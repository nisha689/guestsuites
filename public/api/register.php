<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$first_name = mysqlRealescapestring($conn,$_POST['first_name']);
	$last_name = mysqlRealescapestring($conn,$_POST['last_name']);
	$email = mysqlRealescapestring($conn,$_POST['email']);
	$social_type = !empty($_POST['social_type']) ? mysqlRealescapestring($conn,$_POST['social_type']) : NULL;
	$password = NULL;
	$confirm_password = NULL;
	
	if($social_type > 0){
		$char_count = 10;
	}else{
		$password = mysqlRealescapestring($conn,$_POST['password']);
		$confirm_password = mysqlRealescapestring($conn,$_POST['confirm_password']);
		$char_count = strlen($password);
	}
	$role_id = mysqlRealescapestring($conn,$_POST['role_id']);
	
	// check email is exists or not
	$check_qry_var = "SELECT email FROM ".DB_PREFIX."users WHERE email='".$email."'";
	$check_qry = mysqlQuery($conn,$check_qry_var);
	$check_duplicate = myasqlNumRow($check_qry);
	
	// check role is valid or not
	$check_role_qry_var = "SELECT role_id FROM ".DB_PREFIX."roles WHERE role_id='".$role_id."'";
	$check_role_qry = mysqlQuery($conn,$check_role_qry_var);
	$check_role = myasqlNumRow($check_role_qry);
	
	if($first_name == '' || $last_name == '' || $email == '' || $role_id==''){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = BLANK_VALIDATION_MSG;
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		$response = $response_data;
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid email address!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
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
	elseif($check_duplicate > 0){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Sorry, we already have an account with that email!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		$response = $response_data;
	
	}elseif($char_count < 7){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Please enter at least 7 characters for your password!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}elseif($password == '' && !($social_type > 0)){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Please enter password";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	elseif($password!=$confirm_password){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Password and confirm password is not same!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}else{
		
		$user_data['first_name'] = ucfirst($first_name);
		$user_data['last_name'] = ucfirst($last_name);
		$user_data['email'] = $email;
		if(! $social_type > 0){
			$user_data['password'] = PasswordGenerator($password);
		}
		$user_data['email_verified_at'] = get_current_date_time();
		$user_data['created_at'] = get_current_date_time();
		$user_data['role_id'] = $role_id;
		$user_data['created_type'] = 'App';
		$user_data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$user_data['status'] = '1';
		$user_data['social_type'] = $social_type;
		
		$last_id = ins_rec(DB_PREFIX."users",$user_data);
				
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data']['user_id'] = $last_id;
		$response_data['response_success'] = 'You have signed up successfully.';
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