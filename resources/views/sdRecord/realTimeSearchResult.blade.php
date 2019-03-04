@if(count($results) > 0)
  @foreach ($results as $key => $result)
    <h3>
      <span class="label custom-label custom-label-red">{{ Lang::get('sdRecord/board.recorder') }}:</span>
      <span class="cutom-search-font">{!! $result->recorder !!}</span>
      <span class="label custom-label">{{ Lang::get('sdRecord/board.detailDate') }}:</span>
      <span class="cutom-search-font">{!! $result->created_at !!}</span>
      <span class="label custom-label custom-label-blue">{{ Lang::get('sdRecord/board.detailContent') }}:</span>
      <span class="cutom-search-font">{!! HTML::link('deskRecord/' . $result->id, str_limit(strip_tags($result->sdRecCont),28)) !!}</span>
    </h3>
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
