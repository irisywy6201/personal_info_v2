<?php

namespace App\Entities;

use \Queue;

use Carbon\Carbon;

use App\Jobs\MakeDynamicLinkExpired;

class DynamicLink extends BaseEntity
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dynamic_link';
	protected $primaryKey = 'id';

	/**
	 * Check if hash code already existed in database or not.
	 *
	 * @param {String} hash The hash code to be checked.
	 * @return {Boolean} True if hash code already existed, false if
	 * hash code does not exist in database.
	 */
	public function scopeHasHash($query, $hash) {
		if (is_null($query->where('hash', $hash)->get())) {
			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param {Array} data Information to be used by this dynamic link.
	 * @return {String} Dynamic link.
	 */
	public function newDynamicLink($link, $due = null, $acct = null)
	{
		$hash = $this->genereteHashCode();
		$link = $this->getFormattedLink($link) . $hash;

		$dynamicLink = new DynamicLink;
		$dynamicLink->link = $link;
		$dynamicLink->hash = $hash;
		$dynamicLink->acct = $acct;
		$dynamicLink->due = $due;
		$dynamicLink->save();

		if (!is_null($due)) {
			Queue::later($due, (new MakeDynamicLinkExpired($dynamicLink->id)));
		}

		return $link;
	}

	/**
	 * Generate a unique hash code.
	 *
	 * @return {String} hash code.
	 */
	private function genereteHashCode()
	{
		$hash = null;
		$datetime = null;
		$randomNumber = null;

		while (!$hash && DynamicLink::hasHash($hash)) {
			$hash = md5(Carbon::now()->addDays(2) . rand(1, 1000));
		}

		return $hash;
	}

	/**
	 * Check and change the given link to appropriate format.
	 *
	 * @param {String} link The link to be checked.
	 * @return {String} Formatted link.
	 */
	private function getFormattedLink($link)
	{
		$endChar = '/';

		if (substr($link, -1) == $endChar) {
			return $link;
		}
		else {
			return $link . $endChar;
		}
	}
}

?>