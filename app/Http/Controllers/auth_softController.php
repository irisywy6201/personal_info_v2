<?php

namespace App\Http\Controllers;
use \App;
use \Auth;
use \View;
use \Input;
use \Lang;
use \Redirect;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\Readme;
use App\Entities\ReadmeCatagory;
use App\Entities\authsoftIndex;

use App\Entities\CDs_2;
use App\Entities\download_version;
use App\Entities\download;
use App\Entities\studentsCD_v2;
use App\Entities\User;

use App\Entities\software_list;
use App\Entities\software_version;
use App\Entities\software_requirement;
use App\Entities\software_category;
use App\Entities\software_cd_collection_record;
use DB;
class auth_softController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $rules = [
			'g-recaptcha-response' => 'required|recaptcha',
			'id' => 'required',
			'title_zh' => 'required',
			'title_en' => 'required',
			'Content_zh' => 'required',
			'Content_en' => 'required',
		]; 

  public function index(){

       		$i=1;
       		foreach(Lang::get('Auth_soft/platformList') as $a){
         	       $bits[$i]['title']=$a['title'];
         	       $bits[$i]['id']=$a['id'];
         	       $i++;
      		}
		$software_version_list_ids=software_version::lists('software_list_id');
		foreach ($software_version_list_ids as $software_version_list_id){
			$software_version_ids=software_version::where('software_list_id',$software_version_list_id)->where('surplus','>',0)->lists('id');
			foreach ($software_version_ids as $software_version_id){
				$platform_id=software_version::where('id',$software_version_id)->value('platform_id');
				$options[$software_version_list_id][$software_version_id]['platform']=$bits[$platform_id]['title'];
				$options[$software_version_list_id][$software_version_id]['lend_time']=software_cd_collection_record::where('software_version_id',$software_version_id)->value('updated_at');
				$options[$software_version_list_id][$software_version_id]['name']=software_list::where('id',$software_version_list_id)->value('name_zh');
			}
		}
		if (Auth::check()) {
			/* 找尋已經領過的軟體 */
			$haveTakenSoftId[0]=0;
			$haveTakenTime[0]=0;
			$have_taken_software_version_id=software_cd_collection_record::where('users_id',Auth::user()['acct'])->lists('software_version_id');
			foreach($have_taken_software_version_id as $cds_id){
				$soft_id=software_version::where('id',$cds_id)->value('software_list_id');
				$haveTakenSoftId[$soft_id]=1;
				$haveTakenTime[$soft_id]=software_cd_collection_record::where('users_id',Auth::user()['acct'])->where('software_version_id',$cds_id)->value('updated_at');
				//soft_id是軟體id(software_list)，不是光碟id(software_version)

			}

			$haveTakenNumber=0;
			$notTakenNumber=0;
			foreach ($options as $software_list_id=>$o){
				if (isset($haveTakenSoftId[$software_list_id])){
					$haveTakenNumber++;
				}
				if (!isset($haveTakenSoftId[$software_list_id])){
					$notTakenNumber++;
				}
			}

			/*
				Readme>>officeDoc
			*/

			$readme = Readme::all();
			$readmecatagory = Readmecatagory::all();
			$software_version = software_version::all();
			$software_requirement = software_requirement::all();
			$name = software_list::all();
			$software_category = software_category::all();
			$g_year=round(Auth::user()->acct/1000000,0)+3;
			$authsoftindex = authsoftIndex::all();
		

			if(isset($haveTakenSoftId)){

				return view('Auth_software.index',[
					'readme' => $readme,
					'readmecatagory' => $readmecatagory,
					'software_version'=>$software_version,
					'software_requirement'=>$software_requirement,
					'name'=>$name,
					'software_category'=>$software_category,
					'options'=>$options,
					'g_year'=>$g_year,
					'haveTakenSoftId'=>$haveTakenSoftId,
					'haveTakenTime' => $haveTakenTime,
					'authsoftindex' => $authsoftindex,
					'haveTakenNumber'=>$haveTakenNumber,
					'notTakenNumber'=>$notTakenNumber
				]);
			}
			else{
				return view('Auth_software.index',[
					'readme' => $readme,
					'readmecatagory' => $readmecatagory,
					'software_version'=>$software_version,
					'software_requirement'=>$software_requirement,
					'name'=>$name,
					'software_category'=>$software_category,
					'options'=>$options,
					'g_year'=>$g_year,
					'authsoftindex' => $authsoftindex,
				]);
			}
		}
		else
		{
			return Redirect::to('/login');
		}
		
    }
    public function apple(){
		$readme = Readme::all();
		return view('Auth_software.readme',[
			'readme' => $readme,
		]);	 
    }
    /**
     * 
     *
     lluminate\Routing\Redirector* 
     */
    public function takeCD(){
	$softNumber=Input::get("softNumber");

	$software_list_ids=software_list::lists('id');

	//$download_ids=download::lists('id');


	foreach ($software_list_ids as $software_list_id){
	        if(!empty(Input::get("check_".$software_list_id))){
			$studentID=Auth::user()['acct'];
                        $cdID=substr(Input::get("softInput_".$software_list_id),9);
                        /* 把租用的項目記錄下來，並且更改CD數量 */
                        $record=new software_cd_collection_record;
                        $record->users_id=$studentID;
                        $record->software_version_id=$cdID;
                        $record->save();
                        $cd=software_version::find($cdID);
                        $cd->surplus=$cd->surplus-1;
                        $cd->save();

		}
		$sended="hi";
	}
	/*
	foreach ($download_ids as $download_id){
		if(!empty(Input::get("check_".$download_id))){
			/*假如打勾，針對打勾的方格做出動作*/
			/* debug 用的echo */
			/*echo Input::get("check_".$i);
			echo "</br>";
			echo Input::get("soft_id_".$i);
			echo "</br>";
			echo Auth::user()['acct'];
			echo "</br>";
			echo Input::get("softInput_".$i);
			echo "</br>";
			echo substr(Input::get("softInput_".$i),9);
			echo "</br>";

			$studentID=Auth::user()['acct'];
			$cdID=substr(Input::get("softInput_".$download_id),9);
			/* 把租用的項目記錄下來，並且更改CD數量 
  			$record=new studentsCD_v2;
		        $record->users_id=$studentID;
			$record->CDs_id=$cdID;
			$record->save();
		
			$cd=CDs_2::find($cdID);
			$cd->left_number=$cd->left_number-1;	
			$cd->save();
		}
		$sended="hi";
	}*/


	return redirect('auth_soft')->with('sended','sended!');
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
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function show($id)
    {
        //
    }*/

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	public function show()
	{
			$readme = Readme::all();
			$readmecatagory = Readmecatagory::all();
			$software_version = software_version::all();
			$software_requirement = software_requirement::all();
			$name = software_list::all();
			$software_category = software_category::all();
			$authsoftindex = authsoftIndex::all();
			return view('Auth_software.readme',[
			'readme' => $readme,
			'readmecatagory' => $readmecatagory,
			'software_version'=>$software_version,
			'software_requirement'=>$software_requirement,
			'name'=>$name,
			'software_category'=>$software_category,
			'authsoftindex' => $authsoftindex,
		]);	
	}
}
