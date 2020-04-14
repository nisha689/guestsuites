<?php

namespace App\Classes\Helpers\User;

use App\Classes\Models\AdminConfiguration\AdminConfiguration;
class Helper
{
    protected $image_path = 'images/user';
    protected $status_with_all_option = ['-1' => 'Status',
                                         '1'  => 'Active',
                                         '0'  => 'Inactive'];

    public function __construct(){

        $this->adminConfigurationObj = new AdminConfiguration();
    }

    public function getConfigPerPageRecord()
    {
        $dbConfig = $this->adminConfigurationObj->getValueByKey('default_per_page_record');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.default_per_page_record.value')) :  $dbConfig->value;
    }

    public function getStatusDropDownWithAllOption()
    {
        return $this->status_with_all_option;
    }
    public function getImagePath()
    {
        return $this->image_path;
    }
   
}
