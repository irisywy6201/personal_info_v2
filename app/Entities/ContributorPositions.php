<?php

namespace App\Entities;

class ContributorPositions extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contributor_positions';
	protected $primaryKey = 'id';
	protected $fillable = ['name', 'name_en', 'detail', 'detail_en'];

	/**
	 * ContributorPositions __has_many__ ContributorPositionList.
	 */
	public function contributorPositionList()
	{
		return $this->hasMany('ContributorPositionList');
	}
}

?>