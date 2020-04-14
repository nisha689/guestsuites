@extends('admin.layouts.auth')
@section('title', 'Admin login | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        <div class="container-fluid n_success">
            <div class="btb-login-wrap">
                <div class="btb-login">
                    <h1 class="text-center mb-4">Admin login</h1>
                    @include('partials.message.success')
                    @include('partials.message.error')
                    @include('partials.message.validation_error')

                    {!! Form::open(['method' => 'POST','name'=>'admin-login-form', 'id' =>'admin_login_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin_login']]) !!}

                    {!! Form::email('email', old('email'), ['class' => 'form-control mb-4', 'placeholder' => 'Email', 'required' => '']) !!}
                    @include('partials.message.field',['field_name' => 'email'])

                    <div class="password-box">
                        {!! Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4 icon', 'placeholder' => 'Password', 'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '6', 'required' => '']) !!}
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        @include('partials.message.field',['field_name' => 'password'])
                    </div>

                    <div class="form-edit-profilebtn saveh1">
                        {!! Form::Submit(trans('admin.qa_login'), ['class' => 'btn btn_green mt-4']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection