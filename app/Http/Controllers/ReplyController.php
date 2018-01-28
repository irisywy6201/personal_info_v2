<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Crypt;
use \Input;
use \Lang;
use \Redirect;
use \URL;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\Email;
use App\Entities\Question;
use App\Entities\Reply;
use App\Entities\User;

use App\Jobs\SendMail;

class ReplyController extends Controller
{
	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'content' => 'required|regex:/([^(<p>)(<\/p>)(<br>)(&nbsp;)( )])/'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return App::abort(404);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return App::abort(404);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($messageID)
	{
		if (Auth::check()) {
			$messageValidate = $this->messageValidate($messageID);

			if ($messageValidate['passes']) {
				$validation = Validator::make(Input::all(), $this->rules);

				if ($validation->passes()) {
					$this->sendNewReplyMail($messageID);

					$reply = new Reply;
					$reply->question_id = $messageID;
					$reply->user_id = Auth::user()->id;
					$reply->content = Input::get('content');
					$reply->save();

					$question = Question::find($messageID);
					$question->increment('reply');
					$question->isRead = False;
					$question->save();
					app()->make('App\Http\Controllers\BoardController')->callAction('setCheckPoint', [$messageID, $reply->id]);

					return Redirect::back()->with([
						'feedback' => [
							'type' => 'success',
							'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('messageBoard/board.reply')])
						]
					]);
				}
				else {
					return Redirect::back()->withInput()->withErrors($validation)->with([
						'feedback' => [
							'type' => 'danger',
							'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('messageBoard/board.reply')])
						]
					]);
				}
			}
			else {
				return $messageValidate['response']->with([
					'title' => Lang::get('messageBoard/board.newMessageFailure')
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
	 * @param  Integer  $id
	 * @return Response
	 */
	public function show($id)
	{
		return App::abort(404);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Integer  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return App::abort(404);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param Integer $id The ID number of message this reply
	 * belongs to.
	 * @param Integer $id The ID number of reply.
	 * @return Response
	 */
	public function update($messageID, $replyID)
	{
		if (Auth::check()) {
			$replyValidate = $this->replyValidate($messageID, $replyID);

			if ($replyValidate['passes']) {
				$validation = Validator::make(Input::all(), ['content' => $this->rules['content']]);

				if ($validation->passes()) {
					Reply::find($replyID)->update([
						'content' => Input::get('content')
					]);

					return Redirect::back()->with([
						'feedback' => [
							'type' => 'success',
							'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('messageBoard/board.reply')])
						]
					]);
				}
				else {
					return Redirect::back()->withInput()->withErrors($validation)->with([
						'feedback' => [
							'type' => 'danger',
							'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.reply')])
						]
					]);
				}
			}
			else {
				return $replyValidate['response']->with([
					'title' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.reply')]),
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('messageBoard/board.reply')])
					]
				]);
			}
		}
		else {
			return Redirect::guest('login');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Integer $id The ID number of message this reply
	 * belongs to.
	 * @param Integer $id The ID number of reply.
	 * @return Response
	 */
	public function destroy($messageID, $replyID)
	{
		if (Auth::check()) {
			$replyValidate = $this->replyValidate($messageID, $replyID);

			if ($replyValidate['passes']) {
				Reply::find($replyID)->delete();
				Question::find($messageID)->decrement('reply');

				return Redirect::back()->with([
					'feedback' => [
						'type' => 'success',
						'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('messageBoard/board.reply')])
					]
				]);
			}
			else {
				return $replyValidate['response']->with([
					'title' => Lang::get('alerts.deleteFailure', ['item' => Lang::get('messageBoard/board.reply')]),
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.deleteFailure', ['item' => Lang::get('messageBoard/board.reply')])
					]
				]);
			}
		}
		else {
			return Redirect::guest('login');
		}
	}

	/**
	 * Set up and pass requests to EmailController to
	 * send notification e-mail to user who is watching
	 * this message when a new reply leaved on it.
	 *
	 * @param Integer $messageID the ID number of the message which the
	 * new reply message belongs to.
	 */
	private function sendNewReplyMail($messageID)
	{
		// get the message leaver's e-mail address.
		$data = [];

		// configuring post values.
		if ($data = $this->getMailDataForMessageLeaver($messageID)) {
			$this->dispatch(new SendMail($data));
		}

		// Send E-mail to contact person(s).
		if ($data = $this->getMailDataForContactPerson($messageID)) {
			$this->dispatch(new SendMail($data));
		}
	}

	/**
	 * Generate the POST values for calling send method in
	 * EmailController.
	 *
	 * @param Integer $messageID the ID number of the message which the
	 * new reply message belongs to.
	 * @return Array The POST values for message leaver.
	 *
	 */
	private function getMailDataForMessageLeaver($messageID)
	{
		$messageLeaverID = Question::find($messageID)->user_id;
		$user = User::find($messageLeaverID);
		$messageLeaverAcct = $user->acct;
		$messageLeaverEmail = $user->email()->pluck('address');

		$data['receivers'] = $messageLeaverEmail;
		$data['subject'] = Lang::get('email.newReply.messageLeaver.subject');
		$data['mailView'] = 'emails.messageBoard.newReply.newReplyForMessageLeaver';
		$data['mailViewData'] = [
			'content' => Input::get('content'),
			'link' => [
				'linkToSolvePage' => URL::previous() . '/solve/' . Crypt::encrypt($messageLeaverAcct),
				'linkToMessagePage' => URL::previous()
			]
		];

		return $data;
	}

	/**
	 * Generate the POST values for calling send method in
	 * EmailController.
	 *
	 * @param {Integer} messageID the ID number of the message which the
	 * new reply message belongs to.
	 * @return {Array} The POST values for replier. If no contact person
	 * is found, an empty array will be returned.
	 *
	 */
	private function getMailDataForContactPerson($messageID)
	{
		$categoryID = Question::find($messageID)->category_id;
		$contactPersonEmail = $this->getContactPersonEmail($categoryID);
		$data = [];
		
		if ($contactPersonEmail) {
			$data['receivers'] = $contactPersonEmail;
			$data['subject'] = Lang::get('email.newReply.replier.subject');
			$data['mailView'] = 'emails.messageBoard.newReply.newReplyForReplier';
			$data['mailViewData'] = [
				'content' => Input::get('content'),
				'link' => [
					'linkToMessagePage' => URL::previous()
				]
			];
		}

		return $data;
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
	private function getContactPersonEmail($categoryID)
	{
		$contactPerson = Category::find($categoryID)->contactPersonPositions();
		$contactPersonID = [];

		if ($contactPersonID = $contactPerson->contactPerson()->lists('user_id')->all()) {
			return Email::whereIn('user_id', $contactPersonID)->lists('address')->all();
		}
		elseif ($contactPersonID = $contactPerson->manager()->lists('user_id')->all()) {
			return Email::whereIn('user_id', $contactPersonID)->lists('address')->all();
		}
		else {
			$categoryID = Category::getUnit($categoryID)->pluck('id');
			$contactPerson = Category::find($categoryID)->contactPersonPositions();

			if ($contactPersonID = $contactPerson->contactPerson()->lists('user_id')->all()) {
				return Email::whereIn('user_id', $contactPersonID)->lists('address')->all();
			}
			elseif ($contactPersonID = $contactPerson->manager()->lists('user_id')->all()) {
				return Email::whereIn('user_id', $contactPersonID)->lists('address')->all();
			}
			else {
				return [];
			}
		}
	}

	/**
	 * Check the message exists and is not at "solved" status.
	 *
	 * @param {Integer} id The ID number of message.
	 * @return {Boolean} Return true if validation passes,
	 * return false if validation fails.
	 */
	private function messageValidate($id) {
		$result = [];
		$failureResponsePage = View::make('board.messageSettingFailure');

		if (!$this->isMessageExists($id)) {
			$result['passes'] = false;
			$result['response'] = $failureResponsePage->with([
				'content' => Lang::get('messageBoard/board.messageNotExists')
			]);
		}
		elseif ($this->isMessageSolved($id)) {
			$result['passes'] = false;
			$result['response'] = $failureResponsePage->with([
				'content' => Lang::get('messageBoard/board.linkExpired')
			]);
		}
		else {
			$result['passes'] = true;
			$result['response'] = null;
		}

		return $result;
	}

	/**
	 * Check the reply exists, and the message
	 * it belongs to is not at "solved" status.
	 *
	 * @param {Integer} messageID The ID number of message this reply
	 * belongs to.
	 * @param {Integer} replyID The ID number of reply.
	 * @return {Boolean} Return true if validation passes,
	 * return false if validation fails.
	 */
	private function replyValidate($messageID, $replyID) {
		$result = [];
		$failureResponsePage = View::make('board.messageSettingFailure');

		if (!$this->isReplyExists($replyID)) {
			$result['passes'] = false;
			$result['response'] = $failureResponsePage->with([
				'content' => Lang::get('messageBoard/board.replyNotExists')
			]);
		}
		elseif ($this->isMessageSolved($messageID)) {
			$result['passes'] = false;
			$result['response'] = $failureResponsePage->with([
				'content' => Lang::get('messageBoard/board.linkExpired')
			]);
		}
		else {
			$result['passes'] = true;
			$result['response'] = null;
		}

		return $result;
	}

	/**
	 * Check if message exists in database.
	 *
	 * @param {Integer} id The ID number of message.
	 * @return {Boolean} Return true if message exists,
	 * return false otherwise.
	 */
	private function isMessageExists($id) {
		if (Question::find($id)) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Check if message is solved or not.
	 *
	 * @param {Integer} id The ID number of message.
	 * @return {Boolean} Return true if message is solved,
	 * return false otherwise.
	 */
	private function isMessageSolved($id) {
		$status = Question::find($id)->status;
		
		if (!is_null($status) && $status > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Check if reply exists in database.
	 *
	 * @param {Integer} id The ID number of reply.
	 * @return {Boolean} Return true if reply exists,
	 * return false otherwise.
	 */
	private function isReplyExists($id) {
		if (Reply::find($id)) {
			return true;
		}
		else {
			return false;
		}
	}
}
