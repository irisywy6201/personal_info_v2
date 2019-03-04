<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Redirect;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\SystemProblem;
use App\Entities\User;

use App\Jobs\SendMail;

class AdminSystemProblemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$sysProblem = SystemProblem::orderBy('isSolved','asc')->get();
		return View::make('admin.systemProblem.adminSystemProblem',[
			'systemProblem' => $sysProblem,
			'title' => Lang::get('Admin/SystemProblem.systemProblem') ]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sysProblem = SystemProblem::find($id);
		return View::make('admin.systemProblem.adminDetailSystemProblem',[
			'systemProblem' => $sysProblem,
			'title' => Lang::get('Admin/SystemProblem.systemProblem'),
			'solver' => User::find($sysProblem->solvedBy)->acct
		]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sysProblem = SystemProblem::find($id);
		$sysProblem->isSolved = true;
		$sysProblem->solvedBy = Auth::user()->id;
		$sysProblem->solvedComment = Input::get('comment');
		$feedback = Input::get('feedback');
		$this->sendFeedBackMail($sysProblem->email,$feedback);
		$sysProblem->save();
		return Redirect::to('admin/systemProblem');;

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
  public function sendFeedBackMail($email, $feedback)
  {

    $data['receivers'] = array($email);
    $data['subject'] = Lang::get('Admin/SystemProblem.feedbackEmailSubject');
    $data['mailView'] = 'emails.systemProblemfeedBack';
    $data['mailViewData'] = ['feedback' => 'testtesttest' ];
    
    $this->dispatch(new SendMail($data));
  }


}
