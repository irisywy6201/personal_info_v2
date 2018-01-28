<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \View;
use \Validator;
use \Input;
use \Redirect;
use App\Entities\HDDestroy;
use \Auth;
use App\Http\Controllers\Session;
use App\Entities\NcuRemoteDB;
use PDF;

class HDDestroyModifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	$hds = DB::table('HD_destroy')->where('name', Auth::user()->username)->where('state', 0)->get();
        $name = Auth::user()->username;
        $dates = DB::table('HD_destroy')->where('name', Auth::user()->username)->where('state', 0)->distinct()->lists('appointmentTime');
        $numbers = array();
	foreach($dates as $date) {
	    array_push($numbers, DB::table('HD_destroy')->where('name', Auth::user()->username)->where('appointmentTime', $date)->where('state', 0)->count());
        }
        $data = array(
         'hds'  => $hds,
         'name'   => $name,
         'dates' => $dates,
	 'numbers' => $numbers
        );
	
        return View::make('HDDestroy.modifyList')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
	if(Input::get('store')) {
          return response()->download('./HDDestroyService.pdf');
        }
	
	$username = Auth::user()->username;

	if(Auth::user()->isFaculty()) {
	    $remoteDB = new NcuRemoteDB;
	    $remoteDB->setTable('staff_info');
            $tmp = $remoteDB->where('portal_id', Auth::user()->acct)->value('unit_no');
            $remoteDB->setTable('unit');
            $role = $remoteDB->where('unit_no', $tmp)->value('unit_cname');
        } else if(Auth::user()->isStudent()){
	    $remoteDB = new NcuRemoteDB;
	    $remoteDB->setTable('student_info');
	    $tmp = $remoteDB->where('portal_id', Auth::user()->acct)->value('degree_kind_no');
	    $remoteDB->setTable('academics_unit');
	    $role = $remoteDB->where('degree_kind_no', $tmp)->value('degree_kind_cname');
        } else {
	    $role = "校外人士";
	}

        $brandAndStorages = Input::get('brandAndStorage');
        $c = count($brandAndStorages);
	$appointmentTime = $request->session()->get('date');
        $extension = DB::table('HD_destroy')->where('appointmentTime', $appointmentTime)->where('name', $username)->value('extension');
        $ps = Input::get('note');
        $propertyIds = Input::get('propertyId');
        $rules = [
          //不能空白
          //'brandAndStorage' => 'required',
          //'propertyId' => 'required',
          
        ];
