<?php

namespace App\Classes\Models\Service;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\Service\Helper;
use App\Classes\Helpers\SearchHelper;
use App\Classes\Models\User\User;

class Service extends BaseModel
{
    protected $table = 'gs_business_services';
    protected $primaryKey = 'business_service_id';
    protected $entity = 'business_services';
    protected $searchableColumns = ['business_service_name'];
    protected $fillable = ['business_service_name'];
    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function getDateById( $businessServiceId )
    {
        $return = $this->setSelect()
                       ->addBusinessServiceIdFilter( $businessServiceId )
                       ->get()
                       ->first();
        return $return;
    }

    public function addBusinessServiceIdFilter( $businessServiceId = 0 )
    {
        if ( ! empty( $businessServiceId ) && $businessServiceId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_service_id', '=', $businessServiceId );
        }
        return $this;
    }

    public function getDropDown( $prepend = '', $prependId = '' )
    {
        $return = $this->setSelect()
                       ->addSortOrder( ['business_service_name' => 'asc'] )
                       ->get()
                       ->pluck( 'business_service_name', 'business_service_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependId );
        }

        return $return;
    }

    
    public function addBusinessServiceNameLikeFilter( $businessServiceName )
    {
        if ( ! empty( $businessServiceName ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_service_name', 'like', '%' . $businessServiceName . '%' );
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

    

    public function getList( $searchHelper )
    {
        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;
        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $signUpStartDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $signUpEndDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $businessServiceName = ( ! empty( $searchHelper->_filter['business_service_name'] )) ? $searchHelper->_filter['business_service_name'] : '';
    
        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addBusinessServiceNameLikeFilter( $businessServiceName )
                     ->addCreatedDateFilter( $signUpStartDate, $signUpEndDate )
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
        $signUpStartDate = ( ! empty( $searchHelper->_filter['created_start_date'] )) ? $searchHelper->_filter['created_start_date'] : '';
        $signUpEndDate = ( ! empty( $searchHelper->_filter['created_end_date'] )) ? $searchHelper->_filter['created_end_date'] : '';
        $businessServiceName = ( ! empty( $searchHelper->_filter['business_service_name'] )) ? $searchHelper->_filter['business_service_name'] : '';
        
        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addBusinessServiceNameLikeFilter( $businessServiceName )
                      ->addCreatedDateFilter( $signUpStartDate, $signUpEndDate )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $businessServiceId = 0;
        $tableName = $this->getTableName();
        $rules = ['business_service_name'      => ['required',
                                                    'unique:' . $tableName]];
        
        if ( ! empty( $data['business_service_id'] ) && $data['business_service_id'] > 0 ) {
            $businessServiceId = $data['business_service_id'];
            $rules['business_service_name'] = 'required|unique:' . $tableName . ',business_service_name,' . $businessServiceId . ',business_service_id';
        
        }

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        if ( $businessServiceId > 0 ) {
            $classes = self::findOrFail( $data['business_service_id'] );
            $classes->update( $data );
            $result['business_service_id'] = $classes->business_service_id;
        } else {
            $classes = self::create( $data );
            $result['business_service_id'] = $classes->business_service_id;
        }
        $result['success'] = true;
        $result['message'] = "Service saved successfully.";
        return $result;
    }
}
