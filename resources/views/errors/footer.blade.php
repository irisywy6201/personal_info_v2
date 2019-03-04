@section('footerMessage')

<p>
  {!! Lang::get('errors.footerMessages.contactUs', ['link' => HTML::link('systemProblem', Lang::get('menu.contactUs'))]) !!}
</p>
<p>
  <span class="glyphicon glyphicon-heart"></span>
  {{ Lang::get('errors.footerMessages.thank') }}
  <span class="glyphicon glyphicon-heart"></span>
</p>
<p>
  {{ Lang::get('errors.footerMessages.goForward') }}
  <span class="glyphicon glyphicon-thumbs-up"></span>
</p>

@show