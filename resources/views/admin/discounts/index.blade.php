@extends('admin.layouts.app')
@section('title', 'Discounts | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Discounts ({{ $totalRecordCount }})</h1>
                        <a href="javascript:void(0);" class="btn light_blue float-right newbtn" onclick="openAddModal('#exam_model')">New discount</a>
                        <div class="clear-both"></div>

                        {!! Form::open(['method' => 'GET','name'=>'admin-exam-search', 'id' =>'admin_exam_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.discounts']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}
                        
                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/discounts')}}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                       </div>

                        <div class="col-md-5 col-lg-5">
                            {!! Form::text('code', $code, ['class' => 'form-control mb-3', 'placeholder' => 'Code']) !!}
                        </div>

                        <div class="col-md-3 col-lg-2 offset-lg-3 offset-md-0">
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

                                    <th class="updownicon"
                                        onclick="sortWithSearch('discounts_id');">ID
                                        {!!  $sortedBy =='discounts_id' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('code');">Code
                                        {!!  $sortedBy =='code' ? $sorting : $sortDefault  !!}</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Percent</th>
                                    <th>Validity</th>
                                    <th class="actionwidth">@lang('admin.user.fields.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($discounts) && count($discounts) > 0)
                                    @foreach($discounts as $discountKey => $discount)
                                        <tr>
                                            <td class="data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td><b>{{ $discount->code  }}</b></td>
                                            <td><b>{{ $discount->discounts_type  }}</b></td>
                                            <td>{{ ($discount->fixed_amount > 0) ? "$".$discount->fixed_amount : "-" }}</td>
                                            <td>{{ ($discount->percent > 0) ? $discount->percent."%" : "-" }}</td>
                                            <td>
                                                <b>{{ DateFacades::dateFormat($discount->validity_date,'format-3') }}</b>
                                            </td>

                                            <td class="action_div">
                                            		<div class="action_club">
                                                <a href="javascript:void(0);"  onclick="openEditModal('#exam_model',{{ $discount->discounts_id }})"
                                                   class="viewbtn">view</a>
                                                {!! Form::open(array(
                                                        'method' => 'DELETE',
                                                         'onsubmit' => "return confirm('".trans("admin.qa_are_you_sure_delete")." discount?');",
                                                        'route' => ['admin.discount.delete'])) !!}
                                                {!! Form::hidden('id',$discount->discounts_id ) !!}

                                                <button type="submit" value="Delete" class="delete_btn"><i
                                                            class="far fa-trash-alt"></i></button>

                                                {!! Form::close() !!}
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
	@include('admin.discounts.edit_model')
@endsection
@section('javascript')
    <script>
        var form = 'form#admin_exam_search_form';
		var formAddEditForm = 'form#add_edit_exam_model_form';
        window.addEditUrl = "{{ URL::to('admin/discount/ajax_save') }}";
        window.getDataForEditUrl = "{{ URL::to('admin/discount/get_data') }}";

        pageTitle = "discount";
        addEditModelIdElement = $(formAddEditForm + " #add_edit_model_id");
        codeElement = $(formAddEditForm + " #code");
        validityDateElement = $(formAddEditForm + " #validity_date");
        percentElement = $(formAddEditForm + " #percent");
        fixedAmountElement = $(formAddEditForm + " #fixed_amount");
        customErrorMessageElement = $(formAddEditForm + " .custom-error-message");
        customSuccessMessageElement = $(formAddEditForm + " .custom-success-message");
        modelTitleElement = $(".modal-title");

        /* Reset Form */
        function ResetForm() {
            $(formAddEditForm).parsley().reset();
            customErrorMessageElement.hide();
            customSuccessMessageElement.hide();
            addEditModelIdElement.val(0);
            codeElement.val("");
            validityDateElement.val("");
            percentElement.val("");
            fixedAmountElement.val("");
            
        }

        /* Open Add Model */
        function openAddModal(modelSelector) {
            ResetForm();
            modelTitleElement.html("Add " + pageTitle);
            openModal(modelSelector);
        }

        /* Add Edit Ajax Call */
        $(formAddEditForm).submit(function (event) {

            if ($(formAddEditForm).parsley().validate()) {

                event.preventDefault();
                customErrorMessageElement.hide();
                customSuccessMessageElement.hide();
                showLoader();

                jQuery.ajax({
                    url: window.addEditUrl,
                    method: 'post',
                    dataType: 'JSON',
                    data: {
                        '_token': window._token,
                        'discounts_id': addEditModelIdElement.val(),
                        'code': codeElement.val(),
                        'validity_date': validityDateElement.val(),
                        'fixed_amount': fixedAmountElement.val(),
                        'percent': percentElement.val(),
                    },
                    success: function (response) {
                        if (response.success == true) {
                            customSuccessMessageElement.html(response.message);
                            customSuccessMessageElement.show();
                            hideLoader();
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            customErrorMessageElement.html(response.message);
                            customErrorMessageElement.show();
                            hideLoader();
                        }
                    },
                    error: function (xhr, status) {
                        customErrorMessageElement.html(AjaxErrorMsgCommon);
                        customErrorMessageElement.show();
                        hideLoader();
                    }
                });
            }
        });

        function FormDataBind(data) {

            addEditModelIdElement.val(data.discounts_id);
            codeElement.val(data.code);
            validityDateElement.val(moment(data.validity_date).format('MM/DD/YYYY'));
            fixedAmountElement.val(data.fixed_amount);
            percentElement.val(data.percent);
        }

        function openEditModal(modelSelector, id) {
            showLoader();
            jQuery.ajax({
                url: window.getDataForEditUrl,
                method: 'post',
                dataType: 'JSON',
                data: {
                    '_token': window._token,
                    'discounts_id': id,
                },
                success: function (response) {
                    if (response.success == true) {
                        ResetForm();
                        modelTitleElement.html("Edit " + pageTitle);
                        FormDataBind(response.data);
                        hideLoader();
                        openModal(modelSelector);
                    } else {
                        hideLoader();
                        ResetForm();
                    }
                },
                error: function (xhr, status) {
                    customErrorMessageElement.html(AjaxErrorMsgCommon);
                    customErrorMessageElement.show();
                    hideLoader();

                }
            });
        }

    </script>
@endsection
