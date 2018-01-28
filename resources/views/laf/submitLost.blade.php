@section("submitLost")

<!--submit Lost thing button on navbar-->
<div class="modal fade" id="modal-container-68657" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">
          <span class = "glyphicon glyphicon-file" aria-hidden = "true"></span>{{ Lang::get('LostandFound/page.find') }}
        </h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('method'=>'post','id'=>'submitLost','files'=>true)) !!}
	{{-- label 的 第一個參數為 for 屬性 --}}
	 {{-- text 的 第一個參數為 name 屬性 --}}

	 <div class="form-group">
		<div class = "dropdown">
			<button class="btn btn-default dropdown-toggle" name = "type" data-toggle = "dropdown" role = "button">
				{{Lang::get('LostandFound/page.type')}}
				<span class = "caret"></span>
			</button>
			<ul class = "dropdown-menu menu-content" role="menu" aria-labelledby="dLabel">
				@foreach($type as $key => $value)
				                <li><a id ="{{ $value->id }}">{{ Lang::get('LostandFound/page.'.$value->name) }}</a></li>
				 @endforeach
			</ul>
			<input id="type" name = "type" type = "hidden">
      <div id="typeerror" style="color:red;"></div>
      <div class="text-danger"><p>務必選取物品類型</p></div>
      @if ($errors->has('type'))
        <div>{{ $errors->first('type') }}</div>
      @endif
    </div>
	 </div>

	<div class="form-group">
	  	{!! Form::label('description',Lang::get('LostandFound/page.description')) !!}<br>
		  {!! Form::text('description','',array('id'=>'description','class'=>'input form-control')) !!}<br>
      <div id="descriptionerror" style="color:red;"></div>
      @if ($errors->has('description'))
        <div class="text-danger">{{ $errors->first('description') }}</div>
      @endif
  </div>


          <div class="form-group">
	  	{!! Form::label('location', Lang::get('LostandFound/page.location')) !!}<br>
          	{!! Form::text('location','',array('id'=>'location','class'=>'input form-control')) !!}<br>
      <div id="locationerror" class="text-danger"></div>
      @if ($errors->has('location'))
        <div class="text-danger">{{ $errors->first('location') }}</div>
      @endif
	  </div>


	  <div class="form-group">
	  	{!! Form::label('found_at', Lang::get('LostandFound/page.find_time')) !!}<br>
		{!! Form::text('found_at','',array('id'=>'found_at','class'=>'form_datetime input form_control')) !!}<br>
    <div id="found_aterror" class="text-danger"></div>
    @if ($errors->has('found_at'))
      <div class="text-danger">{{ $errors->first('found_at') }}</div>
    @endif
    </div>

    <div class="form-group">
  		{!! Form::label('things_picture', Lang::get('LostandFound/page.picture')) !!}<br>
  		{!! Form::file('images[]', ['multiple' => true,'id' => 'images','value' => 'csrf_token()']) !!}
      <div id="imageserror" style="color:red;"></div>
      <div class="text-danger"><p>務必選取照片,最多選取4張！！</p></div>
      @if ($errors->has('images'))
        <div style="color:red;">{{ $errors->first('images') }}</div>
      @endif
    </div>

      </div>

      <div class="modal-footer">
	       {!! Form::button('Close',array('class'=>"btn btn-default",'data-dismiss'=>"modal")) !!}
       {!! Form::submit('Submit',array('id'=>'submit','class'=>"btn btn-primary")) !!}
      </div>

      {!! Form::close() !!}
    </div>

  </div>
</div>

{!! HTML::script('js/laf/submit.js') !!}
@show
