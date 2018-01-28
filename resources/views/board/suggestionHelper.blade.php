@section("helper")
<div class="suggestion-helper">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="pull-right panel-heading-tools">
        <button class="btn panel-heading-btn btn-hide" type="button">
          <span class="glyphicon glyphicon-chevron-up"></span>
          {{ Lang::get('board.hideSuggestionHelper') }}
        </button>
        <button class="btn panel-heading-btn btn-show" type="button">
          <span class="glyphicon glyphicon-chevron-down"></span>
          {{ Lang::get('board.showSuggestionHelper') }}
        </button>
        <button class="btn panel-heading-btn btn-disable" type="button">
          <span class="glyphicon glyphicon-ban-circle"></span>
          {{ Lang::get('board.exitShowSuggestHelper') }}
        </button>
      </div>
      <h3 class="panel-title">
        <span class="glyphicon glyphicon-info-sign"></span>
        &nbsp;{{ Lang::get("board.suggestionHelperTitle") }}
      </h3>
    </div>
    <ul class="list-group suggests"></ul>
    <div class="panel-body">{{ Lang::get('searching.noResult') }}</div>
  </div>
</div>
@show