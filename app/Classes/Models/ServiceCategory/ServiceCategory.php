<?php

namespace App\Classes\Models\ServiceCategory;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\ServiceCategory\Helper;
use App\Classes\Models\ServiceCategory\ServiceCategory;
use App\Classes\Helpers\SearchHelper;
use App\Classes\Common\Common;

class ServiceCategory extends BaseModel
{
    protected $table = 'gs_service_category';
    protected $primaryKey = 'service_category_id';
    protected $entity = 'service_category';
    protected $searchableColumns = ['service_category_name'];
    protected $fillable = ['business_service_id','service_category_name'];
    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function getDateById( $serviceCategoryId )
    {
        $return = $this->setSelect()
                       ->addServiceCategoryIdFilter( $serviceCategoryId )
                       ->get()
                       ->first();
        return $return;
    }
    
    public function addBusinessServiceIdFilter( $businessServiceId ){

       if ( ! empty( $businessServiceId ) && $businessServiceId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_service_id', '=', $businessServiceId );
        }
        return $this; 
    }

    public function addServiceCategoryIdFilter( $serviceCategoryId = 0 )
    {
        if ( ! empty( $serviceCategoryId ) && $serviceCategoryId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.business_service_id', '=', $serviceCategoryId );
        }
        return $this;
    }

    public function getDropDown( $prepend = '', $prependId = '' )
    {
        $return = $this->setSelect()
                       ->addSortOrder( ['service_category_name' => 'asc'] )
                       ->get()
                       ->pluck( 'service_category_name', 'business_service_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependId );
        }

        return $return;
    }

    
    public function addBusinessServiceNameLikeFilter( $businessServiceName )
    {
        if ( ! empty( $businessServiceName ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.service_category_name', 'like', '%' . $businessServiceName . '%' );
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
        $businessServiceName = ( ! empty( $searchHelper->_filter['service_category_name'] )) ? $searchHelper->_filter['service_category_name'] : '';
        $businessServiceId = ( ! empty( $searchHelper->_filter['business_service_id'] )) ? $searchHelper->_filter['business_service_id'] : '';
    
        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addBusinessServiceIdFilter( $businessServiceId )
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
        $businessServiceName = ( ! empty( $searchHelper->_filter['service_category_name'] )) ? $searchHelper->_filter['service_category_name'] : '';
        
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
        $serviceCategoryId = 0;
        $tableName = $this->getTableName();
        $rules = ['service_category_name'      => ['required',
                                                    'unique:' . $tableName]];
        
        if ( ! empty( $data['business_service_id'] ) && $data['business_service_id'] > 0 ) {
            $serviceCategoryId = $data['business_service_id'];
            $rules['service_category_name'] = 'required|unique:' . $tableName . ',service_category_name,' . $serviceCategoryId . ',business_service_id';
        
        }

        $validationResult = $this->validateData( $rules, $data );

		$filePath = $this->_helper->getImagePath(); 
		
        if ( ! empty( $data['business_service_icon'] ) ) {
            $data['business_service_icon'] = Common::fileUpload( $filePath, $data['business_service_icon'], '', 256 );
        }		
		
        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        if ( $serviceCategoryId > 0 ) {
            $classes = self::findOrFail( $data['business_service_id'] );
			
			/* Delete Image */
            if ( ! empty( $data['business_service_icon'] ) ) {
                Common::deleteFile( $classes->business_service_icon );
            }
			
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
