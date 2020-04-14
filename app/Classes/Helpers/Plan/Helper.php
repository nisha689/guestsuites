<?php

namespace App\Classes\Helpers\Plan;

use App\Classes\Models\AdminConfiguration\AdminConfiguration;

class Helper
{
    protected $basicPlanId = 1;
    protected $premiumPlanId = 2;
    protected $goldPlanId = 3;
    

    public function __construct(){

        $this->adminConfigurationObj = new AdminConfiguration();
    }

    public function getConfigPerPageRecord()
    {
        $dbConfig = $this->adminConfigurationObj->getValueByKey('default_per_page_record');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.default_per_page_record.value')) :  $dbConfig->value;
    }

    public function getPremiumPlanId()
    {
        return $this->premiumPlanId;
    }

    public function getBasePlanId()
    {
        return $this->basePlanId;
    }

    public function getGoldPlanId()
    {
        return $this->goldPlanId;
    }
}