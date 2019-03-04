<!DOCTYPE html>
<html lang="utf-8">
  <head>
    <title>{{ Lang::get('application.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="google-site-verification" content="tRySogi5xBnaEopeZFONwz70CXn_GPbYvScBsSIFTbQ" />
    {!! HTML::style('css/bootstrap/bootstrap.min.css', array ('media' => 'screen')) !!}
    {!! HTML::style('css/bootstrap/bootswatch.min.css') !!}
    {!! HTML::style('css/custom.css') !!}
    {!! HTML::style('css/font-awesome/font-awesome.css') !!}
    {!! HTML::style('css/maintenance.css') !!}
    {!! HTML::script('js/lib/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/lib/bootstrap/bootswatch.js') !!}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      {{ HTML::script('js/html5shiv.js') }}
      {{ HTML::script('js/respond.min.js') }}
    <![endif]-->
  </head>
  <body>
    <div id="page-wrapper">
      <div id="header">
        {!! HTML::image('img/banner.jpg') !!}
      </div>
      <div id="content">
        <div class="container text-center">
          <div class="page-header">
            <h1 class="text-warning">
              {{ Lang::get('maintenance.title', [], 'zh_TW') }}
              <br>
              <small>
                {{ Lang::get('maintenance.title', [], 'en') }}
              </small>
            </h1>
          </div>
          <p>
            {{{ Lang::get('maintenance.message', [], 'zh_TW') }}}
            <br>
            {{{ Lang::get('maintenance.apologize', [], 'zh_TW') }}}
            <br>
            {{{ Lang::get('maintenance.beRightBack', [], 'zh_TW') }}}
          </p>
          <p>
            {{{ Lang::get('maintenance.thank', [], 'zh_TW') }}}
            <span class="glyphicon glyphicon-thumbs-up"></span>
            <br>
            <span class="glyphicon glyphicon-heart"></span>
            {{{ Lang::get('maintenance.goForward', [], 'zh_TW') }}}
            <span class="glyphicon glyphicon-heart"></span>
          </p>
          <br>
          <p>
            {{ Lang::get('maintenance.message', [], 'en') }}
            <br>
            {{ Lang::get('maintenance.apologize', [], 'en') }}
            <br>
            {{ Lang::get('maintenance.beRightBack', [], 'en') }}
          </p>
          <p>
            {{ Lang::get('maintenance.thank', [], 'en') }}
            <span class="glyphicon glyphicon-thumbs-up"></span>
            <br>
            <span class="glyphicon glyphicon-heart"></span>
            {{ Lang::get('maintenance.goForward', [], 'en') }}
            <span class="glyphicon glyphicon-heart"></span>
          </p>
          </div>
        </div>
      @include('footer')
    </div>
  </body>
</html>
