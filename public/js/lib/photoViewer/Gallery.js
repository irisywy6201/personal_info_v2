'use strict';

/**
 * Gallery.js
 * @author John Wang (汪子超)
 * This JavaScript file is used by Container.js
 * It provides a gallery for storing photos and
 * remembers informations of each photo itself.
 */
define(function (require) {
	var Gallery = function() {
		/** @private */
		var photoObjects;

		/**
		 * @class Gallery.
		 * @constructor.
		 */
		function Gallery() {
			photoObjects = [];
		}

		Gallery.prototype = {
			/**
			 * Add a photo into this gallery.
			 *
			 * @param {Object} {Selector} element
			 * The photo to be added.
			 * @return {JSON} Returns the added
			 * photo as an gallery defined photo object.
			 */
			addPhoto: function(element) {
				var imgSrc = "",
					$newImage = null,
					newPhotoObject = null;

				if ($(element).length === 1) {
					imgSrc = $(element).attr("src");
					$newImage = $("<img></img>").addClass("photo-presented").attr("draggable", false).attr('unselectable', 'on').attr("ondragstart", "return false;");

					$newImage.attr("src", imgSrc);
					$newImage.width($(element).width());
					$newImage.height($(element).height());
					newPhotoObject = {
						$element: $newImage,
						originSize: {
							width: $(element).width(),
							height: $(element).height()
						},
						scale: {
							horizontal: 100,
							vertical: 100
						}
					};

					photoObjects.push(newPhotoObject);
				}

				return newPhotoObject;
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
				var i = 0,
					max = photoObjects.length,
					currentPhotoSrc,
					result = -1;

				if (!this.isEmpty()) {
					for (i; i < max; i++) {
						currentPhotoSrc = photoObjects[i].$element.attr("src");

						if (currentPhotoSrc == $(element).attr("src")) {
							result = i;
							break;
						}
					}
				}

				return result;
			},

			/**
			 * Get the total number of added photos.
			 *
			 * @return {Integer} The length of
			 * photoObjects.
			 */
			getLength: function() {
				return photoObjects.length;
			},

			/**
			 * Get the specific photo object by
			 * index.
			 *
			 * @param {Integer} index The index of
			 * photoObjects.
			 * @return {Object} Returns the instance
			 * of index-th. photoObject. If gallery is
			 * empty, returns Null.
			 */
			getPhoto: function(index) {
				if (!this.isEmpty()) {
					return photoObjects[index];
				}
				else {
					return null;
				}
			},

			/**
			 * Get the scale ratio of specific photo.
			 *
			 * @param {Integer} index The index of the
			 * photo in photoObjects.
			 * @return {JSON} Returns a scale object
			 * containning horizontal and vertical scale
			 * ratio, returns Null if no photo is matched
			 * with the given index.
			 */
			getScale: function(index) {
				if (!this.isEmpty() && index >= 0 && index < this.getLength()) {
					return photoObjects[index].scale;
				}
				else {
					return null;
				}
			},

			/**
			 * Check this gallery is empty or not.
			 *
			 * @return {Boolean} Returns True if
			 * gallery is empty, that is, not a
			 * single photo is added, returns
			 * False if there's one or more photos
			 * added to this gallery.
			 */
			isEmpty: function() {
				if (photoObjects.length === 0) {
					return true;
				}
				else {
					return false;
				}
			},

			/**
			 * Remove and then retrieve the specific
			 * photo from gallery.
			 * If index is defined, the index-th
			 * photo of photoObjects will be removed,
			 * otherwise, the last photo of photoObjects
			 * will be removed.
			 *
			 * @param {Integer} index The index of photoObjects.
			 * @return {Object} Returns the removed photo object,
			 * if no photo object is removed, Null will be returned.
			 */
			removePhoto: function(index) {
				var photoObjectRemoved = null;

				if (!this.isEmpty() && index >= 0 && index < this.getLength()) {
					if (index !== undefined && index !== null) {
						photoObjectRemoved = photoObjects[index];
						photoObjects.splice(index, 1);
					}
					else {
						photoObjectRemoved = photoObjects.pop();
					}
				}

				return photoObjectRemoved;
			},

			/**
			 * Set the scale of specific photo.
			 *
			 * @param {Integer} index The index of the photo
			 * in photoObject.
			 * @param {Integer} horizontal The horizontal scale
			 * ratio to be set.
			 * @param {Integer} vertical The vertical scale ratio
			 * to be set.
			 * @return {Boolean} Returns True if scale setting
			 * has succeeded, returns False if scale setting
			 * failed.
			 */
			setScale: function(index, horizontal, vertical) {
				var photoObject;

				if (!this.isEmpty() && index >= 0 && index < this.getLength() &&
					horizontal >= 0 && vertical >= 0) {
					photoObject = photoObjects[index];

					photoObject.scale.horizontal = horizontal;
					photoObject.scale.vertical = vertical;
					photoObject.$element.width((horizontal / 100) * photoObject.originSize.width);
					photoObject.$element.height((vertical / 100) * photoObject.originSize.height);
					
					return true;
				}
				else {
					return false;
				}
			}
		};

		return (new Gallery());
	};

	return Gallery;
});