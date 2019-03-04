<button class="btn btn-default btn-primary" id="FGbutton" type="button" data-toggle="modal" data-target="#myModal" >
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('送出') }}
</button>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	
	<div class="form-group">
          <span id="username"> {{$username}} </span>
	  {!! Form::label(' 的硬碟破壞清單預覽 : ') !!} 
          <br>
        </div>	

	<div >
  	  <img alt="PDF Preview" src="/img/pdf.png" >
	</div>
	<br>
	<div class="modal-footer">
	<div class="form-inline">
  	  <button class="btn btn-default btn-primary" type="submit">
		<span class="glyphicon glyphicon-ok"></span>確定送出
	  </button>
      
         <button type="button" class="btn btn-default" data-dismiss="modal">返回修改</button>
	</div>
        </div>
        
       </div>
     </div>

  </div>
</div>
