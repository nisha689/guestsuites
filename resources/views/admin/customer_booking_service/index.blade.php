@extends('admin.layouts.app')
@section('title', 'Customer Booking Services | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Customer Booking Services ({{ $totalRecordCount }})</h1>
                        <div class="clear-both"></div>

                        {!! Form::open(['method' => 'GET','name'=>'admin-transaction-search', 'id' =>'admin_transaction_search_form', 'class'=>'top-search-options form-row pb-4','url' => 'admin/customer-booking-service/'.$customerIdEncrypt]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}

                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/customer-booking-service/'.$customerIdEncrypt) }}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('start_date', $startDate, ['id' =>'start_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Start date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('end_date', $endDate, ['id' =>'end_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Finish date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>
                        <div class="col-md-3 col-lg-2 mt-md-0 mt-3 offset-lg-2">
                            {!! Form::Submit(trans('admin.qa_search'), ['class' => 'btn btn_green resetbtn']) !!}                           
                        </div>						
                        {!! Form::close() !!}

                        <div class="table-responsive mt-5">
                            <table class="table sorting data-table school" id="classes">
                                <thead>
                                <tr>
                                    @php($shortClass = ( strtolower($sortedOrder) == 'asc') ? 'up' : 'down' )
                                    @php($sortDefault = '<i class="fas fa-sort"></i>')
                                    @php($sorting = '<i class="fas fa-caret-'.$shortClass.'"></i>')

                                    <th class="updownicon transactions_index_width"
                                        onclick="sortWithSearch('customer_booked_id');">Order#
                                        {!!  $sortedBy =='customer_booked_id' ? $sorting : $sortDefault  !!}</th>
                                    <th>Customer</th>
                                    <th>Business</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('start_date_time');">Start date
                                        {!!  $sortedBy =='start_date_time' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('finish_date_time');">Finish date
                                        {!!  $sortedBy =='finish_date_time' ? $sorting : $sortDefault  !!}</th>
                                    
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($customerBookingServices) && count($customerBookingServices) > 0)
                                    @foreach($customerBookingServices as $customerBookingServiceKey => $customerBookingService)
                                        <tr>
                                            <td class="dtransaction-id data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td>
                                                <b>{{ $customerBookingService->customer->name }}</b>
                                                <a href="mailto:{{ $customerBookingService->customer->email  }}"
                                                   class="mail emailcolor">{{ $customerBookingService->customer->email  }}</a>
                                            </td>
                                            <td>
                                                <b>{{ $customerBookingService->business->company_name }}</b>
                                                <a href="mailto:{{ $customerBookingService->business->email  }}"
                                                   class="mail emailcolor">{{ $customerBookingService->business->email  }}</a>
                                            </td>
                                            <td>
                                                @if(!empty($customerBookingService->start_date_time))
                                                <b>{{ DateFacades::dateFormat($customerBookingService->start_date_time,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($customerBookingService->start_date_time,'time-format-1') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($customerBookingService->finish_date_time))
                                                <b>{{ DateFacades::dateFormat($customerBookingService->finish_date_time,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($customerBookingService->finish_date_time,'time-format-1') }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            
                                            
                                            <td class="action_div">
                                                <div class="action-warp">
                                                    <div class="left-action">
                                                        <a href="{{ url('admin/customer-booking-service-details/') }}/{{ Common::getEncryptId($customerBookingService->customer_booked_id) }}" class="viewbtn singlebtn">view</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10">@lang('admin.qa_no_entries_in_table')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        {!! $paging !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        var form = 'form#admin_transaction_search_form';
    </script>
@endsection