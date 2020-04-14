<?php

namespace App\Classes\Common;

use App\Classes\Helpers\Helper;
use App\Classes\Helpers\User\Helper as HelperUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Classes\Helpers\Roles\Helper as HelperRoles;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class Common
{

    public function __construct()
    {

    }

    public static function getPaginationBasePath( $searchableData )
    {

        $paginationBasePath = \Request::url() . '?';

        if ( ! empty( $searchableData ) ) {

            foreach ( $searchableData as $key => $value ) {
                if ( ! empty( trim( $value ) ) ) {
                    $paginationBasePath .= $key . "=" . $value . "&";
                }
            }
        }
        return $paginationBasePath;
        //return $paginationBasePath = rtrim( $paginationBasePath, "&" );
    }

    public static function checkEmptyDateTime( $dateTime )
    {
        if ( empty( $dateTime ) || $dateTime != '0000-00-00 00:00:00' ) {
            return false;
        }
        return true;
    }

    public static function getRecordStart( $page = -1, $perPage )
    {
        $recordStart = 0;
        if ( ! empty( $page ) && $page > 1 ) {
            return ($perPage * ($page - 1));
        }
        return $recordStart;
    }

	public static function getDefaultPassword($length = 10)
    {
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789@';

        $password = '';
        $max = strlen($chars) - 1;
        for ($i=0; $i < $length; $i++) {
            $password .= $chars[mt_rand( 0, $max )];
        }
        return $password;
    }

    public static function generatePassword( $password )
    {
        $password = trim( $password );
        if ( empty( $password ) ) {
            return $password;
        }
        return Hash::make( $password );
    }

    public static function isFileExists( $path )
    {
        if ( ! empty( $path ) && file_exists( public_path() . '/' . $path ) ) {
            return true;
        }
        return false;
    }

    public static function getPhoneFormat( $phone )
    {
        return $phone;

        if ( ! empty( $phone ) ) {
            return preg_replace( '/^(\d{3})(\d{3})(\d{4})$/i', '$1-$2-$3', $phone );
        }
        return $phone;
    }

    public static function getMailPhoneFormat( $phone )
    {
        if ( ! empty( $phone ) ) {
            return preg_replace( '/^(\d{3})(\d{3})(\d{4})$/i', '$1-$2-$3', $phone );
        }
        return $phone;
    }

    public static function deleteFile( $filePath )
    {
        if(!empty($filePath)){
            File::delete($filePath);
        }
    }

    public static function setPriceFormat( $price )
    {
        return number_format($price,2);
    }

     public static function fileUpload( $filePath, $file , $width = 200, $height = null)
    {
        $fileName = $file->getClientOriginalName();
        $fileName = strtolower( str_replace( ' ', '-', $fileName ) );
        $fileName = str_replace( '.' . $file->getClientOriginalExtension(), '_' . time().mt_rand() . '.' . $file->getClientOriginalExtension(), $fileName );

        if ( ! File::isDirectory( $filePath ) ) {
            File::makeDirectory( $filePath, 0777, true, true );
        }

//        $file->move( public_path( '/' . $filePath ), $fileName );
		$aspectImage = Image::make( $file )
                                    ->resize( $width, $height, function ( $constraint ) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    } )
                                    ->save( $filePath . '/' . $fileName );

        return $filePath . '/' . $fileName;
    }

	public static function getEncryptId( $string )
    {
        if(empty($string)){ return $string; }
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'secret_key_test';
        $secret_iv = 'secret_iv_test';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $result = base64_encode($output);
        return $result;
    }

    public static function getDecryptId( $string )
    {
        if(empty($string)){ return $string; }
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'secret_key_test';
        $secret_iv = 'secret_iv_test';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $result = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $result;
    }

    public static function sendMailByMailJet($htmlContent,$fromName,$fromEmail='',$subject,$toName,$toEmail){
        
        $_helper = new Helper();
        $mailJetPublicApiKey  = $_helper->getMailJetPublicApiKey();
        $mailJetPrivateApiKey  = $_helper->getMailJetPrivateApiKey();
        if(empty($fromEmail)) { $fromEmail = $_helper->getMailJetEmail(); }
        $mailJetPrivateKey = $mailJetPublicApiKey.':'.$mailJetPrivateApiKey;

        $ch1 = curl_init();
        $data = array();
        $data['Messages'][0]['From']['Email']=$fromEmail;
        $data['Messages'][0]['From']['Name']=$fromName;
        $data['Messages'][0]['To'][0]['Email']=$toEmail;
        $data['Messages'][0]['To'][0]['Name']=$toName;
        $data['Messages'][0]['Subject']=$subject;
        $data['Messages'][0]['HTMLPart']=$htmlContent;

        curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch1, CURLOPT_POST, true);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_URL, "https://api.mailjet.com/v3.1/send");
        curl_setopt($ch1, CURLOPT_POST, true);
        curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($mailJetPrivateKey)
        ));

        $response = curl_exec($ch1);
        return json_decode($response);

    }

    public static function isBusiness( $business )
    {
        $_helperRoles = new HelperRoles();
        $response = true;
        if(empty($business->user_id) || $business->role_id != $_helperRoles->getBusinessRoleId() ){
            $response = false;
        }
        return $response;
    }
    public static function isCustomer( $customer )
    {
        $_helperRoles = new HelperRoles();
        $response = true;
        if(empty($customer->user_id) || $customer->role_id != $_helperRoles->getCustomeRoleId() ){
            $response = false;
        }
        return $response;
    }
    

    public static function convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues )
    {
        $templateFields = trim($templateFields);

        if(!empty($templateFields) && !empty($templateFieldValues) ){
            $templateFieldNameArray = explode(',',$templateFields);
        }
        $templateContent = nl2br($templateContent);
        $templateContent = $templateContent;

        foreach ($templateFieldNameArray as $templateFieldNameKey => $templateFieldName){
            if(!empty($templateFieldValues[$templateFieldName])){
                $value = $templateFieldValues[$templateFieldName];
                $templateContent = str_replace('%'.$templateFieldName.'%',$value,$templateContent);
            }
        }
        return $templateContent;
    }

    public static function setUserSessionForWordPress()
    {
        session_start();
        if ( Auth::guard( 'admin' )->check() ) {

            $_SESSION['user_type'] = 'admin';
            $_SESSION['user_id'] = Auth::guard( 'admin' )->user()->user_id;

        } else if ( Auth::guard( 'school' )->check() ) {

            $_SESSION['user_type'] = 'school';
            $_SESSION['user_id'] = Auth::guard( 'school' )->user()->user_id;

        } else if ( Auth::guard( 'teacher' )->check() ) {

            $_SESSION['user_type'] = 'teacher';
            $_SESSION['user_id'] = Auth::guard( 'teacher' )->user()->user_id;

        }  else {
            if(!empty($_SESSION['user_type'])){ unset($_SESSION['user_type']);}
            if(!empty($_SESSION['user_id'])){ unset($_SESSION['user_id']);}
        }
    }
}
