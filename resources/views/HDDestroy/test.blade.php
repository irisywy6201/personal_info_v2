@extends('layout')
@section('content')
<div>
<div >
  {{-------------------------
  <img alt="PDF Preview" src="/img/pdf.png" >
  --------------------------}}
  <embed src="HDDestroyService.pdf" style="width:500px ;height:710px;" />
</div>
<br>
<div class="form-inline">
  {!! Form::open(['url' => 'HDDestroy', 'method' => 'post', 'id' => 'HDDestroyFormFileDownload', 'name' => 'HDDestroyFormFileDownload']) !!}
  <button class="btn btn-default btn-primary" type="submit" value="store" name="store">儲存</button>
  <button class="btn btn-default btn-primary" type="button" onclick="printpdf()">列印</button>
  {!! Form::close() !!}

</div>
</div>


{!! HTML::script('js/HDDestroy/HDDestroy.js') !!}

@stop
