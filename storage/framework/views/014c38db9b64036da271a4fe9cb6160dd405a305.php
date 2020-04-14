<?php $__env->startSection('title', 'Transaction details | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5">Transaction (#<?php echo e($transaction->id); ?>)</h1>
                        <div class="row mt-5">
                            <div class="col-lg-6 brd-lg-right pb-5 tra_title">
                                <h2 class="red text-left mb-4">Payee</h2>
                                <div class="payee-details">
                                    <?php if( !empty($payForUser->photo) &&  Common::isFileExists($payForUser->photo) ): ?>
                                        <img src="<?php echo e(url($payForUser->photo)); ?>" alt="">
                                    <?php else: ?>
                                        <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                    <?php endif; ?>
                                    <div>
                                        <h3><?php echo e($payForUser->name); ?></h3>
                                        <p>
                                            <a href="mailto:<?php echo e($payForUser->email); ?>"><?php echo e($payForUser->email); ?></a>
                                            <br>
                                            <?php echo e(Common::getPhoneFormat($payForUser->phone)); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 pl-sm-4 pb-5 tra_title">
                                <h2 class="red text-center mb-4">Payment details</h2>
                                <div class="payment-details">
                                    <label>Amount:</label>
                                    <p>$<?php echo e(Common::setPriceFormat($transaction->amount)); ?></p>
                                    <label>Product:</label>
                                    <p><?php echo e($transaction->plan->plan_name); ?> plan</p>
                                    <label>Paid on:</label>
                                    <p><?php echo e(DateFacades::dateFormat($transaction->created_at,'format-3')); ?> <br/>
                                        <?php echo e(DateFacades::dateFormat($transaction->created_at,'time-format-1')); ?></p>
                                    <label>Method:</label>
                                    <p><?php echo e($transaction->payment_method_string); ?></p>
                                    <?php if( $transaction->payment_method == 1 ): ?>
                                        <label>Stripe Transaction ID:</label>
                                    <?php else: ?>
                                        <label>Paypal Transaction ID:</label>
                                    <?php endif; ?>
                                    <p><?php echo e($transaction->transaction_id); ?></p>
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