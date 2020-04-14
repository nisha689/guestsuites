<?php $__env->startSection('title', 'Profile | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
    	<?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container n_success">
            <div class="page-wrap bx-shadow my-5 px-sm-5">
                <div class="row user-dt-wrap">

					<div class="col-lg-12 col-md-12 pb-5">
						<h1 class="big-heading mb-5">Admin (<?php echo e($admin->name); ?>)</h1>
						<div class="row">
                    <div class="col-md-6 col-lg-6 pb-5 px-md-5 profile_border">
                        <h3 class="text-center mb-4 admin_inner_title">Contact details</h3>

                        <div class="row after_bottom_border">
                            <div class="col-lg-9 user-dt">

                                <p><span><?php echo e($admin->name); ?></span><a
                                            href="mailto:<?php echo e($admin->email); ?>"><?php echo e($admin->email); ?></a></p>

                                <?php if(!empty($admin->created_at) && $admin->created_at != '0000-00-00 00:00:00'): ?>
                                    <p class="mb-5">
                                        <span>Signed up on:</span><?php echo e(DateFacades::dateFormat($admin->created_at,'format-3')); ?>

                                        <br> <?php echo e(DateFacades::dateFormat($admin->created_at,'time-format-1')); ?><br/> </p>
                                <?php endif; ?>

                                <p class="mb-5">
                                    <span> Account:</span> #<?php echo e($admin->user_id); ?> <br>
                                </p>
                                <p class="mb-5">
                                    <span> Usertype:</span> Admin <br>
                                </p>
                            </div>
                            <div class="col-lg-3 user-dt-img">
                                <?php if( !empty($admin->photo) && Common::isFileExists($admin->photo) ): ?>
                                    <img src="<?php echo e(url($admin->photo)); ?>" alt="">
                                <?php else: ?>
                                    <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 pb-5 px-md-5 label_blue pb0">
                        <h3 class="text-center mb-5 admin_inner_title">Change password</h3>
						<div class="row after_bottom_border">
							<div class="col-lg-12 col-md-12">
								<?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-change-password-form', 'id' =>'admin_change_password_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin.change_password']]); ?>


								<?php echo e(csrf_field()); ?>


								<?php echo Form::hidden('user_id', $admin->user_id, array('id' => 'change_password_user_id')); ?>


								<?php echo Form::label('password', 'New password', ['class' => '']); ?>

								<div class="password-box">
									<?php echo Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4', 'placeholder' => 'Password', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']); ?>

									<?php echo $__env->make('partials.message.field',['field_name' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<span toggle="#password"
										  class="fa fa-fw fa-eye field-icon toggle-password"></span>
								</div>

								<?php echo Form::label('Confirm Password', 'Confirm Password', ['class' => '']); ?>

								<div class="password-box">
									<?php echo Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control mb-4', 'placeholder' => 'Confirm Password', 'data-parsley-equalto' => '#password', 'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '6', 'required' => '']); ?>

									<?php echo $__env->make('partials.message.field',['field_name' => 'password_confirmation'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<span toggle="#password_confirmation"
										  class="fa fa-fw fa-eye field-icon toggle-password"></span>
								</div>

								<?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-1']); ?>


								<?php echo Form::close(); ?>

							</div>
						</div>
                    </div>

                    <div class="col-lg-12 pb-5 px-md-5 mt-5 label_blue">
                        <div class="col-lg-6 proborder"></div>
                        <div class="col-lg-6 col-md-6 proborder_right"></div>
                        <h3 class="text-center mb-5 edittitle admin_inner_title">Edit profile</h3>

                        <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-edit-profile-form', 'id' =>'admin_edit_profile_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin.profile']]); ?>


                        <?php echo e(csrf_field()); ?>


                        <?php echo Form::hidden('user_id', $admin->user_id, array('id' => 'edit_profile_user_id')); ?>

                        <div class="form-edit-profile">
                            <?php echo Form::label('first_name', 'First name', ['class' => '']); ?>

                            <?php echo Form::text('first_name', $admin->first_name, ['class' => 'form-control mb-4', 'required' => '']); ?>


                            <?php echo $__env->make('partials.message.field',['field_name' => 'first_name'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="form-edit-profile">
                            <?php echo Form::label('last_name', 'Last name', ['class' => '']); ?>

                            <?php echo Form::text('last_name', $admin->last_name, ['class' => 'form-control mb-4', 'required' => '']); ?>

                            <?php echo $__env->make('partials.message.field',['field_name' => 'last_name'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                        <div class="form-edit-profile">
                            <?php echo Form::label('email', 'Email', ['class' => '']); ?>

                            <?php echo Form::email('email', $admin->email, ['class' => 'form-control mb-4', 'required' => '']); ?>

                            <?php echo $__env->make('partials.message.field',['field_name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>


                        <div class="form-edit-profile">
                            <label>Photo</label>
                            <div id="photo-upload">
                                <?php if( !empty($admin->photo) && Common::isFileExists($admin->photo) ): ?>
                                    <img src="<?php echo e(url($admin->photo)); ?>" alt="">
                                <?php else: ?>
                                    <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                <?php endif; ?>
								<div class="upload-btn-wrapper">
									<input type="file" style="display:none;" data-name="user-profile-file" name="photo"
										   id="profile_photo">
									<button type="button" class="btn btn-orange" id="select_photo">Select Photo
									</button>
								</div>
                                <span class="user-profile-file" style="padding-left:10px;"></span>
                            </div>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>