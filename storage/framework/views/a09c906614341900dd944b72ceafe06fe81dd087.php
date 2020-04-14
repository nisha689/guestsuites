<?php if(session('success')): ?>
<div class="notification success successmsg">
  <span><?php echo e(session('success')); ?></span>
  <button class="close-ntf"><i class="fas fa-times"></i></button>
</div>
<?php endif; ?>