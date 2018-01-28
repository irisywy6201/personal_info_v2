@extends("layout")
@section("content")

<div class="jumbotron">
  <h3>
    <span>
      {{ Lang::get('forgetpass/newPassSet.inUpdateList') }}
      <br><br>
      {{ Lang::get('forgetpass/newPassSet.wait10Min') }}
      <br><br>
      @if (Auth::guest())
        {{ Lang::get('forgetpass/newPassSet.notice') }}
        <br><br>
        {{ Lang::get('forgetpass/newPassSet.canDoIfLogin') }}
      @endif
    </span>
  </h3>
  <br><br>
  {!! HTML::link('/', Lang::get('forgetpass/newPassSet.backToHome')) !!}
</div>

@stop