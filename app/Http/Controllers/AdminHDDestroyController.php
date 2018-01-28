<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \View;
use \DB;
use \Excel;

class AdminHDDestroyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
	$dates = DB::table('HD_destroy')->distinct()->lists('appointmentTime');
        $numbers = array();
	foreach($dates as $date) {
	    array_push($numbers, DB::table('HD_destroy')->where('appointmentTime', $date)->count());
        }
	$faculties = array();
	foreach($dates as $date) {
	    //dd(DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
	    array_push($faculties, DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
        }
	$states = array();
	foreach($dates as $date) {
	    array_push($states, DB::table('HD_destroy')->where('appointmentTime', $date)->value('state'));
        }
	$closeTimes = array();
        foreach($dates as $date) {
            array_push($closeTimes, DB::table('HD_destroy')->where('appointmentTime', $date)->value('updated_at'));
        }
        $data = array(
         'dates' => $dates,
	 'numbers' => $numbers,
	 'faculties' => $faculties,
	 'states' => $states,
	 'closeTimes' => $closeTimes
        );	

	return View::make('admin.HDDestroy.HDDestroy')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
	return "create";
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
	return "store";
    }

    public function export()
    {
	$dates = DB::table('HD_destroy')->distinct()->lists('appointmentTime');
        $numbers = array();
	foreach($dates as $date) {
	    array_push($numbers, DB::table('HD_destroy')->where('appointmentTime', $date)->count());
        }
	$faculties = array();
	foreach($dates as $date) {
	    //dd(DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
	    array_push($faculties, DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
        }
	$states = array();
	foreach($dates as $date) {
	    array_push($states, DB::table('HD_destroy')->where('appointmentTime', $date)->value('state'));
        }
	$closeTimes = array();
        foreach($dates as $date) {
            array_push($closeTimes, DB::table('HD_destroy')->where('appointmentTime', $date)->value('updated_at'));
        }

	Excel::create('HDDestroyServiceReport', function($excel) use($dates,$numbers,$faculties,$states,$closeTimes){
		$excel->sheet('ServiceDeskRepoter', function($sheet) use($dates,$numbers,$faculties,$states,$closeTimes){
			$sheet->row(1,['#', '處室','硬碟數量','預約時間','狀態']);
			foreach($dates as $key => $date){
				if($states[$key] == 0){
					$state = "Open";
					$date = "";
				}else{
					$state = "Closed at " . $closeTimes[$key];
					$date = date("Y-m-d", strtotime(str_replace('-','/', $closeTimes[$key])));
				}
				$sheet->row($key+2,[$key+1, $faculties[$key], $numbers[$key], $date, $state, $date]);
			}	
       		});
		ob_end_clean();
	})->export('xls');
	//return "export";	
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
	$d = date("Y-m-d H:i:s");
	//dd($d);
	DB::table('HD_destroy')->where('appointmentTime', $id)->update(['state' => 1]);
	DB::table('HD_destroy')->where('appointmentTime', $id)->update(['updated_at' => $d]);
	
	$dates = DB::table('HD_destroy')->distinct()->lists('appointmentTime');
        $numbers = array();
	foreach($dates as $date) {
	    array_push($numbers, DB::table('HD_destroy')->where('appointmentTime', $date)->count());
        }
	$faculties = array();
	foreach($dates as $date) {
	    //dd(DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
	    array_push($faculties, DB::table('HD_destroy')->where('appointmentTime', $date)->value('office'));
        }
	$states = array();
	foreach($dates as $date) {
	    array_push($states, DB::table('HD_destroy')->where('appointmentTime', $date)->value('state'));
        }
	$closeTimes = array();
        foreach($dates as $date) {
            array_push($closeTimes, DB::table('HD_destroy')->where('appointmentTime', $date)->value('updated_at'));
        }
        $data = array(
         'dates' => $dates,
	 'numbers' => $numbers,
	 'faculties' => $faculties,
	 'states' => $states,
	 'closeTimes' => $closeTimes
        );	
	return View::make('admin.HDDestroy.HDDestroy')->with($data);
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
