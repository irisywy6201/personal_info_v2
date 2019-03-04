<!DOCTYPE html>
<html lang="en">
<head>
  <title>中央大學個資</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="/ckeditor/ckeditor/ckeditor.js"></script>
  <style>
    body{
      font-family:微軟正黑體;
    }
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 400px}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      /*background-color: #f1f1f1;*/
      height: 100%;
    }

    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>
</head>
<body>

  @include('layout.navbar')

  <div class="container-fluid " style="background-image:url('/img/bg.jpg');">
    <div class="row content">
      <div class="col-sm-2 "></div>
      <div class="col-sm-8" style="background-color:#fff;">
        @yield('content')
        @include('layout.footer')
      </div>
      <div class="col-sm-2 "></div>
    </div>
  </div>



</body>
</html>
