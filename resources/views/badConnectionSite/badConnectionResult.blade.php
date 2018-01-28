@extends("layout")
@section("content")

<div class="jumbotron">

	<h3>
		<span>
			感謝您的回報，讓我們一起努力讓網路更加順暢
		</span>
	</h3>
	<br><br>

	{{ HTML::link(
		'/', 
		Lang::get('forgetpass/newPassSet.backToHome'), 
		array(
			'style'	=> 'font-size: 20px; text-decoration: underline;',
			)
		)
	}}
</div>

@stop