<?php $__env->startSection('title', 'Admin Home | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>

    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="<?php echo e(url('admin/schools')); ?>">
                            <div class="totals-box orange">
                                <span>TOTAL SCHOOLS</span>
                                <p>0
                                    <small>schools</small>
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="<?php echo e(url('admin/students')); ?>">
                            <div class="totals-box gray">
                                <span>TOTAL STUDENTS</span>
                                <p>0
                                    <small>students</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="<?php echo e(url('admin/teachers')); ?>">
                            <div class="totals-box blue">
                                <span>TOTAL TEACHERS</span>
                                <p>0
                                    <small>teachers</small>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="<?php echo e(url('admin/parents')); ?>">
                            <div class="totals-box yellow">
                                <span>TOTAL PARENTS</span>
                                <p>0
                                    <small>parents</small>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 pt-3">
                        <h2 class="pr-box-heading">Hi, <?php echo e($loginUser->first_name); ?> <?php echo e($loginUser->last_name); ?></h2>
                        <div id="profile-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if(!empty($loginUser->last_login_date) && $loginUser->last_login_date != '0000-00-00 00:00:00'): ?>
                                        <p id="last-login">Last login
                                            <span><?php echo e(DateFacades::dateFormat($loginUser->last_login_date,'format-3')); ?>

                                                <br/>
                                                <?php echo e(DateFacades::dateFormat($loginUser->last_login_date,'time-format-1')); ?>

                                            </span>
                                        </p>
                                    <?php endif; ?>

                                    <div id="box-profile-opt" class="mt-5">
                                        <h3>Your profile</h3>
                                        <?php if( !empty($loginUser->photo) && Common::isFileExists($loginUser->photo) ): ?>
                                            <img src="<?php echo e(url($loginUser->photo)); ?>" alt="">
                                        <?php else: ?>
                                            <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                        <?php endif; ?>
                                        <p class="u_width"><span><?php echo e($loginUser->name); ?></span>
                                            <br><?php echo e($loginUser->email); ?></p>
                                        <a href="<?php echo e(url('admin/profile')); ?>" class="btn viewbtn editbtn">Edit</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="box-date">
                                        <img src="<?php echo e(url('images/date-big.png')); ?>">
                                        <p id="time"><?php echo e(DateFacades::getCurrentDateTime('format-2')); ?></p>
                                        <p id="day" class="mt-3"><?php echo e(DateFacades::getCurrentDateTime('format-4')); ?> <span><?php echo e(DateFacades::getCurrentDateTime('format-3')); ?></span></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <h2 class="pr-box-heading">Recent schools</h2>
                        <div class="table-responsive recentcustomer">
                            <table class="table data-table customers-table">
                                <thead>
                                <tr>
                                    <th>SCHOOL</th>
                                    <th class="emailformat">EMAIL</th>
                                    <th class="dateformat">JOINED</th>
                                </tr>
                                </thead>
                                <?php if(!empty($recentSchools) && count($recentSchools) > 0): ?>
                                    <tbody>
                                    <?php $__currentLoopData = $recentSchools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentSchoolKey => $recentSchoolValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><div class="usernameformat"><?php echo e($recentSchoolValue->first_name); ?> <?php echo e($recentSchoolValue->last_name); ?></div></td>
                                            <td><div class="emailformat"><?php echo e($recentSchoolValue->small_email); ?></div></td>
                                            <td><?php echo e(DateFacades::dateFormat($recentSchoolValue->signup_date,'format-3')); ?> </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                <?php else: ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="3"><?php echo app('translator')->getFromJson('admin.qa_no_entries_in_table'); ?></td>
                                    </tr>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="<?php echo e(url('images/schoolicon1.png')); ?>" alt="">Schools</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total schools</p>
                                <h3><?php echo e($totalSchool); ?></h3>
                                <a href="<?php echo e(url('admin/schools')); ?>" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="<?php echo e(url('images/teachericon1.png')); ?>" alt="">Teachers</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total teachers</p>
                                <h3><?php echo e($totalTeacher); ?></h3>
                                <a href="<?php echo e(url('admin/teachers')); ?>" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 pt0 mt0 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="<?php echo e(url('images/parentsicon.png')); ?>" alt="">Parents</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total parents</p>
                                <h3><?php echo e($totalParent); ?></h3>
                                <a href="<?php echo e(url('admin/parents')); ?>" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="<?php echo e(url('images/studentsicon.png')); ?>" alt="">Students</h2>
                            <div class="dash-stats mt-5 mb-5 customerborder">
                                <p>Total students</p>
                                <h3><?php echo e($totalStudent); ?></h3>
                                <a href="<?php echo e(url('admin/students')); ?>" class="btn viewbtn">open</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-wrap mt-5 pt-4 px-md-4 clear-both">
                    <div class="col-md-6">
                        <div class="dash-col brd-after">
                            <h2><img src="<?php echo e(url('images/events.png')); ?>" alt="" style="width:40px;">Clubs</h2>
                            <div class="dash-stats mt-5 mb-5">
                                <p>Total clubs</p>
                                <h3><?php echo e($totalClub); ?></h3>
                                <a href="javascript:void(0);" class="btn viewbtn">open</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dash-col">
                            <h2><img src="<?php echo e(url('images/announce.png')); ?>" alt="" style="width: 55px;">Announcements
                            </h2>
                            <div class="dash-stats mt-5 mb-5">
                                <p>Total announcements</p>
                                <h3><?php echo e($totalEvent); ?></h3>
                                <a href="javascript:void(0);" class="btn viewbtn">open</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>