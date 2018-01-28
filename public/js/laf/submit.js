$('.form_datetime').datetimepicker({
	format:'Y-m-d H:i'
});

$('#type').change(function(){
	var $input = $(this);
	console.dir($(this));
	if ($(this).val() == '') {
		console.log('enter');
		$('#typeerror').html('此項不能不選');
	}
});

$('#submitLost').find('input').blur(inputAjax);

function inputAjax(){

	var URLs = $('#submitLost').attr('action') + '/validation';
	var input = $(this);
	var data = {};
	data[$(this).attr('name')] = $(this).val();

	$.ajax({
			url: URLs,
			type: "get",
			data: data,
			dataType: "json",

			success: function(abc){
				if(abc.hasOwnProperty(input.attr('name'))){
						document.getElementById(input.attr('name')+'error').innerHTML= abc[input.attr('name')];
				}else{
						document.getElementById(input.attr('name')+'error').innerHTML= '';
				}

				/*
				$.each(abc, function (key, value) {
					var name = key + "error";
					document.getElementById(name).innerHTML=value;
				});
				*/
			},

			error: function(xhr,thrownError){
				console.log('ajax request fail!!');
			}
	});

}

$("#images").fileinput({
	uploadUrl: $('#submitLost').attr('action') + '/validation',
    maxFileCount: 4,
    minFileCount: 1,
    validateInitialCount: true,
    overwriteInitial: false,
    allowedFileExtensions: ["jpg", "png", "gif"]
})
