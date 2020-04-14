<?php

namespace App\Classes\Helpers\Roles;

use App\Classes\Models\AdminConfiguration\AdminConfiguration;

class Helper
{
    protected $adminRoleId = 1;
    protected $businessRoleId = 2;
    protected $customerRoleId = 3;
    
    public function __construct()
    {
        $this->adminConfigurationObj = new AdminConfiguration();
    }

    public function getConfigPerPageRecord()
    {
        $dbConfig = $this->adminConfigurationObj->getValueByKey( 'default_per_page_record' );
        return (empty( $dbConfig )) ? (\Config::get( 'admin-configuration.default_per_page_record.value' )) : $dbConfig->value;
    }

    public function getAdminRoleId()
    {
        return $this->adminRoleId;
    }

    public function getBusinessRoleId()
    {
        return $this->businessRoleId;
    }

    public function getCustomeRoleId()
    {
        return $this->customerRoleId;
    }
  
}