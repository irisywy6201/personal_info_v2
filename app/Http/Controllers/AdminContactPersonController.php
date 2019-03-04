<?php

namespace App\Http\Controllers;

use \AppConfig;
use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\ContactPersonPosition;
use App\Entities\ContactPersonRoles;
use App\Entities\User;

class AdminContactPersonController extends Controller
{
	private $rules = [
		'acct' => 'required',
		'role' => 'required',
		'category' => 'required',
		'g-recaptcha-response' => 'required|recaptcha',
	];
		private $updatedRules = [
		'user' => 'required',
		'role' => 'required',
		'g-recaptcha-response' => 'required|recaptcha',
	];


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$category = Category::topLevelCategories()->lists('id')->all();
		$contactPerson = [];

		if ($category) {
			$contactPerson = ContactPersonPosition::whereIn('category_id', $category)->orderBy('category_id', 'asc')->get();
		}
		
		return View::make('admin.ContactPerson.adminContactPerson',[
			'title'=> Lang::get('Admin/ContactPerson.manageContactPerson'),
			'contactPerson' => $contactPerson,
			'parent' => '0'
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$limitsRole = AppConfig::$roleMap;
		$contactPerson = ContactPersonPosition::all();
		$user = User::whereIn('addRole',[$limitsRole['ROLE_SYSUSER'],$limitsRole['ROLE_ADMIN']])->get();
		return View::make('admin.ContactPerson.adminCreateContactPerson',[
			'title'=> Lang::get('Admin/ContactPerson.createContactPerson'),
			'contactPerson' => $contactPerson,
			'user' => $user,
			'roleMap' => ContactPersonRoles::lists('id')->all()
		]);
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
			$acct = Input::get('acct');
			
			if(!User::where('acct',$acct)->count())
			{
				// return View::make('admin.adminErrorMessage',array(
				// 	'title'=> 'Error',
				// 	'content' => 'No user'
				// ));
				return Redirect::back()->withInput()->with([
					'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('Admin/ContactPerson.noExistsUser')
					]
				]);
			}
			
			$user = User::where('acct',$acct)->first(); 
			$category = Category::find(Input::get('category'));
			$contactPersonCount = ContactPersonPosition::where('category_id',Input::get('category'))->count();
			if(!$user->registered) {
				return Redirect::back()->withInput()->with([
					'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('Admin/ContactPerson.contactPersonWithoutEmail')
					]
				]);
			} 

			if($category->parent_id == 0 && $contactPersonCount >= 1) {
				return Redirect::back()->withInput()->with([
					'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('Admin/ContactPerson.ExistsUnitManager')

					]
				]);
			}
			else if($contactPersonCount >= 2) {
				return Redirect::back()->withInput()->with([
					'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('Admin/ContactPerson.ExistsTwoContactPerson')
					]
				]);
			}

			$contactPerson = new ContactPersonPosition();
			$contactPerson->user_id = $user->id;
			$contactPerson->category_id = Input::get('category');
			$contactPerson->contact_person_roles_id = Input::get('role');		
			$contactPerson->save();

		return Redirect::to('admin/contactPerson/')->with([
					'feedback' => [
						'type' =>'success',
						'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
					]
				]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
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
		$contactPerson = ContactPersonPosition::find($id);
		
		return View::make('admin.ContactPerson.adminDetailContactPerson',[
			'title'=> Lang::get('Admin/ContactPerson.DetailContactPerson'),
			'contactPerson' => $contactPerson,
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
		$contactPerson = ContactPersonPosition::find($id);
		$user = User::whereIn('addRole',[AppConfig::ROLE_ADMIN,AppConfig::ROLE_SYSUSER])->get();


		return View::make('admin.ContactPerson.adminEditContactPerson',[
			'title'=> Lang::get('Admin/ContactPerson.editContactPerson'),
			'contactPerson' => $contactPerson,
			'user' => $user,
			'roleMap' => ContactPersonRoles::lists('id')->all()
		]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validation = Validator::make(Input::all(), $this->updatedRules);
			
		if ($validation->passes()) {
			$contactPerson = ContactPersonPosition::find($id);
			$contactPerson->user_id = Input::get('user');

			if($contactPerson->category->parent_id != 0 && Input::get('role') == 1) {
				return Redirect::back()->withInput()->with([
					'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('Admin/ContactPerson.OnlyDepartmentCanSetManager')
					]
				]);
			}
			$contactPerson->contact_person_roles_id = Input::get('role');
			$contactPerson->save();
			return Redirect::to('admin/contactPerson/')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
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
			ContactPersonPosition::destroy($id);
			return Redirect::to('admin/contactPerson');
	}

	/**
	 * Searches the contact person under certain office or unit.
	 *
	 * @return Response.
	 */
	public function search() 
	{

		$contactPerson = ContactPersonPosition::where('category_id', Input::get('category'))
			->orderBy('category_id', 'asc')->get();
		
		return View::make('admin.ContactPerson.adminContactPerson',[
			'title'=> Lang::get('Admin/ContactPerson.manageContactPerson'),
			'contactPerson' => $contactPerson,
			'parent' => Input::get('category')
		]);
	}

}
