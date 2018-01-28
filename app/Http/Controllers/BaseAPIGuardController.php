<?php

namespace App\Http\Controllers;

use John\ApiGuard\Controllers\ApiGuardController;
use John\ApiGuard\Models\ApiKey;

use Illuminate\Http\Request;

use App\Http\Requests;

class BaseAPIGuardController extends ApiGuardController {

	public function __construct()
	{
		parent::__construct();

		$this->beforeFilter(function()
		{
			$validatePassed = $this->validate();

			if (!$validatePassed) {
				return $this->response->errorUnauthorized();
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
		//
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

	private function validate()
	{
		if (!User::find($this->apiKey->user_id)) {
			Log::warning('[John/ApiGuard] No owner of API key "API key id = ' . $this->apiKey->id . '" is found.');

			return false;
		}
		elseif ($this->apiKey->bound_ip != Request::ip()) {
			Log::warning('[John/ApiGuard] The request URL is different from the one which API key "API key id = ' . $this->apiKey->id . '" is bound to.');
			
			return false;
		}
		else {
			return true;
		}
	}
}
