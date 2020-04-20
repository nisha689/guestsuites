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

    public function setValidityDateAttribute( $value )
    {
        $this->attributes['validity_date'] = ! empty( $value ) ? date( "Y-m-d", strtotime( $value ) ) : null;
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

    public function getDropDown( $prepend = '', $prependKey = "" )
    {
        $return = $this->setSelect()
                       ->addStatusFilter( $status )
                       ->addSortOrder( ['code' => 'asc'] )
                       ->get()
                       ->pluck( 'code', 'discounts_id' );

        if ( ! empty( $prepend ) ) {
            $return->prepend( $prepend, $prependKey );
        }
        return $return;
    }

    public function addCodeLikeFilter( $code = '' )
    {
        if ( ! empty( trim( $code ) ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.code', 'like', '%' . $code . '%' );
        }
        return $this;
    }

    public function getList( $searchHelper )
    {

        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $code = ( ! empty( $searchHelper->_filter['code'] )) ? $searchHelper->_filter['code'] : '';
        
        $list = $this->setSelect()
                     ->addSearch( $search )
                     ->addCodeLikeFilter( $code )
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
        $code = ( ! empty( $searchHelper->_filter['code'] )) ? $searchHelper->_filter['code'] : '';
        
        $count = $this->setSelect()
                      ->addSearch( $search )
                      ->addCodeLikeFilter( $code )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $tableName = $this->getTableName();
        $discountId = 0;
        $rules = ['code'      => ['required','unique:' . $tableName],
                  'validity_date'      => ['required'],
                  'percent'      => ['required_without:fixed_amount'],
                  'fixed_amount'      => ['required_without:percent']
                ];

        if ( ! empty( $data['discounts_id'] ) && $data['discounts_id'] > 0 ) {
            $discountId = $data['discounts_id'];
            $rules['code'] = 'required|unique:' . $tableName . ',code,' . $discountId . ',discounts_id';
        }
                
        $validationResult = $this->validateData( $rules, $data );

        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            return $result;
        }

        if(!empty($data['fixed_amount']) && $data['fixed_amount'] > 0){
          $data['discounts_type'] = 2;
        }else{
          $data['discounts_type'] = 1;
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
        $result['message'] = "Discount saved successfully.";
        return $result;
    }
}
