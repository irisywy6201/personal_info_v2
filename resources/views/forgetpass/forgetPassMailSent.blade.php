@extends("layout")
@section("content")


<div class="jumbotron">

  <h3>
    <span>

      {{ Lang::get('forgetpass/forgetBackupMail.mainSent') }}
      <br><br>
      {{ Lang::get('forgetpass/forgetBackupMail.checkMailBox') }}
    </span>
  </h3>
  <br><br>
  {!! HTML::link('/', Lang::get('forgetpass/forgetBackupMail.backToIndex')) !!}
</div>

@stop