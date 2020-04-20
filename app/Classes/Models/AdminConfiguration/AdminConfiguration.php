<?php
namespace App\Classes\Models\AdminConfiguration;

use App\Classes\Models\BaseModel;

class AdminConfiguration extends BaseModel{

	protected $table = 'gs_configuration';
    protected $primaryKey = 'id';

    protected $fillable = ['id',
						   'key',
						   'value',
						   'label',
						   'group_type',
						   'user_id',
						  ];

	public function addKeyFilter($key){

		$this->queryBuilder->where('key','=',$key);
		return $this;
	}

	public function getValueByKey($key){

	    return $this->setSelect()
		   			  ->addKeyFilter($key)
		   			  ->get(['value'])
		   			  ->first();

  	}
}
