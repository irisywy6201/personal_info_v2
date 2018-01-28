@extends("errors.errorsLayout")
@section("errors.content")
  <p>{{{ Lang::get('errors.iron.content') }}}</p>
  <p>{{ Lang::get('errors.iron.handle') }}</p>
@stop