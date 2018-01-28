@extends("emails.layout")
@section("content")
<p>
	{{ Lang::get("email.notifyAdmin.content.0") . $days . Lang::get("email.notifyAdmin.content.1") }}
	<br>
	{!! HTML::link($link, $link) !!}
</p>
@stop