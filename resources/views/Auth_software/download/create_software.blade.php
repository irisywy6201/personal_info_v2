@extends("layout")
@section("content")

<div style="background-color:#f2f2f2">
<div class="row text-center form-inline">
	<h3>新增</h3>
	<br>
</div>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
	<form class="form-horizontal" method="POST" action="{{url('admin/auth_soft/Software')}}">
	    {{ csrf_field() }}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<label class="col-sm-2 control-label">
			<div class="dropdown" style="display:inline;">
				<button  class="btn btn-primary dropdown-toggle active" type="button" data-toggle="dropdown" >軟體種類
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
				@foreach( $software_category as $category )
					<li onclick="choose1('{{$category->id}}','1')"><a>{{$category->category_name_zh}}</a></li>
				@endforeach
				</ul>  
			</div> 
		</label>
	</div>	
	<input type="hidden"  id="category" name="category" value="" />

    <div class="form-group">
      <label class="col-sm-2 control-label">軟體名稱(中文)&nbsp;:&nbsp;</label>
      <div class="col-sm-8">
        <textarea class="form-control" rows="1" type="text" name="name_zh" ></textarea>
      </div>
	  
    </div><br>
	
	<div class="form-group">
    
	  <label class="col-sm-2 control-label">軟體名稱(英文)&nbsp;:&nbsp;</label>
      <div class="col-sm-8">
        <textarea rows="1" class="form-control" id="focusedInput" type="text" name="name_en" ></textarea>
      </div>
    </div><br>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">新增的學年&nbsp;:&nbsp;</label>
      <div class="col-sm-8">
        <textarea rows="1" class="form-control"  id="focusedInput" type="text" name="year" placeholder="ex:105、106、107.."></textarea>
      </div>
    </div><br>
	
	
	<div class="form-group">
      <label class="col-sm-2 control-label">軟體介紹(中文)&nbsp;:&nbsp;</label>
      <div class="col-sm-8">
		<textarea class="form-control" rows="3" id="comment" name="summary_zh"></textarea>
      </div>
	  
    </div><br>
	
	<div class="form-group">
      <label class="col-sm-2 control-label">軟體介紹(英文)&nbsp;:&nbsp;</label>
      <div class="col-sm-8">
				<textarea class="form-control" rows="3" id="comment" name="summary_en"></textarea>
      </div>
    </div>
		<br>
	<div class="form-group">
	  <label class="col-sm-2 control-label">kms連結&nbsp;:&nbsp;</label>
			<div class="dropdown" style="display:inline;">
				<button  class="btn dropdown-toggle active btn-primary " type="button" data-toggle="dropdown" >選擇說明文件連結
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					@if($readme->isEmpty())
						<li onclick="choose2('0')"><a>(尚未新增說明)</a></li>
					@else
						@foreach( $readme as $kmslink )
							<li onclick="choose2('{{$kmslink->id}}')"><a>{{$kmslink->title_zh}}</a></li>
						@endforeach
					@endif
					
					
				</ul>  
			</div>
    </div><br>

	
	<div class="form-group">
		<label class="col-sm-2 control-label">位元/語言&nbsp;:&nbsp;</label>
		<div class="col-sm-2 " id="dropdown" >
			<div class="btn-group" id="select1" style="margin-bottom:19px;margin-top:7px">
				<button  class="btn btn-primary dropdown-toggle active " type="button" data-toggle="dropdown" >請選擇
					<span class="caret"></span></button>
				<input type="hidden" id="select_menu1" name="platform1" />
				<input type="hidden" name="{{$p=1}}" />
				<ul class="dropdown-menu">
					@foreach( Lang::get('Auth_soft/platformList') as $platform_name )
						<li onclick="choose_platform( '{{$p}}' ,'1')" value="{{$p}}" name="{{$p=$p+1}}"><a>{{$platform_name['title']}}</a></li>
					@endforeach
				 </ul><br>
			</div><br /><br />
		</div> 
		
		<input id="TextValueDiv6" type="hidden" name="dropdown1" value="">
		<label class="col-sm-2 control-label">下載連結&nbsp;:&nbsp;</label>
		<div id="TextValueDiv3" class="col-sm-4"> 
			<textarea class="form-control" rows="1" type="text" id="connect1" name="connect1" /></textarea><br />   
		</div>
		
		<div id="destroybox" class="col-sm-1" style="text-align:left; margin-left:-25px;" >
			<span id="destroy1" ><button id="destroybox1" onclick="destroybox('1')" type="button" class="btn btn-danger " >-</button><br></span><br />
		</div>
    </div>
	
	<div id="ConentDiv">
		<input type="hidden" id="Count"  value="2" />
		
    </div>
	
	<div class="form-group">
		<div class="col-sm-2" style="text-align:right;">
			<button id ="Button2" type="button" class="btn btn-primary" style="padding:10px;">&nbsp;+&nbsp;</button>
		</div>
	</div><br><br><br><br>
	
	<div class="form-group ">
		<label class="col-sm-2 control-label">系統需求(中文)&nbsp;:&nbsp;</label>
		<div id="TextValueDiv2" class="col-sm-3"> 
			<textarea rows="2" class="form-control" type="text" id="need1" name="need1" /></textarea><br />   
		
		</div>
		<label class="col-sm-2 control-label">系統需求(英文)&nbsp;:&nbsp;</label>
		<div id="TextValueDiv5" class="col-sm-3"> 
			<textarea rows="2" class="form-control" type="text" id="need_en1" name="need_en1" /></textarea><br />   
		</div> 
		
		<div id="destroyboxx" class="col-sm-1" style="text-align:left;margin-left:-25px;" >
			<span id="destroyy1" ><button id="destroyboxx1" onclick="destroyboxx('1')" type="button" class="btn btn-danger">-</button><br></span><br />
		</div>
		
    </div>
	
	<div id="ConentDiv2">
		<input type="hidden" id="Count2" value="2" />
		<input type="hidden" id="Count5" value="2" />
    </div>

	<div class="form-group">
		<div class="col-sm-2" style="text-align:right;">	
			<button id ="Button3" type="button" class="btn btn-primary" style="padding:10px;">&nbsp;+&nbsp;</button>
		</div>
	</div><br><br>
	
	 <input type="hidden" id="count_version" name="count_version" value="1" />
	<input type="hidden" id="count_describe" name="count_describe" value="1" />
	<input type="hidden"  id="kms_link" name="kms_link" value="" />
	<div class="form-group">
	<div class="col-sm-11" style="text-align:right;">
	<button type="submit" class="btn btn-primary btn-lg active">送出</button>
	</div>
	</div>
	</form>
	<br><br>
	
	
    
