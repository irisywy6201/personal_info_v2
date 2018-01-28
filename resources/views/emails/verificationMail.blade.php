@extends("emails.layout")
@section("content")
<p>
	{{ Lang::get("email.verificationMail.content.0") }}
</p>
<p>
	{{ Lang::get("email.verificationMail.content.1") }}
	<br>
	{!! HTML::link($link, $link) !!}
	<br>
	{{ Lang::get("email.verificationMail.content.2") }}
</p>
@stop