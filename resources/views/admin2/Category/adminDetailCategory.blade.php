@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>
    <a class="btn btn-link" href="{{URL::to('admin/category/')}}" >
      <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    </a>
    {{ $category->name }}
    @if($category->is_hidden == "1")
      {!! HTML::image('images/circle.png', Lang::get('board.unsolved')) !!}
      {{ Lang::get('Admin/category.hide') }}
    @endif
  </h3>
</div>
<div class="navbar" role="navigation">
	<div class="container-fluid">
		<div class="navbar-right">
			{!! Form::open(['url' => ['/admin/category/' . $category->id], 'method' => 'delete', 'class' => 'navbar-form navbar-right']) !!}
        <a href="{{ URL::to('admin/category/' . $category->id . '/edit') }}" class="btn btn-success">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          編輯
        </a>
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/Category.category')])
        <button class="btn btn-danger btn-delete" type="button">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          刪除
        </button>
      {!! Form::close() !!}
    </div>
	</div>
</div>

<hr>

<h4>{{ Lang::get('Admin/Category.categoryParent') }} : 
	@if($category->parent_id == '0') 
		{{ Lang::get('Admin/Category.department') }}
	@else 
		{{ Lang::get('category.' . $category->parent_id . '.name') }}
	@endif
</h4>

<h2 id="type-blockquotes">{{ $category->name }}  {{ $category->href_abb }}({{ Lang::get('Admin/Category.href')}})</h2>
<blockquote>{!! $category->describe !!}</blockquote>
<h2>English<h2>
<h4 id="type-blockquotes">{{ $category->name_en }}</h4>
<blockquote>{!! $category->describe_en !!}</blockquote>

@stop