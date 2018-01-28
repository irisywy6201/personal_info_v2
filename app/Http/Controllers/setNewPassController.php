<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use \Auth;
use \Redirect;
use \Request;
use \Validator;
use \View;
use \Input;
use \Lang;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\ChangePassword;
use App\Entities\UserLogs;
use App\Entities\DynamicLink;
use App\Entities\ApproveID;

define ('PUBLIC_KEY_FILE', app_path() . '/sshKeys/forgetPass/public_key.pem');

/*
const ROLE_USER = 1;
const ROLE_FACULTY = 2;
const ROLE_STUDENT = 4;
const ROLE_ALUMNI = 8;

const ROLE_SUSPENSION = 16;
const ROLE_ANY_STUDENT = 32;

const ROLE_FACEBOOK = 64;
const ROLE_SYSUSER = 128;
const ROLE_ADMIN = 1024;

e.g.: 
role = 5
=> 1 + 5 = user + student

role = 3
=> 1 + 2 = user + faculty

role = 9
=> 1 + 8 = user + alumni
*/

class setNewPassController extends Controller
{
	public function index()
	{
		return View::make('forgetpass/setNewPass');
	}

	public function encrypt_message ($message, $publickey) 
	{
		openssl_public_encrypt ($message, $crypttext, $publickey); 
		return array (sha1 ($message), base64_encode ($crypttext));
	}


	/****************************************************************
		利用 session 傳遞的 verify link 比對資料庫資料取得學號
	****************************************************************/
	public function whoAreYou()
	{
		if (Auth::check())
		{
			$schoolID = Auth::user()->acct;
		}else
		{
			$verifyLink 	= preg_replace('/\s(?=)/', '', Input::get('whoAreYou'));
			$schoolID 		= DynamicLink::where('link', '=', $verifyLink)->pluck('acct');
		}
		

		$returnData = array(
			'schoolID' 		=> $schoolID,
			);

		return json_encode($returnData);
	}


	public function store()
	{
		$validationResult = Validator::make(['g-recaptcha-response' => Input::get('g-recaptcha-response')], ["g-recaptcha-response" => "required|recaptcha"]);
		if ($validationResult->passes()) 
		{
			try 
			{
				$this->validationInside();
			} catch (Exception $e) 
			{
				return Redirect::to('setNewPass')->withInput();
			}


			try 
			{
				$basicData	= explode(' ', Input::get("basicData"));
				$verifyLink	= $basicData[0];
				$approve_id = $basicData[2];

				if($approve_id == '')
				{
					// 若登入修改密碼 不會透過驗證信件 url 得到 approve_id => 設為不需要人工認證代號 '-1'
					$approve_id = '-1';
				}

			} catch (Exception $e) {
				
			}
			

			switch (Auth::check()) 
			{
				case 1: // 已登入 => 修改密碼
					// 只有忘記密碼(未登入)且忘記備用信箱才需要 approve_id，因為不需要人工驗證
					// approve_id 用於對照 changePassword 和 approve 兩個 table，才能在待審核頁面對照 changePassword 目前狀態

					$schoolID = Auth::user()->acct;
					break;

				case null: // 未登入 => 忘記密碼
					
					$schoolID 	= DynamicLink::where('link', '=', $verifyLink)->pluck('acct');
			
					// 無學號 直接輸入 setNewpass 網址者
					if($schoolID == null)
					{
						return Redirect::to('login');	
					}
					break;
			}


			// 去掉字中間可能有的空白 \s代表所有的空白字符，包括空格、製表符、換頁符等，(?=)代表向前查詢，整段的意思是找出所有的空白字符，並用 "" 取代掉
			$newPass 				= preg_replace('/\s(?=)/', '', Input::get('newPass'));
			$newPass_confirmation	= preg_replace('/\s(?=)/', '', Input::get('nenewPass_confirmationwPass'));

			$now 					= Carbon::now();

			$pubkey 				= file_get_contents (PUBLIC_KEY_FILE);
			$checksum 				= $this->encrypt_message($newPass, $pubkey)[0];
			$encodePass 			= $this->encrypt_message($newPass, $pubkey)[1];

			/*********************************************************
				透過 url 中擷取的 approve id 讓 approve_id table
				中的 changePassword column 修正為對應正確值
				(approveID model 中預設為 -1)
			**********************************************************/

			// 1. 將資料加入 changePassword table
			// 2. 刪除對應的 dynamic link

			$cpDB 					= new ChangePassword;
			$cpDB->schoolID 		= $schoolID;
			$cpDB->created_at		= $now;
			$cpDB->checksum			= $checksum;
			$cpDB->encodePassword	= $encodePass;
			$cpDB->status 			= 0;
			$cpDB->approved_id 		= $approve_id;
			$cpDB->save();
			
			if (Auth::guest())
			{
				DynamicLink::where("link", "=", $verifyLink)->delete();
			}
			
			$this->writeLog($now, $schoolID);
			
			return Redirect::to("newPassSet");
			
			
		}else
		{
			return Redirect::back()->withErrors($validationResult)->withInput()->with(
			[
				'feedback' => 
				[
					'type' => 'danger',                                                
					'message' => Lang::get('forgetpass/setNewPass.recaptchaFail'),
				]
			]);  
		}
	}

