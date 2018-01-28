@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>

<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a id="forCategDeaprt" class="btn navbar-btn btn-primary" href="{{ URL::to('admin/category/createDepartment') }}">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{ Lang::get('Admin/Category.createDepartment') }}
      </a>
      <a id="forCategDeaprt" class="btn navbar-btn btn-primary" href="{{ URL::to('admin/category/createCategory') }}">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{ Lang::get('Admin/Category.createCategory') }}
      </a>
      <a id="forCategDeaprt" class="btn navbar-btn btn-primary" href="{{ URL::to('admin/category/editOrder/' . $parent) }}">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{ Lang::get('Admin/Category.editOrder') }}
      </a>

    </div>
	</div>
</div>

{!! Form::open(['url' => 'admin/category/search', 'class' => 'form-inline']) !!}
  <!--  input text-->
  <div class="form-group">
    <label for="input-text">
      <h4>{{ Lang::get("Admin/General.search") }} </h4>
    </label>
  </div>
  <!-- dropdown menu category-->
  <div id="forDropdownMenu" class="dropdown form-group">
  <button class="btn btn-default navbar-content" id="category" name="category" data-toggle="dropdown" role="button">
    @if($parent == 0)
      {{ Lang::get("Admin/Category.department") }}
    @else
      {{ Lang::get('category.' . $parent . '.name') }}
    @endif
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu menu-content" id="menu-0" aria-labelledby="dLabel" role="menu"></ul>
  {!! Form::hidden('category','0') !!}
  </div>
  <div class="form-group">
    {!! Form::button(Lang::get('Admin/General.search'), ['class' => 'btn btn-success', 'type' => 'sumbit'], 'sumbit') !!}
    {!! HTML::link(URL::to('admin/category/'), Lang::get('Admin/General.cancelSearch'), ['class' => 'btn btn-danger']) !!}
  </div>  
{!! Form::close() !!}
<br>

<table class="table table-hover table-condensed">
  <tr>
    <th class="" style='min-width: 100px'>{{ Lang::get('Admin/Category.categoryName') }}</th>
    <th class=""style='min-width: 100px'>{{ Lang::get('Admin/Category.categoryParent') }}</th>
    <th class="">{{ Lang::get('Admin/Category.categDescribe') }}</th>
    <th class=""style='min-width: 100px;text-align: center'>{{ Lang::get('Admin/Category.href') }}</th>  
    <th class=""style='min-width: 100px;text-align: center'>{{ Lang::get('Admin/Category.isLeaf') }}</th>
    <th class=""style='min-width: 100px;text-align: center'>{{ Lang::get('Admin/General.hide') }}</th>
    <th class=""></th>
  </tr>
  <tbody>
    @foreach($category as $key => $value)
      <tr>
        <td style='max-width: 100px'>{{ $value->name }}</td>    
        <td style='max-width: 100px'>
          @if($value->parent_id == 0) 
            {{ Lang::get('Admin/Category.department') }}
          @else 
            {{ Lang::get('category.' . $value->parent_id . '.name') }}
          @endif
        </td>
        <td style='max-width: 400px'>{!! $value->describe  !!}</td>
        <td style='text-align: center'>{{ $value->href_abb }}</td>
        <td style='text-align: center'>
          @if($value->leaf != 0)
           <p class="text-danger">
                <span class="glyphicon glyphicon-remove"></span>
            </p>
          @else  
            <p class="text-success">
              <span class="glyphicon glyphicon-ok"></span>
            </p>
           @endif
        </td>
        <td style='text-align: center'>
          @if($value->is_hidden == 0)
           <p class="text-danger">
                <span class="glyphicon glyphicon-remove"></span>
            </p>
          @else  
            <p class="text-success">
              <span class="glyphicon glyphicon-ok"></span>
            </p>
           @endif
        </td>
        <td>
          {!! HTML::link(URL::to('admin/category/' . $value->id), Lang::get('Admin/General.detail'), ['class' => 'btn btn-default']) !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<div class="text-center" >
  {!! $category->render() !!}
</div>

@stop
