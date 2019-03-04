<?php
	use App\Entities\Faq as Faq;

	$results = [];
	$databaseLanguages = Faq::get(['id', 'name_en', 'answer_en']);	

	foreach ($databaseLanguages as $key => $row) {
		$id = $row['id'];
		$results[$id]['name'] = $row['name_en'] ? $row['name_en'] : 'Unnamed';
		$results[$id]['answer'] = $row['answer_en'] ? $row['answer_en'] : 'No description currently';
		unset($databaseLanguages[$key]);
	}

	return $results
?>