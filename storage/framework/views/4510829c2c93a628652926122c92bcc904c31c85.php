<?php $helper = app('App\Classes\Helpers\Helper'); ?>
<div class="footer">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-12">
                <img src="<?php echo e(url('images/footer_logo.png')); ?>" class="img-fluid" alt="">
            </div>
            <div class="col-lg-7 col-md-12 d-flex align-items-center">
                <div class="footer_menu">
                    <ul>
                        <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li><a href="<?php echo e(url('/')); ?>">About us</a></li>
                        <li><a href="<?php echo e(url('/')); ?>">Terms and Conditions</a></li>
                        <li><a href="<?php echo e(url('/')); ?>">Privacy policy</a></li>
                        <li><a href="<?php echo e(url('/')); ?>">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-12 d-flex align-items-center">
                <div class="social_icon">
                    <a href="<?php echo e($helper->getFacebookUrl()); ?>" class="fb" target="_blank"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo e($helper->getTwitterUrl()); ?>" class="twitter" target="_blank"><i
                            class="fab fa-twitter"></i></a>
                    <a href="<?php echo e($helper->getLinkedinUrl()); ?>" class="linkedin" target="_blank"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="copyright">
        <small><?php echo $helper->getCopyRight(); ?></small>
    </div>
</div>
