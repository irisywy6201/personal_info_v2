<?php

namespace App\Http\Controllers;

use \vendor\phpoffice\phpword\src\PhpWord\Autoloader;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \View;
//use App\Http\Requests\HDDestroyFormRequest;
use \Validator;
use \Input;
use \Redirect;
use App\Entities\HDDestroy;
use \Auth;
use \App\Http\Controllers\Settings;
//use \vendor\awakenweb\livedocx\src\Soap\Client;
use \vendor\awakenweb\livedocx\src\Livedocx;
use \vendor\awakenweb\livedocx\src\Container;
use DB;
use PDF;
use App\Entities\NcuRemoteDB;
use Elibyy\TCPDF\Facades\TCPdf;

class HDDestroyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return View::make('HDDestroy.HDDestroy', ['username' => $username], ['role' => $role]);
    }

    /****************************************************************
  		利用 session 傳遞的 verify link 比對資料庫資料取得學號
  	****************************************************************/
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	//dd('123');
	$hds = DB::table('HD_destroy')->where('name', Auth::user()->username)->get();
        $name = Auth::user()->username;
	$dates = DB::table('HD_destroy')->where('name', Auth::user()->username)->distinct()->lists('appointmentTime');
	/*foreach($dates as $date) {
	    echo $date;
	}*/
	$data = array(
   	 'hds'  => $hds,
   	 'name'   => $name,
   	 'dates' => $dates
	);
        return View::make('HDDestroy.modify')->with($data);
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
        //dd($c);
        $extension = Input::get('identifyExtensionNumber');
        $appointmentTime = Input::get('datetimepicker');
        $ps = Input::get('note');
        $propertyIds = Input::get('propertyId');
/*	$demagnetizes = Input::get('demagnetize');
for($i=0;$i < $c; $i++)
{
	//echo $demagnetizes[$i];
	dd(implode(',', $demagnetizes));
}
*/
      $rules = [
        //不能空白
        'identifyExtensionNumber' => 'required',
        'datetimepicker' => 'required',
      ];

        $messages = [
          'identifyExtensionNumber.required' => '分機號碼欄位不能為空!',
          'datetimepicker.required' => '時間欄位不能為空!',
          'required' => '硬碟資訊不完整!',
        ];
