@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/systemProblem/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>


<h3>{{ Lang::get('Admin/General.email') }} :  {{ $systemProblem->email }}</h3>
<h3>{{ Lang::get('Admin/SystemProblem.problemContent') }} :  {{ $systemProblem->content }}</h3>


@if($systemProblem->isSolved == '0') 
{!! Form::open(array("url" => "/admin/systemProblem/".$systemProblem->id, "files" => true, "method" => "PUT", "class" => "form-horizontal")) !!}
	<fieldset>
		<div class="form-group">
			<label class="control-label" for="leavMsgCont">
				<span class="must-fill">*</span>
				{{ Lang::get("Admin/SystemProblem.solvedComment") }}
			</label>
			<span class="hidden-feedback help-block pull-right has-error">{{ Lang::get("formFeedback.mustFill") }}</span>
			<textarea class="mustFill summernote" id="leavMsgCont" name="comment" ></textarea>
		</div>
		<div class="form-group " >
			<label class="control-label" for="leavMsgTitl">
				<span class="must-fill">*</span>
				{{Lang::get('Admin/SystemProblem.feedback')}}
			</label>
			<input id="leavMsgTitl" type="text" name="feedback" class="form-control" >
		</div>
		<div class="form-group">
		 <button type="submit" class="btn btn-block btn-success">
			<span class="glyphicon glyphicon-pencil"></span>
		 	{{Lang::get('Admin/General.submit')}}
		 </button>
		</div>
	</fieldset>
{!! Form::close() !!}
@else 
<h3>{{ Lang::get('Admin/SystemProblem.solvedComment') }} :  {{ $systemProblem->solvedComment }}</h3>
<h3>{{ Lang::get('Admin/SystemProblem.solvedBy') }} :  {{ $solver }}</h3>
@endif

@stop