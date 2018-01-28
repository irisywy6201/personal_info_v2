@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>

@if($contactPerson)
  <div class="navbar" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="btn navbar-btn btn-primary" href="{{URL::to('admin/contactPerson/create')}}">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            {{ Lang::get('Admin/ContactPerson.createContactPerson') }}
          
        </a>
      </div>
    </div>
  </div>  

  {!! Form::open(["url" => "admin/contactPerson/search", "class" => "form-inline"]) !!}
    <!--  input text-->
    <div class="form-group">
      <h4>{{ Lang::get("Admin/General.search") }}</h4>
    </div>

    <!-- dropdown menu category-->
    <div class="dropdown form-group" id="forDropdownMenu" >
      <button class="btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button">
        @if($parent == 0)
          {{ Lang::get("Admin/General.department") }}
        @else
          {{ Lang::get('category.'.$parent.'.name') }}
        @endif
        <span class="caret"></span>
      </button>
      <ul id="menu-0" class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu"></ul>
      {!! Form::hidden('category','0') !!}
    </div>
    <div class="form-group">
      {!! Form::button(Lang::get('Admin/General.search'), ['class' => 'btn btn-success', 'type' => 'sumbit'], 'sumbit') !!}
      {!! HTML::link(URL::to('admin/contactPerson/'), Lang::get('Admin/General.cancelSearch'), ['class' => 'btn btn-danger']) !!}
    </div>
  {!! Form::close() !!}
  <br>
  <table class="table table-hover table-condensed">
    <tr>
      <th>#</th>
      <th>{{ Lang::get('Admin/General.category') }}</th>
      <th>{{ Lang::get('Admin/ContactPerson.contactPersonAuthority') }}</th>
      <th>{{ Lang::get('Admin/ContactPerson.contactPerson') }}</th>
      <th>{{ Lang::get('Admin/General.username') }}</th>
      <th>{{ Lang::get('Admin/General.email') }}</th>
      <th></th>
    </tr>
    <tbody>
      @foreach($contactPerson as $key => $value) 
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ Lang::get('category.'.$value->category_id.'.name') }}</td>
        <td>{{ Lang::get('contactPersonRolesDB.'.$value->contact_person_roles_id.'.name') }}</td>
        <td>{{ $value->user->acct }}</td>
        <td>{{ $value->user->username }}</td>
        @if($value->user->registered) 
          <td>{{ $value->user->email->address }}</td>
        @else
          <td></td>
        @endif
        <td>
          <a class="btn btn-default" href="{{ URL::to('admin/contactPerson/'. $value->id) }}">
            {{ Lang::get('Admin/General.detail') }}
          </a>
        </td>
      </tr>
      @endforeach
  
    </tbody>
  </table>
@else
  <div class="text-center">
    <h1 class="text-warning">
      <span class="glyphicon glyphicon-exclamation-sign"></span>
      {{ Lang::get('admin.noContactPerson') }}
    </h1>
    <br>
    <br>
    <a class="btn btn-lg btn-default" href="{{{ URL::to('admin/contactPerson/create') }}}">
      <span class="glyphicon glyphicon-plus"></span>
      {{ Lang::get('admin.createContactPerson') }}
    </a>
  </div>
@endif

@stop