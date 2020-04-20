<div class="modal add-edit-model" id="exam_model">
    <div class="modal-dialog">

        {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'add-edit-exam-model-form', 'id' =>'add_edit_exam_model_form', 'class'=>'login-form px-md-4 add-edit-form-model','data-parsley-validate']) !!}

        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body modal_success">
                <h4 class="modal-title mb-5">Add Service</h4>
                <div class="alert alert-success custom-success-message display-none"></div>
                <div class="alert alert-danger custom-error-message display-none"></div>
                <div class="col-lg-12 col-lg-12">
                    <div class="row">
                        {!! Form::hidden('business_service_id', 0, array('id' => 'add_edit_model_id')) !!}
                        <div class="col-lg-12 col-md-12">
                            {!! Form::label('business_service_name', 'Service Name', ['class' => '']) !!}
                            {!! Form::text('business_service_name', old('business_service_name'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                    </div>
					<div class="row">
					<div class="col-lg-12 col-md-12">
                            <div id="photo-upload">
                                <div class="upload-btn-wrapper">
                                    <input type="file" style="display:none;" data-name="user-profile-file"
                                           name="business_service_icon"
                                           id="profile_photo">
                                    <button type="button" class="btn btn-orange" id="select_photo">Upload an icon for
                                        this service
                                    </button>

                                </div>
                                <span class="user-profile-file" style="padding-left:10px;"></span>
                            </div>                            
                    </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="form-edit-profilebtn saveh1">
                    {!! Form::Submit(trans('admin.qa_save'), ['class' => 'btn btn_green mt-4 mb-5']) !!}
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>

