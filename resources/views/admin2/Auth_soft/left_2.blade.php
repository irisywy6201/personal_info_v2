@extends("admin.adminLayout")
@section("modifyContent")

<script>
	$(document).ready(function(){
		$('#new_softName_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#softName').attr('value',selected);
		});
		$('#new_type_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#type').attr('value',selected);
		});
		$('#new_bits_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#bits').attr('value',selected);
		});
		$('#update_type_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#update_type_dropdown #type').attr('value',selected);
		});
		$('#update_download_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#update_download_dropdown #download_id').attr('value',selected);
		});
		$('#update_version_dropdown li a').on("click",function(){
			var selected=$(this).attr('data-type');
		  $('#update_version_dropdown #download_version_id').attr('value',selected);
		});


		
		$('.fix_btn').click(function(){

			var s=$(this).attr('id');
			var f=s.slice(3);
			var name="fix"+f;
			var div_id="c"+f;
			var input_id="left_number"+f;
			var alert_id="choose_left"+f;
			var input_value=$("#"+input_id).val();
			if(input_value==""){
				$("#"+alert_id).parent().show();
				$("#"+alert_id).show();
			}
			else{
		 		$("form[name="+name+"]").submit();
			}
		});
		$('#add_sure').click(function(){
			
			if(($('#softName').val())==""){
     		$("#add_choose_name_font").parent().show();
        $("#add_choose_name_font").show();
    	}
			else{
				$("#add_choose_name_font").hide();
			} 
    	if(($('#theLeft').val())==""){
				$("#add_choose_left_font").parent().show();
        $("#add_choose_left_font").show();				
   		}
			else{
				$("#add_choose_left_font").hide();
			}
  	  if(($('#type').val())==""){
				$("#add_choose_type_font").parent().show();
        $("#add_choose_type_font").show();
   		}
			else{
				$("#add_choose_type_font").hide();
			} 
    	if(($('#bits').val())==""){
				$("#add_choose_bit_font").parent().show();
        $("#add_choose_bit_font").show();
			}
			else{
				$("#add_choose_bit_font").hide();
			}

			if(($('#softName').val()!="") && ($('#theLeft').val()!="") && ($('#type').val()!="")
				&&	($('#bits').val()!="")){
				$('#reg').submit();
			}


		});	
});
</script>



</br>
<ul class="nav nav-tabs">
	{{$software_categories[0]['id']}}
	@foreach ($software_categories as $software_category)
			

	@endforeach
<!--
  <li class="active">
    <a href="#0" data-toggle="tab" class="tabs">
      作業系統
    </a>
  </li>
  <li>
    <a href="#1" data-toggle="tab" class="tabs">
      應用程式
    </a>
  </li>
  <li>
    <a href="#2" data-toggle="tab" class="tabs">
      防毒軟體
    </a>
  </li>
  <li>
    <a href="#3" data-toggle="tab" class="tabs">
      其他項目
    </a>
  </li>
!-->
</ul>
<div class="tab-content">
	@for ($i=0;$i<4;$i++)
		@if ($i==0)
			<div class="tab-pane fade active in" id="{{$i}}">
		@else
			<div class="tab-pane fade" id="{{$i}}">
		@endif
			</br>

			<div class="addCD">
			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#new_cd_modal">新增光碟</button>

			</br>
			</br>



			<table class="table table-hover">
				<thead>
					<tr>
						<th>剩餘片數</th>
						<th>光碟名稱</th>
						<th>位元</th>
					</tr>
				</thead>
				<tbody>
					<?php// $type=array('os','application','anti_virus','else');  ?>
					@foreach($CDs_2 as $CD_2)
						@if	(1 == $type[$i])
							<tr>
								<th>
									<span>{{$CD_2->surplus}}</span>
								</th>
								<th>
									<span>{{$ds[$CD_2->software_list_id]['name_zh']}}</span>
								</th>
								<th>
									<span>
										{{$d_vs[$CD_2->platform_id]}}
									</span>
									<button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#a{{$CD_2->id}}" style="float:right">刪除光碟</button>

									<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#c{{$CD_2->id}}" style="float:right;margin-right:3%">修改資訊</button>

								</th>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>

				@if (count($errors)>0)
					<div class="alert alert-danger" style="margin-top:2%">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
		</div>
	@endfor	
