@extends('layout')
@section('content')
  <div class="panel panel-danger">
    <div class="panel-heading">
      {{ Lang::get('backupMail.failure') }}
    </div>
    <div class="panel-body">
      {{ Lang::get('backupMail.hashCodeError') }}
      <br>
      {{ Lang::get('backupMail.systemError') }}
    </div>
  </div>
@stop