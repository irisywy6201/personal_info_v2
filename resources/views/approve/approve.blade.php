@extends("admin.adminLayout")
@section("modifyContent")
<style>


  .ui-dialog-titlebar
  {
    background-color: #FCFCFC;
    height: 50px;
    padding: 10px;
    padding-left: 20px;
    font-size: 25px;
    border-radius: 15px 15px 0px 0px;

  }

  .ui-dialog-content
  {
    background-color: #FCFCFC;
    text-align: center;
    border-top: 1px solid #E0E0E0;
    border-bottom: 1px solid #E0E0E0;
    font-weight: bold;
    font-size: 25px;
    padding-top: 30px;
  }

  .ui-dialog-buttonset
  {
    background-color: #FCFCFC;
    height: 55px;
    text-align: center;
    padding: 7px;
    border-radius:  0px 0px 15px 15px;
  }
  #shadow
  	{
  		background : #000000 ;
      opacity: 0.5 ; /*非IE濾鏡*/
      filter:alpha(opacity= 50 ); /*IE濾鏡*/
      z-index : 1987 ;
      position : fixed ; /*雖然IE6 ​​不支持fixed，這裡依然可以兼容ie6*/
      left : 0px;
      top : 0px;
      width : 100%;
      height : 100%;
      overflow : hidden;
  	}

</style>

  <div id='shadow' style='display: none;'></div>
  <h3 align="center"> <b> 修改密碼身分核准 </b> </h3><br>

  <div style="font-size: 18px; font-weight: bold;">
    目前管理者收件信箱: <span id="emailShow" style="color: blue; font-size: 23px;">{{ $approveManagerEmail }}</span>
    <br>
    (若有新增待審核資料會寄出提醒信件至該信箱)
    <br><br>

    <span>更改管理者信箱:</span>
      {!! Form::text('approveManagerEmail', '',  array('id'=>'emailInput')) !!}
      {!! Form::button('更改', array('id'=>'emailButton')) !!}
    <br>

    最後一次修改為
    <span id="lastTimeChangedBy">{{ $lastTimeChangedBy }}</span>
    於
    <span id="lastChangeTime">{{ $lastChangeTime }}</span>
    修改
  </div>

  <br><br>

  <script>
  $('#emailButton').click(function()
  {
    var emailINput = $('#emailInput').val();
    if(emailINput == '')
    {
      alert("請勿留空白");
    }
    else
    {
      emailAjaxInput();
    }

    function emailAjaxInput()
    {
      var  emailAjaxInput=
      {
          email : emailINput,
      };

      var laravelAuthTokenForPost = $('input[name=_token]').val();
      emailAjaxInput['_token'] = laravelAuthTokenForPost;

      $.ajax(
      {
          url: "/admin/approve/changeManagerEmail",
          data: emailAjaxInput,
          type:"post",
          dataType: "json",

          success: function(returnData)
          {
            $('#emailShow').html(returnData['email']);
            $('#lastChangeTime').html(returnData['created_at']);
            $('#lastTimeChangedBy').html(returnData['changedBy']);
            $('#emailInput').val('');

          },

          error: function(xhr, ajaxOptions, thrownError)
          {
             console.log('server error: ', xhr.responseText);
          }
      });
    }
  });

  </script>

