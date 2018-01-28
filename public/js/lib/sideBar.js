'use strict';

define(function () {
	var $wrapper = $('#wrapper'),
		$toggleButton = $wrapper.find('#menu-toggle');

	/**
	 * Check if user is browsing using mobile phone.
	 *
	 * @returns {Boolean} Returns True if user is
	 * browsing by mobile phone, returns False otherwise.
	 */
	function isMobile() {
		if (window.screen.width <= 480) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Toggles the status of sidebar (show / hide).
	 */
	function toggleSidebar() {
		$wrapper.toggleClass('toggled');
		$toggleButton.toggleClass('toggled');
	}

	/**
	 * Initializes the sidebar.
	 */
	function init() {
		if ($wrapper.length > 0) {
			$('#menu-toggle').click(toggleSidebar);
		}
	}

	return init;
});