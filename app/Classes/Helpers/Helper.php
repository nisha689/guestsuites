<?php
namespace App\Classes\Helpers;

use App\Classes\Models\AdminConfiguration\AdminConfiguration;

class Helper{

    public function __construct(){

       $this->adminConfigurationObj = new AdminConfiguration();
    }
	public function getConfigPerPageRecord(){

		$per_page=\Config::get('admin-configuration.default_per_page_record.value');
		return $per_page;
	}

    public function getCopyRight(){
		return '&copy; '.date('Y').' Guest suites';		
        /*$dbConfig = $this->adminConfigurationObj->getValueByKey('copyright');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.copyright.value')) :  $dbConfig->value;*/
    }

    public function getFacebookUrl(){

        $dbConfig = $this->adminConfigurationObj->getValueByKey('facebook_url');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.facebook_url.value')) :  $dbConfig->value;
    }

    public function getTwitterUrl(){

        $dbConfig = $this->adminConfigurationObj->getValueByKey('twitter_url');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.twitter_url.value')) :  $dbConfig->value;
    }

    public function getLinkedinUrl(){

        $dbConfig = $this->adminConfigurationObj->getValueByKey('linkedin_url');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.linkedin_url.value')) :  $dbConfig->value;
    }

    public function getPhoneNumber(){
        $dbConfig = $this->adminConfigurationObj->getValueByKey('phone');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.phone.value')) :  $dbConfig->value;
    }

    public function getMailJetPublicApiKey(){
        $dbConfig = $this->adminConfigurationObj->getValueByKey('mail_jet_public_api_key');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.mail_jet_public_api_key.value')) :  $dbConfig->value;
    }
    public function getMailJetPrivateApiKey(){
        $dbConfig = $this->adminConfigurationObj->getValueByKey('mail_jet_private_api_key');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.mail_jet_private_api_key.value')) :  $dbConfig->value;
    }
    public function getMailJetEmail(){
        $dbConfig = $this->adminConfigurationObj->getValueByKey('mail_jet_email');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.mail_jet_email.value')) :  $dbConfig->value;
    }
	
	public function getIosAppUrl(){		
        $dbConfig = $this->adminConfigurationObj->getValueByKey('ios_app_url');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.ios_app_url.value')) :  $dbConfig->value;
    }
	
	public function getAndroidAppUrl(){		
        $dbConfig = $this->adminConfigurationObj->getValueByKey('android_app_url');
        return (empty($dbConfig)) ?  (\Config::get('admin-configuration.android_app_url.value')) :  $dbConfig->value;
    }
}


