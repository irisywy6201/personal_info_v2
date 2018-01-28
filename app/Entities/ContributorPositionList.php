<?php

namespace App\Entities;

class ContributorPositionList extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contributor_position_list';
	protected $primaryKey = 'id';

	/**
	 * ContributorPositionList __belongs_to__ Contributor.
	 */
	public function contributors()
	{
		return $this->belongsTo('Contributors');
	}

	/**
	 * ContributorPositionList __belongs_to__ ContributorPosition.
	 */
	public function contributorPositions()
	{
		return $this->belongsTo('ContributorPositions');
	}
}

?>