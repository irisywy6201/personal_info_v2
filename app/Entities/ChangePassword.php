<?php

namespace App\Entities;

class ChangePassword extends BaseEntity
{
	// 若不加上 false 則在 database save 時會將目前時間加入 
	// update_at column (update_at 不一定存在)
	public $timestamps = false;
	
	protected $table = 'changePassword';

}

?>