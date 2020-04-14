@extends('admin.layouts.app')
@section('title', 'Email Template | '.trans('admin.front_title'))
@section('content')
    <div class="main_section">
    	@include('partials.message.success')
		@include('partials.message.error')
		@include('partials.message.validation_error')
        <div class="container n_success">
            <div class="page-wrap bx-shadow my-5 px-sm-5">
                <div class="row user-dt-wrap">
					
					<div class="col-lg-12 col-md-12 pb-5">
						<h1 class="big-heading mb-5">{{ $emailtemplate->template_name }}</h1>
						<div class="row">

						<div class="col-lg-12 pb-5 px-md-5 mt-5">                        
							<div class="col-lg-8 col-md-8">

								{!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-email-template-form', 'id' =>'admin_email_template_form', 'data-parsley-validate','route' => ['admin.emailtemplate.save']]) !!}

								{{ csrf_field() }}

								{!! Form::hidden('email_template_id', $emailtemplate->email_template_id, array('id' => 'edit_profile_user_id')) !!}
								{!! Form::hidden('entity', $emailtemplate->entity, array('id' => 'entity')) !!}
								<div class="form-edit-fields">
									{!! Form::label('subject', 'Subject', ['class' => '']) !!}
									{!! Form::text('subject', $emailtemplate->subject, ['class' => 'form-control mb-4', 'required' => '']) !!}
									@include('partials.message.field',['field_name' => 'subject'])
								</div>

								<div class="form-edit-fields">
									{!! Form::label('Message', 'Message', ['class' => '']) !!}
									@php 
										$template_fields = !empty( $emailtemplate->template_fields ) ? explode(",", $emailtemplate->template_fields ) : ''
									@endphp	
									@if( count( $template_fields ) > 0 )
										<div class="form-edit-fields">
											@foreach( $template_fields as $template_fieldKey=>$template_field )
												<span class="badge-pill badge badge-info display-1"> %{{ $template_field }}% </span>
											@endforeach
										</div>
									@endif
									{!! Form::textarea('template_content', $emailtemplate->template_content, ['class' => 'form-control mb-4 mt-4', 'required' => '']) !!}
									@include('partials.message.field',['field_name' => 'subject'])
								</div>	
								<div class="form-edit-profilebtn saveh2">{!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green save_btn_green mt-5']) !!}</div>

								{!! Form::close() !!}
						</div>
                    </div>
                </div>

            </div>
            </div>
            </div>
        </div>
    </div>        
    
@endsection