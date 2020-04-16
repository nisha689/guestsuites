<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');
$response = array();
$response_data = array();

$token = !empty($_POST['token']) ? $_POST['token'] : "";
$check_token = verify_token($token);

if($check_token[0]=='1'){
	
	$user_id = trim($_POST['user_id']);
	$check_user_qry = "SELECT user_id,role_id
					  FROM ".DB_PREFIX."users 
					  WHERE role_id = 2 AND user_id='".$user_id."'";

	$check_user_res = mysqlQuery($conn,$check_user_qry);
	$check_user = myasqlNumRow($check_user_res);
	$check_user_row = mysqlFetchArray($check_user_res);	
	
	if($user_id ==''){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = BLANK_VALIDATION_MSG;
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}elseif(!is_numeric($user_id) || $user_id<=0){
	
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid user id!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}elseif($check_user == 0){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'User not found!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		
	}else{
		
		$update_user_data['fcm_token'] = '';
		$update_user_data['device_type'] = '';
		
		$update_id = upd_rec(DB_PREFIX."users",$update_user_data,"user_id='".$user_id."'");
		
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data'] = array('msg'=>'success');
		$response_data['response_success'] = 'Logout successful.';
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