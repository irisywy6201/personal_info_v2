'use strict';

/**
 * This JavaScript file provide a sudo-class "ConfirmMessage"
 * for "confirmMessage" HTML elements inside a <form>.
 *
 * This sudo-class is used for showing, hiding confirm message,
 * lock or unlock the screen, as well as detect which button on
 * this message is pressed by user to decide the <form> or the
 * action done by user should be submitted or continued.
 *
 * Buttons on this confirm message is "confirm" and "cancel".
 */
define(function (require) {
	/**
	 * @private
	 * @property {Object} lockScreen The singleton
	 * "lockScreen" object providing screen locking.
	 */
	var lockScreen = new (require("LockScreen"))();

	/**
	 * @private
	 * Bind the event to the trigger element.
	 * That is, slide down the confirm message and
	 * call the handler callback.
	 *
	 * @param {Object} $element The trigger element.
	 * @param {Function} handler The callback function.
	 */
	function triggerElementInit($element, handler) {
		var that = this;

		$element.click(function () {
			that.show(handler);
		});
	}

	/**
	 * @private
	 * This function adds the action to the "confirm button"
	 * inside confirm message. When the "confirm button" is
	 * clicked, the form containing this confirm message will
	 * be submitted
	 *
	 * @param {DOM} button The "confirm button" to be bind
	 * to this action.
	 * @param {DOM} form The form to be submitted.
	 */
	function confirmButtonInit($button, handler) {
		var that = this;

		$button.click(function() {
			that.hide(handler);
		});
	}

	/**
	 * @private
	 * This function adds the action to the "cancel button"
	 * inside confirm message. When the "cancel button" is
	 * clicked, the confimr message containing this button
	 * will become invisible, and the screen will be unlocked.
	 *
	 * @param {DOM} button The "cancel button" to be bind to
	 * this action.
	 */
	function cancelButtonInit($button, handler) {
		var that = this;

		$button.click(function() {
			that.hide(handler);
		});
	}

	/**
	 * @class ConfirmMessage
	 * @param {Object} or {Selector} confirmMessageDOM The confirmMessage
	 * HTML element.
	 * @param {Object} or {Selector} triggerElement The element which triggers
	 * the slide down event of confirm message.
	 * @param {Function} onTriggerHandler The callback to be triggered when
	 * triggerElement clicked.
	 * @param {Function} onConfirmHandler The callback to be triggered when 
	 * the confirm button is clicked.
	 * @param {Function} onCancelHandler The callback to be triggered when
	 * the cancel button is clicked.
	 */
	function ConfirmMessage(confirmMessageDOM, triggerElement, onTriggerHandler, onConfirmHandler, onCancelHandler) {
		var $confirmDialog = $(confirmMessageDOM),
			$triggerElement = $(triggerElement);

		if ($confirmDialog.length === 1 && $triggerElement.length === 1) {
			this.$confirmDialog = $confirmDialog;
			this.$triggerElement = $triggerElement;
			this.$confirmButton = this.$confirmDialog.find(".btn-confirm");
			this.$cancelButton = this.$confirmDialog.find(".btn-cancel-confirm");
		}
		else {
			return null;
		}

		triggerElementInit.call(this, this.$triggerElement, onTriggerHandler);
		confirmButtonInit.call(this, this.$confirmButton, onConfirmHandler);
		cancelButtonInit.call(this, this.$cancelButton, onCancelHandler);
	};

	/**
	 * Show the confirm message dialog and lock the screen.
	 * @param {Function} callback The function to be
	 * executed after this method is completed.
	 */
	ConfirmMessage.prototype.show = function(callback) {
		lockScreen.lock(this.$confirmDialog, "fast", "slide");
		this.$confirmDialog.slideDown("fast", callback);
	};

	/**
	 * Hide the confirm message dialog and unlock the screen.
	 * @param {Function} callback The function to be
	 * executed after this method is completed.
	 */
	ConfirmMessage.prototype.hide = function(callback) {
		this.$confirmDialog.slideUp("fast");
		lockScreen.unlock("fast", callback);
	}

	return ConfirmMessage;
});