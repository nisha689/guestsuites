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

            {!! Form::open(['method' => 'POST','name'=>'admin-reset-password-form', 'id' =>'admin_reset_password_form', 'data-wow-delay'=>'.3s','class'=>'login-form clearfix wow fadeInUp','data-parsley-validate','route' => ['admin.password.email']]) !!}

            {{ csrf_field() }}

            {!! Form::email('email', old('email'), ['class' => 'form-control mb-4', 'placeholder' => 'Email', 'required' => '']) !!}
            @include('partials.message.field',['field_name' => 'email'])

            {!! Form::Submit(trans('admin.admin_send_password_reset_link'), ['class' => 'btn btn-pink btn-block']) !!}

            {!! Form::close() !!}
            <p id="forgot-link" class="wow fadeInUp"><a href="{{ route('admin_login')}}">@lang('admin.qa_login')</a></p>
        </div>

    </main>
@endsection