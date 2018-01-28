@extends('layout')
@section('content')

@if(Session::has('backToContributorManagementPage'))
  {{ Session::reflash('backToContributorManagementPage') }}
@endif

<div class="jumbotron">
  {!! Form::open([
    'url' => 'contributorPositions',
    'method' => 'post',
    'class' => 'form-horizontal',
    'files' => false
  ]) !!}
    <fieldset>
      <div class="form-group">
        <h2>{{ Lang::get('about.createPosition') }}</h2>
      </div>

      <div class="form-group @if($errors->has('positionName')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get('about.inputPositionName') }}
        </label>
        {!! Form::text('positionName', Input::old('positionName', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("positionName"))
            {{ $errors->first("positionName") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('EnglishPositionName')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get('about.inputEnPositionName') }}
        </label>
        {!! Form::text('EnglishPositionName', Input::old('EnglishPositionName', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("EnglishPositionName"))
            {{ $errors->first("EnglishPositionName") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('positionDetail')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputPositionDetail") }}
        </label>
        {!! Form::textarea('positionDetail', Input::old('positionDetail', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("positionDetail"))
            {{ $errors->first("positionDetail") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('EnglishPositionDetail')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputEnPositionDetail") }}
        </label>
        {!! Form::textarea('EnglishPositionDetail', Input::old('EnglishPositionDetail', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("EnglishPositionDetail"))
            {{ $errors->first("EnglishPositionDetail") }}
          @endif
        </label>
      </div>

      <hr>

      <div class="form-group text-center">
        <button class="btn btn-primary btn-lg" type="submit" value="submit">
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('about.createPosition') }}
        </button>
        <a class="btn btn-default btn-lg" href="{{ URL::to('contributorPositions') }}">
          <span class="glyphicon glyphicon-remove"></span>
          {{ Lang::get('about.cancel') }}
        </a>
      </div>
    </fieldset>
  {!! Form::close() !!}
</div>

@stop