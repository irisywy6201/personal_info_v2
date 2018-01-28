@extends("admin.adminLayout")
@section("css")
.note-editable{
	height:500px;
}
@endsection
@section("modifyContent")

<div class="row text-center">
	<h3><a class="btn btn-link" href="{{URL::to('admin/authsoftIndex/')}}" >
		<span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>{{ $title }}</h3>
</div>


{!! Form::open(array("url" => array("/admin/authsoftIndex",$id),"files" => true, "method" => "put", "class" => "form-horizontal")) !!}
  <fieldset> 
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
       {{ Lang::get('Admin/Readme.indextitle_zh') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="indextitle_zh" value="{{$authsoftindex->indextitle_zh}}">
	</div>
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
       {{ Lang::get('Admin/Readme.indextitle_en') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="indextitle_en" value="{{$authsoftindex->indextitle_en}}">
    </div>


    <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Readme.indexcontent_zh") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="indexcontent_zh" >{{$authsoftindex->indexcontent_zh}}</textarea>
    </div>

     <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Readme.indexcontent_en") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="indexcontent_en" >{{$authsoftindex->indexcontent_en}}</textarea>
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