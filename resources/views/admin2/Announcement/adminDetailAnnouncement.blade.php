@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/announcement/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>
<div class="navbar" role="navigation">
	<div class="container-fluid">
		<div class="navbar-right">
			{!! Form::open(['url' => 'admin/announcement/' . $announcement->id, 'method' => 'delete', 'class' => 'navbar-form navbar-right']) !!}     
        <a href="{{URL::to('admin/announcement/'.$announcement->id.'/edit')}}" class="btn btn-success">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          {{ Lang::get('Admin/General.edit') }}
        </a>
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/Announcement.announcement')])
        <button class="btn btn-danger btn-delete" type="button">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        	{{ Lang::get('Admin/General.delete') }}
        </button>
      {!! Form::close() !!}
    </div>
	</div>
</div>  

<hr >
{{--
  <div class="row" id="admin-announce-nav">
		<div class="col-lg-10">
		  <a id="forCategDeaprt" class="btn btn-default" href="{{URL::to('admin/announcement/')}}">{{ HTML::image('images/reply.png', 'Button icon') }}{{Lang::get('admin.goback')}}</a>
		  <a id="forCategDeaprt" class="btn btn-success" href="{{URL::to('admin/announcement/'.$announcement->id.'/edit')}}">{{ HTML::image('images/edit_light.png', 'Button icon') }}{{Lang::get('admin.edit')}}</a>
    </div>
    <div class="col-lg-2">
      {{ Form::open(array("url" => array("/admin/announcement/". $announcement->id),"method" => "DELETE")) }}
        <button id="forCategDeaprt" type="submit" class="btn btn-danger" >{{ HTML::image('images/cross_light.png', 'Button icon') }}{{Lang::get('admin.delete')}}</button>
      {{ Form::close() }}
    </div>
  </div>
--}}

<h3>{{ Lang::get('Admin/Announcement.announceUser') }} :  {{ $announcement->announceUser }}</h3>
<h3>{{ Lang::get('Admin/Announcement.title') }} : 	{{ $announcement->title }} </h3>
<h3>{{ Lang::get('Admin/Announcement.link') }} : {{ $announcement->link }} </h3>

@stop
