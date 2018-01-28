@extends("faq.faqLayout")
@section("faq.content")

@include("faq.locationBar")

@if(count($faqs[0]['faqs']) > 0)
  <table class="table table-striped table-hover table-responsive">
    <tbody>
      @foreach($faqs as $key => $faq)
        @if($faq['category'])
          <tr class="info">
            <th>
              <a href="{{ '#' . $faq['category'][count($faq['category']) - 1]  }}">
                @for($i = 0; $i < count($faq['category']); $i++)
                  {{ Lang::get('category.' . $faq['category'][$i] . '.name') }}

                  @if($i < count($faq['category']) - 1)
                    {{ " / " }}
                  @endif
                @endfor
              </a>
            </th>
          </tr>
        @endif

        @foreach($faq['faqs'] as $key => $value)
          <tr>
            <td>
              {!! HTML::link("#" . $value, Lang::get("faqDB." . $value . ".name")) !!}
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

  <div class="text-break-sm">
    @foreach($faqs as $key => $faq)
      @if($faq['category'])
        <a class="h3" name="{{ $faq['category'][count($faq['category']) - 1]  }}"></a>
        <br>
        <br>
        <br>
        <h3 class="text-muted">
          <span class="glyphicon glyphicon-bookmark">&nbsp;</span>
          @for($i = 0; $i < count($faq['category']); $i++)
            {{ Lang::get('category.' . $faq['category'][$i] . '.name') }}

            @if($i < count($faq['category']) - 1)
              {{ " / " }}
            @endif
          @endfor
        </h3>
      @endif
      
      @foreach ($faq['faqs'] as $key => $faqID)
        <a name="{{ $faqID }}">&nbsp;</a>
        <br>
        <br>
        @if(Auth::check() && Auth::user()->isStaff())
          <a class="btn btn-danger" href="{{ URL::to('/admin/faq/' . $faqID . '/edit') }}">
            <span class="glyphicon glyphicon-pencil"></span>
            {{ Lang::get('faq.edit') }}
          </a>
          &nbsp;
          &nbsp;
        @endif
        <h3>
          <b>
            {{ Lang::get("faqDB." . $faqID . ".name") }}
          </b>
        </h3>
        <br>
        <p>
          {!! Lang::get("faqDB." . $faqID . ".answer") !!}
        </p>
      @endforeach        
    @endforeach
  </div>
@else
  <br>
  <br>
  <h1 class="text-center text-warning">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    {{ Lang::get('faq.noFAQ') }}
  </h1>
@endif

@include('globalPageTools.scrollTop')

@stop