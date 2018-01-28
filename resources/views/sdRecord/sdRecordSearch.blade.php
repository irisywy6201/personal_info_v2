@extends("sdRecord.boardLayout")
@section("sdRecord.content")

<h4>
  <b>{{ Lang::get('sdRecord/board.filterItem') }}:</b>
  @if($filterItem[0])
    <span>
      {{ Lang::get('sdRecord/board.department') }}
      ({{ $filterItemDetail[0] }})
    </span>
  @endif
  @if($filterItem[1])
    @if($filterItem[0])<span>, </span>@endif
    <span>
      {{ Lang::get('sdRecord/board.category') }}
      ({{ $filterItemDetail[1] }})
    </span>
  @endif
  @if($filterItem[2])
    @if($filterItem[0] || $filterItem[1])<span>, </span>@endif
    <span>
      {{ Lang::get('sdRecord/board.askerID') }}
      ({{ $filterItemDetail[2] }})
    </span>
  @endif
  @if($filterItem[3])
    @if($filterItem[0] || $filterItem[1] || $filterItem[2])<span>, </span>@endif
    <span>
      {{ Lang::get('sdRecord/board.solution') }}
      ({{ $filterItemDetail[3] }})
    </span>
  @endif
</h4>
<hr>
@if(count($records) > 0)
  @foreach ($records as $key => $result)
    <h3>
      <span class="label custom-label custom-label-red">{{ Lang::get('sdRecord/board.recorder') }}:</span>
      <span class="cutom-search-font">{!! $result->recorder !!}</span>
      <span class="label custom-label">{{ Lang::get('sdRecord/board.detailDate') }}:</span>
      <span class="cutom-search-font">{!! $result->created_at !!}</span>
      <span class="label custom-label custom-label-blue">{{ Lang::get('sdRecord/board.detailContent') }}:</span>
      <span class="cutom-search-font">{!! HTML::link('deskRecord/' . $result->id, str_limit(strip_tags($result->sdRecCont),28)) !!}</span>
    </h3>
    @if($key != count($records))
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

@endsection
