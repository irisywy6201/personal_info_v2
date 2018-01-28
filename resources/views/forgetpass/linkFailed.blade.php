@extends("layout")
@section("content")

<div class="jumbotron">
  <h3>
    {{ Lang::get('forgetpass/forgetBackupMail.linkExpired') }}
    <br><br>
    {!! HTML::link('forgetpass', Lang::get('forgetpass/forgetBackupMail.resetPasswordAgain')) !!}
  </h3>

  <br><br>
  
  {!! HTML::link('/', Lang::get('forgetpass/forgetBackupMail.backToIndex')) !!}
</div>

@stop