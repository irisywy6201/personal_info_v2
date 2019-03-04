@extends('layout.index')

@section('title', '首頁')

@section('content')

    <div >
    <br><h2 style="border-left:solid 2px #e6b3b3">&nbsp;編輯</h2><br>
    @if($SectionOne->type==2)
      <form  action="{{ url('admin/本校個人資料保護與管理/'.$SectionOne->id) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="2">
        <h4>標題: </h4><input type="text" name="title" value="{{ $SectionOne->title }}" class="form-control"><br><br>
        <h4>內文:</h4><textarea  id="editor1" name="content" rows="10" cols="80">{{ $SectionOne->content }}</textarea>
              <script>
                  CKEDITOR.replace( 'editor1' );
              </script>

              <br><div class="row">
              <div class="col-sm-11">

              </div>
              <div class="col-sm-1">
                <button type="submit" class="btn btn-primary">確認</button>
              </div>
              </div>
        </form>
    @else

      <form  action="{{ url('admin/本校個人資料保護與管理/'.$SectionOne->id) }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="1">
        <h4>標題: </h4><input type="text" name="title" value="{{ $SectionOne->title }}" class="form-control"><br><br>
        <h4>目前檔案:</h4>{{ $SectionOne->content }}
        <h4>更改檔案</h4>
        <div class="fileupload fileupload-new" data-provides="fileupload">
           <span class="btn btn-primary btn-file"><span class="fileupload-new"></span>
             <input type="file" name="content"/></span>
           <span class="fileupload-preview"></span>
         </div><br><br><br><br><br><br><br><br><br><br>

              <br><div class="row">
              <div class="col-sm-11">

              </div>
              <div class="col-sm-1">
                <button type="submit" class="btn btn-primary">確認</button>
              </div>
              </div>
        </form>
    @endif



    </div>

@endsection

@section('css')

@endsection

@section('js')
@endsection
