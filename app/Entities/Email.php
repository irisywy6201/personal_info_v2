<?php

namespace App\Entities;

use Carbon\Carbon;

class Email extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'email';
	protected $primaryKey = 'id';
	protected $fillable = array('id','user_id','address','verified','hash','due','created_at','updated_at');

	/**
	 * Email __belongs_to__ User.
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}
}

?>
