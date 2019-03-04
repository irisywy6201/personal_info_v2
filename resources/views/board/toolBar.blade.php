@section('toolBar')

{!! Form::open(["url" => "msg_board/realTimeSearch", "method" => "post", "class" => "navbar-form real-time-search-bar", 'data-real-time-search-id' => 'message-board-real-time-search-bar']) !!}
  <!--  input text-->
  <div class="form-group">
    {!! Form::text('keyword', Input::old('keyword', ''), ['class' => 'form-control keyword', 'id' => 'input-text', 'placeholder' => Lang::get('searching.pleaseInputKeyword')]) !!}
  </div>

  <div class="form-group">
    <div class="dropdown" id="forDepartMenu">
      {!! Form::hidden('department', Input::old('department', '')) !!}
      <button class="btn navbar-btn btn-default navbar-content" id="department" name="department" data-toggle="dropdown" role="button"> 
        {{ Lang::get('messageBoard/board.plzSlectDepart') }}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel">
        @foreach($department as $key => $value)
          <li>
            <a id="{{$value->id}}">
              {{ Lang::get('category.' . $value->id . '.name')}}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="form-group">
    <div class="dropdown" id="forCategMenu">
      {!! Form::hidden('category', Input::old('category', '')) !!}
      <button class="btn navbar-btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button" disabled="disabled"> 
        {{ Lang::get('messageBoard/board.pFirstSelectDepart') }}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu menu-content" id="menu-0" role="menu" aria-labelledby="dLabel"></ul>
    </div>
  </div>

  <!-- dropdown menu status-->
  <div class="form-group">
    <div class="dropdown" id="forStatusMenu">
      {!! Form::hidden('status', Input::old('status', '')) !!}
      <button class="btn navbar-btn btn-default navbar-content" id="status" name="status" data-toggle="dropdown" role="button">
        {{ Lang::get('messageBoard/board.byStatus') }}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
        @foreach($statuses as $key => $status)
          <li>
            <a id="{{ $key }}">
              {{ Lang::get('messageBoard/status.' . $status) }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="form-group">
    <button class="btn btn-default btn-refresh" type="button">
      <span class="glyphicon glyphicon-refresh"></span>
      {{ Lang::get('searching.resetSearchBar') }}
    </button>
  </div>

  <div class="form-group">
    <span class="swoop sr-only loading"></span>
  </div>

  <div class="navbar-right">
    <a class="btn navbar-btn btn-primary" href="{{ URL::to('msg_board/create/') }}">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      {{ Lang::get('messageBoard/board.add_msg') }}
    </a>
  </div>
{!! Form::close() !!}

@show