@extends('layout') 
@section('content')

<div class="jumbotron">
    <h2 >{{$name}} 的修改清單</h2>
    <br>
    <h3 >預定時間：</h3>
    @foreach ($dates as $key => $date)
      <div class="form-inline">
        <a class="btn btn-link" href=" {{ URL::to('HDDestroy/modify/' . $date) }} "><h3 > {{ $date }} </h3> </a>
        <label>數量: {{$numbers[$key]}} </label>
      </div>
    @endforeach
   

</div>

{!! HTML::style('css/HDDestroy/HDDestroy.css') !!}
{!! HTML::script('js/HDDestroy/modify.js') !!}

@stop
