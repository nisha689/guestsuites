<?php

namespace App\Classes\Models\Discount;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\Discount\Helper;


class Discount extends BaseModel
{
    public $table = 'gs_discounts';
    public $primaryKey = 'discounts_id';
    public $entity = 'discounts';
    protected $searchableColumns = [];

    protected $fillable = ['validity_date',
                           'code',
                           'discounts_type',
                           'percent',
                           'fixed_amount'];

    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function addDiscountIdFilter( $discountId = 0 )
    {
        if ( ! empty( $discountId ) && $discountId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.discounts_id', '=', $discountId );
        }
        return $this;
    }

    public function getDateById( $discountId )
    {
        $return = $this->setSelect()
                       ->addDiscountIdFilter( $discountId )
                       ->get()
                       ->first();

        return $return;
    }

    public function getDropDown( $prepend = '', $prependKey = 0, $status = -1 )
    {
        $return = $this->setSelect()
                       ->addStatusFilter( $status )
                       ->addSortOrder( ['plan_name' => 'asc'] )
                       ->get()
                       ->pluck( 'plan_name', 'discounts_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependKey );
        }
        return $return;
    }

    public function getStatusStringAttribute()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }

    public function addNameLikeFilter( $name = '' )
    {
        if ( ! empty( trim( $name ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.name', 'like', '%' . $name . '%' );
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


    public function getList( $searchHelper )
    {

        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $status = isset( $searchHelper->_filter['status'] ) ? $searchHelper->_filter['status'] : -1;

        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addStatusFilter( $status )
                     ->addNameLikeFilter( $name )
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
        $name = ( ! empty( $searchHelper->_filter['name'] )) ? $searchHelper->_filter['name'] : '';
        $status = isset( $searchHelper->_filter['status'] ) ? $searchHelper->_filter['status'] : -1;

        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addStatusFilter( $status )
                      ->addNameLikeFilter( $name )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $discountId = 0;
        if ( ! empty( $data['discounts_id'] ) && $data['discounts_id'] > 0 ) {
            $discountId = $data['discounts_id'];
        }
        $tableName = $this->getTableName();
        $rules = ['plan_name' => ['required',
                             'unique:' . $tableName . ',plan_name,' . $discountId . ',discounts_id'],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        if ( $discountId > 0 ) {

            $plan = self::findOrFail( $data['discounts_id'] );
            $plan->update( $data );
            $result['discounts_id'] = $plan->discounts_id;
        } else {

            $plan = self::create( $data );
            $result['discounts_id'] = $plan->discounts_id;
        }
        $result['success'] = true;
        $result['message'] = "Plan saved successfully.";
        return $result;
    }
}