</div>
<!-- 這裡可以塞到其他.blade.php裡，再include進來 
		 新增光碟			modal version 
<div class="modal fade" id="new_cd_modal" role="dialog">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">新增光碟</h4>
        </div>
				{!! Form::open(['url'=> '/admin/Auth_soft/left_store','method'=>'post','id'=>'reg'])  !!}
				<fieldset>
        <div class="modal-body">
					<h2>請輸入光碟的基本資料</h2>
						<div class="form-group">
							<label for="softName">光碟名稱</label>
							<div class="dropdown" id="new_softName_dropdown">
								<input id="softName" name="softName" type="hidden" >
								<button class="btn btn-default navbar-content btn-block" id="category" name="category" data-toggle="dropdown" role="button">

								請選擇光碟的名稱
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									@foreach ($ds as $d)
										<li><a href="#" data-type="{{$d['id']}}">{{$d['name']}}</a></li>
									@endforeach
								</ul>
							</div>
							<label for="theLeft">剩餘片數</label>
							<input class="form-control" id="theLeft" name="theLeft" type="text" value="">
							<label for="type">軟體分類</label>
							<div class="dropdown" id="new_type_dropdown">
								<input id="type" name="type" type="hidden" value="">
								<button class="btn btn-default navbar-content btn-block" id="type_btn" name="type_btn" data-toggle="dropdown" role="button">

								請選擇軟體的分類
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									<li><a href="#" data-type="os">作業系統</a></li>
									<li><a href="#" data-type="application">應用程式</a></li>
									<li><a href="#" data-type="anti_virus">防毒軟體</a></li>
									<li><a href="#" data-type="else">其他項目</a></li>
								</ul>
							</div>
							<label for="bits">位元</label>
							<div class="dropdown" id="new_bits_dropdown">
								<input id="bits" name="bits" type="hidden" value="">
								<button class="btn btn-default navbar-content btn-block" id="category" name="category" data-toggle="dropdown" role="button">

								請選則欲選取的位元
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									@foreach ($d_vs as $d_v)
										<li><a href="#" data-type="{{$d_v['id']}}">{{$d_v['title']}}</a></li>
									@endforeach
								</ul>
							</div>

						</div>
        </div>
				<div class="alert alert-danger" style="display:none">
					<center style="display:none" id="add_choose_name_font"><p>請選擇光碟名稱</p></center>
					<center style="display:none" id="add_choose_left_font"><p>請輸入剩餘片數</p></center>
					<center style="display:none" id="add_choose_type_font"><p>請選擇光碟種類</p></center>
					<center style="display:none" id="add_choose_bit_font"><p>請選擇位元種類</p></center>
				</div>
        <div class="modal-footer">
					<button type="button" class="btn btn-primary" id="add_sure">確定</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">離開</button>
        </div>

				{!! Form::close() !!}
				</fieldset>
      </div>
	</div>
</div>
-->
<!-- 這裡可以塞到其他.blade.php裡，再include進來 pp\Http\Requests
		 修改剩餘片數		modal version  
