<?php

namespace App\Entities;

use \GeoIP;
use \Request;

class UserLogs extends BaseEntity
{
	protected $table = 'logs';
	public $timestamps = false;
	// 取消自動加入 update_at = 目前時間

	public function scopeLogInfo($query, $portal_id, $info_type)
	{
		$count 		= $query->where('portal_id', $portal_id)->where('log_type_id', $info_type)->count();
		$countBool 	= 0;

		if($count != 0)
		{
			$countBool 	= 1; 
			$created_at = $this
				->where('portal_id', '=', $portal_id)
				->where('log_type_id', '=', $info_type)
				->lists('created_at')[$count - 1];

			$ip 		=  $this
				->where('portal_id', $portal_id)
				->where('log_type_id', $info_type)
				->lists('ip')[$count - 1];

			$location 	= GeoIP::getLocation($ip);
			$array 		= 
				[
					'countBool'		=> $countBool,
					'created_at' 	=> $created_at,
					'ip'			=> $ip,
					'location'		=> $location,
				];
		}else
		{
			$countBool 	= 0; 
			$array 		= 
			[
				'countBool'			=> $countBool
			];
			
		}
		return $array;
	}

	public static function writeEmailLog($time, $schoolID)
	{
		$myip = Request::getClientIp();

		$userLog = new UserLogs();
		$userLog->log_type_id	= 2; // 0 = login, 1 = changePass, 2 = changeMail
		$userLog->portal_id		= $schoolID;
		$userLog->created_at	= $time;
		$userLog->ip 			= $myip;

		$userLog->save();
	}
}

?>