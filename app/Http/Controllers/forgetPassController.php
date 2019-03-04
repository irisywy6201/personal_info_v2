<?php

namespace App\Http\Controllers;

use \Auth;
use \Queue;
use \Redirect;
use \Validator;
use \View;
use Lang;
use App\Entities\User;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StaffEmail\Api_v0_StaffAccountRequest;

use App\Entities\Approve;

use App\Entities\ChangePassword;
use App\Entities\NcuRemoteDB;
use App\Entities\ApproveManager;

use App\Jobs\SendMail;


class forgetPassController extends Controller
{
	public function index()
	{
		if (Auth::check()) {
			return Redirect::to('setNewPass');
		}
		else {
			return View::make('forgetpass.forgetpass');
		}
	}

	/******************************************
		submit 送出前的檢驗及進入伺服器後再次檢驗
	*******************************************/
	public function validationInsideWithEmail()
	{
		$inputData = Input::all();
		$rules = array(
			'username' 			=> array(
	         	'required', // 不能空白
	         	),
			'schoolID' 			=> array(
	         	'required', // 不能空白
	         	),
			'identifyNumber' 	=> array(
	         	'required', // 不能空白
	         	'regex: /^[A-Z]{1}[1-2]{1}[0-9]{8}$/',
	         	// 身分證字首大寫英文(地區) + 1 or 2 (性別) + 8 個任意數字
	         	),
			'datepicker' 		=> array(
	         	'required', // 不能空白
	         	),
			'email'				=> array(
				'required',
				'email',
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
	}

	/******************************************
		submit 送出前的檢驗及進入伺服器後再次檢驗
	*******************************************/
	public function validationInside()
	{
		$inputData = Input::all();
		$rules = array(
			'username' 			=> array(
	         	'required', // 不能空白
	         	),
			'schoolID' 			=> array(
	         	'required', // 不能空白
	         	),
			'identifyNumber' 	=> array(
	         	'required', // 不能空白
	         	'regex: /^[A-Z]{1}[1-2]{1}[0-9]{8}$/',
	         	// 身分證字首大寫英文(地區) + 1 or 2 (性別) + 8 個任意數字
	         	),
			'datepicker' 		=> array(
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
	}

	/******************************************
		// 前端 ajax 即時驗證
	*******************************************/
	public function validation()
	{

		$inputData = Input::all();
		$rules = array();

		$ruleOne = array(
			'regex: /^[A-Z]{1}[1-2]{1}[0-9]{8}$/',
			// 字首大寫英文(地區) + 1 or 2 (性別) + 8 個任意數字
			);
		$ruleIdentifyNumber = array('identifyNumber' => $ruleOne);

		// 目前只有身分證字號會驗證格式 日後若有其他驗證項目加入 ruleTwo ruleThree

		if(Input::has('identifyNumber'))
		{
			$rules = array_merge($rules, $ruleIdentifyNumber);
		}


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

	/******************************************
		忘記密碼因為任何原因失敗
		=> 寄信給計中 ncucc@g.ncu.edu.tw
	*******************************************/
	public function forgetpassFail()
	{

		// json_decode 預設解成 object 格式 加上 true 之後可變成 array
		$status = json_decode($this->validationInsideWithEmail(), true)['status'];
		// 通過 validation 檢驗
		if( $status == 'pass')
		{
			// 成功寄出信件
			if( $this->sendForgetpassFailMail(Input::all()) == 'emailSent')
			{
				$data = json_decode($this->validationInsideWithEmail(), true);
				$data['mailStatus'] = 'passMail';
				$data['mailMessage'] = Lang::get('forgetpass/forgetpass.mail.mailSent');
				return json_encode($data);
			}else
			{
				// 寄出信件失敗
				$data = json_decode($this->validationInsideWithEmail(), true);
				$data['mailStatus'] = 'failMail';
				$data['mailMessage'] = Lang::get('forgetpass/forgetpass.mail.networkOrServerError');
				return json_encode($data);;
			}
		}else
		{
			// 未通過 validation 檢驗
			return $this->validationInsideWithEmail();
		}
	}

	public function sendForgetpassFailMail($inputData)
	{
		try
		{
			$CCEmail 		= ApproveManager::getEmail();

			$data['receivers'] 		= array($CCEmail);
			$data['subject'] 		= 'serviceDesk '.$inputData['username'].Lang::get('forgetpass/forgetpass.mail.modifyMailFail');
			$data['mailView'] 		= 'emails.forgetpassReply.forgetpassFail';
			$data['mailViewData'] 	= array(
				'username'	=> $inputData['username'],
				'wholeBir'	=> $inputData['datepicker'],
				'Ideid'		=> $inputData['identifyNumber'],
				'schoolID'	=> $inputData['schoolID'],
				'stuOrNot'	=> $inputData['stuOrNot'],
				'email'		=> $inputData['email'],
				'phone'		=> $inputData['phone'],
			);

			$this->dispatch(new SendMail($data));
			return 'emailSent';
		}
		catch (Exception $e)
		{
			return 'emailNotSent';
		}
	}

	/******************************************
		利用 身分證字號 及 教職員 學生 校友
		身分取得計中資料庫資料
		稍後於 check function 比對正確性
	*******************************************/
	public function NcuDBConnection($IdeID, $stuOrNot)
	{
		$serverData = array(
			"username"	=> '',
			"schoolID"	=> '',
			"IdeID"		=> '',
			"wholeBir"	=> '',
		);

		$serverData['IdeID'] = $IdeID;

		// 計中資料庫
		$remoteDB = new NcuRemoteDB;

		/************************************************************
			取得帳號(本國)
			(外國人不用輸入身分證 因此不要用身分證查學號)
		*************************************************************/
		switch($stuOrNot)
		{
			case 'student':
				echo "使用者為學生 查詢 portal id (和學號相同)<br>";
				$remoteDB->setTable('student_info');
				$DB_portal_id 			= $remoteDB->where('personal_no', '=', $IdeID)->pluck('s_id');
				$serverData['schoolID'] = $DB_portal_id;
			break;

			case 'staff':
				echo '使用者為教職員 查詢 email 帳號<br>';

				$resultCode = $this->ideIdToEmail($IdeID)['resultCode'];
				if($resultCode != 'nullCode')
				{
					if($resultCode < 300)
					{
						echo '教職員只擁有一個中央大學帳號<br>';
						$email 					= $this->ideIdToEmail($IdeID)['mailAccount'];
						$serverData['schoolID'] = $email;
					}else
					{
						echo '擁有多組帳號之教職員<br>';
						$serverData['schoolID'] = 'multipleAccountError';
					}
				}else
				{
					echo 'server error (取得教職員 email 失敗)<br>';
					$serverData['schoolID'] = 'serverError';
				}

			break;

			case 'alumni':
				echo '使用者為校友<br>';
				$remoteDB->setTable('schoolmate_info');
				$DB_portal_id 			= $remoteDB->where('personal_no', '=', $IdeID)->pluck('s_id');
				$serverData["schoolID"] = $DB_portal_id;
			break;
		}

		/******************************************
			取得姓名
		*******************************************/
		$remoteDB->setTable('basicinfo');
		$DB_username = $remoteDB->where('personal_no', '=', $IdeID)->pluck('cname');

		// 去掉字中間可能有的空白 \s代表所有的空白字符，包括空格、製表符、換頁符等，(?=)代表向前查詢，整段的意思是找出所有的空白字符，並用 "" 取代掉
		$serverData["username"] = preg_replace('/\s(?=)/', '', $DB_username);

		/******************************************
			取得生日
		*******************************************/
		$remoteDB->setTable('basicinfo');
		$DB_birthday = $remoteDB->where('personal_no', '=', $IdeID)->pluck('birthday');


		// 若 databse 生日第一個數字(年份)為 0 (e.g.: 081) => 去掉開頭的 0
		if(substr($DB_birthday, 0, 1) == '0')
		{
			$DB_birthday = substr($DB_birthday, 1);
		}
		$serverData["wholeBir"] = $DB_birthday;

		return $serverData;
	}

	function sendRequest($url, $data)
	{
		return file_get_contents ($url, false, stream_context_create ([
			'http' => [
				'header'  => 'Content-type: application/json',
				'method'  => 'GET',
				'content' => json_encode ($data)
			]
		]));
	}

	/******************************************
		教職員 email 資料並不在計中資料庫
		需要利用身分證字號至人事室資料庫
		取得相對應 email 帳號
	*******************************************/
	public function ideIdToEmail($IdeID)
	{
		$data = new Api_v0_StaffAccountRequest();
		$data->personal_no = $IdeID;
		$returnData = array();

		$ret = $this->sendRequest("https://googleapp.ncu.edu.tw/GoogleApps/api/v0/getSparcByPid", $data);
		$result = json_decode ($ret);
		$mailAccount = '';
		if ($result != null)
		{
			if ($result->code < 300)
			{
				echo '教職員 email 資料取得成功<br>';
				$sparc = json_decode (base64_decode($result->message));
				$returnData['resultCode']	= $result->code;
				$returnData['mailAccount'] 	= $sparc->account;
				//echo "Account=" . $mailAccount . "\n";
				//echo "Host=" . $sparc->host. "\n";
				//echo "Quota=" . $sparc->quota. "\n";
				//echo "Setup_date=" . $sparc->setup_date. "\n";
			} else
			{
				echo '教職員 email server return code: '.$result->code . ' : ' . json_decode (base64_decode ($result->message)).'<br>';
				$returnData['resultCode']	= $result->code;
				$returnData['mailAccount'] 	= 'multipleAccountError';
			}
		}else
		{
			echo "教職員資料 json_decode failed!<br>";
			$returnData['resultCode']	= 'nullCode';
			$returnData['mailAccount'] 	= 'serverError';
		}
		return $returnData;
	}

	public function getLastEmail($schoolID)
	{
		// 取得資料庫中符合身分的 "最後一筆" (最新)資料的信箱
		$email = Approve::where('schoolID', '=', $schoolID)->orderBy('id', 'desc')->pluck('email');
		return $email;
	}

	public function thirtyMinuteLimit($schoolID)
	{
		// 取得資料庫中 "符合身分" 的 "最後一筆" (最新)資料的時間
		$created_at 	= ChangePassword::where('schoolID', '=', $schoolID)->orderBy('id', 'desc')->pluck('created_at');

		// 若存在記錄
		if($created_at != null)
		{
			$now 				= Carbon::now();

			$timeToNow 			= strtotime($now);
			$timeToCreate		= strtotime($created_at);

			// 加上 30 分鐘 = 60 * 30 = 1800(second)
			$timeTo30MinAfter	= $timeToCreate + 1800;
			echo 'now:				'.$now.'<br>';
			echo 'timeToNow:		'.$timeToNow.'<br>';
			echo 'timeToCreate:		'.$timeToCreate.'<br>';
			echo 'timeTo30MinAfter: '.$timeTo30MinAfter.'<br>';

			// 若在 30 分鐘之內(不可再次更改密碼)
			if($timeTo30MinAfter > $timeToNow)
			{
				return 0;
			}else
			{
				// 超過 30 分鐘
				return 1;
			}
		}else
		{
			// 若無記錄 => 可以更改
			return 1;
		}
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
				return Redirect::to('forgetpass')->withInput();
			}


	    	try
			{

				$inputData = array(
					'username'	=> Input::get('username'),
					'schoolID'	=> Input::get('schoolID'),
					'IdeID'		=> Input::get('identifyNumber'),
					'stuOrNot'	=> Input::get('identity'),
					'wholeBir'	=> Input::get('datepickerHide'),
				);

				/******************************************
					取得使用者輸入，查詢計中資料庫取得對應資料
				*******************************************/
				$dbData 	= $this->NcuDBConnection($inputData["IdeID"], $inputData["stuOrNot"]);

				if($dbData['schoolID'] == 'multipleAccountError')
				{
					return Redirect::back()
							->withInput()
								->with(array(
									'multipleAccount'	=> Lang::get('forgetpass/forgetpass.returnWrong.staffEmailWrong'),
									));
				}

				if($dbData['schoolID'] == 'serverError')
				{
					return Redirect::back()
							->withInput()
								->with(array(
									'serverError'	=> Lang::get('forgetpass/forgetpass.returnWrong.networkOrServerError'),
									));
				}

				/******************************************
					比對 使用者輸入 及 資料庫資料
				******************************************/
				if($this->check($dbData, $inputData) == 1)
				{
					// 資料正確

					// 30 分鐘內不得修改兩次密碼
					echo 'result: '.$this->thirtyMinuteLimit($inputData['schoolID']).'<br>';
	/*
					if($this->thirtyMinuteLimit($inputData['schoolID']) == 0)
					{
						$email = $this->getLastEmail($inputData['schoolID']);
						return Redirect::to('forgetpass')->withInput()->with(array(
							'thirtyMinLimit' 	=> Lang::get('forgetpass/forgetpass.noYet30Min'),
							'lastEmail'			=> $email,
							));
					}
*/
					$userInfo = User::where('acct', '=', $inputData["schoolID"])->first();

					if(count($userInfo) != 0)
					{
						// 以前有登入過 資料不為零 => 必然已經設定了備用信箱
						echo '有登入記錄<br>';
						return Redirect::to('confirmCorrect')->with($inputData);
					}
					else
					{
						// 以前沒有登入過(第一次嘗試登入就忘記密碼) 網站資料庫無對應資料
						// => 無備用信箱 => 人工審核
						// 意同於忘記密碼又忘記備用信箱
						echo '無登入記錄<br>';
						return Redirect::to('forgetBackupMail')->with($inputData);
					}
				}else
				{
					echo "輸入資料不正確<br>";
					if($inputData['stuOrNot'] == 'staff')
					{
						$returnArray = array(
								'inputDataWrong' => Lang::get('forgetpass/forgetpass.returnWrong.staffEmailWrong'));
					}else
					{
						$returnArray = array(
								'inputDataWrong' => Lang::get('forgetpass/forgetpass.returnWrong.inputWrong'));
					}
					return Redirect::back()
						->withInput()
							->with($returnArray);

				}
			}catch (Exception $e)
			{
				echo "syntex 或 internet 例外錯誤<br>";
				return Redirect::back()
							->withInput()
								->with(array(
									'serverError'	=> Lang::get('forgetpass/forgetpass.returnWrong.networkOrServerError'),
									));
			}

	    }else{

		    return Redirect::back()->withErrors($validationResult)->withInput()->with(
	    	[
		   		'feedback' =>
		 	    [
		 	    	'type' => 'danger',
		 	    	'message' => Lang::get('forgetpass/forgetpass.recaptchaFail'),
		 	    ]
		    ]);
	 	}
	}

	/******************************************
		比對 使用者輸入 及 資料庫資料
		先比對生日 學號 身分證字號
		中文文字需要判斷造字稍後比對
	******************************************/
	public function check($dbData, $inputData)
	{
		$correct_bool	= 1;
		$index_arr		= array();
		$index_arr[0]	= "wholeBir";
		$index_arr[1]	= "schoolID";
		$index_arr[2]	= "IdeID";

		for( $i=0; $i<sizeof($index_arr); $i++ )
		{
			echo "dbData: ".$dbData[$index_arr[$i]].'<br>';
			echo "inputData: ".$inputData[$index_arr[$i]]."<br>";
			if($dbData[$index_arr[$i]] != $inputData[$index_arr[$i]])
			{
				$correct_bool = 0;
				break;
			}
		}

		/******************************************
			造字中文處理(直接去掉不比對)
		******************************************/
		// 資料庫中的 username
		$DB_username = $dbData['username'];

		/******************************************
			mb_strlen 可取得字串長度
			分解字串存入 DB_usernameArray 陣列
			mb_substr: (0, 1) 第一個字 (1, 1) 第二個字 (2, 2)第三個字 (3, 3)第三個字
		******************************************/
		// 第一個字
		$DB_usernameArray = array(mb_substr($DB_username, 0, 1, 'utf-8'));
		for( $i=1; $i<mb_strlen($DB_username, 'utf-8'); $i++ )
		{
			// 第二個至最後一個字
			$DB_usernameSplit = mb_substr($DB_username, $i, $i, "utf-8");
			array_push($DB_usernameArray, $DB_usernameSplit);
		}


		/******************************************
			unicode 在 57344 ~ 63743 之間者為造字
		******************************************/
		// 建立非造字者陣列
		$notSpecialWordIndex = array();
		$nameUnicode = array();

		for( $i=0; $i<count($DB_usernameArray); $i++ )
		{
			// 轉成 unicode 存入 nameUnicode 陣列
			$temp = base_convert(bin2hex(iconv('UTF-8', 'UCS-4', $DB_usernameArray[$i])), 16, 10);
			array_push($nameUnicode, $temp);

			// 將非造字者之 index 儲存
			if($nameUnicode[$i] < 57344 || $nameUnicode[$i] > 63743)
			{
				array_push($notSpecialWordIndex, $i);
				echo $DB_usernameArray[$i].' $i: '.$i.'<br>';
				echo $nameUnicode[$i].' $i: '.$i.'<br>';
			}
		}

		/******************************************
			組合非造字者字串
			比對 使用者輸入 和 非造字字串
		******************************************/
		$notSpecialWord = '';
		for($i = 0; $i < count($notSpecialWordIndex); $i++)
		{
			$notSpecialWord = $notSpecialWord.$DB_usernameArray[$notSpecialWordIndex[$i]];
		}

		// 去掉字串中的空白
		$inputUsername = preg_replace('/\s(?=)/', '', $inputData['username']);
		echo '去掉造字之後的中文名稱：'.$notSpecialWord.'<br>';;

		if($notSpecialWord != $inputUsername)
		{
			$correct_bool = 0;
		}

		return $correct_bool;
	}
}

?>
