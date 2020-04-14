@inject('request', 'Illuminate\Http\Request')
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name='robots' content='index,follow'>
	<meta name="url" content="{{ url()->current() }}">
	<meta name="identifier-URL" content="{{ url()->current() }}">
	<link rel="canonical" href="{{ url()->current() }}">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@B2B">
	<meta name="twitter:url" content="{{ url()->current() }}">

	@yield('meta')

	<title>@yield('title', trans('admin.front_title'))</title>

	<!--Theme CSS-Files -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
		  crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Karla:400,700|Montserrat:300,400,500,600,700,800" rel="stylesheet">

	<link type="text/css" rel="stylesheet" href="{{ url('css/bootstrap.min.css')}}">
	<link type="text/css" rel="stylesheet" href="{{ url('css/sorter.css')}}">
	<link type="text/css" rel="stylesheet" href="{{ url('css/datepicker.css')}}">
	<link type="text/css" rel="stylesheet" href="{{ url('css/style.css')}}">

	<!--valiation-->
	<link type="text/css" rel="stylesheet" href="{{ url('css/parsley.css')}}">

	<!--custom-->
	<link type="text/css" rel="stylesheet" href="{{ url('css/custom.css')}}">

	@yield('stylesheet')
</head>