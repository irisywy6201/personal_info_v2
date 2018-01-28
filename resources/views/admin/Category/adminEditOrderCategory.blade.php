@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/category/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a>{{ $title }}</h3>
</div>

{!! Form::open(['url' => 'admin/category/editOrder/' . $parent, 'method' => 'post', 'class' => 'form-horizontal']) !!}
  <div class="form-group " id="list_group" >
    <ul class="list-group list-order" >
      @foreach($category as $key => $value) 
        <li class="list-group-item" id="{{ $key }}" >
          <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
          {{ $value->name }}          
          @if($value->is_hidden == 1)
            {{ Lang::get('Admin/General.hide') }}
          @endif
        </li>
      @endforeach
    </ul>
    {!! Form::hidden('order', '') !!}
  </div>
  <div class="form-group">
    {!! Form::button(Lang::get("Admin/General.submit"), ['class' => 'btn btn-block btn-success', 'type' => 'sumbit'], 'sumbit') !!}
  </div>
{!! Form::close() !!}

@stop