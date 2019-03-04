<?php

namespace App\Http\Controllers;

use \Auth;
use \App;
use \View;
use \Lang;
use \Input;
use \Validator;
use \Redirect;
use Carbon\Carbon;
use Session;
use \Excel;
use \SearchEngine;

use DateInterval;
use DateTime;

use App\Entities\Category;
use App\Entities\SolutionCategory;
use App\Entities\SdRecCategory;
use App\Entities\SdRecord;
use App\Entities\SdRecUserCategory;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class SdRecordController extends Controller
{
    //decide how many records to divide per page
    private $userExclude = 0;
    private $rules = [
      'category' => 'required',
      'solution' => 'required',
      'user_category' => 'required',
      // 'sdRecCont' => 'required|regex:[^(<p>)(<\/p>)(<br>)(&nbsp;)( )]'
      'sdRecCont' => 'required',
      'datetimepicker' => 'required | regex:[\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d]',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      $records = SdRecord::orderBy('created_at','desc')->paginate(10);
      $category = SdRecCategory::getSubCategory(1)->get();
      $department = SdRecCategory::getSubCategory(0)->get();
      $user_category = SdRecUserCategory::get();
      $solution_category = SolutionCategory::get();

      $endDate =(new DateTime())->format('Y-m-d');
      $startDate = (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d');
      return View::make('sdRecord.sdRecord',[
        'records' => $records,
        'department' => $department,
        'category' => $category,
        'u_category' => $user_category,
        'solution' => $solution_category,
        'startDate' => $startDate,
  			'endDate' => $endDate,
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if(Auth::check()){
        // $category = Category::getSubCategory('1')->notHidden()->get();
        $solution_category = SolutionCategory::getVisibility(1)->get();
        $category = SdRecCategory::getSubCategory(1)->getVisibility(1)->get();
        // $user_category = Lang::get('sdRecord/user_category');
        $user_category = SdRecUserCategory::getVisibility(1)->get();
        $currentTime = Carbon::now();
        return View::make('sdRecord.create',[
            'category' => $category,
            'solution' => $solution_category,
            'user_category' => $user_category,
            'currentTime' => $currentTime,
        ]);
      }
      else {
  			return Redirect::guest('login');
  		}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if(Auth::check()){
        $validation = Validator::make(Input::all(), $this->rules);

        if ($validation->passes()){
          $records = new SdRecord;
          $records->category = Input::get('category');
          $records->user_category = Input::get('user_category');
          $records->sdRecCont = Input::get('sdRecCont');
          $records->solution = Input::get('solution');
          $records->recorder = Auth::user()->username;
          $records->user_id = Input::get('user_id');
          $records->user_contact = Input::get('user_contact');
          $records->editTime = Carbon::now();
          $records->created_at = Input::get('datetimepicker');
          $records->updated_at = Input::get('datetimepicker');
          $records->save();

          // return redirect('deskRecord/')->withInput()->with('success','Record is successfully saved !');
          return redirect('deskRecord/')->with([
            'feedback' => [
                'type' => 'success',
                'message' => Lang::get('sdRecord/board.saveSuccess'),
            ]
          ]);
        }

        else{
          return Redirect::back()->withErrors($validation)->withInput()->with([
  					'feedback' => [
  						'type' => 'danger',
  						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('sdRecord/board.saveFail')]),
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
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if (!$this->isRecordExists($id)) {
  			return App::abort(404);
  		}
      else{
        $records = SdRecord::getFromId($id)->first();
        $paginate = SdRecord::paginate(10);
        $parent_id = SdRecCategory::where('id', $records->category)->value('parent_id');
        $department = SdRecCategory::where('id', $parent_id)->first();
        $category = SdRecCategory::where('id', $records->category)->first();
        $solution_category = SolutionCategory::where('id', $records->solution)->first();
        // $user_category = Lang::get('sdRecord/user_category');
        // $user_category = $user_category[$records->user_category];
        $user_category = SdRecUserCategory::getFromId($records->user_category)->first();

        return View::make('sdRecord.detail',[
          'records' => $records,
          'department' => $department,
          'category' => $category,
          'u_category' => $user_category,
          'solution' => $solution_category,
          'paginate' => $paginate,
        ]);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if(Auth::check()){
        if (!$this->isRecordExists($id)) {
    			return App::abort(404);
    		}
        else {
          $records = SdRecord::getFromId($id)->first();
          $category = SdRecCategory::getSubCategory(1)->getVisibility(1)->get();
          $department = SdRecCategory::getSubCategory(0)->get();
          $categoryTitle = SdRecCategory::getFromId($records->category)->first();
          $solution_category = SolutionCategory::getVisibility(1)->get();
          $solutionTitle = SolutionCategory::getFromId($records->solution)->first();
          // $user_category = Lang::get('sdRecord/user_category');
          $userCategoryTitle = SdRecUserCategory::getFromId($records->user_category)->first();
          $user_category = SdRecUserCategory::getVisibility(1)->get();
          $recordTime = $records->created_at;
          return View::make('sdRecord.edit',[
            'records' => $records,
            'editId' => $id,
            'category' => $category,
            'categoryTitle' => $categoryTitle,
            'solution' => $solution_category,
            'solutionTitle' => $solutionTitle,
            'userCategoryTitle' => $userCategoryTitle,
            'user_category' => $user_category,
            'recordTime' => $recordTime,
          ]);
        }
      }
      else {
  			return Redirect::guest('login');
  		}
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
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if(Auth::check()){
        $validation = Validator::make(Input::all(), $this->rules);

        if($validation->passes()){
          $records = SdRecord::where('id', $id)->first();
          $records->category = Input::get('category');
          $records->user_category = Input::get('user_category');
          $records->sdRecCont = Input::get('sdRecCont');
          $records->solution = Input::get('solution');
          $records->user_id = Input::get('user_id');
          $records->user_contact = Input::get('user_contact');
          $records->editTime = Carbon::now();
          $records->created_at = Input::get('datetimepicker');
          $records->update();
          return redirect('/deskRecord'.'/'.$id)->with([
            'feedback' => [
                'type' => 'success',
                'message' => Lang::get('sdRecord/board.updateSuccess'),
            ]
          ]);
        }
        else{
          return Redirect::back()->withErrors($validation)->withInput()->with([
  					'feedback' => [
  						'type' => 'danger',
  						'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('sdRecord/board.saveFail')]),
  					]
  				]);
        }
      }
      else {
  			return Redirect::guest('login');
  		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      if(Auth::check()) {
        if (!$this->isRecordExists($id)) {
    			return ['url' => '/deskRecord',
                  'process' => 'fail',
                ];
    		}
        else {
          $records = SdRecord::find($id);
          $records->delete();
          return ['url' => '/deskRecord',
                  'process' => 'success',
          ];
        }
      }
      else {
        return Redirect::guest('login');
      }
    }

    /**
     * Output excel file.
     *
     * @return deskRecord
     */
     public function output() {
       if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
         return App::abort(404);
       }
       $start = Input::get('start');
       $end = Input::get('end');
       $startDate = (new DateTime($start));
       $endDate = (new DateTime($end))->add(new DateInterval('P1D'));
       $category = Input::get('filter_category');
       $user_category = Input::get('filter_user_category');
       $solution = Input::get('filter_solution');
       $department = Input::get('filter_department');
       $titleName = ['編號','單位','分類','記錄內容','解決方式','記錄人','詢問者身份','學生學號或教職員帳號','聯絡方式','建立日期','最後編輯日期'];
       $currentTime = Carbon::now();
       $filterNull = false;

       //  $finalData = SdRecord::orderby('created_at','asc')->afterTime($startDate)->beforeTime($endDate)->outputData($checkbox);
       $finalData = SdRecord::orderby('created_at','asc')->afterTime($startDate)->beforeTime($endDate);
       if($category != 0) {
         $finalData = $finalData->where('category', $category);
       }
       if($user_category != 0) {
          $finalData = $finalData->where('user_category', $user_category);
       }
       if($solution != 0) {
          $finalData = $finalData->where('solution', $solution);
       }
       if($department != 0) {
         $departmentCategoryId = [];
         $findDepartment = SdRecCategory::where('parent_id', $department)->get();
         foreach ($findDepartment as $key => $value) {
           array_push($departmentCategoryId, $value->id);
         }
         $finalData = $finalData->whereIn('category', $departmentCategoryId);
       }

       //check if query return nothing
       if($finalData->get()->count() != 0){
         $finalData = $finalData->outputData();
         Excel::create('records_'.$currentTime, function($excel) use($finalData,$start,$end,$titleName) {
     			$excel->sheet('ServiceDeskRecords', function($sheet) use($finalData,$start,$end,$titleName) {
     				$sheet->row(1,['開始日期：',$start,'結束日期：',$end]);
     				$sheet->fromModel($finalData,null,'A2',true);
            $sheet->row(2, $titleName);
          });
     			ob_end_clean();
     		})->export('xls');
       }
       else {
         return Redirect::back()->withInput()->with([
           'feedback' => [
             'type' => 'danger',
             'message' => Lang::get('sdRecord/board.exportFail'),
           ]
         ]);
       }
    }

    /**
     *
     *filterSearch
     *
     * filterItem determine whether a user has used one specific filter
     * filterItemDetail stores the filter's value and past it to View
     * noFilterItem determine whether user has use any filter
     *
     */
    public function filterSearch() {
      if((Auth::user()->role + Auth::user()->addrole) == $this->userExclude){
        return App::abort(404);
      }
      $category = SdRecCategory::getSubCategory(1)->get();
      $department = SdRecCategory::getSubCategory(0)->get();
      $user_category = SdRecUserCategory::get();
      $solution_category = SolutionCategory::get();
      $endDate =(new DateTime())->format('Y-m-d');
      $startDate = (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d');
      $filterItem = array(false,false,false,false);
      $filterItemDetail = array( "", "", "", "");
      $noFilterItem = true;

      //user selected filter value
      $filter_category = Input::get('filter_category');
      $filter_user_category = Input::get('filter_user_category');
      $filter_solution = Input::get('filter_solution');
      $filter_department = Input::get('filter_department');

      //result data
      $records = SdRecord::orderBy('created_at','desc');

      //filting process
      if($filter_department != 0) {
        $department_range = [];
        foreach (SdRecCategory::getSubCategory($filter_department)->get() as $key => $value) {
          array_push($department_range, $value->id);
        }
        $records = $records->whereIn('category', $department_range);

        $noFilterItem = false;
        $filterItem[0] = true;
        foreach($department as $key => $value){
            if($value->id == $filter_department){
              $filterItemDetail[0] = $value->name;
            }
        }
      }
      if($filter_category != 0) {
        $records = $records->where('category', $filter_category);

        $noFilterItem = false;
        $filterItem[1] = true;
        foreach($category as $key => $value){
            if($value->id == $filter_category){
              $filterItemDetail[1] = $value->name;
            }
        }
      }
      if($filter_user_category != 0) {
        $records = $records->where('user_category', $filter_user_category);

        $noFilterItem = false;
        $filterItem[2] = true;
        foreach($user_category as $key => $value){
            if($value->id == $filter_user_category){
              $filterItemDetail[2] = $value->user;
            }
        }
      }
      if($filter_solution != 0) {
        $records = $records->where('solution', $filter_solution);

        $noFilterItem = false;
        $filterItem[3] = true;
        foreach($solution_category as $key => $value){
            if($value->id == $filter_solution){
              $filterItemDetail[3] = $value->method;
            }
        }
      }

      //return result
      if($records->count() != 0 && !$noFilterItem){
        $records = $records->get();
        return View::make('sdRecord.sdRecordSearch',[
          'records' => $records,
          'department' => $department,
          'category' => $category,
          'u_category' => $user_category,
          'solution' => $solution_category,
          'startDate' => $startDate,
    			'endDate' => $endDate,
          'filterItem' => $filterItem,
          'filterItemDetail' => $filterItemDetail,
        ]);
      }
      //return back to view to alert user to choose at least one filter
      else if($noFilterItem){
        return Redirect::back()->withInput()->with([
          'feedback' => [
            'type' => 'danger',
            'message' => Lang::get('sdRecord/board.chooseFilterItem'),
          ]
        ]);
      }
      // return back to view to alert user that there is no match content
      else{
        return Redirect::back()->withInput()->with([
          'feedback' => [
            'type' => 'danger',
            'message' => Lang::get('sdRecord/board.noFilterData'),
          ]
        ]);
      }
    }

    /**
     *
     * realTimeSearch
     * @return Response
     */
    public function realTimeSearch() {
      if(Input::has('keyword')){
        $result = SearchEngine::search(Input::get('keyword'), 'sdRecord', ['sdRecCont','recorder','user_id','user_contact']);
        $result = SdRecord::whereIn('id', $result->lists('id'));

        $result = $result->get(['id', 'recorder', 'sdRecCont', 'created_at']);
        // dd($result);
        return View::make('sdRecord.realTimeSearchResult')->with([
          'results' => $result
        ]);
      }
    }

    /**
     * Show Deletion complete or fail.
     *
     * @return deskRecord
     */
    public function confirmDelete() {
      if(Session::get('pageLeft')>1) {
        return redirect('deskRecord/?page='.Session::get('pageNum'))->with([
          'feedback' => [
              'type' => 'success',
              'message' => Lang::get('sdRecord/board.deleteSuccess'),
          ]
        ]);
      }
      else {
        if(Session::get('lastPage')>1) {
          return redirect('deskRecord/?page='.(Session::get('pageNum')-1))->with([
            'feedback' => [
                'type' => 'success',
                'message' => Lang::get('sdRecord/board.deleteSuccess'),
            ]
          ]);
        }
        else {
          return redirect('deskRecord/')->with([
            'feedback' => [
                'type' => 'success',
                'message' => Lang::get('sdRecord/board.deleteSuccess'),
            ]
          ]);
        }
      }
    }
    public function failDelete() {
      return redirect('deskRecord/?page='.Session::get('pageNum'))->with([
        'feedback' => [
            'type' => 'danger',
            'message' => Lang::get('sdRecord/board.deleteFail'),
        ]
      ]);
    }


    /**
  	 * Check if the records exists or not.
  	 *
  	 * @param Integer id The ID number of the records.
  	 * @return Return True if records exists, return False
  	 * otherwise.
  	 */
  	private function isRecordExists($id)
  	{
  		if (SdRecord::find($id)) {
  			return true;
  		}
  		else {
  			return false;
  		}
  	}
}
