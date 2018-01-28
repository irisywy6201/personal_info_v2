<?php

namespace App\Exceptions;

use Exception;
use \Lang;

class IronException extends Exception
{
	public function __construct($message = null, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->message = Lang::get('errors.iron.title');
		$this->code = 504;
	}

	/**
	 * Get the status code of this exception.
	 *
	 * @return string
	 */
	final public function getStatusCode()
	{
		return 'iron';
	}
}

?>