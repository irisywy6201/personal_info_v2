@section('confirmMessage')

<div class="panel panel-default confirmMessage">
  <div class="panel-body">
    {{ Lang::get("confirmMessage.deleteWarning", ['item' => $item]) }}
  </div>
  <div class="panel-footer text-right">
    <button class="btn btn-default btn-confirm" type="button">
      <span class="glyphicon glyphicon-ok"></span>
      {{ Lang::get("confirmMessage.confirm") }}
    </button>
    <button class="btn btn-primary btn-cancel-confirm navbar-btn" type="button">
      <span class="glyphicon glyphicon-remove"></span>
      {{ Lang::get("confirmMessage.cancel") }}
    </button>
  </div>
</div>

@show