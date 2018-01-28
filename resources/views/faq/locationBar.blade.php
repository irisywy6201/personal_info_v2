@section("locationBar")

<ol class="breadcrumb">
  <span class="text-muted">
    {{ Lang::get("faq.currentLocation") }}
    &nbsp;
    &nbsp;
  </span>

  @for($i = 0; $i < count($locations) - 1; $i++)
    <li>
      {!! HTML::link($locations[$i]["link"], Lang::get('category.' . $locations[$i]["id"] . '.name')) !!}
    </li>
  @endfor

  <li class="active">
    {{ Lang::get('category.' . $locations[count($locations) - 1]["id"] . '.name') }}
  </li>
</ol>

@show