<?php $__env->startSection('title', __('Method Not Allowed')); ?>
<?php $__env->startSection('code', '405'); ?>
<?php $__env->startSection('message', __('Sorry, Method not allowed.')); ?>
<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>