<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use \Auth;
use \Input;
use \Redirect;
use \Lang;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \View;
use App\Entities\CDs_2;
use App\Entities\download_version;
use App\Entities\download;
use App\Entities\User;
use App\Entities\studentsCD_v2;

use App\Entities\Readme;

use App\Entities\software_list;
use App\Entities\software_version;
use App\Entities\software_requirement;
use App\Entities\software_category;
use App\Entities\software_cd_collection_record;
use DB;

class AdminAuth_softSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index()
    {
	 return View::make('admin.Auth_soft.search');

    }
    public function downloadnew(){
	$software_category = software_category::all();
	return view('Auth_software/download.download_new',[
		'software_category'=>$software_category,
	]);
	return View::make('admin.Auth_soft.search');
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show()
    {
        //
	/*
	需要顯示：
		所有的光碟
		有無領取
	*/
	//$method = Input::get('method');
	$search_input = Input::get('search_input');

	$software_versions=software_version::withTrashed()->get();
	$software_lists=software_list::all();
	
	$i=1;
        foreach(Lang::get('Auth_soft/platformList') as $a){
       		$bits[$i]['title']=$a['title'];
        	$bits[$i]['id']=$a['id'];
        	$i++;
        }
	$software_cd_collection_records=software_cd_collection_record::where('users_id','=',$search_input)->get();
	/* 先在使用者裡查詢該使用者是否存在 */
        /* $userChecker==0 表示該使用者不存在 */
	$userChecker=User::where('acct','=',$search_input)->get();
        $userChecker=count($userChecker);
	
	if($userChecker!=0){
		foreach($software_versions as $software_version){
			$haveTaken[$software_version['id']]=0;
		}
		foreach($software_cd_collection_records as $software_cd_collection_record){
			$haveTaken[$software_cd_collection_record['software_version_id']]=1;
		}
		foreach($software_versions as $software_version){
			if($haveTaken[$software_version['id']]==1){
				$cds[$software_version['id']]['softName']=software_list::where('id',$software_version['software_list_id'])->value('name_zh');
				$cds[$software_version['id']]['platform']=$bits[$software_version['platform_id']]['title'];
				$cds[$software_version['id']]['lend_time']=software_cd_collection_record::where('users_id',$search_input)->where('software_version_id',$software_version['id'])->value('updated_at');
			}
		}	
	}
	if(count($software_cd_collection_records)!=0){
		return View::make('admin.Auth_soft.search')->with([
			'test'=>$software_cd_collection_records,'cds'=>$cds
		]);
	}
	else if(count($software_cd_collection_records)==0){
		if($userChecker==0){
			return View::make('admin.Auth_soft.search')->with([
				'userChecker'=>$userChecker
				
			]);
			/*查無此人*/
		}
		else{
			return View::make('admin.Auth_soft.search')->with([
				'userChecker'=>$userChecker
				
			]);
			/*此人沒有租用過任何光碟*/
		}
	}
    }
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
