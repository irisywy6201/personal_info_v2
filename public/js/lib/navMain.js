'use strict';

define(function () {
	/**
	 * Highlight the navigation item which corresponds to
	 * to current page.
	 *
	 * @param {Object} target The navigation bar object.
	 */
	function currentLocationHighlightInit(target) {
		var path = window.location.pathname;

		if (path === "/") {
			// Special case for index.
			$(target).find("a").first().closest("li").addClass("active");
		}
		else {
			$(target).find("a").each(function (index, value) {
				// <a> tag's "href" attribute.
				var currentHref = $(value).attr("href");

				// Remove "http://domain name"
				currentHref = currentHref.replace("http://" + document.domain, "");

				if (path.match(currentHref) && currentHref) {
					$(value).closest("li").addClass("active");
				}
			});
		}
	}

	/**
	 * Initializes the animation events to the reminderIcon.
	 *
	 * @param {Object} $reminderIcon The reminder icon as a
	 * jQuery object.
	 */
	function userNewsReminderIconInit($reminderIcon) {
		var originPosition = $reminderIcon.css('top');

		function animateUp() {
			$reminderIcon.animate({top: '+=5'}, 1200, 'easeInOutQuad', animateDown);
		}

		function animateDown() {
			$reminderIcon.animate({top: '-=5'}, 1200, 'easeInOutQuad', animateUp);
		}

		$reminderIcon.closest('.dropdown-toggle').click(function () {
			$reminderIcon.remove();
		});

		$reminderIcon.closest('.dropdown-toggle').hover(
			function () {
				$reminderIcon.stop();
				$reminderIcon.animate({top: originPosition}, 'fast', 'easeInOutQuad');
			},
			function () {
				animateUp();
			}
		);

		animateUp();
	}

	return {
		navMainInit: function (target) {
			currentLocationHighlightInit(target);
			userNewsReminderIconInit($(target).find('.navbar-user-news-reminder'));
		}
	};
});