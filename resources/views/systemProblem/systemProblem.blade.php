@extends("layout")
@section("content")

<h1>
  {{ Lang::get('menu.contactUs') }}
</h1>

<h4 class="text-danger">
  {!! Lang::get('systemProblem/systemProblem.anyProblem') !!}
</h4>

<br><br>

<div class="jumbotron">
  {!! Form::open([
        'url'   => 'systemProblem', 
        'method'  => 'post', 
        'id'    => 'spForm'
      ])
  !!}
    <fieldset>
      <div class="form-group @if($errors->has('sysProblem')) has-error @endif">
        <label class="control-label" for="sysProblem">
          <span class="text-danger">*</span>
          {{ Lang::get('systemProblem/systemProblem.describeProb') }}
        </label>
        {!! Form::textarea('sysProblem', Input::old('sysProblem', ''), ['class' => 'form-control', 'id'  => 'sysProblem']) !!}
        <label class="control-label has-error" for="sysProblem">
          @if($errors->has("sysProblem"))
            {{ $errors->first("sysProblem") }}
          @endif
        </label>

        <!-- 'class' => 'summernote', -->
        <span id="sysProblemError" class="must-fill errorMsg"></span>
      </div>

      <div class="form-group @if($errors->has('email')) has-error @endif">
        {!! Form::label('email', Lang::get('systemProblem/systemProblem.email'), ['class' => 'control-label']) !!}
        <span class="must-fill">
          {{ Lang::get('systemProblem/systemProblem.emailOrNot') }}
        </span>
        {!! Form::text('email', Input::old('email', ''), [
              'id'  => 'email',
              'class' => 'input form-control'
            ])
        !!}
        <label class="control-label has-error" for="email">
          @if($errors->has("email"))
            {{ $errors->first("email") }}
          @endif
        </label>
      </div>

      <div class="form-group @if($errors->has('g-recaptcha-response')) has-error @endif">
        <label class="control-label" for="g-recaptcha-response">
          <span class="must-fill">*</span>
          {{ Lang::get('systemProblem/systemProblem.recaptcha') }}
        </label>

        {!! Recaptcha::render() !!}

        <label class="control-label has-error" for="g-recaptcha-response">
          @if($errors->has("g-recaptcha-response"))
            {{ $errors->first("g-recaptcha-response") }}
          @endif
        </label>
      </div>
      
      <div class="form-group">
        <button class="btn btn-primary" id="spButton" type="submit">
          <span class="glyphicon glyphicon-ok"></span>
          {{ Lang::get('systemProblem/systemProblem.submit') }}
        </button>
      </div>

      <span class='must-fill'>{{ Session::get('serverError') }}</span>
    </fieldset>
  {!! Form::close() !!}
</div>

{{--
<script>
var sysProblemInput   = document.getElementById('sysProblem');
var emailInput      = document.getElementById('email');

$('#spButton').click(function()
{
  var URLs    = 'systemProblem/' + 'final';
  var newFormData = new FormData();

  newFormData.append("email" , emailInput.value);
  newFormData.append('sysProblem', sysProblemInput.value);

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
          $('.errorMsg').html('');
          console.log(returnData['status']);
          console.dir(returnData);
          console.log('test: ' + returnData['test']);

          if(returnData['status'] == 'fail')
          {
            jQuery.each(returnData['error'], function(index, value) 
            {
             $('#' + index + 'Error').html(value);
             
            });
          }
          else
          {
            $('#spForm').submit();
          }
        },

         error:function(xhr, ajaxOptions, thrownError)
         {
            console.dir(xhr);
         }
  });
});
  // var a = $('#sysProblem').next('.note-editor').find('.note-editable').code();

  emailInput.onblur = function() 
  {
    var inputJsonData = 
      {
        whichInput    : 'email',
        email       : emailInput.value,
      };
    inputAjax(inputJsonData, emailInput);
  };

  function inputAjax(inputData, whichInput)
  {
      var URLs = $('#spForm').attr('action') + '/validation';
      $.ajax(
      {
          url: URLs,
          data: inputData,
          type:"post",
          dataType: "json",

          success: function(returnData)
          {
            $('.errorMsg').html('');

            if(returnData['status'] == 'fail')
            {
              jQuery.each(returnData['error'], function(index, value) 
              {
                $('#' + index + 'Error').html(value);
              });
            }
          },

          error: function(xhr, ajaxOptions, thrownError)
          {
            console.log('server error: ', xhr.responseText);
          }
      });
  }

</script>
--}}

@stop