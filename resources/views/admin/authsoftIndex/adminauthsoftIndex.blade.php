@extends("admin.adminLayout")
@section("css")
<style>
.table{
  overflow: hidden;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  max-width: 10px;
}
button{
	display:inline;
}
.box{
	height:10px
	overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.container{
	width:800px;
}
</style>
@endsection

@section("modifyContent")

<script>

</script>

<div class="row text-center">
  <h3>{{ Lang::get("Admin/Readme.manageauthsoftindex") }}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/authsoftIndex/adminCreateindex') }}">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          {{ Lang::get("Admin/Readme.createauthsoftindex") }}
      </a>
    </div>
  </div>
</div>  

<table class="table table-hover table-condensed" style="word-break:break-all;">
  <tbody>
    <tr>
      <th>{{ Lang::get("Admin/Readme.indextitle") }}</th>
	  <th style="width:300px">{{ Lang::get("Admin/Readme.indexcontent") }}</th>
    </tr>
	   @foreach($authsoftindex as $value)
      <tr>
        <td>{{ $value->indextitle_zh }}</td>
		<td><div class="box"><p>{!! $value->indexcontent_zh !!}</p></div>
		  <div class="form-group" style="display:inline;float:left;padding-right:5px">
			 <form action="{{ url('admin/authsoftIndex/'.$value->id.'/edit') }}" method="GET">
				<button type="submit" class="btn btn-success" >
				<span class="glyphicon glyphicon-pencil"></span>
				{{ Lang::get("Admin/General.edit") }}
				</button>
			  </form> 
		  </div>
		  <div class="form-group" style="display:inline;float:left;">
			  {!! Form::open(array("url" => array("/admin/authsoftIndex/". $value->id),"method" => "DELETE")) !!}
				<button type="submit" class="btn btn-danger" >
				<span class="glyphicon glyphicon-remove"></span>
				{{ Lang::get("Admin/General.delete") }}
				</button>
		 </div>		
			  {!! Form::close() !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

@stop