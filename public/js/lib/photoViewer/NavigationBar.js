'use strict';

/**
 * NavigationBar.js
 * @author John Wang (汪子超)
 * This JavaScript file is used by PhotoViewer.js
 * It generates and handles the navigation bar of
 * photo viewer.
 */
define(function() {
	var NavigationBar = function(options) {
		/** @private */
		var $navBar = $("<div></div>").addClass("navbar navbar-inverse"),
			$container = $("<div></div>").addClass("container-fluid"),
			$navBarHeader = $("<div></div>").addClass("navbar-header"),
			$navBarToggleButton = $("<button></button>").addClass("navbar-toggle").addClass("collapsed").attr("type", "button").attr("data-toggle", "collapse").attr("data-target", "#photoViewer").append("<span class=\"sr-only\">Toggle navigation</span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span><span class=\"icon-bar\"></span>"),
			$navBarBrand = $("<a></a>").addClass("navbar-brand").append(options ? (options.brandText ? options.brandText : "Photo Viewer") : "Photo Viewer"),
			$navBarBody = $("<div></div>").addClass("collapse navbar-collapse").attr("id", "photoViewer"),
			zoomNav = {
				$nav: $("<ul></ul>").addClass("nav navbar-nav"),
				$zoomOptions: null
			},
			$closeNav = $("<ul></ul>").addClass("nav").addClass("navbar-nav").addClass("navbar-right"),
			$closeButton = $("<button></button>").addClass("btn").addClass("navbar-btn").addClass("btn-photo-viewer").addClass("btn-photo-viewer-close").append("<span class=\"glyphicon glyphicon-remove\"></span>");

		/**
		 * @class NavigationBar
		 * @constructor
		 *
		 * Initializes the views of NavigationBar.
		 */
		function NavigationBar(options) {
			// Initializes private members.
			$navBar.append($container);
			$container.append($navBarHeader).append($navBarBody);
			$navBarHeader.append($navBarToggleButton).append($navBarBrand);
			$closeNav.append($closeButton);
			$navBarBody.append(zoomNav.$nav).append($closeNav);

			//this.addZoomOption(100);
			//this.addZoomOption(50);
			//this.addZoomOption(25);
		}

		NavigationBar.prototype = {
			/**
			 * Set the brand text of navigation bar.
			 *
			 * @param {String} brandText The brnadText to
			 * be set.
			 */
			setBrandText: function(brandText) {
				$navBarBrand.html(brandText);
			},

			/**
			 * Get it's navigation bar HTML element.
			 *
			 * @return {Object} Returns it's top level
			 * navigation bar element.
			 */
			getNavigationBar: function() {
				return $navBar;
			},

			/**
			 * Get it's close button HTML element.
			 */
			getCloseButton: function() {
				return $closeButton;
			},

			/**
			 * Add a zoom option with a specified percentage.
			 *
			 * @param zoomPercentage The percentage value of
			 * zoom option.
			 * @return {Object} Return the zoom option HTML element.
			 */
			addZoomOption: function(zoomPercentage) {
				var $optionWrapper = $("<li></li>"),
					$option = $("<a></a>").append(zoomPercentage + "%");

				$option.attr("data-percentage", parseInt(zoomPercentage));
				$optionWrapper.append($option);
				zoomNav.$nav.append($optionWrapper);

				if (this.isZoomOptionsEmpty()) {
					zoomNav.$zoomOptions = $optionWrapper;
				}
				else {
					zoomNav.$zoomOptions = zoomNav.$zoomOptions.add($optionWrapper);
				}
				
				return $option;
			},

			/**
			 * Get all zoom option HTML elements.
			 *
			 * @return {Array} Return all zoom option
			 * HTML elements as an array.
			 */
			getZoomOptions: function() {
				return zoomNav.$zoomOptions;
			},

			/**
			 * Set certain zoom option to "active" status.
			 *
			 * @param {Object} element The element to be set.
			 */
			setActiveZoomOption: function(element) {
				zoomNav.$zoomOptions.removeClass("active");
				$(element).addClass("active");
			},

			/**
			 * Check if there's any zoom option on this
			 * navigation bar.
			 *
			 * @return {Boolean} Return True if at least one
			 * zoom option is on this navigation bar, return
			 * false if no zoom option on it.
			 */
			isZoomOptionsEmpty: function() {
				if (zoomNav.$zoomOptions && zoomNav.$zoomOptions.length > 0) {
					return false;
				}
				else {
					return true;
				}
			}
		};

		return (new NavigationBar(options));
	};

	return NavigationBar;
});