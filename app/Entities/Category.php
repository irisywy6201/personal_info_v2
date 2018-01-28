<?php

namespace App\Entities;

class Category extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'category';
	protected $primaryKey = 'id';

	/**
	 * Category __has_many__ ContactPersonPosition.
	 */
	public function contactPersonPositions()
	{
		return $this->hasMany('ContactPersonPosition');
	}

	/**
	 * Category __has_many__ Question.
	 */
	public function questions()
	{
		return $this->hasMany('Question');
	}

	/**
	 * Category __has_many__ Faq.
	 */
	public function faqs()
	{
		return Faq::where('category', $this->id);
	}

	/**
	 * Get all next level sub-categories of current category.
	 *
	 * @return Builder All next level sub-categories of current category.
	 */
	public function subCategories()
	{
		return Category::where('parent_id', $this->id);
	}

	/**
	 * Retrieves all children in any depth of current category.
	 *
	 * @return Builder All children in any depth of current category.
	 */
	public function children()
	{
		return Category::whereIn('id', $this->findChildrenIDs());
	}

	/**
	 * Retrieves all children ID in any depth of current category.
	 * This function is a helper function of children().
	 *
	 * @return Array All All children IDs in any depth of current category.
	 */
	private function findChildrenIDs()
	{
		$results = [];

		if (!$this->isLeaf()) {
			$results = Category::find($this->id)->subCategories()->lists('id')->toArray();

			foreach ($results as $key => $id) {
				$results = array_merge($results, Category::find($id)->findChildrenIDs());
			}
		}

		return $results;
	}

	/**
	 * Get all leaves of current category.
	 *
	 * @param Builder $query The category to be
	 * searched.
	 * @return Builder All leaves of given
	 * category.
	 */
	public function leaves()
	{
		$results = [];
		$subCategoryIDs;

		if (!$this->isLeaf()) {
			$results = $this->search($this->id);
			$results = Category::whereIn('id', $results);
		}

		return $results;
	}

	/**
	 * Gets all category ID from root to current
	 * category in same category inherit chain.
	 */
	public function getCategoryIDChainToRoot()
	{
		if ($this->isHasParent()) {
			return array_merge(Category::find($this->parent_id)->getCategoryIDChainToRoot(), [$this->id]);
		}
		else {
			return [$this->id];
		}
	}

	/**
	 * Check the current category is a leaf or not.
	 *
	 * @return bool If the category is a leaf, returns
	 * True, if the category is not a leaf, returns
	 * False.
	 */
	public function isLeaf()
	{
		if (is_null(Category::where('parent_id', $this->id)->first())) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Check current category is root or not.
	 *
	 * @return bool Returns True if current category
	 * is root, returns False if current category is
	 * not root.
	 */
	public function isRoot()
	{
		if ($this->parent_id == 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Check current category has parent category
	 * or not.
	 *
	 * @return Returns True if this category has
	 * parent, returns False if this category does
	 * not has parent.
	 */
	public function isHasParent()
	{
		return !$this->isRoot();
	}

	/**
	 * Check current category has child category
	 * or not.
	 *
	 * @return Returns True if this category has
	 * child, returns False if this category does
	 * not has child.
	 */
	public function isHasChild()
	{
		return !$this->isLeaf();
	}

	/**
	 * Check if current category is hidden or not.
	 *
	 * @return Returns True if this category is hidden,
	 * returns False otherwise.
	 */
	public function isHidden() {
		if ($this->is_hidden) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * 	Get the children of category
	 *  @return $query
	 */
	public function scopeGetSubCategory($query, $parent)
	{
		return $query->where('parent_id', '=', $parent);
	}

	public function scopeGetMaxLayer($query)
	{
		return $query->max('layer');
	}

	public function scopeIsHasChildren($query, $id)
	{
		$leaf = Category::find($id)->leaf;
		$categChildren = $this->scopeGetSubCategory($query,$id)->get();
		$result = '';

		if($categChildren->isEmpty() && $leaf == 1 ) {
			$result = 1;
		}
		else {
			$result = 0;
		}

		return $result;
	}

	/**
	 * Get the unit which the given category belongs to.
	 *
	 * @param Integer id The category ID number.
	 * @return Integer Return the ID number of unit.
	 */
	public function scopeGetUnit($query, $id)
	{
		$parent = Category::find($id)->pluck('parent_id');

		while ($parent != 0) {
			$id = $parent;
			$parent = Category::find($id)->pluck('parent_id');
		}

		return Category::find($id);
	}

	/**
	 * Scope hidden Category.
	 *
	 * @return Builder Returns the Category Builder with is hidden scope.
	 */
	public function scopeHidden($query)
	{
		return $query->where('is_hidden', true);
	}

	/**
	 * Scope not hidden Category.
	 *
	 * @return Builder Returns the Category Builder with not hidden scope.
	 */
	public function scopeNotHidden($query)
	{
		return $query->where('is_hidden', false);
	}

	/**
	 * Get all top level categories.
	 *
	 * @return Builder All top level categories.
	 */
	public function scopeTopLevelCategories($query)
	{
		return Category::where('parent_id', 0);
	}

	/**
	 * Gets the corresponding Faqs.
	 *
	 * @return Builder Returns all corresponding Faqs.
	 */
	public function scopeGetFaqs($query)
	{
		return Faq::whereIn('category', $query->lists('id'));
	}

	/**
	 * Search all leaves of certain category.
	 *
	 * @param integer $id ID number of category.
	 * @return array All matched leaves IDs
	 */
	private function search($id)
	{
		$results = [];
		$childrenIDs;

		if (Category::find($id)->isLeaf()) {
			$results = [$id];
		}
		else {
			if ($childrenIDs = Category::where('parent_id', $id)->lists('id')) {
				foreach ($childrenIDs as $key => $value) {
					$results = array_merge($results, $this->search($value));
				}
			}
		}

		return $results;
	}
}

?>
