<style>
.content{
	padding-left:23%;
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

<div id="menu">
<table class="articlelist" >
		<tbody>
		<br>
        <dl>
	@foreach($readmecatagory as $catagory)	
			<dt><a class="link" href="#" rel="doctitle{{$catagory->id}}" style="text-decoration:none;font-size:16px" data-toggle="collapse" data-target="#down{{$catagory->id}}">{{ $catagory->doccategory_name_zh }} <span class="glyphicon glyphicon-chevron-down"></span></a></dt>
		<div id="down{{$catagory->id}}" class="collapse">
		@foreach($readme as $readmes)  
		   @if($readmes->doccatagory_id==$catagory->id)
				<dd><a href="#" rel="officeDoc{{ $readmes->id }}" class="doctitle" style="text-decoration:none;font-size:15px">&nbsp&nbsp&nbsp&nbsp{{ $readmes->title_zh }}</a></dd>
		   @endif
		@endforeach
		</div>
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
		<li><a class="link" href="#" rel="doctitle{{$value->id}}" data-toggle="collapse" data-target="#down{{$value->id}}"><h4>{{ $value->doccategory_name_zh }}</h4></a>
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

$(".doctitle").on('click', function(){
   var doccontent = $(this).attr('rel');
   $("#"+doccontent).show().siblings(".content").hide();
   console.log(321);
});
</script>

