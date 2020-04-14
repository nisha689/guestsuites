<script type="text/javascript" src="<?php echo e(url('common/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('admin/js/script.js')); ?>"></script>

<!--Validation Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/parsley.min.js')); ?>"></script>

<!--Mask Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/jquery.mask.js')); ?>"></script>

<script>
    window.baseURI = "<?php echo e(url('/')); ?>";
    window._token = "<?php echo e(csrf_token()); ?>";
</script>

<!--Common Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/common.js')); ?>"></script>

<?php echo $__env->yieldContent('javascript'); ?>