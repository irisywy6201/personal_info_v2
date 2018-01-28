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
			var input_id="surplus"+f;
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
	@foreach ($software_categories as $software_category)
		@if ($software_categories[0]['id']==$software_category['id'])
		
			<li class="active">
				<a href="#{{$software_category['id']}}" data-toggle="tab" class="tabs">
					{{$software_category['category_name_zh']}}
				</a>
			</li>
		@else
			<li>
				<a href="#{{$software_category['id']}}" data-toggle="tab" class="tabs">
					{{$software_category['category_name_zh']}}
				</a>
			</li>	
		@endif
	@endforeach
</ul>
<div class="tab-content">
	@foreach ($software_categories as $software_category)
		@if ($software_categories[0]['id']==$software_category['id'])	
			<div class="tab-pane fade active in" id="{{$software_category['id']}}">
		@else
			<div class="tab-pane fade" id="{{$software_category['id']}}">
		@endif
	
		</br>
		</br>
		<table class="table table-hover">
    	<thead>   
      	<tr>
        	<th>{{ Lang::get('Admin/left_cd_record.1') }}</th>
          <th>{{ Lang::get('Admin/left_cd_record.2') }}</th>
          <th>{{ Lang::get('Admin/left_cd_record.3') }}</th>
        </tr>
			</thead>
      <tbody>
				@foreach ($software_versions as $software_version)
					@if ($software_version['software_category_id']==$software_category['id'])
						<tr>
							<th>
								<span>{{$software_version['surplus']}}</span>	
							</th>
							<th>
								<span>{{$software_version['name_zh']}}</span>
							</th>
							<th>
								<span>{{$software_version['platform']}}</span>

                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#c{{$software_version['id']}}" style="float:right">{{ Lang::get('Admin/left_cd_record.4') }}</button>

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
	@endforeach
</div>


@foreach ($software_versions as $software_version)
<div id="c{{$software_version['id']}}" class="modal fade root" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ Lang::get('Admin/left_cd_record.5') }}</h4>
      </div>
			<div class="modal-body">
      	<h3>{{ Lang::get('Admin/left_cd_record.6') }}</h3>
      	{!! Form::open(['url'=> '/admin/Auth_soft/left_fixNumber','method'=>'post','name'=>'fix'.$software_version['id']])  !!}
					<input type="hidden" name="id" value="{{$software_version['id']}}"> 
        	<div class="container" style="width:70%">
         		<h4>{{ Lang::get('Admin/left_cd_record.7') }}{{$software_version['name_zh']}}</h4>
         		</br>
						<label for="surplus">{{ Lang::get('Admin/left_cd_record.1') }}</label>
          	<input class="form-control" id="surplus{{$software_version['id']}}" name="surplus" type="text" value="{{$software_version['surplus']}}">
         		</br>
         		<h4>{{ Lang::get('Admin/left_cd_record.8') }}{{$software_version['software_category']}}</h4>
						</br>
						<h4>{{ Lang::get('Admin/left_cd_record.9') }}{{$software_version['platform']}}</h4>	 
					</div>
      		<div class="alert alert-danger" style="display:none">
        		<center style="display:none" id="choose_left{{$software_version['id']}}"><p>{{ Lang::get('Admin/left_cd_record.10') }}</p></center>
     			</div>
					<div class="modal-footer">
       			<button type="button" id="btn{{$software_version['id']}}"  class="btn btn-primary fix_btn">{{ Lang::get('Admin/left_cd_record.11') }}</button>
       		 	<button type="button" class="btn btn-danger" data-dismiss="modal">{{ Lang::get('Admin/left_cd_record.12') }}</button>
      		</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endforeach


{!! HTML::style('css/admin/Auth_soft/left.css') !!}

@stop







