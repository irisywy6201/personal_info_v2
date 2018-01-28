<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Input;
use \Lang;
use \Redirect;
use \Session;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\ContributorPositions;

class ContributorPositionsController extends Controller
{
	private $rules = [
		'positionName' => 'required',
		'EnglishPositionName' => 'required',
		'positionDetail' => 'required',
		'EnglishPositionDetail' => 'required'
	];
	
	public function __construct()
	{
		if (!Auth::check() || !Auth::user()->isAdmin()) {
			return App::abort(401);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$positions = ContributorPositions::all();
		
		return View::make('about.contributorPositionsIndex')
			->with(['positions' => $positions]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Session::has('backToContributorManagementPage')) {
			Session::reflash('backToContributorManagementPage');
		}

		return View::make('about.createContributorPosition');
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
			$newPosition = new ContributorPositions;
			$newPosition->name = Input::get('positionName');
			$newPosition->name_en = Input::get('EnglishPositionName');
			$newPosition->detail = Input::get('positionDetail');
			$newPosition->detail_en = Input::get('EnglishPositionDetail');
			$newPosition->save();

			$response = null;

			if (Session::has('backToContributorManagementPage')) {
				$response = Redirect::to(Session::pull('backToContributorManagementPage'));
			}
			else {
				$response = Redirect::to('contributorPositions');
			}

			return $response->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('about.position')])
				]
			]);
		}
		else {
			if (Session::has('backToContributorManagementPage')) {
				Session::reflash('backToContributorManagementPage');
			}

			return Redirect::back()->withInput()->withErrors($validation)->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('about.position')])
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
		$position = ContributorPositions::find($id);

		if ($position) {
			return View::make('about.editContributorPosition')->with([
				'id' => $position->id,
				'positionName' => $position->name,
				'EnglishPositionName' => $position->name_en,
				'positionDetail' => $position->detail,
				'EnglishPositionDetail' => $position->detail_en
			]);
		}
		else {
			return App::abort(404);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$position = ContributorPositions::find($id);
		$validation = Validator::make(Input::all(), $this->rules);

		if ($position) {
			if ($validation->passes()) {
				$position->update([
					'name' => Input::get('positionName'),
					'name_en' => Input::get('EnglishPositionName'),
					'detail' => Input::get('positionDetail'),
					'detail_en' => Input::get('EnglishPositionDetail')
				]);

				return Redirect::to('contributorPositions')->with([
					'feedback' => [
						'type' => 'success',
						'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('about.position')])
					]
				]);
			}
			else {
				return Redirect::back()->withInput()->withErrors($validation)->with([
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('about.position')])
					]
				]);
			}
		}
		else {
			return App::abort(404);
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
		return App::abort(404);
	}

	/**
	 * Route used for create a new contributor position and
	 * then return to the previous contributor creation or
	 * editing page.
	 *
	 * @return Response
	 */
	public function createAndReturn()
	{
		switch (Input::get('backToContributorManagementPage')) {
			case 'create':
				Session::flash('backToContributorManagementPage', URL::to('about/create'));
				return $this->create();
			case 'edit':
				if (Input::has('n')) {
					Session::flash('backToContributorManagementPage', URL::to('about/' . Input::get('n') . '/edit'));
					return $this->create();
				}
				else {
					return App::abort(404);
				}
			default:
				return App::abort(404);
		}
	}
}