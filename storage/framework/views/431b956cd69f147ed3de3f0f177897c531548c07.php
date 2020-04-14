<?php $request = app('Illuminate\Http\Request'); ?>
<header class="btb-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="<?php echo e(url('/')); ?>" class="navbar-brand">
                <img src="<?php echo e(url('images/logo.png')); ?>" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#btbMainMenu"
                    aria-controls="btbMainMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="color: #fff;"></span>
            </button>
            <div class="dropdown account-dropdown div_newdropdownmenu">
                <button class="account-btn dropdown-toggle" type="button" id="account-btn" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                    <?php if( !empty(Auth::guard('admin')->user()->photo) && Common::isFileExists(Auth::guard('admin')->user()->photo) ): ?>
                        <img src="<?php echo e(url(Auth::guard('admin')->user()->photo)); ?>" alt="">
                    <?php else: ?>
                        <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                    <?php endif; ?>

                    <i class="fas fa-bars"></i></button>
                <div class="dropdown-menu" aria-labelledby="account-btn">
                    <a class="dropdown-item" href="<?php echo e(url('admin/home')); ?>">Dash Home</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/businesses')); ?>">Businesses</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/email-templates')); ?>">Email Templates</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/transactions')); ?>">Transactions</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/backend-logs')); ?>">Backend Logs</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/settings')); ?>">Settings</a>
                    <a class="dropdown-item" href="<?php echo e(url('admin/profile')); ?>">Profile</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="$('#logout').submit();">Logout</a>
                </div>
            </div>

            <div id="btbMainMenu" class="collapse navbar-collapse">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="<?php echo e(url('/')); ?>" aria-current="page" class="nav-link">Home</a></li>
                    <li class="nav-item"><a
                            href="<?php echo e(url('/')); ?>" class="nav-link">About us</a></li>
                    <li class="nav-item"><a
                            href="<?php echo e(url('/')); ?>#download_app" class="nav-link">Download the App</a></li>
                    <li class="nav-item"><a
                            href="<?php echo e(url('/')); ?>" class="nav-link">Contact us</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>