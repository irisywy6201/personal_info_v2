@extends("faq.faqLayout")
@section("faq.content")

@include("faq.locationBar")

@if($nextLevelFAQs)
  <ul class="nav nav-tabs" >
    @foreach($nextLevelFAQs as $key => $value)
      <li class="@if($key == 0) active @endif">
        <a href="#{{$value['id']}}" data-toggle="tab">
          @if($categoryName = Lang::get('category.' . $value['id'] . '.name'))
            {{ $categoryName }}
          @else
            {{ Lang::get('category.0.name') }}
          @endif
        </a>
      </li>
    @endforeach
  </ul>
  <div class="tab-content">
    <br>
    @foreach($nextLevelFAQs as $key => $value)
      <div class="tab-pane fade @if($key == 0) active in @endif" id="{{ $value['id'] }}">
        @if($categoryDescription = Lang::get('category.' . $value['id'] . '.description'))
          <p>{{ $categoryDescription }}</p>
        @else
          {{ Lang::get('category.0.description') }}
        @endif
        <br>
        @if(count($value['hotLists']) > 0)
          <table class="table table-striped table-hover table-responsive">
            <tbody>
              @foreach($value["hotLists"] as $key => $list)
                <tr>
                  <td>
                    <a href="{{ $list['link'] }}">
                      {{ Lang::get('faqDB.' . $list['id'] . '.name') }}
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="text-center">
            <a class="btn btn-lg btn-primary" href="{{ $value['link'] }}">
              <span class="glyphicon glyphicon-arrow-right"></span>
              {{ Lang::get('faq.goTo', ['name' => Lang::get('category.' . $value['id'] . '.name')]) }}
            </a>
          </div>
        @else
          <h3 class="text-center text-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span>
            {{ Lang::get('faq.noFAQ') }}
          </h3>
        @endif
      </div>
    @endforeach
  </div>
@else
  <h1 class="text-center text-warning">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    {{ Lang::get('faq.noFAQ') }}
  </h1>
@endif

@stop
