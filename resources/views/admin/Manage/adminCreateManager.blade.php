@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/management/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>
{!! Form::open(array("url" => "/admin/management/", "files" => true, "method" => "POST", "class" => "form-horizontal")) !!}
  <fieldset> 
    <div class="form-group">
      <label for="leavMsgCateg">
        {{Lang::get('Admin/General.identity')}}
      </label>
      <div class="dropdown" id="forDropdownMenu" >
        <button class="btn btn-default dropdown-toggle" name="addrole" type="button" data-toggle="dropdown">
          {{ Lang::get('Admin/Management.selectAttachedRole' ) }}
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
        <input id="leavMsgCateg" type="hidden" name="addrole" value="{{ Input::old('addrole') }}">
        <label class="control-label has-error" for="leavMsgTitl">
          @if($errors->has("addrole"))
            {{ $errors->first("addrole") }}
          @endif
        </label>
      </div>
    </div>

    <div class="form-group @if($errors->has('acct')) has-error @endif">
      <label class="control-label" for="leavMsgTitl">
          <span class="must-fill">*</span>
          {{Lang::get('Admin/General.account')}}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="acct" value="{{ Input::old('acct') }}">
      <label class="control-label has-error" for="leavMsgTitl">
        @if($errors->has("acct"))
          {{ $errors->first("acct") }}
        @endif
      </label>
    </div>

    <div class="form-group @if($errors->has('email')) has-error @endif">
      <label class="control-label" for="email">
        <span class="must-fill">*</span>
        {{ Lang::get('Admin/General.email') }}
      </label>
      <input class="form-control mustFill" id="email" type="text" name="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('backupMail.emailPlaceHolder') }}">
      <label class="control-label has-error" for="leavMsgTitl">
        @if($errors->has("email"))
          {{ $errors->first("email") }}
        @endif
      </label>
    </div>

    <div class="form-group">
      <label class="control-label has-error" for="leavMsgTitl">
        {{Lang::get('Admin/General.username')}}
      </label>
      <input class="form-control" id="leavMsgTitl" type="text" name="username">
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

    <div class="text-center">
      <div class="feedback text-center"></div>
      <button class="btn btn-block btn-success" type="submit" value="submit" >
        <span class="glyphicon glyphicon-ok"></span>
        {{ Lang::get("Admin/General.submit") }}
      </button>
    </div>
  </fieldset>  
{!! Form::close() !!}

@stop