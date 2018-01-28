@extends("layout")
@section("content")

<div id="forgetpass_main_div">
  <h1>
    {{ Lang::get('forgetpass/forgetpass.forgetpass') }}
  </h1>

  <br><br>
      {{-- label 的 第一個參數為 for 屬性 --}}
      {{-- text 的 第一個參數為 name 屬性 --}}
      {{-- select name, option values, selected, other --}}
  <div class="jumbotron">

    {!! Form::open(['url' => 'forgetpass', 'method' => 'post', 'id' => 'FGform', 'name' => 'FGform']) !!}

      {{---------------------------------------
        姓名欄位
      -----------------------------------------}}
      <div class="form-group">
        {!! Form::label('username', Lang::get('forgetpass/forgetpass.personalInfo.name')) !!}
        <br>

        <span class="must-fill">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.realName') }}
        </span>

        {!! Form::text('username', '', ['id' => 'username', 'class' => 'input form-control']) !!}
        <br>
        <span id="usernameError" class="must-fill errorMsg"></span>
      </div>

      {{--------------------------------------------
        學號欄位
      --------------------------------------------}}
      <div class="form-group">
        {!! Form::label('schoolID', Lang::get('forgetpass/forgetpass.personalInfo.account')) !!}<br>
        {!! Form::label('', Lang::get('forgetpass/forgetpass.personalInfoWarn.selectIdentify'), ['id' => 'chooseFirst', 'class' => 'text-danger']) !!}
        {{---------------------------------------
          身分欄位 (radio button)
        -----------------------------------------}}
        <div class="" data-toggle="buttons">
          <label id="staffRB" name="staffRB" class="btn btn-default">
            {!! Form::radio('identity', 'staff', null) !!}
            {{ Lang::get('forgetpass/forgetpass.identify.staff') }}
          </label>

          <label id="studentRB" name="studentRB" class="btn btn-default ">
            {{-- label class 加上 active 可使之預選 --}}
            {!! Form::radio('identity', 'student', null) !!}
            {{ Lang::get('forgetpass/forgetpass.identify.student') }}
          </label>

          <label id="alumniRB" name="alumniRB" class="btn btn-default">
            {!! Form::radio('identity', 'alumni', null) !!}
            {{ Lang::get('forgetpass/forgetpass.identify.alumni') }}
          </label>
        </div>

        <br>

        <span class="must-fill account staff">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.staffEmail') }}
        </span>

        <span class="must-fill account student">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.studentSchoolID') }}
        </span>

        <span class="must-fill account alumni">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.alumniSchoolID') }}
        </span>

        {!! Form::text('schoolID', '', ['id' => 'schoolID', 'class' => 'input form-control staff student alumni']) !!}
        <br>
        <span id="schoolIDError" class="must-fill errorMsg"></span>
      </div>


      {{--------------------------------------------
        身分證字號欄位
      --------------------------------------------}}
      <div id='identidyNumberDiv' class="form-group">
        {!! Form::label('identifyNumber', Lang::get('forgetpass/forgetpass.personalInfo.ideNumber')) !!}
        <br>

        <span class="must-fill">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.firstUpperCase') }}
        </span>

        {!! Form::text('identifyNumber', '', ['id' => 'identifyNumber', 'class' => 'input form-control']) !!}
        <br>
        <span id="identifyNumberError" class="must-fill errorMsg"></span>
      </div>

      {{--------------------------------------------
        生日欄位
      --------------------------------------------}}
      <div class="form-group">
        {!! Form::label('datepicker', Lang::get('forgetpass/forgetpass.personalInfo.birthday')) !!}<br>

        <span class="must-fill">
          {{ Lang::get('forgetpass/forgetpass.personalInfoWarn.useSelector') }}
        </span>

        {!! Form::text('datepicker', '', ['id' => 'datepicker', 'class' => 'input form-control']) !!}
        <br>
        <span id="datepickerError" class="must-fill errorMsg"></span>
      </div>

      {!! Form::hidden('datepickerHide', 'datepickerHide', ['id' => 'datepickerHide']) !!}

      <br><br><br>


      {{---------------------------------------
        google recaptcha
      -----------------------------------------}}

      <div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
            <label class="control-label" for="g-recaptcha-response">
              <span class="must-fill">*</span>
              {{ Lang::get('forgetpass/forgetpass.recaptcha') }}
            </label>

            {!! Recaptcha::render() !!}
            {!! Form::close() !!}

            <label class="control-label has-error" for="g-recaptcha-response">
              @if($errors->has("g-recaptcha-response"))
                {{ $errors->first("g-recaptcha-response") }}
              @endif
            </label>
        </div>

      <br>

      <span class='must-fill'>
        {{ Session::get('multipleAccount') }}
      </span>

      <span class='must-fill'>
        {{ Session::get('inputDataWrong') }}
      </span>

      <span class='must-fill'>
        {{ Session::get('sessionTimeOut') }}
      </span>

      {{----------------------------------
        30 分鐘尚未到達 失敗提醒
      -----------------------------------}}
      <span class='must-fill'>
        @if (Session::has('thirtyMinLimit'))
          {{ Session::get('thirtyMinLimit') }}<br><br>
          {{ Lang::get('forgetpass/forgetpass.30MinFail.ifNotReceiveMail') }}<br>
          {{ Lang::get('forgetpass/forgetpass.30MinFail.emailYouTypeIn30Min') }}
          {{ Session::get('lastEmail') }}<br>
          {{ Lang::get('forgetpass/forgetpass.30MinFail.pleaseCheckMail') }}<br><br>
            {{ Lang::get('forgetpass/forgetpass.30MinFail.checkSpamMail') }}<br>
        @endif
      </span>

      <br><br>

      {{--------------------------------------
        下方預設提醒
      ---------------------------------------}}
      <div class='must-fill' style='font-size: 18px;'>
        {{ Lang::get('forgetpass/forgetpass.defaultRemind.onceIn30Min') }}<br>
        {{ Lang::get('forgetpass/forgetpass.defaultRemind.checkInDetail') }}
        <br><br>
        {{ Lang::get('forgetpass/forgetpass.defaultRemind.typeInputAbove') }}<br><br>

        <button class="btn btn-default btn-primary" id="FGbutton" type="button">
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('forgetpass/forgetpass.submit') }}
        </button>

        <button class="btn btn-default" id="failSlideButton" type="button">
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          {{ Lang::get('forgetpass/forgetpass.cannotModify') }}
        </button>
      </div>

      <br><br>

      <div id='failDiv' style='display: none;'>
        <div class="form-group">
          {!! Form::label('email', Lang::get('forgetpass/forgetpass.email')) !!}
          <br>

          <span class="must-fill">
            {!! Lang::get('forgetpass/forgetpass.enterEmail') !!}
          </span>

          {!! Form::text('email', '', ['id' => 'email', 'class' => 'input form-control']) !!}
          <br>
          <span id="emailError" class="must-fill errorMsg"></span>
        </div>

        <div class="form-group">
          {!! Form::label('phone', Lang::get('forgetpass/forgetpass.phone')) !!}
          <br>

          <span class="must-fill">
            {!! Lang::get('forgetpass/forgetpass.phoneOrHome') !!}
            {!! HTML::link('http://phys.thu.edu.tw/~mengwen/telphone.htm', Lang::get('forgetpass/forgetpass.zipCodeSearch'), ['target'=>'_blank']) !!}

          </span>

          {!! Form::text('phone', '', ['id'=>'phone','class'=>'input form-control']) !!}
          <br>
          <span id="phoneError" class="must-fill errorMsg"></span>
        </div>

        <button class="btn btn-primary" id="failButton">
          <span class="glyphicon glyphicon-envelope"></span>
          {{ Lang::get('forgetpass/forgetpass.sendTheMail') }}
        </button>
        <span id='mailMessage' class='must-fill errorMsg'></span>

        <span id='loading' style='margin-left: 20px; display: none;'>
          <span style='position: absolute;'>
              <span class="swoop" style=''></span>
            </sapn>
          </span>

        {{------------------------------
          dialog div
        ------------------------------}}
          <div id='dialog'>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
</div>

{{------------------------------
  dialog 遮照用 div
------------------------------}}
<div id='shadow' style='display: none;'></div>

{!! HTML::script('js/forgetpass/forgetpass.js') !!}
{!! HTML::style('css/forgetpass/forgetpass.css') !!}
@stop
