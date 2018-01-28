<?php

namespace App\Http\Controllers;

use \Input;
use \Redirect;
use \Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
	/**
	 * Set Language to Traditional Chinese.
	 *
	 * @see app/start/global.php
	 * @return Response.
	 */
	public function chinese()
	{
		Session::put('locale', 'zh_TW');
		$this->putReminder('zh_TW');

		Input::flash();

		return Redirect::back();
	}

	/**
	 * Set Language to English.
	 *
	 * @see app/start/global.php
	 * @return Response.
	 */
	public function english()
	{
		Session::put('locale', 'en');
		$this->putReminder('en');

		Input::flash();

		return Redirect::back(); 
	}

	private function putReminder($locale)
	{
		Session::flash('newLocale', $locale);
	}
}