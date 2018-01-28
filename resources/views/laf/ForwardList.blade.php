@extends("layout")
@section("content")

<h1>
  <span class="glyphicon glyphicon-list-alt"></span>
  需移送軍訓室遺失物清單
</h1>

<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th>ID</th>
      <th>{{ Lang::get('LostandFound/page.type') }}</th>
      <th>{{ Lang::get('LostandFound/page.description') }}</th>
      <th>{{ Lang::get('LostandFound/page.location') }}</th>
      <th>{{ Lang::get('LostandFound/page.find_time') }}</th>
      <th>{{ Lang::get('LostandFound/page.picOfThing') }}</th>
      <th>移送軍訓室</th>
    </tr>
  </thead>
  {!! Form::open(array('url' => 'laf/changeMilitary','method' => 'post')) !!}
  <tbody>
    @foreach($results as $key => $value)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $value['type_id'] }}</td>
        <td>{{ $value['description'] }}</td>
        <td>{{ $value['location'] }}</td>
        <td>{{ $value['found_at'] }}</td>
        <td><img src={{URL::to($value['thing_picture1'])}} data-action="zoom" style="width: 50px;height: 50px"></td>
        <td>{!! Form::checkbox('options[' . $key . ']',$value['id']) !!}</td>
      </tr>
    @endforeach
  </tbody>
  {!! Form::submit('已轉送',array('class' => 'btn btn-default')) !!}
  {!! Form::close() !!}

</table>

@stop
