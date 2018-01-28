<?php

namespace App\Http\Controllers;

use DateInterval;
use DateTime;

use \Excel;
use \Input;
use \Lang;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Question;

class AdminReporterController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$endDate =(new DateTime())->format('Y-m-d');
		$addOneDay = (new DateTime($endDate))->add(new DateInterval('P1D'))->format('Y-m-d');
		$startDate = (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d');
		$result = Question::status("1")->afterTime($startDate)->beforeTime($addOneDay)->StatisticsData();
		$resultQuestion = Question::orderby('status','desc')->afterTime($startDate)->beforeTime($addOneDay)->get();
		return View::make('admin.Reporter.adminReporter',array(
			'title' => Lang::get('Admin/Reporter.reporter'),
			'result' => $result,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'resultQuestion' => $resultQuestion,
			'orderValue' => null
			));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$endDate = Input::get('end');
		$startDate = Input::get('start');
		$orderValue = Input::get('orderValue');
		$result = Question::status("1")->afterTime($startDate)->beforeTime((new DateTime($endDate))->add(new DateInterval('P1D')))->StatisticsData();
		$resultQuestion = Question::orderby('status','desc')->orderbyValue($orderValue,'1')->afterTime($startDate)->beforeTime((new DateTime($endDate))->add(new DateInterval('P1D')))->get();
		return View::make('admin.Reporter.adminReporter',array(
			'title' => Lang::get('Admin/Reporter.reporter'),
			'result' => $result,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'resultQuestion' => $resultQuestion,
			'orderValue' => $orderValue
			));
	

	}

	/**
	 * Display the specified resource.
	 *
	 *
	 * @return Response
	 */
	public function show()
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource start storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function output($start,$end)
	{

		$orderValue = Input::get('orderValue');
		$title = Lang::get('admin.reporter');
		$endDate =(new DateTime())->format('Y-m-d');
		$addOneDay = (new DateTime($endDate))->add(new DateInterval('P1D'))->format('Y-m-d');
		$startDate = (new DateTime())->sub(new DateInterval('P7D'))->format('Y-m-d');
		$checkBox = [];
		$titleName = [];
		foreach (Input::get('check') as $key => $value) {
			array_push($checkBox,$key);
			array_push($titleName,Lang::get('admin.'.$key));
		}
		$specifiedData = Question::orderby('status','desc')->orderbyValue($orderValue,'1')->outputData($checkBox);
		
		Excel::create('output', function($excel) use($specifiedData,$startDate,$endDate) {
			$excel->sheet('ServiceDeskRepoter', function($sheet) use($specifiedData,$startDate,$endDate) {
				$sheet->row(1,['Time start',$startDate,'Time end',$endDate]);
				$sheet->fromModel($specifiedData,null,'A2',true);
       		});
			ob_end_clean();
		})->export('xls');

		return View::make('admin.Reporter.adminReporter',array(
			'title' => $title,
			'result' => $result,
			'startDate' =>$startDate,
			'endDate' =>$endDate,	
			'resultQuestion' => $resultQuestion,
			));
		/*Excel::create('output', function($excel) use($result,$name,$startDate,$endDate) {
			$excel->sheet('ServiceDeskRepoter', function($sheet) use($result,$name,$startDate,$endDate) {
				$sheet->row(1,array('Time start',$startDate,'Time end',$endDate));
				$sheet->row(2,array_merge((array)Lang::get('admin.category'),$name));
				$sheet->row(3,array_merge((array)Lang::get('admin.solvedNumber'),$result));
				$sheet->setAutoSize(false);
				$sheet->setPageMargin(0.45);
       		});

			ob_end_clean();
		})->export('xls');*/



	}

}
