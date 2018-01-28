<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use \Auth;
use \Crypt;
use \Input;
use \Redirect;
use \Request;
use \Session;
use \View;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\NcuRemoteDB;
use App\Entities\User as User;
use App\Entities\UserLogs as UserLogs;

use App\Ncucc\AppConfig as AppConfig;
use App\Ncucc\NetID as NetID;
use App\Ncucc\NetIDReturn as NetIDReturn;

class NetIDController extends Controller
{

	protected $layout = 'layout';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function logout() {
		Auth::logout();
		Session::flush();
		return Redirect::to('login')->with('message', 'Your are now logged out!');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		if (Input::get()) {
			$netid = new NetID(
				env('APP_DOMAIN_NAME'),
				AppConfig::netidPrefix,
				AppConfig::$netidAllowedRoles
			);

			$userid = null;
			
			$rc = $netid->doLogin($userid);
			
			$className = get_class($rc);
			$className = explode('\\', $className);
			$className = $className[count($className) - 1];

			if (is_object($rc) && ($className == 'NetIDReturn')) {
				if ($rc->returnCode == NetIDReturn::LOGIN_OK) {
					
					$role = AppConfig::ROLE_USER;

					foreach ($rc->roleList as $r) {
						if (array_key_exists ($r, AppConfig::$roleMap)) {
							$role |= AppConfig::$roleMap[$r];
						}
					}

					$userRealName = NcuRemoteDB::getUserRealName($rc->account, $role);

					try {
						$user = User::where('acct', '=', $rc->account)->firstOrFail();

						if ($user->role != $role) {
							$user->role = $role;
							$user->update();
						}

						if (!empty($userRealName) && $user->username != $userRealName) {
							$user->username = $userRealName;
							$user->update();
						}
						
					} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
						$user = new User();
						$user->acct = $rc->account;
						$user->username = $userRealName;
						$user->role = $role;
						$user->addrole = 0;
						$user->save();
					}

					Auth::login ($user);
					
					// Check if user has alternate E-mail address or not.
					// Force user to add one.
					
						$now = Carbon::now();
						$this->writeLog($now);

						return Redirect::intended('/');
					
				}
				else {
					return View::make ('netid.failed')->with(
						'netid_errorcode',  $rc->returnCode
					);
				}
			}
			dd('error!');
		}
		else {
			return View::make ('netid.login');
		}
	}

	public function writeLog($time)
	{
		$myip = Request::getClientIp();

		$userLog = new UserLogs;
		$userLog->log_type_id	= 0; // 0 = login, 1 = changePass, 2 = changeMail
		$userLog->portal_id		= Auth::user()->acct;
		$userLog->created_at	= $time;
		$userLog->ip 			= $myip;

		$userLog->save();
	}
}
?>
