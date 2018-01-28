@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{ URL::to('admin/contactPerson') }}">
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>

{!! Form::open(["url" => "/admin/contactPerson/", "files" => false, "method" => "post", "class" => "form-horizontal"]) !!}
  <fieldset>
    <div class="form-group">
      <div class="dropdown">
        {!! Form::label(Lang::get('Admin/ContactPerson.selectCategoryPort')) !!}
        <div class="dropdown" id="forDropdownMenu">
          <button class="btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button">
              {{ Lang::get('dropdownMenu.initialOption') }}
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu menu-content" id="menu-0" aria-labelledby="dLabel" role="menu"></ul>
          <input class="form-control mustFill" name="category" type="hidden" value="">
        </div>
      </div>
    </div>


    {{-- <div class="form-group">
      <div class="dropdown">
        {{ Form::label(Lang::get('admin.assignedContactPerson')) }}
        <div class="dropdown">
          <button class="btn btn-default navbar-content" name="user" data-toggle="dropdown" role="button">
            {{ Lang::get('dropdownMenu.initialOption') }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
            @foreach($user as $key => $value) 
              <li>
                <a id="{{$value->id}}">{{ $value->acct }},&nbsp;{{ $value->username }} 
                  @if($value->registered == 0)
                    {{ Lang::get('admin.notRegisteredEmail') }}
                    <span class="text-danger glyphicon glyphicon-remove"></span>
                  @else
                    {{ $value->email->address }}
                    <span class="text-success glyphicon glyphicon-ok"></span>
                  @endif
                </a>
              </li>
            @endforeach
          </ul>
          <input name="user" type="hidden" value="0">
        </div>
      </div>
    </div>
 --}}

  <div class="form-group">
      <div class="dropdown">
        {!! Form::label(Lang::get('Admin/ContactPerson.contactPersonAuthority')) !!}
        <div class="dropdown">
          <button class="btn btn-default navbar-content" name="role" data-toggle="dropdown" role="button">
            {{ Lang::get('dropdownMenu.initialOption') }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
            @foreach($roleMap as $key => $value) 
              <li>
                <a id="{{ $value }}">
                  {{ Lang::get('contactPersonRolesDB.' . $value . '.name') }}
                </a>
              </li>
            @endforeach
          </ul>
          <input class="form-control mustFill" name="role" type="hidden" value="">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
          {!! Form::label(Lang::get('Admin/ContactPerson.assignedContactPerson')) !!} ({{ Lang::get('Admin/General.account') }})
        </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="acct"}}>
    </div>
    

    <div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
      <label class="control-label" for="g-recaptcha-response">
        <span class="must-fill">*</span>
        {{ Lang::get('recaptcha.pleaseInputRecaptcha') }}
      </label>
      {!! Recaptcha::render() !!}
      <label class="control-label has-error" for="g-recaptcha-response">
        @if($errors->has("g-recaptcha-response"))
          {{ $errors->first("g-recaptcha-response") }}
        @endif
      </label>
    </div>
    <div class="text-center">
      <div class="feedback text-center"></div>
      <button class="btn btn-block btn-default" type="submit" value="submit" >
        <span class="glyphicon glyphicon-pencil"></span>
        {{ Lang::get("Admin/General.submit") }}
      </button>
    </div>
  </fieldset>
{!! Form::close() !!}

@stop