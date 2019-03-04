@extends("emails.layout")
@section("content")

{{ Lang::get('forgetpass/newPassValidation.dear') }} {{ $portal_id }} ：<br>
{{ Lang::get('forgetpass/newPassValidation.isvalidationMail') }}<br>
{{ Lang::get('forgetpass/newPassValidation.clickLinkBelow') }}
<br><br>
{!! HTML::link($link, $link) !!}
<br><br>

@stop