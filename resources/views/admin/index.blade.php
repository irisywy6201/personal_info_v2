@extends('layout.index')

@section('title', '首頁')
@section('css')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


@endsection

@section('content')
    <div class="">

      <br><h2 style="border-left:solid 2px #e6b3b3">&nbsp;後台管理</h2><br>
      <center><button type="button button-margin" class="btn btn-default btn-lg" style="margin-top:40px;"><a href="{{ url('admin/本校個人資料保護與管理') }}" >本校個人資料保護與管理</a></button><br>
      <button type="button button-margin" class="btn btn-default btn-lg" style="margin-top:40px;"><a href="{{ url('admin/個資資產盤點作業') }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;個資資產盤點作業&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></button><br>
      <button type="button button-margin" class="btn btn-default btn-lg" style="margin-top:40px;"><a href="{{ url('admin/其它') }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;其它&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br></button><br></center>

    </div>
<br><br><br><br><br><br><br><br><br><br><br>
<style>
  .button-margin{

  }
  a:link {text-decoration:none;}
</style>
@endsection



@section('js')
@endsection
