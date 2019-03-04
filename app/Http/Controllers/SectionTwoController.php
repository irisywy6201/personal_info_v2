<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;
use finfo;
use File;

class SectionTwoController extends Controller
{
    public function index(){
      $SectionTwo=SectionTwo::all();
      return view('admin.two',[
        'SectionTwo'=>$SectionTwo,
      ]);
    }
    public function create(){
      return view('admin.CreateTwo');
    }
    public function store(Request $request){
      $SectionTwo=new SectionTwo;
      $type=$request->type;

      if($type==1){
        $SectionTwo->title=$request->title;
        $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
  			$ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

  			$fname=$name.'.'.$ext;
        $request->content->move(storage_path('/file'), $fname);
        $SectionTwo->content=$fname;
        $SectionTwo->type=$type;
        $SectionTwo->save();
      }else{
        $SectionTwo->title=$request->title;
        $SectionTwo->content=$request->content;
        $SectionTwo->type=$type;
        $SectionTwo->save();
      }



      return redirect('/admin/個資資產盤點作業');
    }

  public function update (Request $request,$id){
    $SectionTwo=SectionTwo::find($id);
    $type=$request->type;

    if($type==1){
      $SectionTwo->title=$request->title;
	  if($request->content==null){
		  
	  }else{
		  $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
		  $ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

		  $fname=$name.'.'.$ext;
		  $request->content->move(storage_path('/file'), $fname);
		  $SectionTwo->content=$fname; 
	  }    
      $SectionTwo->save();
    }else{
      $SectionTwo->title=$request->title;
      $SectionTwo->content=$request->content;
      
      $SectionTwo->save();
    }

    return redirect('/admin/個資資產盤點作業');

  }
  public function edit($id){
    $SectionTwo=SectionTwo::find($id);
    return view('admin.edittwo',[
      'SectionTwo'=>$SectionTwo,
    ]);
  }
  public function destroy($id){
    SectionTwo::destroy($id);
    return redirect('/admin/個資資產盤點作業');
  }


}
