'use strict';

/**
 * @Singleton
 * This JavaScript file provides a singleton FileUploader
 * sudo-class for uploading any type of file onto server.
 * The current version of FileUploader only provides
 * uploadImage method to send and store multiple image
 * files onto server, the file type will be validated, too.
 */
define(function () {
	/**
	 * @private
	 *
	 * @property {Object} instance The instance of FileUploader,
	 * used to check whether there is an instance of FileUploader
	 * created.
	 *
	 * @property {RegExp} imgPattern The regular expression to
	 * validate the type of uploaded files.
	 *
	 * @property {Object} errorHandler The handler to be executed
	 * when validation of uploaded files failed.
	 */
	var instance,
		imgPattern = /(image)/,
		errorHandler = {
			/**
			 * @function
			 *
			 * Handler of image validation error.
			 */
			imageHandler: function() {
				console.log("error");
			},

			audioHandler: function() {

			},

			videoHandler: function() {

			}
		};

	/**
	 * @private
	 * Generates a progress bar DOM.
	 *
	 * @param {String} id The "id" attribute for this
	 * progress bar.
	 *
	 * @returns {DOM} Progress bar <Div>.
	 */
	function generateProgressBar(id) {
		var $progressBarWrapper = $("<div>"),
			$progressBar = $("<div>");

		$progressBarWrapper.addClass("progress");
		$progressBar.addClass("progress-bar progress-bar-warning progress-bar-striped active");
		$progressBar.attr("role", "progressbar");
		$progressBar.attr("aria-valuenow", "0");
		$progressBar.attr("aria-valuemin", "0");
		$progressBar.attr("aria-valuemax", "100");
		$progressBar.css("width", "0");


		if (id && id.length > 0) {
			$progressBar.attr("id", id);
		}

		$progressBarWrapper.append($progressBar);

		return $progressBarWrapper;
	}

	/**
	 * @private
	 * Send multiple files onto server.
	 *
	 * @param {File} files The files to be uploaded.
	 * @param {String} url The URL corresponds to the file
	 * uploading controller on server.
	 * @param {DOM} The HTML element to present the progress
	 * of the uploading procedure.
	 * @param {Function} callback The cakkback funciton to be
	 * executed after file uploading is "succeeded".
	 */
	function sendFile(files, url, progressBarArea, callback) {
		var uploadFile = new FormData(),
			returnData,
			progressBar = generateProgressBar(null);

		$.each(files, function(index, value) {
			uploadFile.append("file" + index, value);
		});

		$.ajax({
			type: 'post',
			url: url,
			xhr: function() {
				// Upload progress
				var xhr = new window.XMLHttpRequest();

				$(progressBarArea).append(progressBar);

				xhr.upload.addEventListener("progress", function(e) {
					var progressPercentage, bar;

					if (e.lengthComputable) {
						progressPercentage = (e.loaded / e.total) * 100;
						bar = $(progressBar).children(".progress-bar");

						$(bar).css("width", progressPercentage + "%");
						$(bar).attr("aria-valuenow", progressPercentage);
					}
				}, false);

				return xhr;
			},
			data: uploadFile,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json'
		}).done(function (data, textStatus, jqXHR) {
			$(progressBar).detach();
			
			if (callback && typeof(callback) === "function") {
				callback(data);
			}
		}).fail(function (jqXHR, textStatus, errorThrown) {
			// console.dir(errorThrown);
		});
	}

	/**
	 * @class FileUploader
	 */
	function FileUploader() {
		/** @constructor */
		if (instance) {
			return instance;
		}

		instance = this;
	};

	/**
	 * @public
	 *
	 * This is the prototype of sudo-class "FileUploader".
	 * The following methods in prototype is shared by every
	 * instance of FileUploader.
	 */
	FileUploader.prototype = {
		/**
		 * @function
		 *
		 * Upload image files onto server.
		 * @param {File} files The image files to be uploaded.
		 * @param {DOM} progressBarArea The HTML element to
		 * present the progress of uploading procedure.
		 * @param {Function} callback The cakkback funciton to be
		 * executed after file uploading is "succeeded".
		 */
		uploadImage: function(files, progressBarArea, callback) {
			var i = 0,
				max = files.length,
				currentFile,
				isSendOkay = true;

			for (i; i < max; i += 1) {
				currentFile = files[i];

				if (!imgPattern.test(currentFile.type)) {
					errorHandler.imageHandler();
					isSendOkay = false;
					break;
				}
			}
			
			if (isSendOkay) {
				sendFile(files, "/imgFile", progressBarArea, callback);
			}
		},

		uploadAudio: function(files, progressBarArea, callback) {

		},

		uploadVideo: function(files, progressBarArea, callback) {

		}
	};

	return FileUploader;
});