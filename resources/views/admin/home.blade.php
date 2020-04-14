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
                        <a href="{{ url('admin/schools') }}">
                            <div class="totals-box orange">
                                <span>TOTAL SCHOOLS</span>
                                <p>0
                                    <small>schools</small>
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/students') }}">
                            <div class="totals-box gray">
                                <span>TOTAL STUDENTS</span>
                                <p>0
                                    <small>students</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/teachers') }}">
                            <div class="totals-box blue">
                                <span>TOTAL TEACHERS</span>
                                <p>0
                                    <small>teachers</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
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
                        <h2 class="pr-box-heading">Recent schools</h2>
                        <div class="table-responsive recentcustomer">
                            <table class="table data-table customers-table">
                                <thead>
                                <tr>
                                    <th>SCHOOL</th>
                                    <th class="emailformat">EMAIL</th>
                                    <th class="dateformat">JOINED</th>
                                </tr>
                                </thead>
                                @if(!empty($recentSchools) && count($recentSchools) > 0)
                                    <tbody>
                                    @foreach($recentSchools as $recentSchoolKey => $recentSchoolValue)
                                        <tr>
                                            <td><div class="usernameformat">{{ $recentSchoolValue->first_name }} {{ $recentSchoolValue->last_name }}</div></td>
                                            <td><div class="emailformat">{{ $recentSchoolValue->small_email }}</div></td>
                                            <td>{{ DateFacades::dateFormat($recentSchoolValue->signup_date,'format-3') }} </td>
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
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="{{ url('images/schoolicon1.png') }}" alt="">Schools</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total schools</p>
                                <h3>{{ $totalSchool }}</h3>
                                <a href="{{ url('admin/schools') }}" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="{{ url('images/teachericon1.png') }}" alt="">Teachers</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total teachers</p>
                                <h3>{{ $totalTeacher }}</h3>
                                <a href="{{ url('admin/teachers') }}" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 pt0 mt0 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="{{ url('images/parentsicon.png') }}" alt="">Parents</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total parents</p>
                                <h3>{{ $totalParent }}</h3>
                                <a href="{{ url('admin/parents') }}" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="{{ url('images/studentsicon.png') }}" alt="">Students</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total students</p>
                                <h3>{{ $totalStudent }}</h3>
                                <a href="{{ url('admin/students') }}" class="btn viewbtn">open</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="{{ url('images/events.png') }}" alt="" style="width:40px;">Clubs</h2>
                            <div class="dash-stats mt-5 mb-5">
                                <p>Total clubs</p>
                                <h3>{{ $totalClub }}</h3>
                                <a href="javascript:void(0);" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="{{ url('images/announce.png') }}" alt="" style="width: 55px;">Announcements
                            </h2>
                            <div class="dash-stats mt-5 mb-5">
                                <p>Total announcements</p>
                                <h3>{{ $totalEvent }}</h3>
                                <a href="javascript:void(0);" class="btn viewbtn">open</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
