<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Crypt;
use \Input;
use \Lang;
use \Queue;
use \Redirect;
use \SearchEngine;
use \URL;
use \Validator;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\Email;
use App\Entities\Question;
use App\Entities\User;

use App\Jobs\SendMail;

use App\Jobs\BoardNotifier;

class BoardController extends Controller {
	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'title' => 'required',
		'department' => 'required',
		'category' => 'required|exists:category,id',
		'identity' => 'required',
		'content' => 'required|regex:/([^(<p>)(<\/p>)(<br>)(&nbsp;)( )])/'
	];
	private $validateFailureMessages = [];
	private $messageStatuses = [];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->validateFailureMessages = [
			'edit' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.message')]),
			'update' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.message')]),
			'destroy' => Lang::get('alerts.deleteFailure', ['item' => Lang::get('messageBoard/board.message')]),
			'solve' => Lang::get('messageBoard/board.setSolvedFailure')
		];

		$this->messageStatuses = [
			'no-status' => Question::STATUS_NO_STATUS,
			'unsolved' => Question::STATUS_UNSOLVED,
			'solved' => Question::STATUS_SOLVED,
			'auto-solved' => Question::STATUS_AUTO_SOLVED
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$department = Category::topLevelCategories()->notHidden()->get();
		$messages = Question::orderBy('status','asc')
			->orderBy('id', 'desc')->paginate(10);

		foreach ($messages as $key => $value) {
			$messages[$key]['userName'] = User::find($value['user_id'])->getPresentName();
		}

		return View::make('board.msgBoard', [
			'department' => $department,
			'statuses' => $this->messageStatuses,
			'messages' => $messages
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check()) {
			$category = Category::getSubCategory('1')->notHidden()->get();
			$identity = Lang::get('identity');
			$department = Category::getSubCategory('0')->notHidden()->get();

			return View::make('board.create', [
				'category' => $category,
				'identity' => $identity,
				'department' => $department
			]);
		}
		else {
			return Redirect::guest('login');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::check()) {
			$validation = Validator::make(Input::all(), $this->rules);

			if ($validation->passes()) {
				$message = new Question;
				$message->title = Input::get('title');
				$message->identity = Input::get('identity');
				$message->status = Question::STATUS_UNSOLVED;
				$message->department = Input::get('department');
				$message->category_id = Input::get('category');
				$message->user_id = Auth::user()->id;

				if(Input::has('isSticky')) {
					$message->isHidden = true;
				}

				$message->content = Input::get('content');
				$message->save();

				$this->sendNewMessageMail($message->id);

				$this->setCheckPoint($message->id, $this->getLastReplyID($message->id));

				return Redirect::to('msg_board/' . $message->id)->with([
					'feedback' => [
						'type' =>'success',
						'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('messageBoard/board.message')])
					]
				]);
			}
			else {
				return Redirect::back()->withErrors($validation)->withInput()->with([
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('messageBoard/board.message')])
					]
				]);
			}
		}
		else {
			return Redirect::guest('login');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (!$this->isMessageExists($id)) {
			return App::abort(404);
		}
		else {
			$message = Question::find($id);
			$reply = Question::find($id)->replies()->orderBy('id', 'DESC')->get();

			// Add count
			$message->increment('count','1');

			//check user read this question
			if(Auth::check() && Auth::user()->acct == $message->user->acct) {
				$message->isRead = true;
				$message->save();
			}

			$unitID = Category::getUnit($message->category_id)->pluck('id');
			$message['acct'] = $this->getUserPresentName($message['user_id'], $unitID, $message->isHidden);

			foreach ($reply as $key => $value) {
				$reply[$key]['acct'] = $this->getUserPresentName($value->user_id, $unitID, $message->isHidden);
			}

			return View::make('board.detail', [
				'message' => $message,
				'reply' => $reply,
				'id' => $id,
				'department' => Category::topLevelCategories()->notHidden(),
				'statuses' => $this->messageStatuses
			]);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::check()) {
			$validation = $this->validation($id, 'edit');

			if ($validation['passes']) {
				$originValues = Question::find($id);
				$department = Category::getSubCategory('0')->notHidden()->get();
				$category = Category::getSubCategory($originValues->department)->notHidden()->get();
				$identity = Lang::get('identity');

				return View::make('board.edit', [
					'originValues' => $originValues,
					'category' => $category,
					'department' => $department,
					'identity' => $identity,
					'id' => $id
				]);
			}
			else {
				return $validation['response'];
			}
		}
		else {
			return Redirect::guest('login');
		}
	}

	/** changechange
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::check()) {
			$validation = $this->validation($id, 'update');

			if ($validation['passes']) {
				$validation = Validator::make(Input::all(), $this->rules);

				if ($validation->passes()) {
					$isHidden = false;

					if(Input::has('isHidden')) {
						$isHidden = true;
					}

					$question = Question::find($id);
					$category = Category::find(Input::get('category'));

					$question->update([
						'identity' => Input::get('identity'),
						'title' => Input::get('title'),
						'content' => Input::get('content'),
						'isHidden' => $isHidden,
						'updated_at' => Carbon::now()
					]);

					$question->category()->associate($category)->save();

					return Redirect::to('msg_board/' . $id)->with([
						'feedback' => [
							'type' => 'success',
							'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('messageBoard/board.message')])
						]
					]);
				}
				else {
					return Redirect::back()->withErrors($validation)->withInput()->with([
						'feedback' => [
							'type' => 'danger',
							'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.message')])
						]
					]);
				}
			}
			else {
				return $validation['response'];
			}
		}
		else {
			return Redirect::guest('login');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::check()) {
			$validation = $this->validation($id, 'destroy');

			if ($validation['passes']) {
				$message = Question::find($id);
				$message->replies()->delete();
				$message->delete();

				return Redirect::to('/msg_board')->with([
					'feedback' => [
						'type' => 'success',
						'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('messageBoard/board.message')])
					]
				]);
			}
			else {
				return $validation['response'];
			}
		}
		else {
			return Redirect::guest('login');
		}
	}

	/**
	 * search contorller.
	 *
	 * @return Response
	 */
	public function realTimeSearch()
	{
		if (Input::has('keyword')) {
			$result = SearchEngine::search(Input::get('keyword'), 'question', ['title', 'content']);
			$result = Question::whereIn('id', $result->lists('id'));

			if (Input::has('department') &&
				Input::has('category') &&
				Category::find(Input::get('category'))) {
				$result = $result->where('category_id', Input::get('category'));
			}

			if (Input::has('status')) {
				$result = $result->choiceStatus(Input::get('status'));
			}

			$result = $result->get(['id', 'title', 'content']);

			return View::make('board.realTimeSearchResult')->with(['results' => $result]);
		}
	}

	/** ===================== to be enhanced =======================
	 * Set status of specific message to "solved".
	 *
	 * @param int id The ID number of the message.
	 * @param string encryptedAcct The encrypted student ID number.
	 * @return Response
	 */
	public function solve($id, $encryptedAcct)
	{
		$acct = Crypt::decrypt($encryptedAcct);
		$userID = User::where('acct', $acct)->pluck('id');

		$validation = $this->validation($id, 'solve');

		if ($validation['passes']) {
			Question::where('id', $id)->where('user_id', $userID)->update([
				'status' => Question::STATUS_SOLVED
			]);

			return $this->show($id)->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('messageBoard/board.setSolvedSuccess')
				]
			]);
		}
		else {
			return $validation['response'];
		}
	}

	/**
	 * Show messages leaved by a specific user.
	 *
	 * @return Response.
	 */
	public function userQuestion()
	{
		$messages = Question::searchCategory(Input::get('category'))
			->status(Input::get('status'))
			->keySearch(Input::get('keyword'))
			->user()
			->orderBy('status','ASC')
			->orderBy('updated_at','DESC')
			->paginate();

		foreach ($messages as $key => $value) {
			$messages[$key]['acct'] = User::find($value['user_id'])->acct;
		}

		$department = Category::getSubCategory('0')->notHidden()->get();

		return View::make('board.msgBoard', [
			'department' => $department,
			'statuses' => $this->messageStatuses,
			'messages' => $messages
		]);

	}

	/**
	 * Send notification e-mail to administrator when there
	 * is not a single reply by administrator or system user
	 * for too long.
	 *
	 * @param Integer messageID The ID number of the not
	 * replied message.
	 * @param Integer replyID The ID number of the last
	 * reply.
	 */
	public function setCheckPoint($messageID, $replyID)
	{
		$categoryID = Question::find($messageID)->category_id;
		$contactPerson = $this->getContactPersonEmail($categoryID);
		$unitManager = $this->getUnitManagerEmail($categoryID);

		// 3 days notify contact person first.
		Queue::later(Carbon::now()->addDays(3), new BoardNotifier([
			'messageID' => $messageID,
			'replyID' => $replyID,
			'days' => 3,
			'daysToCheckAgain' => 0,
			'receivers' => $contactPerson
		]));

		/* ======== 7 days notify unit manager and contact person. ======== */
		// Notify contact person each day.
		Queue::later(Carbon::now()->addDays(7), new BoardNotifier([
			'messageID' => $messageID,
			'replyID' => $replyID,
			'days' => 7,
			'daysToCheckAgain' => 1,
			'receivers' => $contactPerson
		]));

		// Notify contact person every 7 days passes.
		Queue::later(Carbon::now()->addDays(7), new BoardNotifier([
			'messageID' => $messageID,
			'replyID' => $replyID,
			'days' => 7,
			'daysToCheckAgain' => 7,
			'receivers' => $unitManager
		]));
		/* ================================================================ */
	}

	/**
	 * Get the E-mail address of contact person(s) who is
	 * response of the specified category.
	 *
	 * @param Integer $categoryID The ID number of category.
	 * @return Array Returns all contact persons' E-mail addresses.
	 * - If no one is response of the given category, the unit
	 * contact person's E-mail address will be given.
	 * - If there's not a single match of the contact person, an
	 * empty array will be returned.
	 */
	public function getContactPersonEmail($categoryID)
	{
		$contactPersonID = Category::find($categoryID)->contactPersonPositions()->contactPerson()->lists('user_id')->all();
		$managerID = Category::find($categoryID)->contactPersonPositions()->manager()->lists('user_id')->all();

		if ($contactPersonID) {
			return Email::whereIn('user_id', $contactPersonID)->lists('address')->all();
		}
		elseif ($managerID) {
			return Email::whereIn('user_id', $managerID)->lists('address')->all();
		}
		else {
			$categoryID = Category::getUnit($categoryID)->pluck('id');

			return $this->getContactPersonEmail($categoryID);
		}
	}

	/**
	 * Get the E-mail address of unit managers who are
	 * the top level manager of the given category.
	 *
	 * @param Integer $categoryID The ID number of category.
	 * @return Array Returns all managers' E-mail addresses.
	 * - If no one is response of the given category, the unit
	 * contact person's E-mail address will be given.
	 * - If there's not a single match of the contact person, an
	 * empty array will be returned.
	 */
	private function getUnitManagerEmail($categoryID)
	{
		$unitID = Category::getUnit($categoryID)->pluck('id');
		$managerID = [];

		if ($managerID = Category::find($unitID)->contactPersonPositions()
			->manager()->lists('user_id')->all()) {
			return Email::whereIn('user_id', $managerID)->lists('address')->all();
		}
		else {
			return [];
		}
	}

	/**
	 * Check if the check point is out of date or not.
	 *
	 * @param Integer messageID The ID number of the message.
	 * @param Integer replyID The ID number of the reply which
	 * fires this check point.
	 * @return Returns True if the check point is not out of date,
	 * returns False otherwise.
	 */
	/*
	private function isCheckPointOutOfDate($messageID, $replyID)
	{
		if ($replyID == $this->getLastReplyID($messageID)) {
			return false;
		}
		else {
			return true;
		}
	}
	*/

	/**
	 * Send an E-mail to contact person when
	 * a new message is leaved.
	 *
	 * @param Integer $id the ID number of the message.
	 */
	private function sendNewMessageMail($id)
	{
		$receivers = $this->getContactPersonEmail(Question::find($id)->category()->pluck('id'));

		if ($receivers) {
			$data['receivers'] = $receivers;
			$data['subject'] = Lang::get('email.newMessage.subject');
			$data['mailView'] = 'emails.messageBoard.newMessage.newMessage';
			$data['mailViewData'] = [
				'link' => URL::to('msg_board/' . $id)
			];

			$this->dispatch(new SendMail($data));
		}
	}

	private function validation($id, $method)
	{
		$result = [];
		$parameters = [
			'title' => $this->validateFailureMessages[$method],
			'content' => null
		];
		$feedback = [
			'type' => 'danger',
			'message' => $this->validateFailureMessages[$method]
		];

		if (!$this->isMessageExists($id)) {
			$result['passes'] = false;
			$result['response'] = App::abort(404, $this->validateFailureMessages[$method]);
		}
		elseif ($this->isMessageSolved($id)) {
			$result['passes'] = false;
			$parameters['content'] = Lang::get('messageBoard/board.linkExpired');
			$result['response'] = View::make('errors.error')
				->with($parameters)->with(['feedback' => $feedback]);
		}
		else {
			$result['passes'] = true;
			$result['response'] = null;
		}

		return $result;
	}

	/**
	 * Check if the message exists or not.
	 *
	 * @param Integer id The ID number of the message.
	 * @return Return True if message exists, return False
	 * otherwise.
	 */
	private function isMessageExists($id)
	{
		if (Question::find($id)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Check if the message is solved or not.
	 *
	 * @param Integer id The ID number of the message.
	 * @return Boolean Return True if the message is solved,
	 * return False if the message does not exist or the message
	 * is not solved.
	 */
	private function isMessageSolved($id)
	{
		$status = Question::find($id)->status;

		if ($status == Question::STATUS_SOLVED || $status == Question::STATUS_AUTO_SOLVED) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Retrieve the last replier, and return it as a User object.
	 *
	 * @param Integer id The ID number of the message.
	 * @return User Return the last replier as a User object, if
	 * the message does not exist, return Null.
	 */
	/*
	private function getLastReplierID($id) {
		return $lastReplierID = Question::find($id)->replies()
			->orderBy('created_at', 'desc')
			->pluck('user_id');
	}
	*/

	/**
	 * Retrieve the ID number of the last reply.
	 *
	 * @param Integer id The ID number of the message.
	 * @return Integer Returns the ID number of the last reply,
	 * if the message does not exits, return Null.
	 */
	private function getLastReplyID($id) {
		return Question::find($id)->replies()
			->orderBy('created_at', 'desc')
			->pluck('id');
	}

	/**
	 * Get the form of user's name which should be presented to
	 * other users.
	 *
	 * @param int $userID The ID number of replier.
	 * @param int $unitID The ID number of current unit.
	 * @param int $isHidden This message or reply is set to be
	 * hidden or not.
	 * @return string Returns the present name of user.
	 */
	private function getUserPresentName($userID, $unitID, $isHidden)
	{
		if (Auth::check()) {
			if (Auth::user()->id == $userID) {
				return Auth::user()->acct;
			}
			elseif (User::find($userID)->isStaff()) {
				return Lang::get('category.' . $unitID . '.name') . Lang::get('messageBoard/board.customerService');
			}
			elseif ($isHidden) {
				return Lang::get('messageBoard/board.userHidden');
			}
			else {
				return User::find($userID)->acct;
			}
		}
		else {
			if (User::find($userID)->isStaff()) {
				return Lang::get('category.' . $unitID . '.name') . Lang::get('messageBoard/board.customerService');
			}
			elseif ($isHidden) {
				return Lang::get('messageBoard/board.userHidden');
			}
			else {
				return User::find($userID)->acct;
			}
		}
	}
}
