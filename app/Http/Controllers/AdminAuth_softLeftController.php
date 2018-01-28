<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use \Auth;
use \Input;
use \View;
use \Redirect;
use \Lang;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\CDs;
use App\Entities\download_version;


use App\Entities\platform;
use App\Entities\software_version;
use App\Entities\software_list;
use App\Entities\software_category;

use App\Entities\download;
use App\Entities\CDs_2;

class AdminAuth_softLeftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //$software_versions=software_version::all();
        //echo Lang::get('Auth_soft/platformList')[1]['title'];
	//$software_categories=software_category::all();
	//$software_lists=software_list::all();

	$i=1;
	foreach(Lang::get('Auth_soft/platformList') as $a){
		$bits[$i]['title']=$a['title'];
		$bits[$i]['id']=$a['id'];
		$i++;
	}
	$software_versions=software_version::all();	
	$software_lists=software_list::all();
	$software_categories=software_category::all();	
	foreach($software_versions as $software_version){
		$software_version['software_category_id']=software_list::where('id',$software_version['software_list_id'])->value('software_category_id');
		$software_version['software_category']=software_category::where('id',$software_version['software_category_id'])->value('category_name_zh');
		$software_version['name_zh']=software_list::where('id',$software_version['software_list_id'])->value('name_zh');
		$software_version['platform']=$bits[$software_version['platform_id']]['title'];
	}


	$CDs=CDs::all();
	$CDs_2=CDs_2::all();
 	$download_version=download_version::all();
	$download=download::all();
	//foreach($software_versions as $s){
	//	echo $s['software_list_id'];
	//}

	return View::make('admin.Auth_soft.left')->with([
		'software_versions'=>$software_versions,'bits'=>$bits,'software_lists'=>$software_lists,
		'software_categories'=>$software_categories
	]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     
    public function store(Request $request)*/
    public function store()
    {
        //
	if(Auth::check()){
		$test=new CDs_2;
		$left_number=Input::get('theLeft');
		$download_id=Input::get('softName');
		$download_version_id=Input::get('bits');
		$type=Input::get('type');
		
	

		$test->left_number=$left_number;
		$test->download_id=$download_id;
		$test->download_version_id=$download_version_id;
		$test->type=$type;
		/*  資料驗證*/
	  	$input=array('download_id'=>$test->download_id,
			     'download_version_id'=>$test->download_version_id,
			     'type'=>$test->type,
			     'left_number'=>$test->left_number);
		$rules=['download_id'=>'required',
			'download_version_id'=>'required',
		        'type'=>'required',
			'left_number'=>'required|integer'];
		$message=['required'=>'不可有空白欄位！',
			  'integer'=>'剩餘片數只能填整數！',
			  'unique'=>'此光碟名稱已經用過！'];
		$validator=Validator::make($input,$rules,$message);
		if($validator->fails()){
			return redirect('admin/Auth_soft/left')
			->withErrors($validator);
			
		}
		else{
			$test->save();
			return redirect('admin/Auth_soft/left');
		}
		
	}
	else{
		return Redirect::quest('login');
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
     
    public function update(Request $request, $id)*/
    public function update()
    {
	if(Auth::check()){
		$id=Input::get('id');
		$surplus=Input::get('surplus');

		$software_version=software_version::find($id);
		$software_version->surplus=$surplus;
		$input=array('surplus'=>$software_version->surplus);
		$rules=['surplus'=>'required',
			'surplus'=>'integer'];

                $message=['required'=>'此欄位不可為空白',
                          'integer'=>'此欄位只能填整數'];

		$validator=Validator::make($input,$rules,$message);
                if($validator->fails()){
                        return redirect('admin/Auth_soft/left')
                        ->withErrors($validator);
                }
                else{
                        $software_version->save();
                        return redirect('admin/Auth_soft/left');
                }
                return redirect('admin/Auth_soft/left');	
	}
	else{
		return Redirect::quest('login');
	}
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     
    public function destroy($id)*/
    public function destroy()
    {
        //
	if(Auth::check()){
		$id=Input::get('id');
		$test=CDs_2::find($id);

		$test->delete();
		return redirect('admin/Auth_soft/left');
	}
    }
}
