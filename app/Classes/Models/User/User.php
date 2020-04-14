<?php

namespace App\Classes\Models\User;

use App\Classes\Models\AuthBaseModel;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;
use App\Classes\Models\Roles\Roles;
use App\Notifications\Admin\ResetPasswordNotification;
use App\Notifications\Admin\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Auth;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Models\City\City;
use App\Classes\Models\State\State;
use App\Classes\Models\Country\Country;
use Mail;

class User extends AuthBaseModel
{
    public $table = 'gs_users';
    public $primaryKey = 'user_id';
    public $entity = 'users';
    protected $searchableColumns = ['first_name',
                                    'last_name'];

    protected $fillable = ['first_name',
                           'last_name',
                           'company_name',
                           'email',
                           'password',
                           'phone',
                           'gender',
                           'address',
                           'country_id',
                           'state_id',
                           'city_id',
                           'zipcode',
                           'photo',
                           'current_login_date',
                           'last_login_date',
                           'created_type',
                           'business_id',
                           'business_service_id',
                           'plan_id',
                           'ip_address',
                           'fcm_token',
                           'device_type',
                           'role_id',
                           'status',
                           'email_verified_at',
                           'remember_token'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password',
                         'remember_token',];

    protected $_helper;
    protected $_helperRoles;
    protected $cityObj;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();
        $this->cityObj = new City();
        
    }

    public function role()
    {
        return $this->belongsTo( Roles::class, 'role_id', 'role_id' );
    }
    
    public function city()
    {
        return $this->belongsTo( City::class, 'city_id', 'city_id' );
    }

    public function state()
    {
        return $this->belongsTo( State::class, 'state_id', 'state_id' );
    }

    public function country()
    {
        return $this->belongsTo( Country::class, 'country_id', 'country_id' );
    }
   

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

	public function business_customer($businessId)
    {

        $list = $this->setSelect()
                     ->addBusinessIdFilter( $businessId )
                     ->get(['*']);

        return $list;
                
    }

    public function getBusinessDropDown($prependValue = "", $prependKey ="")
    {
        $return = $this->setSelect()
                    ->addSortOrder( ['company_name' => 'asc'] )
                    ->addStatusFilter(1)
                    ->addRoleIdFilter(2)
                    ->get()
                    ->pluck( 'company_name', 'user_id' );

        if(!empty($prependValue)){
            $return->prepend( $prependValue, $prependKey );
        }
        return $return;
    }    
	
    public function getGenderTypeAttribute()
    {
        if ( ! empty( $this->gender ) ) {

            if ( $this->gender == 1 ) {
                return "M";
            } else {
                return "F";
            }
        }
        return "";
    }

    public function getShortEmailAttribute()
    {
        if ( !empty( $this->email) ) {
            return strlen( $this->email ) > 20 ? substr( $this->email, 0, 20).'...' : $this->email;
        }
        return "";
    }
	
	public function getSmallEmailAttribute()
    {		
        if ( !empty( $this->email) ) {
            return strlen( $this->email ) > 15 ? substr( $this->email, 0, 15).'...' : $this->email;
        }
        return "";
    }

	public function getMediumEmailAttribute()
    {
        if ( !empty( $this->email) ) {
            return strlen( $this->email ) > 25 ? substr( $this->email, 0, 25).'...' : $this->email;
        }
        return "";
    }

    
    public function getStatusStringAttribute()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    public function sendPasswordResetNotification( $token )
    {
        $this->notify( new ResetPasswordNotification( $token ) );
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify( new VerifyEmail );
    }

    public function getDateById( $userId )
    {
        $return = $this->setSelect()
                       ->addUserIdFilter( $userId )
                       ->get()
                       ->first();
        return $return;
    }
   
    public function addRoleIdInFilter( $roleIdArray = [] )
    {
        if ( ! empty( $roleIdArray ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->whereIn( $tableName . '.role_id', $roleIdArray );
        }
        return $this;
    }

    public function addUserIdInFilter( $userIdArray = [] )
    {
        if ( ! empty( $userIdArray ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->whereIn( $tableName . '.user_id', $userIdArray );
        }
        return $this;
    }

    public function addUserIdNotInFilter( $userIdArray = [] )
    {
        if ( ! empty( $userIdArray ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->whereNotIn( $tableName . '.user_id', $userIdArray );
        }
        return $this;
    }

    public function addRoleIdNotInFilter( $roleIdArray = [] )
    {
        if ( ! empty( $roleIdArray ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->whereNotIn( $tableName . '.role_id', $roleIdArray );
        }
        return $this;
    }

    public function addStatusFilter( $status = -1 )
    {
        if ( $status != '-1' && $status != -1 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.status', '=', $status );
        }
        return $this;
    }

    
    public function addIsVerifiedFilter( $isVerified = -1 )
    {
        if ( $isVerified != '-1' && $isVerified != -1 ) {
            $tableName = $this->getTableName();
            if ( $isVerified == 1 ) {
                $this->queryBuilder->where( $tableName . '.email_verified_at', '!=', null );
            }
            if ( $isVerified == 0 ) {
                $this->queryBuilder->where( $tableName . '.email_verified_at', '=', null );
            }
        }
        return $this;
    }

    public function addIsLoginFilter( $isLogin = -1 )
    {
        if ( $isLogin != '-1' && $isLogin != -1 ) {
            $tableName = $this->getTableName();
            if ( $isLogin == 1 ) {
                $this->queryBuilder->where( $tableName . '.last_login_date', '!=', null );
            }
            if ( $isLogin == 0 ) {
                $this->queryBuilder->where( $tableName . '.last_login_date', '=', null );
            }
        }
        return $this;
    }

    public function addNameLikeFilter( $name = '' )
    {
        if ( ! empty( trim( $name ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( function ( $q ) use ( $name, $tableName ) {
                $q->where( \DB::raw( "CONCAT($tableName.first_name, ' ',$tableName.last_name)" ), 'like', '%' . $name . '%' );
            } );
        }
        return $this;
    }

    public function addSignUpDateFilter( $startDate = '', $endDate = '' )
    {
        $tableName = $this->getTableName();
        if ( ! empty( $startDate ) ) {
            $startDate = date( "Y-m-d", strtotime( $startDate ) );
            $this->queryBuilder->whereDate( $tableName . '.created_at', '>=', "$startDate" );
        }

        if ( ! empty( $endDate ) ) {
            $endDate = date( "Y-m-d", strtotime( $endDate ) );
            $this->queryBuilder->whereDate( $tableName . '.created_at', '<=', "$endDate" );
        }

        return $this;
    }

    public function addEmailFilter( $email = '' )
    {
        if ( ! empty( trim( $email ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.email', '=', trim( $email ) );
        }
        return $this;
    }


    public function addUserIdFilter( $userId = 0 )
    {
        if ( ! empty( $userId ) && $userId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.user_id', '=', $userId );
        }
        return $this;
    }

    public function addBusinessIdFilter( $businessId = '' )
    {
        if ( ! empty( $businessId ) && $businessId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_id', '=', $businessId );
        }
        return $this;
    }

    public function addRoleIdFilter( $roleId = 0 )
    {
        if ( ! empty( $roleId ) && $roleId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.role_id', '=', $roleId );
        }
        return $this;
    }


    public function addCityFilter( $cityId )
    {

        if ( ! empty( $cityId ) && $cityId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.city_id', '=', $cityId );
        }
        return $this;
    }

    /*public function addSchoolNameLikeFilter( $schoolName )
    {
        if ( ! empty( $schoolName ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.school_name', 'like', '%' . $schoolName . '%' );
        }
        return $this;
    }*/

    public function addGenderFilter( $gender = 0 )
    {
        if ( ! empty( $gender ) && $gender > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.gender', '=', $gender );
        }
        return $this;
    }
    

    public function addFcmTokenFilter( $isFcmToken = 0 )
    {
        if ( $isFcmToken > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( function ( $q ) use ( $tableName ) {
                $q->where( $tableName . '.fcm_token', '!=', '' );
                $q->whereNotNull( $tableName . '.fcm_token' );
                $q->where( $tableName . '.device_type', '!=', '' );
                $q->whereNotNull( $tableName . '.device_type' );
            } );
        }
        return $this;
    }

    
    public function getList( $searchHelper )
    {
        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $roleId = ( ! empty( $searchHelper->_filter['role_id'] )) ? $searchHelper->_filter['role_id'] : 0;
        $businessId = ( ! empty( $searchHelper->_filter['business_id'] )) ? $searchHelper->_filter['business_id'] : '';
        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $email = ( ! empty( $searchHelper->_filter['email'] )) ? $searchHelper->_filter['email'] : '';
        $signUpStartDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $signUpEndDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $status = (isset ( $searchHelper->_filter['status'] )) ? $searchHelper->_filter['status'] : -1;
        $isVerified = ( ! empty( $searchHelper->_filter['is_verified'] )) ? $searchHelper->_filter['is_verified'] : -1;
        $isLogin = ( ! empty( $searchHelper->_filter['is_login'] )) ? $searchHelper->_filter['is_login'] : -1;
        $city_id = ( ! empty( $searchHelper->_filter['city_id'] )) ? $searchHelper->_filter['city_id'] : '';
        $company_name = ( ! empty( $searchHelper->_filter['company_name'] )) ? $searchHelper->_filter['company_name'] : '';
        $gender = ( ! empty( $searchHelper->_filter['gender'] )) ? $searchHelper->_filter['gender'] : 0;
        $roleIdIn = ( ! empty( $searchHelper->_filter['role_id_in'] )) ? $searchHelper->_filter['role_id_in'] : [];
        $roleIdNotIn = ( ! empty( $searchHelper->_filter['role_id_not_in'] )) ? $searchHelper->_filter['role_id_not_in'] : [];
        $userIdIn = ( ! empty( $searchHelper->_filter['user_id_in'] )) ? $searchHelper->_filter['user_id_in'] : [];
        $userIdNotIn = ( ! empty( $searchHelper->_filter['user_id_not_in'] )) ? $searchHelper->_filter['user_id_not_in'] : [];
        $isFcmToken = ( ! empty( $searchHelper->_filter['is_fcm_token'] )) ? $searchHelper->_filter['is_fcm_token'] : 0;
        
        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addRoleIdInFilter( $roleIdIn )
                     ->addBusinessIdFilter( $businessId )
                     ->addUserIdInFilter( $userIdIn )
                     ->addRoleIdNotInFilter( $roleIdNotIn )
                     ->addUserIdNotInFilter( $userIdNotIn )
                     ->addRoleIdFilter( $roleId )
                     ->addGenderFilter( $gender )
                     ->addNameLikeFilter( $name )
                     ->addEmailFilter( $email )
                     ->addSignUpDateFilter( $signUpStartDate, $signUpEndDate )
                     ->addStatusFilter( $status )
                     ->addCityFilter( $city_id )
                     ->addIsVerifiedFilter( $isVerified )
                     ->addIsLoginFilter( $isLogin )
                     ->addFcmTokenFilter( $isFcmToken )
                     ->addSortOrder( $searchHelper->_sortOrder )
                     ->addPaging( $searchHelper->_page, $perPage )
                     ->addGroupBy( $searchHelper->_groupBy )
                     ->get( $searchHelper->_selectColumns );

        return $list;
    }

    public function getListTotalCount( $searchHelper )
    {
        $this->reset();

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $roleId = ( ! empty( $searchHelper->_filter['role_id'] )) ? $searchHelper->_filter['role_id'] : 0;
        $businessId = ( ! empty( $searchHelper->_filter['business_id'] )) ? $searchHelper->_filter['business_id'] : '';
        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $email = ( ! empty( $searchHelper->_filter['email'] )) ? $searchHelper->_filter['email'] : '';
        $signUpStartDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $signUpEndDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $status = (isset ( $searchHelper->_filter['status'] )) ? $searchHelper->_filter['status'] : -1;
        $isVerified = ( ! empty( $searchHelper->_filter['is_verified'] )) ? $searchHelper->_filter['is_verified'] : -1;
        $isLogin = ( ! empty( $searchHelper->_filter['is_login'] )) ? $searchHelper->_filter['is_login'] : -1;
        $city_id = ( ! empty( $searchHelper->_filter['city_id'] )) ? $searchHelper->_filter['city_id'] : '';
        $company_name = ( ! empty( $searchHelper->_filter['company_name'] )) ? $searchHelper->_filter['company_name'] : '';
        $gender = ( ! empty( $searchHelper->_filter['gender'] )) ? $searchHelper->_filter['gender'] : 0;
        $roleIdIn = ( ! empty( $searchHelper->_filter['role_id_in'] )) ? $searchHelper->_filter['role_id_in'] : [];
        $roleIdNotIn = ( ! empty( $searchHelper->_filter['role_id_not_in'] )) ? $searchHelper->_filter['role_id_not_in'] : [];
        $userIdIn = ( ! empty( $searchHelper->_filter['user_id_in'] )) ? $searchHelper->_filter['user_id_in'] : [];
        $userIdNotIn = ( ! empty( $searchHelper->_filter['user_id_not_in'] )) ? $searchHelper->_filter['user_id_not_in'] : [];
        $isFcmToken = ( ! empty( $searchHelper->_filter['is_fcm_token'] )) ? $searchHelper->_filter['is_fcm_token'] : 0;

        $count = $this->setSelect()
                      ->addRoleIdInFilter( $roleIdIn )
                      ->addBusinessIdFilter( $businessId )
                     ->addUserIdInFilter( $userIdIn )
                     ->addRoleIdNotInFilter( $roleIdNotIn )
                     ->addUserIdNotInFilter( $userIdNotIn )
                     ->addRoleIdFilter( $roleId )
                     ->addGenderFilter( $gender )
                     ->addNameLikeFilter( $name )
                     ->addEmailFilter( $email )
                     ->addSignUpDateFilter( $signUpStartDate, $signUpEndDate )
                     ->addStatusFilter( $status )
                     ->addCityFilter( $city_id )
                     ->addIsVerifiedFilter( $isVerified )
                     ->addIsLoginFilter( $isLogin )
                     ->addFcmTokenFilter( $isFcmToken )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $tableName = $this->getTableName();

        $rules = ['first_name' => ['required',
                                   'string',
                                   'max:100'],
                  'last_name'  => ['required',
                                   'string',
                                   'max:100'],
                  'email'      => ['required',
                                   'string',
                                   'email',
                                   'max:191',
                                   'unique:' . $tableName],
                  'photo'      => ['mimes:jpeg,jpg,png,gif'],];
        $userId = 0;
        if ( isset( $data['user_id'] ) && $data['user_id'] != '' && $data['user_id'] > 0 ) {
            $userId = $data['user_id'];
            $rules['email'] = 'required|string|email|max:191|unique:' . $tableName . ',email,' . $userId . ',user_id';
        }

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = 0;
            return $result;
        }

        if ( ! empty( $data['photo'] ) ) {
            $filePath = $this->_helper->getImagePath();
            $data['photo'] = Common::fileUpload( $filePath, $data['photo'] );
        }

        if ( $userId > 0 ) {
            $user = self::findOrFail( $data['user_id'] );

            /* Delete Image */
            if ( ! empty( $data['photo'] ) ) {
                Common::deleteFile( $user->photo );
            }

            $user->update( $data );
            $result['user_id'] = $user->user_id;;

        } else {
            $user = self::create( $data );
            $result['user_id'] = $user->user_id;;
        }
        $result['success'] = true;
        $result['message'] = "User saved successfully.";
        return $result;
    }


	public function saveRecordForStudent( $data )
    {
        $tableName = $this->getTableName();
        $rules = ['first_name' => ['required',
                                   'string',
                                   'max:100'],
                  'last_name'  => ['required',
                                   'string',
                                   'max:100'],
                  'photo'      => ['mimes:jpeg,jpg,png,gif'],];

        $userId = 0;
        if ( isset( $data['user_id'] ) && $data['user_id'] != '' && $data['user_id'] > 0 ) {
            $userId = $data['user_id'];
        }
        if(!empty($data['email'])) {
            $rules['email'] = ['email',
                               'max:191',
                               'unique:' . $tableName];

            if ( $userId > 0 ) {
                $rules['email'] = 'email|max:191|unique:' . $tableName . ',email,' . $userId . ',user_id';
            }
        }

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = 0;
            return $result;
        }

        if ( ! empty( $data['photo'] ) ) {
            $filePath = $this->_helper->getImagePath();
            $data['photo'] = Common::fileUpload( $filePath, $data['photo'] );
        }

        if ($data['email'] == ''){
            $data['email'] = NULL;
        }

        if ( $userId > 0 ) {
            $user = self::findOrFail( $data['user_id'] );

            /* Delete Image */
            if ( ! empty( $data['photo'] ) ) {
                Common::deleteFile( $user->photo );
            }
            $user->update( $data );
            $result['user_id'] = $user->user_id;;

        } else {
            $user = self::create( $data );
            $result['user_id'] = $user->user_id;;
        }
        $result['success'] = true;
        $result['message'] = "User saved successfully.";
        return $result;
    }

    public function changePassword( $data )
    {
        $rules = ['password' => ['required',
                                 'string',
                                 'min:6',
                                 'confirmed']];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        $user = self::findOrFail( $data['user_id'] );
        $data['password'] = Common::generatePassword( $data['password'] );
        $user->update( $data );

        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "User password changed successfully.";
        return $result;
    }

    public function profileSave( $data )
    {
        $tableName = $this->getTableName();
        $userId = $data['user_id'];
        $rules = ['first_name' => ['required',
                                   'string',
                                   'max:100'],
                  'last_name'  => ['required',
                                   'string',
                                   'max:100'],
                  'phone'      => ['required',
                                   'numeric',
                                   'min:10'],
                  'address'    => ['required'],
                  'state_id'   => ['required'],
                  'city_id'    => ['required'],
                  'email'      => ['required',
                                   'string',
                                   'email',
                                   'max:191',
                                   'unique:' . $tableName . ',email,' . $userId . ',user_id'],
                  'photo'      => ['mimes:jpeg,jpg,png,gif'],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = $userId;
            return $result;
        }

        if ( ! empty( $data['photo'] ) ) {

            $filePath = $this->_helper->getImagePath();
            $data['photo'] = Common::fileUpload( $filePath, $data['photo'] );
        }

        $user = self::findOrFail( $userId );

        /* Delete Image */
        if ( ! empty( $data['photo'] ) && ! empty( $user->photo ) ) {
            Common::deleteFile( $user->photo );
        }

        $user->update( $data );
        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "User profile updated successfully.";
        return $result;
    }

    public function adminProfileSave( $data )
    {
        $tableName = $this->getTableName();
        $userId = $data['user_id'];
        $rules = ['first_name' => ['required',
                                   'string',
                                   'max:100'],
                  'last_name'  => ['required',
                                   'string',
                                   'max:100'],
                  'email'      => ['required',
                                   'string',
                                   'email',
                                   'max:191',
                                   'unique:' . $tableName . ',email,' . $userId . ',user_id'],
                  'photo'      => ['mimes:jpeg,jpg,png,gif'],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = $userId;
            return $result;
        }

        if ( ! empty( $data['photo'] ) ) {

            $filePath = $this->_helper->getImagePath();
            $data['photo'] = Common::fileUpload( $filePath, $data['photo'] );
        }

        $user = self::findOrFail( $userId );

        /* Delete Image */
        if ( ! empty( $data['photo'] ) && ! empty( $user->photo ) ) {
            Common::deleteFile( $user->photo );
        }

        $user->update( $data );
        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "User profile updated successfully.";
        return $result;
    }

    public function savePrincipal( $data )
    {
        $tableName = $this->getTableName();
        $userId = $data['user_id'];
        $rules = ['principal_first_name' => ['required',
                                             'string',
                                             'max:100'],
                  'principal_last_name'  => ['required',
                                             'string',
                                             'max:100'],
                  'principal_phone'      => ['required',
                                             'numeric',
                                             'min:10'],
                  'principal_email'      => ['required',
                                             'string',
                                             'email',
                                             'max:191',],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = $userId;
            return $result;
        }
        $user = self::findOrFail( $userId );
        $user->update( $data );
        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "Principal profile updated successfully.";
        return $result;
    }

    public function updateSchool( $data )
    {
        $tableName = $this->getTableName();
        $userId = $data['user_id'];
        $rules = ['school_name'       => ['required',
                                          'string',
                                          'max:100'],
                  'address'           => ['required',
                                          'string',
                                          'max:100'],
                  'school_motto'      => ['required'],
                  'core_values'       => ['required'],
                  'short_description' => ['required'],
                  'photo'             => ['mimes:jpeg,jpg,png,gif'],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = $userId;
            return $result;
        }

        if ( ! empty( $data['photo'] ) ) {

            $filePath = $this->_helper->getImagePath();
            $data['photo'] = Common::fileUpload( $filePath, $data['photo'] );
        }

        $user = self::findOrFail( $userId );

        /* Delete Image */
        if ( ! empty( $data['photo'] ) && ! empty( $user->photo ) ) {
            Common::deleteFile( $user->photo );
        }

        $user->update( $data );
        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "School details updated successfully..";
        return $result;
    }

    public function banOrReActive( $data )
    {
        $user = self::findOrFail( $data['user_id'] );
        $user->update( $data );
        $result['user_id'] = $user->user_id;
        $result['success'] = true;
        $result['message'] = "User banned successfully.";
        if ( $data['status'] == 1 ) {
            $result['message'] = "User reactivated successfully.";
        }
        return $result;
    }

    public function getProfileUrl()
    {
        if ( $this->role_id == $this->_helperRoles->getParentRoleId() ) {
            return "parent";
        }

        if ( $this->role_id == $this->_helperRoles->getTeacherRoleId() ) {
            return "teacher";
        }
        return "";
    }
}
