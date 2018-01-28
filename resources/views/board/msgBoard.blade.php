@extends('board.boardLayout')
@section('board.content')

@if(count($messages) > 0)
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th class="hidden-xs">#</th>
        <th>{{ Lang::get('messageBoard/board.department') }}</th>
        <th class="hidden-xs">{{ Lang::get('messageBoard/board.category') }}</th>
        <th>{{ Lang::get('messageBoard/board.title') }}</th>
        <th class="hidden-xs">{{ Lang::get('messageBoard/board.asked') }}</th>
        <th class="hidden-xs">{{ Lang::get('messageBoard/board.identity') }}</th>
        <th class="hidden-xs">{{ Lang::get('messageBoard/board.date') }}</th>
        <th class="hidden-xs">{{ Lang::get('messageBoard/board.reply') }}</th>
        <th>{{ Lang::get('messageBoard/board.status') }}</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($messages as $key => $value)
        <tr>
          <td class="hidden-xs">{{ $messages->firstItem() + $key }}</td>
          <td>{{ Lang::get('category.' . $value->department . '.name') }}</td>
          <td class="hidden-xs">{{ Lang::get('category.' . $value->category_id . '.name') }}</td>
          <td>{{ str_limit($value->title, 15) }}</td>
          <td class="hidden-xs">
            @if($value->isHidden)
              {{ Lang::get('messageBoard/board.userHidden') }}
            @else
              {{ $value->userName }}
            @endif
          </td>
          <td class="hidden-xs">{{ Lang::get('identity.' . $value->identity) }}</td>
          <td class="hidden-xs">
            {{ date( 'Y-m-d', strtotime( $value->created_at)) }}
            <br>
            {{ date( 'H:i:s', strtotime( $value->created_at)) }}
          </td>
          <td class="hidden-xs">
            @if(Auth::check() && Auth::user()->id == $value->user_id && !$value->isRead)
              <span class="label label-danger">New!!</span>
            @else
              {{ $value->reply }}
            @endif
          </td>
          <td>
            @if($value->status == $statuses['unsolved'])
              <p class="text-danger">
                <span class="glyphicon glyphicon-remove"></span>
              </p>
            @elseif($value->status == $statuses['solved'] || $value->status == $statuses['auto-solved'])
              <p class="text-success">
                <span class="glyphicon glyphicon-ok"></span>
              </p>
            @else
              <p class="text-warning">
                <span class="glyphicon glyphicon-question-sign"></span>
              </p>
            @endif
          </td>
          <td>
            <a class="btn btn-default" href={{ URL::to('msg_board/' . $value->id) }}>
              <span class="glyphicon glyphicon-eye-open"></span>
              <span class="hidden-xs">{{ Lang::get('messageBoard/board.detail') }}</span>
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="text-center">
    {!! $messages->render() !!}
  </div>
@else
  <br><br><br>
  <div class="text-center">
    <h1 class="text-warning">
      <span class="glyphicon glyphicon-exclamation-sign"></span>
      {{ Lang::get('messageBoard/board.noMessage') }}
    </h1>
    <br>
    <hr>
    <br><br>
    <a class="btn btn-lg btn-primary" href="{{ URL::to('msg_board/create') }}">
      <span class="glyphicon glyphicon-plus"></span>
      {{ Lang::get('messageBoard/board.leaveFirstMessage') }}
    </a>
  </div>
@endif

@stop
