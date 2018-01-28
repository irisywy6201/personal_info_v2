@if(count($results) > 0)
<div class="container-fluid">
  <div class="row">
    @foreach($results as $searchkey => $searchvalue)
    <div class="col-md-4" style="height: 250px;border: 2px solid #428bca;border-radius: 25px">
      <p></p>
      <p style="color:#428bca">{{ Lang::get('LostandFound/page.location')}}: {{$searchvalue['location']}}</p>
      <p style="color:#428bca">{{ Lang::get('LostandFound/page.description')}}: {{$searchvalue['description']}}</p>
      <p style="color:#428bca">{{ Lang::get('LostandFound/page.find_time') }}: {{$searchvalue['found_at']}}</p>
      <div>
      	@foreach ($searchvalue['pictures'] as $key => $value)
      		@if($key == 0)
                      <img src={{URL::to($value)}} data-action="zoom" style="width: 50px;height: 50px">
                @else
                      <img src={{URL::to($value)}} data-action="zoom" style="width: 50px;height: 50px">
                @endif
      	@endforeach
      </div>
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
          <button type="button" id="modal-825640" href={{'#modal-container-825640'.$searchvalue['id']}} role="button" class="btn btn-primary btn-lg" data-toggle="modal">
          <!--judge claimed or unclaimed-->
            @if($searchvalue['status'] == 0)
              {{ Lang::get('LostandFound/page.recognize') }}
            @elseif($searchvalue['status'] == 1)
              {{ Lang::get('LostandFound/page.details') }}
            @endif
          </button>
          <div class="modal fade" id="{{'modal-container-825640'.$searchvalue['id']}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            {!! Form::open(array('url' => 'laf/'.$searchvalue['id'], 'method' => 'put','id' => 'recoForm')) !!}
              <div class="modal-content">
                <div class="modal-body">
                  <form class="bs-example bs-example-form" role="form">
                  <!--show detail of things-->
                    <p>{{ Lang::get('LostandFound/page.type') }}: {{ Lang::get('LostandFound/page.'.$searchvalue['type_id']) }}</p>
                    <p>{{ Lang::get('LostandFound/page.location') }}: {{$searchvalue['location']}}</p>
                    <p>{{ Lang::get('LostandFound/page.find_time') }}: {{$searchvalue['found_at']}}</p>
                    <p>{{ Lang::get('LostandFound/page.description') }}: {{$searchvalue['description']}}</p>
                    <!--user can see only if he is admin-->
                    @if($searchvalue['status'] ==1 && Auth::check() && Auth::user()->isAdmin() == true)
                      <div class="alert alert-warning" role="alert">{{ Lang::get('LostandFound/page.alertAfterReco') }}</div>
                      <p>{{ Lang::get('LostandFound/page.timeOfClaim') }}: {{$searchvalue['claimed_at']}}</p>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recoacct') }}: </p>
                      <p style="Display:inline;">{{ $searchvalue['reco_acct']}}</p>
                      <br>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recoemail') }}: </p>
                      <p style="Display:inline;">{{ $searchvalue['reco_email'] }}</p>
                      <br>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recophone') }}: </p>
                      <p style="Display:inline;">{{ $searchvalue['reco_phone'] }}</p>
                      <!--the user who is not admin-->
                    @elseif($searchvalue['status'] == 1)
                      <div class="alert alert-warning" role="alert">{{ Lang::get('LostandFound/page.alertAfterReco') }}</div>
                      <p>{{ Lang::get('LostandFound/page.timeOfClaim') }}: {{$searchvalue['claimed_at']}}</p>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recoacct') }}: </p>
                      <p style="Display:inline;">{{ substr_replace($searchvalue['reco_acct'], '*****', 0,5) }}</p>
                      <br>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recoemail') }}: </p>
                      <p style="Display:inline;">{{ substr_replace($searchvalue['reco_email'],'********',0,8) }}</p>
                      <br>
                      <p style="Display:inline;">{{ Lang::get('LostandFound/page.recophone') }}: </p>
                      <p style="Display:inline;">{{ substr_replace($searchvalue['reco_phone'],'*****',0,5) }}</p>
                    @endif
                  </form>
                  <br>
                  <!--if the thing is still unclaimed-->
                  @if($searchvalue['status'] == 0)
                    <div class="alert alert-warning" role="alert">{{ Lang::get('LostandFound/page.alertBeforeReco') }}</div>
                    <br>

                  
                    <div class="form-group">
                    {{--身份欄位(radio button)--}}
                      <div class="" data-toggle="buttons">
                        <label id="staffRB" name="staffRB" class="btn btn-default">
                          {!! Form::radio('identity', 'student', null) !!}
                          {{ Lang::get('LostandFound/page.student') }}
                        </label>

                        <label id="studentRB" name="studentRB" class="btn btn-default ">
                          {{-- label class 加上 active 可使之預選 --}}
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
                          {{---信箱欄位--}}
                    <div class="form-group">
                      {!! Form::label('email', Lang::get('LostandFound/page.email') ) !!}<br>
                      {!! Form::text('email', '', ['class' => 'input form-control']) !!}
                      <br>
                      <div id="emailerror" style="color:red;"></div>
                      @if ($errors->has('email'))
                        <div style="color:red;">{{ $errors->first('email') }}</div>
                      @endif
                    </div>
                          {{---電話欄位--}}
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
                  {!! Form::button('Close',array('class'=>"btn btn-default",'data-dismiss'=>"modal")) !!}
                  {!! Form::submit('update',array('id'=>'submit','class'=>"btn btn-primary")) !!}
              @if(Auth::check())
                <a class = "btn btn-default" href="{{ URL::to('laf/editDetail/'.$searchvalue['id']) }}">
                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>{{Lang::get('LostandFound/page.update')}}
                </a>
              @endif
          </div>

      </div>
      {!! Form::close() !!}
    </div>

  </div>
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
{!! HTML::script('js/laf/detail.js') !!}
