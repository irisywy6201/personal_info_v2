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

use App\Entities\authsoftIndex;

class authsoftIndexController extends Controller
{
	
	public function index()
	{
		$authsoftindex = authsoftIndex::all();
		return View::make('admin.authsoftIndex.adminauthsoftIndex',[
			'title'=> '管理軟體下載首頁公告',
			'authsoftindex' => $authsoftindex,
		]);
	}
	
	public function create()
	{
		return View::make('admin.authsoftIndex.adminauthsoftIndex')
			->with('title','新增公告');
	}
	
	public function store(Request $request)
	{

			$authsoftindex = new authsoftIndex();
			$authsoftindex->indextitle_zh = $request->indextitle_zh;
			$authsoftindex->indextitle_en = $request->indextitle_en;
			$authsoftindex->indexcontent_zh = $request->indexcontent_zh;
			$authsoftindex->indexcontent_en = $request->indexcontent_en;
			$authsoftindex->save();
		
			return Redirect::to('admin/authsoftIndex')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Readme.index')])
				]
			]);
		}
	
	public function show($id)
	{
		$authsoftindex = authsoftIndex::find($id);
		return View::make('admin.authsoftIndex.adminCreateindex',array(
			'title' => '新增公告',
			'authsoftindex' => $authsoftindex,
		));
	}
	
	public function destroy($id)
	{
		authsoftIndex::destroy($id);

		return Redirect::to('admin/authsoftIndex');
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
		$authsoftindex = authsoftIndex::find($id);

		return View::make('admin.authsoftIndex.adminEditindex',array(
			'authsoftindex' => $authsoftindex,
			'title'=> Lang::get('Admin/Readme.editannouncement'),
			'id' => $id
			));
	}

	public function update($id)
	{
			$authsoftindex = authsoftIndex::find($id);
			$authsoftindex->indextitle_zh = Input::get('indextitle_zh');
			$authsoftindex->indextitle_en = Input::get('indextitle_en');
			$authsoftindex->indexcontent_zh = Input::get('indexcontent_zh');
			$authsoftindex->indexcontent_en = Input::get('indexcontent_en');
			$authsoftindex->save();

			return Redirect::to('admin/authsoftIndex/')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/Readme.index')])
				]
			]);
	}
	

}