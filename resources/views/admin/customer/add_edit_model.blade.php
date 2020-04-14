<div class="modal add-edit-teacher-model" id="teacher_model">
    <div class="modal-dialog">

        {!! Form::open(['method' => 'POST','enctype' => 'multipart/form-data','name'=>'add-edit-teacher-model-form', 'id' =>'add_edit_teacher_model_form', 'class'=>'add-edit-teacher-form-model','data-parsley-validate']) !!}

        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body modal_success">
            
                @if(!empty($businessName))
                    <h4 class="modal-title mb-0" >Add customer</h4>
                    <div class="mb-5">
                        <span class="is-school-in">In</span>
                        <span class="is-school-name">({{ ucfirst($businessName) }})</span>
                    </div>
                @else
                    <h4 class="modal-title mb-5" >Add customer</h4>
                @endif

            
                <div class="alert alert-success custom-success-message display-none"></div>
                <div class="alert alert-danger custom-error-message display-none"></div>

                <div class="col-lg-12 col-lg-12">
                    <div class="row">

                        {!! Form::hidden('user_id', 0, array('id' => 'add_edit_teacher_model_id')) !!}

                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('first_name', 'First name') !!}
                            {!! Form::text('first_name', old('first_name'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('last_name', 'Last name') !!}
                            {!! Form::text('last_name', old('last_name'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('phone', 'Phone number') !!}
                            {!! Form::text('phone', old('phone'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>

                        @if( $businessId > 0 )
                            {!! Form::hidden('business_id', $businessId,  ['class' => 'form-control mb-3', 'id'=>'business_id']) !!}
                        @else
                            <div class="col-lg-6 col-md-6">
                              {!! Form::label('business_id', 'Business', ['class' => '']) !!}
                              {!! Form::select('business_id', $businessDropDownForAdd, old('business_id'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                          </div>
                        @endif

                          <div class="col-lg-6 col-md-6">
                            {!! Form::label('gender', 'Gender') !!}
                            {!! Form::select('gender', ['1' => 'Male','2' => 'Female'], old('gender'), ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>
                        
                        <div class="col-lg-6 col-md-6">
                            {!! Form::label('address', 'Address', ['class' => '']) !!}
                            {!! Form::text('address', old('address') , ['class' => 'form-control mb-4', 'required' => '']) !!}
                        </div>

                          <div class="col-lg-6 col-md-6">
                              {!! Form::label('country_id', 'Country', ['class' => '']) !!}
                              {!! Form::select('country_id', $countryDropDown, old('country_id'), ['onchange' => "getStateDropDown(this,'#state_id')",'class' => 'form-control mb-4', 'required' => '']) !!}
                          </div>

                          <div class="col-lg-6 col-md-6">
                              {!! Form::label('state_id', 'State', ['class' => '']) !!}
                              {!! Form::select('state_id', ['' => 'Select state'], old('state_id'), ['onchange' => "getCityDropDown(this,'#city_id')",'class' => 'form-control mb-4', 'required' => '']) !!}
                          </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    {!! Form::label('city_id ', 'City/Town', ['class' => '']) !!}
                                    {!! Form::select('city_id', ['' => 'Select city'],  old('city_id'), ['id' => 'city_id', 'class' => 'form-control mb-4', 'required' => '']) !!}
                                </div>

                                <div class="col-lg-6">
                                    {!! Form::label('zipcode', 'Zip/Postal code', ['class' => '']) !!}
                                    {!! Form::text('zipcode', old('zipcode') , ['class' => 'form-control mb-4', 'required' => '']) !!}
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-lg-6 col-md-6">
                            <label>Photo</label>
                            <div id="photo-upload">
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
                        
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="form-edit-profilebtn saveh1">
                    {!! Form::Submit('Save', ['class' => 'btn btn_green mt-4 mb-5']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
