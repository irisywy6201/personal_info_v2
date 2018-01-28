@extends("layout")
@section("content")



<!--
<form>
	<label>請輸入備用信箱：</label>
    <input id = "email" name="email" type="email" placeholder="{{ Lang::get('admin.emailPlaceHolder') }}">
    <label id="emailWrong" style="color: red; display: inline;">信箱格式錯誤！</label>
</form><br><br>
-->
    <form id="hiddenForm" name="hiddenForm" >
        {!! Form::text('hiddenText', '', ['id' => 'hiddenText']) !!}<br>
    </form>

	{!! Form::open([
        'url' => 'addBackupMail',
        'id' => 'fileinfo',
        'method' => 'post',
        'files' => true,
        'accept-charset' => 'UTF-8'
        ])
    !!}
        <div>
            <label>請選擇身分證 "正面" 檔案：</label>
		    {!! Form::file('fileup', ['class' => 'upload_file', 'id' => 'fileup']) !!}
		    <img id="upimg" style="width: 300px; display: none;" src="">
        </div>
        <br><br><br><br>
        <div>
            <label>請選擇身分證 "反面" 檔案</label>
            {!! Form::file('filedown', ['class' => 'upload_file', 'id' => 'filedown']) !!}
            <img id="downimg" style="width: 300px; display: none;" src="">
        </div>
	{!! Form::close() !!}
	<br><br>
    <!--<input type="button" value="送出" onclick="checkMail()">-->
    <input id="button" type="button" value="送出">
    </body>
<br><br>

<script>

 var allRightFlag = 0;
 //var checkMailFlag = 0;
 var sendImgFlag = 0;
 var upImgFlage = 0;
 var downImgFlag = 0;


/*
$("#email").change(function(){
    checkMail();
});
*/

 $("#fileup").change(function(){
    sendImg("fileup");
    upImgFlage = 1;
 });
  $("#filedown").change(function(){
    sendImg("filedown");
    downImgFlag = 1;
 });

function finalCheck()
{
    sendImgFlag = upImgFlage * downImgFlag;
    allRightFlag = sendImgFlag;
    //allRightFlag = checkMail * sendImgFlag;
    if(allRightFlag == 1) // user all done
    {
        $("#hiddenForm").submit();
    }else // something not finished yet
    {

    }
}

var pastUpImgName = "";
var pastDownImgName = "";

function sendImg(upORdown)
{
    var data = new FormData();
    if(upORdown == "fileup")
    {
        console.log("in up " + upORdown);
        console.log("pastUpImgName: " + pastUpImgName);
        var fileup = document.getElementById("fileup").files[0];
        data.append("fileup", fileup); 
        data.append("pastUpImgName", pastUpImgName);
    }

    if(upORdown == "filedown")
    {
        console.log("in down " + upORdown);
        var filedown = document.getElementById("filedown").files[0];
        data.append("filedown", filedown);
        data.append("pastDownImgName", pastDownImgName);
    }


    var URLs="addBackupMail";
    $.ajax({
        url: URLs,
        data: data,
        type:"post",
        dataType:"json",

        cache: false,
        processData: false, // 告訴jQuery不要去處理發送的數據
        contentType: false, // 告訴jQuery不要去設置Content-Type請求頭

        success: function(data){
            console.log("pastDownImgName: " + data[7]);
            console.log("pastUpImgName:" + data[6]);
            /*
                store the old file name in passDownImgName and passUpImgName
            */
            pastDownImgName = data[7];
            pastUpImgName = data[6];

            console.log(data[4]);
            console.log(data[3]);
            console.log(data[2]);
            if(data[1] == "up")
            {
                var upImg = document.getElementById("upimg");
                upImg.src = data[0];
                upImg.style.display = "inline";

            }
            
            if(data[1] == "down")
            {
                var downImg = document.getElementById("downimg");
                downImg.src = data[0];
                downImg.style.display = "inline";
            }
            console.log(data[1]);
        	
        },

         error:function(xhr, ajaxOptions, thrownError){
            console.log("WTF");
            //alert(xhr.status);
            //alert(thrownError);
         }
    });
   
}

/*
function checkMail()
{
	var mail_input = document.getElementById("email").value;
	var mail_length = mail_input.length;  

	var temp1 = mail_input.indexOf('@');     
	var temp2 = mail_input.indexOf('.');// first dot

	if (temp1 > 0) 
	{
		if ((mail_length - temp1) > 2)
		{     
			if ((mail_length - temp2) > 0) // last one can't be dot
			{     
				checkMailFlag = 1;
                document.getElementById("emailWrong").style.display = "none";
			}else
            {
                checkMailFlag = 0;
                document.getElementById("emailWrong").style.display = "inline";
            }
    
		}else
        {
            checkMailFlag = 0;
            document.getElementById("emailWrong").style.display = "inline";
        }    
	}
    else
    {
        checkMailFlag = 0;
        document.getElementById("emailWrong").style.display = "inline";
    }    
} 
*/
</script>

@stop