@extends('layout')
@section('content')

<div class="jumbotron">
  {!! Form::open([
    'url' => 'about',
    'method' => 'post',
    'class' => 'form-horizontal',
    'files' => true
  ]) !!}
    <fieldset>
      <div class="form-group">
        <h2>{{ Lang::get('about.createContributor') }}</h2>
      </div>

      <div class="form-group @if($errors->has('name')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get('about.inputName') }}
        </label>
        {!! Form::text('name', Input::old('name', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("name"))
            {{ $errors->first("name") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('EnglishName')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{{ Lang::get('about.inputEnName') }}}
        </label>
        {!! Form::text('EnglishName', Input::old('EnglishName', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("EnglishName"))
            {{ $errors->first("EnglishName") }}
          @endif
        </label>
      </div>      
      
      <div class="form-group @if($errors->has('positions')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get('about.choosePosition') }}
        </label>
        @if($positions)
          @foreach($positions as $key => $position)
            <div class="checkbox">
              <label>
                {!! Form::checkbox('positions[]', $position['id'], Input::old('positions[' . $position['id'] . ']', false)) !!}
                {{ $position['name'] }}
              </label>
            </div>
          @endforeach
          <br>
          <a class="btn btn-sm btn-primary" href="{{ URL::to('contributorPositions/createAndReturn?backToContributorManagementPage=create') }}">
            <span class="glyphicon glyphicon-plus"></span>
          </a>
        @else
          {{ Session::flash('backToContributorManagementPage', URL::to('about/create')) }}
          <h4 class="text-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            {{ Lang::get('about.noPosition') }}
          </h4>
          <a class="btn btn-primary" href="{{ URL::to('contributorPositions/create') }}">
            <span class="glyphicon glyphicon-plus"></span>
            {{ Lang::get('about.createFirstPosition') }}
          </a>
        @endif
        <label class="control-label has-error">
          @if($errors->has("positions"))
            {{ $errors->first("positions") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('introduction')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputIntroduction") }}
        </label>
        {!! Form::textarea('introduction', Input::old('introduction', ''), ['class' => 'summernote', 'placeholder' => Lang::get('about.introductionPlaceholder')]) !!}
        <label class="control-label has-error">
          @if($errors->has("introduction"))
            {{ $errors->first("introduction") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('EnglishIntroduction')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputEnIntroduction") }}
        </label>
        {!! Form::textarea('EnglishIntroduction', Input::old('EnglishIntroduction', ''), ['class' => 'summernote', 'placeholder' => Lang::get('about.introductionPlaceholder')]) !!}
        <label class="control-label has-error">
          @if($errors->has("EnglishIntroduction"))
            {{ $errors->first("EnglishIntroduction") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('ChineseJobResponsibilities')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputJobResponsibilities") }}
        </label>
        {!! Form::textarea('ChineseJobResponsibilities', Input::old('ChineseJobResponsibilities', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("ChineseJobResponsibilities"))
            {{ $errors->first("ChineseJobResponsibilities") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('EnglishJobResponsibilities')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get("about.inputEnJobResponsibilities") }}
        </label>
        {!! Form::textarea('EnglishJobResponsibilities', Input::old('EnglishJobResponsibilities', ''), ['class' => 'form-control']) !!}
        <label class="control-label has-error">
          @if($errors->has("EnglishJobResponsibilities"))
            {{ $errors->first("EnglishJobResponsibilities") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('profilePicture')) has-error @endif">
        <label class="control-label">
          <span class="glyphicon glyphicon-asterisk text-danger"></span>
          {{ Lang::get('about.chooseProfilePicture') }}
        </label>
        <input class="file" name="profilePicture" type="file" value="{{ Input::old('profilePicture', '') }}" data-show-upload="false">
        <label class="control-label has-error">
          @if($errors->has("profilePicture"))
            {{ $errors->first("profilePicture") }}
          @endif
        </label>
      </div>

      <hr>

      <div class="form-group text-center">
        <button class="btn btn-primary btn-lg" type="submit" value="submit">
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('about.createContributor') }}
        </button>
        <a class="btn btn-default btn-lg" href="{{ URL::to('about') }}">
          <span class="glyphicon glyphicon-remove"></span>
          {{ Lang::get('about.cancel') }}
        </a>
      </div>
    </fieldset>
  {!! Form::close() !!}
</div>

@stop