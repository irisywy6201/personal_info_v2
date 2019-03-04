<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\software_list;
use App\Entities\software_version;
use App\Entities\software_requirement;
use App\Entities\software_category;
use App\Entities\Readme;
use DB;
class AdminSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$readme = Readme::all();
        $software_category = software_category::all();
		return view('Auth_software/download.create_software',[
			'software_category'=>$software_category,
			'readme'=>$readme,
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
		$this->validate($request, [
		'category' => 'required',
        'name_zh' => 'required',
		'name_en' => 'required',
		'summary_zh' => 'required',
		'summary_en' => 'required',
		'kms_link'=>'required',
		'year'=>'required',
		], [
		'category.required' => '軟體種類欄位不可留空白!',
		'name_zh.required' => '軟體名稱(中文)欄位不可留空白!',
		'name_en.required' => '軟體名稱(英文)欄位不可留空白!',
		'summary_zh.required' => '軟體介紹(中文)欄位不可留空白!',
		'summary_en.required' => '軟體介紹(英文)欄位不可留空白!',
		'kms_link.required' => 'kms連結欄位不可留空白!',
		'year.required'=>'軟體新增學年度欄位不可留空白!',
		]);
	
		
		
		$test = new software_list;
		
		$test->name_zh=$request->name_zh;
		$test->name_en=$request->name_en;
		$test->summary_zh=$request->summary_zh;
		$test->summary_en=$request->summary_en;
		$test->software_category_id=$request->category;
		$test->year=$request->year;
		$test->kms_link=$request->kms_link;
		$test->isdelete=0;
		$test->save();
		$length_version=$request->count_version;
		$length_describe=$request->count_describe;

		echo $length_version;
	
		$var=DB::table('software_list')
			  ->orderBy('id','desc')
			  ->pluck('id');

		for($i=1;$i<=$length_version;$i++){
			$test2 = new software_version;
			$test2->software_list_id=$var;
			$a = 'platform'.$i;
			$b = 'connect'.$i;
			$this->validate($request, [
				$a => 'required',
				$b => 'required'
				], [$a.'required' => '軟體版本欄位不可留空白!',$b.'required' => '位元/版本欄位不可留空白!'
			]);
			$test2->platform_id=$request->$a;
			$test2->download_link=$request->$b;
			$test2->save();
		}
	
		for($i=1;$i<=$length_describe;$i++){
			$test3 = new software_requirement;
			$c = 'need'.$i;
			$c_en = 'need_en'.$i;
			$this->validate($request, [
				$c => 'required',
				$c_en => 'required'
				], [$c.'required' => '軟體需求欄位不可留空白!',$c_en.'required' => '軟體需求欄位不可留空白!'
			]);
			$test3->software_list_id=$var;
			$test3->requirement_zh=$request->$c;
			$test3->requirement_en=$request->$c_en;
			$test3->save();
		}	
	
		return Redirect::to('/admin/auth_soft/Category')->with([
			'success'=>'新增成功!'
		]);
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
        $software_list = software_list::find($id);
		$software_version= software_version::where('software_list_id',$id)->get();
		$software_requirement= software_requirement::where('software_list_id',$id)->get();
		$readme=readme::all();
		return view('Auth_software/download.edit', [
			'software_list' => $software_list,
			'software_version' => $software_version,
			'software_requirement' => $software_requirement,
			'readme'=>$readme,
		]);
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
         $this->validate($request, [
        'name_zh' => 'required',
		'name_en' => 'required',
		'summary_zh' => 'required',
		'kms_link'=>'required',		
		'summary_en' => 'required',
		'year'=>'required',],
		['name_zh.required' => '軟體名稱(中文)欄位不可留空白!',
		'name_en.required' => '軟體名稱(英文)欄位不可留空白!',
		'summary_zh.required'=>'軟體介紹(中文)欄位不可留白!',
		'summary_en.required'=>'軟體介紹(英文)欄位不可留白!',
		'kms_link.required' => 'kms連結欄位不可留空白!',
		'year.required'=>'軟體新增學年度欄位不可留空白!',
		]);
		$length_version=$request->count_version;
		$length_describe=$request->count_describe-1;
		$num_v=$request->num_v;
		$num_d=$request->num_d;
		
		if($num_v>$length_version){
			$delete_v=software_version::where('software_list_id','=',$id)->take($num_v-$length_version)->get();
			foreach($delete_v as $delete_vs){
				$delete_vs->delete();
			}	
		}
		if($num_d>$length_describe){
			$delete_d=software_requirement::where('software_list_id','=',$id)->take($num_d-$length_describe)->get();
			foreach($delete_d as $delete_ds){
				$delete_ds->delete();
			}	
		}
		$download = software_list::find($id);
		$test2 = software_version::where('software_list_id','=',$id)->get();
		$test3 = software_requirement::where('software_list_id',$id)->get();
		$q=$id;
		
		$download->name_zh = $request->name_zh;
		$download->name_en = $request->name_en;
		$download->summary_zh= $request->summary_zh;
		$download->summary_en= $request->summary_en;	
		$download->year=$request->year;
		$download->kms_link=$request->kms_link;
		$download->save();

		$j=1;
		foreach($test2 as $test4){
			$d = 'platform'.$j;
			$e = 'connect'.$j;
			$this->validate($request, [
				$d => 'required',
				$e => 'required'
				], [$d.'required' => '位元/版本欄位不可留空白!',
				$e.'required' => '下載連結欄位不可留空白!'
			]);
			$test4->software_list_id=$q;
			$test4->platform_id=$request->$d;
			$test4->download_link=$request->$e;
			$test4->save();
			$j=$j+1;
		}

		$k=1;
		foreach($test3 as $test6){
			$c = 'need'.$k;
			$c_en = 'need_en'.$k;
			$this->validate($request, [
				$c => 'required',
				$c_en => 'required'
				], [ $c.'required' => '軟體需求欄位不可留空白!',
				$c_en.'required' => '軟體需求欄位不可留空白!'
			]);
			$test6->software_list_id=$q;
			$test6->requirement_zh=$request->$c;
			$test6->requirement_en=$request->$c_en;
			$test6->save();
			$k=$k+1;
		}

		  for($i=$j;$i<=$length_version;$i++){
  			$test5 = new software_version;
  			$a = 'platform'.$i;
  			$b = 'connect'.$i;	
			$this->validate($request, [
				$a => 'required',
				$b => 'required'
				], [ $a.'required' => '位元/版本欄位不可留空白!',
				$b.'required' => '下載連結欄位不可留空白!'
			]);			
  			$test5->software_list_id=$id;
  			$test5->platform_id=$request->$a;	
  			$test5->download_link=$request->$b;
  			$test5->save();
  		}
  		for($i=$k;$i<=$length_describe;$i++){
  			$test7 = new software_requirement;
  			$f = 'need'.$i;
			$f_en = 'need'.$i;
			$this->validate($request, [
				$f => 'required',$f_en => 'required'
				], [$f.'required' => '軟體需求欄位不可留空白!',$f_en.'required' => '軟體需求欄位不可留空白!'
			]);
  			$test7->software_list_id=$id;
  			$test7->requirement_zh=$request->$f;
			$test7->requirement_en=$request->$f_en;
  			$test7->save();
  		}
		return redirect('/admin/auth_soft/Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $download = software_list::find($id);
		$download->isdelete=1;
		$download->save();
		return back()
		  ->with('delete_suc','刪除成功!');
    }
}
