<?php
	use App\Entities\Contributors;

	$results = [];
	$contributors = Contributors::get(['id', 'name_en', 'introduction_en', 'job_responsibilities_en']);

	foreach ($contributors as $key => $contributor) {
		$results[$contributor->id] = [
			'name' => $contributor['name_en'],
			'introduction' => $contributor['introduction_en'],
			'jobResponsibilities' => $contributor['job_responsibilities_en']
		];
	}

	return $results;
?>
