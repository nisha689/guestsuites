@extends('admin.layouts.app')
@section('title', 'Customer Booking Service Details | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5">Customer Booking Service (#{{ $customerBookingService->customer_booked_id  }})</h1>
                        <div class="row mt-5">
                            <div class="col-lg-6 brd-lg-right pb-5 profile_border">
                                <h2 class="text-center mb-4 blackcolor">Customer</h2>
								<div class="row">
									<div class="col-lg-9 user-dt">
										<h3>{{ $customer->name }}</h3>                                
										<a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                        <br>
                                        {{ Common:: getPhoneFormat($customer->phone)  }}
									</div>
									<div class="col-lg-3 user-dt-img">
										@if ( !empty($customer->photo) &&  Common::isFileExists($customer->photo) )
											<img src="{{ url($customer->photo) }}" alt="">
										@else
											<img src="{{ url('images/profile-default.png') }}" alt="">
										@endif
									</div>
								</div>                                
                            </div>
                            <div class="col-lg-5 pl-sm-4 pb-5 tra_title">
                                <h2 class="red text-center mb-4">Order details</h2>
                                <div class="payment-details">
                                    <label>Business:</label>
                                    <p>{{ $customerBookingService->business->company_name }}</p>
                                    <label>Start Date:</label>
                                    <p>{{ DateFacades::dateFormat($customerBookingService->start_date_time,'format-3') }} <br/>
                                        {{ DateFacades::dateFormat($customerBookingService->start_date_time,'time-format-1') }}</p>
                                    <label>Finish Date:</label>
                                    <p>{{ DateFacades::dateFormat($customerBookingService->finish_date_time,'format-3') }} <br/>
                                        {{ DateFacades::dateFormat($customerBookingService->finish_date_time,'time-format-1') }}</p>
                                   <label>Medical condition:</label>
                                   <p>{{ ($customerBookingService->medical_condition == 1) ? "Yes" : "No" }}</p>
                                   @if(! empty($customerBookingService->medical_condition_explain) )
                                       <label>Medical condition explain:</label>
                                       <p>{{ $customerBookingService->medical_condition_explain }}</p>
                                   @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
