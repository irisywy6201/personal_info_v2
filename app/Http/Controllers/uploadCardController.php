<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class uploadCardController extends Controller
{

	public function index(){
		return View::make('forgetpass.uploadCard');
	}

	public function store(){

		$hiddenText = Input::get("hiddenText");
		
		if (Request::ajax()){
		    //$today = time();
		    date_default_timezone_set('Asia/Taipei'); 
		    //$t = date ("Y-m-d H:i:s" , mktime(date('H'), date('i'), date('s'), date('m'), date('d'), (date('Y'))));
		    $now = date("Y").date("m").date("d").date("H").date("i").date("s");
		    //$date = Carbon::now()->addSeconds(10);

		    $file;
		    $fileName;
		    $studentId = "100502062";
		    $inputUpDown;
		    $fileSize;
		    $pastUpImgName = "";
		    $pastDownImgName = "";

		    if (Input::hasFile("fileup")){
		    	$inputUpDown 	= "up";
		    	$pastUpImgName	= Input::get("pastUpImgName");
		    	$file 			= Input::file("fileup");
		    	$fileExt		= $file->getClientOriginalExtension();
		    	$fileName 		= $file->getClientOriginalName();
		    	$newFileName 	= $studentId.$inputUpDown.$now.".".$fileExt;

		    	try{
		    		unlink("upload/".$pastUpImgName);
		    	}catch(Exception $e){

		    	}

				$pastUpImgName = $newFileName;
			}

			if(Input::hasFile("filedown")){
				$inputUpDown 	= "down";
				$pastDownImgName= Input::get("pastDownImgName");
				$file 			= input::file('filedown');
				$fileExt		= $file->getClientOriginalExtension();
				$fileName 		= $file->getClientOriginalName();
		    	$newFileName 	= $studentId.$inputUpDown.$now.".".$fileExt;

				try{
		    		unlink("upload/".$pastDownImgName);
		    	}catch(Exception $e){

		    	}

				$pastDownImgName = $newFileName;
		    }

			$fileSize 		= $file->getSize();
			
			$fileMime		= $file->getMimeType();

			$file->move("upload/", $fileName);
			rename("upload/".$fileName, "upload/".$newFileName);

			$imgArray 		= array();
			$imgArray[0] 	= "upload/".$newFileName;
			$imgArray[1] 	= $inputUpDown;
			$imgArray[2] 	= $fileSize;
			$imgArray[3]	= $fileExt;
			$imgArray[4]	= $fileMime;
			$imgArray[5]	= $newFileName;
			$imgArray[6]	= $pastUpImgName;
			$imgArray[7]	= $pastDownImgName;
			
			return Response::json($imgArray);
		}
	}
}

?>