//dd($brandAndStorages[0]);
        foreach(range(0, $c-1) as $index) {
          $rules['brandAndStorage.' . $index] = 'required';
          $rules['propertyId.' . $index] = 'required';
	  //$messages['brandAndStorage.' . $index . '.required'] = '品牌不能為空';
	  //$messages['propertyId.' . $index . '.required'] = '編號不能為空';
        }
        $messages = [
          //'brandAndStorage.required' => '品牌容量欄位不能為空!',
          //'propertyId.required' => '財產編號欄位不能為空!',
          'required' => '請輸入完整硬碟資訊!',
        ];
      
        //validation為submit後至controller的驗證
        $validation = Validator::make(Input::all(), $rules, $messages);
           if($validation->passes()){
	      DB::table('HD_destroy')->where('appointmentTime', $appointmentTime)->where('name', $username)->delete();
	      
              for ( $i=0; $i< $c; ++$i) {
                $HD_destroy = new HDDestroy;
                $HD_destroy->office = $role;
                $HD_destroy->name = $username;
                $HD_destroy->extension = $extension;
                $HD_destroy->appointmentTime = $appointmentTime;
                $HD_destroy->ps = $ps[$i];
                $HD_destroy->brandAndStorage = $brandAndStorages[$i];
                $HD_destroy->propertyId = $propertyIds[$i];
                $HD_destroy->save();
              }
	      
	     PDF::SetTitle('HDDestroy Service');
		PDF::AddPage();
		PDF::SetFont('msungstdlight', '', 16, '', true);
		PDF::Write(0, '國立中央大學電子計算機中心', "", "", "C");
		PDF::Ln();
		PDF::Write(0, '硬碟破壞服務申請暨完工證明', "", "", "C");
		PDF::Ln();
		PDF::Ln();
		PDF::SetFontSize("12");
		// Set some content to print
		$tbl = <<<EOD
		<table cellspacing="0" cellpadding="5" border="1">
    		<tr>
        		<td style="width: 11%">申請單位</td>
        		<td style="width: 22%">$role</td>
        		<td style="width: 17%">申請人/分機</td>
			<td style="width: 50%">$username/$extension</td>
    		</tr>
    		<tr>
                        <td style="width: 11%">硬碟數量</td>
                        <td style="width: 22%">$c 顆</td>
                        <td style="width: 17%">預定時間</td>
                        <td style="width: 50%">$appointmentTime</td>
                </tr>
		<tr>
                        <td style="width: 8%">序號</td>
                        <td style="width: 42%" align="center">廠牌/容量</td>
                        <td style="width: 33%">硬碟所屬報廢主機或硬碟財產編號</td>
                        <td style="width: 17%" align="center">備註</td>
                </tr>
EOD;
		//DynamicForm
		$tb = '';
              for ( $i=0; $i< $c; $i++) {
		$id = $i+1;
		$tb .= '<tr>
                           <td style="width: 8%">' . $id . '</td>
                           <td style="width: 42%">' . $brandAndStorages[$i] . '</td>
                           <td style="width: 33%">' . $propertyIds[$i] . '</td>
                           <td style="width: 17%">' . $ps[$i] . '</td>
                        </tr>';
              }
		$tb .= '<tr>
                           <td style="width: 50%; height: 170">申請人：<br><br><br><br><br>單位主管簽章：<br><br> <p align="right">年　&nbsp;&nbsp;&nbsp;&nbsp;　月　&nbsp;&nbsp;&nbsp;&nbsp;　日</p> </td>
                           <td style="width: 50%">電算中心承辦人簽證：<br>已於 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  年 &nbsp;&nbsp;&nbsp;  月 &nbsp;&nbsp;&nbsp;  日完工 <br><br> <p align="center">(電算中心章戳)</p> <br> <p align="r    ight">年　&nbsp;&nbsp;&nbsp;&nbsp;　月　&nbsp;&nbsp;&nbsp;&nbsp;　日</p>  </td>
                        </tr>
                        </table><br>';
		PDF::writeHTML($tbl . $tb, true, true, true, true, '');

                $html = <<<EOD
		<p>申請硬碟破壞需配合事項：</p>
		<p>1. 各單位申辦硬碟破壞，至少需於施做前一天提出申請，排程確定後通知申請單位送件時間。 </p>
		<p>2. 報廢電腦主機請先自行拆卸硬碟並依排程時間將硬碟送至電算中心服務台辦理。</p>
		<p>3. 本表硬碟登記欄位不敷使用時請使用附件表格。</p>
		<p>4. 本表正本連同報廢單送保管組續辦，影本電算中心自存備查。</p>
EOD;
		// Print text using writeHTMLCell()
		 PDF::writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);		
		PDF::Output('/var/www/html/NCU-Service-Desk/NCU-Service-Desk/public/HDDestroyService.pdf', 'F');
	   
              return View::make('HDDestroy.afterModifyPage');
	     }
	//return "validation not pass";		    
        return Redirect::back()
                ->withInput()
                ->withErrors($validation);	

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        //
	$hds = DB::table('HD_destroy')->where('name', Auth::user()->username)->where('appointmentTime', $id)->where('state', '0')->get();
	$data = array(
         'hds'  => $hds,
         'name'   => Auth::user()->username,
         'date' => $id
        );
	$request->session()->put('date', $id);
	return View::make('HDDestroy.modifyForm')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
	return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
	return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
	return "destroy";
    }
}
