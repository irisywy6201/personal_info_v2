@extends("emails.layout")
@section("content")
<p>
	點擊以下連結可以查看遺失物的清單
</p>
{!! URL::forceRootUrl(Config::get('app.url')) !!}
<br>
{!! URL::to('laf/forwardingMilitary') !!}
@stop
