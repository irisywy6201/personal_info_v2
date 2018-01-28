<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Redirect;
//use \Request;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Readme;
use App\Entities\ReadmeCatagory;

class AdminReadmeController extends Controller
{

	
	public function index()
	{
		$readme = Readme::orderBy('id','asc')->get();
		return View::make('admin.Readme.adminReadme',array(
			
			'readmecatagory' => $readmecatagory,
			'readme' => $readme
		));
	}
	
	public function create()
	{
		$readme = Readme::all();
		$readmecatagory = Readmecatagory::all();
		return View::make('admin.Readme.adminCreateReadme',array(
			'title'=> '新增說明',
			'readmecatagory' => $readmecatagory,
			'readme' => $readme,
		));
	}
	
	public function store(Request $request)
	{

			$readme = new Readme();
			$readme->doccatagory_id = $request->doccatagory_id;
			$readme->title_zh = $request->title_zh;
			$readme->title_en = $request->title_en;
			$readme->Content_zh = $request->Content_zh;
			$readme->Content_en = $request->Content_en;
			$readme->save();
		
			return Redirect::to('admin/Readme/catagory')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Readme.readme')])
				]
			]);
		}
	
	public function show($id)
	{
		$readme = Readme::find($id);
		return View::make('admin.Readme.adminCreateReadme',array(
			'title' => Lang::get('Admin/Readme.readme'),
			'readme' => $readme,
		));
	}
	
	public function destroy($id)
	{
		Readme::destroy($id);
		
		return Redirect::to('admin/Readme/catagory');
	}
	
/*	public function edit(Readme $readme)
	{
		
		return View::make('admin.Readme.adminEditReadme',array(
			'title'=> Lang::get('Admin/Readme.editreadme'),
			'readme' => $readme
			));
	}*/
	
	public function edit($id)
	{
		//
		$readme = Readme::find($id);
		$readmecatagory = Readmecatagory::all();
		return View::make('admin.Readme.adminEditReadme',array(
			'readme' => $readme,
			'readmecatagory' => $readmecatagory,
			'title'=> Lang::get('Admin/Readme.editreadme'),
			'id' => $id
			));
	}

	public function update($id)
	{
			$readme = Readme::find($id);
			$readme->doccatagory_id = Input::get('doccatagory_id');
			$readme->title_zh = Input::get('title_zh');
			$readme->title_en = Input::get('title_en');
			$readme->Content_zh = Input::get('Content_zh');
			$readme->Content_en = Input::get('Content_en');
			$readme->save();

			return Redirect::to('admin/Readme/catagory')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/Readme.readme')])
				]
			]);
	}
	

}