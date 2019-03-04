@extends("sdRecord.boardLayout")
@section("sdRecord.content")

@if(count($records)>0)
  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th class="hidden-xs">#</th>
        <th class="th-department">{{ Lang::get('sdRecord/board.department')}}</th>
        <th class="hidden-xs th-category">{{ Lang::get('sdRecord/board.category')}}</th>
        <th class="hidden-xs th-content">{{ Lang::get('sdRecord/board.content')}}</th>
        <th class="th-recorder">{{ Lang::get('sdRecord/board.recorder')}}</th>
        <th class="th-askerID">{{ Lang::get('sdRecord/board.askerID')}}</th>
        <th class="hidden-xs th-date">{{ Lang::get('sdRecord/board.date')}}</th>
        <th class="hidden-xs th-solution">{{ Lang::get('sdRecord/board.solution')}}</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($records as $key => $value)
        <tr>
          <!-- <td>{{($records->total()+1)-($value->id)}}</td> -->
          <td class="hidden-xs">{{ ($records->currentPage()-1)*($records->perPage())+($key+1) }}</td>
          <!-- department -->
          @foreach($category as $c_value)
            @if($c_value->id == $value->category)
              @foreach($department as $d_value)
                @if($d_value->id == $c_value->parent_id)
                  <td>{{$d_value->name}}</td>
                @endif
              @endforeach
            @endif
          @endforeach
          <!-- category -->
          @foreach($category as $c_value)
            @if($c_value->id == $value->category)
              <td class="hidden-xs">{{$c_value->name}}</td>
            @endif
          @endforeach
          <!-- content -->
          <td class="hidden-xs">{!!str_limit(strip_tags($value->sdRecCont),18)!!}</td>
          <!-- <td>{{$value->sdRecCont}}</td> -->
          <!-- recordHolder -->
          <td>{{ $value->recorder }}</td>
          <!-- user_category -->
          @foreach($u_category as $key => $u_value)
            @if($value->user_category == $u_value->id)
              <td>{{$u_value->user}}</td>
            @endif
          @endforeach
          <!-- time -->
          <td class="hidden-xs">{{$value->created_at}}</td>
          <!-- solution -->
          @foreach($solution as $key => $s_value)
            @if($s_value->id == $value->solution)
              <td class="hidden-xs">{{$s_value->method}}</td>
            @endif
          @endforeach
          <td></td>
          <td>
            <div class="btn-group" role="group">
              <a class="btn btn-info" href="{{ URL::to('deskRecord/'.$value->id.'') }}">
              <!-- <a class="btn btn-default" href="{{ URL::to('/deskRecord/detail') }}"> -->
                <span class="glyphicon glyphicon-eye-open"></span>
                <!-- {{Lang:: get('sdRecord/board.detail')}} -->
              </a>
              <a class="btn btn-primary hidden-xs" href="{{ URL::to('deskRecord/'.$value->id.'/edit') }}">
                <span class="glyphicon glyphicon-pencil hidden-xs"></span>
                <!-- {{Lang:: get('sdRecord/board.edit')}} -->
              </a>
              @if(Auth::user()->isAdmin())
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRecord" data-id="{{ 'deskRecord/'.$value->id }}">
                  <span class="glyphicon glyphicon-trash"></span>
                </button>
              @endif
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="text-center">
    {!!$records->render()!!}
    {{Session::put('pageNum',$records->currentPage())}}
    {{Session::put('pageLeft',$records->count())}}
    {{Session::put('lastPage',$records->lastPage())}}
    <!-- <h2>{!!$records->lastPage()!!}</h2> -->
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

@else
  <br>
  <br>
  <br>
  <div class="text-center">
    <h1 class="text-warning">
      <span class="glyphicon glyphicon-exclamation-sign"></span>
      {{ Lang::get('sdRecord/board.noRecord') }}
    </h1>
    <br>
    <hr>
  </div>
@endif

{!! HTML::script('js/sdRecord/deleteRecord.js') !!}
@endsection
