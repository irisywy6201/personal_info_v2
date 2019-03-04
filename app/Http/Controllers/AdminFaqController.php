<?php

namespace App\Http\Controllers;

use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\Faq;

class AdminFaqController extends Controller
{
	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'name' => 'required',
		'name_en' => 'required',
		'category' => 'required',
		'answer' => 'required',
		'answer_en' => 'required',

	];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$faq = Faq::orderby('updated_at','desc')->paginate(10);
		$department = Category::getSubCategory("0")->orderBy('order','asc')->get();

		/**
		 * Find parent id 
		 */
		$parent = [];
		foreach($faq->lists('category')->all() as $value) {

			array_push($parent,Category::find($value)['parent_id']);
		}
			
		return View::make('admin.Faq.adminFaq',array(
			'title'=> Lang::get('Admin/Faq.faq'),
			'department' => $department,
			'parent' => $parent,
			'keyword' => '',
			'category' => '0',
			'faq' => $faq
			));

		
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$category = Category::getSubCategory('1')->orderBy('order','asc')->get();
		return View::make('admin.Faq.adminCreateFaq',array(
			'title'=> Lang::get('Admin/Faq.createFaq'),
			'category' => $category
			));
		
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
			$faq = new Faq;
			$faq->name = Input::get('name');
			$faq->name_en = Input::get('name_en');
			$faq->answer = Input::get('answer');
			$faq->answer_en = Input::get('answer_en');
			$faq->category = Input::get('category');
			$faq->save();

		return Redirect::to('admin/faq/')->with([
					'feedback' => [
						'type' =>'success',
						'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Faq.faq')])
					]
				]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/Faq.faq')])
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
		//
		$faq = Faq::find($id);
		return View::make('admin.Faq.adminDetailFaq',array(
			'title'=> Lang::get('Admin/Faq.detailFaq'),
			'faq'=> $faq,
			));
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
		$faq = Faq::find($id);
		return View::make('admin.Faq.adminEditFaq',array(
			'originValue' => $faq,
			'title'=> Lang::get('Admin/Faq.editFaq'),
			'id' => $id
			));
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
		$validation = Validator::make(Input::all(), $this->rules);

		if ($validation->passes()) { 

			$faq = Faq::find($id);
			$faq->name = Input::get('name');
			$faq->name_en = Input::get('name_en');
			$faq->answer = Input::get('answer');
			$faq->answer_en = Input::get('answer_en');
			$faq->category = Input::get('category');
			$faq->save(); 
			return Redirect::to('admin/faq/')->with([
				'feedback' => [
					'type' =>'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/Faq.faq')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/Faq.faq')])
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
		Faq::destroy($id);

		return Redirect::to('admin/faq')->with([
			'feedback' => [
				'type' => 'success',
				'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('Admin/Faq.faq')])
			]
		]);
	}

	public function search() 
	{
		$faq = Faq::category(Input::get('category'))
							->keyword(['title' => Input::get('keyword')])
							->orderby('updated_at','desc')
							->paginate(10);
		/**
		 * Find parent id 
		 */
		$parent = [];
		foreach($faq->lists('category')->all() as $value) {

			array_push($parent,Category::find($value)['parent_id']);
		}
		$department = Category::getSubCategory("0")->get();
		return View::make('admin.Faq.adminFaq',array(
			'title'=> Lang::get('Admin/Faq.faq'),
			'department' => $department,
			'parent' => $parent,
			'category' => Input::get('category'),
			'keyword' => Input::get('keyword'),
			'faq' => $faq
			));
	}

}
