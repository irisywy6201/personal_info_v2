@extends('layout.index')
@section("content")
<br><br>
{!! Form::open(["route" => "netid", "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
  <fieldset>
    <div class="form-group">
      {!! Form::label('netidlogin', Lang::get('login.usePortal')) !!}
      <br><br>
      <button class="btn btn-lg btn-primary" name="netidlogin" type="submit">
        <span class="glyphicon glyphicon-log-in"></span>
        {{ Lang::get('login.login') }}
      </button>
    </div>
  </fieldset>
{!! Form::close() !!}
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@stop
@section("footer")
  @parent
  <script src="//polyfill.io"></script> 
@stop
