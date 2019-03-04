'use strict';

define(function () {
	var $suggestionHelper,
		$title,
		$department,
		$category,
		$btnHide,
		$btnShow,
		$btnRemove,
		$contentField,
		$noResultPanel,
		isHidden = false,
		isHasData = false;

	/**
	 * Initializes and binds events to the
	 * suggestionHelper.
	 *
	 * @param {Object} {Selector} element The suggestHelper
	 * object.
	 */
	function init(element) {
		if (element && $(element).length > 0) {
			$suggestionHelper = $(element);
			
			$title = $('input[name="title"]');
			$department = $('input[name="department"]');
			$category = $('input[name="category"]');
			$btnHide = $suggestionHelper.find(".btn-hide");
			$btnShow = $suggestionHelper.find(".btn-show");
			$btnRemove = $suggestionHelper.find(".btn-disable");
			$contentField = $suggestionHelper.find(".suggests");
			$noResultPanel = $suggestionHelper.find('.panel-body');

			$contentField.hide();
			$noResultPanel.hide();
			$suggestionHelper.hide();

			$title.on("input", refreshSuggestions);
			//$department.change(refreshSuggestions);
			$category.change(refreshSuggestions);
			$btnHide.click(hideSuggestionHelper);
			$btnShow.hide().click(showSuggestionHelper);
			$btnRemove.click(removeSuggestionHelper);

			eventInit($(element));
		}
	}

	/**
	 * Initializes the event of suggestionHelper.
	 * Implements the dragging feature.
	 *
	 * @param {Object} element The suggestionHelper
	 * jQuery object.
	 */
	function eventInit($element) {
		var $heading = $element.find(".panel-heading"),
			x, y;

		function mouseMove(e) {
			var offX = e.clientX - x,
				offY = e.clientY - y;

				x = e.clientX;
				y = e.clientY;

				dragSuggestionHelper($element, offX, offY);
		}

		$heading.mousedown(function (e) {
			x = e.clientX,
			y = e.clientY,

			$(document).mousemove(mouseMove);
		});
		
		$heading.mouseup(function () {
			$(document).unbind('mousemove', mouseMove);
		});
	}

	/**
	 * Drag the suggestionHelper.
	 *
	 * @param {Object} $element The suggestionHelper
	 * jQuery object.
	 * @param {Integer} offX The x-axis offset.
	 * @param {Integer} offY The y-axis offset.
	 */
	function dragSuggestionHelper($element, offX, offY) {
		$element.offset({
			top: $element.offset().top + offY,
			left: $element.offset().left + offX
		});
	}

	/**
	 * Clear all suggestions on suggestion helper.
	 */
	function clearSuggestions() {
		$contentField.empty();
	}

	/**
	 * Update the content of suggestionHelper.
	 *
	 * @param {Array} data The new data to be
	 * appended to suggestionHelper.
	 */
	function addSuggestions(data) {
		if (data.length > 0) {
			$.each(data, function (key, value) {
				$contentField.append('<li class="list-group-item"><a href="' + value['href'] + '" target="_blank">' + value['title'] + '</a></li>');
			});
			isHasData = true;
		}
		else {
			isHasData = false;
		}
	}

	/**
	 * Refresh the suggestionHelper.
	 */
	function refreshSuggestions() {
		var postData = new FormData();

		postData.append("title", $title.val());
		postData.append("department", $department.val());
		postData.append("category", $category.val());

		$.ajax({
			url: window.location.origin + "/ajax/newMessageSuggestionHelper",
			type: 'post',
			data: postData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json'
		}).done(function (data, textStatus, jqXHR) {
			clearSuggestions();
			addSuggestions(data);
			showSuggestionHelper();
		}).fail(function (jqXHR, textStatus, errorThrown) {
			//console.log(errorThrown);
		});
	}

	/**
	 * Show up the suggestionHelper panel.
	 */
	function showSuggestionHelper() {
		$btnShow.hide();
		$btnHide.show();

		if (isHasData) {
			$suggestionHelper.slideDown("fast");
			$contentField.slideDown('fast');
			$noResultPanel.hide();
		}
		else {
			$noResultPanel.slideDown('fast');
			$contentField.hide();
		}
		
		isHidden = false;
	}

	/**
	 * Hide the suggestionHelper panel.
	 */
	function hideSuggestionHelper() {
		$btnHide.hide();
		$btnShow.show();
		$contentField.slideUp('fast');
		$noResultPanel.slideUp('fast');
		isHidden = true;
	}

	/**
	 * Remove the suggestionHelper panel.
	 */
	function removeSuggestionHelper() {
		$suggestionHelper.slideUp(function () {
			$suggestionHelper.remove();
		});
	}

	/**
	 * Check if the suggestionHelper panel
	 * is hidden or not.
	 *
	 * @return {Boolean} Return True if the
	 * suggestionHelper is hidden, return False
	 * if suggestionHelper is shown.
	 */
	function isSuggestionHidden() {
		return ($suggestionHelper.is(":hidden") || $contentField.is(":hidden"));
	}

	return init;
});