<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\isoList;
use DB;
use Auth;

use File;
class AdminisoDownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
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
    public function download($file_name,$id,$time)
    {
        if(Auth::user()){
			$file=isoList::find($id);
			$now_time=time();
			$differ=$now_time-$time;
			if($differ<86400){
				$file_path = public_path('NAS_Storage/software/'.$file->file_dir.'.'.$file->file_type);
				return response()->download($file_path);
			}
			else{
				echo "<script type='text/javascript'>alert('請重新登入後下載');</script>";
			}
			
			

		}
		else{
			return back()
				->with('plz_login','plz_login');

		}

    }

    /**
     *判斷使用者是否有下載的權限. 
     * @return \Illuminate\Http\Response
     */
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
