@section("navbar")

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" data-target="#navbar-main" data-toggle="collapse" type="button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="navbar-collapse bs-navbar-collapse collapse" id="navbar-main" role="navigation">
      {{-- Main navigation options --}}
      <ul class="nav navbar-nav">
        @foreach (AppConfig::$navbar as $tag => $nav)
          @if (MenuUtils::showable($nav))
            @if (array_key_exists ('submenu', $nav))
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="{{ 'navtag-' . $tag }}">{{ Lang::get('menu.' . $tag) }}
                  @if (array_key_exists ('badge', $nav))
                    <span class="badge" id="{{ $nav{'badge'}{'id'} }}">{{ $nav{'badge'}{'value'} }}</span>
                  @endif
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="{{ 'navtag-' . $tag }}">
                  @foreach ($nav{'submenu'} as $stag => $snav)
                    @if (MenuUtils::showable($snav))
                      @if (array_key_exists ('divider', $snav))
                        <li class="divider"></li>
                      @elseif (array_key_exists ('route', $snav))
                        <li>
                          {!! HTML::link($snav['route'], Lang::get('menu.' . $tag . '.' . $stag), array ('tabindex' => -1)) !!}
                        </li>
                      @else
                        <li>
                          {!! HTML::link($tag . '/' . $stag, Lang::get('menu.' . $tag . '.' . $stag), array ('tabindex' => -1)) !!}
                        </li>
                      @endif
                    @endif
                  @endforeach
                </ul>
              </li>
            @elseif (array_key_exists ('badge', $nav))
              <li class="btn-nav">
                <a href="{{ URL::to($tag) }}">
                  {{ Lang::get('menu.' . $tag) }}
                  <span class="badge" id="{{ $nav{'badge'}{'id'} }}">
                    {{ $nav{'badge'}{'value'} }}
                  </span>
                </a>
              </li>
            @else
              <li class="btn-nav">
                {!! HTML::link($tag, Lang::get('menu.' . $tag)) !!}
              </li>
            @endif
          @endif
        @endforeach
      </ul>

      {{-- In-site search --}}
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown btn-nav">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="search-dropdown">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="search-dropdown">
            <li>
            {!! Form::open(["url" => "/searching", "method" => "get", "class" => "navbar-form navbar-left"]) !!}
              <fieldset>
                  <div class="navbar-searchbox-dropdown">
                    <div class="form-group">
                      {!! Form::text("query", Input::old("query"), ["class" => "form-control", "placeholder" => Lang::get("menu.placeholder")]) !!}
                    </div>
                    <input class="btn btn-inverse" type="submit" value="{{ Lang::get('menu.search') }}"/>
                  </div>
              </fieldset>
            {!! Form::close() !!}
            </li>
          </ul>
        </li>

        {{-- User account --}}
        @if (!Auth::check())
          <li class="btn-nav">
            <a href="{{ URL::to('login') }}">
              <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
              {{ Lang::get('menu.login') }}
            </a>
          </li>
        @else
          <li class="dropdown btn-nav">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="user-tools">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              @if(Auth::user()->notReadQuesCount()->count())
                <span class="navbar-user-news-reminder"></span>
              @endif
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="user-tools">
              <li class="text-left">
                <a class="navbar-user-id" href="">Hi! {{ Auth::user()->acct }}</a>
              </li>
              <li class="divider"></li>
              <li>
                {!! HTML::link('userinfo', Lang::get('menu.userinfo')) !!}
              </li>
              <li>
                <a href="{{ URL::to('msg_board/userquestion') }}">
                  {{ Lang::get('menu.msg_board/userquestion') }}
                  @if($newReplyCount = Auth::user()->notReadQuesCount->count())
                    <span class="badge">
                      {{ $newReplyCount }}
                    </span>
                  @endif
                </a>
              </li>
              <li>
                {!! HTML::link('email/' . Auth::user()->email()->where('verified', true)->pluck('id') . '/edit', Lang::get('menu.editEmail')) !!}
              </li>
              <!-- @if(Auth::check() && Auth::user()->isStaff())
                <li>
                  {!! HTML::link('apiKey', Lang::get('apiKeyManagement.myAPIKeys')) !!}
                </li>
              @endif -->
              <li class="divider"></li>
              <li>
                {!! HTML::link('logout', Lang::get('menu.logout')) !!}
              </li>
            </ul>
          </li>
        @endif

      </ul>
    </div>
  </div>
</div>

@show
