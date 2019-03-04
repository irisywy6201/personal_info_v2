@extends("layout")
@section("content")

<h1>{{ Lang::get('searching.searchingResult') }}</h1>
<em class="help-block">
  {{ Lang::get('searching.resultInformation', [
    'keyword' => $query,
    'number' => $results->total(),
    'location' => Lang::get('menu.' . $location)
  ]) }}
</em>

<br>

<ul class="nav nav-tabs">
  <li role="presentation" class="@if($location == $locations['FAQ']) active @endif">
    {!! HTML::link('searching/' . $locations['FAQ'] . '?query=' . $query , Lang::get('menu.faq')) !!}
  </li>
  <li role="presentation" class="@if($location == $locations['MESSAGE_BOARD']) active @endif">
    {!! HTML::link('searching/' . $locations['MESSAGE_BOARD'] . '?query=' . $query, Lang::get('menu.msg_board')) !!}
  </li>
</ul>

@foreach($results as $key => $data)
  <h3>
    {!! HTML::link($data['link'], $data['title']) !!}
  </h3>
  <p>
    {!! $data['content'] !!}
  </p>

  <hr>
@endforeach

<div class="text-center">
  {!! $results->render() !!}
</div>

@stop