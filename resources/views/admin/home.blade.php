@extends('admin.layouts.app')
@section('title', 'Admin Home | '.trans('admin.front_title'))
@section('content')

    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/businesses') }}">
                            <div class="totals-box orange">
                                <span>TOTAL Businesses</span>
                                <p>{{ $totalBusinesses }}
                                   <small>Businesses</small>
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/services') }}">
                            <div class="totals-box gray">
                                <span>TOTAL Services</span>
                                <p>{{ $totalServices }}
                                    <small>Services</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/customers') }}">
                            <div class="totals-box blue">
                                <span>TOTAL CUSTOMERS</span>
                                <p>{{ $totalCustomers }}
                                    <small>customers</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-none">
                        <a href="{{ url('admin/parents') }}">
                            <div class="totals-box yellow">
                                <span>TOTAL PARENTS</span>
                                <p>0
                                    <small>parents</small>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 pt-3">
                        <h2 class="pr-box-heading">Hi, {{ $loginUser->first_name }} {{ $loginUser->last_name }}</h2>
                        <div id="profile-box">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(!empty($loginUser->last_login_date) && $loginUser->last_login_date != '0000-00-00 00:00:00')
                                        <p id="last-login">Last login
                                            <span>{{ DateFacades::dateFormat($loginUser->last_login_date,'format-3') }}
                                                <br/>
                                                {{ DateFacades::dateFormat($loginUser->last_login_date,'time-format-1') }}
                                            </span>
                                        </p>
                                    @endif

                                    <div id="box-profile-opt" class="mt-5">
                                        <h3>Your profile</h3>
                                        @if ( !empty($loginUser->photo) && Common::isFileExists($loginUser->photo) )
                                            <img src="{{ url($loginUser->photo) }}" alt="">
                                        @else
                                            <img src="{{ url('images/profile-default.png') }}" alt="">
                                        @endif
                                        <p class="u_width"><span>{{ $loginUser->name }}</span>
                                            <br>{{ $loginUser->email }}</p>
                                        <a href="{{ url('admin/profile') }}" class="btn viewbtn editbtn">Edit</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="box-date">
                                        <img src="{{ url('images/date-big.png') }}">
                                        <p id="time">{{ DateFacades::getCurrentDateTime('format-2') }}</p>
                                        <p id="day" class="mt-3">{{ DateFacades::getCurrentDateTime('format-4') }} <span>{{ DateFacades::getCurrentDateTime('format-3') }}</span></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <h2 class="pr-box-heading">Recent customers</h2>
                        <div class="table-responsive recentcustomer">
                            <table class="table data-table customers-table">
                                <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th class="emailformat">EMAIL</th>
                                    <th class="dateformat">JOINED</th>
                                </tr>
                                </thead>
                                @if(!empty($recentCustomers) && count($recentCustomers) > 0)
                                    <tbody>
                                    @foreach($recentCustomers as $recentCustomerKey => $recentCustomerValue)
                                        <tr>
                                            <td><div class="usernameformat">{{ $recentCustomerValue->first_name }} {{ $recentCustomerValue->last_name }}</div></td>
                                            <td><div class="emailformat">{{ $recentCustomerValue->small_email }}</div></td>
                                            <td>{{ DateFacades::dateFormat($recentCustomerValue->signup_date,'format-3') }} </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                    <tr>
                                        <td colspan="3">@lang('admin.qa_no_entries_in_table')</td>
                                    </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
@endsection
