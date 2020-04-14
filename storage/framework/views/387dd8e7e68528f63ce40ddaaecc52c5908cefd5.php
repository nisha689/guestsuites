<?php $__env->startSection('title', 'Backend Logs | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Backend Logs(<?php echo e($totalRecordCount); ?>)</h1>
                        <div class="clear-both"></div>
                        <?php echo Form::open(['method' => 'GET','name'=>'admin-teacher-search', 'id' =>'admin_teacher_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.backend_logs']]); ?>

                        <?php echo Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')); ?>

                        <?php echo Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')); ?>

                        
                        <div class="col-md-3 col-lg-2">
                            <a href="<?php echo e(url('admin/backend-logs')); ?>">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-5 col-lg-3">
                            <?php echo Form::text('name', $name, ['class' => 'form-control mb-3', 'placeholder' => 'Names']); ?>

                        </div>

                        <div class="col-md-4 col-lg-4">
                            <?php echo Form::email('email', $email, ['class' => 'form-control mb-3', 'placeholder' => 'Email']); ?>

                        </div>

                        <div class="col-md-4 col-lg-3">
                            <?php echo Form::select('role_id', $roleDropDownList, $roleId, ['class' => 'form-control mb-3']); ?>

                        </div>

                        
                        <div class="col-md-3 col-lg-2 offset-lg-10">
                            <?php echo Form::Submit(trans('admin.qa_search'), ['class' => 'btn btn_green resetbtn']); ?>

                        </div>
                        <?php echo Form::close(); ?>


                        <div class="table-responsive mt-5">
                            <table class="table sorting data-table school" id="classes">
                                <thead>
                                <tr>
                                    <?php ($shortClass = ( strtolower($sortedOrder) == 'asc') ? 'up' : 'down' ); ?>
                                    <?php ($sortDefault = '<i class="fas fa-sort"></i>'); ?>
                                    <?php ($sorting = '<i class="fas fa-caret-'.$shortClass.'"></i>'); ?>

                                    <th class="updownicon"
                                        onclick="sortWithSearch('user_id');"><?php echo app('translator')->getFromJson('admin.user.fields.id'); ?>
                                        <?php echo $sortedBy =='user_id' ? $sorting : $sortDefault; ?></th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('first_name');">NAMES
                                        <?php echo $sortedBy =='first_name' ? $sorting : $sortDefault; ?></th>
                                    <th>LAST LOGIN</th>
                                    <th>IP ADDRESS</th>
                                    <th>USER TYPE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($users) && count($users) > 0): ?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessKey => $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="data-id"><span><?php echo e(++$recordStart); ?></span></td>
                                            <td>
                                                <b><?php echo e($business->name); ?></b>
                                                <a href="mailto:<?php echo e($business->email); ?>"
                                                   class="mail"><?php echo e($business->short_email); ?></a><br>
                                                <?php echo e(Common:: getPhoneFormat($business->phone)); ?>

                                            </td>
                                            <td>
                                                <b><?php echo e(DateFacades::dateFormat($business->last_login_date,'format-3')); ?></b>
                                                <?php echo e(DateFacades::dateFormat($business->last_login_date,'time-format-1')); ?>

                                            </td>
                                            <td>
                                                <b><?php echo e($business->ip_address); ?></b>
                                            </td>
                                            <td>
                                                <b><?php echo e($business->role->role_name); ?></b>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10"><?php echo app('translator')->getFromJson('admin.qa_no_entries_in_table'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php echo $paging; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script>
        var form = 'form#admin_teacher_search_form';
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>