@extends('layout.index')

@section('title', '首頁')

@section('content')
  <div><img src="/img/ncu.jpg" alt="" width="103%" style="margin-left:-15px;marging-right:-15px"></div>
  <div class="row content">
    <div class="col-sm-4" style="padding:0px"><brr>
      <center><img src="/img/index-pic2.png" style="width:100%"></center>
      <div style="margin-left:15px">
        @if(isset($SectionOne))
          @foreach($SectionOne as $SectionOne)
            <a href="{{ url('本校個人資料保護與管理/'.$SectionOne->id.'/'.$SectionOne->title) }}" @if($SectionOne->type==1) target="_blank" @endif><h4>•{{ $SectionOne->title }}</h4></a>
          @endforeach
        @endif
      </div>
    </div>
    <div class="col-sm-4" style="padding:0px">
      <center><img src="/img/index-pic1.png" style="width:100%"></center>
      <div style="margin-left:15px">
        @if(isset($SectionTwo))
          @foreach($SectionTwo as $SectionTwo)
            <a href="{{ url('個資資產盤點作業/'.$SectionTwo->id.'/'.$SectionTwo->title) }}"><h4>•{{ $SectionTwo->title }}</h4></a>
          @endforeach
        @endif
      </div>
    </div>
    <div class="col-sm-4" style="padding:0px">
      <center><img src="/img/index-pic2.png" style="width:100%"></center>
      <div style="margin-left:15px">
        @if(isset($SectionThree))
          @foreach($SectionThree as $SectionThree)
            <a href="{{ url('其它/'.$SectionThree->id.'/'.$SectionThree->title) }}"><h4>•{{ $SectionThree->title }}</h4></a>
          @endforeach
        @endif
      </div>
    </div>
  </div>

@endsection

@section('css')

@endsection

@section('js')

@endsection
