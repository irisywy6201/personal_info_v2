@extends("layout")
@section("content")

<div class="jumbotron">

	<h3>
		<span>
			{{ Lang::get('forgetpass/waitCCReply.finishType') }}<br><br>
			{{ Lang::get('forgetpass/waitCCReply.waitCC') }}<br><br>
			{{ Lang::get('forgetpass/waitCCReply.needSomeDay') }}<br><br>
			{{ Lang::get('forgetpass/waitCCReply.waitSomeDay') }}
		</span>
	</h3>

	<br><br>

	{!! HTML::link('/', Lang::get('forgetpass/waitCCReply.backToHome'), [
			'style'	=> 'font-size: 20px; text-decoration: underline;'
		])
	!!}
</div>
@stop