@if ($dataCount != 0)
  {!! Form::open(
    array(
      'url' => 'admin/approve'
      )
    )
  !!}

  <div style='width: 700px; margin: 0px auto;'>
    @foreach($dataList as $key => $value)
      <div>
        <div class='panel-heading' style='background-color: #DDDDDD; border: 1px solid black;'>
          <span>
            編號: {{ $value->id }}
          </span>
          <span style='margin-left: 30%; font-size: 18px;'>
            {{ $value->name.'   ('.$value->stuOrNot.')' }}
          </span>
        </div>

        <table id='imgTable{{ $value->id }}' align='left' style='width: 350px;'>
          <!-- 身分證正面 -->
          <tr>
            <td>
            {!! HTML::Image(
              $value->cardFront, // src
              'Card Front',
              array(
                'style' => 'height: 230px; width: 400px;',
                )
              )
            !!}
            </td>
          </tr>

          <!-- 身分證反面 -->
          <tr>
            <td>
            {!! HTML::Image(
              $value->cardBack, // src
              'Card Back',
              array(
                'style' => 'height: 230px; width: 400px;',
                )
              )
            !!}
          </td>
          </tr>
        </table>


        <table id='infoTable{{ $value->id }}' class='infoTable'>
          <!-- 資料一 -->
          <tr style=''>
            <td>生日</td>
            <td>{{ $value->birthday }}</td>
          </tr>

          <!-- 資料二 -->
          <tr>
            <td>身分證字號</td>
            <td>{{ $value->idNumber }}</td>
          </tr>
          <tr>
            <td>學號</td>
            <td>{{ $value->schoolID }}</td>
          </tr>
          <tr>
            <td>上傳日期</td>
            <td>{{ $value->created_at }}</td>
          </tr>
          <tr>
            <td>電子信箱</td>
            <td>{{ $value->email }}</td>
          </tr>

          <tr>
            <td colspan='2'>
              <div>
                <span id='processing{{ $value->id }}' style='display: none;'>
                  {!! HTML::image('http://jimpunk.net/Loading/wp-content/uploads/loading45.gif', '', array('style' => 'width: 100px;', 'class'=>'porcessingImg')) !!}
                  <span style='font-weight: bold;'>processing ... please wait ... </span>
                </span>
                {!! Form::textarea(
                  'content',
                  null,
                  array(
                    'style' => 'width: 210px; height: 100px;',
                    'id'  => 'content'.$value->id,
                    )
                  )
                !!}

                {!! Form::button(
                  '認證失敗<br>寄出驗證失敗信',
                  array(
                    'id'  => 'fail_'.$value->id,
                    'class' => 'verifyFailButton btn btn-danger',
                    'align' => 'left'
                    )
                  )
                !!}

                {!! Form::button(
                  '審核通過<br>寄出驗證信件',
                  array(
                    'id'  => 'correct_'.$value->id,
                    'class' => 'verifyCorrectButton btn btn-success',
                    )
                  )
                !!}
                <br>
                <span id="failSent{{$value->id}}" style="display: none;">
                  (已寄出駁回信件)
                </span>

                <span id="blank{{$value->id}}" style="display: none;">
                  煩請填寫認證失敗理由 如：非本人的身分證
                </span>

                <span id="correctSent{{$value->id}}" style="display: none;">
                  (已寄出認證信件)
                </span>
              </div>
            </td>
          </tr>
        </table>
      </div>

      <div id='dialog{{$value->id}}' style='display: none; '>
        您確定要寄出驗證信嗎？
      </div>
      <br><br>

    @endforeach
  </div>

  {!! Form::close() !!}



