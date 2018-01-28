@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/management/'.$user->id)}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>
{!! Form::open(array("url" => "/admin/management/".$user->id, "files" => true, "method" => "PUT", "class" => "form-horizontal")) !!}
  <fieldset> 
    <div class="form-group">
      <label for="leavMsgCateg">
        {{ Lang::get('Admin/Management.changed_role') }}
      </label>
      <div class="dropdown" id="forDropdownMenu" >
        <button class="btn btn-default dropdown-toggle"  id="dropdownCategory" name="addrole" type="button" data-toggle="dropdown">
          {{ Lang::get('adminRole.' . $user->addrole) }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="addrole" data-target="#addrole">
          @foreach($roleList as $key => $value)
            <li role="presentation">
              <a id="{{ $key }}" role="menuitem">
                {{ $value }}
              </a>
            </li>
          @endforeach
        </ul>
        <input id="leavMsgCateg" type="hidden" name="addrole" value="{{ $user->addrole }}">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        {{ Lang::get('Admin/General.username') }}
      </label>
      <input class="form-control" id="leavMsgTitl" type="text" name="username" value="{{ $user->username }}">
    </div>
    <h2 id="type-blockquotes">{{ $user->acct }} {{ $user->username }} </h2>
    <blockquote>
      @if($user->registered == 0)
        {{ Lang::get('Admin/Management.notRegisteredEmail') }}
          <span class="text-danger glyphicon glyphicon-remove"></span>
      @else
        {{ $user->email->address }}
        <span class="text-success glyphicon glyphicon-ok"></span>
      @endif
      </br>
      {{ Lang::get('adminRole.'.$user->addrole) }}
    </blockquote>
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
    <div class="text-center">
      <div class="feedback text-center"></div>
      <button class="btn btn-block btn-success" type="submit" value="submit" >
        <span class="glyphicon glyphicon-pencil"></span>
        {{ Lang::get("Admin/General.submit") }}
      </button>
    </div>
  </fieldset>  
{!! Form::close() !!}

@stop