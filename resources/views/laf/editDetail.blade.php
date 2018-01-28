@extends("laf.lafLayout")
@section("laf.content")

<div class="jumbotron">

	<h2>重新編輯遺失物資訊</h2>

	{!! Form::open(array("url" => "laf/updateDetail/".$id , "method" => "get", "class" => "form-horizontal")) !!}
			
			<div class="form-group">
				<div class = "dropdown">
					<button class="btn btn-default dropdown-toggle" id = "type" name = "type" data-toggle = "dropdown" role = "button">
						{{Lang::get('LostandFound/page.type')}}
						<span class = "caret"></span>
					</button>
					<ul class = "dropdown-menu menu-content" role="menu" aria-labelledby="dLabel">
						@foreach($type_all as $key => $value)
					                <li><a id ="{{ $value->id }}">{{ Lang::get('LostandFound/page.'.$value->name) }}</a></li>
					 	@endforeach
					</ul>
					<input id="type" name = "type" type = "hidden" value= {{$type_id+1}} >
		 		</div>
		 	</div>
		 	
		 	<div class="form-group">
		  		{!! Form::label('description',Lang::get('LostandFound/page.description')) !!}<br>
			  	{!! Form::text('description',$description,array('id'=>'description','class'=>'input form-control')) !!}<br>
	  		</div>
	  		
	  		<div class="form-group">
		  		{!! Form::label('location', Lang::get('LostandFound/page.location')) !!}<br>
	          	{!! Form::text('location',$location,array('id'=>'location','class'=>'input form-control')) !!}<br>
		  	</div>

		  	<div class="form-group">
		  		{!! Form::label('found_at', Lang::get('LostandFound/page.find_time')) !!}<br>
				{!! Form::text('found_at',$found_at,array('id'=>'found_at','class'=>'form_datetime input form-control')) !!}<br>
	    	</div>

	    @if($status == 1)

	    	<div class="form-group">
	    		{!! Form::label('reco_acct', Lang::get('LostandFound/page.recoacct')) !!}<br>
				{!! Form::text('reco_acct',$reco_acct,array('id'=>'reco_acct','class'=>'input form-control')) !!}<br>
	    	</div>

	    	<div class="form-group">
	    		{!! Form::label('reco_email', Lang::get('LostandFound/page.recoemail')) !!}<br>
				{!! Form::text('reco_email',$reco_email,array('id'=>'reco_email','class'=>'input form-control')) !!}<br>
	    	</div>

	    	<div class="form-group">
	    		{!! Form::label('reco_phone', Lang::get('LostandFound/page.recophone')) !!}<br>
				{!! Form::text('reco_phone',$reco_phone,array('id'=>'reco_phone','class'=>'input form-control')) !!}<br>
	    	</div>

	    	<div class="form-group">
		  		{!! Form::label('claimed_at', Lang::get('LostandFound/page.timeOfClaim')) !!}<br>
				{!! Form::text('claimed_at',$claimed_at,array('id'=>'claimed_at','class'=>'form_datetime input form-control')) !!}<br>
	    	</div>

			
		@endif

		  	<div class="form-group">
		  		<button type="submit" value="submit" class="btn btn-primary">
					<span class="glyphicon glyphicon-ok"></span>
						{{ Lang::get("messageBoard/board.update") }}
				</button>
				
				<a href="{{ URL::previous() }}" class="btn btn-default">
					<span class="glyphicon glyphicon-remove"></span>
					{{ Lang::get("messageBoard/board.cancel") }}
				</a>
			</div>

	{!! Form::close() !!}
</div>

{!! HTML::script('js/laf/edit.js') !!}
@stop