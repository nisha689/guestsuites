<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

@include('admin.auth.partials.head')

<body>

    <div class="loader" id="loader"></div>

    @include('admin.auth.partials.header')

    @yield('content')

    @include('admin.auth.partials.footer')

    @include('admin.auth.partials.javascripts')

</body>

</html>