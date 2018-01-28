<?php

namespace App\Http\Controllers;

use \Auth;
use \DB;
use \Input;
use \Lang;
use \Redirect;
use \URL;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\ApproveID;

use App\Entities\DynamicLink;

use App\Entities\Email;
use App\Entities\User;

use App\Jobs\SendMail;

class confirmCorrectController extends Controller
{
	public function index()
	{
		if(Auth::check())
		{
			return Redirect::to('/');
		}else
		{
			return View::make('forgetpass.confirmCorrect');
		}
	}

	/*********************************************
		忘記備用信箱
	*********************************************/
	public function store()
	{
		$hiddenText	= explode(' ', Input::get('hiddenText'));
		
		$inputData = array(
		    'username'  => $hiddenText[0],
		    'schoolID'  => $hiddenText[1],
		    'IdeID'    	=> $hiddenText[2],
		    'wholeBir'	=> $hiddenText[3],
		    'stuOrNot'	=> $hiddenText[4]
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

		return Redirect::to('forgetBackupMail')->with($inputData);
	}

	/*********************************************
		記得備用信箱
		寄送驗證信件
		設定兩天內要收取驗證信件並重設密碼
	*********************************************/
	public function sendVerifyEmail()
	{
		try 
		{
			$schoolID 	= Input::get("schoolIDHiddenText");
			$stuOrNot 	= Input::get('stuOrNotHiddenText');

			$userInfo 	= User::where('acct', '=', $schoolID)->first();
			$emailInfo 	= Email::where('user_id', '=', $userInfo->id)->first();
			$email 		= $emailInfo->address;

			$approve_id = '-1'; // 此時為 記得備用信箱 => 不需要審核 => 設定 approve id = '-1'
			
			$frontUrl	= "https://sd.cc.ncu.edu.tw/forgetpass/verify/".$approve_id.'/'.$stuOrNot.'/';
			
			$data['acct']	= $schoolID;
			$data['due'] 	= Carbon::now()->addDays(2);
			$data['link'] 	= URL::to($frontUrl);

			$link = new DynamicLink();
			$link = $link->newDynamicLink($data['link'], $data['due'], $data['acct']);

			/******************************************************************************
				創建 approve id 提供後端待審核頁面辨識 changePassword table column 
				approve_id table 中有 changePassword id 可使用
				approve id 透過 url 傳送，初始的 changePassword id 為 (-1)
				當寫入 changePassword table 時更新為正確 changePassword id
			******************************************************************************/

/*
			$hashCode = explode('/', $link);
			$hashCode = $hashCode[count($hashCode) - 1];
*/

			$data['receivers'] 		= array($email);
			$data['subject'] 		= Lang::get('forgetpass/confirmCorrect.email.ncuValidationMail');
			$data['mailView'] 		= 'emails.forgetpassReply.forgetpassReply';
			$data['mailViewData'] 	= array(
				'link'		=> $link,
				'portal_id' => $schoolID
			);

			$this->dispatch(new SendMail($data));

			return Redirect::to('forgetPassMailSent');

			
		}
		catch (Exception $e)
		{
			return Redirect::back()
				->withInput()
					->with(array(
						'serverError'	=> Lang::get('forgetpass/confirmCorrect.networkOrServerError'),
						));
		}
	}


	/*********************************************
		信箱中驗證連結點選後 route 至此
	*********************************************/
	public function verifyEmail(Request $request)
	{
		// 取得驗證信件 url
		$currentLink = $request->url();

		/*************************************
			取出 url 之中的代表身分
		**************************************/
		$stuOrNot 		= '';
		$stuOrNotArray 	= array('alumni', 'staff', 'student');

		for($i = 0; $i < count($stuOrNotArray); $i++)
		{
			// strstr: 取出 參數1字串 中包含 參數2 及其之後至最後的片段字串
			// e.g.: you/Are/A/Student, Are => Are/A/Student
			$isInclude = strstr($currentLink, $stuOrNotArray[$i]);
			if($isInclude != null)
			{
				// 分割字串存於陣列中(依據 / 分割)
				$temp = explode("/", $isInclude);
				$stuOrNot = $temp[0];
				break;
			}
		}

		/*************************************
			取得 url 中包含的 approved_id
		**************************************/
		$temp2 = explode("/", $currentLink);
		$approve_id = $temp2[5];


		$now = Carbon::now();
		/*************************************
			檢查網頁資料庫中是否有此筆連結
		**************************************/
		$record = DB::table('dynamic_link')->where('link', '=', $currentLink)->first();

		// 若存在此連結
		if($record)
		{
			// strtotime: 
			// 轉換自 January 1 1970 00:00:00 GMT 到 "現在" 的秒數
			$timeToNow  	= strtotime($now);
			$deadLine 		= DynamicLink::where('link', '=', $currentLink)->pluck('due');
			// 轉換自 January 1 1970 00:00:00 GMT 到 "死線" 的秒數
			$timeToDeadLine = strtotime($deadLine);
			// 尚未至連結失效時間

			if($timeToDeadLine >= $timeToNow)
			{

				/*******************************************************
					將建立的 approve id 等資料傳遞
				*******************************************************/
				$basicData;
				$basicData = array(
					'verifyLink' 	=> $currentLink,
					'stuOrNot'		=> $stuOrNot,
					'approve_id'	=> $approve_id,
					 );
				return Redirect::to('setNewPass')->with($basicData);;
			}else
			{
				echo '此連結已經超過 2 天未完成動作<br>';
				return Redirect::to('linkOutDated');
			}
		}else
		{
			echo '此連結不存在 可能是已經使用過或是隨便拼湊的網址<br>';
			return Redirect::to("linkFailed");
		}	
	}
}

?>