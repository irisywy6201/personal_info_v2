@extends("layout")
@section("content")


<div>
    @yield('laf.content')
</div>

<div class="col-md-12"></div>

 <div>
    @include('laf.alert')
 </div>


@stop
