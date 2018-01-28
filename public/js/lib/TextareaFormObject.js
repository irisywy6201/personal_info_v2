'use strict';

/**
 * @see BaseFormObject
 * This JavaScript file provide an sudo-class "TextareaFormObject"
 * which extends from "BaseFormObject".
 * This sudo-class is for <textarea> elements inside
 * <form> tags.
 */
define(function (require) {
	/** @private */
	var BaseFormObject = require("BaseFormObject"),
		global = require("global"),
		fileUploader = new (require("FileUploader"))(),
		hasContentPattern = /([^(<p>)(<\/p>)(<br>)(&nbsp;)( )])/;

	/**
	 * @class TextareaFormObject
	 * @param {Object} DOM Element to be initialized inside <form>.
	 * @param {Object} label The label for current element.
	 */
	function TextareaFormObject(DOM, label) {
		/**
		 * @constructor
		 * @private
		 */
		var DOM = $(DOM),
			placeholder = null,
			labels = label,
			formGroup = $(DOM).closest(".form-group"),
			currentMode = this.modes.defaultMode,
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

		// Define a way to retrieve and set the private attribute "placeholder".
		Object.defineProperty(this, 'placeholder', {
			get: function() {
				return placeholder;
			},

			set: function(ph) {
				placeholder = ph;
			}
		});

		// Event initialization.
		// Use summernote opensource plug-in.
		$(DOM).summernote({
			height: 150,

			oninit: function() {
				var value = $(DOM).val(),
					editor = $(DOM).closest(".form-group").find(".note-editable"),
					ph = $(DOM).attr("placeholder");

				if (ph !== "") {
					placeholder = $("<p>", {"class": "help-block"}).append(ph);
				}
				
				if (value !== "" && value !== $(placeholder).prop('outerHTML')) {
					$(editor).empty().append(value);
					$(editor).find("img").css("width", "100%");
				}
				else {
					$(DOM).html("");

					if (ph !== "") {
						$(editor).empty().append(placeholder);
					}
				}
			},

			onfocus: function(e) {
				instance.onFocus(e);
			},

			onblur: function(e) {
				instance.onBlur(e);
			},
			
			onImageUpload: function(files, editor, editable) {
				instance.onImageUpload(files, editor, editable);
			},

			onChange: function(contents, $editable) {
				instance.onChange(contents, $editable);
			}
		});

		// Chenge DOM to summernote editor.
		DOM = $(DOM).next(".note-editor");
	}

	extend(TextareaFormObject, BaseFormObject);

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "TextareaFormObject".
	 * The following methods in prototype is shared by every
	 * instance of TextareaFormObject.
	 */

	/**
	 * Check if this form element is empty or not.
	 *
	 * @returns {Boolean} True if this element is empty,
	 *					  False if this element has content.
	 */
	TextareaFormObject.prototype.isEmpty = function() {
		var editor = $(this.DOM).find(".note-editable"),
			value = null;

		$(this.placeholder).detach();
		value = $(editor).code();

		if (hasContentPattern.test(value)) { // Content is regarded non-empty
			return false;
		}
		else { // Content is regarded empty.
			return true;
		}
	};

	/**
	 * The event which is fired when this element get focus.
	 */
	TextareaFormObject.prototype.onFocus = function(e) {
		var editor = $(e.target),
			summernote = $(editor).closest(".note-editor");

		if ($(editor).code() === "") {
			$(editor).append("<p><br></p>");
		}
		
		$(this.placeholder).detach();

		$(summernote).addClass("editor-focus");
	};

	/**
	 * The event which is fired when this element loose focus.
	 */
	TextareaFormObject.prototype.onBlur = function(e) {
		var editor = $(e.target),
			summernote = $(editor).closest(".note-editor");

		$(summernote).removeClass("editor-focus");

		if (!this.isEmpty()) {
			this.hideFeedbackMessage();
			this.changeMode(this.modes.defaultMode);
		}
		else {
			$(editor).prepend(this.placeholder);

			if (this.isFeedbackShown()) {
				this.remindFeedbackMessage();
			}
		}
	};

	/**
	 * The event which is fired when content of this element
	 * is changed.
	 */
	TextareaFormObject.prototype.onImageUpload = function(files, editor, editable) {
		var progressBarArea = $(document.getSelection().anchorNode);

		fileUploader.uploadImage(files, progressBarArea, function (data) {
			editor.insertImage(editable, data);
		});
	};

	TextareaFormObject.prototype.onChange = function(contents, $editable) {
		$editable.find("img").not(".zoomable").addClass("thumbnail").addClass("zoomable");
	};

	return TextareaFormObject;
});