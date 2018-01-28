<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom" style="background-color:#333">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <a class="navbar-brand" href="{{ url('/') }}"><span><img src="http://www.ncu.edu.tw/assets/thumbs/pic/df1dfaf0f9e30b8cc39505e1a5a63254.png" height="25" width="25" ><img src="/img/title.png" alt=""height="25"></span></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="myNavbar" >
            <ul class="nav navbar-nav navbar-right " >
			 @if(Auth::user())
                    <li>
                        <a href="{{ url('/admin') }}" style="color:#fff">後臺管理</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color:#fff">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    登出
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
              @else
					{!! Form::open(["route" => "netid", "autocomplete" => "off" ,"class" => "form-horizontal", "id"=> "myForm"]) !!}
					<li class="page-scroll navbtn"> 
						<a class="submit" href="#" style="color:#fff">登入</a>	
					</li>
              @endif
              
                <li class="page-scroll navbtn">
                    <a href="http://www.ncu.edu.tw/" style="color:#fff">中大首頁</a>
                </li>{!! Form::close() !!}
					
                
                

            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav><br><br>
<script>
$(document).ready(function(){
    $("a.submit").click(function(){
        document.getElementById("myForm").submit();
    }); 
});
</script>
<style>
  /* Remove the navbar's default margin-bottom and rounded borders */
  .navbar {
    margin-bottom: 0;
    border-radius: 0;
  }
  .navbtn{
      border-color: #f5f5dc;
      border-right-style:solid ;
  }

</style>
