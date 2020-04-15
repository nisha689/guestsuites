@extends('admin.layouts.app')
@section('title', 'Transaction details | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5">Transaction (#{{ $transaction->id }})</h1>
                        <div class="row mt-5">
                            <div class="col-lg-6 brd-lg-right pb-5 profile_border">
                                <h2 class="text-center mb-4 blackcolor">Payee</h2>
								<div class="row">
									<div class="col-lg-9 user-dt">
										<h3>{{ $payForUser->name }}</h3>                                
										<a href="mailto:{{ $payForUser->email }}">{{ $payForUser->email }}</a>
									</div>
									<div class="col-lg-3 user-dt-img">
										@if ( !empty($payForUser->photo) &&  Common::isFileExists($payForUser->photo) )
											<img src="{{ url($payForUser->photo) }}" alt="">
										@else
											<img src="{{ url('images/profile-default.png') }}" alt="">
										@endif
									</div>
								</div>                                
                            </div>
                            <div class="col-lg-5 pl-sm-4 pb-5 tra_title">
                                <h2 class="red text-center mb-4">Payment details</h2>
                                <div class="payment-details">
                                    <label>Amount:</label>
                                    <p>${{ Common::setPriceFormat($transaction->amount) }}</p>
                                    <label>Product:</label>
                                    <p>{{ $transaction->plan->plan_name }} plan</p>
                                    <label>Paid on:</label>
                                    <p>{{ DateFacades::dateFormat($transaction->created_at,'format-3') }} <br/>
                                        {{ DateFacades::dateFormat($transaction->created_at,'time-format-1') }}</p>
                                    <label>Method:</label>
                                    <p>{{ $transaction->payment_method_string }}</p>
                                    @if( $transaction->payment_method == 1 )
                                        <label>Stripe Transaction ID:</label>
                                    @else
                                        <label>Paypal Transaction ID:</label>
                                    @endif
                                    <p>{{ $transaction->transaction_id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
