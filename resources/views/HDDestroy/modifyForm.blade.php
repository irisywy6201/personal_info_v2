@extends('layout') 
@section('content')

{!! Form::open(['url' => 'HDDestroy/modify', 'method' => 'post', 'id' => 'HDDestroyModifyForm', 'name' => 'HDDestroyModifyForm']) !!}
<div class="jumbotron">
    @if (count($errors) > 0)
       <div class="alert alert-danger">
      	  <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
          </ul>
       </div>
    @endif

    <h2 >{{$name}} 的修改清單</h2>
    <h3 >預定時間：{{$date}}</h3>
    <br>
    <div id="HD" class="form-inline">
    @foreach ($hds as $i => $hd)
     <div class="form-inline added">
      <input type="checkbox" name="demagnetize[]" value="{{ $i+1  }}" id ='{{ $i+1 }}'  onClick="demagnetize(this)">
      <label for="brandAndStorage_" >硬碟廠牌／容量 : </label>
      <input class="input form-control" name="brandAndStorage[]" id="brandAndStorage{{$i+400}} " type="text" value="{{$hd->brandAndStorage}}" >
      <label for="propertyId_" >硬碟所屬報廢主機或硬碟財產編號 :</label>
      <input class="input form-control" name="propertyId[]" id="propertyId{{$i+400}}" type="text" value="{{$hd->propertyID}}" >
      <label for="note" >備註 : </label>
      <input class="input form-control" name="note[]" id="note{{$i+1}}" type="text" value="{{$hd->ps}}" > 
      <button type='button' class='btn btn-danger glyphicon glyphicon-minus' onclick="delete_HD(this)"></button>
      <br><br>
      </div>
    @endforeach

      <div class="form-inline non-add">
	<input type="checkbox" name="demagnetize[]" value="400" id ='400'  onClick="demagnetize(this)">
        <label for="brandAndStorage_" >硬碟廠牌／容量 : </label>
        <input class="input form-control" name="brandAndStorage[]" id="brandAndStorage1" type="text" >
        <label for="propertyId_" >硬碟所屬報廢主機或硬碟財產編號 :</label>
        <input class="input form-control" name="propertyId[]" id="propertyId1" type="text" >
        <label for="note" >備註 : </label>
        <input class="input form-control" name="note[]" id="note400" type="text" >
        <button type='button' class='btn btn-primary glyphicon glyphicon-plus gplus' onclick="add_HD()"></button>
      </div> 
      <br>
    
    </div>    
    <button type="submit" class="btn btn-primary">
      <span class="glyphicon glyphicon-ok"></span>
          確定送出
    </button>
   </div>
{!! Form::close() !!}


{!! HTML::style('css/HDDestroy/HDDestroy.css') !!}
{!! HTML::script('js/HDDestroy/HDDestroy.js') !!}

@stop
