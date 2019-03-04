<?php

namespace App\Entities;

class Reply extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reply';
	protected $primaryKey = 'id';
	protected $fillable = ['content'];

	/**
	 * Reply __belongs_to__ User.
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Reply __belongs_to__ Question.
	 */
	public function question()
	{
		return $this->belongsTo('Question');
	}
}

?>