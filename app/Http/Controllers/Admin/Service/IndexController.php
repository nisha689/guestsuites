<?php

namespace App\Http\Controllers\Admin\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\Service\Service;
use App\Classes\Helpers\Service\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Classes\Models\User\User;

class IndexController extends Controller
{
    protected $serviceObj;
    protected $userObj;
    protected $_helper;

    public function __construct( Service $serviceModel )
    {
        $this->serviceObj = $serviceModel;
        $this->userObj = new User();
        $this->_helper = new Helper();
    }

    public function index( Request $request )
    {
        $data = $request->all();
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'updated_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';
        $businessServiceName = ! empty( $data['business_service_name'] ) ? $data['business_service_name'] : "";
        
        $perPage = $this->_helper->getConfigPerPageRecord();
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['business_service_name'  => $businessServiceName];

        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder] );
        $services = $this->serviceObj->getList( $searchHelper );
        $totalRecordCount = $this->serviceObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['business_service_name' => $businessServiceName] );

        $paging = $this->serviceObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );
        return view( 'admin.service.index', compact( 'businessServiceName','sortedBy', 'sortedOrder', 'recordStart', 'services', 'paging', 'totalRecordCount' ) );
    }

    public function delete( Request $request )
    {
        $data = $request->all();
        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }
        $isDelete = $this->serviceObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Service deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Service is not deleted successfully.' );
        }
        return Redirect::back();
    }

    public function saveAjax( Request $request )
    {
        $data = $request->all();
        $results = $this->serviceObj->saveRecord( $data );
        if ( ! empty( $results['business_service_id'] ) && $results['business_service_id'] > 0 ) {
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

    public function getDataForEditModel( Request $request )
    {
        $data = $request->all();
        $results = $this->serviceObj->getDateById( $data['business_service_id'] );

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        if ( ! empty( $results['business_service_id'] ) && $results['business_service_id'] > 0 ) {
            $response['success'] = true;
            $response['message'] = '';
            $response['data'] = $results;
        }
        return response()->json( $response );
    }
    
     public function formBuilder( Request $request )
    {
        return view( 'admin.service.form_builder');
    }

}
