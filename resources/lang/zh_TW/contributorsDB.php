<?php
	use App\Entities\Contributors;

	$results = [];
	$contributors = Contributors::get(['id', 'name', 'introduction', 'job_responsibilities']);

	foreach ($contributors as $key => $contributor) {
		$results[$contributor->id] = [
			'name' => $contributor['name'],
			'introduction' => $contributor['introduction'],
			'jobResponsibilities' => $contributor['job_responsibilities']
		];
	}

	return $results;
?>
