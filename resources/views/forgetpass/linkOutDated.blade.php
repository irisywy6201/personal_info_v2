@extends("layout")
@section("content")

<div class="jumbotron">
  <h3>
    {{ Lang::get('forgetpass.forgetBackupMail.linkOutOfDate') }}
    <br><br>
    {!! HTML::link('forgetpass', Lang::get('forgetpass.forgetBackupMail.updatePasswordAgain')) !!}
  </h3>
  
  <br><br>
  
  {!! HTML::link('/', Lang::get('forgetpass.forgetBackupMail.backToIndex')) !!}
</div>

@stop