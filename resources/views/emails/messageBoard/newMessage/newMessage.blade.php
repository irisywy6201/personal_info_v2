@extends("emails.layout")
@section("content")
<p>
	{{ Lang::get("email.newMessage.content") }}
	<br>
	{!! HTML::link($link, $link) !!}
</p>
@stop