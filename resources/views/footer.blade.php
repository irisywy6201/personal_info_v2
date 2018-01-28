@section("footer")

<footer id="footer">
  <div class="navbar navbar-inverse footer">
    <ul class="nav navbar-nav">
      <li class="btn-nav">{!! HTML::link('http://www.ncu.edu.tw/', Lang::get('menu.ncu'), ['target' => '_blank']) !!}</li>
      <li class="btn-nav">{!! HTML::link('http://www.cc.ncu.edu.tw/', Lang::get('menu.ncucc'), ['target' => '_blank']) !!}</li>
      <li class="btn-nav">{!! HTML::link('about', Lang::get('menu.about')) !!}</li>
      <li class="btn-nav">{!! HTML::link('systemProblem', Lang::get('menu.contactUs')) !!}</li>
    </ul>
    {{-- Language settings --}}
    <ul class="nav navbar-nav navbar-right">
      <li class="btn-nav">
        @if(App::getLocale() != 'en')
          <a href="{{ URL::to('lang/en') }}">
            <span class="glyphicon glyphicon-globe"></span>
            {{ Lang::get('menu.english') }}
          </a>
        @else
          <a href="{{ URL::to('lang/zh_TW') }}">
            <span class="glyphicon glyphicon-globe"></span>
            {{ Lang::get('menu.chinese') }}
          </a>
        @endif
      </li>
    </ul>
    <br><br><br>
    <p class="text-center" style="color:#888888;">

      {{ Lang::get('menu.webcall') }}
      {!! HTML::link('http://140.115.19.96:60080/webcall/?auto_dial=1&uri=97820055', Lang::get('menu.webcallNumbers.0'), ['target' => '_blank']) !!}
      {!! HTML::link('http://140.115.19.96:60080/webcall/?auto_dial=1&uri=97820066', Lang::get('menu.webcallNumbers.1'), ['target' => '_blank']) !!}
      <br>
      {{ Lang::get('menu.address') }}
      <br>
      {{ Lang::get('menu.telephone') }}
      <br>
      {{ Lang::get('menu.email') }}
      {!! HTML::link('mailto:ncucc@ncu.edu.tw', 'ncucc@ncu.edu.tw') !!}
      <br>
      {{ Lang::get('menu.copyright') }}
      <br>
      <br>
      <a class="btn btn-inverse" href="https://www.facebook.com/ncuccsd/?fref=ts" target="_blank">
        <i class="fa fa-facebook-official"></i>
        {{ Lang::get('menu.followUs') }}
      </a>
      <br>
      <br>
    </p>
  </div>
</footer>

@show
