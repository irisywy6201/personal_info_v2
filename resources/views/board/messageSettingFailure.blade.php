@extends('layout')
@section('content')
	<div class="panel panel-danger">
		<div class="panel-heading">
			{{ $title }}
		</div>
		<div class="panel-body">
			{{ $content }}
			<br>
			{{ Lang::get('messageBoard/board.helperMessage.0') }}
			{!! HTML::link(URL::to('/msg_board'), URL::to('/msg_board')) !!}
			{{ Lang::get('messageBoard/board.helperMessage.1') }}
		</div>
	</div>
@stop
