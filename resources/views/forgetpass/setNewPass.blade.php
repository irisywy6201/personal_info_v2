@extends("layout")
@section("content")

<div class="jumbotron">
	<h3>
		{{ Lang::get('forgetpass/setNewPass.set') }}
		<span id="myid"></span>
		{{ Lang::get("forgetpass/setNewPass.'sNewPass") }}
	</h3>
	<br>

	<span class="must-fill" style="font-size: 16px;">
		{{ Lang::get('forgetpass/setNewPass.rule.newPassRule') }}
		<br><br>

		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleOne') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleTwo') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleThree') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleFour') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleFive') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleSix') }}</li>
		<li>{{ Lang::get('forgetpass/setNewPass.rule.ruleSeven') }}</li>
	</span>
	<br>

	{!! Form::open(['url'=>'setNewPass', 'method'=>'post', 'id'=>'NewPassForm']) !!}

		{!! Form::hidden('basicData', '', ['id'=>'basicData']) !!}
		<br>

		<div class="form-group">
			{!! Form::label('newPass', Lang::get('forgetpass/setNewPass.typeNewPass')) !!}
			<br>
			{!! Form::password('newPass', '', ['id'=>'newPass']) !!}
			<br>
			<span id="newPassError" class="must-fill errorMsg"></span>
			<br>
		</div>

		<div class="form-group">
			{!! Form::label('newPass_confirmation', Lang::get('forgetpass/setNewPass.typeNewPassAgain')) !!}
			<br>
			{!! Form::password('newPass_confirmation','', ['id'=>'newPass_confirmation','class'=>'input form-control']) !!}
			<br>
			<span id="newPass_confirmationError" class="must-fill errorMsg"></span>
		</div>
		<br>
		<br>

		<div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
	        <label class="control-label" for="g-recaptcha-response">
	          <span class="must-fill">*</span>
	          {{ Lang::get('forgetpass/setNewPass.recaptcha') }}
	        </label>

	        {!! Recaptcha::render() !!}
	        {!! Form::close() !!}

	        <label class="control-label has-error" for="g-recaptcha-response">
	          @if($errors->has("g-recaptcha-response"))
	            {{ $errors->first("g-recaptcha-response") }}
	          @endif
	        </label>
	    </div>

		<input class="btn btn-default" id="button" type="button" value="送出">
	{!! Form::close() !!}
</div>

<?php
	$basicData = [
	    'verifyLink'  	=> \Session::get('verifyLink'),
	    'stuOrNot'		=> \Session::get('stuOrNot'),
	    'approve_id'	=> \Session::get('approve_id'),
	];
?>

<script>
	/*****************************************
		取得驗證連結
	******************************************/
	var verifyLink 	= '<?php echo $basicData['verifyLink'] ?>';
	whoAreYou(verifyLink);
	
	/*****************************************
		取得目前帳號
	******************************************/
	var schoolID 	= '';
	function whoAreYou(verifyLink)
	{
		var inputJsonData = 
	    {
	    	'whoAreYou' 	: verifyLink,
	    };

	    var URLs = $('#NewPassForm').attr('action') + '/whoAreYou';
	    var laravelAuthTokenForPost = $('input[name=_token]').val();
	    inputJsonData['_token'] = laravelAuthTokenForPost;
	    
	    $.ajax(
	    {
	        url: URLs,
	        data: inputJsonData,
	        type:"post",
	        dataType: "json",

	        success: function(returnData)
	        {
	        	
	        	schoolID = returnData['schoolID'];
	        	$('#myid').html(schoolID);
	        },

	        error:function(xhr, ajaxOptions, thrownError)
	        {
	            console.log('server error: ', xhr.responseText);
	        }
   		});
	}

	var newPassInput 				= document.getElementById('newPass');
	var newPass_confirmation_input 	= document.getElementById('newPass_confirmation');

	$("#button").click(function() 
	{
		$("#basicData").val('<?php echo implode(" ", $basicData); ?>');

		var URLs = $('#NewPassForm').attr('action') + '/final';

		var newFormData =  new  FormData();
		newFormData.append('myid', schoolID);
		newFormData.append("newPass_confirmation" , newPass_confirmation.value);
		newFormData.append("newPass" , newPassInput.value);

		var laravelAuthTokenForPost = $('input[name=_token]').val();
    	newFormData.append('_token', laravelAuthTokenForPost);

	    $.ajax(
	    {
	        url: URLs,
	        data: newFormData,
	        processData: false,
  			contentType: false,
	        type:"post",
	        dataType: "json",

	        success: function(returnData)
	        {
	        	$('.errorMsg').html('');
	        	console.log(returnData['status']);
	        	console.dir(returnData);

	        	if(returnData['status'] == 'fail')
	        	{
	        		jQuery.each(returnData['error'], function(index, value) 
					{
				       $('#' + index + 'Error').html(value);
				   });
	        	}else
	        	{
	        		$('#NewPassForm').submit();
	        	}
	        },

	        error:function(xhr, ajaxOptions, thrownError)
	        {
	            console.log('server error: ', xhr.responseText);
	        }
   		});
	});

	var stuOrNot = '<?php echo $basicData['stuOrNot'] ?>';
	newPassInput.onblur = function()
	{
		var inputJsonData = 
	    {
	    	stuOrNot		: stuOrNot,
	    	myid			: schoolID,
	    	whichInput		: 'newPass',
	    	newPass 		: newPassInput.value,
	    };
	    inputAjax(inputJsonData, newPassInput);
	}

	newPass_confirmation_input.onblur = function()
	{
		var inputJsonData = 
		{
			stuOrNot				: stuOrNot,
			myid					: schoolID,
			whichInput				: 'newPass_confirmation',
			newPass_confirmation 	: newPass_confirmation.value,
		};
		inputAjax(inputJsonData, newPass_confirmation_input);
	}

	/*****************************************
		即時驗證
	******************************************/
	function inputAjax(inputData, whichInput)
	{
	    var URLs = $('#NewPassForm').attr('action') + '/validation';

	    var laravelAuthTokenForPost = $('input[name=_token]').val();
	    inputData['_token'] = laravelAuthTokenForPost;

	    $.ajax(
	    {
	        url: URLs,
	        data: inputData,
	        type:"post",
	        dataType: "json",

	        success: function(returnData)
	        {
	        	console.dir(returnData);
	        	console.log(returnData['status']);

	        	if(returnData['status'] == 'fail')
	        	{
	        		$('#' + inputData['whichInput'] + 'Error').html(
	        			returnData['error'][inputData['whichInput']]
	        			);
	        	}else
	        	{
	        		$('#' + inputData['whichInput'] + 'Error').html('');
	        	}
	        },

	         error:function(xhr, ajaxOptions, thrownError)
	         {
	            console.log('server error: ', xhr.responseText);
	         }
   		});
	}
</script>

@stop