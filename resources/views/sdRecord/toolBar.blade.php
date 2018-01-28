@section('toolBar')
  <!-- filter search -->
  {!! Form::open(["url" => "deskRecord/filterSearch", "method" => "get", "class" => "form-inline search-bar-inline filter-search"]) !!}

  <!-- category filter -->
  <div class="form-group category-filter">
    <div class="dropdown">
      <input type="hidden" name="filter_category" value="{{ Input::old('category',0) }}">
      <button class="btn btn-default dropdown-toggle" id="category" name="filter_category" data-toggle="dropdown" role="button">
        @if(Input::old('category')== '' )
          {{ Lang::get('sdRecord/board.firstSelectCat') }}
          <span class="caret"></span>
        @else
          @foreach($category as $key => $value)
            @if($value->id == Input::old('category'))
               {{ $value->name }}
              <span class="caret"></span>
            @endif
          @endforeach
        @endif
      </button>
      <ul class="dropdown-menu menu-content scollable-list" data-target="#category" aria-labelledby="dropdownCategory" role="menu">
        @foreach($category as $key => $value)
          <li role="presentation">
            <a id="{{ $value->id }}" role="menuitem">
              {{ $value->name }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- user category filter -->
  <div class="form-group category-filter">
    <div class="dropdown">
      <input type="hidden" name="filter_user_category" value="{{ Input::old('u_category', 0) }}">
      <button class="btn btn-default dropdown-toggle" id="user_category" name="filter_user_category" data-toggle="dropdown" role="button">
        @if(Input::old('u_category')== '' )
          {{ Lang::get('sdRecord/board.firstSelectUsrCat') }}
          <span class="caret"></span>
        @else
          @foreach($u_category as $key => $value)
            @if($value->id == Input::old('u_category'))
               {{ $value->user }}
              <span class="caret"></span>
            @endif
          @endforeach
        @endif
      </button>
      <ul class="dropdown-menu menu-content scollable-list" data-target="#user_category" aria-labelledby="dropdownUserCategory" role="menu">
        @foreach($u_category as $key => $value)
          <li role="presentation">
            <a id="{{ $value->id }}" role="menuitem">
              {{ $value->user }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- solution category filter -->
  <div class="form-group category-filter">
    <div class="dropdown">
      <input type="hidden" name="filter_solution" value="{{ Input::old('solution', 0) }}">
      <button class="btn btn-default dropdown-toggle" id="solution_category" name="filter_solution" data-toggle="dropdown" role="button">
        @if(Input::old('solution')== '' )
          {{ Lang::get('sdRecord/board.firstSelectSol') }}
          <span class="caret"></span>
        @else
          @foreach($solution as $key => $value)
            @if($value->id == Input::old('solution'))
               {{ $value->method }}
              <span class="caret"></span>
            @endif
          @endforeach
        @endif
      </button>
      <ul class="dropdown-menu menu-content scollable-list" data-target="#solution_category" aria-labelledby="dropdownSolutionCategory" role="menu">
        @foreach($solution as $key => $value)
          <li role="presentation">
            <a id="{{ $value->id }}" role="menuitem">
              {{ $value->method }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- department category filter -->
  <div class="form-group category-filter">
    <div class="dropdown">
      <input type="hidden" name="filter_department" value="{{ Input::old('department', 0) }}">
      <button class="btn btn-default dropdown-toggle" id="department_category" name="filter_department" data-toggle="dropdown" role="button">
        @if(Input::old('department')== '' )
          {{ Lang::get('sdRecord/board.firstSelectDep') }}
          <span class="caret"></span>
        @else
          @foreach($department as $key => $value)
            @if($value->id == Input::old('department'))
               {{ $value->name }}
              <span class="caret"></span>
            @endif
          @endforeach
        @endif
      </button>
      <ul class="dropdown-menu menu-content scollable-list" data-target="#department_category" aria-labelledby="dropdownDepartmentCategory" role="menu">
        @foreach($department as $key => $value)
          <li role="presentation">
            <a id="{{ $value->id }}" role="menuitem">
              {{ $value->name }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="form-group btn-group">
    <button class="btn btn-success btn-refresh" type="submit">
      <span class="fa fa-search"></span>
      {{ Lang::get('sdRecord/board.searchFilter') }}
    </button>
    <a href="/deskRecord" class="btn btn-danger">
      <span class="glyphicon glyphicon-refresh"></span>
      {{ Lang::get('sdRecord/board.resetFilter') }}
    </a>
  </div>
  {!! Form::close() !!}
  <!-- <span class="verticalDivider" display="none"></span> -->
  <!-- realTimeSearch for keywords -->
   <!-- {!! Form::open(["url" => "deskRecord/realTimeSearch", "method" => "post", "class" => "navbar-form real-time-search-bar search-bar-inline", 'data-real-time-search-id' => 'sdRecord-real-time-search-bar']) !!} -->
    <!--  search text text-->
    <!-- <div class="form-group">
      {!! Form::text('keyword', Input::old('keyword', ''), ['class' => 'form-control keyword', 'id' => 'input-text', 'placeholder' => Lang::get('searching.pleaseInputKeyword')]) !!}
    </div>
    <div class="form-group">
      <button class="btn btn-danger btn-refresh" type="button">
        <span class="glyphicon glyphicon-refresh"></span>
        {{ Lang::get('sdRecord/board.resetKeyword') }}
      </button>
    </div>
    <div class="form-group">
      <span class="swoop sr-only loading"></span>
    </div> -->
  <!-- {!! Form::close() !!} -->
<br>
<!-- create and export buttons -->
  <div class="navbar-right btn-group">
    <a class="btn navbar-btn btn-primary" href="{{ URL::to('deskRecord/create/') }}">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      {{ Lang::get('sdRecord/board.add_rec') }}
    </a>
    @if(Auth::user()->isAdmin())
      <button class="btn navbar-btn btn-success" data-toggle="modal" data-target="#exportExcel" data-id="{{ 'export' }}">
        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
        {{ Lang::get('sdRecord/board.excel') }}
      </button>
    @endif
  </div>

  @if(Auth::user()->isAdmin())
  <!-- Export excel modal -->
  <input id="sdRecExcel" name="sdRecExcel" type="hidden" value="" data-token="{{ csrf_token() }}">
  <div class="modal fade" id="exportExcel" tabindex="-1" role="dialog" aria-labelledby="exportExcelLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h3 class="modal-title" id="exportExcelLabel">{{ Lang::get('sdRecord/board.excel') }}</h3>
          {!! Form::open(array("url" => "deskRecord/excel/export" ,"method" => "post", "class" => "form-horizontal")) !!}
            <div class="text-left">
              <h3><span class="label label-primary">輸出時間: </span></h3>
              <div class="input-daterange input-group from-group" id="datepicker">
                <span class="input-group-addon">From</span>
                <input type="text" class="form-control" name="start" value="{{$startDate}}" />
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="end" value="{{$endDate}}"/>
              </div>

              <h3><span class="label label-primary">輸出篩選: </span></h3>

              <!-- category filter -->
              <div class="category-filter">
                <h4><span class="label label-info">{{ Lang::get('sdRecord/board.category') }}: </span></h4>
                <div class="dropdown">
                  <input type="hidden" name="filter_category" value="{{ Input::old('category',0) }}">
                  <button class="btn btn-default dropdown-toggle" id="category" name="filter_category" data-toggle="dropdown" role="button">
                    @if(Input::old('category')== '' )
                      {{ Lang::get('sdRecord/board.firstSelectFilter') }}
                      <span class="caret"></span>
                    @else
                      @foreach($category as $key => $value)
                        @if($value->id == Input::old('category'))
                           {{ $value->name }}
                          <span class="caret"></span>
                        @endif
                      @endforeach
                    @endif
                  </button>
                  <ul class="dropdown-menu menu-content scollable-list" data-target="#category" aria-labelledby="dropdownCategory" role="menu">
                    <li role="presentation">
                      <a id="0" role="menuitem">
                        全部
                      </a>
                    </li>
                    @foreach($category as $key => $value)
                      <li role="presentation">
                        <a id="{{ $value->id }}" role="menuitem">
                          {{ $value->name }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <!-- user category filter -->
              <div class="category-filter">
                <h4><span class="label label-info">{{ Lang::get('sdRecord/board.user_category') }}: </span></h4>
                <div class="dropdown">
                  <input type="hidden" name="filter_user_category" value="{{ Input::old('u_category', 0) }}">
                  <button class="btn btn-default dropdown-toggle" id="user_category" name="filter_user_category" data-toggle="dropdown" role="button">
                    @if(Input::old('u_category')== '' )
                      {{ Lang::get('sdRecord/board.firstSelectFilter') }}
                      <span class="caret"></span>
                    @else
                      @foreach($u_category as $key => $value)
                        @if($value->id == Input::old('u_category'))
                           {{ $value->user }}
                          <span class="caret"></span>
                        @endif
                      @endforeach
                    @endif
                  </button>
                  <ul class="dropdown-menu menu-content scollable-list" data-target="#user_category" aria-labelledby="dropdownUserCategory" role="menu">
                    <li role="presentation">
                      <a id="0" role="menuitem">
                        全部
                      </a>
                    </li>
                    @foreach($u_category as $key => $value)
                      <li role="presentation">
                        <a id="{{ $value->id }}" role="menuitem">
                          {{ $value->user }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <!-- solution category filter -->
              <div class="category-filter">
                <h4><span class="label label-info">{{ Lang::get('sdRecord/board.solution') }}: </span></h4>
                <div class="dropdown">
                  <input type="hidden" name="filter_solution" value="{{ Input::old('solution', 0) }}">
                  <button class="btn btn-default dropdown-toggle" id="solution_category" name="filter_solution" data-toggle="dropdown" role="button">
                    @if(Input::old('solution')== '' )
                      {{ Lang::get('sdRecord/board.firstSelectFilter') }}
                      <span class="caret"></span>
                    @else
                      @foreach($solution as $key => $value)
                        @if($value->id == Input::old('solution'))
                           {{ $value->method }}
                          <span class="caret"></span>
                        @endif
                      @endforeach
                    @endif
                  </button>
                  <ul class="dropdown-menu menu-content scollable-list" data-target="#solution_category" aria-labelledby="dropdownSolutionCategory" role="menu">
                    <li role="presentation">
                      <a id="0" role="menuitem">
                        全部
                      </a>
                    </li>
                    @foreach($solution as $key => $value)
                      <li role="presentation">
                        <a id="{{ $value->id }}" role="menuitem">
                          {{ $value->method }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>

              <!-- department category filter -->
              <div class="category-filter">
                <h4><span class="label label-info">{{ Lang::get('sdRecord/board.department') }}: </span></h4>
                <div class="dropdown">
                  <input type="hidden" name="filter_department" value="{{ Input::old('department', 0) }}">
                  <button class="btn btn-default dropdown-toggle" id="department_category" name="filter_department" data-toggle="dropdown" role="button">
                    @if(Input::old('department')== '' )
                      {{ Lang::get('sdRecord/board.firstSelectFilter') }}
                      <span class="caret"></span>
                    @else
                      @foreach($department as $key => $value)
                        @if($value->id == Input::old('department'))
                           {{ $value->name }}
                          <span class="caret"></span>
                        @endif
                      @endforeach
                    @endif
                  </button>
                  <ul class="dropdown-menu menu-content scollable-list" data-target="#department_category" aria-labelledby="dropdownDepartmentCategory" role="menu">
                    <li role="presentation">
                      <a id="0" role="menuitem">
                        全部
                      </a>
                    </li>
                    @foreach($department as $key => $value)
                      <li role="presentation">
                        <a id="{{ $value->id }}" role="menuitem">
                          {{ $value->name }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>

            </div>
            <br>
            <div class="text-right">
              <button type="submit" name="button" class="btn btn-success btn-lg glyphicon glyphicon-ok"> {{ Lang::get('sdRecord/board.export') }}</button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  @endif
@show
