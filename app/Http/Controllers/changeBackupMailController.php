<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Redirect;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Jobs\SendMail;

define ("LDAP_HOST",     "ldap://140.115.17.30");
define ("LDAP_HOSTNAME", "tiger");
define ("LDAP_BASE",     "dc=cc,dc=ncu");

class changeBackupMailController extends Controller
{
	public function index()
	{
		if (Auth::check())
		{
			return View::make('changeBackupMail.changeBackupMail');
			
		}else
		{
			return Redirect::to('login');
		}
	}

	public function sendMail()
	{
		/*
		$data['receivers'] = "yojo4000@gmail.com";
		$data['subject'] = "laravel主旨";
		$data['mailView'] = "'emails.messageBoard.newMessage.newMessage'";
		$data['mailViewData'] = array(
		//一些email的php檔要用到的變數
		);*/
		//$this->dispatch(new SendMail($data));
	/*
		$data['receivers'] = array('yojo4000@gmail.com');
		$data['subject'] = "subject";
		$data['mailView'] = 'emails.welcome';
		$data['mailViewData'] = array(
			//$abc = "adsfasdf"
			//'link' => URL::to("msg_board") . '/' . $messageID
		);
		*/
		//return $this->dispatch(new SendMail($data));	
	}

	public function changeDBMail($schoolID, $newMailInput)
	{
		DB::table('users')->where('acct', $schoolID)
			->update(
				array('email' => $newMailInput));

	}

	public function store()
	{
		$pwInput 			= Input::get("pwInput");
		$newMailInput 		= Input::get("newMailInput");
		$stuOrNot			= Input::get("identity");

		/* 

			此時必為 已登入狀態

		*/
			
		$schoolID 			= Auth::user()->acct;
		$schoolPw;
		$correctFlag;

		$correctFlag = $this->ldap_authentication($schoolID, $pwInput);
			
		if($correctFlag == true)
		{
			$this->changeDBMail($schoolID, $newMailInput);

			/* 

				之後要改成 驗證信過了才更新 database 資料

			*/

			$this->sendMail();
			return Redirect::to('backupMailChanged');

		}else
		{
			return Redirect::to('changeBackupMail')->with('error', "error")->withInput();
		}
	}

	public function ldap_authentication($user, $pass) 
	{
		if (empty ($basedn)) 
		{
			echo "base dn is empty !!<br>";
			$basedn = LDAP_BASE;
		}

		if (! preg_match("/^[_a-zA-Z0-9]+$/", $user))
		{
			echo "preg format not match !!<br>";
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
 			
 			echo "my ip address: ".$_SERVER["REMOTE_ADDR"]."<br>"; 
			
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