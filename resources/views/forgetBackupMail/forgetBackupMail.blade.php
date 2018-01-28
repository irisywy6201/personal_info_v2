@extends("layout")
@section("content")

   <div class="jumbotron">
        {!! Form::open(array('url'=>'forgetBackupMail', 'method'=>'post', 'id'=>'hiddenForm')) !!}

             <div class="form-group">
                {!! Form::label('email', Lang::get('forgetpass/forgetBackupMail.email.email')) !!}
                <br>

                <span class="must-fill">
                    {{ Lang::get('forgetpass/forgetBackupMail.email.afterValidation1') }}
                    <br>
                    {{ Lang::get('forgetpass/forgetBackupMail.email.afterValidation2') }}
                </span>

                {!! Form::text('email', '', array('id'=>'email', 'class'=>'input form-control')) !!}
                <br>
                <span id="emailError" class="must-fill errorMsg"></span>
            </div>

            {!! Form::hidden('hiddenText', "", array('id'=>'hiddenText')) !!}
            {!! Form::hidden('cardFrontPath', "", array('id'=>'cardFrontPath')) !!}
            {!! Form::hidden('cardBackPath', "", array('id'=>'cardBackPath')) !!}

        {!! Form::close() !!}
    </div>
    
    <div class="jumbotron">
    	{!! Form::open(array('url' => 'forgetBackupMail', 'id'=>'fileinfo', 'method'=>'post', 'files'=>true, 'accept-charset'=>'UTF-8',)) !!}
            
            <div style="height: 300px;">
                <span class="must-fill">
                    {{ Lang::get('forgetpass/forgetBackupMail.jpgPngOnly') }}
                </span>

                <br>
                <span class="must-fill">
                    {{ Lang::get('forgetpass/forgetBackupMail.choseFront') }}
                </span>

    		    {!! Form::file('fileup', ['class' => 'upload_file', 'id'=>'fileup']) !!}
    		    <img id="upimg" style="height: 200px; display: none;" src="">
                <br>
                <span id="fileupError" class="must-fill errorMsg"></span>
            </div>

            <div style="height: 300px;">
                <span class="must-fill">
                    {{ Lang::get('forgetpass/forgetBackupMail.jpgPngOnly') }}
                </span>
                <br>
                
                <span class="must-fill">{{ Lang::get('forgetpass/forgetBackupMail.choseBack') }}</span>
                {!! Form::file('filedown', array('class' => 'upload_file', 'id'=>'filedown')) !!}
                <img id="downimg" style="height: 200px; display: none;" src="">
                <br>
                <span id="filedownError" class="must-fill errorMsg"></span>
            </div>

            <input id="button" type="button" class="btn btn-default" value={{ Lang::get('forgetpass/forgetBackupMail.submit') }}>

            <span id='processing' style='display: none;'>
                {!! HTML::image('http://jimpunk.net/Loading/wp-content/uploads/loading45.gif', '', array('style' =>'width: 250px;')) !!}
                <span style='font-weight: bold;'>processing ... please wait ... </span>
            </span>

            <br>
            <span class='must-fill'>{{ Session::get('serverError') }}</span>

    	{!! Form::close() !!}
    </div>

<br><br>

<?php
    $inputData = array(
        "username"  => Session::get('username'),
        "schoolID"  => Session::get('schoolID'),
        "IdeID"     => Session::get('IdeID'),
        "stuOrNot"  => Session::get('stuOrNot'),
        'wholeBir'  => Session::get('wholeBir')
    );
?>

