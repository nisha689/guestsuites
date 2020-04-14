@extends('admin.layouts.app')
@section('title', 'Transactions | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Transactions ({{ $totalRecordCount }})</h1>
                        <div class="clear-both"></div>

                        {!! Form::open(['method' => 'GET','name'=>'admin-transaction-search', 'id' =>'admin_transaction_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.transactions']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}

                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/transactions') }}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3">
                            {!! Form::text('name', $name, ['class' => 'form-control mb-3', 'placeholder' => 'Names']) !!}
                        </div>

                        <div class="col-md-5 col-lg-3">
                            {!! Form::email('email', $email, ['class' => 'form-control mb-3', 'placeholder' => 'Email']) !!}
                        </div>

                        <div class="col-md-4 col-lg-2">
                            {!! Form::select('status', ['' => 'Status','1' => 'Success','0' => 'Fail'], $status, ['class' => 'form-control mb-3']) !!}
                        </div>

                        <div class="col-md-4 col-lg-2">
                            {!! Form::select('payment_method', ['' => 'Types','1' => 'Stripe','2' => 'Paypal'], $paymentMethod, ['class' => 'form-control mb-3']) !!}
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('start_date', $startDate, ['id' =>'start_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'From date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('end_date', $endDate, ['id' =>'end_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'To date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>
									
                        <div class="col-md-3 col-lg-2 offset-lg-4 offset-md-3">
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
                                        onclick="sortWithSearch('id');">Order#
                                        {!!  $sortedBy =='id' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('created_at');">Order date
                                        {!!  $sortedBy =='created_at' ? $sorting : $sortDefault  !!}</th>
                                    <th>Payee</th>
                                    <th>Amount</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($transactions) && count($transactions) > 0)
                                    @foreach($transactions as $transactionKey => $transaction)
                                        <tr>
                                            <td class="dtransaction-id data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td>
                                                <b>{{ DateFacades::dateFormat($transaction->created_at,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($transaction->created_at,'time-format-1') }}
                                            </td>
                                            <td>
                                                <b>{{ $transaction->user->name }}</b>
                                                <a href="mailto:{{ $transaction->user->email  }}"
                                                   class="mail emailcolor">{{ $transaction->user->email  }}</a>
                                            </td>
                                            <td>${{ $transaction->amount }}</td>
                                            <td><div class="business_width_index">{{ $transaction->plan->plan_name }}</div></td>
                                            <td class="{{ $transaction->status ==1 ? 'green' : 'inactive' }}">
                                                <b>{{ $transaction->status_string }}</b></td>
                                            
                                            <td class="action_div">
                                                <div class="action-warp">
                                                    <div class="left-action">
                                                        <a href="{{ url('admin/transaction/') }}/{{ Common::getEncryptId($transaction->id) }}" class="viewbtn singlebtn">view</a>
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