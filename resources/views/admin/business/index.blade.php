@extends('admin.layouts.app')
@section('title', 'Businesses | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Businesses({{ $totalRecordCount }})</h1>
                        <a href="javascript:void(0)" onclick="openTeacherModal('#teacher_model')"
                           class="btn light_blue float-right newbtn">New Business</a>
                        <div class="clear-both"></div>
                        {!! Form::open(['method' => 'GET','name'=>'admin-teacher-search', 'id' =>'admin_teacher_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.businesses']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}
                        
                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/businesses') }}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-5 col-lg-3">
                            {!! Form::text('name', $name, ['class' => 'form-control mb-3', 'placeholder' => 'Names']) !!}
                        </div>

                        <div class="col-md-4 col-lg-4">
                            {!! Form::email('email', $email, ['class' => 'form-control mb-3', 'placeholder' => 'Email']) !!}
                        </div>

                        <div class="col-md-4 col-lg-3">
                            {!! Form::select('status', $statusDropDown, $status, ['class' => 'form-control mb-3']) !!}
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('start_date', $createdStartDate, ['id' =>'start_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Signed up from','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>

                        <div class="col-md-4  col-lg-3">
                            {!! Form::text('end_date', $createdEndDate, ['id' =>'end_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Signed up to','autocomplete' => 'Off', 'data-toggle'=>'datepicker']) !!}
                        </div>

                        <div class="col-md-3 col-lg-2 offset-lg-4">
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
                                        onclick="sortWithSearch('user_id');">@lang('admin.user.fields.id')
                                        {!!  $sortedBy =='user_id' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('first_name');">NAMES
                                        {!!  $sortedBy =='first_name' ? $sorting : $sortDefault  !!}</th>
                                    <th>JOINED</th>
                                    <th>CUSTOMERS</th>
                                    <th>STATUS</th>
                                    <th>@lang('admin.user.fields.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($businesses) && count($businesses) > 0)
                                    @foreach($businesses as $businessKey => $business)
                                        <tr>
                                            <td class="data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td>
                                                <b>{{ $business->name }}</b>
                                                <a href="mailto:{{ $business->email  }}"
                                                   class="mail">{{ $business->short_email  }}</a><br>
                                                {{ Common:: getPhoneFormat($business->phone)  }}
                                            </td>
                                            <td>
                                                <b>{{ DateFacades::dateFormat($business->created_at,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($business->created_at,'time-format-1') }}
                                            </td>
                                            <td>
                                                <b>{{ $business->business_customer($business->user_id)->count() }}</b>
                                                <a href="{{ url('admin/customers?business_id='.$business->user_id)}}"
                                                           class="viewbtn">View</a>
                                            </td>
                                            <td class="{{ $business->status ==1 ? 'green' : 'inactive' }}">
                                                <b>{{ $business->status_string }}</b></td>
                                            <td class="action_div">
                                                <div class="action-warp">
                                                    <div class="left-action">
                                                        <a href="javascript:void(0)"
                                                           onclick="openContactModal('.contact-model',{{ $business->user_id }})"
                                                           class="viewbtn contact">Contact</a>
                                                        <a href="{{ url('admin/business/profile/')}}/{{ Common::getEncryptId($business->user_id) }}"
                                                           class="viewbtn">view</a>
                                                        
                                                    </div>
                                                    <div class="right-action">
                                                        {!! Form::open(array(
                                                                'method' => 'DELETE',
                                                                 'onsubmit' => "return confirm('".trans("admin.qa_are_you_sure_delete")." business?');",
                                                                'route' => ['admin.business.delete'])) !!}
                                                        {!! Form::hidden('id',$business->user_id ) !!}
                                                        

                                                        <button type="submit" value="Delete" class="delete_btn">
                                                            <i class="far fa-trash-alt"></i></button>

                                                        {!! Form::close() !!}
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
    @include('admin.business.contact_model')
    @include('admin.business.add_edit_model')
@endsection
@section('javascript')
    <script>
        var form = 'form#admin_teacher_search_form';

        /*----------------------------------  Teacher  -----------------------------------*/

        var addEditTeacherForm = 'form#add_edit_teacher_model_form';
        window.addEditTeacherUrl = "{{ URL::to('admin/business/save_ajax') }}";
        

        addEditTeacherModelIdElement = $(addEditTeacherForm + " #add_edit_teacher_model_id");
        firstNameElement = $(addEditTeacherForm + " #first_name");
        lastNameElement = $(addEditTeacherForm + " #last_name");
        emailElement = $(addEditTeacherForm + " #email");
        phoneElement = $(addEditTeacherForm + " #phone");
        companyNameElement = $(addEditTeacherForm + " #company_name");
        customTeacherErrorMessageElement = $(addEditTeacherForm + " .custom-error-message");
        customTeacherSuccessMessageElement = $(addEditTeacherForm + " .custom-success-message");

        /* Teacher Reset Form */
        function resetTeacherForm() {
            $(addEditTeacherForm).parsley().reset();
            customTeacherErrorMessageElement.hide();
            customTeacherSuccessMessageElement.hide();
            addEditTeacherModelIdElement.val(0);
            firstNameElement.val("");
            lastNameElement.val("");
            emailElement.val("");
            companyNameElement.val("");
            phoneElement.val("");
        }

        /* Add Edit Ajax Call */
        $(addEditTeacherForm).submit(function (event) {

            if ($(addEditTeacherForm).parsley().validate()) {

                event.preventDefault();
                customTeacherErrorMessageElement.hide();
                customTeacherSuccessMessageElement.hide();
                showLoader();

                phoneElement.unmask();
                var formData = new FormData($(this)[0]);

                jQuery.ajax({
                    url: window.addEditTeacherUrl,
                    enctype: 'multipart/form-data',
                    method: 'post',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function (response) {
                        if (response.success == true) {
                            customTeacherSuccessMessageElement.html(response.message);
                            customTeacherSuccessMessageElement.show();
                            hideLoader();
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            customTeacherErrorMessageElement.html(response.message);
                            customTeacherErrorMessageElement.show();
                            hideLoader();
                        }
                    },
                    error: function (xhr, status) {
                        customTeacherErrorMessageElement.html(AjaxErrorMsgCommon);
                        customTeacherErrorMessageElement.show();
                        hideLoader();
                    }
                });
            }
        });

        /* Open Teacher Model */
        function openTeacherModal(modelSelector) {
            resetTeacherForm();
            openModal(modelSelector);
        }

        /*----------------------------------  Contact  -----------------------------------*/

        /* Contact form start */
        var contactForm = 'form#contact_form';
        window.sendContactMailUrl = "{{ URL::to('contact/send_mail') }}";
        contactModelUserIdElement = $(contactForm + " #contact_model_user_id");
        contactModelMessageElement = $(contactForm + " #contact_model_message");
        customErrorMessageElement = $(contactForm + " .custom-error-message");
        customSuccessMessageElement = $(contactForm + " .custom-success-message");

        /* Reset Contact Form */
        function resetContactForm() {
            $(contactForm).parsley().reset();
            customErrorMessageElement.hide();
            customSuccessMessageElement.hide();
            contactModelUserIdElement.val("");
            contactModelMessageElement.val("");
        }

        /* Open Contact Model */
        function openContactModal(modelSelector, userId) {
            resetContactForm();
            contactModelUserIdElement.val(userId);
            openModal(modelSelector);
        }

        /* Send Message Ajax Call */
        jQuery(contactForm).submit(function (event) {
            if (jQuery(contactForm).parsley().validate()) {

                event.preventDefault();
                showLoader();

                /* Send Mail */
                jQuery.ajax({
                    url: window.sendContactMailUrl,
                    method: 'post',
                    dataType: 'JSON',
                    data: {
                        '_token': window._token,
                        'user_id': contactModelUserIdElement.val(),
                        'message': contactModelMessageElement.val(),
                    },
                    success: function (response) {
                        if (response.success == true) {
                            resetContactForm();
                            customSuccessMessageElement.html(response.message);
                            customSuccessMessageElement.show();
                            hideLoader();
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
        /* Contact form end */
    </script>
@endsection
