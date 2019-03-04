@extends("layout")
@section("content")
@if ($errors->has())
	<div class="col-lg-12">
		@foreach ($errors->all() as $error)
		<div class="alert alert-dismissable alert-danger">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>{{ $error }}</strong>
		</div>
		@endforeach
	</div>
@endif
<div class="well">
Login failed ! ... {{ $netid_errorcode }}
</div>
@stop
