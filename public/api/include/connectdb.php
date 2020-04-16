<?php
error_reporting(E_ALL);
//error_reporting(0);
header("Access-Control-Allow-Origin: *");
//...........Database Constants.................

define("HOST", "localhost");

define("DATABASE", "guest_suites");

define("USER", "root");

define("PASSWORD", "");

//..........database connection............

function mysqlConncet() {
	return $db = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
}

function mysqlQuery($connection, $query) {
	return $query_res = mysqli_query($connection, $query);
}

function myasqlNumRow($result) {
	return $res_row = mysqli_num_rows($result);
}

function mysqlFetchArray($array_res) {
	return $res_array = mysqli_fetch_array($array_res);
}

function mysqlLastId($connection) {
	return mysqli_insert_id($connection);
}

function mysqlRealescapestring($connection, $value) {
	return mysqli_real_escape_string($connection, $value);
}

$conn = mysqlConncet();
define("DB_PREFIX", "gs_");

//get configuration data query
$configuration_qry = "SELECT `id`,`key`,`value`,`label`,`user_id` FROM ".DB_PREFIX."configuration"; 
$configuration_res = mysqlQuery($conn,$configuration_qry);
$total_configuration = myasqlNumRow($configuration_res);
if($total_configuration > 0){
	$config_array = array();
	while($configuration_row = mysqlFetchArray($configuration_res)){
		$config_array[$configuration_row['key']] = $configuration_row['value'];
	}
}


/*define("ADMINMAIL", "webzdeveloper272@gmail.com");*/
define("FROMMAIL", "cwiser904@gmail.com");
/*define("FROMMAIL", "websposure2017@gmail.com");*/
define("SITENAME", "Guest Suites");
define("SITEURL", "http://127.0.0.1/guestsuites/trunk/public/api/");
define ("EMAIL_TEMPLATE_HEADER_IMAGE_URL",SITEURL."images/emailtop.png");
define ("EMAIL_TEMPLATE_FOOTER_IMAGE_URL",SITEURL."images/emailbottom.png");
define ("EMAIL_TEMPLATE_FACEBOOK_IMAGE_URL",SITEURL."images/facebook-icon.png");
define ("EMAIL_TEMPLATE_TWITTER_IMAGE_URL",SITEURL."images/twitter-icon.png");
define ("EMAIL_TEMPLATE_FACEBOOK_URL",$config_array['facebook_url']);
define ("EMAIL_TEMPLATE_TWITTER_URL",$config_array['twitter_url']);
define("ADMINMAIL", $config_array['admin_email']);

//define("USER_IMAGE_PATH", $_SERVER['DOCUMENT_ROOT'] . '/api/images/user_images/');
define("USER_IMAGE_PATH", $_SERVER['DOCUMENT_ROOT'] . '/images/user/');
define("USER_IMAGE_URL", "http://127.0.0.1/guestsuites/trunk/public/images/user/");
define("MSG_ATTACHMENT_PATH", $_SERVER['DOCUMENT_ROOT'] . '/images/message_attachment/');
define("DISCUSSION_ATTACHMENT_PATH", $_SERVER['DOCUMENT_ROOT'] . '/images/discussion_attachment/');
define("BLANK_VALIDATION_MSG","Please fill in all the required fields in the form above.");
define("APPSERVERKEY",$config_array['app_server_key']);

?>
