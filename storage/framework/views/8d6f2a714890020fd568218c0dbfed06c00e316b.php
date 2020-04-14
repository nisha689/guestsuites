<?php $__env->startSection('title', 'Email Templates | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Email templates (<?php echo e($totalRecordCount); ?>)</h1>
                        <div class="clear-both"></div>

                        <?php echo Form::open(['method' => 'GET','name'=>'admin-email-template-search', 'id' =>'admin_email_template_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.email_templates']]); ?>

                        <?php echo Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')); ?>

                        <?php echo Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')); ?>


                        <div class="col-md-3 col-lg-2">
                            <a href="<?php echo e(url('admin/email-templates')); ?>">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-3 col-lg-8">
                            <?php echo Form::text('template_name', $templateName, ['id' =>'template_name', 'class' => 'form-control mb-3', 'placeholder' => 'Template name']); ?>

                        </div>

                        <div class="col-md-3 col-lg-2">
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
                                        onclick="sortWithSearch('email_template_id');">ID
                                        <?php echo $sortedBy =='email_template_id' ? $sorting : $sortDefault; ?></th>
									<th class="updownicon"
                                        onclick="sortWithSearch('template_name');">Template Name
                                        <?php echo $sortedBy =='template_name' ? $sorting : $sortDefault; ?></th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('subject');">Subject
                                        <?php echo $sortedBy =='subject' ? $sorting : $sortDefault; ?></th>
                                    <th class="actionwidth"><?php echo app('translator')->getFromJson('admin.user.fields.action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($emailTemplates) && count($emailTemplates) > 0): ?>
                                    <?php $__currentLoopData = $emailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emailTemplateKey => $emailTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="data-id"><span><?php echo e(++$recordStart); ?></span></td>
                                            <td><b><?php echo e($emailTemplate->template_name); ?></b></td>
                                            <td><b><?php echo e($emailTemplate->subject); ?></b></td>
                                            <td>
                                                <a href="<?php echo e(url('admin/email-templates/details/')); ?>/<?php echo e(Common::getEncryptId($emailTemplate->email_template_id)); ?>"
                                                   class="viewbtn">view</a>
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
        var form = 'form#admin_email_template_search_form';
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>