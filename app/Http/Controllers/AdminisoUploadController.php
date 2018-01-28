<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\isoList;
use DB;
use Auth;
use finfo;
use File;
class AdminisoUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$file=isoList::all();
		$test=$_SERVER['HTTP_HOST'];
		return view('admin/isoUpload.isoUpload', [
        'file'=>$file,
        'test'=>$test,
		]);
		
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
      
		$this->validate($request, [
            'isofile' => 'required',
        ],
		['isofile.required' => '您未選擇上傳檔案',
		]);
		$file= new isoList;
		$checkfile=isoList::all();
		$i=1;
		$finfo = new finfo();
		$fileMimeType = $finfo->file($request->isofile, FILEINFO_MIME_TYPE);
	
		
		foreach ($checkfile as $checkfile) {
			$name=pathinfo($request->isofile->getClientOriginalName(), PATHINFO_FILENAME);
			if($name==$checkfile->file_title){
			  $i=0;
			  return back()
				->with('error','您以上傳過相同名稱的檔案了');
			}
		}
		
		if($i==1){
			if($fileMimeType=='application/zip'||$fileMimeType=='application/iso'){
				// $imageName =time().'.'.$request->isofile->getClientOriginalExtension();
			$name=pathinfo($request->isofile->getClientOriginalName(), PATHINFO_FILENAME);
			$type=pathinfo($request->isofile->getClientOriginalName(), PATHINFO_EXTENSION);
			$newname=$name.time();
			$fname=$newname.'.'.$type;
			$file->file_dir=$newname;
			$request->isofile->move(public_path('NAS_Storage/software'), $fname);		
			$file->file_title=$name;
			$file->file_type=$type;		
			$file->save();
			return back()
				->with('success','上傳成功!')
				->with('path',$request->isofile->getClientOriginalName());
			}
			else{
				return back()
				->with('error2','您上傳的不是iso檔或zip');
			}
			
		}

		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($file_name)
    {
        

    }

    /**
     * 
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$file=isoList::find($id);
		return view('admin/isoUpload.iso_edit',[
			'file'=>$file
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
		$file=isoList::find($id);
		if($request->isofile){
			if($request->isofile->getclientoriginalextension()=='iso'){
				$dir=$file->file_dir;
				File::delete('NAS_Storage/software/'.$dir);
				// $imageName =time().'.'.$request->isofile->getClientOriginalExtension();
				$imageName=$file->file_dir;
				$request->isofile->move(public_path('NAS_Storage/software'), $imageName);
				$file->save();
			}
			else{
				return back()
				->with('error2','您上傳的不是iso檔');
			}
		$file->file_title=$request->file_title;
		$file->save();
		 
		}
    return redirect('/admin/auth_soft/isoUpload');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$file=isoList::find($id);
		$name=$file->file_title;
		$dir=$file->file_dir;
		$file->delete();
		File::delete('NAS_Storage/software/'.$dir);

		return back()
		  ->with('delete_suc','成功刪除'.$name);
    }
}
