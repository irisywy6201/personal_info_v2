@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/management/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-right">
      {!! Form::open(["url"=>"/admin/management/". $user->id, "method" => "DELETE", "class" => "navbar-form navbar-right"]) !!}
        <a href="{{URL::to('admin/management/'.$user->id.'/edit')}}" class="btn btn-success">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          {{ Lang::get('Admin/Management.modifyUser') }}
        </a>
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/Management.user')])
        
        <button class="btn btn-danger btn-delete" type="button">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          {{ Lang::get('Admin/General.delete' ) }}
        </button>
      {!! Form::close() !!}
    </div>
  </div>
</div>  
<hr>
<h2>{{ $user->username }} </h2>
<h2>{{ $user->acct }} </h2>
<blockquote>
  {{ Lang::get('adminRole.'.$user->role) }} <br>
  {{ Lang::get('adminRole.'.$user->addrole) }} <br>
  @if($user->registered == 0)
    {{ Lang::get('admin.notRegisteredEmail') }}
     <span class="text-danger glyphicon glyphicon-remove"></span>
  @else
    {{ $user->email->address }}
    <span class="text-success glyphicon glyphicon-ok"></span>
  @endif 
</blockquote>

@stop