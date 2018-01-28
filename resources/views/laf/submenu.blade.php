@section("submenu")

<!--submenu of Lost things type-->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="things1">
    <div class="col-md-4">
      <div class="thumbnail">
      	<img class="lostpic" src="img/laf/electricity.jpeg">
        <div class="caption">
	  <h3>{{Lang::get('LostandFound/page.electronics')}}</h3>
	  <p></p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/0/0') }}">
	  	<span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	  </a>
        </div>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="things2">
    <div class="col-md-4">
      <div class="thumbnail">
      	<img class="lostpic" src="img/laf/IDcard.jpg" >
        <div class="caption">
          <h3>
            {{Lang::get('LostandFound/page.card or identity')}}
          </h3>
	  <p></p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/1/0') }}">
	         <span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	  </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="thumbnail">
     	 <img class="lostpic" src="img/laf/decoration.jpg">
         <div class="caption">
	 <h3>
            {{Lang::get('LostandFound/page.decoration')}}
          </h3>
	  <p></p>
       	<a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/2/0') }}">
	   	  <span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	 </a>
       </div>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="things3">
    <div class="col-md-4">
      <div class="thumbnail">
      <img class="lostpic" src="img/laf/reading.jpg">
      <div class = "caption">
	  <h3>
             {{Lang::get('LostandFound/page.book')}}
          </h3>
	  <p></p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/3/0') }}">
	          <span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	   </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="thumbnail">
      <img class="lostpic" src="img/laf/stationary.jpg">
      <div class="caption">
	  <h3>
           	{{Lang::get('LostandFound/page.writing materials')}}
          </h3>
	  <p> </p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/4/0') }}">
	           <span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	  </a>
        </div>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="things4">
    <div class="col-md-4">
      <div class="thumbnail">
      <img class="lostpic" src="img/laf/cloth.jpg">
      <div class="caption">
	  <h3>
            {{Lang::get('LostandFound/page.cloth')}}
          </h3>
	  <p></p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/5/0') }}">
	  	<span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	  </a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="thumbnail">
      <img class="lostpic" src="img/laf/bag.jpg">
      <div class="caption">
	  <h3>
            {{Lang::get('LostandFound/page.bags')}}
          </h3>
	  <p></p>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/6/0') }}">
	         <span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.view')}}
	   </a>
        </div>
      </div>
    </div>
  </div>
  <div role="tabpanel" class="tab-pane" id="things5">
    <div class="col-md-4">
      <div class="thumbnail">
 	<img class="lostpic"  src="img/laf/others.jpg">
      <div class="caption">
          <h3>
            {{Lang::get('LostandFound/page.others')}}
          </h3>
	  <a class = "btn btn-primary" href = "{{ URL::to('laf/thingsdetail/7/0') }}">
	  	<span class = "glyphicon glyphicon-eye-open" aria-hidden = "true"></span> {{Lang::get('LostandFound/page.others')}}
	  </a>
        </div>
      </div>
    </div>
  </div>
</div>

@show
