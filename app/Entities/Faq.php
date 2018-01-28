<?php

namespace App\Entities;

use \App;
use \URL;

class Faq extends BaseEntity
{
	protected $table = 'faq';
	private $columnNameMap = [
		'name' => 'name',
		'answer' => 'answer'
	];

	public function __construct() {
		$locale = App::getLocale();

		switch ($locale) {
			case 'en':
				$this->setColumnNameMap('en');
				break;
			default:
				break;
		}
	}

	/**
	 * Get the URL link of current FAQ.
	 *
	 * @return String Returns the URL of current FAQ.
	 * If it failed to generate the link of current
	 * FAQ, an empty string will be returned.
	 */
	public function getLink()
	{
		$categoryLinkPart;

		if ($categoryLinkPart = $this->getMiddlePartURLName($this->category)) {			
			return URL::to('faq/' . $categoryLinkPart . '#' . $this->id);
		}
		else {
			return '';
		}
	}

	/**
	 * Get the title column name which corresponds
	 * to the current locale language setting.
	 * For example: name for zh_TW, name_en for en.
	 *
	 * @return String The title column name.
	 */
	public function scopeGetTitleColumnName()
	{
		return $this->columnNameMap['name'];
	}

	/**
	 * Get the content column name which corresponds
	 * to the current locale language setting.
	 * For example: answer for zh_TW, answer_en for en.
	 *
	 * @return String The content column name.
	 */
	public function scopeGetContentColumnName()
	{
		return $this->columnNameMap['answer'];
	}

	/**
	 * Search the category
	 *
	 * @param Integer $category The ID number of category.
	 * @return $query
	 */
	public function scopeCategory($query, $category)
	{
		if($category == '') {
			return $query;
		}
		else {
			return $query->where('category', '=', $category);
		}
	}

	/**
	 * Search FAQ which contains the given keyword.
	 * The current version searches the title of FAQ only.
	 *
	 * @param String $keyword The keyword to be searched.
	 * @return Builder Returns the Builder with keyword search.
	 * If $keyword is empty, the origin Builder will be returned.
	 */
	public function scopeKeyword($query, $keyword)
	{
		if($keyword && is_array($keyword)) {
			foreach ($keyword as $key => $value) {
				if (!empty($key) && !empty($value)) {
					switch ($key) {
						case 'title':
							$query->whereRaw($this->getFullTextSearchString($this->columnNameMap['name'], $value));
							break;
						case 'content':
							$query->whereRaw($this->getFullTextSearchString($this->columnNameMap['answer'], $value));
							break;
						default:
							break;
					}
				}
			}
		}

		return $query;
	}

	/**
	 * Set the $columnNameMap to determine which
	 * column should be used by the given $language.
	 *
	 * @param String $language The language used to
	 * determine what column should be used.
	 */
	private function setColumnNameMap($language)
	{
		$this->columnNameMap['name'] = 'name_' . $language;
		$this->columnNameMap['answer'] = 'answer_' . $language;
	}

	private function getFullTextSearchString($column, $keyword)
	{
		if (!empty($column) && !empty($keyword)) {
			return ('match(' . $column . ') against(\'' . $keyword . '\')');	
		}
		else {
			return '';
		}
	}

	/**
	 * The middle part of FAQ URL is the category chain.
	 * This function generates the middle part URL of the
	 * given FAQ.
	 *
	 * @param Integer id The id of Category.
	 * @return String Returns the middle part of FAQ URL link,
	 * if it fails to generate the middle part of FAQ URL, an
	 * empty string will be returned.
	 */
	private function getMiddlePartURLName($baseCategoryID)
	{
		$result = '';
		$categoryBuilder = Category::find($baseCategoryID);
		$currentURLName;

		if ($categoryBuilder) {
			$currentURLName = $categoryBuilder->href_abb;
		}
		else {
			return '';
		}
		
		if ($categoryBuilder->parent_id != 0) {
			$result = $this->getMiddlePartURLName($categoryBuilder->parent_id);
			$result = $result . '/' . $currentURLName;
		}
		else {
			$result = $currentURLName;
		}

		return $result;
	}
}

?>