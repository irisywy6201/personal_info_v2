'use strict';

/**
 * Entrance of Javascript.
 */

define(['pageAlert', 'marquee', 'navMain', 'dropdownMenu', 'dropdown', 'FormController', 'sideBar', 'photoViewer/PhotoViewer', 'listGroupController', 'suggestionHelper', 'realTimeSearcher', 'scrollTop'], function (pageAlert, marquee_js, navMain_js, dropdownMenu_js, dropdown_js, FormController, sideBar_js, PhotoViewer, listGroupController, suggestionHelper, realTimeSearcher, scrollTop) {
	$(document).ready(function () {
		var btn_nav = $("#navbar-main").find(".btn-nav"),
			btn_index,
			photoViewer, i, max;

		// Initializes side bar.
		sideBar_js();

		navMain_js.navMainInit($("#navbar-main"));

		// Initializes the page-alert component.
		pageAlert($(".page-alert"));

		scrollTop($('.scroll-top'));

		$("#forDropdownMenu").each(function (){
			dropdownMenu_js.addAllMenu($(this).get(0));
		});
		$("#forDepartMenu").each(function (){
			dropdownMenu_js.addDepartListener($(this).get(0));
			dropdownMenu_js.addCategListener($('#forCategMenu').get(0));
		});

		// Initialization routings of index sub-page.
		marquee_js.addMarqueeAction($(".marquee"));

		$(".container").find(".dropdown").each(function (index, dropdown) {
			var name = $(dropdown).find("button").attr("name");
			dropdown_js.bind(dropdown, $("input[name=" + name + "]"));
		});

		$("form").each(function (index, value) {
			new FormController(value);
		});

		$('#datepicker').datepicker({
			format: "yyyy-mm-dd",
			language: "zh-TW",
			orientation: "top auto",
			autoclose: true,
			todayHighlight: true
		});

		if ($("img.zoomable").length > 0) {
			photoViewer = new PhotoViewer();

			$.ajax({
				type: "post",
				url: window.location.origin + "/photoViewer/getText",
				dataType: "json"
			}).done(function(data, textStatus, jqXHR) {
				photoViewer.getNavigationBar().setBrandText(data.brand);
			}).fail(function(jqXHR, textStatus, errorThrown) {
				// console.dir(errorThrown);
			});

			photoViewer.addZoomablePhoto($("img.zoomable"));
		}

		listGroupController.draggable($("#list_group").find('ul'),$("#list_group").find('input'));

		suggestionHelper($(".suggestion-helper"));

		realTimeSearcher($('.real-time-search-bar'), {
			onAfterResultAdded: function () {
			}
		});
	});
});
