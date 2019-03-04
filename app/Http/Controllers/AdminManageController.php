<?php

namespace App\Http\Controllers;

use \App;
use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\User;
use App\Entities\UserLogs;

class AdminManageController extends Controller
{

	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'acct' => 'required|unique:users,acct',
		'email' => 'required|email'
	];

	private $updateRule = [
		'g-recaptcha-response' => 'required|recaptcha',
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = User::orderby('addrole','desc')->paginate(10);

		 foreach ($user as $key =>$value) {
		 	$user[$key] = User::getUserMaxRole($user[$key]);
		 }


		return View::make('admin.Manage.adminManageUser',array(
			'title'=> Lang::get('Admin/Management.management'),
			'user' => $user
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$roleList = Lang::get('adminRole');
		return View::make('admin.Manage.adminCreateManager',array(
			'title'=> Lang::get('Admin/Management.createUser'),
			'roleList' => $roleList));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = Validator::make(Input::all(), $this->rules);
		if ($validation->passes()) {
			$user = new User;
			$user->acct = Input::get('acct');
			$user->username = Input::get('username');
			$user->role = '0';
			$user->addrole = Input::get('addrole');
			$user->save();

			$link = App::make('App\Http\Controllers\EmailController')->storeUnverifiedEmail(Input::get('acct'), Input::get('email'));
			App::make('App\Http\Controllers\EmailController')->sendVerificationMail(Input::get('email'), $link);

			UserLogs::writeEmailLog(Carbon::now(), Input::get('acct'));

			return Redirect::to('admin/management/')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Management.user')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/Management.user')])
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
		$user = User::find($id);
		$user = User::getUserMaxRole($user);

		return View::make('admin.Manage.adminDetailManager',[
			'title'=> Lang::get('Admin/Management.management'),
			'user' => $user
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
		$user = User::find($id);
		$roleList = Lang::get('adminRole');
		$user = User::getUserMaxRole($user);
		return View::make('admin.Manage.adminEditManager',array(
			'title'=> Lang::get('Admin/Management.modifyUser'),
			'user' => $user,
			'roleList' => $roleList));

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
		$validation = Validator::make(Input::all(), $this->updateRule);

		if ($validation->passes()) {
			$user = User::find($id);
			$user->addrole = Input::get('addrole');
			$user->username = Input::get('username');
			$user->save();
			return Redirect::to('admin/management/'.$id)->with([
								'feedback' => [
									'type' =>'success',
									'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Management.user')])
								]
							]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/Management.user')])
				]
			]);
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
		$user = User::find($id);

		if ($user) {
			$user->email()->delete();
			$user->contactPersonPositions()->delete();
			$user->delete();

			return Redirect::to('admin/management')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('Admin/Management.user')])
				]
			]);
		}
		else {
			return App::abort(404, Lang::get('alerts.deleteFailure', ['item' => Lang::get('Admin/Management.user')]));
		}
	}

	public function search() {
		$keyword = Input::get('keyword');
		$user = User::where('acct', 'LIKE', '%'.$keyword.'%')
					->orWhere('username', 'LIKE', '%'.$keyword.'%')
					->orderby('updated_at','desc')
					->paginate(10);
		foreach ($user as $key =>$value) {
		 	$user[$key] = User::getUserMaxRole($user[$key]);
		}

		return View::make('admin.Manage.adminManageUser',array(
			'title'=> Lang::get('Admin/Management.management'),
			'user' => $user,
			'keyword' => $keyword
			));
	}

}
