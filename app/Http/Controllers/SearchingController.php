<?php

namespace App\Http\Controllers;

use \Input;
use \Lang;
use \Redirect;
use \SearchEngine;
use \URL;
use \Validator;
use \View;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Faq;
use App\Entities\Reply;

class SearchingController extends Controller
{
	private $rules = [
		'query' => 'required'
	];
	
	public static $locations = [
		'FAQ' => 'faq',
		'MESSAGE_BOARD' => 'msg_board'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$validation = Validator::make(Input::all(), $this->rules);
		$queryString;
		$FAQResults;

		if ($validation->passes()) {
			$queryString = Input::get('query');
			$FAQResults = $this->getFAQKeywordResults($queryString);

			Input::flash();

			return View::make('searching.searchResults')->with([
				'query' => $queryString,
				'results' => $this->paginate($FAQResults, $queryString),
				'location' => self::$locations['FAQ'],
				'locations' => self::$locations
			]);
		}
		else {
			return Redirect::intended(URL::previous())->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('searching.searchingFailure')
				],
				'location' => self::$locations['FAQ'],
				'locations' => self::$locations
			]);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return App::abort(404);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return App::abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  string  $filter
	 * @return Response
	 */
	public function show($filter)
	{
		$validation = Validator::make(Input::all(), $this->rules);

		if ($validation->passes()) {
			$queryString = Input::get('query');
			$results = $this->getResults($queryString, $filter);

			Input::flash();

			return View::make('searching.searchResults')->with([
				'query' => $queryString,
				'results' => $this->paginate($results, $queryString),
				'location' => $filter,
				'locations' => self::$locations
			]);
		}
		else {
			return Redirect::intended(URL::previous())->withErrors($validation)->withInput()->with([
				'feedback' => [
					'type' => 'danger',
					'message' => Lang::get('searching.searchingFailure'),
					'location' => $filter
				],
				'locations' => self::$locations
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
		return App::abort(404);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return App::abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return App::abort(404);
	}

	/**
	 * Get the results which match the given keyword.
	 *
	 * @param string $keyword The keyword to be matched.
	 * @param int $filter The location of our website.
	 * @return array The result which matches the given
	 * keyword at the specific location of our website.
	 * If the $filter parameter is not given, null will
	 * be returned.
	 */
	private function getResults($keyword, $filter)
	{
		switch ($filter) {
			case self::$locations['FAQ']:
				return $this->getFAQKeywordResults($keyword);
			case self::$locations['MESSAGE_BOARD']:
				return $this->getMessageBoardResults($keyword);
			default:
				return null;
		}
	}

	/**
	 * Get the FAQs which contain the given keyword.
	 *
	 * @param String $keyword The keyword to be searched.
	 * @return Array Returns the FAQs which contain the
	 * given keyword.
	 */
	private function getFAQKeywordResults($keyword)
	{
		$titleColumnName = Faq::getTitleColumnName();
		$contentColumnName = Faq::getContentColumnName();

		$results = SearchEngine::search($keyword, 'faq', [$titleColumnName, $contentColumnName])->get();

		$resultFixed = [];

		foreach ($results as $key => $value) {
			array_push($resultFixed, [
				'title' => $value[$titleColumnName],
				'content' => $value[$contentColumnName],
				'link' => Faq::find($value['id'])->getLink()
			]);
			unset($results[$key]);
		}

		return $resultFixed;
	}

	/**
	 * Get the messages which contain the given keyword.
	 *
	 * @param String $keyword The keyword to be searched.
	 * @return Array Returns the message which contain the
	 * given keyword.
	 */
	private function getMessageBoardResults($keyword)
	{
		$results = SearchEngine::search($keyword, 'question', ['title', 'content'])->get();
		$resultFixed = [];

		foreach ($results as $key => $value) {
			$resultFixed[$value['id']] = [
				'title' => $value['title'],
				'content' => $value['content'],
				'link' => URL::to('msg_board/' . $value['id'])
			];
			unset($results[$key]);
		}

		$results = $this->getMessageResultsByReply($keyword);

		foreach ($results as $key => $value) {
			$resultFixed[$value['id']] = [
				'title' => $value['title'],
				'content' => $value['content'],
				'link' => URL::to('msg_board/' . $value['id'])
			];
			unset($results[$key]);
		}

		return $resultFixed;
	}

	/**
	 * Get the messages whose replies contain the given keyword.
	 *
	 * @param String $keyword The keyword to be searched.
	 * @return Array Returns the message whose replies
	 * contain the given keyword.
	 */
	private function getMessageResultsByReply($keyword)
	{
		$results = SearchEngine::search($keyword, 'reply', 'content')->get();
		$resultFixed = [];
		$question;

		foreach ($results as $key => $value) {
			$question = Reply::find($value['id'])->question()->first();
			
			$resultFixed[$question->id] = [
				'id' => $question->id,
				'title' => $question->title,
				'content' => $question->content,
				'link' => URL::to('msg_board/' . $question->id)
			];
			unset($results[$key]);
		}

		return $resultFixed;
	}

	/**
	 * Paginate the given result.
	 *
	 * @param array $searchResults The results to be paginated.
	 * @param string $queryString The given keyword.
	 * @return Paginator The paginated results.
	 */
	private function paginate($searchResults, $queryString)
	{
		$currentPage = Input::get('page', 1) - 1;
		$perPage = 5;
		$pageData = array_slice($searchResults, $currentPage * $perPage, $perPage);
		$totalResults = count($searchResults);

		$paginator = new Paginator($pageData, $totalResults, $perPage, null, [
			'path' => 'searching'
		]);
		$paginator->appends('query', $queryString);

		return $paginator;
	}
}
