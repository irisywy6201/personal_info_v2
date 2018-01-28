@extends('layout')
@section('content')

<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h1>{{ Lang::get('application.name') }}</h1>
  </div>
  <div class="panel-body">
    <p>
      {{ Lang::get('backupMail.greeting', ['user' => $presentName]) }}
      <br><br>
      {{ Lang::get('backupMail.textualDescription') }}
      <br><br>
      {{ Lang::get('backupMail.browseAsGuest') }}
      <br>
      {{ Lang::get('backupMail.endingSentences') }}
    </p>
    <div class="jumbotron">
      {!! Form::open(['url' => '/email', 'method' => 'post', 'class' => 'form-horizontal']) !!}
        <input name="acct" type="hidden" value="{{ Crypt::encrypt($acct) }}">
        <fieldset>
          <div class="form-group @if($errors->has('name')) has-error @endif" >
            <label class="control-label" for="name">
              <span class="must-fill">*</span>
              {{ Lang::get('backupMail.inputName') }}
            </label>
            <input class="form-control mustFill" id="name" name="name" type="name" placeholder="{{ Lang::get('backupMail.namePlaceHolder') }}" value="{{ Input::old('name', $name) }}" @if($name) readonly @endif">
            <label class="control-label has-error" for="name">
              @if($errors->has("name"))
                {{ $errors->first("name") }}
              @endif
            </label>
          </div>

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
            <input class="form-control mustFill" id="email" name="email" type="email" placeholder="{{ Lang::get('backupMail.emailPlaceHolder') }}" value="{{ Input::old('email') }}">
            <label class="control-label has-error" for="email">
              @if($errors->has("email"))
                {{ $errors->first("email") }}
              @endif
            </label>
          </div>

          @if($errors->has("g-recaptcha-response"))
            <div class="form-group has-error">
          @else
            <div class="form-group">
          @endif
              <label class="control-label" for="g-recaptcha-response">
                <span class="must-fill">*</span>
                {{ Lang::get("recaptcha.pleaseInputRecaptcha") }}
              </label>
              {!! Recaptcha::render() !!}
              {!! Form::close() !!}
              <label class="control-label has-error" for="g-recaptcha-response">
                @if($errors->has("g-recaptcha-response"))
                  {{ $errors->first("g-recaptcha-response") }}
                @endif
              </label>
            </div>

          <div class="form-group">
            <button type="submit" value="submit" class="btn btn-default btn-primary">
              <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
              {{ Lang::get("backupMail.submit") }}
            </button>
          </div>
        </fieldset>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@stop
