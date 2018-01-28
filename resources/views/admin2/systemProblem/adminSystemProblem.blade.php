@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
	<h3>{{ $title }}</h3>
</div>

<table class="table table-hover table-condensed">
	<tr>
		<td>#</td>
	  <td>{{ Lang::get('Admin/General.email') }}</th>
	  <td>{{ Lang::get('Admin/SystemProblem.problemContent') }}</th>
	  <td>{{ Lang::get('Admin/General.status') }}</th>
		<td>{{ Lang::get('Admin/General.updated_at') }}</td>
	  <td></td>
	</tr>
	<tbody>
		@foreach($systemProblem as $key => $value)
			<tr>
	      <td>{{ $value->id }}</td>
	      <td>{{ $value->email }}</td>
	      <td>{!! str_limit($value->content, $limit = 30, $end = '...') !!}</td>
	      <td>
			  @if($value->isSolved == 0)
			  	<span class="text-danger glyphicon glyphicon-remove"></span>
		      @else
		        <span class="text-success glyphicon glyphicon-ok"></span>
		      @endif
		  </td>
	      <td>{{ $value->created_at }}</td>
	      <td>
	      	<a class="btn btn-default" href="{{ URL::to('admin/systemProblem/'. $value->id)}}">{{ Lang::get('Admin/General.detail') }}</a></td>
	    	</tr>
		 	@endforeach
		</tbody>
</table>

@stop
