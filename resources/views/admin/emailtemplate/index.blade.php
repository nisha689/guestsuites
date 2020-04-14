@extends('admin.layouts.app')
@section('title', 'Email Templates | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Email templates ({{ $totalRecordCount }})</h1>
                        <div class="clear-both"></div>

                        {!! Form::open(['method' => 'GET','name'=>'admin-email-template-search', 'id' =>'admin_email_template_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.email_templates']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}

                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/email-templates') }}">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-3 col-lg-8">
                            {!! Form::text('template_name', $templateName, ['id' =>'template_name', 'class' => 'form-control mb-3', 'placeholder' => 'Template name']) !!}
                        </div>

                        <div class="col-md-3 col-lg-2">
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
                                        onclick="sortWithSearch('email_template_id');">ID
                                        {!!  $sortedBy =='email_template_id' ? $sorting : $sortDefault  !!}</th>
									<th class="updownicon"
                                        onclick="sortWithSearch('template_name');">Template Name
                                        {!!  $sortedBy =='template_name' ? $sorting : $sortDefault  !!}</th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('subject');">Subject
                                        {!!  $sortedBy =='subject' ? $sorting : $sortDefault  !!}</th>
                                    <th class="actionwidth">@lang('admin.user.fields.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($emailTemplates) && count($emailTemplates) > 0)
                                    @foreach($emailTemplates as $emailTemplateKey => $emailTemplate)
                                        <tr>
                                            <td class="data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td><b>{{ $emailTemplate->template_name  }}</b></td>
                                            <td><b>{{ $emailTemplate->subject  }}</b></td>
                                            <td>
                                                <a href="{{ url('admin/email-templates/details/')}}/{{ Common::getEncryptId($emailTemplate->email_template_id) }}"
                                                   class="viewbtn">view</a>
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
        var form = 'form#admin_email_template_search_form';
    </script>
@endsection
