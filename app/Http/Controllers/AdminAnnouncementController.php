<?php

namespace App\Http\Controllers;

use \Auth;
use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Announcement;

class AdminAnnouncementController extends Controller
{
	private $rules = [
		'g-recaptcha-response' => 'required|recaptcha',
		'title' => 'required'
	];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$announcement = Announcement::orderBy('updated_at','desc')->get();
		return View::make('admin.Announcement.adminAnnouncement',array(
			'title'=> Lang::get('Admin/Announcement.manageAnnouncement'),
			'announcement' => $announcement
		));

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.Announcement.adminCreateAnnouncement',array(
			'title'=> Lang::get('Admin/Announcement.createAnnouncement')
			));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validation = Validator::make(Input::all(), $this->rules);
	
		if ($validation->passes()) {
			$Announcement = new Announcement();
			$Announcement ->announceUser = Auth::user()->acct;
			$Announcement->title = Input::get('title');
			if(Input::has('isSticky'))
			{
				$Announcement->isSticky =1;
			}
			
			if(Input::has('link'))
			{
				$Announcement->link = Input::get('link');
				$Announcement->isLink = 1;
			}
			$Announcement->save();
		
			return Redirect::to('admin/announcement')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('Admin/Announcement.announcement')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('Admin/Announcement.announcement')])
				]
			]);
		}
		

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$announcement = Announcement::find($id);
		return View::make('admin.Announcement.adminDetailAnnouncement',array(
			'title'=> Lang::get('Admin/Announcement.manageAnnouncement'),
			'announcement' => $announcement
			));

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$announcement = Announcement::find($id);
		return View::make('admin.Announcement.adminEditAnnouncement',array(
			'title'=> Lang::get('Admin/Announcement.editAnnouncement'),
			'announcement' => $announcement
			));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validation = Validator::make(Input::all(), $this->rules);
	
		if ($validation->passes()) {
			$Announcement = Announcement::find($id);
			$Announcement ->announceUser = Auth::user()->acct;
			$Announcement->title = Input::get('title');
			if(Input::has('isSticky'))
			{
				$Announcement->isSticky =1;
			}
			else {
				$Announcement->isSticky =0;
			}
			
			if(Input::has('link'))
			{
				$Announcement->link = Input::get('link');
				$Announcement->isLink = 1;
			}
			else {
				$Announcement->link ="";
				$Announcement->isLink = 0;
			}
			$Announcement->save();
					return Redirect::to('admin/announcement')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('Admin/Announcement.announcement')])
				]
			]);
		}
		else {
			return Redirect::back()->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('Admin/Announcement.announcement')])
				]
			]);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Announcement::destroy($id);

		return Redirect::to('admin/announcement');
	}
}