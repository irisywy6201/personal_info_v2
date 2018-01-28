
<div class="tab-content">
<div id="4">
 
	<table class="table table-striped table-hover table-responsive">
    <tbody>
		<input  type="hidden"  name="{{$j=1}}" />
		@foreach($name as $downloads)
			@if($downloads->category==1)
				@if($downloads->isdelete==0)
					<tr>
						<td>
							<div class="col-sm-1">
								<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#down1{{$j}}">+</button>
							</div>
							<div class="col-sm-10">
								<a href="#"  style="text-decoration:none;font-size:20px">
									<strong>{{ $downloads->name_zh }}</strong>
								</a>
								<p style="color:gray;font-size:14px"><br>{{ $downloads->summary_zh }}</p>
							</div>
							
							<div class="col-sm-1">
							@if(Auth::check() && Auth::user()->isStaff())
								<form action="{{ url('auth_soft/edit/'.$downloads->id) }}" method="GET">
									<button type="submit" id="edit-downloads-{{ $downloads->id }}" class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-pencil"></span>
									</button><br><br>
								</form>
								<form action="{{ url('auth_soft/'.$downloads->id) }}" method="POST">
									{!! csrf_field() !!}
									{!! method_field('DELETE') !!}
									<button type="submit" id="delete-downloads-{{ $downloads->id }}" class="btn btn-default btn-sm" >
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</form>
							@endif
							<p>&nbsp;</p>
							</div>
							<p>&nbsp;</p>
							<br>
							<div id="down1{{$j}}" class="collapse" >
								<h3 style="text-align:center">{{ $downloads->name_zh }}</h3>
								<p style="border-top:#94b8b8 solid 4px;margin-left:45%;margin-right:45%;">&nbsp;</p>
								<div class="row" style="width:90%;margin-left:15px;">
								
									<div class="col-sm-4" style="">
										<input  type="hidden"  name="{{$i=1}}" />
										<a id="connect1{{$j}}" href="#"><img src="/img/download.png" style="width:250px;"></a><br><br>
										<p id="name1{{$j}}" style="color:#fff;border-radius:4px;background-color:#993333; letter-spacing:1px;text-align:center;"></p>

										<!-- Single button -->
										<div class="dropdown" style="display:inline;">
											<button id="which" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" >請選擇版本
											<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
											@foreach($software_version as $software_versions)
											@if($software_versions->software_list_id==$downloads->id)
												<li onclick="get_connect1('{{ $software_versions->link }}','{{ $software_versions->name_zh }}','{{$j}}')"><a>{{ $software_versions->name_zh }}</a></li>
												<input  type="hidden"  name="{{$i=$i+1}}" />
											@endif
										   
											@endforeach
											</ul>
										</div>
										<button type="button" class="btn btn-primary"style="margin-left:26px">KMS認證說明</button>
									</div>
									
									<div class="col-sm-8" style="">
										<h5 style="line-height:24px;letter-spacing:1px;">此為全校授權軟體(含所有學生以及教職員)，合法使用範圍為中央大學校園，以及學生/教職員在家工作使用之電腦。若為應屆畢業生，該生可享有一套畢業時現有版本軟體的永久使用權。</h5>
										<h4 style="line-height:24px;letter-spacing:1px;border-left:gray solid 2px;padding-left:8px"><strong>系統需求</strong></h4>
										<ul style="line-height:24px;letter-spacing:1px;">
										  @foreach($software_requirement as $software_requirements)
											@if($software_requirements->software_list_id==$downloads->id)
												<li>{{ $software_requirements->requirement_zh }}</li>
											@endif
										  @endforeach
										</ul>
									</div>
								</div>
								<br>
								<br>
								<br>

							</div>		
						</td>
					</tr>
		<input  type="hidden"  name="{{$j=$j+1}}" />
			@endif
		@endif
	@endforeach
	</tbody>
    </table>
	 	
</div>
  
  

</div>

<script>
	function get_connect1(connection,name,j){
		
		 document.getElementById('connect1'+j).href=connection;
		  document.getElementById('name1'+j).innerHTML='點擊上面圖片下載 '+name;

		
	}
	
	
	
</script>
