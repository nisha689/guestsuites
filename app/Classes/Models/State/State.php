<?php

namespace App\Classes\Models\State;

use App\Classes\Models\BaseModel;
use App\Classes\Helpers\User\Helper;
use App\Classes\Common\Common;

class State extends BaseModel
{
    public $table = 'gs_state';
    public $primaryKey = 'state_id';
    public $entity = 'state';
    protected $searchableColumns = ['state_name',
                                    'country_id'];

    protected $fillable = ['state_name',
                           'country_id'];

    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
        $this->_helper = new Helper();
    }

    public function addStateIdFilter( $stateId = -1 )
    {
        if ( ! empty( $stateId ) && $stateId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.state_id', '=', $stateId );
        }
        return $this;
    }

    public function addCountryIdFilter( $countryId = -1 )
    {
        if ( ! empty( $countryId ) && $countryId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.country_id', '=', $countryId );
        }
        return $this;
    }

    public function getDateById( $stateId )
    {

        $return = $this->setSelect()
                       ->addStateIdFilter( $stateId )
                       ->get()
                       ->first();
        return $return;
    }

    public function getDropDown( $prepend = '', $prependKey = 0, $countryId = 0 )
    {
        $return = $this->setSelect()
                       ->addCountryIdFilter( $countryId )
                       ->addSortOrder( ['state_name' => 'asc'] )
                       ->get()
                       ->pluck( 'state_name', 'state_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependKey );
        }
        return $return;
    }

    public function addStateNameLikeFilter( $stateName = '' )
    {
        if ( ! empty( trim( $stateName ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.state_name', 'like', '%' . $stateName . '%' );
        }
        return $this;
    }

    public function getList( $searchHelper )
    {
        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $stateName = ( ! empty( $searchHelper->_filter['state_name'] )) ? $searchHelper->_filter['state_name'] : '';

        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addStateNameLikeFilter( $stateName )
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
        $stateName = ( ! empty( $searchHelper->_filter['state_name'] )) ? $searchHelper->_filter['state_name'] : '';

        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addStateNameLikeFilter( $stateName )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $tableName = $this->getTableName();
        $rules = ['state_name' => ['required',
                                   'string',
                                   'max:191']];
        $stateId = 0;
        if ( isset( $data['state_id'] ) && $data['state_id'] != '' && $data['state_id'] > 0 ) {
            $stateId = $data['state_id'];
        }

        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['state_id'] = 0;
            return $result;
        }


        if ( $stateId > 0 ) {
            $state = self::findOrFail( $stateId );
            $state->update( $data );
            $result['state_id'] = $state->state_id;

        } else {
            $state = self::create( $data );
            $result['state_id'] = $state->state_id;
        }

        $result['success'] = true;
        $result['message'] = "state saved successfully.";
        return $result;
    }
}