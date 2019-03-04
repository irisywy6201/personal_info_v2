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

class AdminCategoryController extends Controller
{
	private $rulesCategory = [
		'g-recaptcha-response' => 'required|recaptcha',
		'href_abb' => 'required',
		'category' => 'required',
		'AddCategory' => 'required',
		'AddCategory_en' => 'required',
		'AddDescribe' => 'required',
		'AddDescribe_en' => 'required',
		'AddDescribe' => 'required',

	];

	private $rulesDepartment = [
		'g-recaptcha-response' => 'required|recaptcha',
		'href_abb' => 'required',
		'AddCategory' => 'required',
		'AddCategory_en' => 'required',
		'AddDescribe' => 'required',
		'AddDescribe_en' => 'required',
		'AddDescribe' => 'required',
	];
	private $ruleUpdate = [
		'g-recaptcha-response' => 'required|recaptcha',
		'category' => 'required',
		'categName' => 'required',
		'categName_en' => 'required',
		'AddDescribe' => 'required',
		'AddDescribe_en' => 'required',
		'href_abb' => 'required'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$category = Category::orderBy('order','asc')->paginate(10);
		return View::make('admin.Category.adminCategory',array(
			'title'=> Lang::get('Admin/Category.manageCategory'),
			'category' => $category,
			'parent' => '0'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.Category.adminCreateCategory',array(
			'title'=> Lang::get('Admin/Category.createCategory'),
		));
	}
	public  function createCategory()
	{
		return View::make('admin.Category.adminCreateCategory',array(
			'title'=> Lang::get('Admin/Category.createCategory'),
		));
	}

	public  function createDepartment()
	{
		return View::make('admin.Category.adminCreateDepartment',array(
			'title'=> Lang::get('Admin/Category.createDepartment'),
		));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = Category::find($id);
		return View::make('admin.Category.adminDetailCategory',array(
			'title' => Lang::get('Admin/Category.detailCategory'),
			'category' => $category
		));
	}

	public function showOrder($parent) {
		$category = Category::getSubCategory($parent)->orderBy('order')->paginate(10);
		return View::make('admin.Category.adminEditOrderCategory',array(
			'title'=> Lang::get('Admin/Category.editOrder'),
			'category' => $category,
			'parent' => $parent
		));
	}
	public function search($parent = null) {


		$title = Lang::get('admin.manageCategory');
		if(Input::has('category')) {
			$categ_parentID = Input::get('category');
		}
		else if($parent != null) {
			$categ_parentID = $parent;
		}

		$category = Category::getSubCategory($categ_parentID)->orderBy('order')->paginate(10);

		return View::make('admin.Category.adminCategory',array(
			'title'=> $title,
			'category' => $category,
			'parent' => $categ_parentID
		));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

	public function storeDepartment() {

		$validation = Validator::make(Input::all(), $this->rulesDepartment);

		if ($validation->passes()) {
			// category order which is start at 0
			//getChildren("0") "0" mean department category
			$count = Category::getSubCategory('0')->count();
			$category = new Category();
			$category->name = Input::get('AddCategory');
			$category->name_en = Input::get('AddCategory_en');
			$category->describe = Input::get('AddDescribe');
			$category->describe_en = Input::get('AddDescribe_en');
			$category->href_abb = Input::get('href_abb');
			$category->layer = 1;
			$category->leaf = 1;

			$category->order = $count ;
			if(Input::has('isHidden')) {
				// if the isHidden checked, set the is_hidden column true
				$category->is_hidden = "1";
			}
			$category->save();

			return Redirect::to('admin/category')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('admin.department')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('admin.department')])
				]
			]);
		}

	}

	public function storeCategory() {

		$validation = Validator::make(Input::all(), $this->rulesCategory);

		if ($validation->passes()) {
			// category order which is start at 0
			$parent = Category::find(Input::get('category'));

			$count = $category = Category::getSubCategory(Input::get('category'))->count();
			$category = new Category();
			$category->name = Input::get('AddCategory');
			$category->name_en = Input::get('AddCategory_en');
			$category->describe = Input::get('AddDescribe');
			$category->describe_en = Input::get('AddDescribe_en');
			$category->href_abb = Input::get('href_abb');
			$category->order = $count;
			$category->parent_id = Input::get('category');
			$category->layer = ($parent->layer)+1;
			$category->leaf = "1";


			if(Input::has('isHidden')) {
				// if the isHidden checked, set the is_hidden column true
				$category->is_hidden = "1";
			}
			else {
				$category->is_hidden = "0";
			}
			$category->save();
			// check the parent leaf
			$parent->leaf = $parent->isLeaf();
			$parent->save();

			return Redirect::to('admin/category')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('admin.category')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('admin.category')])
				]
			]);
		}

	}

	public function storeOrder($parent) {
		if(Input::has('order')){
			$order = explode(',',Input::get('order'));
			$category = Category::getSubCategory($parent)->orderBy('order')->paginate(10);
			foreach ($order as $key => $value) {
				$category[$value]->order = $key;
				$category[$value]->save();
			}
		}

		return Redirect::to('admin/category/search/'.$parent);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$title = Lang::get('admin.editCategory');
		return View::make('admin.Category.adminEditCategory',array(
			'title'=> Lang::get('admin.editCategory'),
			'category' => Category::find($id)
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
		$validation = Validator::make(Input::all(), $this->ruleUpdate);
		if($validation->passes()) {

			if(Input::get('category') > $id) {
				return View::make('admin.adminErrorMessage',[
					'title'=> 'Error',
					'content' => Lang::get('admin.childIDMustBeSmallThanFather')
				]);
			}

			$parent = Category::find(Input::get('category'));
			$category = Category::find($id);
			$category->name = Input::get('categName');
			$category->name_en = Input::get('categName_en');
			$category->describe = Input::get('AddDescribe');
			$category->describe_en = Input::get('AddDescribe_en');
			$category->href_abb = Input::get('href_abb');
			$category->parent_id = Input::get('category');

			if(!is_null(Input::get('isHidden'))) {
				$category->is_hidden = "1";
			}
			else {
				$category->is_hidden = "0";
			}
			$category->leaf = $category->isLeaf();
			$category->save();

			if(!is_null($parent)) {
				//this mean current category isn't department
				$parent->leaf = $parent->isLeaf();
				$parent->save();
			}
			return Redirect::to('admin/category/'.$id)->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('admin.category')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('admin.category')])
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
		if(Category::isHasChildren($id) == '1') {
			Category::destroy($id);

			return Redirect::to('admin/category')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('admin.category')])
				]
			]);
		}
		else {
			return View::make('admin.adminErrorMessage',array(
				'title'=> 'Error',
				'content' => Lang::get('admin.thiCategoryHasChidren'),
			))->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.deleteFailure', ['item' => Lang::get('admin.category')])
				]
			]);
		}
	}
}
