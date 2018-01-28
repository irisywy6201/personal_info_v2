<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model
{
	private $basedir = 'App\\Entities\\';

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

	/**
	 * Set up the base directory of Models.
	 *
	 * @param string $dir
	 */
	public function setBaseDir($dir)
	{
		$this->basedir = $this->fixEntityPath($dir);
	}

	/**
	 * Define a one-to-one relationship.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @param  string  $localKey
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function hasOne($related, $foreignKey = null, $localKey = null)
	{
		return parent::hasOne($this->getModelPath($related), $foreignKey, $localKey);
	}

	/**
	 * Define a polymorphic one-to-one relationship.
	 *
	 * @param  string  $related
	 * @param  string  $name
	 * @param  string  $type
	 * @param  string  $id
	 * @param  string  $localKey
	 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
	{
		return parent::morphOne($this->getModelPath($related), $name, $type, $id, $localKey);
	}

	/**
	 * Define an inverse one-to-one or many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @param  string  $otherKey
	 * @param  string  $relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function belongsTo($related, $foreignKey = null, $otherKey = null, $relation = null)
	{
		if (is_null($relation)) {
            list(, $caller) = debug_backtrace(false, 2);

            $relation = $caller['function'];
        }
        
		return parent::belongsTo($this->getModelPath($related), $foreignKey, $otherKey, $relation);
	}

	/**
	 * Define a one-to-many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $foreignKey
	 * @param  string  $localKey
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function hasMany($related, $foreignKey = null, $localKey = null)
	{
		return parent::hasMany($this->getModelPath($related), $foreignKey, $localKey);
	}

	/**
	 * Define a has-many-through relationship.
	 *
	 * @param  string  $related
	 * @param  string  $through
	 * @param  string|null  $firstKey
	 * @param  string|null  $secondKey
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null)
	{
		return parent::hasManyThrough($this->getModelPath($related), $through, $firstKey, $secondKey, $localKey);
	}


	/**
	 * Define a polymorphic one-to-many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $name
	 * @param  string  $type
	 * @param  string  $id
	 * @param  string  $localKey
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
	{
		return parent::morphMany($this->getModelPath($related), $name, $type, $id, $localKey);
	}

	/**
	 * Define a many-to-many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $table
	 * @param  string  $foreignKey
	 * @param  string  $otherKey
	 * @param  string  $relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null, $relation = null)
	{
		return parent::belongsToMany($this->getModelPath($related), $table, $foreignKey, $otherKey, $relation);
	}

	/**
	 * Define a polymorphic many-to-many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $name
	 * @param  string  $table
	 * @param  string  $foreignKey
	 * @param  string  $otherKey
	 * @param  bool    $inverse
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
	{
		return parent::morphToMany($this->getModelPath($related), $name, $table, $foreignKey, $otherKey, $inverse);
	}

	/**
	 * Define a polymorphic, inverse many-to-many relationship.
	 *
	 * @param  string  $related
	 * @param  string  $name
	 * @param  string  $table
	 * @param  string  $foreignKey
	 * @param  string  $otherKey
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function morphedByMany($related, $name, $table = null, $foreignKey = null, $otherKey = null)
	{
		return parent::morphedByMany($this->getModelPath($related), $name, $table, $foreignKey, $otherKey);
	}

	/**
	 * Get the joining table name for a many-to-many relation.
	 *
	 * @param  string  $related
	 * @return string
	 */
	public function joiningTable($related)
	{
		return parent::joiningTable($this->getModelPath($related));
	}

	/**
	 * Get the actual Model path according to its namespace.
	 *
	 * @param string $related
	 * @return string
	 */
	protected function getModelPath($related)
	{
		return $this->basedir . $this->fixRelatedPath($related);
	}

	/**
	 * Fix and retrieve a correct Entity path if the
	 * given $dirname has wrong format.
	 *
	 * @param string $dirname
	 * @return string
	 */
	protected function fixEntityPath($dirname)
	{
		$fixedDirName = $dirname;

		if (substr($fixedDirName, -1) !== '\\') {
			$fixedDirName = $fixedDirName . '\\';
		}

		return $fixedDirName;
	}

	/**
	 * Fix and retrieve a correct related path if the
	 * given $related has wrong format.
	 *
	 * @param string $related
	 * @return string
	 */
	protected function fixRelatedPath($related)
	{
		$fixedDirName = $related;

		if (substr($fixedDirName, 0, 1) === '\\') {
			$fixedDirName = substr($fixedDirName, 1, strlen($fixedDirName) - 1);
		}

		return $fixedDirName;
	}
}
