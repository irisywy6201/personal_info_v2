@extends("admin.adminLayout")
@section("css")
.note-editable{
	height:500px;
}
@endsection
@section("modifyContent")

<div class="row text-center">
	<h3><a class="btn btn-link" href="{{URL::to('admin/Readme/catagory')}}" >
		<span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>{{ $title }}</h3>
</div>


{!! Form::open(array("url" => array("/admin/Readme/kmsreadme",$id),"files" => true, "method" => "put", "class" => "form-horizontal")) !!}
  <fieldset> 
	
	<div class="form-group">
		<label class="control-label control-label" style="float:left">
        <span class="must-fill">*</span>
       {{ Lang::get('Admin/Readme.Doccatagory') }}
        </label>
		<label class="col-sm-2 control-label">
			<div class="dropdown" style="display:inline;">
				<button  class="btn btn-primary dropdown-toggle active" type="button" data-toggle="dropdown" >{{ Lang::get('Admin/Readme.Doccatagory') }}
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
				@foreach( $readmecatagory as $category )
					<li onclick="choose1('{{$category->id}}')"><a>{{$category->doccategory_name_zh}}</a></li>
				@endforeach
				</ul>  
			</div>
		</label>
    </div>		
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
		{{ Lang::get('Admin/Readme.title_zh') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="title_zh" value="{{$readme->title_zh}}">  
	</div>
	
    <div class="form-group">
      <label class="control-label" for="leavMsgTitl">
        <span class="must-fill">*</span>
        {{ Lang::get('Admin/Readme.title_en') }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <input class="form-control mustFill" id="leavMsgTitl" type="text" name="title_en" value="{{$readme->title_en}}"> 
	</div>


    <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Readme.content_zh") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="Content_zh" style="height:500px">{{$readme->Content_zh}}</textarea>
    </div>

    <div class="form-group">
      <label class="control-label" for="leavMsgCont">
        <span class="must-fill">*</span>
        {{ Lang::get("Admin/Readme.content_en") }}
      </label>
      <span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
      <textarea class="mustFill summernote" id="leavMsgCont" name="Content_en" style="height:500px">{{$readme->Content_en}}</textarea>
    </div>
    <br>
		<input type="hidden"  id="category" name="doccatagory_id" value="0" />
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
	function choose1(num){
		document.getElementById('category').value=num;
	}

	$('.summernote').summernote({
	  height: 650,   
	  codemirror: { 
		theme: 'monokai'
	  }
	});
</script>

@stop