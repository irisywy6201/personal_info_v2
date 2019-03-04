<?php

namespace App\Http\Controllers;

use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \App\Entities\SystemProblem;

class systemProblemController extends Controller
{
	public function index()
	{
		return View::make('systemProblem/systemProblem');
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
	public function store()
	{
		$validationResult = Validator::make(Input::all(), [
			'sysProblem' => 'required',
			'email' => 'email',
			'g-recaptcha-response' => 'required|recaptcha'
		]);

		if ($validationResult->passes()) {
			try {
				$sysProblem 	= Input::get("sysProblem");
				// trim 去掉 email 的前後空白
				$email 		= trim(Input::get('email'));

				if($email == null) {
					echo 'no email<br>';
				}
				else {
					echo 'have email: '.$email.'<br>';
				}

				$sysProb 			= new SystemProblem();
				$sysProb->content 	= $sysProblem;
				$sysProb->email 	= $email;
				$sysProb->save();

				return Redirect::to('sysProbDone');
			} 
			catch (Exception $e) {
				return Redirect::to('forgetPassMailSent')
					->withInput()
						->with(array(
							'serverError'	=> '伺服器錯誤或是網路問題',
							));
			}
		}
		else {
			return Redirect::back()->withErrors($validationResult)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('systemProblem/systemProblem.validationFailed')
				]
			]);
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
		return App::abort(404);

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return App::abort(404);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return App::abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return App::abort(404);
	}

	/**********************************
		submit 及 server 再次驗證
	***********************************/
	public function validationInside()
	{
		$inputData 	= Input::all();
		$rules 		= [];

		$aaa = 'begin';
		/************************************
			email 不一定會輸入
		*************************************/
		if(Input::has('email')) {
			$rules = [
				'email' => [
					'email' // 符合 email 格式
				],
				'sysProblem' => [
					'required' // 不能空白
				]
			];

			$aaa = 'hasEmail';
		}
		else {
			$rules = [
				'sysProblem' => [
					'required' // 不能空白
				]
			];

			$aaa = 'sysProblem: ' . Input::get('sysProblem');
		}

		$validator = Validator::make($inputData, $rules);

		if ($validator->fails()) {
			$returnData = [
				'test'		=> $aaa,
				'status' 	=> 'fail',
				'error'		=> $validator->getMessageBag()->toArray()
			];

			return json_encode($returnData);

		}
		else {
			$returnData = [
				'test'		=> $aaa,
				'status' 	=> 'pass',
			];

			return json_encode($returnData);
		}
	}

	/**********************************
		即時驗證
	***********************************/
	public function validation()
	{
		$inputData = Input::all();
		$rules = [];

		if(Input::has('email')) {
			$rules = ['email' => 'email'];
		}

		$validator = Validator::make($inputData, $rules);

		if ($validator->fails()) {
			$returnData = [
				'status' => 'fail',
				'error' => $validator->getMessageBag()->toArray()
			];

			return json_encode($returnData);

		}
		else {
			$returnData = [
				'status' => 'pass'
			];

			return json_encode($returnData);
		}
	}
}

?>