<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script>

  var height = $('#imgTable{{ $value->id }}').css('height');
  $('.infoTable').css('height', height);
  $('img').not('.porcessingImg').css(
    {
      'border-left' : '1px solid black',
      'border-bottom' : '1px solid black'
    }
  );

  $('.infoTable tr td').css(
    {
      'border-right'  : '1px solid black',
      'border-bottom' : '1px solid black',
      'border-left' : '1px solid black',
      'text-align'  : 'center'
    }
  );

  $('textarea').attr('placeholder', "請填寫認證失敗的理由\n系統會隨信寄出");

  /***************************************
    資料正確 寄出驗證信
  ****************************************/
  $(".verifyCorrectButton").click(function()
  {
    var tempId            = $(this).attr("id");
    var splitCorrectId    = tempId.split("_");
    var correctId         = splitCorrectId[1];

    var a = $("#dialog" + correctId).css('z-index');
    $('#shadow').css('z-index', a);
    $('#shadow').show();

    $("#dialog" + correctId).dialog(
    {
        autoOpen: false,
        height: 200,
        width: 700,
        modal: true,
        title: "Warning",
        show: "fade",
        hide: "fade",
        buttons:{
          'send':
          {
              text:'確定',
              class: 'save btn btn-success',
              style: 'width: 80px; height: 40px; margin-right: 30px;',
              click: function()
              {
                $('#processing' + correctId).show();
                verify(correctId, 'correct', '');
                $('#dialog' + correctId).dialog('close');
                $('#shadow').hide();
              }
          },

          'cancel':
          {
              text:'取消',
              class:'cancel btn btn-danger',
              style: 'width: 80px; height: 40px;',
              click: function()
              {
                $('#dialog' + correctId).dialog('close');
                $('#shadow').hide();
              }
          }
      },
      });

    $('#dialog' + correctId).dialog('open');
  });

  /***************************************
    資料錯誤 寄出通知信
  ****************************************/
  $(".verifyFailButton").click(function(){
    var tempId    = $(this).attr("id");
    var splitFailId = tempId.split("_");
    var failId    = splitFailId[1];

    var a = $("#dialog" + failId).css('z-index');
    $('#shadow').css('z-index', a);
    $('#shadow').show();

    var reason = $('#content' + failId).val();
    if(reason == '')
    {
      $('#content' + failId).val('');
      $('#blank' + failId).show();
    }else
    {
      $('#dialog' + failId).dialog(
      {
        autoOpen: false,
          height: 300,
          modal: true,
          title: "Warning",
          show: "fade",
          hide: "fade",
          buttons:{
            'send':
            {
                text:'確定',
                class: 'save btn btn-success',
                style: 'width: 80px; height: 40px; margin-right: 30px;',
                click: function()
                {
                  $('#processing' + failId).show();
                  verify(failId, 'fail', reason);
                  $('#dialog' + failId).dialog('close');
                  $('#shadow').hide();
                }
            },

            'cancel':
            {
                text: '取消',
                class: 'cancel btn btn-danger',
                style: 'width: 80px; height: 40px;',
                click: function()
                {
                  $('#dialog' + failId).dialog('close');
                  $('#shadow').hide();
                }
            }
        },
        });

    $('#dialog' + failId).dialog('open');
    }
  });

  /***************************************

  ****************************************/
  function verify(id, correctOrFail, reason)
  {
    var data = new FormData();
    data.append("eahc_id", id);
    data.append("correctOrFail", correctOrFail);
    data.append("reason", reason);

    var laravelAuthTokenForPost = $('input[name=_token]').val();
    data.append('_token', laravelAuthTokenForPost);
    var URLs = "approve";

    $.ajax(
    {
        url: URLs,
        data: data,
        type:"post",
        dataType:"text",

        cache: false,
        processData: false, // 告訴jQuery不要去處理發送的數據
        contentType: false, // 告訴jQuery不要去設置Content-Type請求頭

        success: function(returnData)
        {
          $('#processing' + id).hide();
          $('#blank' + id).hide();
          console.dir(returnData);
          console.log(returnData['testid']);
          console.log(returnData['cardFront']);
          console.log(returnData['cardBack']);
          // 按下驗證失敗信件寄出
          // 設置按鍵為禁止使用
          if(returnData['correctOrFail'] == 'fail')
          {
            $('#failSent' + id).show();
            $('#correct_' + id).prop('disabled', true);
            $('#fail_' + id).prop('disabled', true);
          }else
          {
            // 按下驗證成功信件寄出
            // 設置按鍵為禁止使用
            $('#correctSent' + id).show();
            $('#correct_' + id).prop('disabled', true);
            $('#fail_' + id).prop('disabled', true);
          }
        },
        error: function(xhr, ajaxOptions, thrownError)
        {
          console.log('server error: ', xhr.responseText);
        }
    });
  }
</script>

@else
<h4 align="center"> <b> 目前沒有待審核資料 </b> </h4><br>
@endif

@stop
