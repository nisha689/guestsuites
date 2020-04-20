<?php

namespace App\Classes\Models\Transaction;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\Transaction\Helper;
use App\Classes\Models\User\User;
use App\Classes\Models\Plan\Plan;
use App\Classes\Models\Discount\Discount;


class Transaction extends BaseModel
{
    public $table = 'gs_transaction';
    public $primaryKey = 'id';
    public $entity = 'transaction';
    protected $searchableColumns = [];

    protected $fillable = ['transaction_id',
                           'payment_method',
                           'amount',
                           'net_amount',
                           'user_id',
                           'plan_id',
                           'discounts_id',
                           'created_type',
                           'status'];

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

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id', 'user_id' );
    }

    public function plan()
    {
        return $this->belongsTo( Plan::class, 'plan_id', 'plan_id' );
    }

    public function discount()
    {
        return $this->belongsTo( Discount::class, 'discounts_id', 'discounts_id' );
    }

    public function addEmailFilter( $email = '' )
    {
        if ( ! empty( trim( $email ) ) ) {
            $tableName = $this->userObj->getTableName();
            $this->queryBuilder->where( $tableName . '.email', '=', trim( $email ) );
        }
        return $this;
    }

    public function getPaymentMethodStringAttribute()
    {
        if ( $this->payment_method == 1 ) {
            return "Stripe";
        }
        if ( $this->payment_method == 2 ) {
            return "Paypal";
        }
        return "";
    }

    public function getStatusStringAttribute()
    {
        return $this->status == 1 ? 'Success' : 'Fail';
    }

    public function joinUser( $searchable = false )
    {
        $userTableName = $this->userObj->getTable();
        $searchableColumns = $this->userObj->getSearchableColumns();

        $this->joinTables[] = ['table'             => $userTableName,
                               'searchable'        => $searchable,
                               'searchableColumns' => $searchableColumns];

        $this->queryBuilder->leftJoin( $userTableName, function ( $join ) use ( $userTableName ) {
            $join->on( $this->table . '.user_id', '=', $userTableName . '.user_id' );

        } );

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

    public function addPaymentMethodFilter( $paymentMethod = 0 )
    {
        if ( ! empty( $paymentMethod ) && $paymentMethod > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.payment_method', '=', $paymentMethod );
        }
        return $this;
    }

    public function addPaymentMethodInFilter( $paymentMethodIn = '' )
    {
        if ( ! empty( $paymentMethodIn ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->whereIn( $tableName . '.payment_method', $paymentMethodIn );
        }
        return $this;
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

    public function addNameLikeFilter( $name = '' )
    {
        if ( ! empty( trim( $name ) ) ) {
            $tableName = $this->userObj->getTableName();
            $this->queryBuilder->where( function ( $q ) use ( $name, $tableName ) {
                $q->where( $tableName . '.first_name', 'like', '%' . $name . '%' );
                $q->Orwhere( $tableName . '.last_name', 'like', '%' . $name . '%' );
            } );
        }
        return $this;
    }

    public function addIdFilter( $id = 0 )
    {
        if ( ! empty( $id ) && $id > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.id', '=', $id );
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

    public function addTransactionIdFilter( $transactionId = '' )
    {
        if ( ! empty( $transactionId ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.transaction_id', '=', $transactionId );
        }
        return $this;
    }

    public function addPlanIdFilter( $planId = '' )
    {
        if ( ! empty( $planId ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.plan_id', '=', $planId );
        }
        return $this;
    }

    public function getDateById( $id )
    {

        if ( ! ($id > 0) ) {
            return [];
        }

        return $this->setSelect()
                    ->addIdFilter( $id )
                    ->get()
                    ->first();
    }

    public function getDateByTransactionId( $transactionId = '' )
    {
        return $this->setSelect()
                    ->addTransactionIdFilter( $transactionId )
                    ->get()
                    ->first();
    }


    public function getList( $searchHelper )
    {

        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;
        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';

        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $email = ( ! empty( $searchHelper->_filter['email'] )) ? $searchHelper->_filter['email'] : '';
        $status = (isset( $searchHelper->_filter['status'] )) ? $searchHelper->_filter['status'] : -1;
        $paymentMethod = ( ! empty( $searchHelper->_filter['payment_method'] )) ? $searchHelper->_filter['payment_method'] : 0;
        $startDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $endDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $planId = ( ! empty( $searchHelper->_filter['plan_id'] )) ? $searchHelper->_filter['plan_id'] : 0;
		$userId = ( ! empty( $searchHelper->_filter['user_id'] )) ? $searchHelper->_filter['user_id'] : 0;
		
        $list = $this->setSelect()
                     ->joinUser()
                     ->addSearch( $search )
                     ->addStatusFilter( $status )
                     ->addEmailFilter( $email )
                     ->addNameLikeFilter( $name )
                     ->addCreatedDateFilter( $startDate, $endDate )
                     ->addPaymentMethodFilter( $paymentMethod )
                     ->addPlanIdFilter( $planId )
					 ->addUserIdFilter( $userId )
                     ->addSortOrder( $searchHelper->_sortOrder )
                     ->addPaging( $searchHelper->_page, $perPage )
                     ->addGroupBy( $searchHelper->_groupBy )
                     ->get( $searchHelper->_selectColumns );
        return $list;
    }

    public function getListTotalCount( $searchHelper )
    {
        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';

        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $email = ( ! empty( $searchHelper->_filter['email'] )) ? $searchHelper->_filter['email'] : '';
        $status = (isset( $searchHelper->_filter['status'] )) ? $searchHelper->_filter['status'] : -1;
        $paymentMethod = ( ! empty( $searchHelper->_filter['payment_method'] )) ? $searchHelper->_filter['payment_method'] : 0;
        $startDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $endDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $planId = ( ! empty( $searchHelper->_filter['plan_id'] )) ? $searchHelper->_filter['plan_id'] : 0;
        $userId = ( ! empty( $searchHelper->_filter['user_id'] )) ? $searchHelper->_filter['user_id'] : 0;

        $count = $this->setSelect()
                      ->joinUser()
                      ->addSearch( $search )
                      ->addStatusFilter( $status )
                      ->addEmailFilter( $email )
                      ->addNameLikeFilter( $name )
                      ->addCreatedDateFilter( $startDate, $endDate )
                      ->addPaymentMethodFilter( $paymentMethod )
                      ->addPlanIdFilter( $planId )
                      ->addUserIdFilter( $userId )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function getSum( $searchHelper )
    {

        $this->reset();

        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';$search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        
        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $email = ( ! empty( $searchHelper->_filter['email'] )) ? $searchHelper->_filter['email'] : '';
        $status = (isset( $searchHelper->_filter['status'] )) ? $searchHelper->_filter['status'] : -1;
        $paymentMethod = ( ! empty( $searchHelper->_filter['payment_method'] )) ? $searchHelper->_filter['payment_method'] : 0;
        $startDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $endDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $planId = ( ! empty( $searchHelper->_filter['plan_id'] )) ? $searchHelper->_filter['plan_id'] : 0;
        $userId = ( ! empty( $searchHelper->_filter['user_id'] )) ? $searchHelper->_filter['user_id'] : 0;

        $list = $this->setSelect()
                     ->joinUser()
                     ->addSearch( $search )
                     ->addStatusFilter( $status )
                      ->addEmailFilter( $email )
                      ->addNameLikeFilter( $name )
                      ->addCreatedDateFilter( $startDate, $endDate )
                      ->addPaymentMethodFilter( $paymentMethod )
                      ->addPlanIdFilter( $planId )
                      ->addUserIdFilter( $userId )
                      ->addSortOrder( $searchHelper->_sortOrder )
                     ->addPaging( $searchHelper->_page, $perPage )
                     ->addGroupBy( $searchHelper->_groupBy )
                     ->sum( $searchHelper->_selectColumns );

        return $list;
    }

    public function saveRecord( $data )
    {
        $tableName = $this->getTableName();
        $id = 0;
        /*$rules = ['first_name' => ['required', 'string', 'max:100'],
                  'last_name' => ['required', 'string', 'max:100'],
                  'email' => ['required', 'string', 'email', 'max:191', 'unique:'.$tableName],
                  'phone' => ['required', 'numeric', 'min:10'],
                  'photo' => ['mimes:jpeg,jpg,png,gif'],];
        */
        if ( isset( $data['id'] ) && $data['id'] != '' && $data['id'] > 0 ) {
            $id = $data['id'];
        }
        /*
        $validationResult = $this->validateData( $rules, $data);

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['user_id'] = 0;
            return $result;
        }*/

        if ( $id > 0 ) {
            $transaction = self::findOrFail( $id );

            $transaction->update( $data );
            $result['id'] = $transaction->id;
        } else {
            $transaction = self::create( $data );
            $result['id'] = $transaction->id;;
        }
        $result['success'] = true;
        $result['message'] = "Transaction saved successfully.";
        return $result;
    }

}
