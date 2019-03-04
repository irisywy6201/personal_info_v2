<?php

namespace App\Entities;

class ContactPersonPosition extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contact_person_position';
	protected $primaryKey = 'id';

	const ROLE_MANAGER = 1;
	const ROLE_CONTACT_PERSON = 2;

	/**
	 * ContactPersonPosition __belongs_to__ User.
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * ContactPersonPosition __belongs_to__ Category.
	 */
	public function category()
	{
		return $this->belongsTo('Category');
	}

	/**
	 * ContactPersonPosition __belongs_to__ ContactPersonRoles.
	 */
	public function contactPersonRole()
	{
		return $this->belongsTo('ContactPersonRoles');
	}

	public function scopeContactPerson($query)
	{
		return $query->where('contact_person_roles_id', ContactPersonPosition::ROLE_CONTACT_PERSON);
	}

	public function scopeManager($query)
	{
		return $query->where('contact_person_roles_id', ContactPersonPosition::ROLE_MANAGER);
	}
}

?>