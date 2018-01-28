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
		<form class="form-horizontal" method="POST" action="{{ url('admin/auth_soft/Category/'.$software_category->id) }}">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體分類名稱(中文)&nbsp;:&nbsp;</label>
			<div class="col-sm-7">
				<input class="form-control" id="focusedInput" type="text" name="category_zh" value="{{ $software_category->category_name_zh }}">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label">軟體分類名稱(英文)&nbsp;:&nbsp;</label>
			<div class="col-sm-7">
				<input class="form-control" id="focusedInput" type="text" name="category_en" value="{{ $software_category->category_name_en }}">
			</div>
		</div>
	
	
		<div class="col-sm-11" style="text-align:right;">
			<button type="submit" class="btn btn-primary btn-lg active">確認修改</button>
		</div>
		
	</form>
	<br><br> <br><br>
	</div>
@stop