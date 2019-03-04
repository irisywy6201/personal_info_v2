@extends('layout')
@section('content')

<h1>{{ Lang::get('about.pageTitle') }}</h1>
<hr>

<p>
  {!! Lang::get('about.introduction', [
    'ncucc' => HTML::link('http://www.cc.ncu.edu.tw/', Lang::get('menu.ncucc'), ['target' => '_blank']),
    'creator' => Lang::get('about.ncuccCreator'),
    'promoter' => HTML::link('http://cilab.csie.ncu.edu.tw/', Lang::get('about.serviceDeskPromoter'), ['target' => '_blank'])
  ]) !!}
</p>

<br>

<h1>
  {{ Lang::get('about.contributor') }}
  @if(Auth::check() && Auth::user()->isAdmin())
    <a class="btn btn-primary" href="{{ URL::to('about/create') }}">
      <span class="glyphicon glyphicon-plus"></span>
      {{ Lang::get('about.createContributor') }}
    </a>
    <a class="btn btn-primary" href="{{ URL::to('contributorPositions') }}">
      <span class="glyphicon glyphicon-wrench"></span>
      {{ Lang::get('about.managePositions') }}
    </a>
  @endif
</h1>
<hr>

@if(count($contributors) > 0)
  @foreach($contributors as $key => $contributor)
    <div class="panel panel-primary contributors-panel">
      <div class="panel-body">
        <div class="thumbnail pull-left">
          @if($contributor->profile_picture)
            <img src="{{ $contributor->profile_picture }}">
          @else
            <span class="glyphicon glyphicon-user"></span>
          @endif
        </div>
        @if(Auth::check() && Auth::user()->isAdmin())
          {!! Form::open(['url' => 'about/' . $contributor->id, 'method' => 'delete', 'class' => 'pull-right']) !!}
            <a class="btn btn-default" href="{{ URL::to('about/' . $contributor->id . '/edit') }}">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </a>
            @include('globalPageTools.confirmMessage', ['item' => Lang::get('about.contributor')])
            <button class="btn btn-default btn-delete" type="button">
              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
          {!! Form::close() !!}
        @endif
        <h1 class="text-primary">
          {{ Lang::get('contributorsDB.' . $contributor->id . '.name') }}
          <br>
          <small>
            @foreach($contributor['positionIDs'] as $key => $id)
              {{ Lang::get('contributorPositionsDB.' . $id . '.name') }}
              &nbsp;
            @endforeach
          </small>
        </h1>
        <hr>
        <p>
          {!! Lang::get('contributorsDB.' . $contributor->id . '.introduction') !!}
        </p>
        <h3>{{ Lang::get('about.responsibilities') }}</h3>
        <p>
          {{ Lang::get('contributorsDB.' . $contributor->id . '.jobResponsibilities') }}
        </p>
      </div>
    </div>
  @endforeach
@else
  <h3 class="text-warning">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    {{ Lang::get('about.noContributor') }}
  </h3>
  <br>
  <br>
  @if(Auth::check() && Auth::user()->isAdmin())
    <div class="text-center">
      <a class="btn btn-primary btn-lg" href="{{ URL::to('about/create') }}">
        <span class="glyphicon glyphicon-plus"></span>
        {{ Lang::get('about.createFirstContributor') }}
      </a>
    </div>
  @endif
@endif

@stop