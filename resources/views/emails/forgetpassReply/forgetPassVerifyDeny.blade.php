@extends("emails.layout")
@section("content")
{{ Lang::get('forgetpass/newPassValidation.dear') }} {{ $portal_id }}：<br>

{{ Lang::get('forgetpass/newPassValidation.validateFail.infoNotPass') }}<br>
{{ Lang::get('forgetpass/newPassValidation.validateFail.reasonis') }}：
<br><br>
{{ $reason }}
<br><br>
{{ Lang::get('forgetpass/newPassValidation.validateFail.checkAgain') }}<br>
@stop