</div>

 <script>
		$(document).on("click", '.dropdown-menu li a', function(e) {
		var selText = $(this).text();
		$(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
		});
		
		$(function () {
		$("#Button2").click( addTextbox);
		});
        function addTextbox() {
            var cobject = document.getElementById("Count");
			var vobject = document.getElementById("count_version");
            var c = cobject.value;
			var box = "  <div class='btn-group' id='select" + c + "' style='margin-bottom:18px'><button class='btn btn-primary dropdown-toggle active' type='button' data-toggle='dropdown' >請選擇<span class='caret'></span></button><input type='hidden' id='select_menu" + c + "' name='platform" + c + "' /><input type='hidden' name='{{$p=1}}' /><ul class='dropdown-menu'>@foreach( Lang::get('Auth_soft/platformList') as $platform_name )<li onclick='choose_platform( {{$p}},"+c+" )' value='{{$p}}' name='{{$p=$p+1}}'><a>{{$platform_name['title']}}</a></li>@endforeach</ul><br></div><br>";
			$("#dropdown> div:last").each(function () {
                $(this).next().after($(box));
            });
			
			var destroybox = "<span id='destroy" + c + "'><button id='destroybox" + c + "' onclick='destroybox(" + c + ")' type='button' class='btn btn-danger'>-</button><br></span><br />";
			$("#destroybox> span:last").each(function(){
				$(this).next().after($(destroybox));
			});
			 
			var dropdown_hide = "<input type='hidden'  name='dropdown" + c + "' value=''/><br/>";
            $("#TextValueDiv6> input:text:last").each(function () {
                $(this).next().after($(dropdown_hide));
            });
			
            var box2 = "<textarea type='text' class='form-control' rows='1' id ='connect" + c + "' name='connect" + c + "' value='' placeholder='連結" + c + "'/></textarea><br/>";
            $("#TextValueDiv3> textarea:last").each(function () {
                $(this).next().after($(box2));
            });
		
            var box3 = "<input type='text' class='form-control' id ='version_en" + c + "' name='version_en" + c + "' value='版本" + c + "'/><br/>";
            $("#TextValueDiv4> input:text:last").each(function () {
                $(this).next().after($(box3));
            });
            var count = Number(c) + 1;
            cobject.value = count;
			vobject.value = count-1;			
        }
		function destroybox(destroy_num){
  			var cobject = document.getElementById("Count");
            var vobject = document.getElementById("count_version");
          	var c = cobject.value;
			if(Number(c)<=2){
				alert("請輸入完整資訊！");
			}else{
				var count = Number(c)-1;
				cobject.value = count;
				vobject.value = count-1;
			
				var select='select'+destroy_num;
				var destroy ='destroy'+destroy_num;
				var connect ='connect'+destroy_num;
				
				$("#" + select + " + br").remove();
				$("#" + destroy + " + br").remove();
				$("#" + connect + " + br").remove();
				$("#"+select).remove();
				$("#"+destroy).remove();
				$("#"+connect).remove();
				
				if(Number(c)>destroy_num){
					for(var i=Number(destroy_num)+1;i<=Number(c);i++){
						var k=i-1
						
						document.getElementById('select_menu'+i).name='platform'+k;
						document.getElementById('select'+i).id='select'+k;
						document.getElementById('select_menu'+i).id='select_menu'+k;
						
						document.getElementById('connect'+i).placeholder='連結'+k;
						document.getElementById('connect'+i).name='connect'+k;
						document.getElementById('connect'+i).id='connect'+k;
						
						document.getElementById('destroy'+i).id='destroy'+k;
						
						var aaa=document.getElementById('destroybox'+i);
						aaa.setAttribute( "onClick", "destroybox("+k+");" );
						document.getElementById('destroybox'+i).id='destroybox'+k;					
					}			
				}				 
			}
			
  		}
		
		$(function () {
		$("#Button3").click( addTextbox2);
		});

		function addTextbox2() {
			var cobject = document.getElementById("Count2");
			var eobject = document.getElementById("Count5");
			var dobject = document.getElementById("count_describe");
			var c = cobject.value;
			var box = "<textarea rows='2' type='text' class='form-control' id ='need" + c + "' name='need" + c + "' value='' placeholder='中文需求" + c + "'/></textarea><br/>";
			$("#TextValueDiv2> textarea:last").each(function () {
				$(this).next().after($(box));
			});
			var box2 = "<textarea rows='2' type='text' class='form-control' id ='need_en" + c + "' name='need_en" + c + "' value='' placeholder='英文需求" + c + "'/></textarea><br/>";
			$("#TextValueDiv5> textarea:last").each(function () {
				$(this).next().after($(box2));
			});
			var destroyboxx = "<br><span id='destroyy" + c + "'><button id='destroyboxx" + c + "' onclick='destroyboxx(" + c + ")' type='button' class='btn btn-danger'>-</button><br></span><br />";
			$("#destroyboxx> span:last").each(function(){
				$(this).next().after($(destroyboxx));
			});
			
			var count = Number(c) + 1;
			cobject.value = count;
			eobject.value = count;
			dobject.value = count-1;
		}
		function destroyboxx(destroy_num){
  			var cobject = document.getElementById("Count2");
  			var lobject = document.getElementById("Count5");
  			var vobject = document.getElementById("count_describe");
			var c = cobject.value;
			if(Number(c)<=2){
				alert("請輸入完整資訊！");
			}else{
					var count = Number(c)-1;
					cobject.value = count;
					vobject.value = count-1;
					lobject.value = count;	
			
			var need='need'+destroy_num;
			var need_en ='need_en'+destroy_num;
			var destroyy ='destroyy'+destroy_num;
				
			$("#" + need + " + br").remove();
			$("#" + need_en + " + br").remove();
			$("#" + destroyy + " + br").remove();
			$("#"+need).remove();
			$("#"+need_en).remove();
			$("#"+destroyy).remove();
			
			if(Number(c)>destroy_num){
					for(var i=Number(destroy_num)+1;i<=Number(c);i++){
						var k=i-1
						
						document.getElementById('need'+i).name='need'+k;
						document.getElementById('need'+i).placeholder='中文需求'+k;
						document.getElementById('need'+i).id='need'+k;
						
						document.getElementById('need_en'+i).placeholder='英文需求'+k;
						document.getElementById('need_en'+i).name='need_en'+k;
						document.getElementById('need_en'+i).id='need_en'+k;
						
						document.getElementById('destroyy'+i).id='destroyy'+k;
						var aaa=document.getElementById('destroyboxx'+i);
						aaa.setAttribute( "onClick", "destroyboxx("+k+");" );
						document.getElementById('destroyboxx'+i).id='destroyboxx'+k;					
					}			
				}
			}
			
  		}
		function choose1(num){
			document.getElementById('category').value=num;
		}
		
		function choose2(num){
			document.getElementById('kms_link').value=num;
		}
		function choose_platform(num,id){
			document.getElementById('select_menu'+id).value=num;
			
		}
</script>

@stop
