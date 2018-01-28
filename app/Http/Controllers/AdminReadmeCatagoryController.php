<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Readme;
use App\Entities\ReadmeCatagory;

class AdminReadmeCatagoryController extends Controller
{
	
	public function index()
	{
		$readme = Readme::orderBy('id','asc')->get();
		$readmecatagory = ReadmeCatagory::all();
		return View::make('admin.Readme.adminReadme',array(
			'title'=> Lang::get('Admin/Readme.managereadme'),
			'readme' => $readme,
			'readmecatagory' => $readmecatagory,
		));
		
	}
	
	public function create()
	{
		$readmecatagory = Readmecatagory::all();
		$readme = Readme::all();
		return View::make('admin.Readme.adminCreateReadmeCatagory',array(
			'title'=> Lang::get('Admin/Readme.managereadmecatagory'),
			'readmecatagory' => $readmecatagory,
			'readme' => $readme,
		));
	}
	
	
	public function store(Request $request)
	{

			$readmecatagory = new Readmecatagory();
			$readmecatagory->doccategory_name_zh = $request->doccategory_name_zh;
			$readmecatagory->doccategory_name_en = $request->doccategory_name_en;
			$readmecatagory->doccategory_discribe_zh = $request->doccategory_discribe_zh;
			$readmecatagory->doccategory_discribe_en = $request->doccategory_discribe_en;
			$readmecatagory->save();
		
			return Redirect::to('admin/Readme/catagory')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Readme.readme')])
				]
			]);
			
		}
	
	public function show($id)
	{
		//
	}
	
	public function destroy($id)
	{
		Readmecatagory::destroy($id);
		return Redirect::to('admin/Readme/catagory');
	}
	
	public function edit($id)
	{
		//
		$readmecatagory = Readmecatagory::find($id);
		
		return View::make('admin.Readme.adminEditReadmeCatagory',array(
			'readmecatagory' => $readmecatagory,
			'title'=> Lang::get('Admin/Readme.editreadmeCatagory'),
			'id' => $id,
			));
	}

	public function update($id)
	{
			$readmecatagory = Readmecatagory::find($id);
			$readmecatagory->doccategory_name_zh = Input::get('doccategory_name_zh');
			$readmecatagory->doccategory_name_en = Input::get('doccategory_name_en');
			$readmecatagory->doccategory_discribe_zh = Input::get('doccategory_discribe_zh');
			$readmecatagory->doccategory_discribe_en = Input::get('doccategory_discribe_en');
			$readmecatagory->save();

			return Redirect::to('admin/Readme/catagory')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/Readme.readme')])
				]
			]);
	}
	

}
