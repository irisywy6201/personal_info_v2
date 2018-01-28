<?php
	use App\Entities\ContactPersonRoles;

	$results = [];
	$contactPersonRoles = ContactPersonRoles::get(['id', 'name_zh_TW', 'description_zh_TW']);

	foreach ($contactPersonRoles as $key => $role) {
		$results[$role->id] = [
			'name' => $role['name_zh_TW'],
			'description' => $role['description_zh_TW']
		];
	}

	return $results;
?>
