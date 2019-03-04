<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BadgeController extends Controller
{
	public function get_badges() {
		# $registcnt = User::where('status', '=', 'regist')->count();
		#if ($registcnt == 0) {
		#	$registcnt = '';
		#}
		return Response::json(array (
			'#menu-badge-usrmgr' => 0,
			'#menu-badge-regist' => 6,
		));
	}
}
