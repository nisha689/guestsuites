<?php $__env->startSection('title', 'Businesses | '.trans('admin.front_title')); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_section">
        <?php echo $__env->make('partials.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.message.validation_error', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <div class="container">
            <div class="page-wrap bx-shadow mt-5 mb-5">
                <div class="row user-dt-wrap">
                    <div class="col-lg-12 col-md-12 pb-5">
                        <h1 class="admin_bigheading mb-5 inlinebtn">Businesses(<?php echo e($totalRecordCount); ?>)</h1>
                        <a href="javascript:void(0)" onclick="openTeacherModal('#teacher_model')"
                           class="btn light_blue float-right newbtn">New Business</a>
                        <div class="clear-both"></div>
                        <?php echo Form::open(['method' => 'GET','name'=>'admin-teacher-search', 'id' =>'admin_teacher_search_form', 'class'=>'top-search-options form-row pb-4','route' => ['admin.businesses']]); ?>

                        <?php echo Form::hidden('sorted_by', $sortedBy, array('id' => 'sortedBy')); ?>

                        <?php echo Form::hidden('sorted_order', $sortedOrder, array('id' => 'sortedOrder')); ?>

                        
                        <div class="col-md-3 col-lg-2">
                            <a href="<?php echo e(url('admin/businesses')); ?>">
                                <button type="button" class="btn btn_green resetbtn mb-3">Reset</button>
                            </a>
                        </div>

                        <div class="col-md-5 col-lg-3">
                            <?php echo Form::text('name', $name, ['class' => 'form-control mb-3', 'placeholder' => 'Names']); ?>

                        </div>

                        <div class="col-md-4 col-lg-4">
                            <?php echo Form::email('email', $email, ['class' => 'form-control mb-3', 'placeholder' => 'Email']); ?>

                        </div>

                        <div class="col-md-4 col-lg-3">
                            <?php echo Form::select('status', $statusDropDown, $status, ['class' => 'form-control mb-3']); ?>

                        </div>

                        <div class="col-md-4  col-lg-3">
                            <?php echo Form::text('start_date', $createdStartDate, ['id' =>'start_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Signed up from','autocomplete' => 'Off', 'data-toggle'=>'datepicker']); ?>

                        </div>

                        <div class="col-md-4  col-lg-3">
                            <?php echo Form::text('end_date', $createdEndDate, ['id' =>'end_date', 'class' => 'form-control date-field mb-3', 'placeholder' => 'Signed up to','autocomplete' => 'Off', 'data-toggle'=>'datepicker']); ?>

                        </div>

                        <div class="col-md-3 col-lg-2 offset-lg-4">
                            <?php echo Form::Submit(trans('admin.qa_search'), ['class' => 'btn btn_green resetbtn']); ?>

                        </div>
                        <?php echo Form::close(); ?>


                        <div class="table-responsive mt-5">
                            <table class="table sorting data-table school" id="classes">
                                <thead>
                                <tr>
                                    <?php ($shortClass = ( strtolower($sortedOrder) == 'asc') ? 'up' : 'down' ); ?>
                                    <?php ($sortDefault = '<i class="fas fa-sort"></i>'); ?>
                                    <?php ($sorting = '<i class="fas fa-caret-'.$shortClass.'"></i>'); ?>

                                    <th class="updownicon"
                                        onclick="sortWithSearch('user_id');"><?php echo app('translator')->getFromJson('admin.user.fields.id'); ?>
                                        <?php echo $sortedBy =='user_id' ? $sorting : $sortDefault; ?></th>
                                    <th class="updownicon"
                                        onclick="sortWithSearch('first_name');">NAMES
                                        <?php echo $sortedBy =='first_name' ? $sorting : $sortDefault; ?></th>
                                    <th>JOINED</th>
                                    <th>CUSTOMERS</th>
                                    <th>STATUS</th>
                                    <th><?php echo app('translator')->getFromJson('admin.user.fields.action'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($businesses) && count($businesses) > 0): ?>
                                    <?php $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessKey => $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="data-id"><span><?php echo e(++$recordStart); ?></span></td>
                                            <td>
                                                <b><?php echo e($business->name); ?></b>
                                                <a href="mailto:<?php echo e($business->email); ?>"
                                                   class="mail"><?php echo e($business->short_email); ?></a><br>
                                                <?php echo e(Common:: getPhoneFormat($business->phone)); ?>

                                            </td>
                                            <td>
                                                <b><?php echo e(DateFacades::dateFormat($business->created_at,'format-3')); ?></b>
                                                <?php echo e(DateFacades::dateFormat($business->created_at,'time-format-1')); ?>

                                            </td>
                                            <td>
                                                <b><?php echo e($business->business_customer($business->user_id)->count()); ?></b>
                                                <a href="<?php echo e(url('admin/customers?business_id='.$business->user_id)); ?>"
                                                           class="viewbtn">View</a>
                                            </td>
                                            <td class="<?php echo e($business->status ==1 ? 'green' : 'inactive'); ?>">
                                                <b><?php echo e($business->status_string); ?></b></td>
                                            <td class="action_div">
                                                <div class="action-warp">
                                                    <div class="left-action">
                                                        <a href="javascript:void(0)"
                                                           onclick="openContactModal('.contact-model',<?php echo e($business->user_id); ?>)"
                                                           class="viewbtn contact">Contact</a>
                                                        <a href="<?php echo e(url('admin/business/profile/')); ?>/<?php echo e(Common::getEncryptId($business->user_id)); ?>"
                                                           class="viewbtn">view</a>
                                                        
                                                    </div>
                                                    <div class="right-action">
                                                        <?php echo Form::open(array(
                                                                'method' => 'DELETE',
                                                                 'onsubmit' => "return confirm('".trans("admin.qa_are_you_sure_delete")." business?');",
                                                                'route' => ['admin.business.delete'])); ?>

                                                        <?php echo Form::hidden('id',$business->user_id ); ?>

                                                        

                                                        <button type="submit" value="Delete" class="delete_btn">
                                                            <i class="far fa-trash-alt"></i></button>

                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10"><?php echo app('translator')->getFromJson('admin.qa_no_entries_in_table'); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php echo $paging; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('admin.business.contact_model', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.business.add_edit_model', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script>
        var form = 'form#admin_teacher_search_form';

        /*----------------------------------  Teacher  -----------------------------------*/

        var addEditTeacherForm = 'form#add_edit_teacher_model_form';
        window.addEditTeacherUrl = "<?php echo e(URL::to('admin/business/save_ajax')); ?>";
        

        addEditTeacherModelIdElement = $(addEditTeacherForm + " #add_edit_teacher_model_id");
        firstNameElement = $(addEditTeacherForm + " #first_name");
        lastNameElement = $(addEditTeacherForm + " #last_name");
        emailElement = $(addEditTeacherForm + " #email");
        phoneElement = $(addEditTeacherForm + " #phone");
        companyNameElement = $(addEditTeacherForm + " #company_name");
        customTeacherErrorMessageElement = $(addEditTeacherForm + " .custom-error-message");
        customTeacherSuccessMessageElement = $(addEditTeacherForm + " .custom-success-message");

        /* Teacher Reset Form */
        function resetTeacherForm() {
            $(addEditTeacherForm).parsley().reset();
            customTeacherErrorMessageElement.hide();
            customTeacherSuccessMessageElement.hide();
            addEditTeacherModelIdElement.val(0);
            firstNameElement.val("");
            lastNameElement.val("");
            emailElement.val("");
            companyNameElement.val("");
            phoneElement.val("");
        }

        /* Add Edit Ajax Call */
        $(addEditTeacherForm).submit(function (event) {

            if ($(addEditTeacherForm).parsley().validate()) {

                event.preventDefault();
                customTeacherErrorMessageElement.hide();
                customTeacherSuccessMessageElement.hide();
                showLoader();

                phoneElement.unmask();
                var formData = new FormData($(this)[0]);

                jQuery.ajax({
                    url: window.addEditTeacherUrl,
                    enctype: 'multipart/form-data',
                    method: 'post',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function (response) {
                        if (response.success == true) {
                            customTeacherSuccessMessageElement.html(response.message);
                            customTeacherSuccessMessageElement.show();
                            hideLoader();
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            customTeacherErrorMessageElement.html(response.message);
                            customTeacherErrorMessageElement.show();
                            hideLoader();
                        }
                    },
                    error: function (xhr, status) {
                        customTeacherErrorMessageElement.html(AjaxErrorMsgCommon);
                        customTeacherErrorMessageElement.show();
                        hideLoader();
                    }
                });
            }
        });

        /* Open Teacher Model */
        function openTeacherModal(modelSelector) {
            resetTeacherForm();
            openModal(modelSelector);
        }

        /*----------------------------------  Contact  -----------------------------------*/

        /* Contact form start */
        var contactForm = 'form#contact_form';
        window.sendContactMailUrl = "<?php echo e(URL::to('contact/send_mail')); ?>";
        contactModelUserIdElement = $(contactForm + " #contact_model_user_id");
        contactModelMessageElement = $(contactForm + " #contact_model_message");
        customErrorMessageElement = $(contactForm + " .custom-error-message");
        customSuccessMessageElement = $(contactForm + " .custom-success-message");

        /* Reset Contact Form */
        function resetContactForm() {
            $(contactForm).parsley().reset();
            customErrorMessageElement.hide();
            customSuccessMessageElement.hide();
            contactModelUserIdElement.val("");
            contactModelMessageElement.val("");
        }

        /* Open Contact Model */
        function openContactModal(modelSelector, userId) {
            resetContactForm();
            contactModelUserIdElement.val(userId);
            openModal(modelSelector);
        }

        /* Send Message Ajax Call */
        jQuery(contactForm).submit(function (event) {
            if (jQuery(contactForm).parsley().validate()) {

                event.preventDefault();
                showLoader();

                /* Send Mail */
                jQuery.ajax({
                    url: window.sendContactMailUrl,
                    method: 'post',
                    dataType: 'JSON',
                    data: {
                        '_token': window._token,
                        'user_id': contactModelUserIdElement.val(),
                        'message': contactModelMessageElement.val(),
                    },
                    success: function (response) {
                        if (response.success == true) {
                            resetContactForm();
                            customSuccessMessageElement.html(response.message);
                            customSuccessMessageElement.show();
                            hideLoader();
                        } else {
                            customErrorMessageElement.html(response.message);
                            customErrorMessageElement.show();
                            hideLoader();
                        }
                    },
                    error: function (xhr, status) {
                        customErrorMessageElement.html(AjaxErrorMsgCommon);
                        customErrorMessageElement.show();
                        hideLoader();
                    }
                });
            }
        });
        /* Contact form end */
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>