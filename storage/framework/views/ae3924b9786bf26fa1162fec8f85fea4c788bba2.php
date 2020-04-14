
<?php $__env->startSection('title', 'Admin login | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <div class="container-fluid n_success">
            <div class="btb-login-wrap">
                <div class="btb-login">
                    <h1 class="text-center mb-4">Admin login</h1>
                    <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo Form::open(['method' => 'POST','name'=>'admin-login-form', 'id' =>'admin_login_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin_login']]); ?>


                    <?php echo Form::email('email', old('email'), ['class' => 'form-control mb-4', 'placeholder' => 'Email', 'required' => '']); ?>

                    <?php echo $__env->make('partials.message.field',['field_name' => 'email'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="password-box">
                        <?php echo Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4 icon', 'placeholder' => 'Password', 'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '6', 'required' => '']); ?>

                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <?php echo $__env->make('partials.message.field',['field_name' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <div class="form-edit-profilebtn saveh1">
                        <?php echo Form::Submit(trans('admin.qa_login'), ['class' => 'btn btn_green mt-4']); ?>

                    </div>

                    <?php echo Form::close(); ?>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>