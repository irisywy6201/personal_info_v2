<?php

namespace App\Http\Controllers;
use File;
use Response;
use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;

class HomeController extends Controller
{
    public function index(){
      $SectionOne=SectionOne::all();
      $SectionTwo=SectionTwo::all();
      $SectionThree=SectionThree::all();
      return view('index',[
      'SectionOne'=>$SectionOne,
      'SectionTwo'=>$SectionTwo,
      'SectionThree'=>$SectionThree,
      ]);
    }
    public function showone($id,$title){


      $SectionOne=SectionOne::find($id);
      $type=$SectionOne->type;
      if($type==1){
        $filename = $SectionOne->content;
        $path = storage_path('file/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$title.'"'
        ]);
      }else{
        return view('admin.show',[
          'show'=>$SectionOne,

        ]);
      }

    }

    public function showtwo($id,$title){
      $SectionTwo=SectionTwo::find($title);
      $type=$SectionTwo->type;
      if($type==1){
        $filename = $SectionTwo->content;
        $path = storage_path('file/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$title.'"'
        ]);
      }else{
        return view('admin.show',[
          'show'=>$SectionTwo,

        ]);
      }

    }

    public function showthree($id,$title){
       $SectionThree=SectionThree::find($title);
      $type=$SectionThree->type;
      if($type==1){
        $filename = $SectionThree->content;
        $path = storage_path('file/'.$filename);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$title.'"'
        ]);
      }else{
        return view('admin.show',[
          'show'=>$SectionThree,

        ]);
      }

    }

}
