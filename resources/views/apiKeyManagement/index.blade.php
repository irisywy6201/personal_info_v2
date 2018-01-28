@extends('layout')
@section('content')

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">
      {{{ Lang::get('apiKeyManagement.myAPIKeys') }}}
    </h3>
  </div>
  @if(count($apiKeys) > 0)
    <table class="table table-hover table-responsive">
      <thead>
        <tr>
          <th>{{{ Lang::get('apiKeyManagement.user') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.key') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.boundIP') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.level') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.accessLimitation') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.createdDate') }}}</th>
          <th>{{{ Lang::get('apiKeyManagement.updatedDate') }}}</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($apiKeys as $index => $apiKey)
          <tr>
            <td>{{{ User::find($apiKey->user_id)->acct }}}</td>
            <td>{{{ $apiKey->key }}}</td>
            <td>{{{ $apiKey->bound_ip }}}</td>
            <td>{{{ $apiKey->level }}}</td>
            <td>
              @if($apiKey->ignore_limits)
                {{{ Lang::get('apiKeyManagement.no') }}}
              @else
                {{{ Lang::get('apiKeyManagement.yes') }}}
              @endif
            </td>
            <td>{{{ $apiKey->created_at }}}</td>
            <td>{{{ $apiKey->updated_at }}}</td>
            <td>
              <a class="btn btn-default" href="{{{ URL::to('apiKey/' . $apiKey->id . '/edit') }}}">
                <span class="glyphicon glyphicon-pencil"></span>
                {{{ Lang::get('apiKeyManagement.edit') }}}
              </a>
            </td>
            <td>
              {{ Form::open(['url' => 'apiKey/' . $apiKey->id, 'method' => 'delete', 'class' => 'form-inline']) }}
                @include('globalPageTools.confirmMessage', ['item' => Lang::get('apiKeyManagement.key')])
                <button class="btn btn-default btn-delete" type="button">
                  <span class="glyphicon glyphicon-trash"></span>
                  {{{ Lang::get('apiKeyManagement.delete') }}}
                </button>
              {{ Form::close() }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <div class="panel-body">
      <h1 class="text-center text-warning">
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        {{{ Lang::get('apiKeyManagement.noAPIKey') }}}
      </h1>
    </div>
  @endif
  <div class="panel-footer">
    {{ Form::open(['url' => 'apiKey', 'method' => 'post', 'class' => 'form-horizontal']) }}
      <fieldset>
        <div class="@if($errors->has('boundIP')) has-error @endif">
          <label class="control-label" for="boundIP">
            <span class="glyphicon glyphicon-asterisk text-danger"></span>
            {{{ Lang::get('apiKeyManagement.inputBoundIP') }}}
          </label>
          {{ Form::text('boundIP', '', ['class' => 'form-control', 'placeholder' => Lang::get('apiKeyManagement.inputBoundIPPlaceholder')]) }}
          @if($errors->has('boundIP'))
            <label class="control-label has-error">
              {{{ $errors->first('boundIP') }}}
          </label>
          @endif
        </div>
        <div class="@if($errors->has('accessLevel')) has-error @endif">
          <label class="control-label" for="accessLevel">
            <span class="glyphicon glyphicon-asterisk text-danger"></span>
            {{{ Lang::get('apiKeyManagement.inputAccessLevel') }}}
          </label>
          {{ Form::text('accessLevel', '', ['class' => 'form-control', 'placeholder' => Lang::get('apiKeyManagement.inputAccessLevelPlaceholder')]) }}
          @if($errors->has('accessLevel'))
            <label class="control-label has-error">
              {{{ $errors->first('accessLevel') }}}
          </label>
          @endif
        </div>
        <div class="@if($errors->has('accessRate')) has-error @endif">
          <div class="checkbox">
            <label class="@if($errors->has('accessRate')) has-error @endif">
              {{ Form::checkbox('accessRate', '1', false) }}
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
            <span class="glyphicon glyphicon-plus"></span>
            {{{ Lang::get('apiKeyManagement.submitAPIKey') }}}
          </button>
        </div>
        <br>
      </fieldset>
    {{ Form::close() }}
  </div>
</div>

@stop
