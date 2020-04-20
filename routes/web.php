<?php

Route::get( 'admin_register', function () {
    return response()->view('errors.404');
});

/* Password Generate */
Route::post( 'password_generate', ['uses' => 'CommonController@getPasswordGenerate','as'   => 'password_generate'] );

/* Admin Auth Start */
Route::get( 'admin_login', 'Admin\Auth\LoginController@showLoginForm' )->name( 'admin_login' );
Route::post( 'admin_login', 'Admin\Auth\LoginController@login' );
Route::post( 'admin_logout', 'Admin\Auth\LoginController@logout' )->name( 'admin_logout' );


//Admin Change Password Routes
Route::get( 'admin_change_password', 'Admin\Auth\ChangePasswordController@showChangePasswordForm' )
     ->name( 'admin_change_password' );
Route::patch( 'admin_change_password', 'Admin\Auth\ChangePasswordController@changePassword' )
     ->name( 'admin_change_password' );

//Admin Password Reset Routes
Route::get( 'admin_password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm' )
     ->name( 'admin.password.request' );
Route::post( 'admin_password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail' )
     ->name( 'admin.password.email' );

Route::get( 'admin_password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm' )
     ->name( 'admin.password.reset' );
Route::post( 'admin_password/reset', 'Admin\Auth\ResetPasswordController@reset' )
     ->name( 'admin.password.reset' );


Route::get('admin_email/verify', 'Admin\Auth\VerificationController@show')->name('admin.verification.notice');
Route::get('admin_email/verify/{id}', 'Admin\Auth\VerificationController@verify')->name('admin.verification.verify');
Route::get('admin_email/resend', 'Admin\Auth\VerificationController@resend')->name('admin.verification.resend');

/* End Admin Auth */

