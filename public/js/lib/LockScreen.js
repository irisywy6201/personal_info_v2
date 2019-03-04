'use strict';

/**
 * @Singleton
 * This JavaScript file provides a singleton LockScreen
 * sudo-class for "lockScreen" HTML element.
 * This sudo-class is used to realize the function of
 * lock and unlock the screen to prevent user from
 * clicking other HTML elements behind the "lock screen"
 * mask.
 */
define(function () {
	/**
	 * @private
	 *
	 * @property {Object} instance The instance of this
	 * singleton sudo-class.
	 *
	 * @property {DOM} lockScreen The "lockScreen" HTML
	 * element.
	 */
	var instance, lockScreen, elementHolder;

	/**
	 * @class LockScreen
	 */
	function LockScreen() {
		/** @constructor */
		if (instance) {
			return instance;
		}

		instance = this;

		lockScreen = $("#lockScreen");
		
		$(lockScreen).click(function () {
			instance.unlock("fast");
		});
	};

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "LockScreen".
	 * The following methods in prototype is shared by every
	 * instance of LockScreen.
	 */
	LockScreen.prototype = {
		/**
		 * @function
		 * 
		 * Lock the screen.
		 * 
		 * @param {Object} {String} element The element
		 * to be hidden after lockScreen clicked.
		 * @param {Integer} {String} speed The animation
		 * speed of showing the lockScreen.
		 * @param {Function} elementHideMethod The method
		 * to hide the element, if this parameter is not
		 * set, slide up will be used.
		 * @param {Function} elementHideCallback The
		 * function to be executed after the unlock function
		 * is finished.
		 * @param {Function} callback The function to be
		 * executed after lock function finished.
		 */
		lock: function(element, speed, elementHideMethod, elementHideCallback, callback) {
			elementHolder = element;
			$(lockScreen).fadeIn(speed, callback);

			$(lockScreen).click(function () {
				instance.unlock(speed, elementHideMethod, elementHideCallback);
			});
		},

		/**
		 * @function
		 *
		 * Unlock the screen.
		 *
		 * @param {Integer} {String} speed The animation
		 * speed of showing the lockScreen.
		 * @param {Function} elementHideMethod The method
		 * to hide the element, if this parameter is not
		 * set, slide up will be used.
		 * @param {Function} callback The function to be
		 * executed after lock function finished.
		 */
		unlock: function(speed, elementHideMethod, callback) {
			if (typeof elementHideMethod == "function") {
				elementHideMethod(elementHolder);
			}
			else {
				switch(elementHideMethod) {
					case "fade":
						$(elementHolder).fadeOut(speed);
						break;
					case "slide":
						$(elementHolder).slideUp(speed);
						break;
					default:
						$(elementHolder).slideUp(speed);
						break;
				}
			}

			$(lockScreen).fadeOut(speed, callback);
		}
	};

	return LockScreen;
});