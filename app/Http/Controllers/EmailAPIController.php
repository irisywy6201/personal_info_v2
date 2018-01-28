<?php

namespace App\Http\Controllers;

use \App;
use \AppConfig;
use \Input;
use \Lang;
use \Validator;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\User;
use App\Entities\UserLogs;

class EmailAPIController extends \BaseAPIGuardController {

	private $rules = [
		'acct' => 'required',
		'email' => 'required|email|regex:/.+(?<!@cc.ncu.edu.tw)$/'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$validationResult = Validator::make(Input::all(), $this->rules);

		if ($validationResult->passes()) {
			$acct = Input::get('acct');
			$email = Input::get('email');
			
			if (User::where('acct', $acct)->pluck('registered')) {
				return $this->response->errorGone(Lang::get('admin.hasBeenUsed'));
			}
			else {
				$this->createUser();

				$link = App::make('App\Http\Controllers\EmailController')->storeUnverifiedEmail($acct, $email);
				App::make('App\Http\Controllers\EmailController')->sendVerificationMail($email, $link);
				
				UserLogs::writeEmailLog(Carbon::now(), $acct);

				return $this->response->withArray([
					'acct' => $acct,
					'email' => $email
				]);
			}
		}
		else {
			return $this->response->errorWrongArgs($validationResult->errors()->all());
		}
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
		//
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
		//
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

	/**
	 * Create a new User in database.
	 * This is a helper function of create() function.
	 *
	 * @return int Returns the ID number of created User, if
	 * there's a User who has the same account number as the Input
	 * gives exists in database, the ID number of this User will
	 * be returned.
	 */
	private function createUser()
	{
		$userID;
		$acct = Input::get('acct');
		$email = Input::get('email');
		$username = Input::get('username', NULL);
		$role = Input::get('role', AppConfig::$roleMap['ROLE_USER'] | AppConfig::$roleMap['ROLE_STUDENT']);

		if (!$userID = User::where('acct', $acct)->pluck('id')) {
			$newUser = new User();
			$newUser->acct = $acct;
			$newUser->username = $username;
			$newUser->role = $role;
			$newUser->save();

			return $newUser->id;
		}
		else {
			return $userID;
		}
	}
}
