@extends('layout.index')

@section('title', '首頁')

@section('content')
    <div class="">
      <br><h2 style="border-left:solid 2px #e6b3b3">&nbsp;新增-本校個人資料保護與管理</h2><br>
      <div class="btn-group">
         <button class="btn dropdown-toggle btn-select" data-toggle="dropdown" href="#">選擇連結模式 <span class="caret"></span></button>
         <ul class="dropdown-menu">
           <li><a id="show_filetype" onclick="show_filetype()">連結單一檔案</a></li>
           <li><a id="show_articletype" onclick="show_articletype()">連結文章列表</a></li>
         </ul>
       </div><br><br>

       <form  action="{{ url('/admin/本校個人資料保護與管理') }}" enctype="multipart/form-data" method="post">
         {{ csrf_field() }}
         <div id="filetype">
           <input type="hidden" name="type" value="1">
           <h4>標題: </h4><input type="text" name="title" class="form-control"><br><br>
           <h4>檔案:</h4>
           <div class="fileupload fileupload-new" data-provides="fileupload">
							<span class="btn btn-primary btn-file"><span class="fileupload-new"></span>
								<input type="file" name="content"/></span>
							<span class="fileupload-preview"></span>
						</div> <br><br><br><br><br><br><br><br><br><br>
           <div class="row">
             <div class="col-sm-11">
             </div>
             <div class="col-sm-1">
               <button type="submit" class="btn btn-primary">確認</button>
             </div>
            </div><br><br>
         </div>

       </form>

      <form class="" action="{{ url('/admin/本校個人資料保護與管理') }}" method="post">
        {{ csrf_field() }}
        <div id="articletype" style="display:none">
          <input type="hidden" name="type" value="2">
          <h4>標題: </h4><input type="text" name="title" value="" class="form-control"><br><br>
          <h4>內文:</h4>
          <textarea  id="editor1" name="content" rows="10" cols="80"></textarea>
                <script>
                    CKEDITOR.replace( 'editor1' );
                </script><br>

          <div class="row">
            <div class="col-sm-11">
            </div>
            <div class="col-sm-1">
              <button type="submit" class="btn btn-primary">確認</button>
            </div>
          </div>
        </div>

      </form>



    </div>
    <script type="text/javascript">
      $(".dropdown-menu li a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
      });

      $(document).ready(function(){
          $("#show_filetype").click(function(){
              $("#articletype").hide(700);
              $("#filetype").show(700);
          });
      });

      $(document).ready(function(){
          $("#show_articletype").click(function(){
              $('#articletype').css('display','').show(700);

              $("#filetype").hide(700);
          });
      });

    </script>
@endsection

@section('css')

@endsection

@section('js')


@endsection
