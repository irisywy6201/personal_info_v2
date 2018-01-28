<?php
	use App\Entities\ContactPersonRoles;

	$results = [];
	$contactPersonRoles = ContactPersonRoles::get(['id', 'name_en', 'description_en']);

	foreach ($contactPersonRoles as $key => $role) {
		$results[$role->id] = [
			'name' => $role['name_en'],
			'description' => $role['description_en']
		];
	}

	return $results;
?>
