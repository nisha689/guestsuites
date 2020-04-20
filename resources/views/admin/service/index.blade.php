@extends('admin.layouts.app')
@section('title', 'Services | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Services ({{ $totalRecordCount }})</h1>
                        <a href="javascript:void(0);" class="btn light_blue float-right newbtn" onclick="openAddModal('#exam_model')">New service</a>
                        <div class="clear-both"></div>

                        {!! Form::open(['method' => 'GET','name'=>'admin-exam-search', 'id' =>'admin_exam_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.services']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}
                        
                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/services')}}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                       </div>

                        <div class="col-md-5 col-lg-5">
                            {!! Form::text('business_service_name', $businessServiceName, ['class' => 'form-control mb-3', 'placeholder' => 'Service name']) !!}
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
                                        onclick="sortWithSearch('business_service_id');">ID
                                        {!!  $sortedBy =='business_service_id' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('business_service_name');">service
                                        {!!  $sortedBy =='business_service_name' ? $sorting : $sortDefault  !!}</th>
                                    <th>ADDED</th>
                                    <th class="actionwidth">@lang('admin.user.fields.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($services) && count($services) > 0)
                                    @foreach($services as $serviceKey => $service)
                                        <tr>
                                            <td class="data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td><b>{{ $service->business_service_name  }}</b></td>
                                            <td>
                                                <b>{{ DateFacades::dateFormat($service->created_at,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($service->created_at,'time-format-1') }}
                                            </td>
                                            <td class="action_div">
                                            		<div class="action_club">
                                                <a href="javascript:void(0);"  onclick="openEditModal('#exam_model',{{ $service->business_service_id }})"
                                                   class="viewbtn">view</a>
                                                {!! Form::open(array(
                                                        'method' => 'DELETE',
                                                         'onsubmit' => "return confirm('".trans("admin.qa_are_you_sure_delete")." service?');",
                                                        'route' => ['admin.service.delete'])) !!}
                                                {!! Form::hidden('id',$service->business_service_id ) !!}

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
	@include('admin.service.edit_model')
@endsection
@section('javascript')
    <script>
        var form = 'form#admin_exam_search_form';
		var formAddEditForm = 'form#add_edit_exam_model_form';
        window.baseURI = "{{ url('/') }}";
        window.addEditUrl = "{{ URL::to('admin/service/ajax_save') }}";
        window.getDataForEditUrl = "{{ URL::to('admin/service/get_data') }}";

        pageTitle = "service";
        addEditModelIdElement = $(formAddEditForm + " #add_edit_model_id");
        businessServiceNameElement = $(formAddEditForm + " #business_service_name");
        customErrorMessageElement = $(formAddEditForm + " .custom-error-message");
        customSuccessMessageElement = $(formAddEditForm + " .custom-success-message");
        businessServiceIcon = $(formAddEditForm + " .user-profile-file");
        modelTitleElement = $(".modal-title");

        /* Reset Form */
        function ResetForm() {
            $(formAddEditForm).parsley().reset();
            customErrorMessageElement.hide();
            customSuccessMessageElement.hide();
            addEditModelIdElement.val(0);
            businessServiceNameElement.val("");
            businessServiceIcon.html('');
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
				var formData = new FormData($(this)[0]);
                jQuery.ajax({
					url: window.addEditUrl,
                    enctype: 'multipart/form-data',
                    method: 'post',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,					
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

            addEditModelIdElement.val(data.business_service_id);
            businessServiceNameElement.val(data.business_service_name);
			if( data.business_service_icon ){
				businessServiceIcon.html('<img src="'+window.baseURI+'/'+data.business_service_icon+'">');
			}
        }

        function openEditModal(modelSelector, id) {
            showLoader();
            jQuery.ajax({
                url: window.getDataForEditUrl,
                method: 'post',
                dataType: 'JSON',
                data: {
                    '_token': window._token,
                    'business_service_id': id,
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
