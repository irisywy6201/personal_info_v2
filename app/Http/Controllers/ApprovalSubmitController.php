<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Queue;
use \Redirect;
use \URL;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Approve;
use App\Entities\ApproveManager;
use App\Entities\DynamicLink;

use App\Jobs\SendMail;
use App\Jobs\DeleteFile;

class ApprovalSubmitController extends Controller
{
	/******************************************************************
		待審核頁面 寄出審核通過 or 未通過信件
	******************************************************************/

	public function index () 
	{
		if(Auth::check())
		{
			$this->clearImg();

			$dataList 	= Approve::waitingApprove()->get(); // status = 0 者之集合
			$count 		= Approve::waitingApprove()->count(); // 集合之數量
			$email 		= ApproveManager::getEmail(); // 審核者信箱
			$lastTime 	= ApproveManager::getTime();  // 上次審核時間
			$changedBy 	= ApproveManager::getAccount();  // 審核者帳號

			return View::make(
				'approve.approve', 
				array(
					'dataList' 	=> $dataList,
					'dataCount'	=> $count,
					'approveManagerEmail'	=> $email,
					'lastTimeChangedBy'		=> $changedBy,
					'lastChangeTime'		=> $lastTime,
					)
				);
		}else
		{
			return Redirect::to('/');
		}
	}

	/*****************************************************************
		送出審核結果信件 (通過 OR 未通過)
	*****************************************************************/
	public function store() 
	{
		$each_id 		= Input::get('eahc_id'); // 該筆資料 id (即 approve table 中的 id)
		$correctOrFail 	= Input::get('correctOrFail'); // 通過 OR NOT
		$reason			= Input::get('reason'); // 如未通過之理由

		$record			= Approve::where('id', '=', $each_id)->first(); // 透過 id 取得 approve table 中相對應資料
		$email 			= $record->email; 		// 取得信箱
		$portal_id 		= $record->schoolID;	// 取得學號
		$stuOrNot 		= $record->stuOrNot;	// 取得身分

		$now = Carbon::now();

		switch ($correctOrFail) 
		{
			case 'correct': // 審核通過
	    		
				$this->sendVerifyEmail($portal_id, $email, $stuOrNot, $each_id);
				
				Approve::where('id', '=', $each_id)
	            ->update(
	           		array(
				    	'status'		=> 1,
				    	'updated_at'	=> $now,
		            	)
	            );
	            
				break;
			
			case 'fail': // 審核失敗
			
				$this->sendFailMail($portal_id, $email, $reason, $stuOrNot);
			
				Approve::where('id', '=', $each_id)
	            ->update(
	           		array(
				    	'status'		=> 2,
				    	'updated_at'	=> $now,
				    	'failReason'	=> $reason,
		            	)
	            );
	            
			break;
		}

		$cardFront 	= Approve::find($each_id)->pluck('cardFront');
		$cardBack 	= Approve::find($each_id)->pluck('cardBack');

		$arrayName 	= array(
			'correctOrFail' => $correctOrFail,
			'testid'		=> $each_id,
			'cardFront'		=> $cardFront,
			'cardBack'		=> $cardBack,
			);

		return json_encode($arrayName);
	}

	public function changeManagerEmail()
	{
		ApproveManager::where('id', '=', 1)
            ->update(
            	array(
            		'email' 		=> Input::get('email'),
            		'changedBy'		=> Auth::user()->acct,
            		'created_at'	=> Carbon::now(),
            	));

        $returnData = array(
	    		'email' 		=> Input::get('email'),
	    		'changedBy'		=> Auth::user()->acct,
	    		'created_at'	=> "".Carbon::now(),
	    		);
		return json_encode($returnData);
	}

	public function clearImg()
	{
		// 刪除相對應的身分證圖片(個資法)

		$cardFrontID 	= [];
		$cardBackID 	= [];

		// 取得 status = 0 (尚未審核)的 row
		$approvedUser = Approve::where('status', '=', 0)->get();
		$i = 0;
		foreach ($approvedUser as $user)
		{
			$cardFrontID[$i] 	= $user->cardFront;
			$cardBackID[$i]		= $user->cardBack;
			$i++;
		}

    	$imgFile 	= [];
	    $imgFile 	= glob("upload/approvePicture/{*.JPG,*.jpg,*.PNG,*png}", GLOB_BRACE);
		// 將 upload 中的這些附檔名的所有檔案之名稱存在陣列中

	    $fileCount 	= count($imgFile);
	    $filesToBeDeleted = [];

		for( $i=0; $i<$fileCount; $i++ )
		{
			// 比對 up img path
			$temp = 0;
			for( $j=0; $j<count($cardFrontID); $j++ )
    		{
    			if( $imgFile[$i] == $cardFrontID[$j] )
    			{
    				$temp = 1;
    			}
    		}

    		// 比對 down img path
    		$temp2 = 0;
    		for( $k=0; $k<count($cardBackID); $k++ )
    		{
    			if( $imgFile[$i] == $cardBackID[$k] )
    			{
    				$temp2 = 1;
    			}
    		}

    		// 如果 up & down 都不符合就刪除
    		if( ($temp+$temp2)==0 )
    		{
    			array_push($filesToBeDeleted, $imgFile[$i]);
    		}
		}

		$this->dispatch(new DeleteFile($filesToBeDeleted));
	}

	public function sendVerifyEmail($portal_id, $email, $stuOrNot, $each_id)
	{
		$frontUrl	= 'forgetpass/verify/'.$each_id.'/'.$stuOrNot;
		
		$data['acct']	= $portal_id;
		$data['due'] 	= Carbon::now()->addDays(2);
		$data['link'] 	= URL::to($frontUrl);
		

		$link = new DynamicLink();
		$link = $link->newDynamicLink($data['link'], $data['due'], $data['acct']);

		$data['receivers'] = array($email);
		$data['subject'] = Lang::get('approve.ncuMail');
		$data['mailView'] = 'emails.forgetpassReply.forgetpassReply';
		$data['mailViewData'] = [
			'portal_id' => $portal_id,
			'link' => $link
		];

		$this->dispatch(new SendMail($data));
	}

	public function sendFailMail($portal_id, $email, $reason, $stuOrNot)
	{
		$frontUrl	= 'forgetpass/verify/'.$stuOrNot;
		
		$data['acct']	= $portal_id;
		$data['due'] 	= Carbon::now()->addDays(2);
		$data['link'] 	= URL::to($frontUrl);

		$link = new DynamicLink();
		$link = $link->newDynamicLink($data['link'], $data['due'], $data['acct']);

		$data['receivers'] = array($email);
		$data['subject'] = Lang::get('approve.ncuMail');
		$data['mailView'] = 'emails.forgetpassReply.forgetPassVerifyDeny';
		$data['mailViewData'] = [
			'portal_id' => $portal_id,
			'reason'	=> $reason
		];
		
		$this->dispatch(new SendMail($data));
	}
}

?>