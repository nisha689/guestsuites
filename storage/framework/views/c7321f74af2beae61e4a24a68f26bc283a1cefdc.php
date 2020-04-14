<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<?php echo $__env->make('admin.auth.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body>
<?php echo $__env->make('errors.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<main>
    <div class="main_section">
        <div class="container">
            <div class="msg_section">
                <h1> <?php echo $__env->yieldContent('code', __('Oh no')); ?></h1>
                <div class="msgborder"></div>
                <p>
                    <?php echo $__env->yieldContent('message'); ?>
                </p>
                <a href="<?php echo e(app('router')->has('home') ? route('home') : url('/')); ?>">
                    <button class="">
                        <?php echo e(__('Go Home')); ?>

                    </button>
                </a>
            </div>
        </div>
    </div>
</main>
<?php echo $__env->make('admin.auth.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('admin.auth.partials.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>
