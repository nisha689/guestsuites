<?php

namespace App\Classes\Models\CustomerBookingService;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\CustomerBookingService\Helper;
use App\Classes\Models\User\User;


class CustomerBookingService extends BaseModel
{
    public $table = 'gs_customer_booked';
    public $primaryKey = 'customer_booked_id';
    public $entity = 'customer_booked';
    protected $searchableColumns = [];

    protected $fillable = ['business_id',
                           'customer_id',
                           'signature_img',
                           'medical_condition',
                           'medical_condition_explain',
                           'is_recive_message',
                           'is_stopping',
                           'are_you_18_or_older',
                           'are_you_18_content',
                           'start_date_time',
                           'finish_date_time'];

    protected $_helper;
    protected $userObj;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
        $this->userObj = new User();
    }

    public function customer()
    {
        return $this->belongsTo( User::class, 'customer_id', 'user_id' );
    }

    public function business()
    {
        return $this->belongsTo( User::class, 'business_id', 'user_id' );
    }

    public function addCreatedDateFilter( $startDate = '', $endDate = '' )
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

    public function addCustomerBookedIdFilter( $customerBookedId = 0 )
    {
        if ( ! empty( $customerBookedId ) && $customerBookedId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.customer_booked_id', '=', $customerBookedId );
        }
        return $this;
    }
    public function addCustomerIdFilter( $userId = 0 )
    {
        if ( ! empty( $userId ) && $userId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.customer_id', '=', $userId );
        }
        return $this;
    }
    public function addBusinessIdFilter( $userId = 0 )
    {
        if ( ! empty( $userId ) && $userId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_id', '=', $userId );
        }
        return $this;
    }
   

    public function getDateById( $id )
    {

        if ( ! ($id > 0) ) {
            return [];
        }

        return $this->setSelect()
                    ->addCustomerBookedIdFilter( $id )
                    ->get()
                    ->first();
    }


    public function getList( $searchHelper )
    {

        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;
        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';

        $startDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $endDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $customerId = ( ! empty( $searchHelper->_filter['customer_id'] )) ? $searchHelper->_filter['customer_id'] : 0;
        $businessId = ( ! empty( $searchHelper->_filter['business_id'] )) ? $searchHelper->_filter['business_id'] : 0;
		
        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addCreatedDateFilter( $startDate, $endDate )
                     ->addBusinessIdFilter( $businessId )
                     ->addCustomerIdFilter( $customerId )
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

        $startDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $endDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $customerId = ( ! empty( $searchHelper->_filter['customer_id'] )) ? $searchHelper->_filter['customer_id'] : 0;
        $businessId = ( ! empty( $searchHelper->_filter['business_id'] )) ? $searchHelper->_filter['business_id'] : 0;
        
        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addCreatedDateFilter( $startDate, $endDate )
                      ->addBusinessIdFilter( $businessId )
                      ->addCustomerIdFilter( $customerId )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }
   
}