-->
@foreach ($CDs_2 as $CD_2)
<div id="c{{$CD_2->id}}" class="modal fade root" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">修改資訊</h4>
      </div>
      <div class="modal-body">
				<h2>請修改光碟的基本資料</h2>
				{!! Form::open(['url'=> '/admin/Auth_soft/left_fixNumber','method'=>'post','name'=>'fix'.$CD_2->id])  !!}
				<fieldset>
					<div class="form-group">
					<label for="download_id">光碟名稱</label>
					<div class="dropdown" id="update_download_dropdown">
								<input id="download_id" name="download_id" type="hidden" value="{{$CD_2->download_id}}">
								<button class="btn btn-default navbar-content btn-block" id="type_btn" name="type_btn" data-toggle="dropdown" role="button">
								{{$ds[$CD_2['download_id']]['name']}}<!--id是從1開始，陣列是從零開始-->
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									@foreach ($ds as $d)
										<li><a href="#" data-type="{{$d['id']}}">{{$d['name']}}</a></li>
									@endforeach
								</ul>
							</div>

					<label for="left_number">剩餘片數</label>
					<input class="form-control" id="left_number{{$CD_2->id}}" name="left_number" type="text" value="{{$CD_2->left_number}}">
					<label for="type">軟體分類</label>
				   <div class="dropdown" id="update_type_dropdown">
								<input id="type" name="type" type="hidden" value="{{$CD_2->type}}">
								<button class="btn btn-default navbar-content btn-block" id="type_btn" name="type_btn" data-toggle="dropdown" role="button">
								@if ($CD_2->type=="os")
									作業系統
								@elseif ($CD_2->type =="application")
									應用程式
								@elseif ($CD_2->type =="anti_virus")
									防毒軟體
								@elseif ($CD_2->type =="else")
									其他項目
								@endif
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									<li><a href="#" data-type="os">作業系統</a></li>
									<li><a href="#" data-type="application">應用程式</a></li>
									<li><a href="#" data-type="anti_virus">防毒軟體</a></li>
									<li><a href="#" data-type="else">其他項目</a></li>
								</ul>
							</div>
						<label for="download_version_id">位元</label>
						<div class="dropdown" id="update_version_dropdown">
								<input id="download_version_id" name="download_version_id" type="hidden" value="{{$CD_2->download_version_id}}">
								<button class="btn btn-default navbar-content btn-block" id="type_btn" name="type_btn" data-toggle="dropdown" role="button">
								{{$d_vs[$CD_2['download_version_id']]['name_zh']}}<!--id從1開始，陣列從0開始-->
								<span class="caret"></span>
								</button>
								<ul class="dropdown-menu menu-content" role="menu"  aria-labelledby="dLabel" style="width:100%">
									@foreach ($d_vs as $d_v)
										<li><a href="#" data-type="{{$d_v['id']}}">{{$d_v['name_zh']}}</a></li>
									@endforeach
								</ul>
							</div>

					</div>
					<input type="hidden" name="id" id="id" value="{{$CD_2->id}}">
				</fieldset>
      </div>
			<div class="alert alert-danger" style="display:none">
				<center style="display:none" id="choose_name{{$CD_2->id}}"><p>請選擇光碟名稱</p></center>
				<center style="display:none" id="choose_left{{$CD_2->id}}"><p>請輸入剩餘片數</p></center>
				<center style="display:none" id="choose_type{{$CD_2->id}}"><p>請選擇光碟種類</p></center>
				<center style="display:none" id="choose_bit{{$CD_2->id}}"><p>請選擇位元種類</p></center>
			</div>
      <div class="modal-footer">
				<button type="button" id="btn{{$CD_2->id}}"  class="btn btn-primary fix_btn">確定</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">離開</button>
      </div>
			{!! Form::close() !!}	
    </div>

  </div>
</div>
@endforeach

<!-- 這裡可以塞到其他.blade.php裡，再include進來 
		 刪除該列			modal version 
@foreach ($CDs_2 as $CD_2)
<div class="modal fade" id="a{{$CD_2->id}}" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">刪除資訊</h4>
      </div>
			{!! Form::open(['url'=> '/admin/Auth_soft/left_delete','method'=>'post'])  !!}
      <div class="modal-body">
				<input type="hidden" name="id" value="{{$CD_2->id}}">	
				<div class="container" style="width:70%">
					<h2>確認要刪除該列資訊嗎？</h2>
					</br>
					<h4>光碟名稱：{{$ds[$CD_2->download_id-1]['name']}}</h4>
					</br>
					<h4>剩餘片數：{{$CD_2->left_number}}</h4>
					</br>
					<h4>軟體分類：
							@if ($CD_2->type == 'os')
								作業系統
							@elseif ($CD_2->type=='application')
								應用程式
							@elseif ($CD_2->type=='anti_virus')
								防毒軟體
							@elseif ($CD_2->type=='else')
								其他項目
							@endif
					</h4>

					</br>
					<h4>位元：
						<span>
							{{$d_vs[$CD_2->paltform_id]['name_zh']}}
						</span>
					</h4>
					</br>
				</div>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-primary">確定</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">離開</button>
      </div>
    </div>      
		{!! Form::close() !!}		
  </div>
</div>
@endforeach

-->
{!! HTML::style('css/admin/Auth_soft/left.css') !!}

@stop







