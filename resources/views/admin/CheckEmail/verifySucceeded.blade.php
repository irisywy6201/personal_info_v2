@extends('layout')
@section('content')
	<div class="panel panel-success">
		<div class="panel-heading">
			{{ Lang::get('backupMail.verifySuccess') }}
		</div>
		<div class="panel-body">
			{{ $email }}
			{{ Lang::get('backupMail.successMsg') }}
		</div>
	</div>
@stop