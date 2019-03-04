'use strict';

/**
 * This JavaScript file provide an abstract sudo-class
 * "BaseFormObject" for elements inside a <form> such as
 * <input>, <select>, <textarea>, and so on.
 *
 * This sudo-class only provide a basic structure.
 * The specific method of each different element should be
 * overridden appropriately.
 */
define(function () {	
	/** 
	 * @private
	 *
	 * @property {JSON} modes Different modes of this objecct.
	 * modes may be changed when user give an inappropriate or
	 * incorrect value to the element.
	 *
	 * @property {JSON} animationOp1 the animation for emphasis
	 * of feedback message.
	 *
	 * @property {JSON} animationOp2 the 2nd. animation followed
	 * by animationOp1.
	 */
	var modes = {
			"defaultMode": "default",
			"successMode": "has-success",
			"warningMode": "has-warning",
			"errorMode": "has-error"
		},
		animateOp1 = {
			marginRight: "+=3",
			marginLeft: "+=3"
		},
		animateOp2 = {
			marginRight: "-=3",
			marginLeft: "-=3"
		},
		hasContentPattern = /\S/;

	/**
	 * @private
	 *
	 * @param {Array} object The DOM to be analized.
	 * @param {String} selector The string for CSS selector.
	 *
	 * @returns {Object} The first occurrence of matched
	 * element in object.
	 */
	function findMatchedElement(object, selector) {
		var i = 0,
			max = object.length;

		for (i; i < max; i += 1) {
			if ($(object[i]).is(selector)) {
				return object[i];
			}
		}
	}

	/**
	 * @class BaseFromObject
	 * @param {Object} DOM Element to be initialized inside <form>.
	 * @param {Object} label The label for current element.
	 */
	function BaseFormObject(DOM, label) {
		/**
		 * @constructor
		 * @private
		 */
		var DOM = DOM,
			labels = label,
			formGroup = $(DOM).closest(".form-group"),
			currentMode = modes.defaultMode,
			instance = this;

		/** @public */
		// Define a way to retrieve the private attribute "DOM".
		Object.defineProperty(this, 'DOM', {
			get: function() {
				return DOM;
			}
		});

		// Define a way to retrieve the private attribute "labels".
		Object.defineProperty(this, 'labels', {
			get: function() {
				return labels;
			}
		});

		// Define a way to retrieve the private attribute "formGroup".
		Object.defineProperty(this, 'formGroup', {
			get: function() {
				return formGroup;
			}
		});

		// Define a way to retrieve and set the private attribute "mode".
		Object.defineProperty(this, 'mode', {
			get: function() {
				return currentMode;
			},

			set: function(mode) {
				currentMode = mode;
			}
		});

		// Event initialization.
		$(DOM).focus(function () {
			instance.onFocus();
		});

		$(DOM).blur(function () {
			instance.onBlur();
		});

		$(DOM).change(function () {
			instance.onChange();
		});
	};

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "BaseFormObject".
	 * The following methods in prototype is shared by every
	 * instance of BaseFormObject.
	 */
	BaseFormObject.prototype = {
		/**
		 * Check if this form element is empty or not.
		 *
		 * @returns {Boolean} True if this element is empty,
		 *					  False if this element has content.
		 */
		isEmpty: function() {
			var value = $(this.DOM).val();
			
			if (!hasContentPattern.test(value)) { // If no word character.
				return true;
			}
			else { // There is one or more characters.
				return false;
			}
		},

		/**
		 * Check if the feedback massage of this form element
		 * is shown or not.
		 *
		 * @returns {Boolean} True if feedback massage is hidden.
		 *					  False otherwise.
		 */
		isFeedbackShown: function() {
			if ($(this.labels).is(":hidden")) {
				return false;
			}
			else {
				return true;
			}
		},

		/**
		 * Change the mode of this form element.
		 * Mode may be changed when the content of this element is
		 * changed.
		 *
		 * @param {String} modeToChange The mode this element to be
		 * chenged to.
		 *
		 * @param {Function} callback The callback to be executed
		 * after the mode of this element is changed.
		 */
		changeMode: function(modeToChange, callback) {
			if ($.inArray(modeToChange, modes)) {
				if (modeToChange === modes.defaultMode) {
					for (var key in modes) {
						$(this.formGroup).removeClass(modes[key]);
					}
				}
				else {
					$(this.formGroup).addClass(modeToChange);
					this.mode = modeToChange;
				}

				(callback && typeof(callback) === "function") && callback();
			}
		},

		/**
		 * Display the hiddne feedback message for this element.
		 * The message to be shown is the one corresponds to the
		 * current mode of this element.
		 *
		 * @param {Function} callback The callback function to be
		 * executed after feedback message shown.
		 */
		showFeedbackMessage: function(callback) {
			var message = findMatchedElement(this.labels, "." + this.mode);

			if (message) {
				if ($(message).css("display") === "none") {
					$(message).slideDown(90, callback);
				}
				else {
					$(message).animate(animateOp1, 90).animate(animateOp2, 90).animate(animateOp1, 90).animate(animateOp2, 90, callback);
				}
			}
		},

		/**
		 * Hide the shown feedback message for this element.
		 * The message to be hidden is the one corresponds to the
		 * current mode of this element.
		 *
		 * @param {Function} callback The callback function to be
		 * executed after feedback message hidden.
		 */
		hideFeedbackMessage: function(callback) {
			var message = findMatchedElement(this.labels, "." + this.mode);

			if (message) {
				$(message).slideUp(90, callback);
			}
		},

		/**
		 * Animate the feedback message a little to get user's
		 * attention, reminding user of this message.
		 */
		remindFeedbackMessage: function() {
			var i = 0,
				max = 2,
				speed = 90;

			for (i; i < max; i += 1) {
				$(this.labels).animate(animateOp1, speed).animate(animateOp2, speed);
			}
		},

		/**
		 * The event which is fired when this element get focus.
		 */
		onFocus: function() {
			
		},

		/**
		 * The event which is fired when this element loose focus.
		 */
		onBlur: function() {
			if (!this.isEmpty()) {
				this.hideFeedbackMessage();
				this.changeMode(this.modes.defaultMode);
			}
			else {
				if (this.isFeedbackShown()) {
					this.remindFeedbackMessage();
				}
			}
		},

		/**
		 * The event which is fired when content of this element
		 * is changed.
		 */
		onChange: function() {

		}
	};

	/**
	 * @public
	 * Define the way to retrieve the private attribute "modes".
	 */
	Object.defineProperty(BaseFormObject.prototype, 'modes', {
		get: function() {
			return modes;
		}
	});

	return BaseFormObject;
});