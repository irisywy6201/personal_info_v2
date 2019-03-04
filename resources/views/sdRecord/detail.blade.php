@extends("layout")
@section("content")

  <!-- record info -->

  <!-- previous page -->
  <div class="text-right">
    <div class="btn-group" role="group">
      <a class="btn btn-lg btn-default" href="{{ URL::to('/deskRecord/?page='.Session::get('pageNum'))}}">
        <span class="glyphicon glyphicon-circle-arrow-left"></span>
        回列表
      </a>
      @if(Auth::user()->isAdmin())
        <a class="btn btn-lg btn-danger" type="button" class="btn btn-default" data-toggle="modal" data-target="#deleteRecord" data-id="{{ $records->id }}">
          <span class="glyphicon glyphicon-trash"></span>
          刪除紀錄
        </a>
      @endif
    </div>
  </div>

  <!-- Delete record modal -->
  <input id="sdRecDelete" name="sdRecDelete" type="hidden" value="" data-token="{{ csrf_token() }}">
  <div class="modal fade" id="deleteRecord" tabindex="-1" role="dialog" aria-labelledby="deleteRecordLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="modal-title" id="deleteRecordLabel">{{ Lang::get('sdRecord/board.confirmDelete') }}</h4>
          <div class="text-right">
            <a type="button" class="btn btn-default btn-lg glyphicon glyphicon-remove" data-dismiss="modal"></a>
            <a type="button" onclick="deleteRecord()" class="btn btn-danger btn-lg glyphicon glyphicon-ok" data-dismiss="modal"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
<div class="detail-section-background jumbotron">
  <!-- record detail -->
  <h2>{{Lang::get('sdRecord/board.detailInfo')}}:</h2>
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th class="hidden-xs"><h3>{{ Lang::get('sdRecord/board.department') }}</h3></th>
        <th><h3>{{ Lang::get('sdRecord/board.category') }}</h3></th>
        <th class="hidden-xs"><h3>{{ Lang::get('sdRecord/board.recorder') }}</h3></th>
        <th><h3>{{ Lang::get('sdRecord/board.solution') }}</h3></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="hidden-xs">
          <p>{{$department->name}}</p>
        </td>
        <td>
          <p>{{$category->name}}<p>
        </td>
        <td class="hidden-xs">
          <p>{{$records->recorder}}</p>
        </td>
        <td>
          <p>{{$solution->method}}</p>
        </td>
      </tr>
    </tbody>
  </table>
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th><h3>{{ Lang::get('sdRecord/board.detailDate') }}</h3></th>
        <th><h3>{{ Lang::get('sdRecord/board.detailEditDate') }}</h3></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <p>{{$records->created_at}}</p>
        </td>
        <td>
          <p>{{$records->editTime}}</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="detail-section-background jumbotron">
  <!-- record content -->
  <h2>{{Lang::get('sdRecord/board.detailContent')}}:</h2>
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <p>{{strip_tags($records->sdRecCont)}}</p>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="detail-section-background jumbotron">
  <!-- record asker info -->
  <h2>{{Lang::get('sdRecord/board.detailAskerInfo')}}:</h2>
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th class="hidden-xs"><h3>{{ Lang::get('sdRecord/board.detailUser') }}</h3></th>
        <th><h3>{{ Lang::get('sdRecord/board.detailUserIdAcct') }}</h3></th>
        <th><h3>{{ Lang::get('sdRecord/board.detailUserContact') }}</h3></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="hidden-xs">
          <p>{{$u_category->user}}</p>
        </td>
        <td>
          @if($records->user_id == '')
            <p>{{ Lang::get('sdRecord/board.detailNoUserInfo') }}</p>
          @else
            <p>{{strip_tags($records->user_id)}}</p>
          @endif
        </td>
        <td>
          @if($records->user_contact == '')
            <p>{{ Lang::get('sdRecord/board.detailNoUserInfo') }}</p>
          @else
            <p>{{strip_tags($records->user_contact)}}</p>
          @endif
        </td>
      </tr>
    </tbody>
  </table>
</div>
<a class="btn btn-block btn-lg btn-primary" href="{{ URL::to('deskRecord/'.$records->id.'/edit')}}">
  <span class="glyphicon glyphicon-edit"></span>
  {{ Lang::get('sdRecord/board.edit') }}
</a>
{!! HTML::script('js/sdRecord/deleteRecord.js') !!}
@stop
