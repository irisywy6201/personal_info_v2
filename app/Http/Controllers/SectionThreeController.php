<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;
use finfo;
use File;

class SectionThreeController extends Controller
{
    public function index(){
      $SectionThree=SectionThree::all();
      return view('admin.three',[
        'SectionThree'=>$SectionThree,
      ]);
    }
    public function create(){
      return view('admin.CreateThree');
    }
    public function store(Request $request){
      $SectionThree=new SectionThree;
      $type=$request->type;

      if($type==1){
        $SectionThree->title=$request->title;
        $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
  			$ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

  			$fname=$name.'.'.$ext;
        $request->content->move(storage_path('/file'), $fname);
        $SectionThree->content=$fname;
        $SectionThree->type=$type;
        $SectionThree->save();
      }else{
        $SectionThree->title=$request->title;
        $SectionThree->content=$request->content;
        $SectionThree->type=$type;
        $SectionThree->save();
      }



      return redirect('/admin/其它');
    }

  public function update (Request $request,$id){
    $SectionThree=SectionThree::find($id);
    $type=$request->type;

    if($type==1){
      $SectionThree->title=$request->title;
	  if($request->content==null){
		  
	  }else{
		  $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
		  $ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

		  $fname=$name.'.'.$ext;
		  $request->content->move(storage_path('/file'), $fname);
		  $SectionThree->content=$fname; 
	  }    
      $SectionThree->save();
    }else{
      $SectionThree->title=$request->title;
      $SectionThree->content=$request->content;
      
      $SectionThree->save();
    }

    return redirect('/admin/其它');

  }
  public function edit($id){
    $SectionThree=SectionThree::find($id);
    return view('admin.editthree',[
      'SectionThree'=>$SectionThree,
    ]);
  }
  public function destroy($id){
    SectionThree::destroy($id);
    return redirect('/admin/其它');
  }


}
