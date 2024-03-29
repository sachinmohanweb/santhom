<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to Santhom Connect, where we embrace the love and fostering a welcoming and inclusive environment for spiritual growth and meaningful connections within our vibrant community of faith.">
    <meta name="keywords" content="Santhom Connect, St.Thomas Malankara Syrian Catholic Church,Nalanchira">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/images/logo/logo.svg')}}" type="image/x-icon" width="10px">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/logo.svg')}}" type="image/x-icon" width="10px">
     <title>Santhom Connect - @yield('title')</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    
    @include('layouts.authentication.css')
    @yield('style') 
  </head>
  <body>
    <!-- login page start-->
    @yield('content')  
    <!-- latest jquery-->
    @include('layouts.authentication.script') 
  </body>
</html>