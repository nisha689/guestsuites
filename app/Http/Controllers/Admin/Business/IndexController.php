<?php

namespace App\Http\Controllers\Admin\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\User\User;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Models\EmailTemplate\EmailTemplate;
use App\Classes\Models\Country\Country;
use App\Classes\Models\State\State;
use App\Classes\Models\City\City;

class IndexController extends Controller
{
    protected $userObj;
    protected $_helper;
    protected $_helperRoles;
    protected $emailTemplateObj;
    protected $countryObj;
    protected $stateObj;
    protected $cityObj;

    public function __construct( User $userModel )
    {
        $this->userObj = $userModel;
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();
        $this->emailTemplateObj = new EmailTemplate();
        $this->countryObj = new Country();
        $this->stateObj = new State();
        $this->cityObj = new City();
    }

    public function index( Request $request )
    {
        $data = $request->all();
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'updated_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';
        $businessRoleId = $this->_helperRoles->getBusinessRoleId();
        $name = ! empty( $data['name'] ) ? $data['name'] : "";
        $email = ! empty( $data['email'] ) ? $data['email'] : "";
        $status = isset( $data['status'] ) ? $data['status'] : -1;
        $createdStartDate = isset( $data['start_date'] ) ? $data['start_date'] : '';
        $createdEndDate = isset( $data['end_date'] ) ? $data['end_date'] : '';

        $perPage = $this->_helper->getConfigPerPageRecord();
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['status'             => $status,
                   'role_id'            => $businessRoleId,
                   'name'               => $name,
                   'email'              => $email,
                   'created_start_date' => $createdStartDate,
                   'created_end_date'   => $createdEndDate];
        $groupBy = [$userTableName = $this->userObj->getTable() . '.user_id'];
        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder],$groupBy );
        $businesses = $this->userObj->getList( $searchHelper );
        $totalRecordCount = $this->userObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['name'       => $name,
                                                              'status'     => $status,
                                                              'email'      => $email,
                                                              'start_date' => $createdStartDate,
                                                              'end_date'   => $createdEndDate] );
        $paging = $this->userObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );
        $statusDropDown = $this->_helper->getStatusDropDownWithAllOption();
        $countryDropDown = $this->countryObj->getDropDown('Select Country','');
                
        return view( 'admin.business.index', compact( 'sortedBy', 'sortedOrder', 'recordStart', 'businesses', 'paging', 'totalRecordCount', 'name', 'email', 'statusDropDown', 'status', 'createdStartDate', 'createdEndDate','countryDropDown' ) );
    }

    public function delete( Request $request )
    {
        $data = $request->all();
        
        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }
        $isListingPage = false;
        if(!empty($data['is_listing_page']) && $data['is_listing_page'] == 1){
            $isListingPage = true;
        }

        $isDelete = $this->userObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Business deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Business is not deleted successfully.' );
        }
        if($isListingPage){
            return redirect( 'admin/businesses' );
        }
        return Redirect::back();
        
    }

    public function saveAjax( Request $request )
    {
        $data = $request->all();
        $password = Common::getDefaultPassword();
        $data['password'] = Common::generatePassword( $password );
        $data['ip_address'] = \Request::ip();
        $data['created_type'] = 'Web';
        $data['email_verified_at'] = \DateFacades::getCurrentDateTime( 'format-1' );
        $data['e_token_check'] = '1';
        $data['status'] = 1;
        $data['role_id'] = $this->_helperRoles->getBusinessRoleId();
        $data['plan_id'] = 3;
        
        $results = $this->userObj->saveRecord( $data );
        if ( ! empty( $results['user_id'] ) && $results['user_id'] > 0 ) {
            
            $fromName = "Guest suites";
            $toName = $data['first_name'] . ' ' . $data['last_name'];
            $toEmail = $data['email'];

            $entity = "business_register";
            $emailTemplate = $this->emailTemplateObj->getDateByEntity( $entity );
            $templateFields = $emailTemplate->template_fields;
            $templateContent = $emailTemplate->template_content;

            $templateFieldValues = ['name'     => $toName,
                                    'email'    => $toEmail,
                                    'password' => $password];
            $mailContent = Common::convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues );

            $subject = $emailTemplate->subject;
            $htmlContent = \View::make( 'admin.emails.common.email_template', ['mailContent' => $mailContent,
                                                                               'subject'     => $subject] )
                                ->render();

            Common::sendMailByMailJet( $htmlContent, $fromName, '', $subject, $toName, $toEmail );
            
            return response()->json( $results );
        } else {
            /* Set Validation Message */
            $message = null;
            foreach ( $results['message'] as $key => $value ) {
                if ( empty( $message ) ) {
                    $message = $results['message']->{$key}[0];
                    break;
                }
            }
            $response = [];
            $response['success'] = false;
            $response['message'] = $message;
            return response()->json( $response );
        }
    }

    public function profileDetails( Request $request, $businessId )
    {
        $businessId = Common::getDecryptId( $businessId );

        if ( $businessId <= 0 ) {
            return abort( 404 );
        }

        $business = $this->userObj->getDateById( $businessId );
        if ( ! Common::isBusiness( $business ) ) {
            return abort( 404 );
        }
        $countryDropDown = $this->countryObj->getDropDown();
        $stateDropDown = $this->stateObj->getDropDown( $prepend = '', $prependKey = 0, $business->country_id );
        $cityDropDown = $this->cityObj->getDropDown( $prepend = '', $prependKey = 0, $business->state_id );

        return view( 'admin.business.profile', compact( 'business','countryDropDown','stateDropDown','cityDropDown') );
    }

    public function changePassword( Request $request )
    {
        $data = $request->all();
        $password = $data['password'];
        $result = $this->userObj->changePassword( $data );
        if ( ! empty( $result['user_id'] ) && $result['user_id'] > 0 ) {

            /* Send mail */
            $user = $this->userObj->getDateById( $result['user_id'] );

            $fromName = "Guest Suites";
            $toName = $user->name;
            $toEmail = $user->email;

            $entity = "business_password_change";
            $emailTemplate = $this->emailTemplateObj->getDateByEntity( $entity );
            $templateFields = $emailTemplate->template_fields;
            $templateContent = $emailTemplate->template_content;

            $templateFieldValues = ['name'     => $toName,
                                    'email'    => $toEmail,
                                    'password' => $password];
            $mailContent = Common::convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues );

            $subject = $emailTemplate->subject;
            $htmlContent = \View::make( 'admin.emails.common.email_template', ['mailContent' => $mailContent,
                                                                               'subject'     => $subject] )
                                ->render();
            Common::sendMailByMailJet( $htmlContent, $fromName, '', $subject, $toName, $toEmail );
            /* Send mail end */

            $message = "Business password changed successfully.";
            $request->session()
                    ->flash( 'success', $message );
            return Redirect::back();
        }
        return Redirect::back()
                       ->withErrors( $result['message'] );
    }

    public function banOrReActive( Request $request )
    {
        $data = $request->all();
        $userId = Common::getDecryptId( $data['user_id'] );
        if ( $userId <= 0 ) {
            return abort( 404 );
        }
        $data['user_id'] = $userId;
        $result = $this->userObj->banOrReActive( $data );
        if ( ! empty( $result['user_id'] ) && $result['user_id'] > 0 ) {
            $message = "Business banned successfully";
            if ( $data['status'] == 1 ) {
                $message = "Business reactivated successfully.";
            }
            $request->session()
                    ->flash( 'success', $message );
            return Redirect::back();
        } else {
            return Redirect::back()
                           ->withErrors( $result['message'] );
        }
    }

    public function profileSave( Request $request )
    {
        $data = $request->all();
        $result = $this->userObj->saveRecord( $data );

        if ( ! empty( $result['user_id'] ) && $result['user_id'] > 0 ) {
            $request->session()
                    ->flash( 'success', 'Business profile update successfully.' );
            return Redirect::back();
        } else {
            return Redirect::back()
                           ->withErrors( $result['message'] );
        }
    }
    
}
