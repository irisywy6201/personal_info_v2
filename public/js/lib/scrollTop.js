'use strict';

function scrollTop(el, callback) {
	var $element = $(el);

	if ($element.length > 0) {
		$element.click(function () {
			$('body, html').animate({scrollTop: 0}, 500, 'swing', callback);
		});
	}
}

define(function () {
	return scrollTop;
});