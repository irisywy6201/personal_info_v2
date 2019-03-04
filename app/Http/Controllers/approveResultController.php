<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Redirect;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Approve;
use App\Entities\ChangePassword;

class approveResultController extends Controller
{
	public function index()
	{
		if(Auth::check())
		{
			App::make('App\Http\Controllers\ApprovalSubmitController')->clearImg();

			$approvedData 		= Approve::approved()->get()->toArray(); 
			// 取得 approve table 中作業中(status = 1)已完成(status = 2)的資料

			$dataCount 			= Approve::approved()->count(); 
			// 計算數量


			/************************************************************************
				取得 changePassword 的 approved_id 來對照 approve 的 id
				因此 approve 可以取得對應 changePassword 的 status
			************************************************************************/
			$iDArray = array();
			$iDArray = ChangePassword::lists('approved_id')->all(); 
			// 取得 changePassword table 中的 approved_id column 的所有資料

			$statusArray = array();
			$statusArray = ChangePassword::lists('status')->all(); 
			// 取得 changePasswrod table 中的 status columns 的所有資料

			for( $i=0; $i<count($approvedData); $i++ )
			{
				$approvedData[$i]['changePassword_status'] = (-1); // 初始化

				for( $j=0; $j<count($iDArray); $j++)
				{
					if( $approvedData[$i]['id'] == $iDArray[$j] ) // 對照 changePassword table 中的 approve_id
					{
						$approvedData[$i]['changePassword_status'] = $statusArray[$j]; 
						// 將目前狀態(in changePassword table)寫入提供前端使用
					}
				}
			}

			return View::make(
				'approve.approveResult',
				array(
					'approvedData' 	=> $approvedData,
					'dataCount'		=> $dataCount,
					)
				);
			
		}else
		{
			return Redirect::to('/');
		}
	}

	public function store()
	{

	}
}

?>