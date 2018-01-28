<?php

namespace App\Entities;

class ContactPersonRoles extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contact_person_roles';
	protected $primaryKey = 'id';
	protected $fillable = ['name_zh_TW', 'name_en', 'description_zh_TW', 'description_en'];

	/**
	 * ContactPersonRoles __has_many__ ContactPersonPosition.
	 */
	public function contactPersonPositions()
	{
		return $this->hasMany('ContactPersonPosition');
	}
}

?>