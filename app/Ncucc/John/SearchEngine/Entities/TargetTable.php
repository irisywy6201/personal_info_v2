<?php

namespace App\Ncucc\John\SearchEngine\Entities;

use Exception;
use \DB;
use \Eloquent;

class TargetTable extends Eloquent
{
	protected $table = '';

	/**
	 * Get all columns' name of this table as
	 * a array.
	 *
	 * @return array Returns all columns' name
	 * of this table, if the $table of this
	 * Eloquent is not defined, an empty array
	 * will be returned.
	 */
	public function getAllColumnsNames()
	{
		$columns = [];

		if (!$this->table) {
			switch (DB::connection()->getConfig('driver')) {
				case 'pgsql':
					$query = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->table . "'";
					$column_name = 'column_name';
					$reverse = true;
					break;
				case 'mysql':
					$query = 'SHOW COLUMNS FROM ' . $this->table;
					$column_name = 'Field';
					$reverse = false;
					break;
				case 'sqlsrv':
					$parts = explode('.', $this->table);
					$num = (count($parts) - 1);
					$table = $parts[$num];
					$query = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
					$column_name = 'column_name';
					$reverse = false;
					break;
				default:
					$error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
					throw new Exception($error);
					break;
			}
			
			foreach(DB::select($query) as $column) {
				$columns[] = $column->$column_name;
			}
			
			if($reverse) {
				$columns = array_reverse($columns);
			}
		}

		return $columns;
	}

	/**
	 * Search the record which contains the given keyword.
	 *
	 * @param string $keyword The keyword to be searched.
	 * @param string|array|Null $columns The columns to be searched.
	 * This parameter is optional. If this parameter is not given,
	 * then it will search through all columns.
	 * @return Builder Returns the Builder with keyword search.
	 * If $keyword is empty, the origin Builder will be returned.
	 */
	public function scopeFullTextSearch($query, $keyword, $columns = [])
	{
		if ($this->validate($keyword)) {
			$columns = $this->setUpColumns($columns);

			return $query->whereRaw($this->getFullTextSearchString($columns), [
				'keyword' => $keyword
			]);
		}
		else {
			return $query;
		}
	}

	/**
	 * Use Regular Expression to search the record which contains the
	 * given keyword.
	 *
	 * @param string $keyword The keyword to be searched.
	 * @param string|array|Null $columns The columns to be searched.
	 * This parameter is optional. If this parameter is not given,
	 * then it will search through all columns.
	 * @return Builder Returns the Builder with keyword search.
	 * If $keyword is empty, the origin Builder will be returned.
	 */
	public function scopeRegExpSearch($query, $keyword, $columns = [])
	{
		if ($this->validate($keyword)) {
			$columns = $this->setUpColumns($columns);
			$pattern = str_replace(' ', '|', $keyword);
			$query = $query->whereRaw($this->getRegExpString($columns), [
				'pattern' => $pattern
			]);

			return $query;
		}
		else {
			return $query;
		}
	}

	/**
	 * Check if this table is ready to perform a search.
	 *
	 * @param string $keyword.
	 * @return bool Returns True if this table is ready, returns
	 * False if the table is not set or the keyword is empty.
	 */
	private function validate($keyword)
	{
		if (!empty($keyword) && $this->table) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Convert the given keyword and target columns to the
	 * full-text search query string.
	 *
	 * @param array $columns The columns to be searched.
	 * @return string The full-text searching query string.
	 */
	private function getFullTextSearchString($columns)
	{
		$queryString = 'match(';

		for ($i = 0; $i < count($columns) - 1; $i++) {
			$queryString = $queryString . $columns[$i] . ',';
		}

		$queryString = $queryString . $columns[count($columns) - 1];

		$queryString = $queryString . ') against(:keyword)';

		return $queryString;
	}

	/**
	 * Convert the given keyword and target columns to the
	 * Regular Expression searching query string.
	 *
	 * @param array $columns The columns to be searched.
	 * @return string The Regular Expression searching query string.
	 */
	private function getRegExpString($columns)
	{
		$regexpString = '';

		for ($i = 0; $i < count($columns) - 1; $i++) {
			$regexpString = $regexpString . $columns[$i] . ' REGEXP :pattern or ';
		}

		$regexpString = $regexpString . $columns[$i] . ' REGEXP :pattern';

		return $regexpString;
	}

	/**
	 * Transform the given column(s) to an array for
	 * searching.
	 *
	 * @param array $columns The column(s) to be searched.
	 * @return array The transformed column(s). 
	 */
	private function setUpColumns($columns = [])
	{
		$result;

		if (!empty($columns)) {
			if (!is_array($columns)) {
				$result = [$columns];
			}
			else {
				$result = $columns;
			}
		}
		else {
			$result = $this->getAllColumnsNames();
		}

		return $result;
	}
}