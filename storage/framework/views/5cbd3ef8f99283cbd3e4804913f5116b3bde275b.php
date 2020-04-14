<div class="modal contact-model">
    <div class="modal-dialog">

        <?php echo Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'contact_form', 'id' =>'contact_form', 'class'=>'contact-form','data-parsley-validate']); ?>


        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body modal_success">
                <h4 class="modal-title mb-5" >Contact</h4>

                <div class="alert alert-success custom-success-message display-none"></div>
                <div class="alert alert-danger custom-error-message display-none"></div>

                <div class="col-lg-12 col-lg-12">
                    <div class="row">

                        <?php echo Form::hidden('user_id', 0, array('id' => 'contact_model_user_id')); ?>


                        <div class="col-lg-12 col-md-12">
                            <?php echo Form::label('message', 'Message', ['class' => '']); ?>

                            <?php echo Form::textarea('message', '', ['id' => 'contact_model_message','class' => 'form-control mb-4 popup_msghit', 'rows' => 9, 'required' => '']); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="form-edit-profilebtn saveh1">
                    <?php echo Form::Submit('Send Message', ['class' => 'btn btn_green mt-4 mb-5']); ?>

                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>