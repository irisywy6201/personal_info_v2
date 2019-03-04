<?php

namespace App\Http\Controllers;

use \App;
use \Input;
use \Redirect;
use \URL;
use \Request;
use \SearchEngine;
use \View;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\Faq;

class FaqController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::to('faq/sd');
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
		//
	}


	/**
	 * Shows the base department FAQ page.
	 *
	 * @param  string  $departmentHref
	 * @return Response
	 */
	public function show($departmentHref)
	{
		$departments;
		$currentLocations;
		$nextLevelFAQs;
		$departmentID = Category::where('href_abb', $departmentHref)->pluck('id');
		$department = Category::find($departmentID);

		if (Category::first() == null)
		{
			return View::make('faq.emptyState');
		}

		if (!$department || $department->isHidden()) {
			return App::abort(404);
		}
		elseif ($this->checkIsLeaf([$departmentHref])) {
			return $this->showFAQLists($departmentHref);
		}
		else {
			$departments = Category::topLevelCategories()->notHidden()->get(['id']);
			$currentLocations = $this->getLocationLinks([$departmentHref]);
			$nextLevelFAQs = $this->getNextLevelFAQs($currentLocations[count($currentLocations) - 1]['id']);		

			foreach ($departments as $key => $department) {
				$departments[$key]['link'] = Category::find($department['id'])->href_abb;
			}

			return View::make('faq.faq', [
				'departments' => $departments,
				'locations' => $currentLocations,
				'nextLevelFAQs' => $nextLevelFAQs
			]);
		}
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Show the FAQ question lists.
	 * This function should be called when the leaf location
	 * is reached.
	 *
	 * @param array $departments The ID numbers of categories
	 * as departments.
	 * @param array $locations The location history user passed.
	 * @return Response.
	 */
	public function showFAQLists($departmentHref, $subHref, $otherHrefs = null)
	{
		$departments = Category::topLevelCategories()->notHidden()->get(['id']);
		$currentLocations = $this->urlLocationToArray($departmentHref, $subHref, $otherHrefs);
		$locationLinks = $this->getLocationLinks($currentLocations);
		$lastLocation = $locationLinks[count($locationLinks) - 1];
		$faqs = [];

		foreach ($departments as $key => $department) {
			$departments[$key]['link'] = Category::find($department['id'])->href_abb;
		}

		if ($this->checkIsLeaf($currentLocations)) {
			$faqIDs = Faq::where('category', $lastLocation['id'])->lists('id')->all();
			
			array_push($faqs, [
				'category' => null,
				'faqs' => $faqIDs
			]);
		}
		else {
			$leafIDs = Category::find($lastLocation['id'])->leaves()->notHidden()->lists('id')->all();
			
			foreach ($leafIDs as $key => $id) {
				array_push($faqs, [
					'category' => Category::find($id)->getCategoryIDChainToRoot()->notHidden(),
					'faqs' => Faq::where('category', $id)->lists('id')->all()
				]);
			}
		}

		return View::make('faq.faqList', [
			'departments' => $departments,
			'locations' => $this->getLocationLinks($currentLocations),
			'faqs' => $faqs
		]);
	}

	private function urlLocationToArray($departmentHref, $subHref, $otherHrefs = null)
	{
		$urlArray;

		if ($otherHrefs) {
			$urlArray = array_merge([$departmentHref], [$subHref], explode('/', $subHrefs));
		}
		else {
			$urlArray = [$departmentHref, $subHref];
		}

		return $urlArray;
	}

	/**
	 * Traces back all levels of the locations until reaches
	 * the top level category, then get all corresponding
	 * links of each level of location and return it.
	 *
	 * @param array $locations All locations user has visited.
	 * @return array Returns an array containing category ID
	 * and the corresponding link as a row of each location
	 * visited by user.
	 */
	private function getLocationLinks($locations)
	{
		$currentLocation = URL::to('faq');
		$currentCategoryID;
		$results = [];

		foreach ($locations as $key => $value) {
			$currentCategoryID = Category::where('href_abb', $value)->pluck('id');
			$currentLocation = $currentLocation . '/' . $value;

			array_push($results, [
				'id' => $currentCategoryID,
				'link' => $currentLocation
			]);
		}

		return $results;
	}

	/**
	 * Get informations about the next level FAQ page.
	 *
	 * @param int $currentCategoryID The category ID which 
	 * the corresponding category is used by current FAQ page.
	 * @return array Returns an array containing informations
	 * about the sub-categories. If there's no sub-categories
	 * of given category ID, that is, the given category ID is
	 * a leaf in category chain, then an empty array will be
	 * returned.
	 */
	private function getNextLevelFAQs($currentCategoryID)
	{
		$currentCategory;
		$nextLevelFAQs = [];
		$subCategoriesIDs = Category::find($currentCategoryID)
			->subCategories()->notHidden()->orderBy('order')->lists('id')->all();

		if ($subCategoriesIDs) {
			foreach ($subCategoriesIDs as $key => $value) {
				$currentCategory = Category::find($value);

				array_push($nextLevelFAQs, [
					'id' => $currentCategory->id,
					'link' => Request::url() . '/' . $currentCategory->href_abb,
					'hotLists' => $this->getHotLists($currentCategory->id)
				]);
			}
		}

		return $nextLevelFAQs;
	}

	/**
	 * Get the hot FAQs under specific category.
	 *
	 * @param int $categoryID The category ID which
	 * the hot FAQs belongs to.
	 * @return array Returns 5 hotest FAQ questions.
	 */
	private function getHotLists($categoryID)
	{
		$category = Category::find($categoryID);
		$faqs;
		$results = [];
		$currentFAQ;

		if ($category->isLeaf()) {
			$faqs = $category->faqs()->take(5)->lists('id')->all();
		}
		else {
			$category = $category->leaves()->notHidden()->lists('id')->all();
			$faqs = Faq::whereIn('category', $category)
				->orderBy('popularity', 'desc')->take(5)->lists('id')->all();
		}

		foreach ($faqs as $key => $id) {
			$currentFAQ = Faq::find($id);

			array_push($results, [
				'id' => $currentFAQ->id,
				'link' => $currentFAQ->getLink()
			]);
		}

		return $results;
	}

	/**
	 * Check the current location (last element of the
	 * given array) is leaf or not.
	 *
	 * @param array $locations The current location.
	 * @return bool Returns True if current location is
	 * leaf, returns False if current location is not leaf.
	 */
	private function checkIsLeaf($locations)
	{
		$lastLocation = $locations[count($locations) - 1];
		$categoryID = Category::where('href_abb', $lastLocation)->pluck('id');

		return Category::find($categoryID)->isLeaf();
	}

	/**
	 * This function is provided for client real time
	 * Ajax searching.
	 */
	public function realTimeSearch() {
		$searchResult;

		if (Input::has('keyword')) {
			$searchResult = SearchEngine::search(Input::get('keyword'), 'faq', [
				Faq::getTitleColumnName(),
				Faq::getContentColumnName()
			]);

			if (Input::has('department') && Input::has('category')) {
				$categoryID = Input::get('category');

				if (Category::find($categoryID)->notHidden()->get()->toArray()) {
					$searchResult = Faq::whereIn('id', $searchResult->lists('id')->all())
						->where('category', $categoryID);
				}
			}

			$searchResult = $searchResult->orderBy('popularity', 'desc')->lists('id')->all();

			foreach ($searchResult as $key => $faqID) {
				$searchResult[$key] = [
					'id' => $faqID,
					'link' => Faq::find($faqID)->getLink()
				];
			}

			return View::make('faq.realTimeSearchResult')->with(['results' => $searchResult]);
		}
	}
	
	// Use faq id to return location in faq (use in index hot faq)
	public function getLinkByFaqId($id)
	{
		return Redirect::to(Faq::find($id)->getLink());
	}
}
