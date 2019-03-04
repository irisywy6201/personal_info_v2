<?php

namespace App\Http\Controllers;

use \Auth;
use \DB;
use \Input;
use \Validator;
use \Lang;
use \Redirect;
use \URL;
use \View;

use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Jobs\SendMail;

use App\Entities\Approve;
use App\Entities\ApproveManager;


class forgetBackupMailController extends Controller
{

	public function index()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}else
		{
			return View::make('forgetBackupMail.forgetBackupMail');
		}
	}

	public function store()
	{
		try 
		{
			$email				= Input::get('email');
			$hiddenText			= explode(' ', Input::get('hiddenText'));
			$cardFrontPath		= Input::get('cardFrontPath');
			$cardBackPath		= Input::get('cardBackPath');

			$inputData = array(
			    'username'  => $hiddenText[0],
			    'schoolID'  => $hiddenText[1],
			    'IdeID'     => $hiddenText[2],
			    'stuOrNot'  => $hiddenText[3],
			    'wholeBir'	=> $hiddenText[4]
			);

			/**************************************
				檢查 input session 是否逾時
			***************************************/
			$isSessionEmpty = 0;
			foreach ($inputData as $key => $value) 
			{
				if( $value=='' )
				{
					$isSessionEmpty++;
				}
			}

			if( $isSessionEmpty!=0 )
			{
				return Redirect::to('forgetpass')
					->with(array(
						'sessionTimeOut'	=> Lang::get('forgetpass/confirmCorrect.sessionTimeOut'),
						));
			}
			
			/***********************
				生日 => 西元年-月-日
			***********************/
			$year 		= substr($inputData['wholeBir'], 0, -4);
			$year2 		= (intval($year) + 1911);
			$month 		= substr($inputData['wholeBir'], -4, -2);
			$day 		= substr($inputData['wholeBir'], -2);
			$birthday 	= $year2.'-'.$month.'-'.$day;
			$now 		= Carbon::now();

			Approve::insert(
				array( 
			    	'name' 			=> $inputData['username'],
			    	'birthday'		=> $birthday,
			    	'idNumber'		=> $inputData['IdeID'],
			    	'schoolID'		=> $inputData['schoolID'],
			    	'cardFront'		=> $cardFrontPath,
			    	'cardBack'		=> $cardBackPath,
			    	'created_at'	=> $now,
			    	'email'			=> $email,
			    	'stuOrNot'		=> $inputData['stuOrNot']
			    	)
				);
			//$record = Approve::where('schoolID', '=', $inputData['schoolID'])->first();

			$this->sendMailToApproveManager($inputData['schoolID']);

			return Redirect::to('waitCCReply');
		} 
		catch (Exception $e) 
		{
			return Redirect::back()
					->withInput()
						->with(array(
							'serverError'	=> Lang::get('forgetpass/forgetBackupMail.networkOrServerError'),
							));
		}
	}

	public function sendMailToApproveManager($schoolID)
	{
		$email 				= ApproveManager::getEmail();
		$data['receivers'] 	= array($email);
		$data['subject'] 	= "有一筆新的忘記密碼代審核資料！(".$schoolID.") (".Carbon::now().")";
		$data['mailView'] 	= 'emails.newApproveDataRemind';
		$data['mailViewData'] = [
			'schoolID' 	=> $schoolID,
			'now'		=> "".Carbon::now(),
		];
		
		$this->dispatch(new SendMail($data));
	}
	
	/**********************************************
		form submit 及 server 再次驗證
	***********************************************/
	public function validationInside()
	{
		$inputData = Input::all();
		$rules = array();

		$ruleOne = array(
			'email',
			'required'
	         	);
		$ruleEmail = array('email' => $ruleOne);
		$rules = array_merge($rules, $ruleEmail);

		$rules = array(
				'email' 	=> array(
		         	'required',
		         	'email',
		         	), 
				'cardFrontPath' 	=> array(
		         	'required', // 不能空白
		         	),
				'cardBackPath' 	=> array(
		         	'required', // 不能空白
		         	),
		    );

	    $validator = Validator::make($inputData, $rules);

	    if ($validator->fails())
	    {
	    	$returnData = array(
	    		'status' 	=> 'fail',
	    		'error'		=> $validator->getMessageBag()->toArray()
	    		);
			return json_encode($returnData);

	    } else 
	    {
	    	$returnData = array(
	    		'status' 	=> 'pass',
	    		);
			return json_encode($returnData);
	    }

	    $returnData = array(
	    		'status' 	=> 'pass',
	    		);
			return json_encode($returnData);
	}

	/**********************************************
		即時驗證
	***********************************************/
	public function validation()
	{
		$returnData = array(
	    		'status' 	=> 'pass',
	    		);
		$inputData = Input::all();
		$rules = array();

		$ruleOne = array(
			'email',
	         	);
		$ruleEmail = array('email' => $ruleOne);
		$rules = array_merge($rules, $ruleEmail);


	    $validator = Validator::make($inputData, $rules);

	    if ($validator->fails())
	    {
	    	$returnData = array(
	    		'status' 	=> 'fail',
	    		'error'		=> $validator->getMessageBag()->toArray()
	    		);
			return json_encode($returnData);

	    } else 
	    {
	    	$returnData = array(
	    		'status' 	=> 'pass',
	    		);
			return json_encode($returnData);
	    }
	}

	/*************************************************
		身分證上傳及其驗證
	**************************************************/

	public function imageUpload()
	{
		$imgArray 			= array();
		$newUpFilePath		= '';
		$newDownFilePath	= '';

	    date_default_timezone_set('Asia/Taipei'); 
	    $now = Carbon::now();
	    //$date = Carbon::now()->addSeconds(10);

	    $file;
	    $fileName;
	    $schoolID 		= Input::get('schoolID');
	    $inputUpDown 	= '';
	    $fileSize		= '';
	    $isSmallEnough	= 0;
	    $isExtCorrect	= 0;

	    /*****************************
	    	身分證正面 上傳
	    ******************************/
	    if (Input::hasFile('fileup'))
	    {
	    	$file 				= Input::file('fileup');
	    	$inputUpDown 		= 'up';
	    	$fileExt			= $file->getClientOriginalExtension();
	    	
	    	$validExt 	= array('jpg', 'JPG', 'png', 'PNG');

	    	for($i = 0; $i < sizeof($validExt); $i++)
	    	{
	    		if($fileExt == $validExt[$i])
		    	{
		    		/*
						是否為合法附檔名
		    		*/
		    		$isExtCorrect = 1;
		    		break;
		    	}
	    	}

	    	/*************************************
	    		取得上傳檔案檔名
	    		修改檔名為: 學號_up/down_時間_附檔名
	    	**************************************/
	    	$fileName 			= $file->getClientOriginalName();
	    	$newFileName 		= $schoolID."_".$inputUpDown."_".$now.".".$fileExt;

	    	/*
	    	$imgFile 	= array();
		    $imgFile 	= glob("upload/approvePicture/{*.JPG,*.jpg,*.PNG,*png}", GLOB_BRACE);    
			//將 upload 中的這些附檔名的所有檔案之名稱存在陣列中
		    
		    $fileCount 	= sizeof($imgFile);

	    	for($i = 0; $i < $fileCount; $i++)
		    {
		    	if(strpos($imgFile[$i], $schoolID."_up") != false)
		    	{	
					//判斷檔名是否包含 100502062_up
		    		
		    		try{
			    		unlink($imgFile[$i]);
			    		// 刪除舊檔
			    	}catch(Exception $e){

			    	}
		    	}
		    }
		    */

			$oldFilePath		= 'upload/approvePicture/'.$fileName;
			$newUpFilePath 		= 'upload/approvePicture/'.$newFileName;

			$fileSize 			= $file->getSize();
			
			$twoMB = 2 * pow(2, 20); // 2 * 2^20 byte = 2 * 2*10 KB = 2 MB
			if($fileSize <= $twoMB)
			{
				/*
					限制檔案大小 < 2 MB
				*/
				$isSmallEnough = 1;
			}

			$checkFlag = $isSmallEnough * $isExtCorrect;

			if($checkFlag == 1)
			{
				$file->move('upload/approvePicture/', $fileName);
				rename($oldFilePath, $newUpFilePath);
			}
		}

		/*****************************
	    	身分證反面 上傳
	    ******************************/
		elseif(Input::hasFile('filedown'))
		{
			$inputUpDown 		= 'down';
			$file 				= Input::file('filedown');
			$fileExt			= $file->getClientOriginalExtension();

			$validExt 	= array('jpg', 'JPG', 'png', 'PNG');

	    	for($i = 0; $i < sizeof($validExt); $i++)
	    	{
	    		if($fileExt == $validExt[$i])
		    	{
		    		/*
						是否為合法附檔名
		    		*/
		    		$isExtCorrect = 1;
		    		break;
		    	}
	    	}

			$fileName 			= $file->getClientOriginalName();
	    	$newFileName 		= $schoolID."_".$inputUpDown."_".$now.".".$fileExt;

	    	/*
			$imgFile 	= array();
		    $imgFile 	= glob("upload/approvePicture/{*.JPG,*.jpg,*.PNG,*png}", GLOB_BRACE);
		    
			//將 upload 中的這些附檔名的所有檔案之名稱存在陣列中
		    
		    $fileCount 	= sizeof($imgFile);

	    	for($i = 0; $i < $fileCount; $i++)
		    {
		    	if(strpos($imgFile[$i], $schoolID."_down") != false)
		    	{
						//判斷檔名是否包含 100502062-down
		    		try{
			    		unlink($imgFile[$i]);
			    	}catch(Exception $e){

			    	}
		    	}
		    }
		    */

			$oldFilePath		= 'upload/approvePicture/'.$fileName;
			$newDownFilePath 	= 'upload/approvePicture/'.$newFileName;

			$fileSize 			= $file->getSize();

			$twoMB = 2 * pow(2, 20); // 2 * 2^20 byte = 2 * 2*10 KB = 2 MB
			if($fileSize <= $twoMB)
			{
				/*
					限制檔案大小 < 2 MB
				*/
				$isSmallEnough = 1;
			}

			$checkFlag = $isSmallEnough * $isExtCorrect;

			if($checkFlag == 1)
			{
				$file->move('upload/approvePicture/', $fileName);
				rename($oldFilePath, $newDownFilePath);
			}
	    }

		$imgArray[0]	= array(
							'isSmallEnough' => $isSmallEnough,
							'error'			=> 'the file size must be smaller than 2M',
						  );
		$imgArray[1] 	= $inputUpDown;
		$imgArray[2] 	= $fileSize;
		$imgArray[3]	= $fileExt;
		$imgArray[4]	= array(
							'isExtCorrect' => $isExtCorrect, //附檔名不合
							'error' => 'file extension is invalid',
							);

		$imgArray[5]	= $newFileName;
		$imgArray[6]	= $newUpFilePath;
		$imgArray[7]	= $newDownFilePath;
		
		return response()->json($imgArray);
	}
}
?>
