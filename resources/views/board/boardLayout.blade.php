@extends('layout')
@section('content')

@include('board.toolBar')

<br>

<div class="real-time-search-wrapper" data-real-time-search-id="message-board-real-time-search-bar">
  <div class="real-time-search-origin-page">
    @yield('board.content')
  </div>
  <div class="real-time-search-result-page"></div>
</div>

@stop