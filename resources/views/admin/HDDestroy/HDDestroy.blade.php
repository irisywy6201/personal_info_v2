@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center form-inline">
	<h3>{{ '硬碟破壞系統' }}</h3>
	<a class="btn btn-success" style="float:right" href=" {{ URL::to('admin/HDDestroyExportExcel') }}">匯出報表</a>
	<br>
</div>
<br>

<table class="table table-hover table-condensed">
	<tr>
	<td>#</td>
	<td>{{ '處室' }}</th>
	<td>{{ '硬碟數量' }}</th>
	<td>{{ '預約時間' }}</th>
	<td>{{ Lang::get('狀態') }}</td>
	<td></td>
	</tr>
	{!! Form::open(array('url' => 'admin/HDDestroy')) !!}
	<tbody>
	    @foreach($dates as $key => $date)
		<tr>
		<td>{{ $key+1 }}</td>
	        <td>{{ $faculties[$key] }}</td>
	        <td>{{ $numbers[$key] }}</td>
	        <td>{{ $date }}</td>
		@if($states[$key] == 0)
		    <td>{{ 'Open' }}</td>
		    <td><a class='btn btn-danger glyphicon ' href=" {{ URL::to('admin/HDDestroy/' . $date) }}" >Close</a></td>
		@else
		    <td>{{ 'Close at '.$closeTimes[$key] }}</td>
		    <td></td>
		@endif
		
	    	</tr>
	    @endforeach

	</tbody>
	{!! Form::close() !!}	
</table>

@stop
