<?php

namespace App\Ncucc\John\SearchEngine;

use App\Ncucc\John\SearchEngine\Entities\TargetTable;

class SearchEngine {
	/**
	 * Get the FAQs which contain the given keyword.
	 *
	 * @param String $keyword The keyword to be matched.
	 * @param String $table The table to be searched.
	 * @param Array|String $columns The columns to
	 * be searched.
	 * @return Builder Returns the result as a Builder
	 * which contains the given keyword.
	 */
	public function search($keyword, $table, $columns)
	{
		$model;
		$results = null;
		
		if ($this->validate($keyword, $table, $columns)) {
			$model = new TargetTable();
			$model->setTable($table);
			
			return $model->fullTextSearch($keyword, $columns);
		}

		return $results;
	}

	/**
	 * Check if all given parameters are in proper form.
	 *
	 * @param string $keyword.
	 * @param string $table.
	 * @param string|array $columns.
	 * @return bool Returns True if all parameters are
	 * in proper form, returns False otherwise.
	 */
	private function validate($keyword, $table, $columns)
	{
		if (!empty($keyword) && !empty($table) && !empty($columns)) {
			return true;
		}
		else {
			return false;
		}
	}
}