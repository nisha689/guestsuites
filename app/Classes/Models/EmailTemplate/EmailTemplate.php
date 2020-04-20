<?php

namespace App\Classes\Models\EmailTemplate;

use App\Classes\Common\Common;
use App\Classes\Models\BaseModel;
use App\Classes\Models\User\User;

class EmailTemplate extends BaseModel
{
    protected $table = 'gs_email_template';
    protected $primaryKey = 'email_template_id';
    protected $entity = 'ka_email_template';
    protected $searchableColumns = [];
    protected $fillable = ['subject',
                           'entity',
                           'template_content',
                           'template_fields',];
    protected $_helper;

    public function __construct( array $attributes = [] )
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill( $attributes );
    }

    public function getDateById( $emailTemplateId )
    {
        $return = $this->setSelect()
                       ->addEmailTemplateIdFilter( $emailTemplateId )
                       ->get()
                       ->first();
        return $return;
    }

    public function getDateByEntity( $entity )
    {
        $return = $this->setSelect()
                       ->addEntityFilter( $entity )
                       ->get()
                       ->first();
        return $return;
    }

    public function addEntityFilter( $entity = '' )
    {
        if ( ! empty( $entity ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.entity', '=', $entity );
        }
        return $this;
    }

    public function addEmailTemplateIdFilter( $emailTemplateId = 0 )
    {
        if ( ! empty( $emailTemplateId ) && $emailTemplateId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.email_template_id', '=', $emailTemplateId );
        }
        return $this;
    }

    public function addTemplateNameLikeFilter( $templateName )
    {
        if ( ! empty( $templateName ) ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.template_name', 'like', '%' . $templateName . '%' );
        }
        return $this;
    }

    public function getList( $searchHelper )
    {
        $this->reset();
        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;

        $search = ( ! empty( $searchHelper->_filter['search'] )) ? $searchHelper->_filter['search'] : '';
        $templateName = ( ! empty( $searchHelper->_filter['template_name'] )) ? $searchHelper->_filter['template_name'] : '';

        $list = $this->setSelect()
                     ->addTemplateNameLikeFilter( $templateName )
                     ->addSearch( $search )
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
        $templateName = ( ! empty( $searchHelper->_filter['template_name'] )) ? $searchHelper->_filter['template_name'] : '';

        $count = $this->setSelect()
                      ->addTemplateNameLikeFilter( $templateName )
                      ->addSearch( $search )
                      ->addSortOrder( $searchHelper->_sortOrder )
                      ->addGroupBy( $searchHelper->_groupBy )
                      ->get()
                      ->count();

        return $count;
    }

    public function saveRecord( $data )
    {
        $rules = ['email_template_id' => ['required'],
                  'subject'           => ['required'],
                  'entity'            => ['required']];

        $validationResult = $this->validateData( $rules, $data );
        $emailTemplateId = $data['email_template_id'];
        if ( $validationResult['success'] == false ) {
            $result['success'] = false;
            $result['message'] = $validationResult['message'];
            $result['email_template_id'] = 0;
            return $result;
        }

        if ( $emailTemplateId > 0 ) {
            $emailTemplate = self::findOrFail( $data['email_template_id'] );

            $emailTemplate->update( $data );
            $result['email_template_id'] = $emailTemplate->email_template_id;;

        }
        $result['success'] = true;
        $result['message'] = "Email Template saved successfully.";
        return $result;
    }
}