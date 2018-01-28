@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/faq/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>
{!! Form::open(array("url" => "/admin/faq/", "files" => true, "method" => "POST", "class" => "form-horizontal")) !!}
  <fieldset>
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{Lang::get('Admin/Faq.faqName')}}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="name"  placeholder={{ Lang::get("Admin/Faq.titleHolder") }}>
    </div>

    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{Lang::get('Admin/Faq.faqName_en')}}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="name_en"  placeholder={{ Lang::get("Admin/Faq.titleHolder_en") }}>
    </div>

    <div class="form-group">
      <label class="control-label" for="leavMsgCateg">
        <span class="must-fill">*</span>
        {{Lang::get('Admin/Category.category')}}
      </label>
      <span class="hidden-feedback help-block has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <div class="dropdown" id="forDropdownMenu" >
        <button class="btn btn-default dropdown-toggle"  id="dropdownCategory" name="category" type="button" data-toggle="dropdown">
          {{ Lang::get('Admin/Category.selectCategory' ) }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" id="menu-0" role="menu" aria-labelledby="dropdownCategory" data-target="#dropdownCategory">
        </ul>
        <input class="form-control mustFill" id="leavMsgCateg" type="hidden" name="category" value="">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Faq.faqAnswer") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="answer"  placeholder="{{ Lang::get('Admin/Faq.contentHolder') }}"></textarea>
    </div>

    <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Faq.faqAnswer_en") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="answer_en"  placeholder="{{ Lang::get('Admin/Faq.contentHolder_en') }}"></textarea>
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