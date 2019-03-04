@section("searchBar")
{!! Form::open(['url' => 'laf/realTimeSearch','method' => 'post', 'class' => 'form-inline real-time-search-bar','data-real-time-search-id' => 'lostthing-real-time-search-bar']) !!}
  <div class="form-group">
      {!! Form::label('keyword',Lang::get('LostandFound/page.searchdescription')) !!}
      {!! Form::text('keyword', Input::old('keyword', ''), ['class' => 'form-control keyword', 'id' => 'input-text','placeholder' => Lang::get('LostandFound/page.searchHolder')]) !!}
  </div>

  <div class="input-group">
  <div class="dropdown">
    {!! Form::hidden('type', Input::old('type', ''),array('class' => 'form-control')) !!}
    <button class="btn btn-default navbar-content" id="type" name="type" data-toggle="dropdown" role="button">
          {{ Lang::get('LostandFound/page.chooType') }}
          <span class="caret"></span>
    </button>
    <ul class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel">
          @foreach($type as $key => $value)
            <li><a id ="{{ $value->id }}">{{ Lang::get('LostandFound/page.'.$value->name) }}</a></li>
          @endforeach
    </ul>
  </div>
</div>

<div class="input-group">
  <div class="dropdown">
    {!! Form::hidden('status', Input::old('status', ''),array('class' => 'form-control')) !!}
    <button class="btn btn-default navbar-content" id="status" name="status" data-toggle="dropdown" role="button">
          {{ Lang::get('LostandFound/page.choostatus') }}
          <span class="caret"></span>
    </button>
    <ul class="dropdown-menu menu-content " role="menu" aria-labelledby="dLabel">
            <li><a id ="lost">{{Lang::get('LostandFound/page.lost')}}</a></li>
            <li><a id ="found">{{Lang::get('LostandFound/page.found')}}</a></li>
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
{!! Form::close() !!}
@show
