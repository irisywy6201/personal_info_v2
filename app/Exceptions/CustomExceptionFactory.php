<?php

namespace App\Exceptions;

use Exception;

class CustomExceptionFactory
{
	/**
	 * Generate the corresponding custom exception
	 * from the given exception.
	 *
	 * @param \Exception $e
	 * @return mixed Returns the corresponding custom
	 * exception.
	 */
	public function make(Exception $e)
	{
		if ($this->isIronIoException($e)) {
			return new IronException();
		}
		else {
			return null;
		}
	}

	/**
	 * Check if the given Exception is an Iron.io exception.
	 *
	 * @param \Exception $e
	 * @return bool
	 */
	private function isIronIoException(Exception $e)
    {
        $errorCode = $e->getCode();
        $errorMessage = $e->getMessage();

        return $errorCode === 0 && strpos($errorMessage, 'iron.io') !== false;
    }
}

?>