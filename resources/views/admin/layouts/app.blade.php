<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('admin.partials.head')

<body>

<div class="loader" id="loader"></div>

@include('admin.partials.header')

@yield('content')

@include('admin.partials.footer')

{!! Form::open(['route' => 'admin_logout', 'style' => 'display:none;', 'id' => 'logout']) !!}

<button type="submit">Logout</button>
{!! Form::close() !!}

@include('admin.partials.javascripts')

</body>

</html>