/*      
	foreach(range(0, $c-1) as $index) {
	    $rules['brandAndStorage.' . $index] = 'required';
            $rules['propertyId.' . $index] = 'required';
	}
*/
/*
	foreach(range(0, $c-1) as $index) {
          $messages = [
            'identifyExtensionNumber.required' => '分機號碼欄位不能為空!',
            'datetimepicker.required' => '時間欄位不能為空!',
	    'brandAndStorage[' + $index + '].required' => '品牌容量欄位' + $index+1 + "不能為空！",
	    'propertyId[' + $index + '].required' => '財產編號欄位' + $index+1 + "不能為空！",
          ];
	}
*/
	//validation為submit後至controller的驗證
        $validation = Validator::make(Input::all(), $rules, $messages);
           if($validation->passes()){
	      
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
	      
/*PHPWord////////////////////////////////
              \PhpOffice\PhpWord\Autoloader::register();
              \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
              \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

              // Creating the new document...
              $phpWord = new \PhpOffice\PhpWord\PhpWord();
              $phpWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceAfter' => 100));

              // Note: any element you append to a document must reside inside of a Section. 

              // Adding an empty Section to the document...
              $section = $phpWord->addSection();

	      //$section->addText(htmlspecialchars('中文楷体样式测试', ENT_COMPAT, 'UTF-8'), array('name' => '楷体', 'size' => 16, 'color' => '1B2232'));
	   
              // add content
              $section->addText(
                htmlspecialchars(
                  '國立中央大學電子計算機中心'
                ),
                array( 'size' => 16, 'bold' => true),
                'pStyle'
              );

              $section->addText(
                htmlspecialchars(
                  '硬碟破壞服務申請暨完工證明'
                ),
                array('name' => 'bkai', 'size' => 16, 'bold' => true),
                'pStyle'
              );

              //colspan (gridSpan) and rowspan (vMerge)
              $styleTable = array('borderSize' => 6, 'borderColor' => '######');
              $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
              $cellRowContinue = array('vMerge' => 'continue');
              $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
              $cellHCentered = array('align' => 'center');
              $cellVCentered = array('valign' => 'center');

              $phpWord->addTableStyle('Colspan Rowspan', $styleTable);

              $section->addTextBreak(1);
              $table = $section->addTable('Colspan Rowspan');

              $table->addRow(800);

              $cell1 = $table->addCell(880, $cellRowSpan);
              $textrun1 = $cell1->addTextRun($cellHCentered);
              $textrun1->addText(htmlspecialchars('申請單位'), array('name' => 'Heiti TC Light', 'size' => 12, 'bold' => true));

              $cell2 = $table->addCell(2700, $cellRowSpan);
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars($role));

              $cell3 = $table->addCell(1420, $cellRowSpan);
              $textrun3 = $cell3->addTextRun($cellHCentered);
              $textrun3->addText(htmlspecialchars('申請人/分機'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell4 = $table->addCell(5000, $cellRowSpan);
              $textrun4 = $cell4->addTextRun($cellHCentered);
              $textrun4->addText(htmlspecialchars($username . '/' . $extension), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $table->addRow(800);

              $cell5 = $table->addCell(880, $cellRowSpan);
              $textrun5 = $cell5->addTextRun($cellHCentered);
              $textrun5->addText(htmlspecialchars('硬碟數量'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell6 = $table->addCell(2700, $cellRowSpan);
              $textrun6 = $cell6->addTextRun($cellHCentered);
              $textrun6->addText(htmlspecialchars($c), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell7 = $table->addCell(1420, $cellRowSpan);
              $textrun7 = $cell7->addTextRun($cellHCentered);
              $textrun7->addText(htmlspecialchars('預定時間'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell8 = $table->addCell(5000, $cellRowSpan);
              $textrun8 = $cell8->addTextRun($cellHCentered);
              $textrun8->addText(htmlspecialchars($appointmentTime), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $table = $section->addTable('Colspan Rowspan');

              $table->addRow(800);

              $cell9 = $table->addCell(880, $cellRowSpan);
              $textrun9 = $cell9->addTextRun($cellHCentered);
              $textrun9->addText(htmlspecialchars('序號'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell10 = $table->addCell(4120, $cellRowSpan);
              $textrun10 = $cell10->addTextRun($cellHCentered);
              $textrun10->addText(htmlspecialchars('廠牌／容量'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell11 = $table->addCell(3285, $cellRowSpan);
              $textrun11 = $cell11->addTextRun($cellHCentered);
              $textrun11->addText(htmlspecialchars('硬碟所屬報廢主機或硬碟財產編號'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              $cell12 = $table->addCell(1715, $cellRowSpan);
              $textrun12 = $cell12->addTextRun($cellHCentered);
              $textrun12->addText(htmlspecialchars('備註'), array('name' => '標楷體', 'size' => 12, 'bold' => true));

              //DynamicForm
              for ( $i=0; $i< $c; ++$i) {
                $table->addRow(800);

                $cell13 = $table->addCell(880, $cellRowSpan);
                $textrun13 = $cell13->addTextRun($cellHCentered);
                $textrun13->addText(htmlspecialchars($i+1), array('name' => '標楷體', 'size' => 12, 'bold' => true));

                $cell14 = $table->addCell(4120, $cellRowSpan);
                $textrun14 = $cell14->addTextRun($cellHCentered);
                $textrun14->addText(htmlspecialchars($brandAndStorages[$i]), array('name' => '標楷體', 'size' => 12, 'bold' => true));

                $cell15 = $table->addCell(3285, $cellRowSpan);
                $textrun15 = $cell15->addTextRun($cellHCentered);
                $textrun15->addText(htmlspecialchars($propertyIds[$i]), array('name' => '標楷體', 'size' => 12, 'bold' => true));

                $cell16 = $table->addCell(1715, $cellRowSpan);
                $textrun16 = $cell16->addTextRun($cellHCentered);
<<<<<<< HEAD
                $textrun16->addText(htmlspecialchars($ps), array('name' => '標楷體', 'size' => 12, 'bold' => true));
=======
                $textrun16->addText(htmlspecialchars($ps[$i]), array('name' => '標楷體', 'size' => 12, 'bold' => true));
>>>>>>> 9128d04001124becf8b58efcab9d9c79360a7338
              }

              //$section->addTextBreak(1);
              $table = $section->addTable('Colspan Rowspan');

              $table->addRow(2650);
              $cell1 = $table->addCell(5000);
              $textrun1 = $cell1->addTextRun($cellHCentered);
              $textrun1->addText(htmlspecialchars('申請人及單位主管簽章：'), array('name' => '標楷體', 'size' => 12, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell1->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars('年　　月　　日'), array('name' => '標楷體', 'size' => 12, 'bold' => true), array('align' => 'right', 'spaceAfter' => 100));

              $cell2 = $table->addCell(5000);
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars('電算中心承辦人簽證：'), array('name' => '標楷體', 'size' => 12, 'bold' => true));
              $textrun3 = $cell2->addTextRun($cellHCentered);
              $textrun3->addText(htmlspecialchars('已於    年    月    日完工'), array('name' => '標楷體', 'size' => 12, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars(''), array('name' => '標楷體', 'size' => 16, 'bold' => true));
              $textrun2 = $cell2->addTextRun($cellHCentered);
              $textrun2->addText(htmlspecialchars('年　　月　　日'), array('name' => '標楷體', 'size' => 12, 'bold' => true), array('align' => 'right', 'spaceAfter' => 100));

              $section->addTextBreak(1);
              $section->addText(htmlspecialchars('申請硬碟破壞需配合事項：'), array('name' => '標楷體', 'size' => 12, 'bold' => false));
              $section->addText(htmlspecialchars('1. 各單位申辦硬碟破壞，至少需於施做前一天提出申請，排程確定後通知申請單位送件時間。'), array('name' => '標楷體', 'size' => 12, 'bold' => false));
              $section->addText(htmlspecialchars('2. 報廢電腦主機請先自行拆卸硬碟，並依排程時間將硬碟送至電算中心服務台辦理。'), array('name' => '標楷體', 'size' => 12, 'bold' => false));
              $section->addText(htmlspecialchars('3. 本表硬碟登記欄位不敷使用時請使用附件表格。'), array('name' => '標楷體', 'size' => 12, 'bold' => false));
              $section->addText(htmlspecialchars('4. 本表正本連同報廢單送保管組續辦，影本電算中心自存備查。'), array('name' => '標楷體', 'size' => 12, 'bold' => false));

              //Open template and save it as docx
<<<<<<< HEAD
              $document = $phpWord->loadTemplate('HDDestroyService.docx');
              $document->saveAs('HDDestroyService.docx');
=======
	      $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	      $xmlWriter->save('HDDestroyService.docx');
              //$document = $phpWord->loadTemplate('HDDestroyService.docx');
              //$document->saveAs('HDDestroyService.docx');
>>>>>>> 9128d04001124becf8b58efcab9d9c79360a7338

              //Load temp file
              $phpWord = \PhpOffice\PhpWord\IOFactory::load('HDDestroyService.docx');

<<<<<<< HEAD
              //$includeFile = \PhpOffice\PhpWord\Settings::getPdfRendererPath();
=======
	      \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
              \PhpOffice\PhpWord\Settings::setPdfRendererName('DOMPDF');
>>>>>>> 9128d04001124becf8b58efcab9d9c79360a7338

              // Saving the document as OOXML file...
	      //$objWriter->writeAttribute('w:eastAsia', $font);
              $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
              $pdfWriter->save('HDDestroyService.pdf');
*/
//////////////////////////////////////////////////////////////////   TCPDF
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

		////////DynamicForm
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
			   <td style="width: 50%">電算中心承辦人簽證：<br>已於 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  年 &nbsp;&nbsp;&nbsp;  月 &nbsp;&nbsp;&nbsp;  日完工 <br><br> <p align="center">(電算中心章戳)</p> <br> <p align="right">年　&nbsp;&nbsp;&nbsp;&nbsp;　月　&nbsp;&nbsp;&nbsp;&nbsp;　日</p>  </td>
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


              return View::make('HDDestroy.test');
		    }

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
    public function show($id)
    {
        //
	
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
        dd('update');
	$hds = DB::table('HD_destroy')->get();
	foreach ($hds as $hd) {
     	   echo $hd->name;
	}
	//
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
    }
}
