<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$user_id = mysqlRealescapestring($conn,$_POST['user_id']);
	$first_name = mysqlRealescapestring($conn, $_POST['first_name']);
	$last_name = mysqlRealescapestring($conn, $_POST['last_name']);
	$company_name = mysqlRealescapestring($conn, $_POST['company_name']);
	$email = mysqlRealescapestring($conn, $_POST['email']);
	$phone = mysqlRealescapestring($conn, $_POST['phone']);
	$address = mysqlRealescapestring($conn, $_POST['address']);
	$country_id = mysqlRealescapestring($conn, $_POST['country_id']);
	$state_id = mysqlRealescapestring($conn, $_POST['state_id']);
	$city_id = mysqlRealescapestring($conn, $_POST['city_id']);
	$zipcode = mysqlRealescapestring($conn, $_POST['zipcode']);
	$imgbase64 = $_POST['photo'];
	
	// check email is exists or not
	$check_qry_var = "SELECT email FROM ".DB_PREFIX."users WHERE email='".$email."' AND user_id !='".$user_id."'";
	$check_qry = mysqlQuery($conn, $check_qry_var);
	$check_duplicate = myasqlNumRow($check_qry);
	
	//check state
	$check_state_qry = "SELECT state_id FROM ".DB_PREFIX."state WHERE state_id='".$state_id."'";
	$check_state_res = mysqlQuery($conn,$check_state_qry);
	$total_check_state_row = myasqlNumRow($check_state_res);
	
	if ($user_id == '' || $first_name == '' || $last_name == '' || $email == '' || $phone=='' || $address =='' || $state_id =='' || $city_id =='') {
		$response_data['response_code'] = '0';
		$response_data['response_error'] = BLANK_VALIDATION_MSG;
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		$response = $response_data;
	}
	else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $first_name)){
	
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "First name should not allow any special characters!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $last_name)){
		
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Last name should not allow any special characters!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid email address!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}/*
	else if(!preg_match('/((^\+?234(\d{7,10}))|(^234(\d{7,10}))|(^0+234(\d{7,10})))$/', $phone)) {
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid phone number!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}*/
	elseif ($check_duplicate > 0) {

		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Sorry, we already have an account with that email!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	elseif ($total_check_state_row == 0) {

		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Sorry, there is no state for this id!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}  
	else{
		
		if ($imgbase64 != '') {
			// convert the image data from base64
			$imgData = base64_decode($imgbase64);
			// set the image paths
			$filename = (date('Ymdgisu')) . '.jpg';
			$file = USER_IMAGE_PATH . $filename;
			// write the imgData to the file
			$fp = fopen($file, 'w');
			fwrite($fp, $imgData);
			fclose($fp);
			$image = $filename;
			
			$user_data['photo'] = 'images/user/'.$image;
			
			// unlink old image
			$get_user_details_qry_var = "SELECT photo FROM ".DB_PREFIX."users WHERE user_id='".$user_id."'";
			$get_user_details_qry = mysqlQuery($conn,$get_user_details_qry_var);
			$get_user_details_row = mysqlFetchArray($get_user_details_qry);
			unlink(SITEURL.$get_user_details_row['photo']);
		}
		
		$user_data['first_name'] = $first_name;
		$user_data['last_name'] = $last_name;
		$user_data['company_name'] = $company_name;
		$user_data['email'] = $email;
		$user_data['phone'] = $phone;
		$user_data['address'] = $address;
		$user_data['country_id'] = $country_id;
		$user_data['state_id'] = $state_id;
		$user_data['state_id'] = $state_id;
		$user_data['city_id'] = $city_id;
		$user_data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$user_data['updated_at'] = get_current_date_time();
		
		$update_id = upd_rec(DB_PREFIX."users", $user_data, "user_id='".$user_id."'");
		
		$display_user_data_qry_var = "SELECT *
									  FROM ".DB_PREFIX."users WHERE user_id='".$user_id."'";
									  
		$display_user_data_qry = mysqlQuery($conn,$display_user_data_qry_var);
		$display_user_data_row = mysqlFetchArray($display_user_data_qry);
		
		$display_user_data['first_name'] = $display_user_data_row['first_name'];
		$display_user_data['last_name'] = $display_user_data_row['last_name'];
		$display_user_data['company_name'] = $display_user_data_row['company_name'];
		$display_user_data['email'] = $display_user_data_row['email'];
		$display_user_data['phone'] = $display_user_data_row['phone'];
		$display_user_data['address'] = $display_user_data_row['address'];
		$display_user_data['state_id'] = $state_id;
		$display_user_data['city_id'] = $city_id;
		$display_user_data['country_id'] = $country_id;
		$display_user_data['ip_address'] = $display_user_data_row['ip_address'];
		$display_user_data['zipcode'] = $display_user_data_row['zipcode'];
		$display_user_data['business_service_id'] = $display_user_data_row['business_service_id'];
		$display_user_data['photo'] = $display_user_data_row['photo']!=""?SITEURL.$display_user_data_row['photo']:"";
				
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data'] = $display_user_data;
		$response_data['response_success'] = 'Profile has been updated successfully.';
	}
}else{
	$response_data['response_code'] = '0';
	$response_data['response_error'] = $check_token[1];
	$response_data['response_data'] = array();
	$response_data['response_success'] = '';
}

echo json_encode($response_data, JSON_UNESCAPED_SLASHES);
exit;

?>