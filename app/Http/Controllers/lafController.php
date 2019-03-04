<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \Crypt;
use \Input;
use \Lang;
use \Queue;
use \Redirect;
use \SearchEngine;
use \URL;
use \Validator;
use \View;
use \File;
use \Mail;

use DateTime;
use  App\Ncucc\AppConfig as AppConfig;
use \Uuid;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Jobs\SendMail;
use App\Jobs\LostToMilitary;

use App\Entities\lostandfound;
use App\Entities\lostType;

class lafController extends Controller
{
    //set private variable
    //set the root path of upload picture
    private $photoUploadPath = 'upload';
    
    /**
    *
    * make testing ip a public function
    *
    **/
    public function testIP($ip)
    {
      $IP = AppConfig::$matchIP;
      //if ip match the addr we set in appconfig, we can let it show submit button
      if(in_array($ip, $IP)){

        return true;
      }else{

        return false;
      }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       	$type = lostType::all();
        //get the client ip
        $ip = $request->ip();
        
        $result = false;  
		
		$test =lostandfound::all();

        if(Auth::check()){

          if(Auth::user()->acct == 'center18' || Auth::user()->acct == '104403535'){

              $result = true;
          }
        }  
	       return View::make('laf.laf', [
          'admin' => $result,
          'goIP' => $this->testIP($ip),
          'type' => $type,
		  'test'=>$test,
          ]);
    }
    /*
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
      $files = Input::file('images');
      $rules = [
        //不能空白
         'type' => 'required',
  	     'description' => 'required|max:100',
  	     'location' => 'required|max:20',
         'found_at' => 'required',
      ];
      foreach ($files as $file) {
        $rules2 = array('file' => 'required|image');
        $validation2 = Validator::make(array('file' => $file),$rules2);
      }
      //validation為submit後至controller的驗證
		    $validation = Validator::make(Input::all(), $rules);

		      if($validation->passes() && $validation2->passes()){
			         $newLostthing = new lostandfound;
			         $newLostthing->type_id = Input::get('type') - 1;
			        $newLostthing->description = Input::get('description');
			        $newLostthing->location  = Input::get('location');
			        $newLostthing->found_at = Input::get('found_at');
			        $newLostthing->created_at = Carbon::now();

			        $images = $request->file('images');
			        $image_count = count($images);
              $userStudentIDNum = Auth::user()->acct;
              $uploadcount = 0 ;
			        $dbID = 1;

			        foreach($images as $image){
                $datetime = new DateTime('now');
                $datetime = $datetime->format("Y-m-d(h:i:s)");
                $randomNum = rand(1000, 9999);
				        $extension = $image->getClientOriginalExtension();
 				        $filename = $datetime.'_'.$randomNum.'.'.$extension;
				        $image ->move($this->photoUploadPath,$filename);
				        $newLostthing["thing_picture".$dbID]= $this->photoUploadPath.'/'.$filename;
				        $uploadcount ++;
				        $dbID ++;
			        }

			           $newLostthing->save();
                 $this->lostToMilitary($newLostthing->id);
                 //$this->sendLostthingMail();

			              if($uploadcount == $image_count){
				                  return Redirect::to('laf');

			              }

		    }else {
          return Redirect::to('laf')
                  ->withInput()
                  ->withErrors($validation);
		    }
      }


    /***
    **
    **
    ** preshow data of lostthing in the tab panel
    **
    */
    public function preshow(Request $request, $type,$status)
    {

      $lostsimple = lostandfound::where('type_id',$type)->where('status', $status)->where('ForwardStatus','default')->orderBy('created_at','desc')->paginate(6,['type_id','created_at','id','location','found_at','description','updated_at','reco_acct','reco_email','reco_phone','claimed_at'])->toArray();
      $lostpic = lostandfound::where('type_id',$type)->where('status', $status)->where('ForwardStatus','default')->orderBy('created_at','desc')->paginate(6,['thing_picture1','thing_picture2','thing_picture3','thing_picture4'])->toArray();

      $losttype = lostType::find($type+1)->name;

      for ($i = 0; $i < count($lostsimple['data']); $i++){

        $pictures = [];
        foreach ($lostpic['data'][$i] as $key => $pic){
          if ($pic != null){

            array_push($pictures, $pic);
          }
        }
        $l = $lostsimple['data'][$i]['type_id'];
        $lostsimple['data'][$i]['type_id'] = lostType::find($l+1)->name;
        $lostsimple['data'][$i]['pictures'] = $pictures;
      }

      //get the client ip
        $ip = $request->ip(); 

      //check user is admin or not  
        $result02 = false;  

        if(Auth::check()){

          if(Auth::user()->acct == 'center18' || Auth::user()->acct == '102502022'){

              $result02 = true;
          }
        }  

      return View::make('laf.thingsdetail', [
        'admin' => $result02,
        'goIP' => $this->testIP($ip),
        'stat' => $status,
        'option' => $type,
        'losttype' => $losttype,
        'lostthing' => $lostsimple,
      ]);
    }

