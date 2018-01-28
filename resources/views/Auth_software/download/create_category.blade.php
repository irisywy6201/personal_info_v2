@extends("layout")
@section("content")
<div style="background-color:#f2f2f2">
<div class="row text-center form-inline">
	<h3>新增</h3>
	<br>
</div>

	<form class="form-horizontal" method="POST" action="{{url('admin/auth_soft/Category')}}">
	    {{ csrf_field() }}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
	
    <div class="form-group">
      <label class="col-sm-2 control-label">軟體分類名稱(中文)&nbsp;:&nbsp;</label>
      <div class="col-sm-7">
        <input class="form-control" id="focusedInput" type="text" name="name_zh" >
      </div>
    </div>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">軟體分類名稱(英文)&nbsp;:&nbsp;</label>
      <div class="col-sm-7">
        <input class="form-control" id="focusedInput" type="text" name="name_en" >
      </div>
    </div>
	<div class="form-group">
		<div class="col-sm-10" style="text-align:right;">
			<button type="submit" class="btn btn-primary active">確認</button>
		</div>
	</div>
	</form>
	 @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
	<br><br>
	
	
    
</div>

@stop