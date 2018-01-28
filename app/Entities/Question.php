<?php

namespace App\Entities;

use \Auth;
use \Lang;

class Question extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'question';
	protected $primaryKey = 'id';
	protected $fillable = ['content'];

	const STATUS_NO_STATUS = 0;
	const STATUS_UNSOLVED = 1;
	const STATUS_SOLVED = 2;
	const STATUS_AUTO_SOLVED = 3;

	/**
	 * Question __belongs_to__ User.
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Question __belongs_to__ Category.
	 */
	public function category()
	{
		return $this->belongsTo('Category');
	}

	/**
	 * Question __has_many__ Reply.
	 */
	public function replies()
	{
		return $this->hasMany('Reply');
	}

	/**
	 *
	 */
	public function scopeStatisticsData($query)
	{
		$data = $query->lists('category_id')->toArray();
		return array_count_values($data);
	}


	/**
	 * This fumction will return the question after this time
	 * @var string $from : start from this time
	 * @return $query
	 */
	public function scopeAfterTime($query, $after)
	{
		return $query->where('updated_at', '>=', $after);
	}

	/**
	 * This function will return the question before this time
	 * @var string $before :  before this time
	 * @return $query
	 */
	public function scopeBeforeTime($query, $before)
	{
		return $query->where('updated_at', '<=', $before);
	}

	/**
	 * Bind the filter of solved and auto solved status together.
	 * @param int $status
	 */
	public function scopeChoiceStatus($query, $status)
	{
		if ($status == Question::STATUS_NO_STATUS) {
			return $query;
		}
		elseif ($status == Question::STATUS_SOLVED ||
			$status == Question::STATUS_AUTO_SOLVED) {
			return $query->solved();
		}
		else {
			return $query->where('status', $status);
		}
	}

	/**
	 * Filters the solved messages.
	 */
	public function scopeSolved($query)
	{
		return $query->where('status', Question::STATUS_SOLVED)
			->orWhere('status', Question::STATUS_AUTO_SOLVED);
	}

	/**
	 * 	Search the status
	 *  @return $query
	 */
	public function scopeStatus($query, $status)
	{
		if (trim($status) == '') {
			return $query;
		}
		else if (strcmp($status, '0')) {
			return $query->where('status', '>', '0');
		}
		else {
			return $query->where('status', '=', '0');
		}
	}

	/**
	 * 	Search the cateogry
	 *  @return $query
	 */
	public function scopeSearchCategory($query, $category)
	{
		if (trim($category) == '') {
			return $query;
		}
		else {
			return $query->where('category_id', '=', $category);
		}

	}
	/**
	 * 	Search the keyword
	 *  @return $query
	 */
	public function scopeKeySearch($query, $keyword)
	{
		if (empty($keyword)) {
			return $query;
		}
		else {
			return $query->where('title', 'LIKE', '%'.$keyword.'%');
		}

	}
	/**
	 * $isAsc mean increment or decrement
	 * increment = true;
	 */
	public function scopeOrderbyValue($query, $Value, $isAsc)
	{
		if (trim($Value)=='') {
			return $query;
		}
		else {
			if ($isAsc) {
				return $query->orderby($Value, 'ASC');
			}
			else {
				return $query->orderby($Value, "DESC");
			}

		}
	}

	public function scopeOutputData($query, $specifiedCol)
	{
		$result = $query->select($specifiedCol)->get();

		foreach ($result as $key => $value) {
			if ($value->category_id) {
				$value->category_id = Lang::get('category.'.$value->category_id.'.name');
			}
			if ($value->status != null) {
				$value->status = Lang::get('status.'.$value->status);
			}
			if ($value->identity != null) {
				$value->identity = Lang::get('identity.'.$value->identity);
			}
		}

		return $result;

	}

	/**
	 * Search the user question
	 */
	public function scopeUser($query)
	{
		return $query->where('user_id', 'LIKE', Auth::user()->id);
	}
}

?>
