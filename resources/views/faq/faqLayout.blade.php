@extends("layout")
@section("content")

<div id="wrapper">
  <button class="btn btn-no-edge" id="menu-toggle" type="button">
    <span class="glyphicon glyphicon-align-justify"></span>
  </button>
  <div id="sidebar-wrapper">
    @include("faq.sideBar")
  </div>

  <div id="page-content-wrapper">
    @include("faq.searchBar")

    <br>

    <div class="real-time-search-wrapper" data-real-time-search-id="faq-real-time-search-bar">
      <div class="real-time-search-origin-page">
        @yield("faq.content")
      </div>
      <div class="real-time-search-result-page"></div>
    </div>
  </div>
</div>

@stop