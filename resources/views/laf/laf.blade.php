@extends("laf.lafLayout")
@section("laf.content")

@if($goIP == true || $admin == true)
 <button type="button" id="modal-68657" class="btn btn-primary" data-target="#modal-container-68657" data-toggle="modal" style="float:right">
    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> {{Lang::get('LostandFound/page.find')}}
</button>
@endif

@if(Auth::check())
 <a class = "btn btn-primary" href = "{{ URL::to('laf/claimrecord/login') }}">
   <span class = "glyphicon glyphicon-search" aria-hidden = "true"></span> {{ Lang::get('LostandFound/page.claimrecord')}}
 </a>
 <a class = "btn btn-primary" href = "{{ URL::to('laf/deleteRecord') }}">
   <span class= "glyphicon glyphicon-search" aria-hidden = "true"></span> {{ Lang::get('LostandFound/page.delete') }}
</a>
 <br>
@else
 {!! Form::open(['method'=>'post','url'=>'laf/realsearch','class' => 'form-inline']) !!}

    <div class="form-group">
        {!! Form::label('realsearch',Lang::get('LostandFound/page.keyword')) !!}
        {!! Form::text('realsearch',Input::old('realsearch',''),array('id'=>'realsearch','class'=>'form-control realsearch','placeholder'=>Lang::get('LostandFound/page.idnumber'))) !!}
    </div>
    &nbsp;
    <button class="btn btn-inverse"  type="submit">
      <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
      {{ Lang::get('menu.search') }}
    </button>
 {!! Form::close() !!}
@endif
<br>

@include("laf.searchBar")
&nbsp;

<div class="real-time-search-wrapper" data-real-time-search-id="lostthing-real-time-search-bar">
  <div class="real-time-search-origin-page">
    <!--put all kind of navbar or menu here-->
    <!--things type navbar-->
    <div class="col-md-12">
      <ul class="nav nav-tabs" id="things_type">
        <li class="active">
          <a href="#things1" data-toggle="tab">{{ Lang::get('LostandFound/page.electronics') }}</a>
        </li>
        <li>
          <a href="#things2" data-toggle="tab">{{ Lang::get('LostandFound/page.possession') }}</a>
        </li>
        <li>
          <a href="#things3" data-toggle="tab">{{ Lang::get('LostandFound/page.writing materials or books') }}</a>
        </li>
        <li>
          <a href="#things4" data-toggle="tab">{{ Lang::get('LostandFound/page.cloth or bags') }}</a>
        </li>
        <li>
          <a href="#things5" data-toggle="tab">{{ Lang::get('LostandFound/page.others') }}</a>
        </li>
     </ul>
    </div>
     <div>
        @include("laf.submitLost")
    </div>
    <div>
      @include("laf.submenu")
    </div>

  </div>
  <div class="real-time-search-result-page"></div>
</div>

{!! HTML::style('css/laf/lafstyle.css') !!}
{!! HTML::script('js/laf/detail.js') !!}

@stop
