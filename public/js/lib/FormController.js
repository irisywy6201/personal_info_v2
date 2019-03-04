/**
 * This JavaScript file provides an sudo-class for every
 * <form> HTML elements to perform some manipulattions to
 * it such as validation, delete confirmation, and so on.
 */
define(function (require) {
	'use strict';

	/**
	 * @private
	 * 
	 * @property {Class} BaseFormObject The class for basic
	 * basic form object. For example: <input type="text">
	 *
	 * @property {Class} TextareaFormObject The class for
	 * <textarea> elements.
	 *
	 * @property {Class} ConfirmMessage This class is needed
	 * when there is a "delete" button and a "conform dialog"
	 * HTML element inside this form.
	 *
	 * @property {Class} ReplyPanel This class is needed when
	 * there are "reply panels" HTML element inside this form.
	 *
	 * @property {JSON} selectors Help selecting different
	 * type of <input> HTML elements.
	 */
	var BaseFormObject = require("BaseFormObject"),
		TextareaFormObject = require("TextareaFormObject"),
		FileFormObject = require("FileFormObject"),
		ConfirmMessage = require("ConfirmMessage"),
		ReplyPanel = require("ReplyPanel"),
		selectors = {
			defaultInput: "input[type=text].mustFill",
			textarea: "textarea.summernote",
			email: "input[type=email].mustFill",
			file: "input[type=file].mustFill",
			password: "input[type=password].mustFill",
			select: "input[type=hidden]",
			submit: "button[type=submit], input[type=submit]"
		};

	/**
	 * @class FormController
	 * @param {DOM} form The form element to be controlled.
	 */
	function FormController(form) {
		/**
		 * @constructor
		 * @private
		 */
		var formObjects,
			$confirmMessage = $(form).find(".confirmMessage"),
			$deleteButton = $(form).find(".btn-delete");
		
		if ($(form).length === 1) {
			formObjects = new Array();

			if ($confirmMessage.length === 1 && $deleteButton.length === 1) {
				new ConfirmMessage($confirmMessage, $deleteButton, null, function () {
					$(form).submit();
				}, null);
			}

			/** @public */
			// Define a way to retrieve the private attribute "selectors".
			Object.defineProperty(this, 'selectors', {
				get: function() {
					return selectors;
				}
			});

			// Define a way to retrieve the private attribute "formObjects".
			Object.defineProperty(this, 'formObjects', {
				get: function() {
					return formObjects;
				}
			});
			
			defaultInputInit($(form).find(selectors.defaultInput), formObjects);
			textareaInit($(form).find(selectors.textarea), formObjects);
			fileInputInit($(form).find(selectors.file), formObjects);
			emailInputInit($(form).find(selectors.email), formObjects);
			submitInit(form, formObjects);
		}
		else {
			return null;
		}
	}

	/**
	 * Initializes the default <input> HTML element (<input type="text">)
	 * with class BaseFormObject.
	 *
	 * @param {DOM} input The <input> HTML element.
	 * @param {Array} formObjects The array to store every form objects
	 * created by class BaseFormObject, TextareaFormObject, and so on.
	 */
	function defaultInputInit(input, formObjects) {
		if (input.length > 0) {
			$(input).each(function (index, value) {
				var obj = new BaseFormObject(value, $(value).closest(".form-group").find(".hidden-feedback"));
				
				formObjects.push(obj);
			});
		}
	}

	/**
	 * Initializes the <textarea> HTML element with class TextareaFormObject.
	 * If this <textarea> is used for "edit field" inside "reply panel", then
	 * an object will be created from class ReplyPanel, too.
	 * 
	 * @param {DOM} textarea The <textarea> element.
	 * @param {Array} formObjects The array to store every form objects
	 * created by class BaseFormObject, TextareaFormObject, and so on.
	 */
	function textareaInit(textarea, formObjects) {
		if ($(textarea).length > 0) {
			$(textarea).each(function (index, value) {
				var obj = new TextareaFormObject(value, $(value).closest(".form-group").find(".hidden-feedback")),
					replyPanel = $(textarea).closest(".replyPanel");
				
				if (replyPanel.length === 1) {
					replyPanel = new ReplyPanel(replyPanel, obj);
				}

				formObjects.push(obj);
			});
		}
	}

	/**
	 * Initializes the <input> HTML element whose type attribute
	 * is "email" (<input type="email">) with class BaseFormObject.
	 *
	 * @param {DOM} input The <input> HTML element.
	 * @param {Array} formObjects The array to store every form objects
	 * created by class BaseFormObject, TextareaFormObject, and so on.
	 */
	function emailInputInit(input, formObjects) {
		if (input.length > 0) {
			$(input).each(function (index, value) {
				var obj = new BaseFormObject(value, $(value).closest(".form-group").find(".hidden-feedback"));

				formObjects.push(obj);
			});
		}
	}

	/**
	 * Initializes the <input> HTML element whose type attribute
	 * is "file" (<input type="file">) with class FileFormObject.
	 *
	 * @param {DOM} input The <input> HTML element.
	 * @param {Array} formObjects The array to store every form objects
	 * created by class BaseFormObject, TextareaFormObject, and so on.
	 */
	function fileInputInit(input, formObjects) {
		if (input.length > 0) {
			$(input).each(function (index, value) {
				var obj = new FileFormObject(value, $(value).closest(".form-group").find(".hidden-feedback"));

				formObjects.push(obj);
			});
		}
	}

	/**
	 * Initializes the submit element with a routing of validations.
	 * Type of submit element includes <button type="submit"> and
	 * <input type="submit">.
	 *
	 * @param {DOM} form This form HTML element.
	 * @param {Array} formObjects The array to store every form objects
	 * created by class BaseFormObject, TextareaFormObject, and so on.
	 */
	function submitInit(form, formObjects) {
		$(form).submit(function (e) {
			var i = 0,
				max = formObjects.length,
				currentObj,
				notSend = false,
				goToDOM;

			for (i; i < max; i += 1) {
				currentObj = formObjects[i];

				if (currentObj.isEmpty()) {
					currentObj.changeMode(currentObj.modes.errorMode);
					currentObj.showFeedbackMessage();

					if (!notSend) {
						goToDOM = currentObj.labels;

						$("body, html").animate({
							scrollTop: ($(goToDOM).offset().top - 60)
						}, "slow");

						notSend = true;
					}
				}
				else {
					currentObj.hideFeedbackMessage(function () {
						currentObj.changeMode(currentObj.modes.defaultMode);
					});
				}
			}
			
			if (notSend) {
				e.preventDefault();
			}
		});
	}

	return FormController;
});