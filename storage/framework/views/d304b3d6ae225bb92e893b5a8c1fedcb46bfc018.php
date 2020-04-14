<?php $__env->startSection('title', 'Settings | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <main>
        <div class="main_section">
            <div class="container">
                <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="page-wrap bx-shadow my-5 px-sm-5">

                    <h1 class="big-heading mb-5">Settings</h1>

                    <div class="row user-dt-wrap">

                        <div class="col-lg-12 pb-5 px-md-5">

                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link <?php echo e($currentTab =='general' ? 'active' : ''); ?>"
                                                        href="#general" data-toggle="tab">General</a></li>
                                <li class="nav-item"><a class="nav-link <?php echo e($currentTab =='mailjet' ? 'active' : ''); ?>"
                                                        href="#mailjet" data-toggle="tab">Mailjet</a></li>
                                <li class="nav-item"><a class="nav-link <?php echo e($currentTab =='social' ? 'active' : ''); ?>"
                                                        href="#social" data-toggle="tab">Social</a></li>
                               
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane mt-4 <?php echo e($currentTab=='general' ? 'active' : ''); ?>" id="general">
                                    <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]); ?>


                                    <?php echo e(csrf_field()); ?>

                                    <?php if(count($configurationList)>0): ?>
                                        <?php $__currentLoopData = $configurationList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $value['group_type'] == 1 ): ?>
                                                <div class="form-edit-profile">
                                                    <?php echo Form::label($key,$value['label'], ['class' => '']); ?>

                                                    <?php echo Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']); ?>

                                                    <?php echo $__env->make('partials.message.field',['field_name' => $value['key']], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php echo Form::hidden( 'currenttab', 'general' ); ?>

                                    <div class="form-edit-profilebtn saveh1">
                                        <?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']); ?>

                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>

                                <div class="tab-pane mt-4 <?php echo e($currentTab=='mailjet' ? 'active' : ''); ?>" id="mailjet">
                                    <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]); ?>


                                    <?php echo e(csrf_field()); ?>

                                    <?php if(count($configurationList)>0): ?>
                                        <?php $__currentLoopData = $configurationList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $value['group_type'] == 2 ): ?>
                                                <div class="form-edit-profile">
                                                    <?php echo Form::label($key,$value['label'], ['class' => '']); ?>

                                                    <?php echo Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']); ?>

                                                    <?php echo $__env->make('partials.message.field',['field_name' => $value['key']], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php echo Form::hidden( 'currenttab', 'mailjet' ); ?>

                                    <div class="form-edit-profilebtn saveh1">
                                        <?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']); ?>

                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>


                                <div class="tab-pane mt-4 <?php echo e($currentTab=='social' ? 'active' : ''); ?>" id="social">
                                    <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'customer-edit-profile-form', 'id' =>'customer_edit_profile_form', 'class'=>'login-form px-md-4','data-parsley-validate','route' => ['admin.setting.save']]); ?>


                                    <?php echo e(csrf_field()); ?>

                                    <?php if(count($configurationList)>0): ?>
                                        <?php $__currentLoopData = $configurationList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if( $value['group_type'] == 3 ): ?>
                                                <div class="form-edit-profile">
                                                    <?php echo Form::label($key,$value['label'], ['class' => '']); ?>

                                                    <?php echo Form::text($value['key'], $value['value'], ['class' => 'form-control mb-4', 'placeholder' => '']); ?>

                                                    <?php echo $__env->make('partials.message.field',['field_name' => $value['key']], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php echo Form::hidden( 'currenttab', 'social' ); ?>

                                    <div class="form-edit-profilebtn saveh1">
                                        <?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4']); ?>

                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>