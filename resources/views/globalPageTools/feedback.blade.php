@section("feedback")

@if(isset($feedback) || (Session::has("feedback") && $feedback = Session::pull("feedback")))
  <div class="alert {{ AppConfig::$alerts['alertClasses'][$feedback['type']] }} alert-dismissible page-alert" role="alert">
    <span class="glyphicon {{ AppConfig::$alerts['alertIcons'][$feedback['type']] }}" aria-hidden="true"></span>
    {{ $feedback["message"] }}
    <button class="close" type="button" data-dismiss="alert" data-label="Close">
      <span aria-hidden="true">
        &times;
      </span>
      <span class="sr-only">
        Close
      </span>
    </button>
  </div>
@endif

@show