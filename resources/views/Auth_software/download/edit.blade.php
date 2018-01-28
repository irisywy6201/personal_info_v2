@extends("layout")
@section("content")
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div style="background-color:#f2f2f2">
	<div class="row text-center form-inline">
		<h3> 修改</h3>
		<br>
	</div>
	
	<form class="form-horizontal" method="POST" action="{{ url('admin/auth_soft/Software/'.$software_list->id) }}">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體名稱(中文)&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="1" id="comment" name="name_zh">{{ $software_list->name_zh }}</textarea><br /> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體名稱(英文)&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="1" id="comment" name="name_en">{{ $software_list->name_en }}</textarea><br /> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">新增的學年度&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea rows="1" class="form-control"  id="focusedInput" type="text" name="year" >{{ $software_list->year }}</textarea>
			</div>
		</div><br>
	
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體介紹(中文)&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="3" id="comment" name="summary_zh">{{ $software_list->summary_zh }}</textarea><br /> 
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體介紹(英文)&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="3" id="comment" name="summary_en">{{ $software_list->summary_en }}</textarea><br /> 
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體介紹(英文)&nbsp;:&nbsp;</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="3" id="comment" name="summary_en">{{ $software_list->summary_en }}</textarea><br /> 
			</div>
		</div>

	<div class="form-group">
	  <label class="col-sm-2 control-label">kms連結&nbsp;:&nbsp;</label>
			<div class="dropdown col-sm-8" style="display:inline;">
				<button  class="btn dropdown-toggle active @if($readme->isEmpty()) btn-danger @else btn-primary @endif" type="button" data-toggle="dropdown" >@if($software_list->kms_link==0)(尚未新增) @elseif($readme->isEmpty()) 您尚未新增kms認證說明 @else @foreach( $readme as $kmslink )   @if($software_list->kms_link==$kmslink->id){{$kmslink->title_zh}}@endif @endforeach  @endif
				<span class="caret"></span></button>
				<input type="hidden"  id="kms_link" name="kms_link" value=" {{ $software_list->kms_link }} " />
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
    </div>
	
	<br>
	
		<div class="form-group">
			<label class="col-sm-2 control-label">位元/語言&nbsp;:&nbsp;</label>
			
			<div id="TextValueDiv" class="col-sm-2">
				<input  type="hidden"  name="{{$i=1}}" />
				<div id="dropdown" class="col-sm-8">
				@foreach($software_version as $version)	
					<div class="btn-group" style="margin-bottom:21px;" id="select{{$i}}">
					<input type="hidden" id="select_menu{{$i}}" name="platform{{$i}}"  value="{{$version->platform_id}}"/>
					<input type="hidden" name="{{$p=1}}" />
						<button  class="btn btn-primary dropdown-toggle active " type="button" data-toggle="dropdown" >@foreach( Lang::get('Auth_soft/platformList') as $platform_name ) @if($version->platform_id==$platform_name['id']) {{$platform_name['title']}} @endif @endforeach
						<span class="caret"></span></button>
						<ul class="dropdown-menu">
							@foreach( Lang::get('Auth_soft/platformList') as $platform_name )
								<li onclick="choose_platform( '{{$p}}' ,'1')" value="{{$p}}" name="{{$p=$p+1}}"><a>{{$platform_name['title']}}</a></li>
							@endforeach
						</ul><br />
					</div><br />
					<input type="hidden" name="{{$i=$i+1}}"  />
				@endforeach
				</div> 				
			</div>

			<label class="col-sm-2 control-label">下載連結&nbsp;:&nbsp;</label>
			<div id="TextValueDiv3" class="col-sm-4"> 
				<input  type="hidden"  name="{{$j=1}}" />
				@foreach($software_version as $versions)
					<textarea class="form-control" rows="1" id="connect{{$j}}" name="connect{{$j}}">{{ $versions->download_link }}</textarea><br />   
					<input type="hidden" name="{{$j=$j+1}}"  />
				@endforeach
			</div>
			<div id="destroybox" class="col-sm-1" style="text-align:left; margin-left:-25px;" >
				<input  type="hidden"  name="{{$z=1}}" />
				@foreach($software_version as $versions)
					<span id="destroy{{$z}}" ><button id="destroybox{{$z}}" onclick="destroybox('{{$z}}')" type="button" class="btn btn-danger " >-</button><br></span><br />
					<input type="hidden" name="{{$z=$z+1}}"  />
				@endforeach
			</div>
		</div>
		<input type="hidden" value="{{$j-1}}" id="count_version" name="count_version"/>
		<input type="hidden" id="Count"  value="{{$i}}" />
		<input type="hidden" value="{{$j-1}}" name="num_v" />

		<div class="form-group">
			<div class="col-sm-2" style="text-align:right;" >
				<button id ="Button2" type="button" class="btn btn-primary " style="padding:10px;" >&nbsp;+&nbsp;</button>
			</div>
		</div><br><br><br><br>
	
		<div class="form-group">
			<label class="col-sm-2 control-label">系統需求(中文)&nbsp;:&nbsp;</label>
			<div id="TextValueDiv2" class="col-sm-3"> 
				<input  type="hidden"  name="{{$k=1}}" />
				@foreach($software_requirement as $requirement)
					<textarea class="form-control" rows="2" id="need{{$k}}" name="need{{$k}}" />{{$requirement->requirement_zh}}</textarea><br /> 
					<input type="hidden" name="{{$k=$k+1}}"  />	
				@endforeach
			</div>
			<label class="col-sm-2 control-label">系統需求(英文)&nbsp;:&nbsp;</label>
			<div id="TextValueDiv5" class="col-sm-3"> 
				<input  type="hidden"  name="{{$m=1}}" />
				@foreach($software_requirement as $requirement)
					<textarea class="form-control" rows="2" id="need_en{{$m}}" name="need_en{{$m}}">{{ $requirement->requirement_en }}</textarea><br /> 
					<input type="hidden" name="{{$m=$m+1}}"  />	
				@endforeach
			</div>
			<input  type="hidden"  name="{{$t=1}}" />
			
			<div id="destroyboxx" class="col-sm-2" style="text-align:left;margin-left:-25px;" >
				@foreach($software_requirement as $requirement)
					<span id="destroyy{{$t}}" ><button id="destroyboxx{{$t}}" onclick="destroyboxx('{{$t}}')" type="button" class="btn btn-danger">-</button><br></span><br />
					<input type="hidden" name="{{$t=$t+1}}"  />	<br>
				@endforeach
			</div>
			<input type="hidden" value="{{$t}}" id="count_describe" name="count_describe" />	
			<input type="hidden" value="{{$t=$t-1}}" name="num_d" />
		</div>

		<div class="form-group">
			<div class="col-sm-2" style="text-align:right;">
				<button id ="Button3" type="button" class="btn btn-primary " style="padding:10px;">&nbsp;+&nbsp;</button>
			</div>
		</div>
		
		<div class="col-sm-11" style="text-align:right;">
			<button type="submit" class="btn btn-primary btn-lg active">送出</button>
		</div>
		
	</form>
	<br><br> <br><br>
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
			var a = document.getElementById("Count4");
			var vobject = document.getElementById("count_version");
			
            var c = cobject.value;
			var box = "  <div class='btn-group' id='select" + c + "' style='margin-bottom:18px'><button class='btn btn-primary dropdown-toggle active' type='button' data-toggle='dropdown' >請選擇<span class='caret'></span></button><input type='hidden' id='select_menu" + c + "' name='platform" + c + "' /><input type='hidden' name='{{$p=1}}' /><ul class='dropdown-menu'>@foreach( Lang::get('Auth_soft/platformList') as $platform_name )<li onclick='choose_platform( {{$p}},"+c+" )' value='{{$p}}' name='{{$p=$p+1}}'><a>{{$platform_name['title']}}</a></li>@endforeach</ul><br></div><br>";
            $("#dropdown> div:last").each(function () {
                $(this).next().after($(box));
            });

            var box2 = "<textarea class='form-control' rows='1' id ='connect" + c + "' name='connect" + c + "'  placeholder='連結" + c + "'></textarea><br/>";
            $("#TextValueDiv3> textarea:last").each(function () {
                $(this).next().after($(box2));
            });
			
			var destroybox = "<span id='destroy" + c + "'><button id='destroybox" + c + "' onclick='destroybox(" + c + ")' type='button' class='btn btn-danger'>-</button><br></span><br />";
			$("#destroybox> span:last").each(function(){
				$(this).next().after($(destroybox));
			});
            var count = Number(c) + 1;
            cobject.value = count;
			vobject.value = count-1;

			
        }
		function destroybox(destroy_num){
  			var cobject = document.getElementById("Count");
  			var lobject = document.getElementById("Count3");
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
				$("#"+connect).remove();
				$("#"+destroy).remove();
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
		function add(){
			var a = document.getElementById("Count4");
			a.value=a.value+1;
		}
		
		$(function () {
		$("#Button3").click( addTextbox2);
		});

		function addTextbox2() {
		
			var cobject = document.getElementById("count_describe");
			var c = cobject.value;
			var box = "<textarea rows='2' type='text' class='form-control' id ='need" + c + "' name='need" + c + "' value='' placeholder='中文需求" + c + "'/></textarea><br/>";
			$("#TextValueDiv2> textarea:last").each(function () {
				$(this).next().after($(box));
			});
			var box2 = "<textarea rows='2' type='text' class='form-control' id ='need_en" + c + "' name='need_en" + c + "' value='' placeholder='英文需求" + c + "'/></textarea><br/>";
			$("#TextValueDiv5> textarea:last").each(function () {
				$(this).next().after($(box2));
			});
			var destroyboxx = "<br><span id='destroyy" + c + "'><button id='destroyboxx" + c + "' onclick='destroyboxx(" + c + ")' type='button' class='btn btn-danger'>-</button><br></span><br /><br>";
			$("#destroyboxx> span:last").each(function(){
				$(this).next().after($(destroyboxx));
			});
			
			var count = Number(c) + 1;
			cobject.value = count;
			
		}
		
		
		function destroyboxx(destroy_num){
 
  			var vobject = document.getElementById("count_describe");
			var c = vobject.value;
			
			if(Number(c)<=2){
				alert("請輸入完整系統需求資訊！");
			}else{
				var count = Number(c)-1;
					
			vobject.value = count;
					
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
				
					for(var i=Number(destroy_num)+1;i<Number(c);i++){
						var k=i-1;
						
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
		function choose2(num){
			document.getElementById('kms_link').value=num;
		}
		function choose_platform(num,id){
			document.getElementById('select_menu'+id).value=num;
			
		}
        
</script>
@stop
