<?php

namespace App\Http\Controllers\Admin\CustomerBookingService;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\CustomerBookingService\CustomerBookingService;
use App\Classes\Helpers\CustomerBookingService\Helper;
use App\Classes\Models\User\User;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Helpers\Helper as HelperMain;
use Carbon\Carbon;

class IndexController extends Controller
{
    protected $customerBookingServiceObj;
    protected $userObj;
    protected $_helper;
    protected $_helperRoles;
	protected $_helperMain;

    public function __construct( CustomerBookingService $customerBookingServiceModel )
    {
        $this->customerBookingServiceObj = $customerBookingServiceModel;
        $this->userObj = new User();
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();
		$this->_helperMain = new HelperMain();
    }

    public function index( Request $request, $customerIdEncrypt )
    {
        $data = $request->all();
        $customerId = Common::getDecryptId($customerIdEncrypt);
        if( $customerId <= 0 ){ return abort(404); }
        
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'updated_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';

        $startDate = isset( $data['start_date'] ) ? $data['start_date'] : "";
        $endDate = isset( $data['end_date'] ) ? $data['end_date'] : "";
        $perPage = isset( $data['per_page'] ) ? $data['per_page'] : $this->_helper->getConfigPerPageRecord();
		
        if( $perPage <= 0 ) $page = -1;
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['created_start_date' => $startDate,
                   'created_end_date'   => $endDate,
                   'customer_id'        => $customerId];
        
        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder] );
        $customerBookingServices = $this->customerBookingServiceObj->getList( $searchHelper );
        $totalRecordCount = $this->customerBookingServiceObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['start_date'     => $startDate,
                                                              'end_date'       => $endDate,] );
        $paging = $this->customerBookingServiceObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );
		
        return view( 'admin.customer_booking_service.index', compact( 'sortedBy', 'sortedOrder', 'recordStart', 'paging', 'totalRecordCount', 'startDate', 'endDate', 'customerBookingServices','perPage','customerIdEncrypt' ) );
    }

    public function details( Request $request, $id )
    {
        $id = Common::getDecryptId($id);
        if( $id <= 0 ){ return abort(404); }
        $customerBookingService = $this->customerBookingServiceObj->getDateById($id);
        if(empty($customerBookingService->customer_booked_id )){ return abort(404); }
        $customer = $this->userObj->getDateById( $customerBookingService->customer_id );
        return view('admin.customer_booking_service.details',compact('customerBookingService','customer'));
    }

    public function delete( Request $request )
    {
        $data = $request->all();

        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }

        $isDelete = $this->customerBookingServiceObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Customer booking service deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Customer booking service is not deleted successfully.' );
        }
        return Redirect::back();
    }
}
