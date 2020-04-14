<?php $__env->startSection('title', 'Email Template | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
    	<?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container n_success">
            <div class="page-wrap bx-shadow my-5 px-sm-5">
                <div class="row user-dt-wrap">
					
					<div class="col-lg-12 col-md-12 pb-5">
						<h1 class="big-heading mb-5"><?php echo e($emailtemplate->template_name); ?></h1>
						<div class="row">

						<div class="col-lg-12 pb-5 px-md-5 mt-5">                        
							<div class="col-lg-8 col-md-8">

								<?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-email-template-form', 'id' =>'admin_email_template_form', 'data-parsley-validate','route' => ['admin.emailtemplate.save']]); ?>


								<?php echo e(csrf_field()); ?>


								<?php echo Form::hidden('email_template_id', $emailtemplate->email_template_id, array('id' => 'edit_profile_user_id')); ?>

								<?php echo Form::hidden('entity', $emailtemplate->entity, array('id' => 'entity')); ?>

								<div class="form-edit-fields">
									<?php echo Form::label('subject', 'Subject', ['class' => '']); ?>

									<?php echo Form::text('subject', $emailtemplate->subject, ['class' => 'form-control mb-4', 'required' => '']); ?>

									<?php echo $__env->make('partials.message.field',['field_name' => 'subject'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
								</div>

								<div class="form-edit-fields">
									<?php echo Form::label('Message', 'Message', ['class' => '']); ?>

									<?php 
										$template_fields = !empty( $emailtemplate->template_fields ) ? explode(",", $emailtemplate->template_fields ) : ''
									?>	
									<?php if( count( $template_fields ) > 0 ): ?>
										<div class="form-edit-fields">
											<?php $__currentLoopData = $template_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template_fieldKey=>$template_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<span class="badge-pill badge badge-info display-1"> %<?php echo e($template_field); ?>% </span>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</div>
									<?php endif; ?>
									<?php echo Form::textarea('template_content', $emailtemplate->template_content, ['class' => 'form-control mb-4 mt-4', 'required' => '']); ?>

									<?php echo $__env->make('partials.message.field',['field_name' => 'subject'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
								</div>	
								<div class="form-edit-profilebtn saveh2"><?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green save_btn_green mt-5']); ?></div>

								<?php echo Form::close(); ?>

						</div>
                    </div>
                </div>

            </div>
            </div>
            </div>
        </div>
    </div>        
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>