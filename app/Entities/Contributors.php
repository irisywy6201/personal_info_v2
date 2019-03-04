<?php

namespace App\Entities;

class Contributors extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contributors';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'name_en', 'introduction', 'introduction_en', 'job_responsibilities', 'job_responsibilities_en', 'profile_picture'];

	/**
	 * Contributor __has_many__ ContributorPositionList.
	 */
	public function contributorPositionList()
	{
		return $this->hasMany('ContributorPositionList');
	}
}

?>