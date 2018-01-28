<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Redirect;
//use \Request;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Readme;

class ReadmeController extends Controller
{
	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'id' => 'required',
		'title_zh' => 'required',
		'title_en' => 'required',
		'Content_zh' => 'required',
		'Content_en' => 'required',
	];
	
	public function index()
	{
		$readme = Readme::all();
		return view('Auth_soft/readme',[
			'readme' => $readme,
		]);
	}
	
	
}