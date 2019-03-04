@extends("layout")
@section("content")



<div id="changePass_main_div">
	<span style="font-size: 30px; font-family: 標楷體; font-weight: bold;">更改密碼：</span><br><br>

	{{-- label 的 第一個參數為 for 屬性 --}}
	{{-- text 的 第一個參數為 name 屬性 --}}
	{{-- select name, option values, selected, other --}}
	{{-- radio name, value, checked, other--}} {{-- 設定相同 name => 單選 --}}
	{{ Form::open(array('url'=>'changePass', 'method'=>'post', 'id'=>'CPform')) }}
		
		
		{{ Form::radio('identity', 'staff', null, array('id'=>'staff','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('staff','教職員', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}

		&nbsp&nbsp&nbsp

		{{ Form::radio('identity', 'student', null, array('id'=>'student','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('student','學生', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}

		&nbsp&nbsp&nbsp

		{{ Form::radio('identity', 'alumni', null, array('id'=>'alumni','class'=>'radio', 'style'=>'display: inline;')) }}
		{{ Form::label('alumni','畢業校友', array('id'=>'','class'=>'', 'style'=>'display: inline;')) }}<br><br><br>
		
{{--
		{{ Form::label('username','姓名:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('username','',array('id'=>'username','class'=>'input')) }}<br>

		{{ Form::label('schoolID','portal帳號:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('schoolID','',array('id'=>'schoolID','class'=>'input')) }}<br>

		{{ Form::label('identifyNumber','身份證字號:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('identifyNumber','',array('id'=>'identifyNumber','class'=>'input')) }}<br><br>
		
		{{ Form::label('birthday','出生年月日:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::select('year', array(), 'default', array('id' => 'year', 'class' => 'sel_year')) }}
		{{ Form::select('month', array(), 'default', array('id' => 'month', 'class' => 'sel_year')) }}
		{{ Form::select('day', array(), 'default', array('id' => 'day', 'class' => 'sel_year')) }}<br><br>
--}}
		{{ Form::label('oldPass','請輸入舊密碼:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('oldPass','',array('id'=>'oldPass','class'=>'input')) }}<br><br><br>
{{--
		{{ Form::label('newPass','請輸入新密碼:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('newPass','',array('id'=>'newPass','class'=>'input')) }}<br>

		{{ Form::label('newPassAgain','再次輸入新密碼:',array('id'=>'','class'=>'')) }}<br>
		{{ Form::text('newPassAgain','',array('id'=>'newPassAgain','class'=>'input')) }}<br>
			<br><br><br>
--}}
		<input id="button" type="button" value="送出驗證信" onclick="finalCheck()">
	{{ Form::close() }}

    <div id="blankError" class="errorMsg" style="color: red; display: none;">尚有欄位未輸入！</div>
    <div id="lengthError" class="errorMsg" style="color: red; display: none;">身份證字號長度錯誤！</div>
    <div id="dataError" class="errorMsg" style="color: red; display: none;">輸入資料不符！</div>
    <div id="formatError" class="errorMsg" style="color: red; display: none;">密碼格式錯誤！</div>
    <div id="notSameError" class="errorMsg" style="color: red; display: none;">兩次輸入密碼不同！</div>
</div>

<script>

	var errorBack = "<?php echo Session::get('error'); ?>";
	if(errorBack == "error")
	{
		console.log(errorBack);
		$("#dataError").show();
	}
	else
	{
		console.log(errorBack);
	}

	/*
	var year 			= document.getElementById("year");
	var month 			= document.getElementById("month");
	var day 			= document.getElementById("day");
	var newpass			= document.getElementById("newPass");
	var newPassAgain 	= document.getElementById("newPassAgain");
	*/
	var oldPass			= document.getElementById("oldPass");


	var inputAreaId 	= new Array("oldPass");
	//var birthdayMenu 	= new Array("year", "month", "day");
	

	function finalCheck()
	{
		var checkBlank 	= 1;
		//var checkLength = 1;

		for(var i = 0; i < inputAreaId.length; i++)
		{
			var inp = document.getElementById(inputAreaId[i]).value;
			if(inp == "")
			{
				checkBlank = 0;
			}
		}

		/*
		for(var i = 0; i < birthdayMenu.length; i++)
		{
			var bir = document.getElementById(birthdayMenu[i]).value;
			console.log(bir);
			if(bir == "--")
			{
				checkBlank = 0;
			}
		}

		*/

		if(radioSelectedCheck() == 0)
		{
			checkBlank = 0;
		}

		$(".errorMsg").hide();

		/*
		if(identifyNameCheck() == 0)
		{
			checkLength = 0;
			
			$("#lengthError").show();
			console.log("身分證 長度不正確");
		}
		*/

		if(checkBlank == 0)
		{
			$("#blankError").show();
			console.log("something blank");
		}
		
		if(checkBlank == 1 )
		{
			//if(checkLength == 1)
			//{
				$(".errorMsg").hide();
				console.log("all done");
				$("#CPform").submit();
			//}
		}
	}

	function radioSelectedCheck()
	{
		var atLeastOne = 0;
		$('input:radio').each(function(){
			console.log("wa wa wa");
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

/*
	function identifyNameCheck()
	{
		var idNameValue = document.getElementById("identifyNumber").value;
		var id_length 	= idNameValue.length;
		if(id_length != 10)
		{
			return 0;
		}
		return 1;
	}
	*/


/*
	var date 		= new Date();
	var now_year 	= date.getFullYear();
	var lowest_year = "1900";
	

	function create_option(create_value, id)
	{
		var year_select = document.getElementById(id);
		var option_html = document.createElement("option");
		option_html.appendChild(document.createTextNode(create_value));
		year_select.appendChild(option_html);
	}

	create_option("--", "year");
	create_option("--", "month");
	create_option("--", "day");

	for(var i = now_year; i >= lowest_year; i--)
	{
		create_option(i, "year");
	}


	year.onchange = changeYearMount;
	function changeYearMount()
	{
		if (year.value == "--")
		{
			cleanMonth();
			cleanDay();
			
		}else
		{
			for(var i = 1; i <= 12; i++)
			{
				create_option(i, "month");
			}
			
			for(var i = 0; i < month.children.length; i++)
			{
				month.children[i].className += "month_class";
			}

			if(month.value == "2")
			{
				day.value = "--";
				cleanDay();
				cleanMonth();
				for(var i = 1; i <= 12; i++)
				{
					create_option(i, "month");
				}

				changeDayMount();
				LeapYear();
			}
		}
	}
*/

/*
	month.onchange = changeDayMount;
	function changeDayMount()
	{
		if (year.value == "--")
		{
			cleanDay();
			cleanMonth();
		}
		else
		{
			var bigMonth = new Array("1", "3", "5", "7", "8", "10", "12");
			var flag = bigMonth.some(function(value, index, array)
			{
				return value == month.value? true: false;
			});


			cleanDay();

			if(flag == true)
			{
				for(var i = 1; i <= 31; i++)
				{
					create_option(i, "day");
				}
			}else if(flag == false && month.value != "2")
			{
				for(var i = 1; i <= 30; i++)
				{
					
					create_option(i, "day");
				}
			}else
			{
				LeapYear();
			}
		}	
	}

*/
/*
	newPass.onchange = passFormatCheck;
	function passFormatCheck()
	{
		var staffRadio 		= document.getElementById("staff");
		var studentRadio	= document.getElementById("student");;
		var radioCheck		= 0;

		var enNumBool	  	= 0;

		var lowerNum		= 0;
		var upperNum		= 0;
		var isNum			= 0;
		var isOthersSymbol	= 0;

		var newPass 		= $("#newPass").val();
		var strLength 		= newPass.length;

		if(/^[a-z]+$/.test(newPass.substring(0,1)))
		{
			enNumBool = 0;
			console.log("第一個字是小寫");
			$("#formatError").show();
		}

		if(strLength < 8)
		{
			console.log("密碼字數至少為 8");
			enNumBool = 0;
			$("#formatError").show();
		}

		for(var i = 0; i < strLength; i++)
		{
			var temp = newPass.charAt(i);
			//console.log(temp);
			if(/^[A-Z]+$/.test(temp))
			{
				upperNum++;
				//console.log("大寫");

			}else if(/^[a-z]+$/.test(temp))
			{
				lowerNum++;
				//console.log("小寫");
			}else if((temp >= '0') && (temp <=  '9'))
			{
				isNum++;
				console.log("數字");
			}else
			{
				isOthersSymbol++;
				//console.log("奇怪的符號!!!!");
			}
		}

		if(staffRadio.checked)
		{
			var schoolID  = document.getElementById("schoolID").value;
			var isInclude = schoolID.match(newPass);

			if(isInclude == null)
			{
				// 密碼沒有包含教職員 ID
				radioCheck = 1;

			}else
			{
				radioCheck = 0;
			}

		}
		if(studentRadio.checked)
		{
			radioCheck = 1;
			console.log("student selected");
		}

		passSameCheck();
		enNumBool 		= lowerNum * upperNum * isNum;

		if(enNumBool == 0 || isOthersSymbol != 0)
		{
			// 若不包含至少一個 英文 or 數字  ||  存在其他符號 
			$("#formatError").show();
			return 0;
		}else
		{
			$("#formatError").hide();
			console.log("password format correct !");
			return 1;
		}
	}
*/

/*
	newPassAgain.onchange = passSameCheck;
	function passSameCheck()
	{
		var passOne = $("#newPass").val();
		var passTwo = $("#newPassAgain").val();
		if(passOne != passTwo)
		{
			$("#notSameError").show();
		}else
		{
			$("#notSameError").hide();
		}
	}
*/

/*
	function LeapYear()
	{
		if(year.value % 4 == 0)
		{
			for(var i = 1; i <= 29; i++)
			{
				
				create_option(i, "day");
			}
		}else
		{
			for(var i = 1; i <= 28; i++)
			{
				
				create_option(i, "day");
			}
		}
	}
*/

/*
	function cleanDay()
	{
		while(day.lastChild.value != "--")
		{
			day.removeChild(day.lastChild);
		}
	}

	function cleanMonth()
	{
		while(month.lastChild.value != "--")
		{
			month.removeChild(month.lastChild);
		}
	}
*/
</script>
@stop