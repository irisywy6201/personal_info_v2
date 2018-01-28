@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
	<h3><a class="btn btn-link" href="{{URL::to('admin/Readme/catagory')}}" >
		<span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>{{ $title }}</h3>
</div>

{!! Form::open(['url' => '/admin/Readme/catagory/store', 'files' => false, 'method' => 'post', 'class' => 'form-horizontal']) !!}
  <fieldset> 
  
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
       {{ Lang::get('Admin/Readme.doccategory_name_zh') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="doccategory_name_zh">
    </div>
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{ Lang::get('Admin/Readme.doccategory_name_en') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="doccategory_name_en">
    </div>
	
	<div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{ Lang::get('Admin/Readme.doccategory_discribe_zh') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="doccategory_discribe_zh">
    </div>
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{ Lang::get('Admin/Readme.doccategory_discribe_en') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="doccategory_discribe_en">
    </div>


    <br>
    <div class="text-center">
      <div class="feedback text-center"></div>
      <button class="btn btn-block btn-success" type="submit" value="submit" >
        <span class="glyphicon glyphicon-ok"></span>
        {{ Lang::get("Admin/General.submit") }}
      </button>
    </div>
  </fieldset>  
{!! Form::close() !!}

<script>
	$('.summernote').summernote({
	  height: 650,   //set editable area's height
	  codemirror: { // codemirror options
		theme: 'monokai'
	  }
	});
</script>

@stop