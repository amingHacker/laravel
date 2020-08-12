<!DOCTYPE html>
<html lang="zh-TW">

    <head>
      
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="icon" type="image/x-icon" href="img/favicon.ico">

        <title>Merck CIM System</title>
      
        {{-- 1.填寫標題的地方 --}}
        {{-- <title>Business Casual - Start Bootstrap Theme</title> --}}
        {{-- <title>@yield('title')</title> --}}
      
        {{-- 2.連結css的地方 --}}
        <!-- Bootstrap core CSS -->
        {{-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
        <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      
        {{-- 3.連結css的地方 --}}
        <!-- Custom styles for this template -->
        {{-- <link href="css/business-casual.min.css" rel="stylesheet"> --}}
        <link href="{{asset('css/modern-business.css')}}" rel="stylesheet">
         
        {{-- 引用Javascript --}}
        <script src="{{ asset ('jquery/jquery.min.js') }}"></script>
        <script src="{{ asset ('bootstrap/js/bootstrap.bundle.min.js')}} "></script>
        
        <style>
          body{
            background-color:rgb(245, 245, 245);
          }
        </style>


    </head>
      
    <body>
    {{-- 4.從外部include各種固定的layout進來，達到分割layout的效果 --}}
    {{-- @include('mainlayout.layouts.header') --}}
    @include('mainlayout.layouts.navbar-fixbar')
    @yield('content')   
    @include('mainlayout.layouts.footer')

    </body>

</html>