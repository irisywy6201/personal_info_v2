<?php

namespace App\Http\Controllers;

use John\ApiGuard\Models\ApiKey;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class APIKeyManagementController extends Controller
{

	private $rules = [
		'boundIP' => 'required|ip',
		'accessLevel' => 'required|integer|min:1'
	];

	public function __construct()
	{
		$this->beforeFilter(function()
		{
			if (!Auth::check() || !Auth::user()->isStaff()) {
				return App::abort(401, Lang::get('apiKeyManagement.unauthorized'));
			}
		});
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$userID = Auth::user()->id;
		$apiKeys = ApiKey::where('user_id', $userID)->where('deleted_at', NULL)->get();

		return View::make('apiKeyManagement.index')->with([
			'apiKeys' => $apiKeys
		]);
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
		$validation = Validator::make(Input::all(), $this->rules);

		if ($validation->passes()) {
			$apiKey = new ApiKey();
			$apiKey->user_id = Auth::user()->id;
			$apiKey->bound_ip = Input::get('boundIP');
			$apiKey->key = $apiKey->generateKey();
			$apiKey->level = Input::get('accessLevel');
			$apiKey->ignore_limits = Input::has('accessRate') ? false : true;
			$apiKey->save();

			return Redirect::to('apiKey')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('apiKeyManagement.key')])
				]
			]);
		}
		else {
			return Redirect::back()->withInput()->withErrors($validation)->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('apiKeyManagement.key')])
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
		$apiKey = ApiKey::find($id);

		if ($apiKey && $apiKey->deleted_at === NULL) {
			return View::make('apiKeyManagement.editApiKey')->with([
				'id' => $apiKey->id,
				'userID' => $apiKey->user_id,
				'boundIP' => $apiKey->bound_ip,
				'key' => $apiKey->key,
				'accessLevel' => $apiKey->level,
				'accessRate' => !$apiKey->ignore_limits
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
		$apiKey = ApiKey::find($id);
		$validation = Validator::make(Input::all(), $this->rules);

		if ($apiKey) {
			if ($validation->passes()) {
				$apiKey->update([
					'bound_ip' => Input::get('boundIP'),
					'level' => Input::get('accessLevel'),
					'ignore_limits' => Input::has('accessRate') ? false : true
				]);

				return Redirect::to('apiKey')->with([
					'feedback' => [
						'type' => 'success',
						'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('apiKeyManagement.key')])
					]
				]);
			}
			else {
				return Redirect::back()->withInput()->withErrors($validation)->with([
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('apiKeyManagement.key')])
					]
				]);
			}
		}
		else {
			return App::abort(404, Lang::get('alerts.updateFailure', ['item' => Lang::get('apiKeyManagement.key')]));
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
		$apiKey = ApiKey::find($id);

		if ($apiKey && $apiKey->deleted_at == NULL) {
			$apiKey->update([
				'deleted_at' => Carbon::now(),
			]);

			return Redirect::to('apiKey')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('apiKeyManagement.key')])
				]
			]);
		}
		else {
			return App::abort(404, Lang::get('alerts.deleteFailure', ['item' => Lang::get('apiKeyManagement.key')]));
		}
	}
}