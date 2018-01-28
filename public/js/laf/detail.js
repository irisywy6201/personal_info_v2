$(".account").hide();
$("#schoolID").hide();

$('#staffRB').click(function(){
	$(".account").hide();
	$(".student").show(500);
	$("#schoolID").show(500);
});

$('#studentRB').click(function(){
	$(".account").hide();
	$(".staff").show(500);
	$("#schoolID").show(500);
});

