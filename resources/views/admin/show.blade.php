@extends('layout.index')

@section('title', '首頁')

@section('content')
    <div class="">
      <h2>
        {{ $show->title }}

    </h2>

      {!! $show->content !!}

    </div>

@endsection

@section('css')

@endsection

@section('js')
@endsection
