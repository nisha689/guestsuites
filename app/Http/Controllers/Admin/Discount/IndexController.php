<?php

namespace App\Http\Controllers\Admin\Discount;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Models\Discount\Discount;
use App\Classes\Helpers\Discount\Helper;
use App\Classes\Common\Common;
use App\Classes\Helpers\SearchHelper;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $discountObj;
    protected $_helper;

    public function __construct( Discount $discountModel )
    {
        $this->discountObj = $discountModel;
        $this->_helper = new Helper();
    }

    public function index( Request $request )
    {
        $data = $request->all();
        $page = ! empty( $data['page'] ) ? $data['page'] : 0;
        $sortedBy = ! empty( $request->get( 'sorted_by' ) ) ? $request->get( 'sorted_by' ) : 'updated_at';
        $sortedOrder = ! empty( $request->get( 'sorted_order' ) ) ? $request->get( 'sorted_order' ) : 'DESC';
        $code = ! empty( $data['code'] ) ? $data['code'] : "";
        
        $perPage = $this->_helper->getConfigPerPageRecord();
        $recordStart = common::getRecordStart( $page, $perPage );
        $filter = ['code'  => $code];

        $searchHelper = new SearchHelper( $page, $perPage, $selectColumns = ['*'], $filter, $sortOrder = [$sortedBy => $sortedOrder] );
        $discounts = $this->discountObj->getList( $searchHelper );
        $totalRecordCount = $this->discountObj->getListTotalCount( $searchHelper );
        $paginationBasePath = Common::getPaginationBasePath( ['code' => $code] );

        $paging = $this->discountObj->preparePagination( $totalRecordCount, $paginationBasePath, $searchHelper );
        return view( 'admin.discounts.index', compact( 'code','sortedBy', 'sortedOrder', 'recordStart', 'discounts', 'paging', 'totalRecordCount' ) );
    }

    public function delete( Request $request )
    {
        $data = $request->all();
        if ( empty( $data['id'] ) ) {
            return abort( 404 );
        }
        $isDelete = $this->discountObj->removed( $data['id'] );
        if ( $isDelete ) {
            $request->session()
                    ->flash( 'success', 'Discount deleted successfully.' );
        } else {
            $request->session()
                    ->flash( 'error', 'Discount is not deleted successfully.' );
        }
        return Redirect::back();
    }

    public function saveAjax( Request $request )
    {
        $data = $request->all();
        $results = $this->discountObj->saveRecord( $data );
        if ( ! empty( $results['discounts_id'] ) && $results['discounts_id'] > 0 ) {
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
        $results = $this->discountObj->getDateById( $data['discounts_id'] );

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        if ( ! empty( $results['discounts_id'] ) && $results['discounts_id'] > 0 ) {
            $response['success'] = true;
            $response['message'] = '';
            $response['data'] = $results;
        }
        return response()->json( $response );
    }

}
