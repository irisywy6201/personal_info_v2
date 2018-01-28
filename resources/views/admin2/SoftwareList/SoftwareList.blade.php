@extends("admin.adminLayout")
@section("modifyContent")
<br>
	@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
           <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $message }}&nbsp;&nbsp;</strong>
    </div>
	@endif
	@if ($success_category = Session::get('success_category'))
    <div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>
           <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $success_category }}&nbsp;&nbsp;</strong>
    </div>
	@endif
	@if ($delete_suc_category = Session::get('delete_suc_category'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			   <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $delete_suc_category }}&nbsp;&nbsp;</strong>
		</div>
    @endif 
	@if ($delete_suc = Session::get('delete_suc'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			   <span class="glyphicon glyphicon-ok-sign"></span><strong>{{ $delete_suc }}&nbsp;&nbsp;</strong>
		</div>
    @endif 
	
<div class="row text-center form-inline">
	<h3>授權軟體管理</h3>
	<br>
</div>
<div class="row  form-inline">
	<div class="col-sm-2">
		<a class="btn navbar-btn btn-primary" href="{{url('admin/auth_soft/Category/create')}}">
				  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				  新增軟體種類
		</a>
	</div>
	<div class="col-sm-2">
		<a class="btn navbar-btn btn-primary" href="{{url('admin/auth_soft/Software/create')}}">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              新增軟體
		</a>
	</div>
</div>
<br>
<div class="tab-content">
<table class="table table-hover table-condensed">
	<tr>
	<th>&nbsp;軟體種類名稱</th>
	<th>&nbsp;</th>
</table>
 <table class="table table-hover table-condensed">
		<tbody>
			
		  @foreach($software_category as $software)
		  <tr>
			<td>
				<div class="col-sm-10">
				  <p style="font-size:20px">
					{{ $software->category_name_zh }}<br><br>
				  </p>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
							
						<div class="col-sm-6">
							<form action="{{ url('admin/auth_soft/Category/'.$software->id.'/edit') }}" method="GET">
								<button type="submit" id="edit-software-{{ $software->id }}" class="btn btn-default btn-sm">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>
							</form>
						</div>	
						<div class="col-sm-6">
							<form action="{{ url('admin/auth_soft/Category/'.$software->id) }}" method="POST">
								{!! csrf_field() !!}
								{!! method_field('DELETE') !!}
								<button type="submit" id="delete-software-{{ $software->id }}" class="btn btn-default btn-sm">
									<span class="glyphicon glyphicon-trash"></span>
								</button>
							</form>	
						</div>
									
										<p>&nbsp;</p>
					</div>
				</div>
			</td>
		  </tr>
		
		  @endforeach
		</tbody>
	</table>
	<table class="table table-hover table-condensed">
		<tr>
		<th>
		<div class="row  form-inline">
			<div class="col-sm-2"><p style="line-height:40px">&nbsp;軟體名稱&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
			<div class="col-sm-10">
			 <ul class="nav nav-pills">
				@foreach($software_category as $software)
					<li><a href="#b{{$software->id}}" data-toggle="tab" role="tab">{{ $software->category_name_zh }}</a></li>
				@endforeach         
			  </ul>
			
	
			
				
			</div>
		</th>
		<th>&nbsp;</th>
	</table>
	 @foreach($software_category as $software)
	
	<div class="tab-pane fade" id="b{{$software->id}}">
	
		<table class="table table-striped table-hover table-responsive">
			<tbody>
				<input  type="hidden"  name="{{$j=1}}" />
				@foreach($name as $downloads)
					@if($downloads->software_category_id==$software->id)
						@if($downloads->isdelete==0)
							<tr>
								<td>
									<div class="col-sm-10">
										<p style="font-size:20px">{{ $downloads->name_zh }}</p>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<div class="col-sm-6">
												<form action="{{ url('admin/auth_soft/Software/'.$downloads->id.'/edit') }}" method="GET">
													<button type="submit" id="edit-downloads-{{ $downloads->id }}" class="btn btn-default btn-sm">
														<span class="glyphicon glyphicon-pencil"></span>
													</button>
												</form>
											</div>
											<div class="col-sm-6">
												<form action="{{ url('admin/auth_soft/Software/'.$downloads->id) }}" method="POST">
													{!! csrf_field() !!}
													{!! method_field('DELETE') !!}
													<button type="submit" id="delete-downloads-{{ $downloads->id }}" class="btn btn-default btn-sm">
														<span class="glyphicon glyphicon-trash"></span>
													</button>
												</form>	
											</div>
										</div>
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
@endforeach 
</div>
<script>
	
</script>
@stop