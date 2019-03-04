<?php

namespace App\Http\Controllers;

use \Auth;
use \DB;
use \Input;
use \Redirect;
use \URL;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Jobs\SendMail;

define ("LDAP_HOST",     "ldap://140.115.17.30");
define ("LDAP_HOSTNAME", "tiger");
define ("LDAP_BASE",     "dc=cc,dc=ncu");

class changePassController extends Controller
{
	public function index()
	{
		if (Auth::check())
		{
			return View::make("changePass.changePass");
			
		}else
		{
			return Redirect::to('login');
		}
	}

	public function NcuDBConnection($IdeID, $stuOrNot)
	{
		$serverData = array(
			"userName"	=> "",
			"schoolID"	=> "",
			"IdeID"	=> "",
			"BirYear"	=> "",
			"BirMon"	=> "",
			"BirDay"	=> ""
		);

		$serverIP		= "140.115.182.214";
		$userName 		= "app_servicedesk";
		$pw 			= "57555@cc.ncu";
		$dbName			= "ncu_member";

		$connect_db 	= mssql_connect($serverIP, $userName, $pw) or die ("db connecting fail");
		$selected 		= mssql_select_db($dbName, $connect_db) or die ("db can't open");
		
		$serverData["IdeID"]	= $IdeID;
		echo $serverData["IdeID"]."<br>";

		switch($stuOrNot)
		{
			/* 

				身分證字號 找 portal id

			*/
			case "student":
				$selected 		= "portal_id";
				$tableName		= "student_info";
				$columnName		= "personal_no";
				$equalTo 		= "'".$IdeID."'";

				$query 			= "SELECT ".$selected;
				$query 			= $query." FROM ".$tableName; 
				$query 			= $query." WHERE ".$columnName;
				$query 			= $query."=".$equalTo;	

				$result			= mssql_query($query);
				$db_schoolID 	= array();
				$db_schoolID 	= mssql_fetch_array($result);

				$serverData["schoolID"] 	= $db_schoolID[0];
				echo $serverData["schoolID"]."<br>";
			break;

			case "staff": 

				$selected 		= "portal_id";
				$tableName		= "staff_info";
				$columnName		= "staff_personal_no";
				$equalTo 		= "'".$IdeID."'";

				$query 			= "SELECT ".$selected;
				$query 			= $query." FROM ".$tableName; 
				$query 			= $query." WHERE ".$columnName;
				$query 			= $query."=".$equalTo;	

				$result			= mssql_query($query);
				$db_schoolID 	= array();
				$db_schoolID 	= mssql_fetch_array($result);

				$serverData["schoolID"] 	= $db_schoolID[0];
				echo $serverData["schoolID"]."<br>";	
			break;

			case "alumni":
				$selected 		= "portal_id";
				$tableName		= "schoolmate_info";
				$columnName		= "personal_no";
				$equalTo 		= "'".$IdeID."'";

				$query 			= "SELECT ".$selected;
				$query 			= $query." FROM ".$tableName; 
				$query 			= $query." WHERE ".$columnName;
				$query 			= $query."=".$equalTo;	

				$result			= mssql_query($query);
				$db_schoolID 	= array();
				$db_schoolID 	= mssql_fetch_array($result);

				$serverData["schoolID"] 	= $db_schoolID[0];	
				echo $serverData["schoolID"]."<br>";	
			break;
		}

		/*
		**
			use Identify ID to search chinese name
		**
		*/

		$selected2 		= "cname";
		$tableName2		= "basicinfo";
		$columnName2	= "personal_no";
		$equalTo2 		= "'".$IdeID."'";

		$query2 		= "SELECT ".$selected2;
		$query2 		= $query2." FROM ".$tableName2; 
		$query2 		= $query2." WHERE ".$columnName2;
		$query2			= $query2."=".$equalTo2;	

		$result2		= mssql_query($query2);
		$db_userName 		= array();
		$db_userName 		= mssql_fetch_array($result2);

		$serverData["userName"]	= $db_userName[0];
		echo $serverData["userName"]."<br>";

		
		/*
		**
			use Identify ID to search birthday
		**
		*/
		$selected3 		= "birthday";
		$tableName3		= "basicinfo";
		$columnName3	= "personal_no";
		$equalTo3 		= "'".$IdeID."'";

		$query3 		= "SELECT ".$selected3;
		$query3 		= $query3." FROM ".$tableName3; 
		$query3 		= $query3." WHERE ".$columnName3;
		$query3			= $query3."=".$equalTo3;	

		$result3		= mssql_query($query3);
		$db_stBir 		= array();
		$db_stBir 		= mssql_fetch_array($result3);

		$stBir_arr 		= array();
		$stBir_arr 		= str_split($db_stBir[0]);

		$init_bir				 	= $stBir_arr[1].$stBir_arr[2];
		$bir_BC 					= (int)$init_bir + 1911;

		$serverData["BirYear"] 		= (string)$bir_BC;
		$serverData["BirMon"]		= $stBir_arr[3].$stBir_arr[4];
		$serverData["BirDay"]		= $stBir_arr[5].$stBir_arr[6];
		
		echo $serverData["BirYear"]."<br>";
		echo $serverData["BirMon"]."<br>";
		echo $serverData["BirDay"]."<br>";
		
		return $serverData;
	}
	

