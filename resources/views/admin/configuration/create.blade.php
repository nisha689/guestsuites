@extends('admin.layouts.app')
@section('title', 'Settings | '.trans('admin.front_title'))
@section('content')
    <main>
        <div class="main_section">
            <div class="container">
                @include('partials.message.success')
                @include('partials.message.error')
                @include('partials.message.validation_error')

                <div class="page-wrap bx-shadow my-5 px-sm-5">

                    <h1 class="big-heading mb-5">Settings</h1>

                    <div class="row user-dt-wrap">

                        <div class="col-lg-12 pb-5 px-md-5">

                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link {{ $currentTab =='general' ? 'active' : '' }}"
                                                        href="#general" data-toggle="tab">General</a></li>
                                <li class="nav-item"><a class="nav-link {{ $currentTab =='mailjet' ? 'active' : '' }}"
                                                        href="#mailjet" data-toggle="tab">Mailjet</a></li>
                                <li class="nav-item"><a class="nav-link {{ $currentTab =='social' ? 'active' : '' }}"
                                                        href="#social" data-toggle="tab">Social</a></li>
                               
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane mt-4 {{ $currentTab=='general' ? 'active' : '' }}" id="general">
                                    {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]) !!}

                                    {{ csrf_field() }}
                                    @if(count($configurationList)>0)
                                        @foreach($configurationList as $key=>$value)
                                            @if( $value['group_type'] == 1 )
                                                <div class="form-edit-profile">
                                                    {!! Form::label($key,$value['label'], ['class' => '']) !!}
                                                    {!! Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']) !!}
                                                    @include('partials.message.field',['field_name' => $value['key']])
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    {!! Form::hidden( 'currenttab', 'general' ) !!}
                                    <div class="form-edit-profilebtn saveh1">
                                        {!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="tab-pane mt-4 {{ $currentTab=='mailjet' ? 'active' : '' }}" id="mailjet">
                                    {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]) !!}

                                    {{ csrf_field() }}
                                    @if(count($configurationList)>0)
                                        @foreach($configurationList as $key=>$value)
                                            @if( $value['group_type'] == 2 )
                                                <div class="form-edit-profile">
                                                    {!! Form::label($key,$value['label'], ['class' => '']) !!}
                                                    {!! Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']) !!}
                                                    @include('partials.message.field',['field_name' => $value['key']])
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    {!! Form::hidden( 'currenttab', 'mailjet' ) !!}
                                    <div class="form-edit-profilebtn saveh1">
                                        {!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>


                                <div class="tab-pane mt-4 {{ $currentTab=='social' ? 'active' : '' }}" id="social">
                                    {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]) !!}

                                    {{ csrf_field() }}
                                    @if(count($configurationList)>0)
                                        @foreach($configurationList as $key=>$value)
                                            @if( $value['group_type'] == 3 )
                                                <div class="form-edit-profile">
                                                    {!! Form::label($key,$value['label'], ['class' => '']) !!}
                                                    {!! Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']) !!}
                                                    @include('partials.message.field',['field_name' => $value['key']])
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    {!! Form::hidden( 'currenttab', 'social' ) !!}
                                    <div class="form-edit-profilebtn saveh1">
                                        {!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection