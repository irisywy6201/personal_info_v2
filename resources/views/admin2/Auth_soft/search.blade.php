@extends("admin.adminLayout")
@section("modifyContent")

</br>

<div>
  <p>
	  <!--{!! Form::open(['url'=>'/admin/Auth_soft/stuasdjf;','method'=>'post']) !!}-->
		
		{!! Form::open(['url'=> '/admin/Auth_soft/studentID_OR_email','method'=>'post'])      !!}
    {{ Lang::get('Admin/software_cd_record.1') }}
    <code>{{ Lang::get('Admin/software_cd_record.2') }}</code>
    {{ Lang::get('Admin/software_cd_record.3') }}<code>{{ Lang::get('Admin/software_cd_record.4') }}</code>：
    <input type="text" id="search_input" name="search_input" />
    <button type="submit" class="btn btn-primary" value="查詢">{{ Lang::get('Admin/software_cd_record.5') }}</button>
		{!! Form::close() !!}
  </p>
</div>

</br>

@if (isset($test))
		<p>{{ Lang::get('Admin/software_cd_record.6') }}<code>{{$test[0]['users_id']}}</code>{{ Lang::get('Admin/software_cd_record.7') }}</p>	
		<table class="table table-hover">
			<thead>
				<tr>
					<th>{{ Lang::get('Admin/software_cd_record.8') }}</th>
					<th>{{ Lang::get('Admin/software_cd_record.10') }}</th>
					<th>{{ Lang::get('Admin/software_cd_record.9') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($cds as $id=>$cd)
				<tr>
					<th>{{$cd['lend_time']}}</th>
					<th>{{$cd['softName']}}</th>
					<th>{{$cd['platform']}}</th>
				</tr>
			@endforeach
			</tbody>
		</table>
@elseif (isset($userChecker))
	@if ($userChecker==0)
		<h1>{{ Lang::get('Admin/software_cd_record.11') }}</h1>
	@else
		<h1>{{ Lang::get('Admin/software_cd_record.12') }}</h1>
	@endif
@endif
@stop
