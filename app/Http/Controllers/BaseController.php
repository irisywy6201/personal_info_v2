<?php

class BaseController extends Controller {

	//$rule = array(array());
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
/*
	protected function realTimeValidation()
	{
		foreach (Input::all() as $key => $value) 
		{
			$validator = Validator::make($key, $rules);	
		}
	}
*/
}