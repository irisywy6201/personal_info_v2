@extends("layout")
@section("content")

<!-- previous page -->
<div class="text-right">
  <a class="btn btn-lg btn-default" href="{{ URL::to('/deskRecord/?page='.Session::get('pageNum'))}}">
    <span class="glyphicon glyphicon-circle-arrow-left"></span>
    回列表
  </a>
</div>
<br>
<div class="detail-section-background jumbotron">
  {!! Form::open(['url' => '/deskRecord/'.$editId.'', 'files' => true, 'method' => 'patch', 'class' => 'form-horizontal']) !!}
    <fieldset>

      <!--category -->
      <div class="form-group @if($errors->has('category')) has-error @endif">
        <label for="sdRecCateg">
          <span class="must-fill">*</span>
          {{ Lang::get('sdRecord/board.category') }}
        </label>
        <div id="forCategMenu" class="dropdown">
          <input id="sdRecCateg" name="category" type="hidden" value="{{ $records->category }}">
          <button class="btn btn-default dropdown-toggle" id="category" name="category" data-toggle="dropdown" type="button">
            {{ $categoryTitle->name }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" data-target="#category" aria-labelledby="dropdownCategory" role="menu">
            @foreach($category as $key => $value)
              <li role="presentation">
                <a id="{{ $value->id }}" role="menuitem">
                  {{ $value->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <label class="control-label has-error" for="sdRecCateg">
          @if($errors->has('category'))
            {{ $errors->first('category') }}
          @endif
        </label>
      </div>
      <!-- user_category -->
      <div class="form-group @if($errors->has('user_category')) has-error @endif">
        <label for="sdRecUser">
          <span class="must-fill">*</span>
          {{ Lang::get('sdRecord/board.user_category') }}
        </label>
        <input id="sdRecUserCat" name="user_category" type="hidden" value="{{ $records->user_category }}">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" id="dropdownUserCategory" name="user_category" data-toggle="dropdown" type="button">
            {{ $userCategoryTitle->user }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" data-target="#dropdownUserCategory" aria-labelledby="dropdownUserCategory" role="menu">
            @foreach($user_category as $key => $value)
              <li role="presentation">
                <a id="{{ $value->id }}" role="menuitem">
                  {{ $value->user }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <label class="control-label has-error" for="sdRecUserCat">
          @if($errors->has('user_category'))
            {{ $errors->first('user_category') }}
          @endif
        </label>
      </div>

      <!-- record time -->
      <div class="form-group @if($errors->has('datetimepicker')) has-error @endif">
        <label for="sdRecTime">
          <span class="must-fill">*</span>
            {{ Lang::get('sdRecord/board.recordTime') }}
        </label>
        <label class="control-label has-error" for="sdRecTime">
          @if($errors->has('datetimepicker'))
            &nbsp&nbsp&nbsp
            <span class="glyphicon glyphicon-info-sign"></span>
              {{ $errors->first('datetimepicker') }}
          @endif
        </label>
        <div>
          {!! Form::text('datetimepicker', $recordTime, ['id' => 'datetimepicker', 'class' => 'mustFill form-control']) !!}
        </div>
      </div>

      <!-- content description -->
      <div class="form-group @if($errors->has('sdRecCont')) has-error @endif">
        <label for="sdRecCont">
          <span class="must-fill">*</span>
          {{ Lang::get('sdRecord/board.contDescribe') }}
        </label>
        <label class="control-label has-error" for="sdRecCont">
          @if($errors->has('sdRecCont'))
            &nbsp&nbsp&nbsp
            <span class="glyphicon glyphicon-info-sign"></span>
            {{ $errors->first('sdRecCont') }}
          @endif
        </label>
        <div>
          {!! Form::textarea('sdRecCont', $records->sdRecCont, ['class' => 'mustFill form-control','rows' => 6, 'id' => 'sdRecCont', 'placeholder' => Lang::get('sdRecord/board.contentHolder')]) !!}
        </div>
      </div>
      <!-- solution -->
      <div class="form-group @if($errors->has('solution')) has-error @endif">
        <label for="sdRecSol">
          <span class="must-fill">*</span>
          {{ Lang::get('sdRecord/board.solution') }}
        </label>
        <input id="sdRecSol" name="solution" type="hidden" value="{{ $records->solution }}">
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" id="dropdownSolution" name="solution" data-toggle="dropdown" type="button">
            {{ $solutionTitle->method }}
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" data-target="#dropdownSolution" aria-labelledby="dropdownSolution" role="menu">
            @foreach($solution as $key => $value)
              <li role="presentation">
                <a id="{{ $value->id }}" role="menuitem">
                  {{ $value->method }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <label class="control-label has-error" for="sdRecSol">
          @if($errors->has('solution'))
            {{ $errors->first('solution') }}
          @endif
        </label>
      </div>
      <!-- user_id -->
      <div class="form-group @if($errors->has('user_id')) has-error @endif">
        <label class="control-label" for="sdRecUserId">
          <!-- <span class="smust-fill">*</span> -->
          {{ Lang::get('sdRecord/board.userId') }}
        </label>
        <input class="form-control" id="sdRecUserId" name="user_id" type="text" value="{{ Input::old('user_id', $records->user_id) }}" placeholder="{{ Lang::get('sdRecord/board.userInfoHolder') }}">
        <label class="control-label has-error" for="sdRecUserId">
          @if($errors->has('user_id'))
            {{ $errors->first('user_id') }}
          @endif
        </label>
      </div>
      <!-- user_contact -->
      <div class="form-group @if($errors->has('user_contact')) has-error @endif">
        <label class="control-label" for="sdRecUserContact">
          <!-- <span class="must-fill">*</span> -->
          {{ Lang::get('sdRecord/board.userContact') }}
        </label>
        <input class="form-control" id="sdRecUserContact" name="user_contact" type="text" value="{{ $records->user_contact }}" placeholder="{{ Lang::get('sdRecord/board.userContactHolder') }}">
        <label class="control-label has-error" for="sdRecUserContact">
          @if($errors->has('user_contact'))
            {{ $errors->first('user_contact') }}
          @endif
        </label>
      </div>

      <hr class="darker">
      <div class="form-group text-center">
        <button class="btn btn-block btn-lg btn-success" type="submit" value="submit">
          <span class="glyphicon glyphicon-floppy-disk"></span>
          {{ Lang::get('sdRecord/board.save') }}
        </button>
      </div>
    </fieldset>
  {!! Form::close() !!}
</div>

{!! HTML::script('js/sdRecord/recordTimePicker.js') !!}

@endsection
