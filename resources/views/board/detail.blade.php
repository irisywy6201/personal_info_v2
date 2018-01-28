@extends("board.boardLayout")
@section("board.content")

<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand text-muted">
        {{ $message->title }}
      </a>
    </div>

    @if(Auth::check() && $message->status == $statuses['unsolved'] && ($message->acct == Auth::user()->acct || Auth::user()->isAdmin()))
      <div class="navbar-right">
        {!! Form::open(['url' => 'msg_board/' . $id, 'method' => 'delete', 'class' => 'navbar-form navbar-right']) !!}
          @if($message->acct == Auth::user()->acct)
            @if($message->reply > 0)
              <a class="btn btn-default" href="{{ URL::to('msg_board/' . $id . '/solve/' . Crypt::encrypt(Auth::user()->acct)) }}">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                {{ Lang::get('messageBoard/board.setSolved') }}
              </a>
            @endif

            <a href="{{ URL::to('/msg_board/' . $id . '/edit') }}" class="btn btn-default">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
              {{ Lang::get('messageBoard/board.edit') }}
            </a>
          @endif
          
          @include('globalPageTools.confirmMessage', ['item' => Lang::get('messageBoard/board.message')])

          <button class="btn btn-default btn-delete" type="button">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            {{ Lang::get('messageBoard/board.delete') }}
          </button>
        {!! Form::close() !!}
      </div>
    @endif
  </div>
</div>

<p>{{ Lang::get('messageBoard/board.department') }}: {{ Lang::get('category.' . $message->department . '.name') }}</p>
<p>{{ Lang::get('messageBoard/board.category') }}: {{ Lang::get('category.' . $message->category_id . '.name') }}</p>
<p>{{ Lang::get('messageBoard/board.asked') }}: {{ $message->acct }}</p>
<p>{{ Lang::get('messageBoard/board.identity') }}: {{ Lang::get('identity.' . $message->identity) }}</p>
<p>{{ Lang::get('messageBoard/board.date') }}: {{ $message->created_at }}</p>
<p>{{ Lang::get('messageBoard/board.status') }}: {{ Lang::get('messageBoard/status.' . $message->status) }}</p>
<p>{{ Lang::get('messageBoard/board.contDesc') }}:
  <br>
  {!! $message->content !!}
</p>

<hr>

<p>{{ Lang::get('messageBoard/board.replyRegion') }}</p>
<div class="well">
  @if(count($reply) == 0)
    <h1 class="text-center help-block">
      {{ Lang::get('messageBoard/board.noReply') }}
    </h1>
  @else
    @foreach($reply as $key => $value)
      <div class="replyPanel panel panel-default">
        <div class="panel-body">
          <div class="media">
            <div class="thumbnail pull-left">
              <span class="glyphicon glyphicon-comment media-object" aria-hidden="true"></span>
            </div>
            <div class="media-body">
              @if(Auth::check() && $value->acct == Auth::user()->acct && $message->status == $statuses['unsolved'])
                {!! Form::open(['url' => ['/msg_board/' . $message->id . '/reply/' . $value->id], 'method' => 'delete']) !!}
                  @include('globalPageTools.confirmMessage', ['item' => Lang::get('messageBoard/board.reply')])
                  <button class="btn btn-no-edge btn-delete pull-right" type="button">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                  </button>
                {!! Form::close() !!}
                <button class="btn btn-no-edge btn-edit pull-right" type="button">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
              @endif
              <h4 class="media-heading">
                {{ $value->acct }}
              </h4>
            </div>
            <div class="media-body content-field">
              <p>{!! $value->content !!}</p>
              <p class="help-block">
                {{ $value->created_at }}
              </p>
            </div>
          </div>
          <div class="media-body edit-field form-group @if($errors->has('email')) has-error @endif">
            {!! Form::open(['url' => '/msg_board/' . $message->id . '/reply/' . $value->id, 'files' => true, 'method' => 'put', 'class' => 'form-horizontal form-group']) !!}
              <fieldset>
                <textarea id="editReplyContent" class="mustFill summernote" name="content" value="{{ Input::old('content') }}"></textarea>
                <label class="control-label has-error" for="editReplyContent">
                  @if($errors->has("content"))
                    {{ $errors->first("content") }}
                  @endif
                </label>
                <br>
                <button class="btn btn-primary" type="submit">
                  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                  {{ Lang::get('messageBoard/board.update') }}
                </button>
                <button class="btn btn-default btn-cancel" type="button">
                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                  {{ Lang::get('messageBoard/board.cancel') }}
                </button>
              </fieldset>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    @endforeach
  @endif
</div>

<hr>
@if($message->status != $statuses['solved'] || $message->status != $statuses['auto-solved'])
  @if(Auth::check())
    @if(Auth::user()->isStaff() || Auth::user()->acct == $message->acct)
      {!! Form::open(['url' => 'msg_board/' . $message->id . '/reply', 'method' => 'post']) !!}
        <fieldset>
          <div class="form-group @if($errors->has('content')) has-error @endif">
            <label class="control-label" for="newReplyContent">
              {{ Lang::get('messageBoard/board.plzInputReply') }}
            </label>
            <textarea id="newReplyContent" class="mustFill summernote" name="content" value="{{ Input::old('content') }}" placeholder="{{ Lang::get('messageBoard/board.plzInputReply') }}"></textarea>
            <label class="control-label has-error" for="newReplyContent">
              @if($errors->has("content"))
                {{ $errors->first('content') }}
              @endif
            </label>
          </div>

          <div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
            <label class="control-label" for="g-recaptcha-response">
              <span class="must-fill">*</span>
              {{ Lang::get('recaptcha.pleaseInputRecaptcha') }}
            </label>
            {!! Recaptcha::render() !!}
            {!! Form::close() !!}
            <label class="control-label has-error" for="g-recaptcha-response">
              @if($errors->has('g-recaptcha-response'))
                {{ $errors->first('g-recaptcha-response') }}
              @endif
            </label>
          </div>
          <button class="btn btn-primary" type="submit">
            <span class="glyphicon glyphicon glyphicon-comment" aria-hidden="true"></span>
            {{ Lang::get('messageBoard/board.reply') }}
          </button>
        </fieldset>
      {!! Form::close() !!}
    @else
      <h3 class="help-block">
        {{ Lang::get('messageBoard/board.cannotReply') }}
      </h3>
    @endif
  @else
    <a class="btn btn-primary" href="{{ URL::to('loginAndReturn') }}">
      <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
      {{ Lang::get('messageBoard/board.loginToReply') }}
    </a>
  @endif
@endif

@include('globalPageTools.scrollTop')

@stop
