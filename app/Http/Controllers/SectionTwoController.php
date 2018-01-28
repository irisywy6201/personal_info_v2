<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;

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
      $SectionTwo->title=$request->title;
      $SectionTwo->content=$request->content;

      $SectionTwo->save();
      return redirect('/admin/個資資產盤點作業');
    }

  public function update (Request $request,$id){
    $SectionTwo=SectionTwo::find($id);
    $SectionTwo->title=$request->title;
    $SectionTwo->content=$request->content;
    $SectionTwo->save();

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
