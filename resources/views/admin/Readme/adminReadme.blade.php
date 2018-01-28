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


@endsection

@section("modifyContent")

<script>

$(".doctitle").on('click', function(){
   var doccontent = $(this).attr('rel');
   $("#"+doccontent).show().siblings(".content").hide();
   console.log(321);
});
</script>

<div class="row text-center">
  <h3>KMS認證說明</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
	<div class="navbar-header" style="padding-right:1%">
      <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/Readme/catagory/create') }}">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          新增分類
      </a>
    </div>
	
    <div class="navbar-header">
      <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/Readme/kmsreadme/create') }}">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          新增說明
      </a>
	</div>
  </div>
</div>  

<table class="table table-hover table-condensed">
  <tbody>
    <tr>
      <th>分類標題</th>
      <th>分類簡介</th>
      <th></th>
    </tr>
@foreach($readmecatagory as $catagory)
      <tr>
        <td>{{$catagory->doccategory_name_zh}}</td>
        <td style="width:">{{ $catagory->doccategory_discribe_zh }}</td>
		<td style="width:18%">
  <div class="form-group" style="display:inline;float:left;padding-right:5%">
	 <form action="{{ url('admin/Readme/catagory/'.$catagory->id.'/edit') }}" method="GET">
		<button type="submit" class="btn btn-success" >
		<span class="glyphicon glyphicon-pencil"></span>
		{{ Lang::get("Admin/General.edit") }}
		</button>
	  </form> 
 </div>	  

 <div class="form-group" style="display:inline; float:left;">
	  {!! Form::open(array("url" => array("/admin/Readme/catagory/". $catagory->id),"method" => "DELETE")) !!}
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

<table class="table table-hover table-condensed">
  <tbody>
    <tr>
      <th>分類</th>
      <th>標題</th>
	  <th>內容</th>
      <th></th>
    </tr>
@foreach($readmecatagory as $catagory)
   @foreach($readme as $value)
      <tr>
	  @if($catagory->id==$value->doccatagory_id)
        <td>{{$catagory->doccategory_name_zh}}</td>
        <td>{{ $value->title_zh }}</td>
		<td>{!! $value->Content_zh !!}</td>
		<td style="width:18%">
  <div class="form-group" style="display:inline;float:left;padding-right:5%">
	 <form action="{{ url('admin/Readme/kmsreadme/'.$value->id.'/edit') }}" method="GET">
		<button type="submit" class="btn btn-success" >
		<span class="glyphicon glyphicon-pencil"></span>
		{{ Lang::get("Admin/General.edit") }}
		</button>
	  </form> 
 </div>	  
 <div class="form-group" style="display:inline; float:left;">
	  {!! Form::open(array("url" => array("/admin/Readme/kmsreadme/". $value->id),"method" => "DELETE")) !!}
        <button type="submit" class="btn btn-danger" >
		<span class="glyphicon glyphicon-remove"></span>
		{{ Lang::get("Admin/General.delete") }}
		</button>
 </div>		
      {!! Form::close() !!}
        </td>
      </tr>
	  @endif	  
    @endforeach
@endforeach
  </tbody>
</table>

@stop