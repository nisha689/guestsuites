<?php
header('Content-type: application/json; charset=UTF-8;');

include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();


$token = $_POST['token'];

$check_token = verify_token($token);

if($check_token[0]=='1'){


	$email = mysqlRealescapestring($conn,$_POST['email']);

	$password = mysqlRealescapestring($conn,$_POST['password']);

	$fcm_token = mysqlRealescapestring($conn,$_POST['fcm_token']);

	$device_type = mysqlRealescapestring($conn,$_POST['device_type']);

	
	$check_qry_var = "SELECT *

					  FROM ".DB_PREFIX."users 

					  WHERE role_id = 2 AND email='".$email."'";

	$check_qry = mysqlQuery($conn,$check_qry_var);

	$check_row = myasqlNumRow($check_qry);

	$get_data = mysqlFetchArray($check_qry);

	$check_role =  $get_data['role_id'];

	// check password

	$userEnterPassword = $password;

	$laravelDBPassword = $get_data['password'];

	$check_password = "correct";

		
	if(password_verify($userEnterPassword,$laravelDBPassword)){

    	$check_password = "correct";

	}else{

		$check_password = "not_correct";

	}	
	

	if($email=='' || $password==''){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = BLANK_VALIDATION_MSG;

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

	

	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){


		$response_data['response_code'] = '0';

		$response_data['response_error'] = "Invalid email address!";

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';


	
	}else if($check_row=='0' || $check_password=='not_correct'){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = 'Sorry either your email or password is incorrect, please try again!';

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

		

	}else if($get_data['status']=='0'){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = "Your profile is not active, Please contact administrator.";

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

	}

	/*else if(trim($fcm_token)==''){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = "Please enter valid fcm token.";

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

	}*/

	else if(trim($fcm_token)!='' && $device_type==''){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = "Please enter device type.";

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

	}

	else if(($device_type!='') && ($device_type!='android' && $device_type!='ios')){

		$response_data['response_code'] = '0';

		$response_data['response_error'] = "Please enter valid device type.";

		$response_data['response_data'] = array();

		$response_data['response_success'] = '';

	}

	else{

		// update last login

		$update_login_data['last_login_date'] = get_current_date_time();

		if($fcm_token!=''){

			$update_login_data['fcm_token'] = trim($fcm_token);

			$update_login_data['device_type'] = trim($device_type);

		}

		$update_id = upd_rec(DB_PREFIX."users",$update_login_data,"user_id='".$get_data['user_id']."'");

		$user_data['user_id'] = $get_data['user_id'];
		$user_data['first_name'] = $get_data['first_name'];
		$user_data['last_name'] = $get_data['last_name'];
		$user_data['company_name'] = $get_data['company_name'];
		$user_data['email'] = $get_data['email'];
		$user_data['phone'] = $get_data['phone'];
		$user_data['address'] = $get_data['address'];
		$user_data['country_id'] = $get_data['country_id'];
		$user_data['state_id'] = $get_data['state_id'];
		$user_data['city_id'] = $get_data['city_id'];
		$user_data['zipcode'] = $get_data['zipcode'];
		$user_data['role_id'] = $get_data['role_id'];
		$user_data['last_login_date'] = $get_data['last_login_date'];
		$user_data['business_service_id'] = $get_data['business_service_id'];
		$user_data['plan_id'] = $get_data['plan_id'];
		$user_data['status'] = $get_data['status'];

		$user_data['photo'] = SITEURL."images/profile-default.png";

		if(!empty($get_data['photo'])){

			$user_data['photo'] = SITEURL."".$get_data['photo'];
		}

		$response_data['response_code'] = '1';

		$response_data['response_error'] = "";

		$response_data['response_data'] = $user_data;

		$response_data['response_success'] = 'Login successful.';

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