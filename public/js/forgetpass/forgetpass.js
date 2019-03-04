/************************************************
	選擇其中一種身分 (教職員 學生 校友)
************************************************/
$(".account").hide();
$("#schoolID").hide();

$('#staffRB').click(function(){
	$("#chooseFirst").hide();
	$(".account").hide();
	$(".staff").show(500);
	$("#schoolID").show(500);
});

$('#studentRB').click(function(){
	$("#chooseFirst").hide();
	$(".account").hide();
	$(".student").show(500);
	$("#schoolID").show(500);
});
$('#alumniRB').click(function(){
	$("#chooseFirst").hide();
	$(".account").hide();
	$(".alumni").show(500);
	$("#schoolID").show(500);
});


/********************************
    無法完成忘記密碼
********************************/
$('#failSlideButton').click(function()
{
    $("#failDiv").slideToggle();
});

var emailInput = document.getElementById('email');
var phoneInput = document.getElementById('phone');

$('#failButton').click(function()
{

    //$('#dialog').css('z-index', '1000');
    var a = $('#dialog').css('z-index');
    $('#shadow').css('z-index', a);
    $('#shadow').show();

    var identity = document.getElementsByName('identity');
    var identity_value;
    for(var i = 0; i < identity.length; i++)
    {
        if(identity[i].checked)
        {
            identity_value = identity[i].value;
        }
    }
    $("#dialog").dialog(
    {
        title: 'warning',
        autoOpen: false,
        modal: true,
        resizable:false,

        open: function()
        {
          var dialogContent =
          '您輸入的資料為:<br><br>' +
          '姓名:   ' + usernameInput.value + '<br>' +
          '身分:   ' + identity_value + '<br>' +
          '學號:   ' + schoolIdInput.value + '<br>' +
          '身分證: ' + identifyNumberInput.value + '<br>' +
          '生日:   ' + datepickerInput.value + '<br>' +
          '信箱:   ' + emailInput.value + '<br>';

          if(phoneInput.value != '')
          {
            dialogContent =
            dialogContent + '電話: ' + phoneInput.value + '<br>';
          }
          else
          {
            dialogContent =
            dialogContent + '電話: ' + '您沒有輸入電話號碼' + '<br>';
          }
          
          dialogContent = dialogContent + '<br>' + '您確定要送出嘛？<br>';
          $(this).html(dialogContent);
        },

        buttons:{
            'send':
            {
                text:'確定',
                class:'save-button ui-button btn btn-default',
                click: function()
                {
                    sendMailAjax();
                    $('#dialog').dialog('close');
                    $('#shadow').hide();
                }
            },

            'cancel':
            {
                text:'取消',
                class:'cancel-button ui-button btn btn-default',
                click: function()
                {
                    $('#dialog').dialog('close');
                    $('#shadow').hide();
                }
            }
        },
    });

    $('#dialog').dialog('open');
});


function sendMailAjax()
{
    var URLs        = $('#FGform').attr('action') + '/forgetpassFail';
    var newFormData = new FormData();

    newFormData.append('username', usernameInput.value);
    newFormData.append('schoolID', schoolIdInput.value);
    newFormData.append('identifyNumber', identifyNumberInput.value);
    newFormData.append('datepicker', datepickerInput.value);
    newFormData.append('email', emailInput.value);
    newFormData.append('phone', phoneInput.value);

    var laravelAuthTokenForPost = $('#FGform').find('input[name="_token"]').val();

    newFormData.append('_token', laravelAuthTokenForPost);


    var identity = document.getElementsByName('identity');
    var identity_value;
    for(var i = 0; i < identity.length; i++)
    {
        if(identity[i].checked)
        {
            identity_value = identity[i].value;
        }
    }

    newFormData.append('stuOrNot', identity_value);
    $('#loading').show();

    $.ajax(
    {
        url: URLs,
        data: newFormData,
        type:"post",
        processData: false,
        contentType: false,
        dataType: "json",

        success: function(returnData)
        {
            console.log('ajax success');
            
            console.dir(returnData);
            $('.errorMsg').val('');

            if(returnData['status'] == 'fail')
            {
                console.log('validation fail');
                
                jQuery.each(returnData['error'], function(index, value)
                {
                   $('#' + index + 'Error').html(value);
                });
            }else
            {
                console.log('validation pass');
                console.log(returnData['mailStatus']);

                $('#mailMessage').html(returnData['mailMessage']);

                if(returnData['mailStatus'] == 'passMail')
                {
                    $( "#failButton" ).prop('disabled', true);
                }
            }
            $('#loading').hide();

            
        },

         error: function(xhr, ajaxOptions, thrownError)
         {
            console.log('server error: ', xhr.responseText);
         }
    });
}

/************************************************
	取得輸入日期並轉為民國年份
************************************************/
//var datepicker = new Pikaday({ field: jQuery('#datepicker')[0]});

