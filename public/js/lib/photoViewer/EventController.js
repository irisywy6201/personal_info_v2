'use strict';

/**
 * EventController.js
 * @author John Wang (汪子超)
 * This JavaScript file is used by PhotoViewer.js
 * It provides several events for PhotoViewer.
 * For example: dragging the photo inside the photo frame.
 */
define(function () {
	var EventController = function(parent) {
		/** @private */
		var instance,
			photoViewer,
			mouseStatus,
			mousePosition;

		/**
		 * @private
		 * Records the current position and the offset
		 * of the mouse.
		 */
		function recordMouseMovement(e) {
			mousePosition.offX = mousePosition.x - e.clientX;
			mousePosition.offY = mousePosition.y - e.clientY;
			mousePosition.x = e.clientX;
			mousePosition.y = e.clientY;
		}

		/**
		 * @class EventController
		 * @constructor
		 */
		function EventController(parent) {
			// Initializing private members.
			photoViewer = parent;
			mouseStatus = {
				hovering: false,
				pressing: false,
				dragging: false
			};
			mousePosition = {
				x: null,
				y: null,
				offX: null,
				offY: null
			};
			$(document).mouseup(function () {
				photoViewer.getContainer().getCurrentPhoto().mouseup();
			});
			instance = this;
		}

		EventController.prototype = {
			/**
			 * Event handler for the situation that 
			 * when mouse is rolling into the
			 * target element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseIn: function(e) {
				mouseStatus.hovering = true;
				mousePosition.x = e.clientX;
				mousePosition.y = e.clientY;
				mousePosition.offX = 0;
				mousePosition.offY = 0;
				
			},

			/**
			 * Event handler for the situation that 
			 * when mouse is rolling out from the
			 * target element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseOut: function(e) {
				mouseStatus.hovering = false;
				mousePosition.x = null;
				mousePosition.y = null;
				mousePosition.offX = null;
				mousePosition.offY = null;
			},

			/**
			 * Event handler for the situation that 
			 * once mouse is pressed on the target
			 * element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseDown: function(e) {
				mouseStatus.pressing = true;
				recordMouseMovement(e);
			},

			/**
			 * Event handler for the situation that 
			 * when mouse is pressed and then
			 * released from the target element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseUp: function(e) {
				mouseStatus.pressing = false;
				mouseStatus.dragging = false;
				
				if (mouseStatus.hovering) {
					recordMouseMovement(e);
				}
			},

			/**
			 * Event handler for the situation that 
			 * when mouse moving around on the
			 * target element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseMove: function(e) {
				recordMouseMovement(e);

				if (mouseStatus.pressing) {
					mouseStatus.dragging = true;
					instance.mouseDrag(e);
				}
			},

			/**
			 * Event handler for the situation that 
			 * when mouse is dragging the target element.
			 *
			 * @param {Object} e The jQuery event
			 * object.
			 */
			mouseDrag: function(e) {
				var targetPosition = {
						top: $(e.target).offset().top,
						bottom: $(e.target).offset().top + $(e.target).height(),
						left: $(e.target).offset().left,
						right: $(e.target).offset().left + $(e.target).width()
					},
					newTargetPosition = {
						top: $(e.target).offset().top - mousePosition.offY,
						bottom: $(e.target).offset().top - mousePosition.offY + $(e.target).height(),
						left: $(e.target).offset().left - mousePosition.offX,
						right: $(e.target).offset().left - mousePosition.offX + $(e.target).width()
					},
					boundaries = photoViewer.getContainer().getFrameBoundaries(),
					checkBoundResult = null;

				checkBoundResult = instance.checkBound(newTargetPosition, boundaries);

				if (!checkBoundResult.passes) {
					// Horizontal position fixing.
					if ($(e.target).width() < (boundaries.right - boundaries.left)) {
						newTargetPosition.left = boundaries.left;
					}
					else {
						if (checkBoundResult.direction.left) {
							newTargetPosition.left = boundaries.left;
						}
						else {
							if (checkBoundResult.direction.right) {
								newTargetPosition.left = boundaries.right - $(e.target).width();
							}
						}
					}
					// Vertical position fixing.
					if ($(e.target).height() < (boundaries.bottom - boundaries.top)) {
						newTargetPosition.top = boundaries.top;
					}
					else {
						if (checkBoundResult.direction.top) {
							newTargetPosition.top = boundaries.top;
						}
						else {
							if (checkBoundResult.direction.bottom) {
								newTargetPosition.top = boundaries.bottom - $(e.target).height();
							}
						}
					}
				}

				$(e.target).offset({
					top: newTargetPosition.top,
					left: newTargetPosition.left
				});
			},

			/**
			 * Event handler for the situation that
			 * mouse wheel is scrolled on the target
			 * element.
			 */
			mousewheel: function(e) {
				if (mouseStatus.hovering) {
					if (e.deltaY > 0) {
					instance.zoomIn();
					}
					else {
						instance.zoomOut();
					}
				}
			},

			/**
			 * Checking whether the target element has exceeded
			 * the given boundaries or not.
			 *
			 * @param {JSON} targetPosition The position to be
			 * checked.
			 * @param {JSON} boundaries The boundaries which
			 * target position cannot exceeds.
			 * @return {JSON}
			 * - If target photo exceeded the given boundaries:
			 * passes: False
			 * direction: An array which specifies what direction
			 * the target photo exceeded
			 * - If target photo did not exceed the boundary:
			 * passes: True
			 * direction: Empty array.
			 */
			checkBound: function(targetPosition, boundaries) {
				var result = {
					passes: true,
					direction: {
						top: false,
						bottom: false,
						left: false,
						right: false
					}
				};

				if (targetPosition.top >= boundaries.top) {
					result.passes = false;
					result.direction.top = true;
				}
				if (targetPosition.bottom <= boundaries.bottom) {
					result.passes = false;
					result.direction.bottom = true;
				}
				if (targetPosition.left >= boundaries.left) {
					result.passes = false;
					result.direction.left = true;
				}
				if (targetPosition.right <= boundaries.right) {
					result.passes = false;
					result.direction.right = true;
				}

				return result;
			},

			/**
			 * Enter the photo viewer mode (show up the photo
			 * viewer).
			 */
			enterPhotoViewer: function() {
				photoViewer.getPhotoViewerElement().slideDown();
			},

			/**
			 * Exit the photo viewer mode (hide the photo viewer).
			 */
			exitPhotoViewer: function() {
				photoViewer.getPhotoViewerElement().slideUp();
			},

			/**
			 * Switch the photo inside photo frame
			 * to the next one.
			 *
			 * @return {Boolean} Return True if the
			 * photo inside photo frame is switched,
			 * return False if no switch happened.
			 */
			nextPhoto: function() {
				var container = photoViewer.getContainer(),
					crrentPhotoIndex = container.getCurrentPhotoIndex();

				return container.setCurrentPhotoByIndex(crrentPhotoIndex + 1);
			},

			/**
			 * Switch the photo inside photo frame
			 * to the previous one.
			 *
			 * @return {Boolean} Return True if the
			 * photo inside photo frame is switched,
			 * return False if no switch happened.
			 */
			prevPhoto: function() {
				var container = photoViewer.getContainer(),
					crrentPhotoIndex = container.getCurrentPhotoIndex();

				return container.setCurrentPhotoByIndex(crrentPhotoIndex - 1);
			},

			/**
			 * Zoom in the photo by 10%.
			 */
			zoomIn: function() {
				var container = photoViewer.getContainer(),
					gallery = container.getGallery(),
					currentPhotoIndex = container.getCurrentPhotoIndex(),
					originScaleRatio = gallery.getScale(currentPhotoIndex),
					horizontalRatio = originScaleRatio.horizontal + 10,
					verticalRatio = originScaleRatio.vertical + 10;

				gallery.setScale(currentPhotoIndex, horizontalRatio, verticalRatio);
				container.setZoomInformation(gallery.getScale(currentPhotoIndex).horizontal);
			},

			/**
			 * Zoom out the photo by 10%.
			 */
			zoomOut: function() {
				var container = photoViewer.getContainer(),
					gallery = container.getGallery(),
					currentPhotoIndex = container.getCurrentPhotoIndex(),
					originScaleRatio = gallery.getScale(currentPhotoIndex),
					horizontalRatio = originScaleRatio.horizontal - 10,
					verticalRatio = originScaleRatio.vertical - 10;

				gallery.setScale(currentPhotoIndex, horizontalRatio, verticalRatio);
				container.setZoomInformation(gallery.getScale(currentPhotoIndex).horizontal);
			}
		};

		return (new EventController(parent));
	};

	return EventController;
});