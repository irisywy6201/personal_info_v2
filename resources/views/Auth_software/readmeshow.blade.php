@extends("layout")
@section("content")
@include("Auth_software.locationBar")
<style>
.content{
	padding-left:25%;
	padding-top:10px;
}
#menu{
	display:block;
	border: 2px solid #cce6ff;
	background-color:#cce6ff;
	text-aligin:center;
	margin-top:5px;
	padding-right:2%;
	float:left;
	border-radius: 25px;
}
ul{
	list-style-type: none;
}
ol{
	color:#0066cc;
	display:block;
	list-style-type:decimal;
	padding-left:-15%;
}
dt{
	padding-left:15%;
}
dd{
	padding-left:15%;
}
</style>
<ul class="nav nav-tabs ">
  @foreach(Lang::get('Auth_soft/auth_index') as $test)
    <li class="@if($test['index']==0) active  @endif" >
      <a href="#{{$test['index']}}" data-toggle="tab" class="tabs ">
        {{$test['title']}}
      </a>
    </li>
  @endforeach
</ul>

<div id="menu">
<table class="articlelist" >
		<tbody>
		<br>
        <dl>
	@foreach($readmecatagory as $catagory)	
			<dt><a class="link" href="#" rel="doctitle{{$catagory->id}}">{{ $catagory->doccategory_name_zh }}</a></dt>
		@foreach($readme as $key => $value)	
		@if($value->doccatagory_id==$catagory->id)
			<dd id="doctitle{{$value->doccatagory_id}}" class="doctitle" style="display:none"><a href="auth_soft/readme/{{$value->id}}" rel="officeDoc{{ $value->id }}" class="doctitle"><ul>{{ $value->title_zh }}</ul></a></dd>
			@endif
		@endforeach
	@endforeach
		</dl>
		</tbody>
</table>
</div>	
	<div class="content" style="">
	<center><h3 style="font-weight:bold;">以下為說明文件分類</h3></center>
	<br>
	  <ol>
@foreach($readmecatagory as $value)		  
		<li><a class="link" href="#" rel="doctitle{{$value->id}}"><h4>{{ $value->doccategory_name_zh }}</h4></a>
		<span><p style="color:#5c8a8a">{{ $value->doccategory_discribe_zh }}</p></span>
		<br>
@endforeach		
		</li>
	  </ol>
	  <br>
	</div>

	@foreach($readme as $value)	
    <div class="content" id="officeDoc{{ $value->id }}" style="display:none">
        <p>{!! $value->Content_zh !!}</p>
    </div>
	@endforeach
<script>
$(".link").on('click', function(){
   var article = $(this).attr('rel');
   $("#"+article).show().siblings(".doctitle").hide();
});
$(".doctitle").on('click', function(){
   var doccontent = $(this).attr('rel');
   $("#"+doccontent).show().siblings(".content").hide();
   console.log(321);
});
</script>

@stop