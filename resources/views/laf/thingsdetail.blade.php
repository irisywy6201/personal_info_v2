@extends('laf.lafLayout')
@section('laf.content')

<div id="wrapper">
  <button class="btn btn-no-edge" id="menu-toggle" type="button">

    <span class="glyphicon glyphicon-align-justify"></span>
  </button>

  <div id="sidebar-wrapper">
    @include("laf.sideBar")
  </div>

  <div id="page-content-wrapper">

    @if(Auth::check())
     <a class = "btn btn-primary" href = "{{ URL::to('laf/claimrecord/login') }}">
       <span class = "glyphicon glyphicon-search" aria-hidden = "true"></span> {{ Lang::get('LostandFound/page.claimrecord')}}
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

      <div>
        @include("laf.locationBar")
      </div>

      @if(count($lostthing)>0)
        <div class="container-fluid">
        	<div class="row">
            @foreach($lostthing['data'] as $thingkey => $thingvalue)
              <div class="col-md-4">
            		<div style="height: 250px;border: 2px inset;border-radius: 25px;padding:7px">
                  <p></p>
                  <p style="color:#a9a9a9">{{ Lang::get('LostandFound/page.location')}}: {{$thingvalue['location']}}</p>
                  <p style="color:#a9a9a9">{{ Lang::get('LostandFound/page.description')}}: {{$thingvalue['description']}}</p>
                  <p style="color:#a9a9a9">{{ Lang::get('LostandFound/page.find_time') }}: {{$thingvalue['found_at']}}</p>
                  <div>
                    @foreach ($thingvalue['pictures'] as $key => $value)
                      @if($key == 0)
                        <img class="pic" src={{URL::to($value)}} data-action="zoom" style="width: 50px;height: 50px">
                      @else
                        <img class="pic" src={{URL::to($value)}} data-action="zoom" style="width: 50px;height: 50px">
                      @endif
                    @endforeach
                  </div>
                  <br>
                    @if($goIP == true || $admin == true)
            				  <p>@include('laf.recognize', ["modal_key" => $thingvalue['id']])</p>
                    @endif
                </div>
              </div>
            @endforeach
        	</div>
        </div>
      @else
        <h2>
          <span class="glyphicon glyphicon-exclamation-sign"></span>
            {{ Lang::get('searching.noResult') }}
        </h2>
      @endif
  </div>
</div>

{!! HTML::script('js/laf/detail.js') !!}

@stop
