@extends("layout")
@section("content")

@include("Auth_software.locationBar")
<!--因為用到blade，所以放這裡QAQ，跪求可以在js裡放blade的方法-->
<script>
$(document).ready(function(){
})
</script>
<!--tabs-->
<ul class="nav nav-tabs ">
  @foreach(Lang::get('Auth_soft/auth_index') as $test)
    <li id="e{{$test['index']}}" class="@if($test['index']==0) active  @endif" >
      <a href="#{{$test['index']}}" data-toggle="tab" class="tabs ">
        {{$test['title']}}
      </a>
    </li>
  @endforeach
</ul>

<div class="tab-content">
  <!--首頁-->
  <div class="tab-pane active" id="0">
	<table class="table table-striped table-hover table-responsive">
		<tbody>
			@foreach($authsoftindex as $test)
		<tr>
			<td>
				<a href="#indextitle{{$test->id}}" data-toggle="tab" class="listen">
					{{$test->indextitle_zh}}
				</a>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
  </div>

  <!--軟體下載 選擇頁面-->
  <div class="tab-pane fade" id="1">
	   <table class="table table-striped table-hover table-responsive">
		<tbody>
		  @foreach($software_category as $software)
		  <tr>
			<td>
				<div class="col-sm-10">
				  <a  href="#b{{$software->id}}" id="a{{$software->id}}1" data-toggle="tab" class="listen" style="text-decoration:none;font-size:20px">
					<strong>{{ $software->category_name_zh }}</strong><br><br>
				  </a>
				</div>
			</td>
		  </tr>
		  @endforeach
		</tbody>
	</table>
  </div>
  <!--光碟領用 選擇頁面-->
  <div class="tab-pane fade" id="2">
    <table class="table table-striped table-hover table-responsive">
      <tbody>
        @foreach(Lang::get('Auth_soft/auth_index.take_CD.items') as $test)
	  <tr>
	    <td>
	      <a href="#{{$test['index']}}" data-toggle="tab" class="listen">
	        {{$test['title']}}
	      </a>
	    </td>
	  </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!--KMS認證  選擇頁面-->
	<div class="tab-pane fade" id="3">
    <table class="table table-striped table-hover table-responsive">
      <tbody>
        @foreach(Lang::get('Auth_soft/auth_index.KMS.items') as $test)
	  <tr>
	    <td>
	      <a href="#{{$test['index']}}" data-toggle="tab" class="listen">
	        {{$test['title']}}
	      </a>
	    </td>
	  </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!--軟體下載 作業系統-->
  <div class="tab-pane fade" id="4">
    @include("Auth_software.os") 
  </div>  
  
  
  <!--軟體下載 應用程式-->
  <div class="tab-pane fade" id="5">
    @include("Auth_software.app") 
  </div>  
  

  <!--軟體下載 防毒軟體-->
  <div class="tab-pane fade" id="6">
    @include("Auth_software.anti_virus") 
  </div>  
  <!--軟體下載 其他項目-->
  <div class="tab-pane fade" id="7">
    @include("Auth_software.else") 
  </div>  
  <!--光碟領用 領用聲明-->
  <div class="tab-pane fade" id="8">
    @include("Auth_software.claim") 
  </div>  
  <!--光碟領用 光碟領取-->
  <div class="tab-pane fade" id="9">
    @include("Auth_software.take_cd") 
  </div>  
  <!--KMS認證 認證說明-->
  <div class="tab-pane fade" id="12">
    @include("Auth_software.readme") 
  </div>  
  <!--KMS認證 KMS認證-->
  <div class="tab-pane fade" id="13">
    @include("Auth_software.KMS") 
  </div> 

 @foreach($authsoftindex as $index)
	<div class="tab-pane fade" id="indextitle{{$index->id}}">
		{!!$index->indexcontent_zh!!}
	</div>
 @endforeach

 @foreach($software_category as $software)
		
		<div class="tab-pane fade" id="b{{$software->id}}">
		
			<table class="table table-striped table-hover table-responsive">
				<tbody>
					<input  type="hidden"  name="{{$j=1}}" />
					@foreach($name as $downloads)
						@if($downloads->software_category_id==$software->id)
							@if($g_year>=$downloads->year)
								@if($downloads->isdelete==0)
									<tr>
										<td>
											<div class="col-sm-1">
												<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#down{{$software->id}}{{$j}}">∨</button>
											</div>
											<div class="col-sm-10">
												<a style="text-decoration:none;font-size:20px">
													<strong>{{ $downloads->name_zh }}</strong>
												</a>
												<p style="color:gray;font-size:14px"><br>{{ $downloads->summary_zh }}</p>
											</div>
											<div class="col-sm-1">
												<p>&nbsp;</p>
											</div>
											<p>&nbsp;</p>	
											<br><br><br>
											<div id="down{{$software->id}}{{$j}}" class="collapse">
												<h3 style="text-align:center">{{ $downloads->name_zh }}</h3>
												<p style="border-top:#94b8b8 solid 4px;margin-left:45%;margin-right:45%;">&nbsp;</p>
												<div class="row" style="width:90%;margin-left:15px;">
													<div class="col-sm-4" style="">
														<input  type="hidden"  name="{{$i=1}}" />
														<a id="connect{{$software->id}}{{$j}}" href="#"><img src="/img/download.png" style="width:250px;"></a><br><br>
														<p id="name{{$software->id}}{{$j}}" style="color:#fff;border-radius:4px;background-color:#993333; letter-spacing:1px;text-align:center;"></p>

														<!-- Single button -->
														<div class="dropdown" style="display:inline;">
															<button id="which" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" >請選擇版本
															<span class="caret"></span></button>
															<ul class="dropdown-menu">
															@foreach($software_version as $software_versions)
																@if($software_versions->platform_id==7)
																	<li onclick="get_connect{{$software->id}}('{{ $software_versions->download_link }}<?php echo time(); ?>','','{{$j}}')"><a>{{ $downloads->name_zh }}</a></li>
																@elseif($software_versions->software_list_id==$downloads->id)
																	<li onclick="get_connect{{$software->id}}('{{ $software_versions->download_link }}<?php echo time(); ?>','<?php echo Lang::get('Auth_soft/platformList.'.$software_versions->platform_id.'.title')?>','{{$j}}')"><a><?php echo Lang::get('Auth_soft/platformList.'.$software_versions->platform_id.'.title')?></a></li>
																	<input  type="hidden"  name="{{$i=$i+1}}" />
																@endif   
															@endforeach
															</ul>
														</div>
														<a href="{{ $downloads->kms_link }}"><button type="button" class="btn btn-primary"style="margin-left:26px">KMS認證說明</button></a>
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
													@foreach($readme as $kmslink)
														@if($kmslink->id == $downloads->officeDoc_id)													
												<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$kmslink->id}}" style="margin-left:26px">
														KMS認證說明
														</button>

														<!-- Modal -->
														<div class="modal fade" id="{{$kmslink->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
														  <div class="modal-dialog" role="document">
															<div class="modal-content">
															  <div class="modal-header">
																<h5 class="modal-title" id="exampleModalLongTitle">{{$kmslink->title_zh}}</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																  <span aria-hidden="true">&times;</span>
																</button>
															  </div>
															  <div class="modal-body">
															  {!!$kmslink->Content_zh!!}
															  </div>
															  <div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															  </div>
															</div>
														  </div>
														</div>		
														@endif
													@endforeach
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
												<br><br><br>

											</div>
				
										</td>
									</tr>
									<input  type="hidden"  name="{{$j=$j+1}}" />
								@endif
							@endif
						@endif
					@endforeach
				</tbody>
			</table> 		
		  </div>
	@endforeach 
 
</div>

{!! HTML::script('js/Auth_soft/auth_soft.js') !!}
{!! HTML::style('css/Auth_soft/auth_soft.css') !!}
<script>

 @foreach($software_category as $software)
  	function get_connect{{$software->id}}(connection,name,j){
  		
  		document.getElementById('connect'{{$software->id}}+j).href=connection;
  		document.getElementById('name'{{$software->id}}+j).innerHTML='點擊上面圖片下載 '+name;

  		
  	}	
  @endforeach

  </script>

@stop




