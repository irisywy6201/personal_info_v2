@extends('layout')
@section('content')

<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h1>
      {{ Lang::get('application.name') }}
    </h1>
  </div>
  <div class="panel-body">
    <p>
      {{ Lang::get('backupMail.greeting', ['user' => $user]) }}
      <br><br>
      {{ Lang::choice('backupMail.emailSet', $showPortalEmailMessage, [
        'email' => Crypt::decrypt($email)
      ]) }}
      <br>
      {{ Lang::get('backupMail.emailSent') }}
      <br><br>
      {!! Form::open(['action' => 'EmailController@redoStoreEmailVerification', 'files' => false, 'method' => 'post', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('acct', $acct) !!}
        {!! Form::hidden('email', $email) !!}
        {{ Lang::get('backupMail.notReceiveEmail') }}
        <button type="submit" class="btn btn-primary">
          <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
          {{ Lang::get('backupMail.resendVarificationEmail') }}
        </button>
      {!! Form::close() !!}
      <br><br>
      {{ Lang::get('backupMail.helperMessage.0') }}
      {!! HTML::link(URL::to('systemProblem'), Lang::get('menu.contactUs')) !!}
      {{ Lang::get('backupMail.helperMessage.1') }}
    </p>
  </div>
</div>
@stop