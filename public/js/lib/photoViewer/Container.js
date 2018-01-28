'use strict';

/**
 * Container.js
 * @author John Wang (汪子超)
 * This JavaScript file is used by PhotoViewer.js
 * Container - a singleton class, provides a
 * photo gallery for photo viewer, and enables
 * the photo to zoom in and out inside the
 * photo frame it provides.
 */
define(function (require) {
	/**
	 * @private
	 * Singleton checker.
	 */
	var instance;

	var Container = function() {
		/** @private */
		var $container = $("<div></div>").addClass("photo-container"),
			gallery = new (require("./Gallery"))(),
			currentPhotoIndex,
			$currentPhoto,
			mask = {
				$top: $("<div></div>").addClass("mask-top"),
				$bottom: $("<div></div>").addClass("mask-bottom").addClass("text-center"),
				$left: $("<div></div>").addClass("mask-left"),
				$right: $("<div></div>").addClass("mask-right")
			},
			$toolBar = $("<div></div>").addClass("container-fluid photo-viewer-toolbar"),
			photoNavigationTool = {
				$wrapper: $("<div></div>").addClass("photo-viewer-navigations"),
				$prev: $("<span></span>").addClass("btn glyphicon glyphicon-chevron-left").addClass("btn-photo-viewer"),
				$next: $("<span></span>").addClass("btn glyphicon glyphicon-chevron-right").addClass("btn-photo-viewer"),
				$information: $("<p></p>").addClass("photo-viewer-text-info")
			},
			photoZoomingTool = {
				$wrapper: $("<div></div>").addClass("pull-right photo-viewer-zooming"),
				$zoomIn: $("<span></span>").addClass("btn glyphicon glyphicon-plus btn-photo-viewer"),
				$zoomOut: $("<span></span>").addClass("btn glyphicon glyphicon-minus btn-photo-viewer"),
				$information: $("<p>100%</p>").addClass("photo-viewer-text-info")
			};

		/**
		 * @class Container
		 * @constructor
		 * Initializes the views of Container.
		 */
		function Container() {
			if (instance) {
				return instance;
			}
			else {
				// Initializes private members.
				photoZoomingTool.$wrapper.append(photoZoomingTool.$zoomOut);
				photoZoomingTool.$wrapper.append(photoZoomingTool.$information);
				photoZoomingTool.$wrapper.append(photoZoomingTool.$zoomIn);
				$toolBar.append(photoZoomingTool.$wrapper);

				photoNavigationTool.$wrapper.append(photoNavigationTool.$prev);
				photoNavigationTool.$wrapper.append(photoNavigationTool.$information);
				photoNavigationTool.$wrapper.append(photoNavigationTool.$next);
				$toolBar.append(photoNavigationTool.$wrapper);

				mask.$bottom.append($toolBar);

				$.each(mask, function(key, value) {
					$container.append(value);
				});

				currentPhotoIndex = -1;

				instance = this;
			}
		}

		Container.prototype = {
			/**
			 * Add photos into gallery by raw jQuery
			 * object or selector.
			 *
			 * @param {Object} {String} element
			 * The elements to be stored into gallery.
			 */
			addPhoto: function(element) {
				if (element) {
					return gallery.addPhoto(element);
				}
				else {
					return null;
				}
			},

			/**
			 * Get the container HTML element.
			 *
			 * @return {Object} The top level
			 * HTML element of this container.
			 */
			getContainerElement: function() {
				return $container;
			},

			/**
			 * Get the index of current photo in
			 * gallery.
			 *
			 * @return {Integer} Returns the index
			 * of current photo in gallery.
			 */
			getCurrentPhotoIndex: function() {
				return currentPhotoIndex;
			},

			/**
			 * Get the presented photo in the
			 * photo frame as an jQuery object.
			 *
			 * @return {Object} Returns the
			 * presented photo as an jQuery object.
			 * If the gallery is empty, return null.
			 */
			getCurrentPhoto: function() {
				return $currentPhoto;
			},

			/**
			 * Get the photo frame boundaries.
			 *
			 * @return {Object} Return a JSON object
			 * containing top, left bottom, and right
			 * boundary of the photo frame.
			 */
			getFrameBoundaries: function() {
				return {
					top: mask.$top.offset().top + mask.$top.height(),
					bottom: mask.$bottom.offset().top,
					left: mask.$left.offset().left + mask.$left.width(),
					right: mask.$right.offset().left
				};
			},

			/**
			 * Get the gallery object.
			 *
			 * @return {Object} Returns the gallery
			 * object.
			 */
			getGallery: function() {
				return gallery;
			},

			/**
			 * Get the "previous" photo navigation
			 * button as an jQuery object.
			 *
			 * @return {Object} Returns the $prev jQuery
			 * object.
			 */
			getPrevButton: function() {
				return photoNavigationTool.$prev;
			},

			/**
			 * Get the "next" photo navigation
			 * button as an jQuery object.
			 *
			 * @return {Object} Returns the $next jQuery
			 * object.
			 */
			getNextButton: function() {
				return photoNavigationTool.$next;
			},

			/**
			 * Get the "+" zoom-in button as an
			 * jQuery object.
			 *
			 * @return {Object} Returns the $zoomIn
			 * jQuery object.
			 */
			getZoomInButton: function() {
				return photoZoomingTool.$zoomIn;
			},

			/**
			 * Get the "-" zoom-out button as an
			 * jQuery element.
			 *
			 * @return {Object} Returns the $zoomOut
			 * jQuery object.
			 */
			getZoomOutButton: function() {
				return photoZoomingTool.$zoomOut;
			},

			/**
			 * Switch the photo inside photo frame to
			 * a specific one.
			 *
			 * @param {Object} element The photo
			 * to be placed and presented.
			 * @return {Boolean} Return True if the
			 * photo inside photo frame is switched,
			 * return False if no switch happened.
			 */
			setCurrentPhoto: function(element) {
				var matchedIndex = gallery.findPhoto(element);
				
				return instance.setCurrentPhotoByIndex(matchedIndex);
			},

			/**
			 * @private
			 * Set the current photo to a specific one.
			 * currentPhotoIndex and $currentPhoto will
			 * be changed.
			 * 
			 * @param {Integer} index The index of the gallery
			 * to get the to-be-set photo.
			 * @return {Boolean} Return True if the
			 * photo inside photo frame is switched,
			 * return False if no switch happened.
			 */
			setCurrentPhotoByIndex: function(index) {
				var currentPhotoObject;

				if (!gallery.isEmpty() && index >= 0 && index < gallery.getLength()) {
					instance.takeOutPhoto();

					currentPhotoObject = gallery.getPhoto(index);
					currentPhotoIndex = index;
					$currentPhoto = currentPhotoObject.$element;
					photoNavigationTool.$information.html((currentPhotoIndex + 1) + " / " + gallery.getLength());
					
					instance.placePhoto();

					this.setZoomInformation(gallery.getScale(index).horizontal);

					return true;
				}
				else {
					return false;
				}
			},

			/**
			 * Set the current zooming scale.
			 *
			 * @param {Integer} scale The zooming scale
			 * to be set.
			 */
			setZoomInformation: function(scale) {
				photoZoomingTool.$information.html(scale + "%");
			},

			/**
			 * Find the given photo in the gallery by
			 * raw jQuery object or selector.
			 *
			 * @param {Object} {String}
			 * @return {Integer} Returns the key of matched
			 * jQuery element in gallery. If no element
			 * matched, -1 will be returned.
			 */
			findPhoto: function(element) {
				return gallery.findPhoto(element);
			},

			/**
			 * Check if gallery is empty or not.
			 *
			 * @return Return True if gallery is empty,
			 * return False if gallery is not empty.
			 */
			isEmpty: function() {
				return gallery.isEmpty();
			},

			/**
			 * Place the $currentPhoto into the
			 * photo frame.
			 */
			placePhoto: function() {
				if (!gallery.isEmpty() && $currentPhoto) {
					this.takeOutPhoto();
					$container.append($currentPhoto);
				}
			},

			/**
			 * Take out the $currentPhoto from the
			 * photo frame.
			 */
			takeOutPhoto: function() {
				if ($currentPhoto) {
					$currentPhoto.detach();
				}
			},

			/**
			 * Zoom the presented photo by percentage.
			 *
			 * @param {Integer} percentage The percentage
			 * value for the presented photo to be zoomed.
			 */
			zoomPhotoByPercentage: function(percentage) {
				console.log("Photo will be zoomed to " + percentage + "%.");
			}
		};

		return (new Container());
	};

	return Container;
});