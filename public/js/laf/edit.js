$('.form_datetime').datetimepicker({
	format:'Y-m-d H:i'
});

$('.form_datetime').on('claimed_at',function(ev){
	$('.form_datetime').val(ev.target.value);
});

$('.form_datetime').on('found_at',function(ev){
	$('.form_datetime').val(ev.target.value);
});

$('.form_datetime').datetimepicker("update","");
