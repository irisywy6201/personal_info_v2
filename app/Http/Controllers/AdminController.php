<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\SectionOne;
use App\SectionTwo;
use App\SectionThree;

class AdminController extends Controller
{
    public function index(){
		if(Auth::user()){
		return view('admin.index');
		}
		else {
		return redirect('/login');
		}
		
	}
}
