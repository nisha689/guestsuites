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
                        <a href="{{ url('admin/customers') }}">
                            <div class="totals-box gray">
                                <span>TOTAL CUSTOMERS</span>
                                <p>{{ $totalCustomers }}
                                    <small>Customers</small>
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ url('admin/transactions') }}">
                            <div class="totals-box blue">
                                <span>TOTAL Transaction</span>
                                <p>${{ $totalTransaction }}
                                    <small></small>
                                </p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="javascript:void(0);">
                            <div class="totals-box yellow">
                                <span>TOTAL ORDERS</span>
                                <p>{{ $totalOrder }}
                                    <small>orders</small>
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
                    <div class="col-lg-6 pt-3">
                        <div class="mt-4 ">
                                <h2 class="pr-box-heading">Business</h2>
                            <canvas id="business_chart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="mt-4 ">
                                <h2 class="pr-box-heading">Customers</h2>
                            <canvas id="customer_chart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="mt-4 ">
                                <h2 class="pr-box-heading">Order</h2>
                            <canvas id="order_chart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="mt-4 ">
                                <h2 class="pr-box-heading">Transaction</h2>
                            <canvas id="transaction_chart"></canvas>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
    
@endsection
@section('javascript')
    <script>
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    var today = new Date();
    var d;
    var month = [];

    for(var i = 6; i >= 0; i -= 1) {
        d = new Date(today.getFullYear(), today.getMonth() - i, 1);
        month.push(monthNames[d.getMonth()]);
    }
    /* Business */
    new Chart(document.getElementById("business_chart"), {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                data: {{ json_encode($businessMap) }},
                borderColor: "#2d59a9",
                label: "Business",
                fill: false
            }]
        }
    });
    /* Customer */
    new Chart(document.getElementById("customer_chart"), {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                data: {{ json_encode($customerMap) }},
                borderColor: "#f9360f",
                label: "Customer",
                fill: false
            }]
        }
    });
    /* Order */
    new Chart(document.getElementById("order_chart"), {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                data: {{ json_encode($orderMap) }},
                borderColor: "#038c30",
                label: "Order",
                fill: false
            }]
        }
    });
    /* Transaction */
    new Chart(document.getElementById("transaction_chart"), {
        type: 'line',
        data: {
            labels: month,
            datasets: [{
                data: {{ json_encode($transactionMap,true) }},
                borderColor: "#7c68dd",
                label: "transaction",
                fill: false
            }]
        }
    });
    </script>
@endsection