@extends('layout')
@section('content')
  <br>
  <div class="panel panel-warning">
    <div class="panel-heading"><h1>{{ Lang::get('application.name') }}</h1></div>
    <div class="panel-body">
      <p>
        {{ Lang::get('backupMail.greeting', ['user' => $user]) }}
        <br><br>
        {{ Lang::get('backupMail.hasBeenUsed', ['email' => $email]) }}
        <br><br>
        {{ Lang::get("backupMail.helperMessage.0") }}
        {!! HTML::link(URL::to("systemProblem"), Lang::get("menu.contactUs")) !!}
        {{ Lang::get("backupMail.helperMessage.1") }}
      </p>
    </div>
  </div>
@stop