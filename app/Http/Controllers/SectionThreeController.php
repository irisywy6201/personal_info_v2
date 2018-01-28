<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;

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
    $SectionThree->title=$request->title;
    $SectionThree->content=$request->content;

    $SectionThree->save();
    return redirect('/admin/其它');
  }

public function update (Request $request,$id){
  $SectionThree=SectionThree::find($id);
  $SectionThree->title=$request->title;
  $SectionThree->content=$request->content;
  $SectionThree->save();

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
