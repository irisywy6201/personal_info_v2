<?php

namespace App\Entities;

class Approve extends BaseEntity
{
	protected $table = 'approve';

	public function scopeWaitingApprove($query) 
	{
		return $query->where('status', '0');
	}

	public function scopeApproved($query) 
	{
		return $query->where('status', '1')->orwhere('status', '2')->orderBy('created_at', 'desc');
	}
}

?>