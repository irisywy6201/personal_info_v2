@if(count($results) > 0)
  @foreach ($results as $key => $result)
    <h2>
    	{!! HTML::link('msg_board/' . $result->id, $result->title) !!}
    </h2>
    <p>
      {!! $result->content !!}
    </p>
    @if($key != count($results))
      <hr>
    @endif
  @endforeach

  @include('globalPageTools.scrollTop')
@else
  <h1>
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    {{ Lang::get('searching.noResult') }}
  </h1>
@endif