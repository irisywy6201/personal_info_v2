'use strict';

define(function (require) {
	var formElementsSelector = 'input:not([name="_token"]):not([type="text"]), select',
		visibleTextInputSelector = 'input[type="text"]',
		bootstrapDropdownSelector = '.dropdown > button',
		allFormElementSelector = formElementsSelector + ', ' + visibleTextInputSelector + ', ' + bootstrapDropdownSelector;

	/**
	 * Initializes the origin values of form elements.
	 *
	 * @param {Object} elements The elements to be
	 * initialized.
	 */
	function initOriginValues(elements) {
		var instance = this;

		$(elements).each(function (index, value) {
			var currentValue;

			if ($(value).attr('data-toggle') === 'dropdown') {
				currentValue = $(value).text();
			}
			else {
				currentValue = $(value).val();
			}

			instance.formOriginValues.push({
				$element: $(value),
				value: currentValue
			});
		});
	}

	/**
	 * Set up custom callbacks to RealTimeSearcher.
	 * @param {JSON} options The custom callbacks to be added.
	 */
	function registerCallbacks(options) {
		if (!options) return;

		if (typeof options.onAfterResultAdded === 'function') {
			this.onAfterResultAdded = options.onAfterResultAdded;
		}
	}

	/**
	 * The initialize function
	 *
	 * @param {Object} $realTImeSearchBar The search
	 * bar to be initialized.
	 */
	function RealTimeSearcher($realTimeSearchBar, options) {
		var instance = this,
			searchBarID = $realTimeSearchBar.attr('data-real-time-search-id');

		this.$searchBar = $realTimeSearchBar;
		this.$resultPanel = $(document).find('.real-time-search-wrapper[data-real-time-search-id="' + searchBarID + '"]');
		this.$originContentPanel = this.$resultPanel.children('.real-time-search-origin-page');
		this.$searchResultPanel = this.$resultPanel.children('.real-time-search-result-page');
		this.$refreshButton = this.$searchBar.find('.btn-refresh');
		this.$loadingIcon = this.$searchBar.find('.loading');
		this.formOriginValues = [];
		this.ajaxCounter = 0;

		initOriginValues.call(this, this.$searchBar.find(allFormElementSelector));

		this.$searchBar.find(formElementsSelector).change(function () {
			instance.realTimeSearch();
		});

		this.$searchBar.find(visibleTextInputSelector).on('input', function () {
			instance.realTimeSearch();
		});

		this.$refreshButton.click(function () {
			instance.refreshSearchBar();
		});

		registerCallbacks.call(this, options);
	};



	/**
	 * Perform an Ajax real time search and present the result to
	 * user.
	 *
	 * @param {Object} $searchBar The searchBar to be submitted as
	 * a jQuery object.
	 */
	RealTimeSearcher.prototype.realTimeSearch = function() {
		var instance = this,
			currentAjaxCounter = ++this.ajaxCounter;

		if (this.$searchBar.find('.keyword').val().length > 0) {
			this.showLoadingIcon();
			$.ajax({
				type: 'post',
				url: this.$searchBar.attr('action'),
				data: this.$searchBar.serialize(),
				dataType: 'html'
			}).done(function (data, textStatus, jqXHR) {
				instance.appendResultAndSwitch(data, currentAjaxCounter);
			}).fail(function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText);
				console.log(textStatus);
			});
		}
		else {
			this.backToOriginPanel();
		}
	};

	/**
	 * Switches from origin content panel to the result panel.
	 *
	 * @param {html} data The result to be appended.
	 * @param {Integer} currentAjaxCounter Determines whether this
	 * @param {Function} callback The
	 * ajax result is out-of-date or not.
	 */
	RealTimeSearcher.prototype.appendResultAndSwitch = function(data, currentAjaxCounter) {
		var instance = this;

		if (currentAjaxCounter === this.ajaxCounter) {
			this.$searchResultPanel.empty().append(data);
			if (this.onAfterResultAdded) this.onAfterResultAdded();
			this.$originContentPanel.fadeOut('fast', function() {
				instance.$searchResultPanel.fadeIn('fast', function () {
					instance.hideLoadingIcon();
				});
			});
		}
	};

	/**
	 * Switches back to the origin content panel and clear all search results.
	 */
	RealTimeSearcher.prototype.backToOriginPanel = function() {
		var instance = this;

		this.ajaxCounter = 0;
		this.$searchResultPanel.fadeOut('fast', function () {
			instance.$originContentPanel.fadeIn('fast', function() {
				instance.hideLoadingIcon(function () {
					instance.$searchResultPanel.empty();
				});
			});
		});
	};

	/**
	 * Refreshes the whole search bar to its origin status.
	 */
	RealTimeSearcher.prototype.refreshSearchBar = function() {
		this.backToOriginPanel();

		$.each(this.formOriginValues, function (index, row) {
			var iconHolder;

			if (row.$element.attr('data-toggle') === 'dropdown') {
				iconHolder = row.$element.children('.caret').detach();
				row.$element.text(row.value).append(iconHolder);
			}
			else {
				row.$element.val(row.value);
			}
		});
	};

	/**
	 * Shows the loading icon.
	 *
	 * @param {Function} callback The function to be executed after
	 * loading icon showed completely.
	 */
	RealTimeSearcher.prototype.showLoadingIcon = function(callback) {
		this.$loadingIcon.removeClass('sr-only').fadeIn(callback);
	};

	/**
	 * Hides the loading icon.
	 *
	 * @param {Function} callback The function to be executed after
	 * loading icon hid completely.
	 */
	RealTimeSearcher.prototype.hideLoadingIcon = function(callback) {
		this.$loadingIcon.fadeOut(callback);
	};

	/**
	 * Initialization function.
	 */
	function realTimeSearcher(realTimeSearchBar, options) {
		if ($(realTimeSearchBar).length > 0) {
			$(realTimeSearchBar).each(function (index, searchBar) {
				new RealTimeSearcher($(searchBar), options);
			});
		}
	}

	return realTimeSearcher;
});
