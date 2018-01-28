@extends("layout")
@section("content")

{{------------------------------
  忘記備用信箱表單
-------------------------------}}
{!! Form::open(['url' => 'confirmCorrect', 'method' => 'post', 'id' => 'hiddenForm']) !!}
    {!! Form::hidden('hiddenText', '', ['id' => 'hiddenText']) !!}
    <br>
{!! Form::close() !!}

{{------------------------------
  記得備用信箱表單
-------------------------------}}
{!! Form::open(['action' => 'confirmCorrectController@sendVerifyEmail', 'method' => 'post', 'id' => 'sendMailHiddenForm']) !!}
    {!! Form::hidden('schoolIDHiddenText', '', ['id' => 'schoolIDHiddenText']) !!}
    {!! Form::hidden('stuOrNotHiddenText', '', ['id' => 'stuOrNotHiddenText']) !!}
{!! Form::close() !!}


<div class="jumbotron">
  <span style="font-size: 30px;">
    {{ Lang::get('forgetpass/confirmCorrect.inputFinish') }}
  </span>
  <br><br>

  <button class="btn btn-success btn-large" id="sendButton" style="width: 300px; height: 50px; font-size: 25px;">
    {{ Lang::get('forgetpass/confirmCorrect.sendMail') }}
  </button>

  <span id='processing' style='display: none;'>
    {!! HTML::image('http://jimpunk.net/Loading/wp-content/uploads/loading45.gif', '', ['style' => 'width: 250px;']) !!}
    <span><b>processing ... please wait ... </b></span>
  </span>

  <br>
  <span class='must-fill'>{{ Session::get('serverError') }}</span>
</div>

<div style="font-size: 20px;" class="jumbotron">
  {{ Lang::get('forgetpass/confirmCorrect.mailBreakReason') }}
  <br><br>

  <button id="forgetBackupMailButton" class="btn btn-danger btn-large" style="font-size: 20px;">
    {{ Lang::get('forgetpass/confirmCorrect.mailBreak') }}
  </button>

  <br><br>

  {!! Lang::get('forgetpass/confirmCorrect.cardUpDownUpload') !!}
</div>

<?php
  $inputData = [
    'username'  => \Session::get('username'),
    'schoolID'  => \Session::get('schoolID'),
    'IdeID'     => \Session::get('IdeID'),
    'wholeBir'  => \Session::get('wholeBir'),
    'stuOrNot'  => \Session::get('stuOrNot')
  ];
?>

<script>
$("#sendButton").click(function()
{
  $('#processing').show();
  $("#schoolIDHiddenText").val('<?php echo $inputData['schoolID']; ?>');
  $('#stuOrNotHiddenText').val('<?php echo $inputData['stuOrNot']; ?>');
  $("#sendMailHiddenForm").submit();
});

$("#forgetBackupMailButton").click(function(){
  $("#hiddenText").val('<?php echo implode(" ", $inputData);?>');
    $("#hiddenForm").submit();
});
</script>

@stop
