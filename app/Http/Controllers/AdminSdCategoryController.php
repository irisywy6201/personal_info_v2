<?php

namespace App\Http\Controllers;

use \Auth;
use \View;
use \Lang;
use \Redirect;
use \Input;
use \Validator;
use Carbon\Carbon;
use \Route;
use Session;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\SolutionCategory;
use App\Entities\SdRecCategory;
use App\Entities\SdRecUserCategory;

class AdminSdCategoryController extends Controller
{

    private $categoryRule = [
      'category' => 'required',
    ];
    private $userRule = [
      'user_category' => 'required',
    ];
    private $solutionRule = [
      'solution' => 'required',
    ];
    private $categoryRuleUpdate = [
      'updateCategory' => 'required',
    ];
    private $userRuleUpdate = [
      'updateUserCategory' => 'required',
    ];
    private $solutionRuleUpdate = [
      'updateSolCategory' => 'required',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('visibility-toggle') && !Session::get('visibility-toggle')) {
          $category = SdRecCategory::getSubCategory(1)->getVisibility(1)->get();
          $department = SdRecCategory::getSubCategory(0)->getVisibility(1)->get();
          $user_category = SdRecUserCategory::getVisibility(1)->get();
          $solutionCategory = SolutionCategory::getVisibility(1)->get();
        }
        else {
          $category = SdRecCategory::getSubCategory(1)->get();
          $department = SdRecCategory::getSubCategory(0)->get();
          $user_category = SdRecUserCategory::get();
          $solutionCategory = SolutionCategory::get();
        }
        return View::make('admin.SdCategory.adminSdCategory',[
          'title' => Lang::get('Admin/SdCategory.manageSdCategory'),
          'category' => $category,
          'department' => $department,
          'user_category' => $user_category,
          'solutionCategory' => $solutionCategory,
          'tab' => 'category',
        ]);
    }

    /**
     *
     * Control visibility toggle
     *
     */
    public function visibleToggle($status,$id) {
      if($status == 'on') {
        Session::put('visibility-toggle',true);
      }
      elseif($status == 'off') {
        Session::put('visibility-toggle',false);
      }

      if($id == 1) {
        $tab = 'category';
      }
      elseif($id == 2) {
        $tab = 'userCategory';
      }
      elseif ($id == 3) {
        $tab = 'solutionCategory';
      }
      return redirect('admin/sdCategory')->with([
        'tab' => $tab,
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCategory() {
      if(Auth::check()) {
        $validation = Validator::make(Input::all(), $this->categoryRule);
        if($validation->passes()) {
          $category = new SdRecCategory;
          $category->name = Input::get('category');
          $category->parent_id = 1;
          $category->visible = 1;
          $category->save();

          $feedback = [
              'type' => 'success',
              'message' => Lang::get('Admin/SdCategory.createSuccessfully'),
          ];
          $tab = 'category';
          return redirect('admin/sdCategory')->with([
            'feedback' => $feedback,
            'tab' => $tab
          ]);
        }
        else {
          return Redirect::back()->withErrors($validation)->withInput()->with([
  					'feedback' => [
  						'type' => 'danger',
  						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/SdCategory.sdCategory')]),
  					]
  				]);
        }
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function saveUserCategory() {
      if(Auth::check()) {
        $validation = Validator::make(Input::all(), $this->userRule);
        if($validation->passes()) {
          $user = new SdRecUserCategory;
          $user->user = Input::get('user_category');
          $user->visible = 1;
          $user->save();

          $feedback = [
              'type' => 'success',
              'message' => Lang::get('Admin/SdCategory.createSuccessfully'),
          ];
          $tab = 'userCategory';
          return redirect('admin/sdCategory')->with([
            'feedback' => $feedback,
            'tab' => $tab
          ]);
        }
        else {
          return Redirect::back()->withErrors($validation)->withInput()->with([
  					'feedback' => [
  						'type' => 'danger',
  						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/SdCategory.userCategory')]),
  					]
  				]);
        }
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function saveSolCategory() {
      if(Auth::check()) {
        $validation = Validator::make(Input::all(), $this->solutionRule);
        if($validation->passes()) {
          $solution = new SolutionCategory;
          $solution->method = Input::get('solution');
          $solution->visible = 1;
          $solution->save();

          $feedback = [
              'type' => 'success',
              'message' => Lang::get('Admin/SdCategory.createSuccessfully'),
          ];
          $tab = 'solutionCategory';
          return redirect('admin/sdCategory')->with([
            'feedback' => $feedback,
            'tab' => $tab
          ]);
        }
        else {
          return Redirect::back()->withErrors($validation)->withInput()->with([
  					'feedback' => [
  						'type' => 'danger',
  						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/SdCategory.solutionCategory')]),
  					]
  				]);
        }
      }
      else {
        return Redirect::guest('login');
      }
    }

    /**
     *
     *Update specific category
     *
     */
     public function updateCategory(Request $request, $id) {
       if(Auth::check()) {
         $validation = Validator::make(Input::all(), $this->categoryRuleUpdate);
         if($validation->passes()) {
           $category = SdRecCategory::where('id', $id)->first();
           $category->name = Input::get('updateCategory');
           $category->update();

           $feedback = [
               'type' => 'success',
               'message' => Lang::get('Admin/SdCategory.updateSuccessfully'),
           ];
           $tab = 'category';
           return redirect('admin/sdCategory')->with([
             'feedback' => $feedback,
             'tab' => $tab
           ]);
         }
         else {
           return Redirect::back()->withErrors($validation)->withInput()->with([
   					'feedback' => [
   						'type' => 'danger',
   						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/SdCategory.sdCategory')]),
   					]
   				]);
         }
       }
       else {
         return Redirect::guest('login');
       }
     }
     public function updateUserCategory(Request $request, $id) {
       if(Auth::check()) {
         $validation = Validator::make(Input::all(), $this->userRuleUpdate);
         if($validation->passes()) {
           $user = SdRecUserCategory::where('id', $id)->first();
           $user->user = Input::get('updateUserCategory');
           $user->update();

           $feedback = [
               'type' => 'success',
               'message' => Lang::get('Admin/SdCategory.updateSuccessfully'),
           ];
           $tab = 'userCategory';
           return redirect('admin/sdCategory')->with([
             'feedback' => $feedback,
             'tab' => $tab
           ]);
         }
         else {
           return Redirect::back()->withErrors($validation)->withInput()->with([
   					'feedback' => [
   						'type' => 'danger',
   						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/SdCategory.userCategory')]),
   					]
   				]);
         }
       }
       else {
         return Redirect::guest('login');
       }
     }
     public function updateSolCategory(Request $request, $id) {
       if(Auth::check()) {
         $validation = Validator::make(Input::all(), $this->solutionRuleUpdate);
         if($validation->passes()) {
           $solution = SolutionCategory::where('id', $id)->first();
           $solution->method = Input::get('updateSolCategory');
           $solution->update();

           $feedback = [
               'type' => 'success',
               'message' => Lang::get('Admin/SdCategory.updateSuccessfully'),
           ];
           $tab = 'solutionCategory';
           return redirect('admin/sdCategory')->with([
             'feedback' => $feedback,
             'tab' => $tab
           ]);
         }
         else {
           return Redirect::back()->withErrors($validation)->withInput()->with([
   					'feedback' => [
   						'type' => 'danger',
   						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/SdCategory.solutionCategory')]),
   					]
   				]);
         }
       }
       else {
         return Redirect::guest('login');
       }
     }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * set category visibility
     * @param category $id
     */
    public function setCatVisible($id)
    {
      if(Auth::check()){
        $category = SdRecCategory::where('id', $id)->first();
        $category->visible = 1;
        $category->update();
        return $this->setReturn('category');
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function setCatInVisible($id)
    {
      if(Auth::check()){
        $category = SdRecCategory::where('id', $id)->first();
        $category->visible = 0;
        $category->update();
        return $this->setReturn('category');
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function setCatUserVisible($id)
    {
      if(Auth::check()){
        $userCategory = SdRecUserCategory::where('id', $id)->first();
        $userCategory->visible = 1;
        $userCategory->update();
        return $this->setReturn('userCategory');
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function setCatUserInVisible($id)
    {
      if(Auth::check()){
        $userCategory = SdRecUserCategory::where('id', $id)->first();
        $userCategory->visible = 0;
        $userCategory->update();
        return $this->setReturn('userCategory');
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function setSolVisible($id)
    {
      if(Auth::check()){
        $solution = SolutionCategory::where('id', $id)->first();
        $solution->visible = 1;
        $solution->update();
        return $this->setReturn('solutionCategory');
      }
      else {
        return Redirect::guest('login');
      }
    }
    public function setSolInVisible($id)
    {
      if(Auth::check()){
        $solution = SolutionCategory::where('id', $id)->first();
        $solution->visible = 0;
        $solution->update();
        return $this->setReturn('solutionCategory');
      }
      else {
        return Redirect::guest('login');
      }
    }

    /**
     * return with different parameters
     */
    public function setReturn($tab) {
      return redirect('admin/sdCategory')->with([
        'tab' => $tab,
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
