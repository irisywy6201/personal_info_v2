@section("locationBar")

<ol class="breadcrumb">
  <span class="text-muted">
    {{ Lang::get("LostandFound/page.type") }}
    &nbsp;
    &nbsp;
  </span>
  <li>
    @if($option == 0)
      {{Lang::get('LostandFound/page.electronics')}}
    @elseif($option == 1)
      {{Lang::get('LostandFound/page.card or identity')}}
    @elseif($option == 2)
      {{Lang::get('LostandFound/page.decoration')}}
    @elseif($option == 3)
      {{Lang::get('LostandFound/page.book')}}
    @elseif($option == 4)
      {{Lang::get('LostandFound/page.writing materials')}}
    @elseif($option == 5)
      {{Lang::get('LostandFound/page.cloth')}}
    @elseif($option == 6)
      {{Lang::get('LostandFound/page.bags')}}
    @elseif($option == 7)
      {{Lang::get('LostandFound/page.others')}}
    @endif
  </li>
</ol>

@show
