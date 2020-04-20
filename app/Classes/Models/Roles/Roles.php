<?php
namespace App\Classes\Models\Roles;
use App\Classes\Helpers\Roles\Helper;
use App\Classes\Models\BaseModel;
use DB;

class Roles extends BaseModel
{
    protected $table = 'gs_roles';
    protected $primaryKey = 'role_id';
    protected $entity='roles';
	protected $searchableColumns=['role_name'];
		
	protected $fillable = ['role_id', 'role_name'];
	protected $_helper;

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getDropDown($prepend ='')
    {
        $return = $this->setSelect()
                    ->addSortOrder( ['role_name' => 'asc'] )
                    ->get()
                    ->pluck( 'role_name', 'role_id' );

        if(!empty($prepend)){
            $return->prepend( $prepend, 0 );
        }
        return $return;
    }
}
