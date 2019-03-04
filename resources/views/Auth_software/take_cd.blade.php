@if (Auth::check())

	@if (session('sended'))
		<script>
			$(document).ready(function(){

				/*調整location bar*/
				$('.page').each(function(){
     			 if("a9"==$(this).attr("id") || "a2"==$(this).attr("id") || "9"==$(this).attr("id")){
       			 $(this).show();
     			 }
     			 else{
       			 $(this).hide();
     			 }
		    });
				/* 顯示頁面 */
				$('#9').addClass("active");
				$('#9').removeClass("fade");
				/* 調整location bar */
				$('#e0').removeClass("active");
				$('#e2').addClass("active");
			  $('#0').removeClass("active");//隱藏公告，因為預設公告會出現。	

				$(':checkbox').checkboxpicker();
			})	
		</script>
	@endif
	
	<style type="text/css">
		.checkbox label:after, 
		.radio label:after {
  		 content: '';
   		 display: table;
   		 clear: both;
		}

		.checkbox .cr,
		.radio .cr {
 		   position: relative;
  		 display: inline-block;
 		   border: 1px solid #a9a9a9;
 		   border-radius: .25em;
  		 width: 1.3em;
   		 height: 1.3em;
   		 float: left;
   		 margin-right: .5em;
		}

		.radio .cr {
 		   border-radius: 50%;
		}

		.checkbox .cr .cr-icon,
		.radio .cr .cr-icon {
  		 position: absolute;
   		 font-size: .8em;
   		 line-height: 0;
   		 top: 50%;
   		 left: 20%;
		}

		.radio .cr .cr-icon {
  		  margin-left: 0.04em;
		}

		.checkbox label input[type="checkbox"],
		.radio label input[type="radio"] {
  		  display: none;
		}

		.checkbox label input[type="checkbox"] + .cr > .cr-icon,
		.radio label input[type="radio"] + .cr > .cr-icon {
 		   transform: scale(3) rotateZ(-20deg);
  		 opacity: 0;
   		 transition: all .3s ease-in;
		}

		.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
		.radio label input[type="radio"]:checked + .cr > .cr-icon {
 		   transform: scale(1) rotateZ(0deg);
  		 opacity: 1;
		}

		.checkbox label input[type="checkbox"]:disabled + .cr,
		.radio label input[type="radio"]:disabled + .cr {
 		   opacity: .5;
		}
	</style>

	</br>
	<span>{{Lang::get('Auth_soft/take_cd.1')}}</span>
	</br>
	</br>
	<p>{{Lang::get('Auth_soft/take_cd.2')}}</p>
	<ol>
		<li>{{Lang::get('Auth_soft/take_cd.3')}}</li>
		<li>{{Lang::get('Auth_soft/take_cd.4')}}</li> 
	</ol>
	</br>
	
	@if(isset($haveTakenNumber) && $haveTakenNumber!=0)
  <table class="table table-hover">
		<thead>
			<th style="width:20%">{{Lang::get('Auth_soft/take_cd.5')}}</th>
			<th style="width:20%">{{Lang::get('Auth_soft/take_cd.6')}}</th>
      <th>{{Lang::get('Auth_soft/take_cd.7')}}</th>
		</thead>
		<tbody>
			 @foreach ($options as $software_list_id=>$o)
				
				@if (isset($haveTakenSoftId[$software_list_id]))
				 <tr>
					<th style="width:20%">
							<span>{{$haveTakenTime[$software_list_id]}}</span>
					</th>
					<th style="width:20%">
							<span>
								{{current(array_values($o))['platform']}}	
							</span>
						</th>
						<th>
							<span>{{DB::table("software_list")->where('id',$software_list_id)->value('name_zh')}}</span>
						</th>
				  </tr>
				@endif
				@endforeach		
		</tbody>
	</table>	
	@endif
	
	@if(isset($notTakenNumber) &&  $notTakenNumber!=0)
  {!! Form::open(['url'=> '/auth_soft/takeCD','method'=>'post'])  !!}
		<table class="table table-hover">
			<thead>
				<tr>
					<th>{{Lang::get('Auth_soft/take_cd.8')}}</th>
					<th>{{Lang::get('Auth_soft/take_cd.9')}}</th>
					<th>{{Lang::get('Auth_soft/take_cd.10')}}</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($options as $software_list_id=>$o)

				  @if (!isset($haveTakenSoftId[$software_list_id]))
					 <tr>
						<th style="width:20%">
						<!--		<input type="checkbox" id="check_{{$software_list_id}}" name="check_{{$software_list_id}}" value="check_{{$software_list_id}}" style="margin-right:3%"><span>點選領用</span>-->
							<div class="checkbox">
         		  	<label style="font-size: 1em">
               		<input type="checkbox" id="check_{{$software_list_id}}" name="check_{{$software_list_id}}"value="check_{{$software_list_id}}"style="margin-right:3%">
               		<span class="cr"><i class="cr-icon fa fa-check"></i></span>
                {{Lang::get('Auth_soft/take_cd.11')}}
           		  </label>
        			</div>
						</th>
						<th style="width:20%">
							<span>
					      <div class="dropdown" id="new_type_dropdown">
									<input id="softInput_{{$software_list_id}}" name="softInput_{{$software_list_id}}" autocomplete="off" value="softSend_{{current(array_keys($o))}}" type="hidden">
									<button class="btn btn-default navbar-content btn-block" id="soft_btn_{{$software_list_id}}" name="softInput_{{$software_list_id}}" data-toggle="dropdown" role="button" autocomplete="off" >
									{{current(array_values($o))['platform']}}
									<span class="caret"></span>
									</button>
									<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
										@foreach ($o as $id=>$data)
											<li ><a href="#" id="softSend_{{$id}}">{{$data['platform']}}</a></li>
										@endforeach
									</ul>
                </div>
							</span>
						</th>
						<th>
							<span>{{DB::table("software_list")->where('id',$software_list_id)->value('name_zh')}}</span>
						</th>
					</tr>
					@endif
				@endforeach
			</tbody>
		</table>
		@endif
	<input type="submit" class="btn btn-primary " value="{{Lang::get('Auth_soft/take_cd.13')}}" />
	{!! Form::close() !!}	
@else
		<h1>{{Lang::get('Auth_soft/take_cd.12')}}</h1>
@endif
<?php
	//顯示ip
	if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else{
			$ip = $_SERVER["REMOTE_ADDR"];
	}
			 
	$ip=$_SERVER["REMOTE_ADDR"];	
?>
<!-- 這裡只是prototype，用完後要把所有文字用resource lang表示 -->
<!--
假如有光碟已經領過，就不會顯示在上面。
要封ip應該比想像中的簡單，只要用php顯示ip的函式，再加上檢測有沒有登入就可以了。
重點就是，這裡檢測到的ip，是從哪裡來的ip?因為他一直跳動，讓我覺得怕怕der
-->


