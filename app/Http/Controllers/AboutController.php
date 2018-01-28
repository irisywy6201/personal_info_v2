<?php

namespace App\Http\Controllers;

use \App;
use \Auth;
use \File;
use \Input;
use \Lang;
use \Redirect;
use \Validator;
use \View;

use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Contributors;
use App\Entities\ContributorPositions;
use App\Entities\ContributorPositionList;

class AboutController extends Controller
{

	private $rules = [
		'name' => 'required',
		'EnglishName' => 'required',
		'positions' => 'required|exists:contributor_positions,id',
		'introduction' => 'required',
		'EnglishIntroduction' => 'required',
		'ChineseJobResponsibilities' => 'required',
		'EnglishJobResponsibilities' => 'required',
		'profilePicture' => 'required|image'
	];

	private $photoUploadPath = 'upload';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contributors = Contributors::all();

		foreach ($contributors as $key => $contributor) {
			$contributors[$key]['positionIDs'] = Contributors::find($contributor->id)->contributorPositionList()->lists('contributor_positions_id')->all();
		}

		return View::make('about.index')->with([
			'contributors' => $contributors
		]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check() && Auth::user()->isAdmin()) {
			$positions = ContributorPositions::all()->toArray();

			return View::make('about.createContributor')->with([
				'positions' => $positions
			]);
		}
		else {
			return App::abort(401);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::check() && Auth::user()->isAdmin()) {
			$validation = Validator::make(Input::all(), $this->rules);

			if ($validation->passes()) {
				$newContributor = new Contributors;
				$newContributor->name = Input::get('name');
				$newContributor->name_en = Input::get('EnglishName');
				$newContributor->introduction = Input::get('introduction');
				$newContributor->introduction_en = Input::get('EnglishIntroduction');
				$newContributor->job_responsibilities = Input::get('ChineseJobResponsibilities');
				$newContributor->job_responsibilities_en = Input::get('EnglishJobResponsibilities');

				$fileName = Carbon::now() . '_contributorProfileImage_' . $newContributor->id . '_' . rand(100, 999);
				Input::file('profilePicture')->move($this->photoUploadPath, $fileName);
				
				$newContributor->profile_picture = 'upload/' . $fileName;
				$newContributor->save();

				$this->refreshPositionList($newContributor, Input::get('positions'));

				return Redirect::to('about')->with([
					'feedback' => [
						'type' => 'success',
						'message' => Lang::get('alerts.createSuccess', ['item' => Lang::get('about.contributor')])
					]
				]);
			}
			else {
				return Redirect::back()->withInput()->withErrors($validation)->with([
					'feedback' => [
						'type' => 'danger',
						'message' => Lang::get('alerts.createFailure', ['item' => Lang::get('about.contributor')])
					]
				]);
			}
		}
		else {
			return App::abort(401, Lang::get('alerts.createFailure', ['item' => Lang::get('about.contributor')]));
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
		return App::abort(404);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::check() && Auth::user()->isAdmin()) {
			$contributor = Contributors::find($id);
			$positions = ContributorPositions::get(['id', 'name'])->toArray();
			
			foreach ($positions as $key => $position) {
				$positions[$key]['positions'] = ContributorPositionList::where('contributors_id', $id)->where('contributor_positions_id', $position['id'])->get()->toArray();
			}

			if ($contributor) {
				return View::make('about.editContributor')->with([
					'id' => $contributor->id,
					'name' => $contributor->name,
					'nameEn' => $contributor->name_en,
					'introduction' => $contributor->introduction,
					'introductionEn' => $contributor->introduction_en,
					'responsibilities' => $contributor->job_responsibilities,
					'responsibilitiesEn' => $contributor->job_responsibilities_en,
					'profilePicture' => $contributor->profile_picture,
					'positions' => $positions
				]);
			}
			else {
				return App::abort(404, Lang::get('alerts.updateFailure', ['item' => Lang::get('about.contributor')]));
			}
		}
		else {
			return App::abort(401, Lang::get('alerts.updateFailure', ['item' => Lang::get('about.contributor')]));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::check() && Auth::user()->isAdmin()) {
			if ($contributor = Contributors::find($id)) {
				$editRules = $this->rules;
				$editRules['profilePicture'] = 'image';
				$validation = Validator::make(Input::all(), $editRules);

				if ($validation->passes()) {
					$updateContents = [
						'name' => Input::get('name'),
						'name_en' => Input::get('EnglishName'),
						'position_id' => Input::get('position'),
						'introduction' => Input::get('introduction'),
						'introduction_en' => Input::get('EnglishIntroduction'),
						'job_responsibilities' => Input::get('ChineseJobResponsibilities'),
						'job_responsibilities_en' => Input::get('EnglishJobResponsibilities')
					];

					if (Input::hasFile('profilePicture')) {
						$this->deleteProfilePicture($contributor);
						$fileName = Carbon::now() . '_contributorProfileImage_' . $contributor->id . '_' . rand(100, 999);
						Input::file('profilePicture')->move($this->photoUploadPath, $fileName);
						$updateContents['profile_picture'] = 'upload/' . $fileName;
					}

					$this->refreshPositionList(Contributors::find($id), Input::get('positions'));

					$contributor->update($updateContents);

					return Redirect::to('about')->with([
						'feedback' => [
							'type' => 'success',
							'message' => Lang::get('alerts.updateSuccess', ['item' => Lang::get('about.contributor')])
						]
					]);
				}
				else {
					return Redirect::back()->withInput()->withErrors($validation)->with([
						'feedback' => [
							'type' => 'danger',
							'message' => Lang::get('alerts.updateFailure', ['item' => Lang::get('about.contributor')])
						]
					]);
				}
			}
			else {
				return App::abort(404, Lang::get('alerts.updateFailure', ['item' => Lang::get('about.contributor')]));
			}
		}
		else {
			return App::abort(401, Lang::get('alerts.updateFailure', ['item' => Lang::get('about.contributor')]));
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
		if (Auth::check() && Auth::user()->isAdmin()) {
			$contributor = Contributors::find($id);

			if ($contributor) {
				$this->deleteProfilePicture($contributor);
			}

			$contributor->contributorPositionList()->delete();
			$contributor->delete();

			return Redirect::to('about')->with([
				'feedback' => [
					'type' => 'success',
					'message' => Lang::get('alerts.deleteSuccess', ['item' => Lang::get('about.contributor')])
				]
			]);
		}
		else {
			return App::abort(401, Lang::get('alerts.deleteFailure', ['item' => Lang::get('about.contributor')]));
		}
	}

	/**
	 * Delete the old profile picture of contributor.
	 *
	 * @param Model $contributor
	 * @return bool Returns True if the profile picture
	 * of this contributor exists and was deleted, return
	 * False if the profile picture of this contributor
	 * does not exist.
	 */
	private function deleteProfilePicture($contributor)
	{
		if (File::exists($contributor->profile_picture)) {
			File::delete($contributor->profile_picture);
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Refreshes the position list of certain contributor.
	 *
	 * @param Model $contributor The ID number of contributor.
	 * @param array $positions The new position list.
	 */
	private function refreshPositionList($contributor, $positions)
	{
		$contributor->contributorPositionList()->delete();
		
		foreach ($positions as $key => $positionID) {
			$newList = new ContributorPositionList;
			$newList->contributors()->associate($contributor);
			$newList->contributorPositions()->associate(ContributorPositions::find($positionID));
			$newList->save();
		}
	}
}
