@extends('layout')
@section('content')

{!! Form::open(["url" => ["/email", $id], "files" => true, "method" => "put", "class" => "form-horizontal"]) !!}
  <fieldset>
    <div class="jumbotron">
      <div class="form-group">
        <p>
          {{ Lang::get('backupMail.greeting', ['user' => $user]) }}
        </p>
        <p>
          {{ Lang::get('backupMail.yourCurrentEmailIs', ['email' => $email]) }}
        </p>
        @if($errors->has("email"))
          <div class="form-group has-error">
        @else
          <div class="form-group">
        @endif
          <label class="control-label" for="email">
            <span class="must-fill">*</span>
            {{ Lang::get('backupMail.inputEmail') }}
          </label>
          <span class="pull-right help-block">
            {{ Lang::get("backupMail.notCCEmail") }}
          </span>
        {!! Form::email('email', "", ['id' => 'editEmail', 'placeholder' => Lang::get('backupMail.emailPlaceHolder'), 'class' => 'form-control mustFill']) !!}
        <label class="control-label has-error" for="email">
          @if($errors->has("email"))
            {{ $errors->first("email") }}
          @endif
        </label>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit" name="submit" value="submit">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          {{ Lang::get('backupMail.submit') }}
        </button>
      </div>
    </div>
  </fieldset>
{!! Form::close() !!}

@stop