    /**
    *
    * the record of the claimed thing through identity
    *
    */
    public function realSearch(){

      if(Input::has('realsearch')){

        $string = Input::get('realsearch');
        $sub = substr($string, 0, 1);
      /** if you don't have portal , don't search portal record **/
        if (preg_match("/^[a-zA-Z]$/", $sub)) {

          $results = lostandfound::where('status',1)->where('reco_acct', Input::get('realsearch'))->orderBy('created_at','desc');
          $result = $results->get(['type_id','description', 'claimed_at','location', 'updated_at','found_at','thing_picture1','thing_picture2','thing_picture3','thing_picture4'])->toArray();
          $military = 0;

          foreach ($result as $key => $value) {
            $result[$key]['type_id'] = lostType::find($value['type_id'] +1)->name;
          }

          return View::make('laf.claimrecord',[
            'results' => $result,
            'military' => $military,
          ]);
        }else {
          return Redirect::to('laf');
        }

      }
    }
    /**
    *
    * the record of claimed things by acct
    *
    **/
    public function acctSearch(){

      $military = 0;

      if(Auth::check()){
        $acct = Auth::user()->acct;

        $results = lostandfound::where('status', 1)->where('reco_acct', $acct)->orderBy('created_at','desc');
        $result = $results->get(['type_id','description', 'claimed_at', 'location', 'updated_at','found_at','thing_picture1','thing_picture2','thing_picture3','thing_picture4'])->toArray();

        foreach ($result as $key => $value) {
          $result[$key]['type_id'] = lostType::find($value['type_id']+1)->name;
        }

        return View::make('laf.claimrecord',[
          'results' => $result,
          'military' => $military,
        ]);
      }else{
        return Redirect::guest('login');
      }
    }

