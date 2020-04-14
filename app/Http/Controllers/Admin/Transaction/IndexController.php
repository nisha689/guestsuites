<?php

namespace App\Http\Controllers\Admin\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\Transaction\Transaction;
use App\Classes\Helpers\Transaction\Helper;
use App\Classes\Models\User\User;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use App\Classes\Helpers\Helper as HelperMain;

class IndexController extends Controller
{
    protected $transactionObj;
    protected $userObj;
    protected $_helper;
    protected $_helperRoles;
	protected $_helperMain;

    public function __construct( Transaction $transactionModel )
    {
        $this->transactionObj = $transactionModel;
        $this->userObj = new User();
        $this->_helper = new Helper();
        $this->_helperRoles = new HelperRoles();
		$this->_helperMain = new HelperMain();
    }

    public function index( Request $request )
    {
        $data = $request->all();
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'updated_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';
        $name = ! empty( $data['name'] ) ? $data['name'] : "";
        $email = ! empty( $data['email'] ) ? $data['email'] : "";
        $paymentMethod = ! empty( $data['payment_method'] ) ? $data['payment_method'] : -1;
        $status = isset( $data['status'] ) ? $data['status'] : -1;
        $startDate = isset( $data['start_date'] ) ? $data['start_date'] : "";
        $endDate = isset( $data['end_date'] ) ? $data['end_date'] : "";

        $perPage = isset( $data['per_page'] ) ? $data['per_page'] : $this->_helper->getConfigPerPageRecord();
		if( $perPage <= 0 ) $page = -1;
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['name'               => $name,
                   'email'              => $email,
                   'payment_method'     => $paymentMethod,
                   'status'             => $status,
                   'created_start_date' => $startDate,
                   'created_end_date'   => $endDate,];
        
        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder] );
        $transactions = $this->transactionObj->getList( $searchHelper );
        $totalRecordCount = $this->transactionObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['name'           => $name,
                                                              'email'          => $email,
                                                              'payment_method' => $paymentMethod,
                                                              'status'         => $status,
                                                              'start_date'     => $startDate,
                                                              'end_date'       => $endDate,] );

        $paging = $this->transactionObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );
		
        return view( 'admin.transaction.index', compact( 'sortedBy', 'sortedOrder', 'recordStart', 'paging', 'totalRecordCount', 'startDate', 'endDate', 'transactions', 'name', 'email', 'paymentMethod','status','perPage' ) );
    }

    public function details( Request $request, $id )
    {
        $id = Common::getDecryptId($id);
        if( $id <= 0 ){ return abort(404); }
        $transaction = $this->transactionObj->getDateById($id);
        if(empty($transaction->id)){ return abort(404); }
        $payForUser = $this->userObj->getDateById( $transaction->user_id );
        return view('admin.transaction.details',compact('transaction','payForUser'));
    }

    public function delete( Request $request )
    {
        $data = $request->all();

        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }

        $isDelete = $this->transactionObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Transaction deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Transaction is not deleted successfully.' );
        }
        return Redirect::back();
    }
}
