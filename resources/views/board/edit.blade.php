@extends("layout")
@section("content")

<div class="jumbotron">
  {!! Form::open(array("url" => "/msg_board/" . $id, "files" => true, "method" => "put", "class" => "form-horizontal")) !!}
    <fieldset>      
      <div class="form-group @if($errors->has('title')) has-error @endif">
        <label class="control-label" for="leavMsgTitl">
          <span class="must-fill">*</span>
          {{ Lang::get("messageBoard/board.title") }}
        </label>
        <input class="form-control mustFill" id="leavMsgTitl" name="title" type="text" value="{{ Input::old('title', $originValues->title) }}" placeholder="{{ Lang::get('messageBoard/board.titleHolder') }}">
        <label class="control-label has-error" for="leavMsgTitl">
          @if($errors->has("title"))
            {{ $errors->first("title") }}
          @endif
        </label>
      </div>

      @include("board.suggestionHelper")

      <div class="form-group @if($errors->has('department')) has-error @endif">
        <label for="leavMsgCateg">
          <span class="must-fill">*</span>
          {{ Lang::get("messageBoard/board.department") }}
        </label>
        <div id="forDepartMenu" class="dropdown">
          <input name="department" type="hidden" value="{{ Input::old('department', $originValues->department) }}" autocomplete="off">
          <button id="department" name="department" class="btn btn-default navbar-content" autocomplete="off" data-toggle="dropdown" role="button"> 
            {{ Lang::get('category.' . $originValues->department . '.name') }}
            <span class="caret"> </span>
          </button>
          <ul class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel">
              @foreach($department as $key => $value)
                <li> <a id="{{$value->id}}"> {{ Lang::get('category.' . $value->id . '.name')}} </a> </li>
              @endforeach
          </ul>
        </div>
        <label class="control-label has-error" for="leavMsgTitl">
          @if($errors->has("department"))
            {{ $errors->first("department") }}
          @endif
        </label>
      </div>
      <!--category -->
      <div class="form-group @if($errors->has('category')) has-error @endif">
        <label for="leavMsgCateg">
          <span class="must-fill">*</span>
          {{ Lang::get("messageBoard/board.category") }}
        </label>
        <div id="forCategMenu" class="dropdown">
          <input id="leavMsgCateg" name="category" type="hidden" value="{{ Input::old('category', $originValues['category_id']) }}">
          <button class="btn btn-default dropdown-toggle" id="category" name="category" data-toggle="dropdown" type="button">
            {{ Lang::get('category.' . $originValues->category_id . '.name') }}
            <span class="caret"></span>
          </button>
          <ul id="menu-0" class="dropdown-menu menu-content" data-target="#dropdownCategory" aria-labelledby="dropdownCategory" role="menu">
          </ul>
        </div>
        <label class="control-label has-error" for="leavMsgCateg">
          @if($errors->has("category"))
            {{ $errors->first("category") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('identity')) has-error @endif">
        <label for="leavMsgCateg">
          <span class="must-fill">*</span>
          {{ Lang::get("messageBoard/board.identity") }}
        </label>
        <input id="leavMsgCateg" name="identity" type="hidden" value="{{ Input::old('identity', 0) }}">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" id="dropdownCategory" name="identity" data-toggle="dropdown" type="button">
            {{ Lang::get("identity.0") }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" data-target="#dropdownCategory" aria-labelledby="dropdownCategory" role="menu">
            @foreach($identity as $key => $value)
              <li role="presentation">
                <a id="{{ $key }}" role="menuitem">
                  {{ $value }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <label class="control-label has-error" for="leavMsgCateg">
          @if($errors->has("identity"))
            {{ $errors->first("identity") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('content')) has-error @endif">
        <label class="control-label" for="leavMsgCont">
          <span class="must-fill">*</span>
          {{ Lang::get("messageBoard/board.contDesc") }}
        </label>
        {!! Form::textarea("content", Input::old("content", $originValues->content), ['class' => 'mustFill summernote', 'id' => 'leavMsgCont', 'placeholder' => Lang::get("messageBoard/board.contentHolder")]) !!}
        <label class="control-label has-error" for="leavMsgCont">
          @if($errors->has("content"))
            {{ $errors->first("content") }}
          @endif
        </label>
      </div>

      <div class="form-group">
        <label class="control-label" for="isSticky">
            {{ Lang::get('messageBoard/board.userHidden') }}
        </label>
        {!! Form::checkbox('isSticky') !!}
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

			<hr class="darker">

			<div class="form-group">
				<button type="submit" value="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-ok"></span>
					{{ Lang::get("messageBoard/board.update") }}
				</button>
				<a href="{{ URL::previous() }}" class="btn btn-default">
					<span class="glyphicon glyphicon-remove"></span>
					{{ Lang::get("messageBoard/board.cancel") }}
				</a>
			</div>
		</fieldset>
	{!! Form::close() !!}
</div>

@stop
