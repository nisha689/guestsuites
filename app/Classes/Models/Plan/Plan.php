<?php

namespace App\Classes\Models\Plan;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\Plan\Helper;


class Plan extends BaseModel
{
    public $table = 'gs_plan';
    public $primaryKey = 'plan_id';
    public $entity = 'plan';
    protected $searchableColumns = ['plan_name'];

    protected $fillable = ['plan_name',
                           'price',
                           'description',
                           'created_type',
                           'status',
                           'sort_order',];

    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function addPlanIdFilter( $planId = 0 )
    {
        if ( ! empty( $planId ) && $planId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.plan_id', '=', $planId );
        }
        return $this;
    }

    public function getDateById( $planId )
    {
        $return = $this->setSelect()
                       ->addPlanIdFilter( $planId )
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
                       ->pluck( 'plan_name', 'plan_id' );

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
        $planId = 0;
        if ( ! empty( $data['plan_id'] ) && $data['plan_id'] > 0 ) {
            $planId = $data['plan_id'];
        }
        $tableName = $this->getTableName();
        $rules = ['plan_name' => ['required',
                             'unique:' . $tableName . ',plan_name,' . $planId . ',plan_id'],];

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        if ( $planId > 0 ) {

            $plan = self::findOrFail( $data['plan_id'] );
            $plan->update( $data );
            $result['plan_id'] = $plan->plan_id;
        } else {

            $plan = self::create( $data );
            $result['plan_id'] = $plan->plan_id;
        }
        $result['success'] = true;
        $result['message'] = "Plan saved successfully.";
        return $result;
    }
}
