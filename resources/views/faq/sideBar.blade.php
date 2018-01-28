@section("sideBar")
  <ul class="sidebar-nav">
    <li class="sidebar-brand">
        <a>{{ Lang::get("faq.navigation") }}</a>
    </li>
    @foreach ($departments as $key => $department)
      <li role="presentation">
        {!! HTML::link('faq/' . $department['link'], Lang::get('category.' . $department['id'] . '.name')) !!}
      </li>
    @endforeach
  </ul>
@show