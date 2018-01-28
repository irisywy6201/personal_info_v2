@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/contactPerson/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a> {{ Lang::get('category.'.$contactPerson->category_id.'.name') }} {{ Lang::get('Admin/ContactPerson.contactPerson')}}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-right">
      {!! Form::open(["url"=>"/admin/contactPerson/". $contactPerson->id, "method" => "DELETE", "class" => "navbar-form navbar-right"]) !!}
        <a href="{{URL::to('admin/contactPerson/'.$contactPerson->id.'/edit')}}" class="btn btn-primary">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          {{ Lang::get('Admin/ContactPerson.changeContactPerson')}}
        </a>
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
        <button class="btn btn-danger btn-delete" type="button">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          刪除
        </button>
      {!! Form::close() !!}
    </div>
  </div>
</div>  
<hr>
<h2 id="type-blockquotes">{{ Lang::get('category.'.$contactPerson->category_id.'.name') }}</h2>
<blockquote> 
  {{ $contactPerson->user->username }} {{ $contactPerson->user->acct }} <br>
  @if($contactPerson->user->registered) 
    {{ $contactPerson->user->email->address }} <br>
  @else
     {{ Lang::get('Admin/General.notRegisteredEmail')}}
    <span class="text-danger glyphicon glyphicon-remove"></span><br>
  @endif
  {{ Lang::get('contactPersonRolesDB.'.$contactPerson->contact_person_roles_id.'.name') }}
</blockquote>

@stop