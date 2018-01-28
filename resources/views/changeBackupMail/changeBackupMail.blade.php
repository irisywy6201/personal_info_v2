@extends("layout")
@section("content")

<span style="font-size: 30px; font-family: 標楷體; font-weight: bold;">更改備用信箱：</span><br><br>

{{ Form::open(array('url'=>'changeBackupMail', 'method'=>'post', 'id'=>'changeBackupMailForm')) }}
	{{--
		{{ Form::radio('identity', 'staff', null, array('id'=>'staff','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('staff','教職員', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}
		&nbsp&nbsp&nbsp

		{{ Form::radio('identity', 'student', null, array('id'=>'student','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('student','學生', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}
		&nbsp&nbsp&nbsp
		{{ Form::radio('identity', 'alumni', null, array('id'=>'alumni','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('alumni','畢業校友', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}<br><br><br>
	--}}
	{{ Form::label('pwInput','請輸入密碼：',array('id'=>'','class'=>'')) }}<br>
	{{ Form::text('pwInput','',array('id'=>'pwInput','class'=>'')) }}<br><br><br>

	{{ Form::label('newMailInput','請輸入新信箱：',array('id'=>'','class'=>'')) }}<br>
	{{ Form::text('newMailInput','',array('id'=>'newMailInput','class'=>'')) }}<br><br><br>

	{{ Form::label('newMailInputAgain','請再次輸入新信箱：',array('id'=>'','class'=>'')) }}<br>
	{{ Form::text('newMailInputAgain','',array('id'=>'newMailInputAgain','class'=>'')) }}<br><br><br>
{{ Form::close() }}


<div id="somethingBlank" style="color: red; font-size: 18px; display: none;">尚有欄位未填寫！</div>
<div id="passNotSame" style="color: red; font-size: 18px; display: none;">輸入信箱不相同！</div>
<div id="emailFormat" style="color: red; font-size: 18px; display: none;">信箱格式錯誤！</div>
<div id="errorBack" style="color: red; font-size: 18px; display: none;">密碼不符！</div>

<button id="button" type="button">送出</button>

<script>
var errorBack = "<?php echo Session::get('error'); ?>";
if(errorBack == 'error')
{
	$("#errorBack").show();
}

var pwInput = document.getElementById("pwInput");
var newMailInput = document.getElementById("newMailInput");
var pwNewAgain = document.getElementById("newMailInputAgain");

$("#button").click(function(){
	var pwInputFlag 			= 0;
	var newMailInputFlag 		= 0;
	var newMailInputAgainFlag 	= 0;
	var theSameFlag				= 0;
	//var radioFlag				= 0;
	var emailFormatFlag			= 0;

	var blankFlag				= 0;
	var finalFlag 				= 0;

	var new1Value = newMailInput.value;
	var new2Value = newMailInputAgain.value;

	if(pwInput.value.length != "")
	{
		pwInputFlag =  1;
	}

	if(new1Value.length != "")
	{
		newMailInputFlag =  1;
	}

	if(new2Value.length != "")
	{
		newMailInputAgainFlag =  1;
	}

	/*
	if(radioSelectedCheck() == 1)
	{
		radioFlag = 1;
	}
	*/

	if(new1Value == new2Value)
	{
		theSameFlag = 1;
	}

	//blankFlag = pwInputFlag * newMailInputFlag * newMailInputAgainFlag * radioFlag;
	blankFlag = pwInputFlag * newMailInputFlag * newMailInputAgainFlag;

	if(blankFlag == 0)
	{
		$("#somethingBlank").show();
	}

	if(theSameFlag == 0)
	{
		$("#passNotSame").show();
	}

	if(checkEmailFormat(new1Value) == 1)
	{
		emailFormatFlag = 1
		console.log("adsfasdf");
	}else
	{
		console.log("qewrqwer");
		$("#emailFormat").show();
	}

	finalFlag = blankFlag * theSameFlag * emailFormatFlag;

	if(finalFlag == 1)
	{
		$("#changeBackupMailForm").submit();
	}
});

function radioSelectedCheck()
{
	var atLeastOne = 0;
	$('input:radio').each(function(){
		if($(this).prop('checked'))
		{
			atLeastOne++;
		}

	}); 

	if(atLeastOne == 0)
	{
		return 0;
	}else
	{
		return 1;
	}	
}

function checkEmailFormat(emailInput)  
{
	var emailFormat = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

	if(emailInput.search(emailFormat))
	{
		return 0;
	}else
	{
		return 1;
	}

	/*
	\w：表示任何一個字元與數字以及 '_' ，意同 [a-zA-Z0-9_] 。
	
	^ ：寫在 pattern 第一個位置時，表示其後一符號必須出現在字串開頭的位置。
		寫在 pattern 中間位置時則為否定之意，表示字串中不可有 ^ 之後一符號的內容。

	$：寫在 pattern 最後一個位置時，表示其前一符號必須出現在字串尾端的位置。寫在 pattern 中時無特別意義。

	*：表示字串中有 0 到無數個其前一符號的內容。

	+：表示字串中有 1 到無數個其前一符號的內容。

	?：表示字串中有 0 到 1個其前一符號的內容。

	{ }：表示前一符號在字串中的重覆次數。例如 /A{2}/ 表示 'A' 重覆兩次 (即 'AA') ；/A{2,}/ 表示字串含有 2 到無數多個 'A' ；/A{2,5}/ 表示含有 2 到 5 個 'A' 。


	(1) 必須以一個以上的文字&數字開頭
	(2) @ 之前可以出現 1 個以上的文字、數字與「-」的組合，例如 -abc-
	(3) @ 之前可以出現 1 個以上的文字、數字與「.」的組合，例如 .abc.
	(4) @ 之前以上兩項以 or 的關係出現，並且出現 0 次以上
	(5) 中間一定要出現一個 @
	(6) @ 之後出現一個以上的大小寫英文及數字的組合
	(7) @ 之後只能出現「.」或是「-」，但這兩個字元不能連續時出現
	(8) @ 之後出現 0 個以上的「.」或是「-」配上大小寫英文及數字的組合
	(9) @ 之後出現 1 個以上的「.」配上大小寫英文及數字的組合，結尾需為大小寫英文

	*/
}
</script>

@stop