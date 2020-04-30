<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('admin.auth.partials.head')
<body>
@include('errors.partials.header')
<main>
    <div class="main_section">
        <div class="container">
            <div class="msg_section">
                <h1> @yield('code', __('Oh no'))</h1>
                <div class="msgborder"></div>
                <p>
                    @yield('message')
                </p>
                <a href="{{ app('router')->has('home') ? route('home') : url('admin/home') }}">
                    <button class="">
                        {{ __('Go Home') }}
                    </button>
                </a>
            </div>
        </div>
    </div>
</main>
@include('admin.auth.partials.footer')
@include('admin.auth.partials.javascripts')
</body>
</html>
