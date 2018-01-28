<ul class = "sidebar-nav">
	<li class = "sidebar-brand">
		{!! HTML::link(URL::to('laf'),Lang::get('LostandFound/page.sidechoose')) !!}
	</li>
	<li class = "sidebar-brand">
		<a>{{ Lang::get('LostandFound/page.status') }}</a>
	</li>
	<li role="presentation">
		@if($stat == 0)
				{!! HTML::link(URL::to('laf/thingsdetail/'.$option.'/0'),Lang::get('LostandFound/page.lost'),array('class'=>'active')) !!}
		@else
				{!! HTML::link(URL::to('laf/thingsdetail/'.$option.'/0'),Lang::get('LostandFound/page.lost')) !!}
		@endif
	</li>
	<li role="presentation">
		@if($stat == 1)
				{!! HTML::link(URL::to('laf/thingsdetail/'.$option.'/1'),Lang::get('LostandFound/page.found'),array('class'=>'active')) !!}
	  @else
				{!! HTML::link(URL::to('laf/thingsdetail/'.$option.'/1'),Lang::get('LostandFound/page.found')) !!}
	  @endif
	</li>
	<br>
</ul>
{!! HTML::style('css/laf/sidestyle.css') !!}
