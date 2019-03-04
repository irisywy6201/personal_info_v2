'use strict';

/**
 * This JavaScript file provide a sudo-class "ReplyPanel"
 * for "reply panel" HTML elements.
 *
 * This sudo-class dominate the features of reply panel,
 * including showing textarea and hide the original
 * content for editing this reply, hiding textarea and
 * re-showing the original content of this reply for
 * canceling editing.
 */
define(function () {
	/**
	 * @private
	 * This function adds the "edit action" to this button.
	 * The edit action is to show the edit dialog to user
	 * and hide the origin content of this field.
	 *
	 * @param {DOM} button The "edit" button to be bound to
	 * this action.
	 */
	function editButtonInit(button) {
		var instance = this;

		$(button).click(function() {
			instance.showEditForm();
		});
	}

	/**
	 * @private
	 * This function adds the "cancel action" to this button.
	 * The cancel action is to close the edit dialog,
	 * hidding the edit dialog, and retain the original
	 * content for user.
	 *
	 * @param button The "cancel button" to be bound to this
	 * action.
	 */
	function cancelButtonInit(button) {
		var instance = this;

		$(button).click(function () {
			instance.hideEditForm();
		});
	}

	/**
	 * @class ReplyPanel
	 * @param {DOM} replyPanel The "reply panel" HTML
	 * element.
	 * @param {Object} formObj The instance of
	 * "TextareaFormObject" providing manipulations
	 * toward an <form> HTML element.
	 */
	function ReplyPanel(replyPanel, formObj) {
		/**
		 * @constructor
		 * @private
		 */
		var panel,
			formObject,
			editButton,
			deleteButton,
			cancelButton,
			contentField,
			editField;

		if (replyPanel && replyPanel.length === 1) {
			panel = replyPanel;
			formObject = formObj;
			editButton = $(panel).find(".btn-edit");
			cancelButton = $(panel).find(".btn-cancel");
			contentField = $(panel).find(".content-field");
			editField = $(panel).find(".edit-field");
		}
		else {
			return null;
		}

		if (editButton.length === 1) {
			editButtonInit.call(this, editButton);
		}

		if (cancelButton.length === 1) {
			cancelButtonInit.call(this, cancelButton);
		}

		/**
		 * @public
		 * Define a way to retrieve the private attribute "panel".
		 */
		Object.defineProperty(this, "panel", {
			get: function() {
				return panel;
			}
		});

		/**
		 * @public
		 * Define a way to retrieve the private attribute
		 * "contentField".
		 */
		Object.defineProperty(this, "contentField", {
			get: function() {
				return contentField;
			}
		});

		/**
		 * @public
		 * Define a way to retrieve the private attribute
		 * "editField".
		 */
		Object.defineProperty(this, "editField", {
			get: function() {
				return editField;
			}
		});

		/**
		 * @public
		 * Define a way to retrieve the private attribute
		 * "formObject".
		 */
		Object.defineProperty(this, "formObject", {
			get: function() {
				return formObject;
			}
		});
	};

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "BaseFormObject".
	 * The following methods in prototype is shared by every
	 * instance of BaseFormObject.
	 */
	ReplyPanel.prototype = {
		/**
		 * @function
		 * Showing the textarea and hiding the original
		 * content for editing this reply. 
		 */
		showEditForm: function() {
			$(this.contentField).slideUp("fast");
			$(this.editField).slideDown("fast");
		},

		/**
		 * @function
		 * Hiding the textarea and re-showing the original
		 * content for cancel editing this reply.
		 */
		hideEditForm: function() {
			$(this.editField).slideUp("fast");
			$(this.contentField).slideDown("fast");
			this.formObject.hideFeedbackMessage();
			this.formObject.changeMode(this.formObject.modes.defaultMode);
		}
	};

	return ReplyPanel;
});