    /**
     *
     * find the lost thing by input of searchbar
     *
     */
     public function realTimeSearch(){
       $searchResult;

      //keyword is necessary
       if(Input::has('keyword')){
         $searchResult01 = SearchEngine::search(Input::get('keyword'),'lostandfound',['description']);
         $searchResult02 = SearchEngine::search(Input::get('keyword'),'lostandfound',['description']);

         $searchResult = lostandfound::whereIn('id',$searchResult01->lists('id'));
         $supResult = lostandfound::whereIn('id',$searchResult02->lists('id'));

         if(Input::has('type')){

           $searchResult = $searchResult->where('type_id',Input::get('type'));
           $supResult = $supResult->where('type_id',Input::get('type'));

           if(Input::has('status')){

             $searchResult = $searchResult->where('status',Input::get('status'));
             $supResult = $supResult->where('status',Input::get('status'));
           }

         }elseif (Input::has('status')) {

           $searchResult = $searchResult->where('status',Input::get('status'));
           $supResult = $supResult->where('status',Input::get('status'));
         }

         $searchResult = $searchResult->get(['id','status','type_id','description','location','reco_acct','reco_email','reco_phone','created_at','updated_at','found_at','claimed_at'])->toArray();
         $supResult = $supResult->get(['thing_picture1','thing_picture2','thing_picture3','thing_picture4'])->toArray();


         for ($i = 0; $i < count($searchResult); $i++){

          $pictures = [];
          foreach ($supResult[$i] as $key => $pic){

            if ($pic != null){

              array_push($pictures, $pic);
            }
          }
          $s = $searchResult[$i]['type_id'];
          $searchResult[$i]['type_id'] = lostType::find($s+1)->name;
          $searchResult[$i]['pictures'] = $pictures;
        }

         return View::make('laf.realTimeSearchResult',[
          'results' => $searchResult
        ]);
       }
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
    public function update(Request $request,$modal_key)
    {
	       $rules = [
          //不能空白
           'account' => 'required',
    	     'email' => 'required|email',
    	     'phone' => 'required',
        ];
        $recothing = lostandfound::find($modal_key);

	     $validationi = Validator::make(Input::all(), $rules);
        if ($validationi->passes()) {
          $recothing->update([
            'status' => '1',
            'reco_acct' => Input::get('account'),
            'reco_email' => Input::get('email'),
            'reco_phone' => Input::get('phone'),
            'updated_at' => Carbon::now(),
            'claimed_at' => Carbon::now(),
          ]);

          $recothing->save();

          return Redirect::to('laf');

        }elseif($validationi->fails()){
          return Redirect::back()
                  ->withInput()
                  ->withErrors($validationi);
        }


    }

    /**
    *
    *
    * return detail of lost thing before update
    *
    *
    **/
    public function getDetail($modal_key){

      $builder = lostandfound::where('id',$modal_key);

      $lost = $builder->get(['status','type_id','created_at','id','location','found_at','description','updated_at','claimed_at','reco_acct','reco_email','reco_phone'])->toArray();

      $type_all = lostType::all();


      return View::make('laf/editDetail',[
        'id' => $lost[0]['id'],
        'status' => $lost[0]['status'],
        'type_all' => $type_all,
        'type_id' => $lost[0]['type_id'],
        'location' => $lost[0]['location'],
        'description' => $lost[0]['description'],
        'updated_at' => $lost[0]['updated_at'],
        'found_at' => $lost[0]['found_at'],
        'claimed_at' => $lost[0]['claimed_at'],
        'reco_acct' => $lost[0]['reco_acct'],
        'reco_email' => $lost[0]['reco_email'],
        'reco_phone' => $lost[0]['reco_phone'],
      ]);
    }

    /**
    *
    * edit thing detail of lost thing
    *
    *
    **/
    public function updateDetail($id){

        $lost = lostandfound::find($id);

        $lost->update([
            'type_id' => Input::get('type')-1,
            'description' => Input::get('description'),
            'location' => Input::get('location'),
            'updated_at' => Carbon::now(),
            'found_at' => Input::get('found_at'),
            'reco_acct' => Input::get('reco_acct'),
            'reco_email' => Input::get('reco_email'),
            'reco_phone' => Input::get('reco_phone'),
            'claimed_at' => Input::get('claimed_at'),
          ]);

          $lost->save();

          return Redirect::to('laf');
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

    /***
    ***
    ** submitlost 前端ajax驗證
    **
    */
    public function validation()
    {
      $inputData = Input::all();

      $v = Validator::make($inputData,[
        'type' => 'required',
        'description' => 'required|max:100',
        'location' => 'required|max:20',
        'found_at' => 'required',
        'images' => 'required|array|max:4|image',
      ]);

      if ($v->fails()) {
        return json_encode($v->errors());
      }
    }

    // public function sendEmailReminder(){
    //   Mail::send('emails.welcome',,function($message){
    //       $message->from('a0988358096@gmail.com','nothing');
    //       $message->to('a0988358096@yahoo.com.tw');
    //   });
    // }

     /*
    *
    * the mail view list to Military Office
    *
    */
    public function listToMilitary(){
      $result = lostandfound::where('ForwardStatus', 'Forwarding')->where('status',0)->orderBy('created_at','desc')->get()->toArray();

      foreach ($result as $key => $value) {
        $result[$key]['type_id'] = lostType::find($value['type_id'] +1)->name;
      }

      return View::make('laf.ForwardList',[
        'results' => $result,
      ]);
    }

    /*
    *
    * from mail submit losthing list
    *
    */
    public function changeMilitaryStatus(){

      $military = 1;
      $option[] = Input::get('options');
      foreach ($option as $key => $value) {
        //the record in the forward list change their status to already after submit
        lostandfound::find($value)->update(array('ForwardStatus' => 'Already'));
      }
      $result = lostandfound::where('ForwardStatus','Already')->orderBy('created_at','desc')->get()->toArray();

      return View::make('laf.claimrecord',[
        'results' => $result,
        'military' => $military
      ]);
    }

    /*
    *
    * the record delivered to Military Office
    *
    */
    public function toMilitary(){

      $result = lostandfound::where('ForwardStatus', 'Already')->where('status', 0)->orderBy('created_at','desc')->get()->toArray();
      $military = 1;

      foreach ($result as $key => $value) {
        $result[$key]['type_id'] = lostType::find($value['type_id'] +1)->name;
      }

      return View::make('laf.claimrecord',[
        'results' => $result,
        'military' => $military,
      ]);
    }


    /**
    *
    *
    * 介紹寫法：
    *  遺失物轉交教官室的email
    *  用schedule讓物品在提交三個月後還未有人領取的情況下轉變為“應該送到教官室”狀態
    *  用cron執行於server上每三個月送一次email
    *  內容為“應該送到教官室”狀態的所有物品
    *
    **/


    /***
    **
    *
    * update isMilitary column in queue
    *
    **/
    public function lostToMilitary($id){

      $job = (new LostToMilitary($id));
      /*$job = (new LostToMilitary($id))->delay(15552000);*/

      //Queue::later(Carbon::now()->addMonths(3), $job);
      Queue::later(Carbon::now()->addMonths(3), $job);

    }
  }
