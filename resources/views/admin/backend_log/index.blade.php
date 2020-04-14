@extends('admin.layouts.app')
@section('title', 'Backend Logs | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Backend Logs({{ $totalRecordCount }})</h1>
                        <div class="clear-both"></div>
                        {!! Form::open(['method' => 'GET','name'=>'admin-teacher-search', 'id' =>'admin_teacher_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.backend_logs']]) !!}
                        {!! Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')) !!}
                        {!! Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')) !!}
                        
                        <div class="col-md-3 col-lg-2">
                            <a href="{{ url('admin/backend-logs') }}">
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
                            {!! Form::select('role_id', $roleDropDownList, $roleId, ['class' => 'form-control mb-3']) !!}
                        </div>

                        
                        <div class="col-md-3 col-lg-2 offset-lg-10">
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
                                    <th>LAST LOGIN</th>
                                    <th>IP ADDRESS</th>
                                    <th>USER TYPE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($users) && count($users) > 0)
                                    @foreach($users as $businessKey => $business)
                                        <tr>
                                            <td class="data-id"><span>{{ ++$recordStart  }}</span></td>
                                            <td>
                                                <b>{{ $business->name }}</b>
                                                <a href="mailto:{{ $business->email  }}"
                                                   class="mail">{{ $business->short_email  }}</a><br>
                                                {{ Common:: getPhoneFormat($business->phone)  }}
                                            </td>
                                            <td>
                                                <b>{{ DateFacades::dateFormat($business->last_login_date,'format-3') }}</b>
                                                {{ DateFacades::dateFormat($business->last_login_date,'time-format-1') }}
                                            </td>
                                            <td>
                                                <b>{{ $business->ip_address }}</b>
                                            </td>
                                            <td>
                                                <b>{{ $business->role->role_name }}</b>
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
        var form = 'form#admin_teacher_search_form';
    </script>
@endsection