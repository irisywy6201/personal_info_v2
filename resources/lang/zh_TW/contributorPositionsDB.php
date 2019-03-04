<?php
	use App\Entities\ContributorPositions;

	$results = [];
	$contributorPositions = ContributorPositions::get(['id', 'name', 'detail']);

	foreach ($contributorPositions as $key => $position) {
		$results[$position->id] = [
			'name' => $position['name'],
			'detail' => $position['detail']
		];
	}

	return $results;
?>
