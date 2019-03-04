<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use \App;
use \Auth;
use \Input;
use \Lang;
use \Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Input::hasFile("file0")) {
			$destinationPath = "upload/";

			$file = Input::all();
			$userStudentIDNum = Auth::user()->acct;
			$returnMsg = array();

			foreach ($file as $value)
			{
				$datetime = new DateTime('now');
				$datetime = $datetime->format("Y-m-d(h:i:s)");

				$randomNum = rand(1, 100);
			
				$originFileName = $value->getClientOriginalName();
				$extension = $value->getClientOriginalExtension();
				$newName = $userStudentIDNum . '_' . $datetime . '_' . $randomNum . '_' . $originFileName;

				$value->move($destinationPath, $newName);

				array_push($returnMsg, '/' . $destinationPath . $newName);
			}

			return Response::json($returnMsg);
		}
		else
		{
			return App::abort(404);
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

	public function getPhotoViewerText()
	{
		return json_encode(Lang::get('photoViewer'));
	}
}
