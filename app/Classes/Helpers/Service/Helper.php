<?php

namespace App\Classes\Helpers\Service;

use App\Classes\Models\AdminConfiguration\AdminConfiguration;

class Helper
{
	protected $image_path = 'images/service';
    public function __construct(){

        $this->adminConfigurationObj = new AdminConfiguration();
    }

    public function getConfigPerPageRecord()
    {
        $dbConfig = $this->adminConfigurationObj->getValueByKey('default_per_page_record');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.default_per_page_record.value')) :  $dbConfig->value;
    }
	
	public function getImagePath()
    {
        return $this->image_path;
    }
}