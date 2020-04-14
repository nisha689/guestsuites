@extends('admin.layouts.auth')
@section('title', 'Admin | '.trans('admin.front_title'))
@section('content')
    <main>
        <div class="container">
            <div class="row login-top mb-4">
                <div class="col-md-12 text-center wow fadeInUp">
                    <h1 class="resetpw">Reset password</h1>
                </div>
            </div>

            @include('partials.message.success')
            @include('partials.message.error')
            @include('partials.message.validation_error')

            {!! Form::open(['method' => 'POST','name'=>'admin-login-form', 'id' =>'admin_login_form', 'data-wow-delay'=>'.3s','class'=>'login-form clearfix wow fadeInUp','data-parsley-validate','route' => ['admin.password.reset']]) !!}

            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            {!! Form::email('email', old('email'), ['class' => 'form-control mb-4', 'placeholder' => 'Email', 'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'email'])

            <div class="password-box">
                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4', 'placeholder' => 'Password',  'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']) !!}
                @include('partials.message.field',['field_name' => 'password'])
                <span toggle="#password"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            <div class="password-box">
                {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control mb-4', 'placeholder' => 'Confirm Password',  'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '', 'data-parsley-equalto' =>'#password','data-parsley-equalto-message' => 'Password and confirm password should be same.']) !!}
                @include('partials.message.field',['field_name' => 'password_confirmation'])
                <span toggle="#password_confirmation"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            {!! Form::Submit(trans('admin.qa_reset_password'), ['class' => 'btn btn-pink btn-block']) !!}

            {!! Form::close() !!}
            <p id="forgot-link" class="wow fadeInUp"><a
                        href="{{ route('admin.password.reset')}}">@lang('admin.qa_forgot_password')</a></p>
        </div>

    </main>
@endsection