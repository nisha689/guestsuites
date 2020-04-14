<?php if(session('error')): ?>
<div class="notification error successmsg">
  <span>Error : <?php echo e(session('error')); ?></span>
  <button class="close-ntf"><i class="fas fa-times"></i></button>
</div>
<?php endif; ?>