<?php
namespace App\Classes\Models\Country;
use App\Classes\Models\BaseModel;
use DB;

class Country extends BaseModel
{
    protected $table = 'gs_country';
    protected $primaryKey = 'country_id';
    protected $entity='country';
	protected $searchableColumns=['country_name'];
	protected $fillable = ['country_name'];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
    }

    public function getDropDown($prepend ='', $prependId = 0)
    {
        $return = $this->setSelect()
                    ->addSortOrder( ['country_id' => 'asc'] )
                    ->get()
                    ->pluck( 'country_name', 'country_id' );

        if(!empty($prepend)){

            $return->prepend( $prepend, $prependId );
        }

        return $return;
   }
   
   public function getDateById( $countryId ) {
        $return = $this->setSelect()
                       ->addCountryIdFilter( $countryId )
                       ->get()
                       ->first();
        return $return;
    }
	
	public function addCountryIdFilter( $countryId = 0 )
    {
        if ( ! empty( $countryId ) && $countryId > 0 ) {
            $tableName = $this->getTableName();
            $this->queryBuilder->where( $tableName . '.country_id', '=', $countryId );
        }
        return $this;
    }
}