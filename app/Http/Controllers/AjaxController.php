<?php

namespace App\Http\Controllers;

use \Input;
use \Lang;
use \Response;
use \SearchEngine;
use \Validator;

use Illuminate\Database\Query\Grammars;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Category;
use App\Entities\Faq;

class AjaxController extends Controller
{
	public function setNewPassFormatControllerMethod($inputData)
	{
		$newPass 				= $inputData['newPass']; 
		$newPass_confirmation 	= $inputData['newPass_confirmation'];

		$rules = array(
			// 要和確認密碼欄位相同  // 不可以空白  
			// 至少有一個英文大寫 一個英文小寫 一個數字  
			// 至少有 8 個字
	        //$inputData['whichInput'] 	=> array('confirmed','required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	        $newPass 				=> array('required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	        //'newPass_confirmation' 	=> array('required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	    	$newPass_confirmation 	=> array('required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	    );

	    $rules2 = array(
	    	
	    );

	    $validator = Validator::make($inputData, $rules);

	    /*
	    if($inputData['whichInput'] == 'newPass')
	    {
	    	$validator = Validator::make(Input::all(), $rules);
	    }else
	    {
	    	$validator = Validator::make(Input::all(), $rules2);
	    }
	    */

	    if ($validator->fails())
	    {
	    	//$errorsMessages = $validation->messages();
	        //$errorsMessages 				= $validator->errors()->all();
	        //$resultArray = $validator->messages()->toJson();

	        $returnData = array(
				'status'	=> 'f',
				'error' 	=> $validator->getMessageBag()->toArray()
			);

			return Response::json($returnData);

	    } else 
	    {
	    	$returnData = array(
				'status'	=> 't',
			);

	    	return Response::json($returnData);
	    }

	}

	public function setNewPassFormat()
	{
		$inputData = Input::all();

		$rules = array(
			// 要和確認密碼欄位相同  // 不可以空白  
			// 至少有一個英文大寫 一個英文小寫 一個數字  
			// 至少有 8 個字
	        //$inputData['whichInput'] 	=> array('confirmed','required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	        'newPass' 				=> array('confirmed', 'required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	        //'newPass_confirmation' 	=> array('required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	    );

	    $rules2 = array(
	    	'newPass_confirmation' 	=> array('required', 'regex: /^[A-Z]/','regex: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'),
	    );

	    if($inputData['whichInput'] == 'newPass')
	    {
	    	$validator = Validator::make(Input::all(), $rules);
	    }else
	    {
	    	$validator = Validator::make(Input::all(), $rules2);
	    }
	    

	    if ($validator->fails())
	    {
	    	//$errorsMessages = $validation->messages();
	        //$errorsMessages 				= $validator->errors()->all();
	        //$resultArray = $validator->messages()->toJson();

	        $returnData = array(
				'status'	=> 'f',
				'error' 	=> $validator->getMessageBag()->toArray()
			);

			return Response::json($returnData);

	    } else 
	    {
	    	$returnData = array(
				'status'	=> 't',
			);

	    	return Response::json($returnData);


	    }

	}

	public function forgetPassInputCheck($inputData)
	{
		$rules = array(
	        $inputData['whichInput'] => 'required',
	    );
	    $validator = Validator::make(Input::all(), $rules);

	    if ($validator->fails())
	    {
	        $errorsMessages 				= $validator->errors()->all();
	        $inputData['empty'] 			= 'empty';
	        $inputData['errorsMessages']	= $errorsMessages;
	        $resultArray					= json_encode($inputData);
			return $resultArray; 

	    } else 
	    {
	    	$inputData['empty'] = 'notEmpty';
	    	/*
	        // validation successful ---------------------------

	        // our duck has passed all tests!
	        /*
	        $duck = new Duck;
	        $duck->name     = Input::get('name');
	        $duck->email    = Input::get('email');
	        $duck->password = Hash::make(Input::get('password'));
	        $duck->save();
	        */
	        $resultArray	= json_encode($inputData);
			return $resultArray;

	    }
	}

	public function forgetPassInputIsEmpty()
	{
		$inputData = Input::all();
		return $this->forgetPassInputCheck($inputData);
	}
	
	/**
	 * Gets all needed information of the children of given
	 * category.
	 *
	 * @return JSON All children of given category.
	 */
	public function getCategory($parent)
	{
		$categories = [];

		if ($parent == 0) {
			$categories = Category::notHidden()->get(['id', 'leaf', 'parent_id'])->toArray();
		}
		else {
			$categories = Category::find($parent)->children()->notHidden()->get(['id', 'leaf', 'parent_id'])->toArray();
		}

		for ($i = 0; $i < count($categories); $i++) {
			$categories[$i]['name'] = Lang::get('category.' . $categories[$i]['id'] . '.name');
		}

		return Response::json($categories);
	}

	public function getCategMaxLayer()
	{
		return Category::getMaxLayer()->notHidden();
	}

	/**
	 * Get the suggestions for user who
	 * wants to create a new question.
	 *
	 * @param String $title The title of question.
	 * @param Integer $department The category ID
	 * as a department which the question belongs to.
	 * @param Integer $category The category ID which
	 * the question belongs to.
	 * @return JSON Suggestion messages.
	 */
	public function suggestionHelper()
	{
		$result = [];
		$response = [];
		$title = '';
		$builder;

		if (Input::has('title')) {
			$title = Input::get('title');
			$result = SearchEngine::search($title, 'faq', [Faq::getTitleColumnName()]);

			if (Input::has('category')) {
				$result = $result->where('category', Input::get('category'));
			}

			$result = $result->orderBy('popularity', 'desc')->take(5)->lists('id')->all();
		
			foreach ($result as $key => $id) {
				$response[$key] = [];
				$response[$key]['title'] = Lang::get('faqDB.' . $id . '.name');
				$response[$key]['href'] = Faq::find($id)->getLink();
			}
		}

		return json_encode($response);
	}
}
