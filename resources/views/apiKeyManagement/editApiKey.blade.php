@extends('layout')
@section('content')

<div class="jumbotron">
  {{ Form::open(['url' => 'apiKey/' . $id, 'method' => 'put', 'class' => 'form-horizontal']) }}
    <fieldset>
      <div class="form-group">
        <h1>
          {{{ Lang::get('apiKeyManagement.edit') . ' ' . Lang::get('apiKeyManagement.key') }}}
        </h1>
      </div>
      <div class="form-group">
        <label class="control-label" for="key">
          {{{ Lang::get('apiKeyManagement.key') }}}
        </label>
        {{ Form::text('key', '', ['class' => 'form-control', 'placeholder' => $key, 'disabled']) }}
      </div>
      <div class="form-group @if($errors->has('boundIP')) has-error @endif">
        <label class="control-label" for="boundIP">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{{ Lang::get('apiKeyManagement.inputBoundIP') }}}
        </label>
        {{ Form::text('boundIP', $boundIP, ['class' => 'form-control', 'placeholder' => Lang::get('apiKeyManagement.inputBoundIPPlaceholder')]) }}
        @if($errors->has('boundIP'))
          <label class="control-label has-error">
            {{{ $errors->first('boundIP') }}}
        </label>
        @endif
      </div>
      <div class="form-group @if($errors->has('accessLevel')) has-error @endif">
        <label class="control-label" for="accessLevel">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{{ Lang::get('apiKeyManagement.inputAccessLevel') }}}
        </label>
        {{ Form::text('accessLevel', $accessLevel, ['class' => 'form-control', 'placeholder' => Lang::get('apiKeyManagement.inputAccessLevelPlaceholder')]) }}
        @if($errors->has('accessLevel'))
          <label class="control-label has-error">
            {{{ $errors->first('accessLevel') }}}
        </label>
        @endif
      </div>
      <div class="form-group @if($errors->has('accessRate')) has-error @endif">
        <div class="checkbox">
          <label class="@if($errors->has('accessRate')) has-error @endif">
            {{ Form::checkbox('accessRate', '1', $accessRate) }}
            {{{ Lang::get('apiKeyManagement.inputAccessRate') }}}
          </label>
          @if($errors->has('accessRate'))
            <label class="control-label has-error" for="accessRate">
              {{{ $errors->first('accessRate') }}}
            </label>
          @endif
        </div>
      </div>
      <hr class="darker">
      <div class="text-center">
        <button class="btn btn-lg btn-primary" type="submit">
          <span class="glyphicon glyphicon-ok"></span>
          {{{ Lang::get('apiKeyManagement.update') }}}
        </button>
        <a class="btn btn-lg btn-default" href="{{{ URL::to('apiKey') }}}">
          <span class="glyphicon glyphicon-remove"></span>
          {{{ Lang::get('apiKeyManagement.cancelUpdate') }}}
        </a>
      </div>
    </fieldset>
  {{ Form::close() }}
</div>

@stop
