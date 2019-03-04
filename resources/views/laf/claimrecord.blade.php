@extends('laf.lafLayout')
@section('laf.content')

@if($military == 0)
<h1>
  <span class="glyphicon glyphicon-record"></span>
  {{ Lang::get('LostandFound/page.claimrecord') }}
</h1>
@elseif($military == 1)
<h1>
  <span class="glyphicon glyphicon-record"></span>
  已移送至軍訓室
</h1>
@endif

@if(count($results)>0)
<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th>ID</th>
      <th>{{ Lang::get('LostandFound/page.type') }}</th>
      <th>{{ Lang::get('LostandFound/page.description') }}</th>
      <th>{{ Lang::get('LostandFound/page.location') }}</th>
      <th>{{ Lang::get('LostandFound/page.find_time') }}</th>
      @if($military == 0)
        <th>{{ Lang::get('LostandFound/page.timeOfClaim') }}</th>
      @endif
      <th>{{ Lang::get('LostandFound/page.picOfThing') }}</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($results as $key => $value)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ Lang::get('LostandFound/page.'.$value['type_id']) }}</td>
        <td>{{ $value['description'] }}</td>
        <td>{{ $value['location'] }}</td>
        <td>{{ $value['found_at'] }}</td>
        @if($military == 0)
          <td>{{ $value['claimed_at'] }}</td>
        @endif
	<td><img src={{URL::to($value['thing_picture1'])}} data-action="zoom" style="width: 50px;height: 50px"></td>
      </tr>
    @endforeach
  </tbody>
</table>
@else
<h2>
  <span class="glyphicon glyphicon-exclamation-sign"></span>
  {{ Lang::get('searching.noResult') }}
</h2>
@endif

{!! HTML::script('js/laf/record.js') !!}
@stop