birthdayInput = document.getElementById('datepicker');

birthdayInput.onchange = birthdayProcess;
birthdayInput.value = '';

function birthdayProcess()
{
	var combineValue='';
	if(birthdayInput.value != '')
	{
		// 西元轉民國
		var splitValue	= birthdayInput.value.split("-");
		combineValue	= splitValue[0] - 1911 + splitValue[1] + splitValue[2];
	}

	document.getElementById("datepickerHide").value = combineValue;

	var inputJsonData =
    {
        whichInput	: 'datepicker',
        datepicker	: combineValue,
    };
	inputAjax(inputJsonData, birthdayInput);
}


/************************************************
	ajax and submit 驗證資料正確性
************************************************/
var usernameInput		= document.getElementById("username");
var schoolIdInput		= document.getElementById("schoolID");
var identifyNumberInput = document.getElementById("identifyNumber");
var datepickerInput		= document.getElementById('datepicker');

identifyNumberInput.onblur = function()
{
    var inputJsonData =
    {
        whichInput		: 'identifyNumber',
        identifyNumber	: identifyNumberInput.value,
    };
	inputAjax(inputJsonData, identifyNumberInput);
};

schoolIdInput.onblur = function()
{
	var inputJsonData =
    {
        whichInput	: 'schoolID',
        schoolID	: schoolIdInput.value,
    };
	inputAjax(inputJsonData, schoolIdInput);
};

usernameInput.onblur = function()
{
	var inputJsonData =
    {
        whichInput	: 'username',
        username	: usernameInput.value,
    };
	inputAjax(inputJsonData, usernameInput);
};

// 即時驗證(單一輸入資料)
function inputAjax(inputData, whichInput)
{
    var URLs = $('#FGform').attr('action') + '/validation';
    var laravelAuthTokenForPost = $('#FGform').find('input[name="_token"]').val();

    inputData['_token'] = laravelAuthTokenForPost;

    $.ajax(
    {
        url: URLs,
        data: inputData,
        type:"post",
        dataType: "json",

        success: function(returnData)
        {
            
            $('.errorMsg').html('');
            console.log(returnData['status']);

            if(returnData['status'] == 'fail')
            {
                console.log('#' + inputData['whichInput'] + 'Error');
                $('#' + inputData['whichInput'] + 'Error').html(returnData['error'][inputData['whichInput']]);
            }
            
        },

         error:function(xhr, ajaxOptions, thrownError)
         {
            //console.log('hahaha');
           // console.dir('server error: ', xhr.status);
            //
            console.log('statusText:  ' + xhr.statusText);
            console.log('status:  ' + xhr.status);
            console.log('readyState:  ' + xhr.readyState);
            console.log('responseXML: ' + xhr.responseXML);
            //console.log('responseText:  ' + xhr.responseText);
            //console.log('getResponseHeader:  ' + xhr.getResponseHeader());
            console.log('statusCode: ' + xhr.statusCode);
            console.log('abort: ' + xhr.abort);
            /*
            0: 請求未初始化
            1: 服務器連接已建立
            2: 請求已接收
            3: 請求處理中
            4: 請求已完成，且響應已就緒
            */
            console.log('ajaxOptions: ' + ajaxOptions);
            console.log("thrownError: " + thrownError);
         }
	});
}

// 最後驗證(所有表單資料)
$('#FGbutton').click(function()
{
	var URLs = $('#FGform').attr('action') + '/final';
	var newFormData = new FormData();

    var identity = document.getElementsByName('identity');
    var identity_value;
    for(var i = 0; i < identity.length; i++)
    {
        if(identity[i].checked)
        {
            identity_value = identity[i].value;
        }
    }

    newFormData.append('stuOrNot', identity_value);

	newFormData.append("username", usernameInput.value);
	newFormData.append('schoolID', schoolIdInput.value);
	newFormData.append("identifyNumber", identifyNumberInput.value);
	newFormData.append('datepicker', datepickerInput.value);
    console.log(datepickerInput.value);

    var laravelAuthTokenForPost = $('#FGform').find('input[name="_token"]').val();

    newFormData.append('_token', laravelAuthTokenForPost);

    $.ajax(
    {
        url: URLs,
        data: newFormData,
        type:"post",
        processData: false,
		contentType: false,
        dataType: "json",

        success: function(returnData)
        {
            console.log('button status: ' + returnData['status']);
            console.log(JSON.stringify(returnData));
            $('.errorMsg').html('');

            if(returnData['status'] == 'fail')
            {
                jQuery.each(returnData['error'], function(index, value)
                {
                    console.log('index: ' + index);
                    console.log('value: ' + value);
                    $('#' + index + 'Error').html(value);
                });
            }else
            {
                $('#FGform').submit();
            }
        },

         error:function(xhr, ajaxOptions, thrownError)
         {
            console.log('server error: ', xhr.responseText);
         }
	});

});
