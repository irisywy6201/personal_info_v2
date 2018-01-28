@if(count($results) > 0)
  @foreach ($results as $key => $faq)
    <h2>
    	{!! HTML::link($faq['link'], Lang::get('faqDB.' . $faq['id'] . '.name')) !!}
    </h2>
    <p>
      {!! Lang::get('faqDB.' . $faq['id'] . '.answer') !!}
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