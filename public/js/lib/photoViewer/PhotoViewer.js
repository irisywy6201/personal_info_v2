'use strict';

/**
 * PhotoViewer.js
 * @author John Wang (汪子超)
 * This JavaScript file generates a photo viewer for
 * inspecting and zooming photos.
 * The photos to be zoomed can be added into this
 * photo viewer by calling it's addZoomablePhoto()
 * method.
 */
define(function (require) {
	var PhotoViewer = function() {
		/** @private */
		var $photoViewer,
			navBar,
			container,
			events;

		/**
		 * @private
		 * Initializes and binds events to NavigationBar.
		 */
		function navBarInit() {
			navBar = new (require("./NavigationBar"))();

			navBar.getCloseButton().click(events.exitPhotoViewer);
			$photoViewer.append(navBar.getNavigationBar());
		}

		/**
		 * @private
		 * Initializes and binds events to container.
		 */
		function containerInit() {
			var $presentedPhoto;

			container = new (require("./Container"))();
			$photoViewer.append(container.getContainerElement());

			container.getPrevButton().click(events.prevPhoto);
			container.getNextButton().click(events.nextPhoto);

			container.getZoomInButton().click(events.zoomIn);

			container.getZoomOutButton().click(events.zoomOut);
		}

		/**
		 * @class PhotoViewer
		 * @constructor
		 * Initializes views and binds events to
		 * NavigationBar and PhotoViewer.
		 */
		function PhotoViewer() {
			var instance = this;

			// Initializes views of PhotoViewer.
			$photoViewer = $("<div></div>").addClass("photo-viewer").hide().appendTo("body");
			
			events = new (require("./EventController"))(this);
			navBarInit();
			containerInit();

			$(document).keypress(function (e) {
				if (e.keyCode === 27) {
					events.exitPhotoViewer();
				}
			});
		}


		PhotoViewer.prototype = {
			/**
			 * Get the photoViewer jQuery object.
			 *
			 * @reutrn {jQuery} The photoViewer jQuery object.
			 */
			getPhotoViewerElement: function() {
				return $photoViewer;
			},

			/**
			 * Get the NavigationBar instance.
			 *
			 * @return {Object} Returns the instance of NavigationBar.
			 */
			getNavigationBar: function() {
				return navBar;
			},

			/**
			 * Get the Container instance.
			 *
			 * @return {Object} Returns the instance of Container.
			 */
			getContainer: function() {
				return container;
			},

			/**
			 * Add photos to this photo viewer and bind mouse
			 * events to these photos.
			 *
			 * @param {Selector} {jQuery} photos The photos to
			 * be added.
			 */
			addZoomablePhoto: function(photos) {
				var instance = this,
					$currentPhoto;

				if (photos) {
					$(photos).each(function (index, value) {
						$currentPhoto = container.addPhoto($(value)).$element;

						$currentPhoto.hover(events.mouseIn, events.mouseOut);
						$currentPhoto.mousedown(events.mouseDown);
						$currentPhoto.mouseup(events.mouseUp);
						$currentPhoto.mousemove(events.mouseMove);
						$currentPhoto.mousewheel(events.mousewheel);
					});

					$(photos).click(function () {
						container.setCurrentPhoto(this);
						events.enterPhotoViewer();
					});
				}
			}
		};

		return (new PhotoViewer());
	};

	return PhotoViewer;
});