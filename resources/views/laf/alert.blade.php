@section("alert")

<div id="alert" class="col-md-offset-4 col-md-4">
  <div class="alert alert-dismissable alert-warning fade-in">

    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
      ×
    </button>
    <h4>
      {{ Lang::get('LostandFound/page.alert') }}
    </h4>
    <div>
      {{ Lang::get('LostandFound/page.whatAlert') }}
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#alert").fadeOut(30000);
  });
</script>

@show
