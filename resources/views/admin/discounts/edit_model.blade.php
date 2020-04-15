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
                <h4 class="modal-title mb-5">Add discount</h4>
                <div class="alert alert-success custom-success-message display-none"></div>
                <div class="alert alert-danger custom-error-message display-none"></div>
                <div class="col-lg-12 col-lg-12">
                    <div class="row">
                        {!! Form::hidden('discount_id', 0, array('id' => 'add_edit_model_id')) !!}
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('code', 'Code', ['class' => '']) !!}
                            {!! Form::text('code', old('code'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('validity_date', 'Validity Date', ['class' => '']) !!}
                            {!! Form::text('validity_date', old('validity_date'), ['class' => 'form-control date-field mb-3','autocomplete' => 'Off', 'data-toggle'=>'datepicker', 'required' => '']) !!}
                        </div>
                        <div class="col-lg-12 col-md-12">
                            {!! Form::label('percent', 'Percent (%)', ['class' => '']) !!}
                            {!! Form::text('percent', old('percent'), ['class' => 'form-control mb-4 price-validation']) !!}
                        </div>
                        <div class="col-lg-12 col-md-12 text-center">
                           {!! Form::label('or', 'OR',['class' => 'mb-4']) !!}
                        </div>
                        <div class="col-lg-12 col-md-12">
                            {!! Form::label('fixed_amount', 'Fixed amount ($)', ['class' => '']) !!}
                            {!! Form::text('fixed_amount', old('fixed_amount'), ['class' => 'form-control mb-4 price-validation']) !!}
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

