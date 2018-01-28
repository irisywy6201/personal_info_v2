'use strict';

define(function () {
	return {
		draggable: function(listGroup,inputDom) {
			var $listGroup = $(listGroup),
				$inputDom = $(inputDom);

			if ($listGroup.length > 0 && inputDom.length > 0) {
				listGroup.sortable({
					appendTo: document.body,
					cursor: "move",

					stop: function( event, ui ) {
						var sortedIDs = $(this).sortable( "toArray" );
						inputDom.val(sortedIDs);
					}
				});
			}
		} 
	};
});