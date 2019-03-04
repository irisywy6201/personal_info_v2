<?php

namespace App\Entities;

class ApproveManager extends BaseEntity
{
	protected $table = 'approveManagerEmail';

	public function scopeGetEmail($query) 
	{
		return ApproveManager::where('id', '=', 1)->pluck('email');
	}

	public function scopeGetTime($query) 
	{
		return $query->where('id', '=', 1)->pluck('created_at');
	}

	public function scopeGetAccount($query) 
	{
		return $query->where('id', '=', 1)->pluck('changedBy');
	}
}

?>