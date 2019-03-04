@extends('layout')
@section('content')
<div class="text-center">
  <h1 class="text-danger">
    @if($exception->getMessage())
      {{ $exception->getCode() . ' ' . $exception->getMessage() }}
    @else
      {{ Lang::get('errors.' . $exception->getStatusCode() . '.title') }}
    @endif
  </h1>
  <hr>
  @yield('errors.content')
  <br>
</div>
@stop
