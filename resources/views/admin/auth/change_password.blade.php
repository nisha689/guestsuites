@extends('admin.layouts.auth')
@section('title', 'Admin | '.trans('admin.front_title'))
@section('content')
    <main>
        <div class="container">
            <div class="row login-top mb-4">
                <div class="col-md-12 text-center wow fadeInUp">
                    <h1>Change password</h1>
                </div>
            </div>
            @include('partials.message.success')
            @include('partials.message.error')
            @include('partials.message.validation_error')
            {!! Form::open(['method' => 'PATCH','name'=>'admin-login-form', 'id' =>'admin_login_form', 'data-wow-delay'=>'.3s','class'=>'login-form clearfix wow fadeInUp','data-parsley-validate','route' => ['admin_change_password']]) !!}

            {{ csrf_field() }}

            <div class="password-box">
                {!! Form::password('current_password', ['id' => 'current_password', 'class' => 'form-control mb-4', 'placeholder' => 'Current Password', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']) !!}
                @include('partials.message.field',['field_name' => 'current_password'])
                <span toggle="#current_password"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            <div class="password-box">
                {!! Form::password('new_password', ['id' => 'new_password', 'class' => 'form-control mb-4', 'placeholder' => 'New password', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']) !!}
                @include('partials.message.field',['field_name' => 'new_password'])
                <span toggle="#new_password"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            <div class="password-box">
                {!! Form::password('new_password_confirmation', ['id' => 'new_password_confirmation', 'class' => 'form-control mb-4', 'placeholder' => 'New Password Confirmation', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '','data-parsley-equalto'=>'#new_password','data-parsley-equalto-message'=>'New Password and confirm password should be same.']) !!}
                @include('partials.message.field',['field_name' => 'new_password_confirmation'])
                <span toggle="#new_password_confirmation"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>

            {!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn-pink btn-block']) !!}

            {!! Form::close() !!}
            <p id="forgot-link" class="wow fadeInUp"><a
                        href="{{ route('admin.password.reset')}}">@lang('admin.qa_forgot_password')</a></p>
        </div>

    </main>
@endsection