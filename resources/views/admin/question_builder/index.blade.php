@extends('admin.layouts.app')
@section('title', 'Question Builder | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
        @include('partials.message.success')
        @include('partials.message.error')
        @include('partials.message.validation_error')
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Question Builder</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
	@include('admin.service.edit_model')
@endsection
@section('javascript')
    <script>
    </script>
@endsection
