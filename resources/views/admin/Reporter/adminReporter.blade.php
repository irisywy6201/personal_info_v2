@extends("admin.adminLayout")
@section("modifyContent")
<div class="row text-center">
  <h3>{{ $title }}</h3>
</div>
{!! Form::open(array("url" => "/admin/reporter","method" => "post","class" => "form-inline col-lg-12")) !!}

  <div class="form-group">  
      <h4>{{ Lang::get("Admin/General.search") }} </h4>
  </div>
  <div class="input-daterange input-group from-group" id="datepicker">
    <input type="text" class="form-control" name="start" value="{{$startDate}}" />
    <span class="input-group-addon">to</span>
    <input type="text" class="form-control" name="end" value="{{$endDate}}"/>
  </div>
  <div class="dropdown form-group">
      <button class="btn btn-default navbar-content" id="orderValue" name="orderValue" data-toggle="dropdown" role="button">
        {{ Lang::get("Admin/Reporter.sortby") }}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu menu-content" aria-labelledby="dLabel" role="menu">
          <li>
            <a id="category_id">
              {{ Lang::get('Admin/Reporter.category') }}
            </a>
          </li>
          <li>
            <a id="title">
              {{ Lang::get('Admin/Reporter.title') }}
            </a>
          </li>
          <li>
            <a id="user_id">
              {{ Lang::get('Admin/Reporter.asked') }}
            </a>
          </li>
          <li>
            <a id="identity">
              {{ Lang::get('Admin/Reporter.identity') }}
            </a>
          </li>       
          <li>
            <a id="reply">
              {{ Lang::get('Admin/Reporter.reply') }}
            </a>
          </li>     
          <li>
            <a id="status">
              {{ Lang::get('Admin/Reporter.status') }}
            </a>
          </li> 
          <li>
            <a id="created_at">
              {{ Lang::get('Admin/Reporter.created_at') }}
            </a>
          </li> 
          <li>
            <a id="updated_at">
              {{ Lang::get('Admin/Reporter.updated_at') }}
            </a>
          </li>   
      </ul>
      <input name="orderValue" type="hidden">
  </div> 
  <div class="form-group">
    {!! Form::button('Sumbit',array('type'=>'sumbit','class'=>'btn btn-default ')) !!}
  </div>
{!! Form::close() !!}


{!! Form::open(array("url" => array("/admin/reporter/excel/".$startDate."/".$endDate),"method" => "post", "class" => "form-horizontal")) !!}
  {!! Form::hidden('startDate',Lang::get('Admin/Reporter.startDate')) !!}
  {!! Form::hidden('endDate',Lang::get('Admin/Reporter.endDate')) !!}
<div class="form-group">
  <table class="table table-hover table-condensed">
      <tbody>
        <tr>     
          <th>    
            <label>
              <input name="check[category_id]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.category')}}
            </label>              
          </th>
          <th>    
            <label>
              <input name="check[title]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.title')}}
            </label>
          </th>
          <th>    
            <label>
              <input name="check[user_id]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.asked')}}
            </label>
          </th>
          <th>    
            <label>
              <input name="check[identity]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.identity')}}
            </label>
          </th>
          <th>    
            <label>
              <input name="check[reply]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.reply')}}
            </label>
          </th>
          <th>    
            <label>
              <input name="check[status]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.status')}}
            </label>
          </th>  
          <th>    
            <label>
              <input name="check[created_at]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.created_at')}}
            </label>
          </th>     
          <th>    
            <label>
              <input name="check[updated_at]" type="checkbox" checked="checked">{{Lang::get('Admin/Reporter.updated_at')}}
            </label>
          </th>    
          <th>
            <button type="submit" value="submit" class="btn btn-success" >
              {{ Lang::get("Admin/Reporter.outputExcel") }}
            </button>
        </th>      
      </tr> 
    <tr>
    </tbody>
  </table>
</div>
{!! Form::close() !!}

<table class="table table-hover table-condensed">
<tbody>  
    <tr>     
      <th>#</th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.category')}}
        </label>              
      </th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.title')}}
        </label>
      </th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.asked')}}
        </label>
      </th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.identity')}}
        </label>
      </th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.reply')}}
        </label>
      </th>
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.status')}}
        </label>
      </th>    
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.startDate')}}
        </label>
      </th>  
      <th>    
        <label>
          {{Lang::get('Admin/Reporter.endDate')}}
        </label>
      </th>                        
    </tr>
    <tr>
    @foreach($resultQuestion as $key => $value)
      <tr>
        <td>{{$key+1}}</td>
        <td>{{Lang::get('category.'.$value->category->id.'.name')}}</td>
        <td>{{$value->title}}</td>
        <td>{{$value->userID}}</td>
        <td>{{Lang::get('identity.'.$value->identity)}}</td>
        <td>{{$value->reply}}</td>
        <td>{{Lang::get('status.'.$value->status)}}</td>
        <td>{{$value->created_at}}</td>
        <td>{{$value->updated_at}}</td>
      </tr>
    @endforeach
  </tbody>
</table>

@stop

