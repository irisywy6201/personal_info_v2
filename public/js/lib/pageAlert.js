'use strict';

/**
 * @author John Wang.
 * This JavaScript file give a simple animation to
 * reminder component which is a HTML element.
 */
define(function () {
	/**
	 * Starts fading out the page-alert component
	 * after 5 seconds.
	 *
	 * @param {Object} $pageAlert The page-alert
	 * component as a jQuery object.
	 * @returns {Boolean} Returns the setTimeout
	 * ID number.
	 */
	function startFadeOutPageAlert($pageAlert) {
		var timeoutID = setTimeout(function () {
			$pageAlert.fadeOut(5000, function () {
				$pageAlert.remove();
			});
		}, 2000);

		return timeoutID;
	}

	/**
	 * Bind animation to reminder component.
	 *
	 * @param {DOM} reminderDOM The HTML element.
	 * @returns {Object} Return the given reminderDOM
	 * HTML DOM object.
	 */
	function pageAlert(pageAlert) {
		var $pageAlert = $(pageAlert),
			timeoutID = 0;

		if ($pageAlert.length === 1) {
			$pageAlert.hover(
				function () {
					clearTimeout(timeoutID);
					$pageAlert.stop().fadeIn('fast');
				},
				function () {
					timeoutID = startFadeOutPageAlert($pageAlert);
				}
			);

			timeoutID = startFadeOutPageAlert($pageAlert);

			return $pageAlert;
		}
		else {
			return null;
		}
	}

	return pageAlert;
});