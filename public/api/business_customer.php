<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$token = $_POST['token'];

$check_token = verify_token($token);

if($check_token[0]=='1'){
	
	$business_id = mysqlRealescapestring($conn,$_POST['business_id']) ;

	if( empty($business_id) ){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Business id is required';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}else{
		
		
		$select_qry_var = "SELECT * FROM ".DB_PREFIX."users WHERE role_id = 3 AND business_id =".$business_id; 
		if(!empty($_POST['email'])){
			$email = mysqlRealescapestring($conn,$_POST['email']);	
			$select_qry_var .= " AND email=".$email; 
		}

		if(!empty($_POST['phone'])){
			$phone = mysqlRealescapestring($conn,$_POST['phone']);	
			$select_qry_var .= " AND phone=".$phone; 
		}
		
		if(!empty($_POST['name'])){
			$name = strtolower(mysqlRealescapestring($conn,$_POST['name']));	
			$select_qry_var .= " AND LOWER( CONCAT(first_name,' ',last_name) ) LIKE '%".$name."%'"; 
		}
					   
		$select_qry = mysqlQuery($conn,$select_qry_var);

		$get_plan_total = myasqlNumRow($select_qry);
		
		
		if($get_plan_total > 0){

			while($select_row = mysqlFetchArray($select_qry)){

				$user_data['user_id'] = $select_row['user_id'];
				$user_data['first_name'] = $select_row['first_name'];
				$user_data['last_name'] = $select_row['last_name'];
				$user_data['company_name'] = $select_row['company_name'];
				$user_data['email'] = $select_row['email'];
				$user_data['phone'] = $select_row['phone'];
				$user_data['address'] = $select_row['address'];
				$user_data['country_id'] = $select_row['country_id'];
				$user_data['state_id'] = $select_row['state_id'];
				$user_data['city_id'] = $select_row['city_id'];
				$user_data['zipcode'] = $select_row['zipcode'];
				$user_data['role_id'] = $select_row['role_id'];
				$user_data['last_login_date'] = $select_row['last_login_date'];
				$user_data['business_service_id'] = $select_row['business_service_id'];
				$user_data['plan_id'] = $select_row['plan_id'];
				$user_data['status'] = $select_row['status'];

				$user_data['photo'] = SITEURL."images/profile-default.png";

				if(!empty($select_row['photo'])){

					$user_data['photo'] = SITEURL."".$user_data['photo'];
				}	

				$response['user'][] = $user_data;
			}
			
			$response_data['response_data'] = $response;
			
		}else{
			$response_data['response_data'] = array();
		}
		
		$response_data['response_code'] = '1';
		$response_data['response_error'] = '';
		$response_data['response_success'] = 'success';
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