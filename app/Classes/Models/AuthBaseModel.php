<?php
namespace App\Classes\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Classes\Common\Common;

class AuthBaseModel extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;

    protected $queryBuilder;
    protected $modelObj;
    protected $joinTables=array();
    protected $entity='';
    protected $searchableColumns=[];

    public function reset()
    {
        $this->queryBuilder='';
        return $this;
    }

    public function setSelect(){

        $this->queryBuilder=$this->query();
        return $this;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getSearchableColumns()
    {
        return $this->searchableColumns;
    }

    public function addSearch($search='')
    {
        $search=trim($search);
        $searchKeyword=explode(" ",$search);
        $searchKeywordArray=array();
        if(count($searchKeyword)>0){
            foreach($searchKeyword as $keyword){
                $searchKeywordArray[]=trim($keyword);
            }
            array_unique($searchKeywordArray);
        }

        if(count($searchKeywordArray)>0){

            $this->queryBuilder->where(function($query) use ($searchKeywordArray){
                $i=0;
                foreach($searchKeywordArray as $keyword){ //first table
                    if($i==0){
                        $query->where(function($query) use ($keyword){
                            $j=0;
                            foreach($this->searchableColumns as $column){
                                if($j==0)
                                    $query->where($this->table.'.'.$column, 'like', '%' . $keyword . '%');
                                else
                                    $query->orWhere($this->table.'.'.$column, 'like', '%' . $keyword . '%');
                                $j++;
                            }
                        });
                    }else{
                        $query->orWhere(function($query) use ($keyword){
                            $j=0;
                            foreach($this->searchableColumns as $column){
                                if($j==0)
                                    $query->where($this->table.'.'.$column, 'like', '%' . $keyword . '%');
                                else
                                    $query->orWhere($this->table.'.'.$column, 'like', '%' . $keyword . '%');
                                $j++;
                            }
                        });
                    }
                    $i++;
                }
                if(count($this->joinTables)>0){
                    foreach($this->joinTables as $tableRow){
                        if($tableRow['searchable']){
                            foreach($searchKeywordArray as $keyword){
                                if($i==0){
                                    $query->where(function($query) use ($keyword,$tableRow){
                                        $j=0;
                                        foreach($tableRow['searchableColumns'] as $column){
                                            if($j==0)
                                                $query->where($tableRow['table'].'.'.$column, 'like', '%' . $keyword . '%');
                                            else
                                                $query->orWhere($tableRow['table'].'.'.$column, 'like', '%' . $keyword . '%');
                                            $j++;
                                        }
                                    });
                                }else{
                                    $query->orWhere(function($query) use ($keyword,$tableRow){
                                        $j=0;
                                        foreach($tableRow['searchableColumns'] as $column){
                                            if($j==0)
                                                $query->where($tableRow['table'].'.'.$column, 'like', '%' . $keyword . '%');
                                            else
                                                $query->orWhere($tableRow['table'].'.'.$column, 'like', '%' . $keyword . '%');
                                            $j++;
                                        }
                                    });
                                }
                                $i++;
                            }
                        }
                    }
                }
            });
        }
        return $this;
    }

    public function get( $selectColumns = ['*'] ){

        foreach ($selectColumns as $columnsKey => $columnsValue){
            $selectColumns[$columnsKey] = $this->setFieldNameWithTableName($columnsValue);
        }
        return $this->queryBuilder->get($selectColumns);
    }

    public function sum( $selectColumns ){

        foreach ($selectColumns as $columnsKey => $columnsValue){
            $selectColumns[$columnsKey] = $this->setFieldNameWithTableName($columnsValue);
        }
        return $this->queryBuilder->sum($selectColumns[0]);
    }

    public function addSortOrder( $sortOrderList = [] )
    {
        if ( ! empty( $sortOrderList ) ) {

            foreach ( $sortOrderList as $fieldName => $sortOrder ) {

                $fieldName = $this->setFieldNameWithTableName($fieldName);

                $this->queryBuilder->orderBy( $fieldName, $sortOrder );
            }
        }
        return $this;
    }
    public function setFieldNameWithTableName($fieldName){

        $tableName = $this->getTableName();
        if(!strpos($fieldName,".") > 0){
            return $tableName.'.'.$fieldName;
        }
        return $fieldName;
    }
    public function addGroupBy( $groupByList = [] )
    {
        if ( ! empty( $groupByList ) ) {

            foreach ( $groupByList as $fieldName ) {

                $fieldName = $this->setFieldNameWithTableName($fieldName);

                $this->queryBuilder->groupBy( $fieldName );
            }
        }
        return $this;
    }

    public function addPaging($page = 0,$perPage){

        if($page != -1 || $page != '-1') {
            $limit = (($page > 0) ? ($page - 1) : $page) * $perPage;
            $this->queryBuilder->skip($limit)->take($perPage);
        }

        return $this;
    }

    public function validateData($rules,$data, $messages = [], $attributeNames = [])
    {
        $validator = '';
        $validationResult=array();
        $validationResult['success']=false;
        $validationResult['message']=array();

        $validator = \Validator::make($data, $rules, $messages)
                               ->setAttributeNames( $attributeNames );
        if($validator->passes()){
            $validationResult['success']=true;
            return $validationResult;
        }
        $errors = json_decode($validator->errors());
        $validationResult['success']=false;
        $validationResult['message']=$errors;
        return $validationResult;
    }

    public function preparePagination( $totalRecordCount,$paginationBasePath, $searchHelper ){

        $perPage = ($searchHelper->_perPage == 0) ? $this->_helper->getConfigPerPageRecord() : $searchHelper->_perPage;
        $pageHelper = new \App\Classes\PageHelper( $perPage, 'page' );
        $pageHelper->set_total( $totalRecordCount );
        $pageHelper->page_links( $paginationBasePath );
        return $pageHelper->page_links( $paginationBasePath );
    }

    public function getTableName(){
        return $this->table;
    }

    public function removed( $id ){
        $deleteObj = $this->getDateById( $id );
        if ( ! empty( $deleteObj ) ) {

            /* Delete Image */
            if(!empty($deleteObj->photo)) {
                Common::deleteFile( $deleteObj->photo );
            }
            $delete = $deleteObj->delete();
            return $delete;
        }
        return false;
    }
}
