<?php

namespace App\Http\Controllers;

use \Auth;
use \Redirect;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Email;
use App\Entities\User;
use App\Entities\UserLogs;
	
class UserInfoController extends Controller
{
	public function index()
	{
		if (Auth::check()) 
		{
			$portal_id 		= Auth::user()->acct;
			$loginInfo 		= UserLogs::logInfo($portal_id, "0");
			$changePassInfo = UserLogs::logInfo($portal_id, "1");
			$changeMailInfo = UserLogs::logInfo($portal_id, "2");
			$user_id 		= User::where('acct', '=', $portal_id)->first()->id;
			$email 			= Email::where('user_id', '=', $user_id)->first()->address;


			$InfoArray 						= array();
			$InfoArray['portal_id']			= $portal_id;
			$InfoArray['email']				= $email;
			$InfoArray['noLoginData'] 		= 0;
			$InfoArray['noChangeMailData']	= 0;
			$InfoArray['noChangePassData'] 	= 0;

			if($loginInfo['countBool'] == 0) // 沒有登入資訊
			{
				$InfoArray['noLoginData'] = 1;
			}
			else
			{
				$InfoArray['loginCreated_at'] 	= $loginInfo['created_at'];
				$InfoArray['loginIp']			= $loginInfo['ip'];
				$InfoArray['loginCountry']		= $loginInfo['location']['country'];
				$InfoArray['loginCity']			= $loginInfo['location']['city'];
				//$InfoArrayp['test']				= $test;
			}

			if($changePassInfo['countBool'] == 0)
			{
				$InfoArray['noChangePassData']	= 1;
			}else
			{
				$InfoArray['changePassCreated_at'] 	= $changePassInfo['created_at'];
				$InfoArray['changePassIp']			= $changePassInfo['ip'];
				$InfoArray['changePassCountry']		= $changePassInfo['location']['country'];
				$InfoArray['changePassCity']		= $changePassInfo['location']['city'];
			}

			if($changeMailInfo['countBool'] == 0)
			{
				$InfoArray['noChangeMailData']	= 1;
			}else
			{
				$InfoArray['changeMailCreated_at'] 	= $changeMailInfo['created_at'];
				$InfoArray['changeMailIp']			= $changeMailInfo['ip'];
				$InfoArray['changeMailCountry']		= $changeMailInfo['location']['country'];
				$InfoArray['changeMailCity']		= $changeMailInfo['location']['city'];
			}

			return View::make('tools/userinfo', $InfoArray);

		}else
		{
			return Redirect::to('/login');
		}
		
	}
}

?>