@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>
<div class="navbar" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="btn navbar-btn btn-primary" href="{{URL::to('admin/management/create')}}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{Lang::get('Admin/Management.createUser')}}</a>
    </div>
  </div>
</div> 
{!! Form::open(array("url" => "admin/management/search", "class" => "form-inline")) !!}
  <!--  input text-->
  <div class="form-group">  
      <h4>{{ Lang::get("Admin/General.search") }}   </h4>
  </div>
  <div class="form-group"> 
    <input class="form-control" id="input-text" name="keyword" value="@if(isset($keyword)){{$keyword}}@endif" type="text" placeholder="{{ Lang::get('Admin/General.keyword') }}">
  </div>
  <div class="form-group">
    {!! Form::button(Lang::get('Admin/General.search'),['class'=>'btn btn-success','type'=>'sumbit'],'sumbit') !!}
    {!! HTML::link(URL::to('admin/management/'),Lang::get('Admin/General.cancelSearch'),['class' => 'btn btn-danger']) !!}
  </div>  
{!! Form::close() !!}
</br>
<table class="table table-hover table-condensed">
  <tr>
    <th>#</th>
    <th class="">{{Lang::get('Admin/General.account')}}</th>
    <th class="">{{Lang::get('Admin/General.username')}}</th>
    <th class="">{{Lang::get('Admin/General.identity')}}</th>
    <th class="">{{Lang::get('Admin/Management.attachedRole')}}</th>
    <th class="">{{Lang::get('Admin/General.email')}}</th>
    <th class="">{{Lang::get('Admin/Management.updated')}}</th>
    <th class=""></th>
  </tr>
<tbody>
  @foreach($user as $key => $value)
    <tr>
      <td>{{ (Input::get('page',1)-1 ) * count($user) + $key +1 }}</td>
      <td>{{ $value->acct }}</td>
      <td>{{ $value->username }}</td>
      <td>{{ Lang::get('adminRole.'.$value->role) }}</td> 
      <td>{{ Lang::get('adminRole.'.$value->addrole) }}</td>  
      <td>
      @if($value->registered == 0)
          <span class="text-danger glyphicon glyphicon-remove"></span>
      @else
        {{ $value->email->address }}    
        <span class="text-success glyphicon glyphicon-ok"></span>
      @endif      
      </td>
      <td>{{ $value->updated_at }}</td>
      <td><a class="btn btn-default" href="{{ URL::to('admin/management/'. $value->id)}}">{{Lang::get('Admin/General.edit')}}</a></td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="text-center" >
  @if(isset($keyword)) 
    {{ $user->appends(['keyword' => $keyword ])->render() }}
  @else
    {!! $user->render() !!}
  @endif
</div>

@stop