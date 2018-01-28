@extends('layout') @section('content')

<div>
<a class="btn btn-link" href=" {{ URL::to('HDDestroy/modify') }} "><h3>編輯之前送出的表單</h3></a>
</div>

<br>

@include('HDDestroy.introduction')

<div class="jumbotron">

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

    {!! Form::open(['url' => 'HDDestroy', 'method' => 'post', 'id' => 'HDDestroyform', 'name' => 'HDDestroyform']) !!}

      {{---------------------------------------
        處室欄位
      -----------------------------------------}}
      <div class="form-group">
        {!! Form::label('處室名稱：') !!}
	<span id="role"> {{$role}} </span>
        <br>
      </div>

      {{---------------------------------------
        姓名欄位
      -----------------------------------------}}
      <div class="form-group">
        {!! Form::label('姓名：') !!}
        <span id="username"> {{$username}} </span>
        <br>
      </div>


      {{--------------------------------------------
        分機號碼欄位
      --------------------------------------------}}
      <div id='identidyExtensionNumberDiv' class="form-inline">

        {!! Form::label('identifyExpandNumber', "分機號碼 : ") !!}

        {!! Form::text('identifyExtensionNumber', '', ['id' => 'identifyExtensionNumber', 'class' => 'input form-control']) !!}
        <br>
        <span class="must-fill">
          {{ Lang::get('此欄位必填 ') }}
        </span>
        <span id="identifyExtensionNumberError" class="must-fill errorMsg"></span>

      </div>
      <br>

      {{--------------------------------------------
        預定時間欄位
      --------------------------------------------}}
      <div class="form-group">
        {!! Form::label('datepicker', Lang::get('預定時間 : 請先填寫送件時間，如有衝突，電算中心會另行通知。')) !!}<br>

        <span class="must-fill">
          {{ Lang::get('請利用選擇器點選以免格式錯誤 ') }}
        </span>

        <div class="form-inline">
        {!! Form::text('datetimepicker', '', ['id' => 'form_datetime', 'class' => 'form_datetime input form-control']) !!}
        </div>


        <span id="datepickerError" class="must-fill errorMsg"></span>
      </div>

      {!! Form::hidden('datetimepickerHide', 'datetimepickerHide', ['id' => 'datetimepickerHide']) !!}

      {{--------------------------------------------
        填寫硬碟欄位
      --------------------------------------------}}
{{---------- 
      <div class="form-inline" id="HD">
          <div class="form-group" >
              {!! Form::label('hardDrive', '硬碟 :') !!}<br>
              <div class="form-inline">
                  <div class="non-add">
                      <input type="checkbox" name="demagnetize[]" value="1" id="1" onClick="demagnetize(this)">
                      {!! Form::label('brandAndStorage_', '硬碟廠牌／容量 : ') !!}
                      <input id="brandAndStorage1" class="input form-control" name="brandAndStorage[]" type="text">
                      {!! Form::label('propertyId_', '硬碟所屬報廢主機或硬碟財產編號 : ') !!}
                      <input id="propertyId1" class="input form-control" name="propertyId[]" type="text">
                      {!! Form::label('note', "備註 : ") !!}
                      <input id="note1" class="input form-control" name="note[]" type="text" value=" ">
                      <button type="button" class="btn btn-primary glyphicon glyphicon-plus gplus" onclick="add_HD()"></button>
                  </div>
              </div>
              <br>
          </div>
      </div>
 ----------------}}


<div class="form-inline" >
    <div class="form-group" id="HD">
        {!! Form::label('hardDrive', '硬碟 :') !!}<br>
            <div class="non-add form-inline" id="HDD">
                <input type="checkbox" name="demagnetize[]" value="1" id="1" onClick="demagnetize(this)">
                {!! Form::label('brandAndStorage_', '硬碟廠牌／容量 : ') !!}
                <input id="brandAndStorage1" class="input form-control" name="brandAndStorage[]" type="text">
                {!! Form::label('propertyId_', '硬碟所屬報廢主機或硬碟財產編號 : ') !!}
                <input id="propertyId1" class="input form-control" name="propertyId[]" type="text">
                {!! Form::label('note', "備註 : ") !!}
                <input id="note1" class="input form-control" name="note[]" type="text" value=" ">
                <button type="button" class="btn btn-danger glyphicon glyphicon-minus" onclick="delete_HD(this)" style="visibility:hidden"></button>
            </div>
        <br>
    </div>
    <div>
    <button type="button" class="btn btn-primary glyphicon glyphicon-plus " onclick="add_HD()"></button>
    </div>
</div>
      {{--------------------------------------
        下方預設提醒(button要設成submit)
      ---------------------------------------}}
      <div class='must-fill' style='font-size: 18px;'>

        <br><br>
	{{----------------------------------------
        {{ Lang::get('forgetpass/forgetpass.defaultRemind.typeInputAbove') }}<br><br>

	@include('HDDestroy.confirmModal')
	----------------------------------------}}

        <button class="btn btn-default btn-primary" id="HDbutton" type="button" >
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('送出') }}
        </button>

      </div>

      {!! Form::close() !!}

      <br><br>

      <div id='failDiv' style='display: none;'>
        <div class="form-group">
          {!! Form::label('email', Lang::get('信箱:')) !!}
          <br>

          <span class="must-fill">
            {!! Lang::get('請輸入email') !!}
          </span>

          {!! Form::text('email', '', ['id' => 'email', 'class' => 'input form-control']) !!}
          <br>
          <span id="emailError" class="must-fill errorMsg"></span>
        </div>

        <div class="form-group">
          {!! Form::label('phone', Lang::get('電話:')) !!}
          <br>

          <span class="must-fill">
            {!! Lang::get('(選填)請輸入電話號碼，若為市話請輸入區碼') !!}
            {!! HTML::link('http://phys.thu.edu.tw/~mengwen/telphone.htm', Lang::get('區碼查詢'), ['target'=>'_blank']) !!}

          </span>

          {!! Form::text('phone', '', ['id'=>'phone','class'=>'input form-control']) !!}
          <br>
          <span id="phoneError" class="must-fill errorMsg"></span>
        </div>

        <button class="btn btn-primary" id="failButton">
          <span class="glyphicon glyphicon-envelope"></span>
          {{ Lang::get('寄出信件') }}
        </button>
        <span id='mailMessage' class='must-fill errorMsg'></span>

        <span id='loading' style='margin-left: 20px; display: none;'>
          <span style='position: absolute;'>
              <span class="swoop" style=''></span>
            </sapn>
          </span>





{!! HTML::script('js/HDDestroy/HDDestroy.js') !!}
{!! HTML::style('css/HDDestroy/HDDestroy.css') !!}


@stop
