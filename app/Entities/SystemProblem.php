<?php

namespace App\Entities;

class SystemProblem extends BaseEntity
{

	protected $table = 'sysProb';
	/* Scope for Approved or not */
	public function scopeExists($query) {
		return $query->where('isSolved', '0');
	}

}

?>