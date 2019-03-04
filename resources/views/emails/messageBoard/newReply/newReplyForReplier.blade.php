@extends("emails.layout")
@section("content")
<p>
	{{ Lang::get("email.newReply.replier.content.0") }}
	<br>
	{{ Lang::get("email.newReply.replier.content.1") }}
</p>
<div>
	{!! $content !!}
</div>
<p>
	{{ Lang::get("email.newReply.replier.content.2") }}
	{!! HTML::link($link["linkToMessagePage"], $link["linkToMessagePage"]) !!}
</p>
@stop