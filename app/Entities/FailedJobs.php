<?php

namespace App\Entities;

class FailedJobs extends BaseEntity
{

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'failed_jobs';
	protected $primaryKey = 'id';

	public $timestamps = false;
}

?>