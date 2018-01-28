<?php
	use App\Entities\Category;

	$result = [[
		'name' => 'Unclassified',
		'description' => 'No description currently'
	]];
	$databaseLanguages = Category::get(['id', 'name_en', 'describe_en']);

	foreach ($databaseLanguages as $key => $row) {
		$id = $row['id'];
		$result[$id]['name'] = $row['name_en'] ? $row['name_en'] : 'Unnamed';
		$result[$id]['description'] = $row['describe_en'] ? $row['describe_en'] : 'No description currently';
		unset($databaseLanguages[$key]);
	}

	return $result;
?>


