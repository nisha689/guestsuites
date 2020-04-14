@extends('admin.layouts.auth')
@section('title', 'Admin | '.trans('admin.front_title'))
@section('content')
    <main>

        <div class="container">

            <div class="row login-top mb-4">
                <div class="col-md-12 text-center wow fadeInUp">
                    <h1>Register</h1>
                </div>
            </div>
            @include('partials.message.success')
            @include('partials.message.error')
            @include('partials.message.validation_error')
            {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-form', 'id' =>'admin_form', 'data-wow-delay'=>'.3s','class'=>'login-form clearfix wow fadeInUp','data-parsley-validate','route' => ['admin_register']]) !!}

            {{ csrf_field() }}

            {!! Form::hidden('ip_address', \Request::ip(), ['id' => 'ip_address']) !!}

            {!! Form::hidden('signup_method', 'Web', ['id' => 'signup_method']) !!}

            {!! Form::hidden('created_at', DateFacades::getCurrentDateTime('format-1'), ['id' => 'signup_method']) !!}

            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control mb-4', 'placeholder' => trans('admin.user.fields.first_name'), 'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'first_name'])

            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control mb-4', 'placeholder' => trans('admin.user.fields.last_name'), 'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'last_name'])

            {!! Form::text('phone', old('phone'), ['id' => 'phone','class' => 'form-control mb-4', 'placeholder' => trans('admin.user.fields.phone'),'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'phone'])

            {!! Form::email('email', old('email'), ['class' => 'form-control mb-4', 'placeholder' => trans('admin.user.fields.email'), 'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'email'])

            <div class="password-box">
                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4', 'placeholder' => 'Password', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']) !!}
                @include('partials.message.field',['field_name' => 'password'])
                <span toggle="#password"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <div class="password-box">
                {!! Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control mb-4', 'placeholder' => 'Confirm Password', 'data-parsley-equalto' => '#password', 'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '6', 'required' => '']) !!}
                @include('partials.message.field',['field_name' => 'password_confirmation'])
                <span toggle="#password_confirmation"
                      class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <input type="file" style="display:none;" data-name="user-profile-file" name="photo" id="profile_photo">
            <button type="button" class="btn btn-orange select_photo" id="select_photo">Select Photo</button>
            <span class="user-profile-file" style="padding-left:10px;"></span>

            @include('partials.message.field',['field_name' => 'photo'])

            {!! Form::Submit(trans('admin.qa_register'), ['class' => 'btn btn-pink btn-block']) !!}

            {!! Form::close() !!}
            <p id="forgot-link" class="wow fadeInUp"><a
                        href="{{ route('admin.password.reset')}}">@lang('admin.qa_forgot_password')</a></p>
        </div>

    </main>
@endsection