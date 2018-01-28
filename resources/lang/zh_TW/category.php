<?php
	use App\Entities\Category;

	$result = [[
		'name' => '未分類',
		'description' => '尚無描述'
	]];
	$databaseLanguages = Category::get(['id', 'name', 'describe']);

	foreach ($databaseLanguages as $key => $row) {
		$id = $row['id'];
		$result[$id]['name'] = $row['name'] ? $row['name'] : '未命名';
		$result[$id]['description'] = $row['describe'] ? $row['describe'] : '尚無描述';
		unset($databaseLanguages[$key]);
	}

	return $result;
?>


