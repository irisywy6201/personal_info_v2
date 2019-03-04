@extends('layout')
@section('content')

<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand text-muted">
        {{ Lang::get('about.position') }}
      </a>
    </div>
    <div class="navbar-right">
      <a class="btn btn-primary pull-right" href="{{ URL::to('contributorPositions/create') }}">
        <span class="glyphicon glyphicon-plus"></span>
        {{ Lang::get('about.createPosition') }}
      </a>
    </div>
  </div>
</div>

<hr>

@if(count($positions) > 0)
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th>{{ Lang::get('about.name') }}</th>
        <th>{{ Lang::get('about.nameEn') }}</th>
        <th>{{ Lang::get('about.positionDetail') }}</th>
        <th>{{ Lang::get('about.positionDetailEn') }}</th>
        <th>{{ Lang::get('about.createdAt') }}</th>
        <th>{{ Lang::get('about.updatedAt') }}</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($positions as $key => $position)
        <tr>
          <td>{{ $position->name }}</td>
          <td>{{ $position->name_en }}</td>
          <td>{{ $position->detail }}</td>
          <td>{{ $position->detail_en }}</td>
          <td>{{ $position->created_at }}</td>
          <td>{{ $position->updated_at }}</td>
          <td>
            <a class="btn btn-default" href="{{ URL::to('contributorPositions/' . $position->id . '/edit') }}">
              <span class="glyphicon glyphicon-pencil"></span>
              {{ Lang::get('about.edit') }}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <h2 class="text-warning">
    <span class="glyphicon glyphicon-exclamation-sign"></span>
    {{ Lang::get('about.noPosition') }}
  </h2>
  <br>
  <br>
  <br>
  <div class="text-center">
    <a class="btn btn-primary btn-lg" href="{{ URL::to('contributorPositions/create') }}">
      <span class="glyphicon glyphicon-plus"></span>
      {{ Lang::get('about.createFirstPosition') }}
    </a>
  </div>
@endif

@stop