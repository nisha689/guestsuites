<?php

namespace App\Classes\Models\City;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;

class City extends BaseModel
{
    public $table = 'gs_city';
    public $primaryKey = 'city_id';
    public $entity = 'city';
    protected $searchableColumns = ['city_name'];

    protected $fillable = ['city_name',
                           'state_id',];

    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function addCityIdFilter( $cityId = -1 )
    {
        if ( ! empty( $cityId ) && $cityId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.city_id', '=', $cityId );
        }
        return $this;
    }

    public function addStateIdFilter( $stateId = -1 )
    {
        if ( ! empty( $stateId ) && $stateId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.state_id', '=', $stateId );
        }
        return $this;
    }

    public function getDateById( $stateId )
    {

        $return = $this->setSelect()
                       ->addCityIdFilter( $stateId )
                       ->get()
                       ->first();
        return $return;
    }

    public function getDropDown( $prepend = '', $prependKey = 0, $stateId = 0 )
    {
        $return = $this->setSelect()
                       ->addStateIdFilter( $stateId )
                       ->addSortOrder( ['city_name' => 'asc'] )
                       ->get()
                       ->pluck( 'city_name', 'city_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependKey );
        }
        return $return;
    }

    public function addCityNameLikeFilter( $cityName = '' )
    {
        if ( ! empty( trim( $cityName ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.city_name', 'like', '%' . $cityName . '%' );
        }
        return $this;
    }

    public function getCityDropDownByStateId( $stateId ,$prepend = '', $prependKey = 0 )
    {
        $return = $this->setSelect()
                       ->addSortOrder( ['city_name' => 'asc'] )
                       ->addCityIdFilter( $stateId )
                       ->get()
                       ->pluck( 'city_name', 'city_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependKey );
        }
        return $return;
    }


    public function getList( $searchHelper )
    {

        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $cityName = ( ! empty( $searchHelper->_filter['city_name'] )) ? $searchHelper->_filter['city_name'] : '';

        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addCityNameLikeFilter( $cityName )
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
        $cityName = ( ! empty( $searchHelper->_filter['city_name'] )) ? $searchHelper->_filter['city_name'] : '';

        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addCityNameLikeFilter( $cityName )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $tableName = $this->getTableName();
        $rules = ['city_name' => ['required',
                                  'string',
                                  'max:191']];
        $cityId = 0;
        if ( isset( $data['city_id'] ) && $data['city_id'] != '' && $data['city_id'] > 0 ) {
            $cityId = $data['city_id'];
        }

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['city_id'] = 0;
            return $result;
        }


        if ( $cityId > 0 ) {
            $city = self::findOrFail( $cityId );
            $city->update( $data );
            $result['city_id'] = $city->city_id;
        } else {
            $city = self::create( $data );
            $result['city_id'] = $city->city_id;
        }

        $result['success'] = true;
        $result['message'] = "city saved successfully.";
        return $result;
    }
}