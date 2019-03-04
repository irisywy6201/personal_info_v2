@extends("emails.layout")
@section("content")
<p>我是更改密碼的驗證信件！！</p>
{!! HTML::link($link, $link) !!}
@stop

{{--
<p>
	{{ Lang::get("email.newReply.messageLeaver.content.0") }}
	<br>
	{{ Lang::get("email.newReply.messageLeaver.content.1") }}
</p>
<div>
	{{ $replyContent }}
</div>
<p>
	{{ Lang::get("email.newReply.messageLeaver.content.2") }}
	<br>
	{{ HTML::link($link["linkToSolvePage"], $link["linkToSolvePage"]) }}
</p>
<p>
	{{ Lang::get("email.newReply.messageLeaver.content.3") }}
	<br>
	{{ HTML::link($link["linkToMessagePage"], $link["linkToMessagePage"]) }}
</p>

--}}

