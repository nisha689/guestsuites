<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">

<?php echo $__env->make('admin.partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>

<div class="loader" id="loader"></div>

<?php echo $__env->make('admin.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('admin.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo Form::open(['route' => 'admin_logout', 'style' => 'display:none;', 'id' => 'logout']); ?>


<button type="submit">Logout</button>
<?php echo Form::close(); ?>


<?php echo $__env->make('admin.partials.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>

</html>

