@extends("admin.adminLayout")
@section("modifyContent")

<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      
      <a class="btn navbar-btn btn-primary" href="{{URL::to('admin/faq/create')}}"><h5><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{Lang::get('Admin/Faq.createFaq')}}</h5></a>
    </div>
  </div>
</div> 
{!! Form::open(array("url" => "admin/faq/search", "class" => "form-inline")) !!}
  <!--  input text-->
  <div class="form-group ">
    <label for="input-text">
      <h4>{{ Lang::get("Admin/General.search") }} </h4>
    </label>
  </div>
  <div class="form-group">
    {!! Form::text('keyword',$keyword,[ 'class'=>'form-control','id'=>'input-text','type'=>'text','placeholder'=> Lang::get('Admin/Faq.keywordFaqTitle')]) !!}
  </div>

  <!-- dropdown menu category-->
  <div id="forDropdownMenu" class="dropdown form-group">
    <button class="btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button">
      @if($category == '0') 
        {{ Lang::get("Admin/General.category") }}
      @else
        {{ Lang::get('category.'.$category.'.name') }}
      @endif
      
      <span class="caret"></span>
    </button>
    <ul id="menu-0" class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
    </ul>
    {!! Form::hidden('category',$category) !!}
  </div>
  <div class="form-group">
   {!! Form::button(Lang::get('Admin/General.search'),['class'=>'btn btn-success','type'=>'sumbit'],'sumbit') !!}
    {!! HTML::link(URL::to('admin/faq/'),Lang::get('Admin/General.cancelSearch'),['class' => 'btn btn-danger']) !!}
  </div>  
{!! Form::close() !!}

<br>

<table class="table table-hover table-condensed">
  <tr>
    <th class="">{{ Lang::get('Admin/Category.categoryParent') }}</th>
    <th class="">{{ Lang::get('Admin/Category.category') }}</th>
    <th class="">{{ Lang::get('Admin/Faq.faqName') }}</th>
    <th class="">{{ Lang::get('Admin/Faq.faqName_en') }}</th>
    <th class=""></th>
  </tr>
  <tbody>
    @foreach($faq as $key => $value)
      <tr>
        <td style='min-width: 80px'>{{ Lang::get('category.'.$parent[$key].'.name')}}</td>
        <td style='min-width: 80px'>{{ Lang::get('category.'.$value->category.'.name') }}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->name_en }}</td>                    
        <td><a class="btn btn-default" href="{{ URL::to('admin/faq/'. $value->id)}}">{{Lang::get('Admin/General.detail')}}</a></td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="text-center">
  {!! $faq->appends(['category' => $category,'keyword' => $keyword ])->render() !!}
</div>

@stop