	public function writeLog($time, $schoolID)
	{
		$myip = Request::getClientIp();
		echo "<br>".$myip;

		$userLog = new UserLogs;
		$userLog->log_type_id	= 1; // 0 = login, 1 = changePass, 2 = changeMail
		$userLog->portal_id		= $schoolID;
		$userLog->created_at	= $time;
		$userLog->ip 			= $myip;

		$userLog->save();
	}

	/****************************************

	*****************************************/
	public function validationInside()
	{
		$inputData = Input::all();
		// 去掉空格
		$myid = preg_replace('/\s(?=)/', '', Input::get('myid'));
		$stuOrNot 	= Input::get('stuOrNot');

		$rules = array(
			'newPass_confirmation' 	=> array(
				'required', // 不能空白
				'min: 8', // 至少要有 8 個字
				'regex: /^((?!'.$myid.').)*$/', // 教職員密碼不能包含帳號
				'regex: /^[A-Z]/', // 開頭要大寫英文
				'regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', // 至少要有一個大寫英文 一個小寫英文 一個數字
				'regex: /^.[A-Za-z0-9]+$/', // 只能由英文和數字組成
				), 

			'newPass' 	=> array(
				'required', // 不能空白
				'min: 8', // 至少要有 8 個字
				'regex: /^((?!'.$myid.').)*$/', // 教職員密碼不能包含帳號
				'regex: /^[A-Z]/', // 開頭要大寫英文
				'regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/',// 至少要有一個大寫英文 一個小寫英文 一個數字
				'regex: /^.[A-Za-z0-9]+$/',
				'confirmed',
				), 
		);

	   $validator = Validator::make($inputData, $rules);

	   if ($validator->fails())
		{
			$returnData = array(
				'myid'		=> 'myid: '.$myid,
				'status' 	=> 'fail',
				'error'		=> $validator->getMessageBag()->toArray()
				);
			return json_encode($returnData);

		} else 
		{
			$returnData = array(
				'status' 	=> 'pass',
				'myid'		=> 'myid: '.$myid
				);
			return json_encode($returnData);
		}
	}

	/****************************************
		即時驗證 密碼 && 再次輸入密碼
	*****************************************/
	public function validation()
	{
		$inputData 	= Input::all();
		$rules 		= array();
		$stuOrNot 	= Input::get('stuOrNot');

		/****************************************
			教職員的密碼不能包含帳號
		*****************************************/
		// 去掉空格
		$myid 		= preg_replace('/\s(?=)/', '', Input::get('myid'));

		$ruleONe 	= array(
			'required', // 不能空白
			'min: 8', // 至少要有 8 個字
			'regex: /^[A-Z]/', // 開頭要大寫英文
			'regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/', // 至少要有一個大寫英文 一個小寫英文 一個數字
			'regex: /^.[A-Za-z0-9]+$/', // 只能由英文和數字組成
				);

		$ruleTwo 	= array(
			'required', // 不能空白
			'min: 8', // 至少要有 8 個字
			'regex: /^[A-Z]/', // 開頭要大寫英文
			'regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/',// 至少要有一個大寫英文 一個小寫英文 一個數字
			'regex: /^.[A-Za-z0-9]+$/', // 只能由英文和數字組成
			);

		/********************************
			若為教職員 加入下列規則:
			密碼不可以包含帳號
			(但是只要大小寫不同就可以)
		*********************************/
		if($stuOrNot == 'staff')
		{
			array_push($ruleONe, 'regex: /^((?!'.$myid.').)*$/');
			array_push($ruleTwo, 'regex: /^((?!'.$myid.').)*$/');
		}

		$ruleNewPass 				= array('newPass' => $ruleONe);
		$ruleNewPassConfirmation 	= array('newPass_confirmation' => $ruleTwo);

		if(Input::has('newPass'))
		{
			$rules = array_merge($rules, $ruleNewPass);
		}

		if(Input::has('newPass_confirmation'))
		{
			$rules = array_merge($rules, $ruleNewPassConfirmation);
		}

		$validator = Validator::make($inputData, $rules);

		if ($validator->fails())
		{
			$returnData = array(
				'myid'		=> 'myid: '.$myid,
				'status' 	=> 'fail',
				'error'		=> $validator->getMessageBag()->toArray()
				);
			return json_encode($returnData);
		} else 
		{
			$returnData = array(
				'status' 	=> 'pass',
				'myid'		=> 'myid: '.$myid
				);
			return json_encode($returnData);
		}
	}
}

?>