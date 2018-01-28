<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;
use finfo;
use File;

class SectionOneController extends Controller
{
    public function index(){
      $SectionOne=SectionOne::all();
      return view('admin.one',[
        'SectionOne'=>$SectionOne,
      ]);
    }
    public function create(){
      return view('admin.CreateOne');
    }
    public function store(Request $request){
      $SectionOne=new SectionOne;
      $type=$request->type;

      if($type==1){
        $SectionOne->title=$request->title;
        $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
  			$ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

  			$fname=$name.'.'.$ext;
        $request->content->move(storage_path('/file'), $fname);
        $SectionOne->content=$fname;
        $SectionOne->type=$type;
        $SectionOne->save();
      }else{
        $SectionOne->title=$request->title;
        $SectionOne->content=$request->content;
        $SectionOne->type=$type;
        $SectionOne->save();
      }



      return redirect('/admin/本校個人資料保護與管理');
    }

  public function update (Request $request,$id){
    $SectionOne=SectionOne::find($id);
    $type=$request->type;

    if($type==1){
      $SectionOne->title=$request->title;
      $name=pathinfo($request->content->getClientOriginalName(), PATHINFO_FILENAME);
      $ext=pathinfo($request->content->getClientOriginalName(), PATHINFO_EXTENSION);

      $fname=$name.'.'.$ext;
      $request->content->move(storage_path('/file'), $fname);
      $SectionOne->content=$fname;
      $SectionOne->save();
    }else{
      $SectionOne->title=$request->title;
      $SectionOne->content=$request->content;
      
      $SectionOne->save();
    }

    return redirect('/admin/本校個人資料保護與管理');

  }
  public function edit($id){
    $SectionOne=SectionOne::find($id);
    return view('admin.editone',[
      'SectionOne'=>$SectionOne,
    ]);
  }
  public function destroy($id){
    SectionOne::destroy($id);
    return redirect('/admin/本校個人資料保護與管理');
  }


}
