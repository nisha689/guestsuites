<script type="text/javascript" src="<?php echo e(url('common/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/datepicker.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/jquery.datetimepicker.full.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('common/js/jquery-ui.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(url('admin/js/script.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(url('common/js/jquery.multiselect.js')); ?>"></script>

<!--Validation Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/parsley.min.js')); ?>"></script>

<!--Mask Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/jquery.mask.js')); ?>"></script>

<!-- Tinymce -->
<script type="text/javascript" src="<?php echo e(url('tinymce/js/tinymce/tinymce.js')); ?>"></script>

<!-- Time Pikcer -->
<script type="text/javascript" src="<?php echo e(url('common/js/timepicki.js')); ?>"></script>

<script>
    window.baseURI = "<?php echo e(url('/')); ?>";
    window._token = "<?php echo e(csrf_token()); ?>";
    window.getStateDropDownUrl = "<?php echo e(url('/getstatedropdown')); ?>";
    window.getCityDropDownUrl = "<?php echo e(url('/getcitydropdown')); ?>";
    
	$(document).ready(function () {
        $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 4048,
        });
    });
</script>

<!--Common Js-->
<script type="text/javascript" src="<?php echo e(url('common/js/common.js')); ?>"></script>

<?php echo $__env->yieldContent('javascript'); ?>