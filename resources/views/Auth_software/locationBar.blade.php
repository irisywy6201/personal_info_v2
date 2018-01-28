@section("locationBar")

<script>
var wholeLocation="";

//alert('{{Lang::get("Auth_soft/auth_index.download.title")}}');
$(document).ready(function(){
  $('.chooser').each(function(){
    $(this).hide();
  });
  $('#a0').show();
  $('.page').each(function(){
    $(this).hide();
  });
  $('#line').hide();

  /* 顯示chooser並隱藏page */
  $('.tabs').click(function(){
    var nowLocation="a"+$(this).attr("href").slice(1);

    
    $('.chooser').each(function(){
      if(nowLocation==$(this).attr("id")){
        $(this).show();
      }
      else{
	$(this).hide();
      }
    });
    if(nowLocation!=wholeLocation){
      $('.page').each(function(){
        $(this).hide();	
      });
    }
    wholeLocation="a"+$(this).attr("href").slice(1);
  });

  /* 顯示page */
  $('.listen').click(function(){
    
    var nowLocation="a"+$(this).attr("href").slice(1);
    var nowNumber=$(this).attr("href").slice(1);
   
   //可取得現在的頁面
    $('.page').each(function(){
      if(nowLocation==$(this).attr("id")){
        $(this).show();
      }
      else{
	$(this).hide();	
      }
    });
  });
});
</script>


<ol class="breadcrumb">
  <span class="text-muted">
    {{Lang::get('Auth_soft/locationBar.nowLocation')}}：
    &nbsp;
    &nbsp;
  </span>
  
  <a href="">
    {{Lang::get('Auth_soft/locationBar.bigTitle')}}
  </a>
  <span class="text-muted">
    &nbsp;
    &nbsp;
    /
    &nbsp;
    &nbsp;
  </span>

  @foreach(Lang::get('Auth_soft/auth_index') as $test )
    <a href="#{{$test['index']}}" data-toggle="tab" class="tabs listen_2 listen chooser" id="a{{$test['index']}}">
      {{$test['title']}}
    </a>
  @endforeach
  
  @foreach($authsoftindex as $test ) 
    <span id="aindextitle{{$test->id}}" class="text-muted page">
      &nbsp;
      &nbsp;
      /
      &nbsp;
      &nbsp;
    </span>

    <a href="#indextitle{{$test->id}}" id="aindextitle{{$test->id}}" class="page" data-toggle="tab">
	{{$test->indextitle_zh}}
    </a>
	
  @endforeach

  @foreach($software_category as $test ) 
    <span id="ab{{$test->id}}" class="text-muted page">
      &nbsp;
      &nbsp;
      /
      &nbsp;
      &nbsp;
    </span>

    <a href="#b{{$test->id}}" id="ab{{$test->id}}" class="page" 
    data-toggle="tab">
	{{$test->category_name_zh}}
    </a>
	
  @endforeach
  
  
  @foreach(Lang::get('Auth_soft/auth_index.take_CD.items') as $test )
    <span id="a{{$test['index']}}" class="text-muted page">
      &nbsp;
      &nbsp;
      /
      &nbsp;
      &nbsp;
    </span>
    <a  href="#{{$test['index']}}" id="a{{$test['index']}}" class="page"
    data-toggle="tab">
      {{$test['title']}}
    </a>
  @endforeach
  @foreach(Lang::get('Auth_soft/auth_index.KMS.items') as $test )
    <span id="a{{$test['index']}}" class="text-muted page">
      &nbsp;
      &nbsp;
      /
      &nbsp;
      &nbsp;
    </span>
    <a href="#{{$test['index']}}"  id="a{{$test['index']}}" class="page"
    data-toggle="tab">
      {{$test['title']}}
    </a>
  @endforeach
  
  
</ol>

@show


