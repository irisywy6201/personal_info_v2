<!DOCTYPE html>
<html lang="utf-8">
  <head>
    <title>{{ Lang::get('application.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta property="og:title" content="{{ Lang::get('application.name') }}">
    <meta property="og:description" content={{ Lang::get('application.description') }}>
    <meta property="og:image" content={{ URL::to('img/banner_phones.jpg') }}>
    <meta property="og:url" content={{ $_SERVER['SERVER_NAME']  }}>
    <meta property="og:type" content="website">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {!! HTML::style('css/bootstrap/bootstrap.min.css', array ('media' => 'screen')) !!}
    {!! HTML::style('css/bootstrap/bootswatch.min.css') !!}
    {!! HTML::style('css/bootstrap-fileinput/fileinput.min.css') !!}
    {!! HTML::style('css/font-awesome/font-awesome.min.css') !!}
    {!! HTML::style('css/simple-sidebar.css') !!}
    {!! HTML::style('css/summernote.css') !!}
    {!! HTML::style('css/photoviewer.css') !!}
    {!! HTML::style('css/dropdown.css') !!}
    {!! HTML::style('css/datepicker.css') !!}
    {!! HTML::style('css/loading.css') !!}
    {!! HTML::style('css/datetimepicker/jquery.datetimepicker.css') !!}
    {!! HTML::style('zoom/css/zoom.css') !!}
    {!! HTML::style('css/custom.css') !!}
    {!! HTML::style('css/bootstrap/bootstrap-toggle.css') !!}
    {!! HTML::style('css/datetimepicker/jquery.datetimepicker.css') !!}
    {!! HTML::script('js/lib/jquery/jquery.min.js') !!}
    {!! HTML::script('js/lib/jquery/jquery-ui.min.js') !!}
    {!! HTML::script('js/lib/jquery/jquery.mousewheel.min.js') !!}
    {!! HTML::script('js/lib/bootstrap-fileinput/fileinput.min.js') !!}
    {!! HTML::script('js/lib/bootstrap-fileinput/fileinput_locale_zh.js') !!}
    {!! HTML::script('js/lib/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/lib/bootstrap/bootswatch.js') !!}
    {!! HTML::script('js/lib/bootstrap/bootstrap-toggle.min.js') !!}
    {!! HTML::script('js/lib/bootstrap/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/lib/summernote.min.js') !!}
    {!! HTML::script('zoom/js/zoom.js') !!}
    {!! HTML::script('js/lib/global.js') !!}
    {!! HTML::script('js/datetimepicker/jquery.datetimepicker.js') !!}
    {!! HTML::script('js/lib/require.min.js', array ('data-main' => '/js/app')) !!}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      {{ HTML::script('js/html5shiv.js') }}
      {{ HTML::script('js/respond.min.js') }}
    <![endif]-->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-75161137-1', 'auto');
      ga('send', 'pageview');
			
    </script>

    <style>
      body { font-family: DejaVu Sans, sans-serif; }
    </style>

  </head>
  <body>
    @include("navbar")
    @if(Request::url() == Request::root())
      <div id="banner"></div>
    @endif
    <div id="page-wrapper">
      <div id="lockScreen">
      </div>
      @include('globalPageTools.feedback')
      <div id="content">
        <br>
        <div class="container">
          <br><br><br>
          @yield('content')
        </div>
      </div>
      @include('footer')
    </div>
  </body>
</html>
