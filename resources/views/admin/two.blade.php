@extends('layout.index')

@section('title', '首頁')

@section('content')
    <div class="">
      <br><h2 style="border-left:solid 2px #e6b3b3">&nbsp;個資資產盤點作業</h2><br>
      <div class="right"><a href="{{ url('admin/個資資產盤點作業/create') }}" ><button type="button" class="btn btn-primary">新增</button></a></div>
      <table class="table">
       <thead>
         <tr>
           <th>文章名稱</th>
           <th>/&nbsp;</th>
         </tr>
       </thead>
       <tbody>
         @foreach($SectionTwo as $SectionTwo)
         <tr>
           <td>{{ $SectionTwo->title }}</td>
           <td><p>
             <div class="form-group">
      					 <div class="col-sm-2">
                   <form action="{{ url('admin/個資資產盤點作業/'.$SectionTwo->id.'/edit') }}" method="GET">
            					<button type="submit" id="edit-category-{{ $SectionTwo->id }}" class="btn btn-default btn-sm">
            						<span class="glyphicon glyphicon-pencil"></span>修改
            					</button>
            			 </form>
                 </div>
                <div class="col-sm-2">
                  <form action="{{ url('admin/個資資產盤點作業/'.$SectionTwo->id) }}" method="POST">
                              {!! csrf_field() !!}
                              {!! method_field('DELETE') !!}
                              <button type="submit" id="delete-category-{{ $SectionTwo->id }}" class="btn btn-danger btn-sm">
                                <span class="glyphicon glyphicon-trash"></span>刪除
                              </button>
                    </form>


            			</form>
                </div>
              </div>
            </p></td>

         </tr>
         @endforeach
       </tbody>
      </table>



    </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection

@section('css')

@endsection

@section('js')
@endsection
