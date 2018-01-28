@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3><a class="btn btn-link" href="{{URL::to('admin/faq/')}}" >
    <span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
  </a> {{ $faq->name }}</h3>
</div>
<div class="navbar" role="navigation">
	<div class="container-fluid">
		<div class="navbar-right">
			{!! Form::open(array("url" => array("/admin/faq/". $faq->id), "method" => "DELETE", "class" => "navbar-form navbar-right")) !!}
        <a href="{{URL::to('admin/faq/'.$faq->id.'/edit')}}" class="btn btn-success">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          {{ Lang::get('Admin/General.edit') }}
        </a>
        @include('globalPageTools.confirmMessage', ['item' => Lang::get('Admin/Faq.faq')])
        <button class="btn btn-danger btn-delete" type="button">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          {{ Lang::get('Admin/General.delete')}}
        </button>
      {!! Form::close() !!}
    </div>
	</div>
</div>  
<hr >
<h4>{{Lang::get('Admin/General.category')}} : {{Lang::get('category.'.$faq->category.'.name')}} </h4>
<br>
<h4 id="type-blockquotes">{{$faq->name}}</h4>
<blockquote>{!! $faq->answer !!}</blockquote>
<h2>English<h2>
<h4 id="type-blockquotes">{{$faq->name_en}}</h4>
<blockquote>{!! $faq->answer_en !!}</blockquote>

@stop
