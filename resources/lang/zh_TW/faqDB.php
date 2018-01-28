<?php
	use App\Entities\Faq as Faq;

	$results = [];
	$databaseLanguages = Faq::get(['id', 'name', 'answer']);	

	foreach ($databaseLanguages as $key => $row) {
		$id = $row['id'];
		$results[$id]['name'] = $row['name'] ? $row['name'] : '未命名標題';
		$results[$id]['answer'] = $row['answer'] ? $row['answer'] : '尚無描述';
		unset($databaseLanguages[$key]);
	}

	return $results
?>