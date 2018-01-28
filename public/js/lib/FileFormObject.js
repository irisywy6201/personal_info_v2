'use strict';

/**
 * @see BaseFormObject
 * This JavaScript file provide an sudo-class "FileFormObject"
 * which extends from "BaseFormObject".
 * This sudo-class is for <input> elements whose "type" is file
 * inside <form> tags.
 * The current version of "FileFormObject" provides image
 * uploading only.
 */
define(function (require) {
	/** @private */
	var BaseFormObject = require("BaseFormObject"),
		global = require("global"),
		fileUploader = new (require("FileUploader"))(),
		hasContentPattern = /([^(<p>)(<\/p>)(<br>)(&nbsp;)( )])/;

	/**
	 * @class FileFormObject
	 * @param {Object} DOM Element to be initialized inside <form>.
	 * @param {Object} label The label for current element.
	 */
	function FileFormObject(DOM, label) {
		/**
		 * @constructor
		 * @private
		 */
		var DOM = $(DOM),
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

		$(DOM).change(function () {
			instance.onChange();
		});
	};

	extend(FileFormObject, BaseFormObject);

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "FileFormObject".
	 * The following methods in prototype is shared by every
	 * instance of FileFormObject.
	 */

	/**
	 * The event which is fired when content of this element
	 * is changed.
	 * Detail of this method is send request to server for
	 * file uploading, then add the uploaded file to the
	 * "previewArea" for user to preview the file he/she
	 * choosen before submit the form.
	 */
	FileFormObject.prototype.onChange = function() {
		var files = $(this.DOM)[0].files,
			previewArea = $(this.formGroup).find(".previewArea");

		// Clean all preview area.
		$(previewArea).empty();

		// Upload file onto server.
		fileUploader.uploadImage(files, previewArea, function (data) {
			// Add uploaded files to "previewArea".
			$.each(data, function (index, value) {
				if (previewArea[index]) {
					$(previewArea[index]).append('<img src="' + value + '" alt="preview of image">');
				}
			});
		});
	};

	return FileFormObject;
});