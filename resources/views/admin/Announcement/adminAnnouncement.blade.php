@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="btn navbar-btn btn-primary" href="{{ URL::to('admin/announcement/create') }}">
        <h5>
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			{{ Lang::get('Admin/Announcement.createAnnouncement') }}
        </h5>
		

      </a>
    </div>
  </div>
</div>  

<table class="table table-hover table-condensed">
  <tbody>
    <tr>
      <th>#</th>
      <th>{{ Lang::get('Admin/Announcement.title') }}</th>
      <th>{{ Lang::get('Admin/Announcement.link') }}</th>
      <th>{{ Lang::get('Admin/Announcement.updated_at') }}</th>
      <th></th>
    </tr>
    @foreach($announcement as $key => $value)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $value->title }}</td>
        <td>{{ $value->link }}</td>
        <td>{{ $value->updated_at }}</td>
        <td>
          <a class="btn btn-default" href="{{ URL::to('admin/announcement/'. $value->id) }}">
            {{ Lang::get('Admin/General.detail') }}
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

@stop