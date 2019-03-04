@section("searchBar")

{!! Form::open(['url' => 'faq/realTimeSearch', 'class' => 'navbar-form real-time-search-bar', 'data-real-time-search-id' => 'faq-real-time-search-bar']) !!}
  <fieldset>
    <div class="form-group">
      {!! Form::text('keyword', Input::old('keyword', ''), ['class' => 'form-control keyword', 'id' => 'input-text', 'placeholder' => Lang::get('searching.pleaseInputKeyword')]) !!}
    </div>

    <div class="form-group">
      <div id="forDepartMenu" class="dropdown">
        {!! Form::hidden('department', Input::old('department', '')) !!}
        <button class="btn navbar-btn btn-default navbar-content" id="department" name="department" data-toggle="dropdown" role="button"> 
          {{ Lang::get('faq.department_category') }}
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel">
          @foreach($departments as $key => $department)
            <li>
              <a id="{{ $department['id'] }}">
                {{ Lang::get('category.' . $department['id'] . '.name') }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="form-group">
      <div id="forCategMenu" class="dropdown">
        {!! Form::hidden('category', Input::old('category', '')) !!}
        <button class="btn navbar-btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button" disabled="disabled"> 
          {{ Lang::get('faq.pFirstSelectDepart') }}
          <span class="caret"></span>
        </button>
        <ul id="menu-0" class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel"></ul>
      </div>
    </div>

    <div class="form-group">
      <button class="btn navbar-btn btn-default btn-refresh" type="button">
        <span class="glyphicon glyphicon-refresh"></span>
        {{ Lang::get('searching.resetSearchBar') }}
      </button>
    </div>

    <div class="form-group">
      <span class="swoop sr-only loading"></span>
    </div>
  </fieldset>
{!! Form::close() !!}

@show