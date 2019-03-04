'use strict';

define(function (require) {
	var dropdown_js = require('dropdown');

	function buildMenu(condition,target,callback) {
		getCategory(condition,function (data) {
			for (var i = 0; i < data.length; i++) {
				createCateg(data[i]);
			}
			callback();
		});
	}
	/**
	 * Create li tag which include a tag
	 *
	 */
	function createCateg(data) {

		var ul = null,
			parentTag = null;
		var li = document.createElement('li');
		var aTag = document.createElement('a');

		aTag.setAttribute('tabindex','-1');
		aTag.setAttribute('id',data.id);
		aTag.innerHTML = data.name;
		/**
		  * if this category has sub category
		  */

		if(isHasChildren(data.leaf)) {
			ul = document.createElement('ul');
			ul.setAttribute('class','dropdown-menu' );
			ul.setAttribute('id','menu-'+data.id);

			aTag.setAttribute('data-toggle','dropdown');

			li.setAttribute('class','dropdown-submenu');
			li.appendChild(ul);

		}
		
		parentTag = getBelongParentTag(data.parent_id);
		li.appendChild(aTag);
		parentTag.appendChild(li);
	}

	function isHasChildren(leaf) {
		if(leaf == 0) {
			return true;
		}
		else {
			return false;
		}
	}

	function getBelongParentTag(parent) {
		var tag = $('#menu-'+parent)[0];
		if(tag == undefined) {
			tag = $('#menu-0')[0];
		}
		return tag;
	}

	// initial ul button input and set button enable ;
	function initialMenu(ul,button,input) {

		var icon = $(button).find(".caret").detach();
		if(button.attr('disabled')) {
			button.removeAttr('disabled');
		}
		input.val('');
		button.text('Please choose ');
		button.append(icon);
		ul.empty();
	}

	/**
	 * Get Category
	 * @param  {[int]}   id       [description]
	 * @param  {Function} callback [description]
	 * @return {[type]}            [description]
	 */
	function getCategory(parent,callback) {
		return $.ajax({
			type: "POST",
			url: window.location.origin +'/ajax/category/' + parent,
			data: {
				_token: $('input[name="_token"]').val()
			},
			dataType: "json"
		}).done(callback);
	}

	return {
		/**
		 * Initialization routings of index sub-page.
		 */
		addAllMenu: function (dropdownMenu) {
			buildMenu('0',dropdownMenu,function() {
				dropdown_js.bind($(dropdownMenu), $(dropdownMenu).find("input"));
			});
		},

		addDepartListener: function (departMenu) {
			//dropdown_js.bind($(departMenu), $(departMenu).find("input"));
		},

		addCategListener: function (categMenu) {
			var $forDepartMenuInput = $('#forDepartMenu').find('input');
			/**
			  * if department has default value, we need add category
			  */
			if ($forDepartMenuInput.val() != null && $forDepartMenuInput.val() != '') {
				initialMenu($(categMenu).find('ul'),$(categMenu).find('button'),$(categMenu).find('input'));
				buildMenu($forDepartMenuInput.val(),categMenu,function() {
					dropdown_js.bind($(categMenu), $(categMenu).find("input"));
				});
			}

			$forDepartMenuInput.change(function() {
				//ul,button,input tag in category menu
				initialMenu($(categMenu).find('ul'),$(categMenu).find('button'),$(categMenu).find('input'));
				//$(this).val() mean parent ID
				buildMenu($forDepartMenuInput.val(),categMenu,function() {
					dropdown_js.bind($(categMenu), $(categMenu).find("input"));
				});
			});
		}
	};
});