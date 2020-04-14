<?php $__env->startSection('title', 'Transactions | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Transactions (<?php echo e($totalRecordCount); ?>)</h1>
                        <div class="clear-both"></div>

                        <?php echo Form::open(['method' => 'GET','name'=>'admin-transaction-search', 'id' =>'admin_transaction_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.transactions']]); ?>

                        <?php echo Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')); ?>

                        <?php echo Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')); ?>


                        <div class="col-md-3 col-lg-2">
                            <a href="<?php echo e(url('admin/transactions')); ?>">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-4 col-lg-3">
                            <?php echo Form::text('name', $name, ['class' => 'form-control mb-3', 'placeholder' => 'Names']); ?>

                        </div>

                        <div class="col-md-5 col-lg-3">
                            <?php echo Form::email('email', $email, ['class' => 'form-control mb-3', 'placeholder' => 'Email']); ?>

                        </div>

                        <div class="col-md-4 col-lg-2">
                            <?php echo Form::select('status', ['' => 'Status','1' => 'Success','0' => 'Fail'], $status, ['class' => 'form-control mb-3']); ?>

                        </div>

                        <div class="col-md-4 col-lg-2">
                            <?php echo Form::select('payment_method', ['' => 'Types','1' => 'Stripe','2' => 'Paypal'], $paymentMethod, ['class' => 'form-control mb-3']); ?>

                        </div>

                        <div class="col-md-4  col-lg-3">
                            <?php echo Form::text('start_date', $startDate, ['id' =>'start_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'From date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']); ?>

                        </div>

                        <div class="col-md-4  col-lg-3">
                            <?php echo Form::text('end_date', $endDate, ['id' =>'end_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'To date','autocomplete' => 'Off', 'data-toggle'=>'datepicker']); ?>

                        </div>
									
                        <div class="col-md-3 col-lg-2 offset-lg-4 offset-md-3">
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

                                    <th class="updownicon transactions_index_width"
                                        onclick="sortWithSearch('id');">Order#
                                        <?php echo $sortedBy =='id' ? $sorting : $sortDefault; ?></th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('created_at');">Order date
                                        <?php echo $sortedBy =='created_at' ? $sorting : $sortDefault; ?></th>
                                    <th>Payee</th>
                                    <th>Amount</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($transactions) && count($transactions) > 0): ?>
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transactionKey => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="dtransaction-id data-id"><span><?php echo e(++$recordStart); ?></span></td>
                                            <td>
                                                <b><?php echo e(DateFacades::dateFormat($transaction->created_at,'format-3')); ?></b>
                                                <?php echo e(DateFacades::dateFormat($transaction->created_at,'time-format-1')); ?>

                                            </td>
                                            <td>
                                                <b><?php echo e($transaction->user->name); ?></b>
                                                <a href="mailto:<?php echo e($transaction->user->email); ?>"
                                                   class="mail emailcolor"><?php echo e($transaction->user->email); ?></a>
                                            </td>
                                            <td>$<?php echo e($transaction->amount); ?></td>
                                            <td><div class="business_width_index"><?php echo e($transaction->plan->plan_name); ?></div></td>
                                            <td class="<?php echo e($transaction->status ==1 ? 'green' : 'inactive'); ?>">
                                                <b><?php echo e($transaction->status_string); ?></b></td>
                                            
                                            <td class="action_div">
                                                <div class="action-warp">
                                                    <div class="left-action">
                                                        <a href="<?php echo e(url('admin/transaction/')); ?>/<?php echo e(Common::getEncryptId($transaction->id)); ?>" class="viewbtn singlebtn">view</a>
                                                    </div>
                                                </div>
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
        var form = 'form#admin_transaction_search_form';
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>