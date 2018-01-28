<div class="col-md-8">
</div>
<div class="col-md-4">
	<button type="button" id="modal-825640" href={{'#modal-container-825640'.$modal_key}} role="button" class="btn btn-primary btn-lg" data-toggle="modal">
		<!--judge claimed or unclaimed-->
		@if($stat == 0)
			{{ Lang::get('LostandFound/page.recognize') }}
		@elseif($stat == 1)
			{{ Lang::get('LostandFound/page.details') }}
		@endif
	</button>
	<div class="modal fade" id="{{'modal-container-825640'.$modal_key}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			{!! Form::open(array('url' => 'laf/'.$modal_key, 'method' => 'put','id' => 'recoForm')) !!}
			<div class="modal-content">
				<div class="modal-body">
					<form class="bs-example bs-example-form" role="form">
						<!--show detail of things-->
						<p>{{ Lang::get('LostandFound/page.location') }}: {{$thingvalue['location']}}</p>
						<p>{{ Lang::get('LostandFound/page.find_time') }}: {{$thingvalue['found_at']}}</p>
						<p>{{ Lang::get('LostandFound/page.description') }}: {{$thingvalue['description']}}</p>
						<!--user can see only if he is admin-->
						@if($stat ==1 && Auth::check() && Auth::user()->isAdmin() == true)
							<div class="alert alert-danger" role="alert"><strong>{{ Lang::get('LostandFound/page.alertAfterReco') }}</strong></div>
							<p>{{ Lang::get('LostandFound/page.timeOfClaim') }}: {{$thingvalue['claimed_at']}}</p>
							<p>{{ Lang::get('LostandFound/page.recoacct') }}: {{$thingvalue['reco_acct']}}</p>
							<p>{{ Lang::get('LostandFound/page.recoemail') }}: {{$thingvalue['reco_email']}}</p>
							<p>{{ Lang::get('LostandFound/page.recophone') }}: {{$thingvalue['reco_phone']}}</p>	
							<p>{{ Lang::get('LostandFound/page.updatedat') }}: {{$thingvalue['updated_at']}}</p>	
							<!--the user who is not admin-->
						@elseif($stat == 1)
							<div class="alert alert-warning" role="alert">{{ Lang::get('LostandFound/page.alertAfterReco') }}</div>
							<p>{{ Lang::get('LostandFound/page.timeOfClaim') }}: {{$thingvalue['claimed_at']}}</p>
								<p style="Display:inline;">{{ Lang::get('LostandFound/page.recoacct') }}: </p>
								<p style="Display:inline;">{{ substr_replace($thingvalue['reco_acct'], '*****', 0,5) }}</p>
								<br>
								<p style="Display:inline;">{{ Lang::get('LostandFound/page.recoemail') }}: </p>
								<p style="Display:inline;">{{ substr_replace($thingvalue['reco_email'],'********',0,8) }}</p>
								<br>
								<p style="Display:inline;">{{ Lang::get('LostandFound/page.recophone') }}: </p>
								<p style="Display:inline;">{{ substr_replace($thingvalue['reco_phone'],'*****',0,5) }}</p>
						@endif
					</form>
					<br>
					<!--if the thing is still unclaimed-->
					@if($stat == 0)
						<div class="alert alert-warning" role="alert">{{ Lang::get('LostandFound/page.alertBeforeReco') }}</div>
						<br>

						
							<div class="form-group">

								<div class="" data-toggle="buttons">
          							<label id="staffRB" name="staffRB" class="btn btn-default">
            							{!! Form::radio('identity', 'student', null) !!}
            							{{ Lang::get('LostandFound/page.student') }}
          							</label>

          							<label id="studentRB" name="studentRB" class="btn btn-default ">

            							{!! Form::radio('identity', 'staff', null) !!}
            							{{ Lang::get('LostandFound/page.outsider') }}
          							</label>
								</div>
								<br>
								<span class="must-fill account student">
				 					{{ Lang::get('LostandFound/page.id') }}
			 					</span>

			 					<span class="must-fill account staff">
				 					{{ Lang::get('LostandFound/page.idnumber') }}
			 					</span>
								{!! Form::text('account', '', ['id' => 'schoolID', 'class' => 'input form-control']) !!}
								<br>
								@if ($errors->has('account'))
									<div style="color:red;">{{ $errors->first('account') }}</div>
								@endif
							</div>

							<div class="form-group">
								{!! Form::label('email', Lang::get('LostandFound/page.email') ) !!}<br>
								{!! Form::text('email', '', ['class' => 'input form-control']) !!}
        						<br>
								<div id="emailerror" style="color:red;"></div>
								@if ($errors->has('email'))
								    <div style="color:red;">{{ $errors->first('email') }}</div>
								@endif
							</div>

							<div class="form-group">
								{!! Form::label('phone',  Lang::get('LostandFound/page.phone') ) !!}<br>
								{!! Form::text('phone', '', ['class' => 'input form-control']) !!}
        						<br>
								<div id="phoneerror" style="color:red;"></div>
							    @if ($errors->has('phone'))
							      <div style="color:red;">{{ $errors->first('phone') }}</div>
							    @endif
							</div>
					@endif

			</div>
			<div class="modal-footer">
       			@if($admin == true || $goIP == true)
	       			<a class = "btn btn-default" href="{{ URL::to('laf/editDetail/'.$modal_key) }}">
	       				<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>{{Lang::get('LostandFound/page.update')}}
	       			</a>
	       		@endif
	       		@if($stat == 0)
       				{!! Form::submit(Lang::get('LostandFound/page.claim'),array('id'=>'submit','class'=>"btn btn-primary")) !!}
	       		@endif
	       		{!! Form::button(Lang::get('LostandFound/page.close'),array('class'=>"btn btn-default",'data-dismiss'=>"modal")) !!}
      		</div>

			</div>
			{!! Form::close() !!}
		</div>

	</div>
	
</div>
