<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\software_list;
use App\Entities\software_version;
use App\Entities\software_requirement;
use App\Entities\software_category;
use DB;
class AdminSoftwareCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		$software_version = software_version::all();
		$software_requirement = software_requirement::all();
		$name = software_list::all();
		$software_category = software_category::all();
		return view('admin/SoftwareList.SoftwareList',[
			'software_version'=>$software_version,
			'software_requirement'=>$software_requirement,
			'name'=>$name,
			'software_category'=>$software_category,
			
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('Auth_software/download.create_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'name_zh' => 'required'
		], ['name_zh.required' => '軟體名稱欄位不可留空白!'
		]);
		$this->validate($request, [
        'name_en' => 'required'
		], ['name_en.required' => '軟體名稱欄位不可留空白!'
		]);
		$test = new software_category;
		$test->category_name_zh=$request->name_zh;
		$test->category_name_en=$request->name_en;
		$test->save();
		return Redirect::to('/admin/auth_soft/Category')->with([
			'success_category'=>'新增成功!'
		]);
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
        $software_category = software_category::find($id);
		
		return view('Auth_software/download.edit_category', [
			'software_category' => $software_category,
			
		]);
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
		$software_category=software_category::find($id);
		$software_category->category_name_zh=$request->category_zh;
		$software_category->category_name_en=$request->category_en;
		$software_category->save();
		return redirect('/admin/auth_soft/Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $software_category = software_category::find($id);
		$software_category->delete();
		return back()
		  ->with('delete_suc_category','刪除成功!');
    }
}
