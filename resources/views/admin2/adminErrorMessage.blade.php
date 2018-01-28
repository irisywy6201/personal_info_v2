@extends('layout')
@section('content')
<div class="panel panel-danger">
	<div class="panel panel-heading">{{ $title }}</div>
	<div class="panel-body">{{ $content }}</div>
</div>
@stop
