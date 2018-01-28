@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
	<h3><a class="btn btn-link" href="{{URL::to('admin/announcement/')}}" >
		<span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	</a>{{ $title }}</h3>
</div>
{!! Form::open(['url' => ['/admin/announcement', $announcement->id], 'files' => false, 'method' => 'put', 'class' => 'form-horizontal']) !!}
	<fieldset>
		<div class="form-group">
			<label class="control-label" for="leavMsgTitl">
				<span class="must-fill">*</span>
				{{ Lang::get('Admin/Announcement.announceUser') }} : {{ $announcement->announceUser }}
			</label>
		</div>
		<div class="form-group">
			<label class="control-label" for="leavMsgTitl">
				<span class="must-fill">*</span>
				{{ Lang::get('Admin/Announcement.title') }}
			</label>
			<input id="leavMsgTitl" type="text" name="title" class="form-control" placeholder="{{Lang::get('Admin/Announcement.titleHolder')}}" value="{{ $announcement->title }}">
		</div>

		<div class="form-group">
			<label class="control-label" for="leavMsgTitl">
				{{ Lang::get('Admin/Announcement.link') }}
			</label>
			<input id="leavMsgTitl" type="text" name="link" class="form-control" placeholder="{{Lang::get('Admin/Announcement.linkHolder')}}" value="{{ $announcement->link }}">
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
			<div class="feedback text-center"></div>
			<button type="submit" value="submit" class="btn btn-block btn-success">
				<span class="glyphicon glyphicon-pencil"></span>
				{{ Lang::get("Admin/General.submit") }}
			</button>
		</div>
	</fieldset>
{!! Form::close() !!}


@stop
