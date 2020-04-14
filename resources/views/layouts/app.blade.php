<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

@include('partials.head')

<body>

<div class="loader" id="loader"></div>

@include('partials.header')

@yield('content')

@include('partials.footer')

<!--Scripts-->
@include('partials.javascripts')

</body>

</html>

