@extends('layout')
@section('content')
  <div class="panel panel-danger">
    <div class="panel-heading">
      {{ $title }}
    </div>
    <div class="panel-body">
      {{ $content }}
      <br>
      {{ Lang::get("backupMail.helperMessage.0") }}
      {!! HTML::link(URL::to("systemProblem"), Lang::get("menu.contactUs")) !!}
      {{ Lang::get("backupMail.helperMessage.1") }}
    </div>
  </div>
@stop