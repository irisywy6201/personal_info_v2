'use strict';

define(function () {
	var value = "",
		text = "",
		dropdownToggle = "",
		$iconHolder = null;

	return {
		bind: function (dropdown, targetInputDOM) {
			$(dropdown).find("a").click(function () {
				dropdownToggle = $(dropdown).find("button");
				value = $(this).attr("id");
				text = $(this).text();
				name = $(dropdownToggle).attr("name");
				$iconHolder = $(dropdownToggle).find(".caret").detach();
			
				if($.trim(dropdownToggle.html())) {
					$(dropdownToggle).text(text);
				}
				
				$(dropdownToggle).append($iconHolder);
				$(targetInputDOM).val(value).trigger('change');
			});
		}
	};
});

