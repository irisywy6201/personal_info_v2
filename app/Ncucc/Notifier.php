<?php

namespace App\Ncucc;

use Closure;
use \Queue;
use Carbon\Carbon;
use App\Jobs\ClosureExecutor;

class Notifier
{
	public function __construct()
	{
		//
	}

	public static function setCheckPoint($date, Closure $rule, Closure $handler)
	{
		if ($date->gt(Carbon::now())) {
			Queue::later($date - Carbon::now(), new ClosureExecutor($this->handler));

			return true;
		}
		else {
			return false;
		}
	}

	private function handler(Closure $rule, Closure $handler)
	{
		if ($rule()) {
			$handler();
		}
	}
}

?>