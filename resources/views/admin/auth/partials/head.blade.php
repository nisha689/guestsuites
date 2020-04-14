<head>
  <title>@yield('title', trans('admin.front_title'))</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name='robots' content='index,follow'>
  <meta name="url" content="{{ url()->current() }}">
  <meta name="identifier-URL" content="{{ url()->current() }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Kidrend">
  <meta name="twitter:url" content="{{ url()->current() }}">

  @include('partials.meta-tags')

  @yield('meta')

  <link rel="shortcut icon" href="{{ url('favicon.ico') }}">
  <link rel="stylesheet" href="{{ url('common/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" media="all">
  <link rel="stylesheet" href="{{ url('common/css/font-awesome-all.css')}}" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
        crossorigin="anonymous">
  <!--<link href="https://fonts.googleapis.com/css?family=Karla:400,700|Montserrat:300,400,500,600,700,800" rel="stylesheet">-->
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Poppins:400,500,600,700&display=swap"
        rel="stylesheet">
   
  <link rel="stylesheet" href="{{ url('common/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ url('admin/css/style.css')}}">

  <!--valiation-->
  <link type="text/css" rel="stylesheet" href="{{ url('common/css/parsley.css')}}">

  <!--common-->
  <link type="text/css" rel="stylesheet" href="{{ url('common/css/common.css')}}">

  @yield('stylesheet')
</head>