	public function store()
	{

		$inputData = array(
				/*"userName"		=> Input::get("username"),
				"schoolID"		=> Input::get("schoolID"),
				"IdeID"			=> Input::get("identifyNumber"),
				"BirYear"		=> Input::get("year"),
				"BirMon"		=> Input::get("month"),
				"BirDay"		=> Input::get("day"),
				"newPass"		=> Input::get("newPass"),*/
				"stuOrNot"		=> Input::get("identity"),
				"oldPass"		=> Input::get("oldPass")
			);
			$schoolID 	= Auth::user()->acct;
			$email 		= Auth::user()->email;
			$stuOrNot	= $inputData["stuOrNot"];

		try
		{
			$inputData = array(
				/*"userName"		=> Input::get("username"),
				"schoolID"		=> Input::get("schoolID"),
				"IdeID"			=> Input::get("identifyNumber"),
				"BirYear"		=> Input::get("year"),
				"BirMon"		=> Input::get("month"),
				"BirDay"		=> Input::get("day"),
				"newPass"		=> Input::get("newPass"),*/
				"stuOrNot"		=> Input::get("identity"),
				"oldPass"		=> Input::get("oldPass")
			);
			$oldPass 	= $inputData["oldPass"];
			$schoolID 	= Auth::user()->acct;
			$stuOrNot	= $inputData["stuOrNot"];
			//$IdeID		= $inputData["IdeID"];

			//$dbData = $this->NcuDBConnection($IdeID, $stuOrNot);

			//if($this->newCheck($dbData, $inputData) == 1)// 當帳密符合資料庫資料時
			if($this->newCheck($schoolID, $oldPass) == 1)
			{
				$this->sendVerifyEmail($schoolID, $email, $stuOrNot);

				return Redirect::to('passChanged');

			}else// 輸入資料和資料庫不符
			{
				echo "輸入資料和資料庫不符<br>";
				return Redirect::to('changePass')->with('error', "error")->withInput();
			}
		}catch (Exception $e) 
		{
			return Redirect::to('changePass')->with('error', "error")->withInput();
		    //echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}

	public function verifyEmail()
	{
		$createTime = date ("Y-m-d H:i:s" , mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')));
		$record = DB::table('changePassword')->where('schoolID', '=', $inputData["schoolID"])->first();

		if($record)
		{
			// 若還沒收驗證信就重新做一次更新密碼

			DB::table('changePassword')->where('schoolID', '=', $inputData["schoolID"])
	            ->update(
	           		array(
		            	//'schoolID' 		=> $inputData["schoolID"], 
		            	'schoolID' 		=> $schoolID,
				    	'pwNew' 		=> $inputData["newPass"],
				    	'stuOrNot'		=> $inputData["stuOrNot"],
				    	'created_at'	=> $createTime
		            	)
	            );
	            
		}else
		{
			// 無 連續兩次操作更新密碼 卻沒收驗證信

			DB::table('changePassword')->insert(
			    array(
			    	'schoolID' 		=> $inputData["schoolID"], 
			    	'pwNew' 		=> $inputData["newPass"],
			    	'stuOrNot'		=> $inputData["stuOrNot"],
			    	'created_at'	=> $createTime
			    	)
				);
		}
	}

	public function sendVerifyEmail($schoolID, $email, $stuOrNot)
	{
		$frontUrl	= "changePass/verify/".$stuOrNot;
		
		$data['acct']	= $schoolID;
		$data['due'] 	= Carbon::now()->addDays(2);
		$data['link'] 	= URL::to($frontUrl);
		$link = app()->make('DynamicLinkController')->callAction('store', [$data]);
		//$data['subject'] = Lang::get('email.newMessage.subject');

		$data['receivers'] = array($email);
		$data['subject'] = "subject";
		$data['mailView'] = 'emails.changePassReply.changePassReply';
		$data['mailViewData'] = array(
			'link'	=> $link
		);
		
		$this->dispatch(new SendMail($data));

		return Redirect::to('forgetPassMailSent');
	}

	public function newCheck($schoolID, $oldPass)
	{
		$correct_bool		= 1;
		$passTrueOrFalse 	= $this->ldap_authentication($schoolID, $oldPass);

		if($passTrueOrFalse == false)
		{
			echo "密碼錯啦<br>";
			$correct_bool = 0;
		}

		return $correct_bool;
	}

	public function check($dbData, $inputData)
	{
		$correct_bool	= 1;

		$index_arr		= array();
		$index_arr[0]	= "userName";
		$index_arr[1]	= "schoolID";
		$index_arr[2]	= "IdeID";
		$index_arr[3]	= "BirYear";
		$index_arr[4]	= "BirMon";
		$index_arr[5]	= "BirDay";
		$arr_length 	= sizeof($index_arr);

		for($i = 0; $i < $arr_length; $i++)
		{
			if($dbData[$index_arr[$i]] != $inputData[$index_arr[$i]])
			{
				$correct_bool = 0;
				break;
			}
		}

		$pass 				= $inputData["oldPass"];
		$schoolID 			= $inputData["schoolID"];
		echo "pass: ".$pass."<br>";
		echo "school id: ".$schoolID."<br>";
		$passTrueOrFalse 	= $this->ldap_authentication($schoolID, $pass);

		if($passTrueOrFalse == false)
		{
			echo "密碼錯啦<br>";
			$correct_bool = 0;
		}
		echo "check bool !!!!!: ".$correct_bool."<br>";
		return $correct_bool;
	}

	public function ldap_authentication($user, $pass) 
	{
		if (empty ($basedn)) 
		{
			//echo "base dn is empty !!<br>";
			$basedn = LDAP_BASE;
		}

		if (! preg_match("/^[_a-zA-Z0-9]+$/", $user))
		{
			//echo "preg format not match !!<br>";
			return false;
		}

		$ds = @ldap_connect (LDAP_HOST);
		$dn = sprintf ("uid=%s,ou=People,%s", $user, $basedn);
		$cn = false;
 
		if ($ds) 
		{
			echo "connectd ladp !! <br>";
			@ldap_set_option ($ds, LDAP_OPT_REFERRALS, 0);
			//@ldap_set_option ($ds, LDAP_OPT_HOST_NAME, LDAP_HOSTNAME);
 			
 			//echo "my ip address: ".$_SERVER["REMOTE_ADDR"]."<br>"; 
			
			if (! @ldap_set_option ($ds, LDAP_OPT_PROTOCOL_VERSION, 3)) 
			{
				echo "Not Using LDAPv3 !! <br>";
			} else if (@ldap_bind ($ds, $dn, $pass))
			{
				echo "bind success!! <br>";
				$cn = $user;
 
				$sr = ldap_search($ds, $basedn, "uid=".$user);
 
				if (($cnt = ldap_count_entries($ds, $sr)) == 1) 
				{
					$info = ldap_get_entries ($ds, $sr);
					$cn = $info[0]["cn"][0];
				}

			}else
			{
				echo "using LDAPv3 && bind fail !! <br>";
			}
			@ldap_close ($ds);
		}
		return $cn;
	}
}

?>