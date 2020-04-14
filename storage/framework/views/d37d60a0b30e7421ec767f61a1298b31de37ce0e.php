<?php $__env->startSection('title', 'Business Profile | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="container n_success">
            <div class="page-wrap bx-shadow my-5 px-sm-5 ">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5 school_details">
                        <h1 class="big-heading mb-5">Business (<?php echo e($business->company_name); ?>)</h1>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 pb-5 px-md-5 profile_border">
                                <h3 class="text-center mb-4 admin_inner_title">Contact details</h3>

                                <div class="row after_bottom_border">
                                    <div class="col-lg-9 user-dt">

                                        <p><span><?php echo e($business->name); ?></span><a
                                                    href="mailto:<?php echo e($business->email); ?>"><?php echo e($business->medium_email); ?></a></p>

                                        <?php if(!empty($business->created_at) && $business->created_at != '0000-00-00 00:00:00'): ?>
                                            <p class="mb-5">
                                                <span>Signed up on:</span><?php echo e(DateFacades::dateFormat($business->created_at,'format-3')); ?>

                                                <br> <?php echo e(DateFacades::dateFormat($business->created_at,'time-format-1')); ?>

                                                <br/></p>
                                        <?php endif; ?>

                                        <p class="mb-5">
                                            <span> Account:</span> #<?php echo e($business->user_id); ?>

                                        </p>
                                        <p class="mb-5">
                                            <span> Usertype:</span> Business
                                        </p>
                                    </div>
                                    <div class="col-lg-3 user-dt-img">
                                        <?php if( !empty($business->photo) && Common::isFileExists($business->photo) ): ?>
                                            <img src="<?php echo e(url($business->photo)); ?>" alt="">
                                        <?php else: ?>
                                            <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="user-actions-opt">
                                    <?php echo Form::open(array(
                            'method' => 'POST',
                            'onsubmit' => "return confirm('".($business->status == 1 ? trans("admin.qa_are_you_sure_ban_user") : trans("admin.qa_are_you_sure_reactive_user"))."');",
                            'route' => ['admin.business.ban_reactive'])); ?>

                                    <?php echo Form::hidden('user_id', Common::getEncryptId($business->user_id), array('id' => 'ban_user_id')); ?>

                                    <?php echo Form::hidden('status', ($business->status == 1 ? 0 : 1 ), array('id' => 'status')); ?>

                                    <?php echo Form::submit( ($business->status == 1 ? trans('admin.qa_ban_user'): trans('admin.qa_reactive_user') ), array('class'=>($business->status == 1 ? 'ban_account' : 'reactive-user-btn' ))); ?>

                                    <?php echo Form::close(); ?>



                                    <?php echo Form::open(array('method' => 'DELETE',
                                                        'onclick' => "return teacherDelete()",
                                                        'route' => ['admin.business.delete'], 'id'=>'removeteacher')); ?>

                                    <?php echo Form::hidden('id', $business->user_id, array('id' => 'delete_user_id')); ?>

                                    <?php echo Form::hidden('is_listing_page', 1, array('id' => 'is_listing_page')); ?>

                                    <?php echo Form::submit( trans('admin.qa_delete_user'), array('id'=>'del-user','class' => 'ban_account delete_account' )); ?>

                                    <?php echo Form::close(); ?>


                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 pb-5 px-md-5 label_blue pb0">
                                <h3 class="text-center mb-5 admin_inner_title">Change password</h3>
                                <div class="row after_bottom_border">
                                    <div class="col-lg-12 col-md-12">
                                        <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-change-password-form', 'id' =>'admin_change_password_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin.business.change_password']]); ?>


                                        <?php echo e(csrf_field()); ?>


                                        <?php echo Form::hidden('user_id', $business->user_id, array('id' => 'change_password_user_id')); ?>


                                        <?php echo Form::label('password', 'New password', ['class' => '']); ?>

                                        <div class="password-box">
                                            <?php echo Form::password('password', ['id' => 'password', 'class' => 'form-control mb-4', 'placeholder' => 'Password', 'data-parsley-minlength' => '6', 'data-parsley-trigger'=>'keyup', 'required' => '']); ?>

                                            <?php echo $__env->make('partials.message.field',['field_name' => 'password'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <span toggle="#password"
                                                  class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <?php echo Form::label('Confirm Password', 'Confirm Password', ['class' => '']); ?>

                                        <div class="password-box">
                                            <?php echo Form::password('password_confirmation', ['id' => 'password_confirmation', 'class' => 'form-control mb-4', 'placeholder' => 'Confirm Password', 'data-parsley-equalto' => '#password', 'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '6', 'required' => '']); ?>

                                            <?php echo $__env->make('partials.message.field',['field_name' => 'password_confirmation'], \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <span toggle="#password_confirmation"
                                                  class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>

                                        <?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-1']); ?>


                                        <?php echo Form::close(); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 pb-0 px-md-5 mt-5 label_blue">
                                <div class="col-lg-6 proborder"></div>
                                <div class="col-lg-6 col-md-6 proborder_right"></div>
                                <h3 class="text-center mb-5 edittitle admin_inner_title">Edit profile</h3>

                                <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'admin-edit-profile-form', 'id' =>'admin_edit_profile_form', 'class'=>'login-form','data-parsley-validate','route' => ['admin.business.profile.save']]); ?>


                                <?php echo e(csrf_field()); ?>


                                <?php echo Form::hidden('user_id', $business->user_id, array('id' => 'edit_profile_user_id')); ?>

                                <?php echo Form::hidden('school_id', $business->school_id, array('id' => 'school_id')); ?>


                                <div class="form-edit-profile">
                                    <?php echo Form::label('first_name', 'First name', ['class' => '']); ?>

                                    <?php echo Form::text('first_name', $business->first_name, ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>
                                <div class="form-edit-profile">
                                    <?php echo Form::label('last_name', 'Last name', ['class' => '']); ?>

                                    <?php echo Form::text('last_name', $business->last_name, ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>
                                <div class="form-edit-profile">
                                    <?php echo Form::label('company_name', 'Company name', ['class' => '']); ?>

                                    <?php echo Form::text('company_name', $business->company_name, ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>
								<div class="form-edit-profile">
                                    <?php echo Form::label('email', 'Email', ['class' => '']); ?>

                                    <?php echo Form::email('email', $business->email, ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>
								<div class="form-edit-profile">
                                    <?php echo Form::label('phone', 'Phone number', ['class' => '']); ?>

                                    <?php echo Form::text('phone', $business->phone, ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>

                                <div class="form-edit-profile">
                                    <?php echo Form::label('address', 'Business address', ['class' => '']); ?>

                                    <?php echo Form::text('address', $business->address , ['class' => 'form-control mb-4', 'required' => '']); ?>

                                </div>

                              <div class="form-edit-profile">
                                  <?php echo Form::label('country_id', 'Country', ['class' => '']); ?>

                                  <?php echo Form::select('country_id', $countryDropDown, $business->country_id, ['onchange' => "getStateDropDown(this,'#state_id')",'class' => 'form-control mb-4', 'required' => '']); ?>

                              </div>

                              <div class="form-edit-profile">
                                  <?php echo Form::label('state_id', 'State', ['class' => '']); ?>

                                  <?php echo Form::select('state_id', $stateDropDown, $business->state_id, ['onchange' => "getCityDropDown(this,'#city_id')",'class' => 'form-control mb-4', 'required' => '']); ?>

                              </div>

                            <div class="form-edit-profile">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php echo Form::label('city_id ', 'City/Town', ['class' => '']); ?>

                                        <?php echo Form::select('city_id', $cityDropDown, $business->city_id, ['id' => 'city_id', 'class' => 'form-control mb-4', 'required' => '']); ?>

                                    </div>

                                    <div class="col-lg-6">
                                        <?php echo Form::label('zipcode', 'Zip/Postal code', ['class' => '']); ?>

                                        <?php echo Form::text('zipcode', $business->zipcode , ['class' => 'form-control mb-4', 'required' => '']); ?>

                                    </div>
                                </div>
                            </div>

                                <div class="form-edit-profile">
                                    <label>Photo</label>
                                    <div id="photo-upload">
                                        <?php if( !empty($business->photo) && Common::isFileExists($business->photo) ): ?>
                                            <img src="<?php echo e(url($business->photo)); ?>" alt="">
                                        <?php else: ?>
                                            <img src="<?php echo e(url('images/profile-default.png')); ?>" alt="">
                                        <?php endif; ?>
                                        <div class="upload-btn-wrapper">
                                            <input type="file" style="display:none;" data-name="user-profile-file"
                                                   name="photo"
                                                   id="profile_photo">
                                            <button type="button" class="btn btn-orange" id="select_photo">Select Photo
                                            </button>
                                        </div>
                                        <span class="user-profile-file" style="padding-left:10px;"></span>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                                
                                <div class="form-edit-profilebtn saveh2"><?php echo Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green save_btn_green mt-5']); ?></div>

                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script>
        function teacherDelete() {
            var dynamicDialog = $('<div id="conformBox">' + 'Are you sure you want to delete this business?</div>');
            dynamicDialog.dialog({
                title: "Delete business",
                closeText: "",
                draggable: false,
                closeOnEscape: true,
                modal: true,
                minWidth: 450,
                dialogClass: 'customer-remove-dialog',
                open: function (event, ui) {
                    $('body').addClass('modal-open');
                },
                close: function (event, ui) {
                    $('body').removeClass('modal-open');
                },
                buttons:
                    [{
                        text: "Delete",
                        click: function () {
                            $(this).dialog("close");
                            teacherDeleteConfirm();
                        },
                        class: 'cutomer-remove-button',
                    },
                        {
                            text: "Cancel",
                            click: function () {
                                $(this).dialog("close");
                            },
                            class: 'cutomer-remove-cancel',
                        }]
            });
            return false;
        }

        function teacherDeleteConfirm() {
            var dynamicDialog2 = $('<div id="conformBox">' + 'Deleting business is permanent and cannot be undone?</div>');
            dynamicDialog2.dialog({
                title: "Delete business",
                closeOnEscape: true,
                modal: true,
                closeText: "",
                draggable: false,
                minWidth: 550,
                dialogClass: 'customer-remove-dialog',
                open: function (event, ui) {
                    $('body').addClass('modal-open');
                },
                close: function (event, ui) {
                    $('body').removeClass('modal-open');
                },
                buttons:
                    [{
                        text: "Delete",
                        click: function () {
                            $(this).dialog("close");
                            $('#removeteacher').submit();
                        },
                        class: 'cutomer-remove-button',
                    },
                        {
                            text: "Cancel",
                            click: function () {
                                $(this).dialog("close");
                            },
                            class: 'cutomer-remove-cancel',
                        }]
            });
            return false;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>