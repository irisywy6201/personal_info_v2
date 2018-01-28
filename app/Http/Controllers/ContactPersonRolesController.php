<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactPersonRolesController extends Controller
{
	private $rules = [
		'nameZhTW' => 'required',
		'nameEn' => 'required',
		'descriptionZhTW' => 'required',
		'descriptionEn' => 'required'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = ContactPersonRoles::paginate(10);

		return View::make('admin.contactPersonRoles.index')->with([
			'roles' => $roles
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.contactPersonRoles.createContactPersonRole');
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
			$newRole = new ContactPersonRoles();
			$newRole->name_zh_TW = Input::get('nameZhTW');
			$newRole->name_en = Input::get('nameEn');
			$newRole->description_zh_TW = Input::get('descriptionZhTW');
			$newRole->description_en = Input::get('descriptionEn');
			$newRole->save();

			return Redirect::to('admin/contactPersonRoles')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('contactPersonRoles.role')])
				]
			]);
		}
		else {
			return Redirect::back()->withInput()->withErrors($validation)->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('contactPersonRoles.role')])
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
		$role = ContactPersonRoles::find($id);
		
		return View::make('admin.contactPersonRoles.editContactPersonRole')->with([
			'id' => $role->id,
			'nameZhTW' => $role->name_zh_TW,
			'nameEn' => $role->name_en,
			'descriptionZhTW' => $role->description_zh_TW,
			'descriptionEn' => $role->description_en
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
		$validation = Validator::make(Input::all(), $this->rules);

		if ($validation->passes()) {
			$role = ContactPersonRoles::find($id);

			if ($role) {
				$role->update([
					'name_zh_TW' => Input::get('nameZhTW'),
					'name_en' => Input::get('nameEn'),
					'description_zh_TW' => Input::get('descriptionZhTW'),
					'description_en' => Input::get('descriptionEn')
				]);

				return Redirect::to('admin/contactPersonRoles')->with([
					'feedback' => [
						'type' => 'success',
						'message' => 'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('contactPersonRoles.role')])
					]
				]);
			}
			else {
				return App::abort(404, Lang::get('contactPersonRoles.updateFailure'));
			}
		}
		else {
			return Redirect::back()->withInput()->withErrors($validation)->with([
				'feedback' => [
					'type' => 'danger',
					'message' => 'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('contactPersonRoles.role')])
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
		$role = ContactPersonRoles::find($id);

		if ($role) {
			ContactPersonRoles::find($id)->contactPersonPositions()->update([
				'contact_person_roles_id' => NULL
			]);

			$role->delete();

			return Redirect::to('admin/contactPersonRoles')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('contactPersonRoles.role')])
				]
			]);
		}
		else {
			return App::abort(404, Lang::get('alerts.deleteFailure', ['item' => Lang::get('contactPersonRoles.role')]));
		}
	}
}