<script>

    var emailInput          = document.getElementById('email');
    var cardFrontPathInput  = document.getElementById('cardFrontPath');
    var cardBackPathInput   = document.getElementById('cardBackPath');

    $("#fileup").change(function()
    {
        sendImgAjax("fileup");
    });

    $("#filedown").change(function()
    {
        sendImgAjax("filedown");
    });

    emailInput.onblur = function() 
    {
        var inputJsonData = 
        {
            whichInput      : 'email',
            email           : emailInput.value,
        };
        inputAjax(inputJsonData, emailInput);
    };

    /****************************************************
        即時驗證 email
    ****************************************************/
    function inputAjax(inputData, whichInput)
    {
        var URLs = $('#hiddenForm').attr('action') + '/validation';
        var laravelAuthTokenForPost = $('#hiddenForm').find('input[name="_token"]').val();
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
                    jQuery.each(returnData['error'], function(index, value) 
                    {
                       $('#' + index + 'Error').html(value);
                    });
                }
            },

             error:function(xhr, ajaxOptions, thrownError)
             {
                console.log('server error: ', xhr.responseText)
             }
        });
    }

    /****************************************************
        submit 驗證所有 input
    ****************************************************/
    $('#button').click(function()
    {
        $('#processing').show();
        var URLs = $('#hiddenForm').attr('action') + '/final';

        var newFormData =  new  FormData();

        newFormData.append("email" , emailInput.value);
        //newFormData.append("hiddenText" , '<?php echo implode(" ", $inputData);?>');
        newFormData.append('cardFrontPath', cardFrontPathInput.value);
        newFormData.append('cardBackPath', cardBackPathInput.value);

        var laravelAuthTokenForPost = $('#hiddenForm').find('input[name="_token"]').val();
        newFormData.append('_token', laravelAuthTokenForPost)

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
                        console.log('index: ' + index);
                        if(index == 'cardFrontPath')
                        {
                            $('#fileupError').html(value);
                        }

                        if(index == 'cardBackPath')
                        {
                            $('#filedownError').html(value);
                        }

                        if(index == 'email')
                        {
                            $('#emailError').html(value);
                        }
                   });
                    
                }else
                {
                    $('#hiddenText').val('<?php echo implode(" ", $inputData);?>');
                    $('#hiddenForm').submit();
                }
            },

            error: function(xhr, ajaxOptions, thrownError)
            {
                console.dir(xhr.responseText);
            }
        });
    });

    /****************************************************
        上傳檔案限制(phpinfo)：
        upload_max_filesize => 上傳檔案大小限制(預設15MB)
        post_max_size       => post method 總上傳大小限制(預設8M)(包含文字資料及檔案)
    ****************************************************/
    function sendImgAjax(upORdown)
    {
        var data        = new FormData();
        var fileSize    = 0;

        /***********************
            身分證正面檔案上傳   
        ************************/
        if(upORdown == "fileup")
        {
            var fileup  = document.getElementById("fileup").files[0];
            console.dir("fileup: " + fileup);
            fileSize    = fileup.size/1024/1024; // MB
            console.log("filesize: " + fileSize);

            /***********************
                檔案大小需 < 2M   
            ************************/
            
            if(fileSize > 2)
            {
                $('#fileupError').html('{{ Lang::get('forgetpass/forgetBackupMail.lessThan2M') }}');
                
                var upImg = document.getElementById("upimg");
                upImg.style.display = "none";
                cardFrontPathInput.value = '';
            }else
            {
                data.append("fileup", fileup);
            }
            
        }

        /***********************
            身分證反面檔案上傳   
        ************************/
        if(upORdown == "filedown")
        {

            var filedown    = document.getElementById("filedown").files[0];
            fileSize        = filedown.size/1024/1024; // MB

            /***********************
                檔案大小需 < 2M   
            ************************/
            if(fileSize > 2)
            {
                $('#filedownError').html('the file size must be smaller than 2M');
                var downImg = document.getElementById("downimg");
                downImg.style.display = "none";
                cardBackPathInput.value = '';
            }else
            {
                data.append("filedown", filedown);
            }
        }


        if(fileSize < 2)
        {
            // schoolID 提供 server 命名上傳的照片
            data.append("schoolID", "<?php echo $inputData['schoolID'];?>");
            var laravelAuthTokenForPost = $('#hiddenForm').find('input[name="_token"]').val();

            data.append('_token', laravelAuthTokenForPost);

            var URLs = "forgetBackupMail/imageUpload";
            $.ajax(
            {
                url: URLs,
                data: data,
                type:"post",
                dataType:"json",

                cache: false,
                processData: false, // 告訴jQuery不要去處理發送的數據
                contentType: false, // 告訴jQuery不要去設置Content-Type請求頭

                success: function(returnData)
                {

                    //console.dir('successsssss: ' + returnData);
                    var isSmallEnough   = returnData[0];
                    var inputUpDown     = returnData[1];
                    var fileSize        = returnData[2];
                    var fileExt         = returnData[3];
                    var isExtCorrect    = returnData[4];
                    var newFileName     = returnData[5];
                    var newUpFilePath   = returnData[6];
                    var newDownFilePath = returnData[7];
                
                    /*******************************
                        檔案大於 2M 
                    ********************************/
                    if(isSmallEnough['isSmallEnough'] == 0)
                    {
                        if(inputUpDown == "up")
                        {
                            $('#fileupError').html(isSmallEnough['error']);
                            var upImg           = document.getElementById("upimg");
                            upImg.style.display = "none";
                            cardFrontPathInput.value = '';
                        }
                        else
                        {
                            $('#filedownError').html(isExtCorrect['error']);
                            var downImg                 = document.getElementById("downimg");
                            downImg.style.display       = "none";
                            cardBackPathInput.value     = '';
                        }
                    }

                    /*******************************
                        若附檔名不合法 
                    ********************************/
                    if(isExtCorrect['isExtCorrect'] == 0)
                    {
                        if(inputUpDown == "up")
                        {
                            $('#fileupError').html(isExtCorrect['error']);
                            var upImg                   = document.getElementById("upimg");
                            upImg.style.display         = "none";
                            cardFrontPathInput.value    = '';
                        }
                        else
                        {
                            $('#filedownError').html(isExtCorrect['error']);
                            var downImg             = document.getElementById("downimg");
                            downImg.style.display   = "none";
                            cardBackPathInput.value = '';
                        }
                    }

                    /*******************************
                        若 檔案大小 和 檔案附檔名 均正確 
                    ********************************/
                    if((isSmallEnough['isSmallEnough'] * isExtCorrect['isExtCorrect']) == 1)
                    {
                        if(inputUpDown == "up")
                        {
                            var upImg           = document.getElementById("upimg");
                            upImg.src           = newUpFilePath;
                            upImg.style.display = "inline";

                            $('#fileupError').html('');
                            $("#cardFrontPath").val(newUpFilePath);
                        }
                    
                        if(inputUpDown == "down")
                        {
                            var downImg             = document.getElementById("downimg");
                            downImg.src             = newDownFilePath;
                            downImg.style.display   = "inline";

                            $('#filedownError').html('');
                            $("#cardBackPath").val(newDownFilePath);
                        }
                    }


                },

                 error:function(xhr, ajaxOptions, thrownError)
                 {
                    console.log('failllllllllll');
                    console.dir(xhr.responseText);
                 }
            });
        }
    }
</script>

@stop