/* Admin region start */
Route::group( ['middleware' => ['admin'],
               'namespace' => 'Admin',
               'prefix'     => 'admin',
               'as'         => 'admin.'], function () {

    Route::get( '/home', 'HomeController@index' );


    /* Configuration Start */
    Route::get( 'settings', ['uses' => 'Configuration\IndexController@index','as'   => 'settings'] );
    Route::post( 'settings', ['uses' => 'Configuration\IndexController@save','as'   => 'setting.save'] );
    
    /* Configuration End */
    

	/* Email Template Start */
    Route::get( 'email-templates', ['uses' => 'EmailTemplate\IndexController@index','as'   => 'email_templates'] );
    Route::get( 'email-templates/details/{emailtemplate_id}', ['uses' => 'EmailTemplate\IndexController@emailDetails','as'   => 'emailtemplate.details'] );

    Route::post( 'email-templates/save', ['uses' => 'EmailTemplate\IndexController@save','as'   => 'emailtemplate.save'] );
    /* Email Template End */

    /* Configuration Start */
    Route::get( 'settings', ['uses' => 'Configuration\IndexController@index',
                             'as'   => 'settings'] );

    Route::post( 'settings', ['uses' => 'Configuration\IndexController@save',
                              'as'   => 'setting.save'] );

    /* Configuration End */


    /* Profile Start */
    Route::get( 'profile', ['uses' => 'Profile\IndexController@index','as'   => 'profile'] );
    Route::post( 'profile', ['uses' => 'Profile\IndexController@profileSave','as'   => 'profile'] );
    Route::post( 'change_password', ['uses' => 'Profile\IndexController@changePassword','as'   => 'change_password'] );
    /* Profile end */

    /* Business Start */

    Route::get( 'businesses', ['uses' => 'Business\IndexController@index',
                                             'as'   => 'businesses'] );

    Route::delete( 'business/delete', ['uses' => 'Business\IndexController@delete',
                                    'as'   => 'business.delete'] );

    Route::post( 'business/save_ajax', ['uses' => 'Business\IndexController@saveAjax',
                                     'as'   => 'business.save_ajax'] );


    Route::get( 'business/profile/{user_id}', ['uses' => 'Business\IndexController@profileDetails','as'   => 'business.profile'] );

    Route::post( 'business/ban_reactive', ['uses' => 'Business\IndexController@banOrReActive',
                                           'as'   => 'business.ban_reactive'] );

    Route::post( 'business/profile/save', ['uses' => 'Business\IndexController@profileSave','as'   => 'business.profile.save'] );
    Route::post( 'business/change_password', ['uses' => 'Business\IndexController@changePassword','as'   => 'business.change_password'] );


    /* Business End */


    /* Customer Start */

    Route::get( 'customers', ['uses' => 'Customer\IndexController@index',
                                             'as'   => 'customers'] );

    Route::delete( 'customer/delete', ['uses' => 'Customer\IndexController@delete',
                                    'as'   => 'customer.delete'] );

    Route::post( 'customer/save_ajax', ['uses' => 'Customer\IndexController@saveAjax',
                                     'as'   => 'customer.save_ajax'] );

    Route::get( 'customer/profile/{user_id}', ['uses' => 'Customer\IndexController@profileDetails','as'   => 'customer.profile'] );

    Route::post( 'customer/ban_reactive', ['uses' => 'Customer\IndexController@banOrReActive',
                                           'as'   => 'customer.ban_reactive'] );

    Route::post( 'customer/profile/save', ['uses' => 'Customer\IndexController@profileSave','as'   => 'customer.profile.save'] );
    Route::post( 'customer/change_password', ['uses' => 'Customer\IndexController@changePassword','as'   => 'customer.change_password'] );


    /* Customer End */

    /* Customer Booking Service Start */

    Route::get( 'customer-booking-service/{id}', ['uses' => 'CustomerBookingService\IndexController@index',
                        'as'   => 'customer_booking_service'] );

    Route::get( 'customer-booking-service-details/{id}', ['uses' => 'CustomerBookingService\IndexController@details',
                                 'as'   => 'customer_booking_service_details'] );

    Route::delete( 'customer-booking-service/delete', ['uses' => 'CustomerBookingService\IndexController@delete',
                                  'as'   => 'customer_booking_service.delete'] );

    /* Customer Booking Service Start */



    /* Backend Logs Start */
    Route::get( 'backend-logs', ['uses' => 'BackendLog\IndexController@index','as'   => 'backend_logs'] );

    /* Transaction Start */

    Route::get( 'transactions', ['uses' => 'Transaction\IndexController@index',
                        'as'   => 'transactions'] );

    Route::get( 'transaction/{id}', ['uses' => 'Transaction\IndexController@details',
                                 'as'   => 'transaction'] );

    Route::delete( 'transaction/delete', ['uses' => 'Transaction\IndexController@delete',
                                  'as'   => 'transaction.delete'] );

    /* Transaction Start */

    /* Services Start */
    Route::get( 'services', ['uses' => 'Service\IndexController@index',
                                        'as'   => 'services'] );

    Route::post( 'service/get_data', ['uses' => 'Service\IndexController@getDataForEditModel',
                                     'as'   => 'service.getdata'] );

    Route::post( 'service/ajax_save', ['uses' => 'Service\IndexController@saveAjax',
                                     'as'   => 'service.save_ajax'] );

    Route::delete( 'service/delete', ['uses' => 'Service\IndexController@delete',
                                   'as'   => 'service.delete'] );

    /* Services End */
    
    /* Form builder */
    Route::get( 'form-builder', ['uses' => 'Service\IndexController@FormBuilder'                                     ,'as'   => 'form_builder'] );

    /* Services End */

    /* Discounts Start */
    Route::get( 'discounts', ['uses' => 'Discount\IndexController@index',
                                        'as'   => 'discounts'] );

    Route::post( 'discount/get_data', ['uses' => 'Discount\IndexController@getDataForEditModel',
                                     'as'   => 'discount.getdata'] );

    Route::post( 'discount/ajax_save', ['uses' => 'Discount\IndexController@saveAjax',
                                     'as'   => 'discount.save_ajax'] );

    Route::delete( 'discount/delete', ['uses' => 'Discount\IndexController@delete',
                                   'as'   => 'discount.delete'] );

    /* Discounts End */
    
});
/* Admin region end */

/* Contact send mail Start */
    Route::post( 'contact/send_mail', ['uses' => 'Admin\Contact\IndexController@postSendMail',
                                       'as'   => 'contact.send_mail'] );

/* Contact send mail End */

  Route::post( 'getstatedropdown', ['uses' => 'CommonController@getStateDropdown',
                                 'as'   => 'getstatedropdown'] );

  Route::post( 'getcitydropdown', ['uses' => 'CommonController@getCityDropdown',
                                 'as'   => 'getcitydropdown'] );

