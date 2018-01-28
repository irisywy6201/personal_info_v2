@extends("layout")
@section("content")
<div id="admin-content" >
  <div class="row">
    <div class="col-lg-2">
      <ul class="nav nav-pills nav-stacked ">
        <li ><a href="{{ URL::to('admin/announcement') }}"><h4>{{ Lang::get('Admin/PageList.manageAnnouncement') }}</h4></a></li>
        <li ><a href="{{ URL::to('admin/faq') }}" ><h4>{{ Lang::get('Admin/PageList.faq') }}</h4></a></li>
        <li ><a href="{{ URL::to('admin/category') }}"><h4>{{ Lang::get('Admin/PageList.manageCategory') }}</h4></a></li>
        <li ><a href="{{ URL::to('admin/sdCategory') }}"><h4>{{ Lang::get('Admin/PageList.manageSdCategory') }}</h4></a></li>
        <li ><a href="{{ URL::to('admin/contactPerson') }}"><h4>{{ Lang::get('Admin/PageList.manageContactPerson') }}</h4></a></li>
        <li ><a href="{{ URL::to('admin/management') }}"><h4>{{ Lang::get('Admin/PageList.management') }} </h4></a></li>
        <li ><a href="{{ URL::to('admin/approve') }}"><h4>{!! Lang::get('Admin/PageList.approveForgetpass') !!} </h4></a></li>
        <li ><a href="{{ URL::to('admin/approveResult') }}"><h4>{!! Lang::get('Admin/PageList.approvedInfo') !!} </h4></a></li>
        <li ><a href="{{ URL::to('admin/reporter') }}"><h4>{{ Lang::get('Admin/PageList.reporter') }} </h4></a></li>
        <li ><a href="{{ URL::to('admin/systemProblem') }}"><h4>{{ Lang::get('Admin/PageList.systemProblem') }} </h4></a></li>
		<li ><a href="{{ URL::to('admin/HDDestroy') }}"><h4>{{ '硬碟破壞系統' }} </h4></a></li>
		<li ><a href="{{ URL::to('admin/Readme/catagory') }}"><h4>{!! Lang::get('Admin/PageList.Readme') !!} </h4></a></li>
		<li ><a href="{{ URL::to('admin/authsoftIndex') }}"><h4>{!! Lang::get('Admin/PageList.manageauthsoftindex') !!} </h4></a></li>
		<li ><a href="{{ URL::to('admin/auth_soft/Category') }}"><h4>{!! Lang::get('Admin/PageList.softwareList') !!} </h4></a></li>

		<li ><a href="{{ URL::to('admin/auth_soft/isoUpload') }}"><h4>{!! Lang::get('Admin/PageList.softwareUpload') !!} </h4></a></li>
        <li><a href="{{URL::to('admin/Auth_soft/search')}}"><h4>{!! Lang::get('Admin/PageList.search_record') !!}</h4></a></li>
        <li><a href="{{URL::to('admin/Auth_soft/left')}}"><h4>{!! Lang::get('Admin/PageList.left_cd_record') !!}</h4></a></li>

      </ul>
    </div>
    <div id="admin-display" class="col-lg-10 " >
      @yield('modifyContent')
    </div>
  </div>
</div>
@stop
