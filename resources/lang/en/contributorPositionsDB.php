<?php
	use App\Entities\ContributorPositions;

	$results = [];
	$contributorPositions = ContributorPositions::get(['id', 'name_en', 'detail_en']);

	foreach ($contributorPositions as $key => $position) {
		$results[$position->id] = [
			'name' => $position['name_en'],
			'detail' => $position['detail_en']
		];
	}

	return $results;
?>
