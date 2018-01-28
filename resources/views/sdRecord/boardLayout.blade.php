@extends('layout')
@section('content')

@include('sdRecord.toolBar')

<br>
<div class="real-time-search-wrapper" data-real-time-search-id="sdRecord-real-time-search-bar">
  <div class="real-time-search-origin-page">
    @yield('sdRecord.content')
  </div>
  <div class="real-time-search-result-page"></div>
</div>


@stop
