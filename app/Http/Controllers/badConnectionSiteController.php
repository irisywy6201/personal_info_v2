<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class badConnectionSiteController extends Controller
{
	public function index()
	{
		if(Auth::check())
		{
			$client_ip 	= Request::getClientIp();
			$ipArray 	= array();
			$ipArray 	= explode('.', $client_ip);
			$ncuPart 	= $ipArray[0].$ipArray[1];
			$isNcuOrNot = 0;

			if($ncuPart == '140115')
			{
				$isNcuOrNot = 1;
			}else
			{
				$isNcuOrNot = 0;
			}

			return View::make('badConnectionSite.badConnectionSite')->with(
					array(
						'client_ip'		=> $client_ip,
						'isNcuOrNot'	=> $isNcuOrNot
						));
		}else
		{
			return Redirect::to('loginAndReturn')
			->with(
				array(
					'loginAndReturn'=>URL::current()
					));
		}
	}

	public function store()
	{
		//dd(Session::pull('loginAndReturn'));
		$badUrl 	= Input::get('badUrl');
		$dorm 		= Input::get('dormSelector');
		$building 	= Input::get('buildingSelector');
		$floor 		= Input::get('floorSelector');
		$dateTime 	= Input::get('datetimepicker');

		$domainName = parse_url($badUrl)['host'];
		$client_ip 	= Request::getClientIp();
		/*
		["scheme"]	=> "http" 
		["host"]	=> "sd.cc.ncu.edu.tw" 
		["path"]	=> "/badConnectionSite" 
		*/

		$ipArray 	= array();
		$ipArray 	= explode('.', $client_ip);
		$ncuPart 	= $ipArray[0].$ipArray[1];

		if($ncuPart == '140115')
		{
			$place 	= '';
			if($dorm == "")
			{
				$place = $building;
			}

			if($building == "")
			{
				$place = $dorm;
			}

			$badUrlRecord = new BadUrlRecord;
			
			$badUrlRecord->schoolID 	= Auth::user()->acct;
			$badUrlRecord->url 			= $badUrl;
			$badUrlRecord->floor 		= $floor;
			$badUrlRecord->happen_time 	= $dateTime;
			$badUrlRecord->record_time 	= Carbon::now();
			$badUrlRecord->place_symbol	= $place;
			$badUrlRecord->url_domain	= $domainName;
			$badUrlRecord->record_IP 	= $client_ip;
			$badUrlRecord->save();

			echo $badUrl."<br>".$place."<br>".$floor."<br>".$dateTime."<br>".Auth::user()->acct;
			return Redirect::to('badConnectionResult');
		}else
		{
			return Redirect::to('badConnectionSite')->with(
				array(
					'notNcu'	=> '您所使用的 IP 位址不在中央大學校內！'
					));
		}
	}
}

?>