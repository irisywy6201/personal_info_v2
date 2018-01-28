@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>
    <a class="btn btn-link" href="{{URL::to('admin/contactPerson/'.$contactPerson->id)}}">
      <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    {{ Lang::get('Admin/General.edit') }} {{ Lang::get('category.' . $contactPerson->category_id . '.name') }} {{ Lang::get('Admin/ContactPerson.contactPerson') }}
  </h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-right">
      {!! Form::open(['url' => '/admin/contactPerson/' .  $contactPerson->id, 'method' => 'delete', 'class' => 'navbar-form navbar-right']) !!}
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/ContactPerson.contactPerson')])
        <button class="btn b btn-danger btn-delete" type="button">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          刪除
        </button>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<h2 id="type-blockquotes">
  {{ Lang::get('category.' . $contactPerson->category_id . '.name') }}
</h2>
<blockquote> 
  {{ $contactPerson->user->username }} {{ $contactPerson->user->acct }} <br>
  @if($contactPerson->user->registered)
    {{ $contactPerson->user->email->address }}<br>
  @else
    {{ Lang::get('Admin/General.notRegisteredEmail')}}
    <span class="text-danger glyphicon glyphicon-remove"></span><br>
  @endif
  {{ Lang::get('contactPersonRolesDB.' . $contactPerson->contact_person_roles_id . '.name') }}
</blockquote>
<hr>
{!! Form::open(['url' => '/admin/contactPerson/' . $contactPerson->id, 'files' => false, 'method' => 'put', 'class' => 'form-horizontal']) !!}
  <fieldset>
    <div class="dropdown form-group">
      {!! Form::label(Lang::get('Admin/ContactPerson.changeContactPerson')) !!}
      <div class="dropdown">
        <button class="btn btn-default navbar-content" name="user" data-toggle="dropdown" role="button">
            {{ Lang::get('category.0.name') }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
          @foreach($user as $key => $value) 
            <li>
              <a id="{{$value->id}}">{{ $value->acct }}, {{ $value->username }}, 
                @if($value->registered == 0)
                    {{ Lang::get('Admin/General.notRegisteredEmail')}}
                    <span class="text-danger glyphicon glyphicon-remove"></span>
                  @else
                    {{ $value->email->address }}  
                    <span class="text-success glyphicon glyphicon-ok"></span>
                  @endif
                </a>
            </li>
          @endforeach
        </ul>
        <input name="user" type="hidden" value="{{$contactPerson->user_id}}">
      </div>
    </div>

    <div class="dropdown form-group">
      {!! Form::label(Lang::get('Admin/ContactPerson.changeContactPersonAuthority')) !!}
      <div class="dropdown">
        <button class="btn btn-default navbar-content" name="role" data-toggle="dropdown" role="button">
            {{ Lang::get('category.0.name') }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
          @foreach($roleMap as $key => $value) 
            <li><a id="{{ $value }}">{{ Lang::get('contactPersonRolesDB.' . $value .'.name') }}</a></li>
          @endforeach
        </ul>
        <input name="role" type="hidden" value="{{$contactPerson->role}}">
      </div>
    </div>
    <div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
      <label class="control-label" for="g-recaptcha-response">
        <span class="must-fill">*</span>
        {{ Lang::get('recaptcha.pleaseInputRecaptcha') }}
      </label>
      {!! Recaptcha::render() !!}
      {!! Form::close() !!}
      <label class="control-label has-error" for="g-recaptcha-response">
        @if($errors->has("g-recaptcha-response"))
          {{ $errors->first("g-recaptcha-response") }}
        @endif
      </label>
    </div>
  <div class="form-group">
    <button class="btn btn-default" type="submit" value="submit" >
      <span class="glyphicon glyphicon-pencil"></span>
      {{ Lang::get("Admin/General.submit") }}
    </button>
  </div>
  </fieldset>
{!! Form::close() !!}

@stop

