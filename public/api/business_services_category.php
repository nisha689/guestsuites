<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

		$business_service_id = $_POST['business_service_id'];

		$get_service_category_qry = "SELECT * FROM ".DB_PREFIX."service_category WHERE business_service_id = ".$business_service_id." 
		ORDER BY service_category_name ASC";
		
		$get_service_category_res = mysqlQuery($conn,$get_service_category_qry);

		$get_service_category_total = myasqlNumRow($get_service_category_res);
				
		if($get_service_category_total>0){
			
			while($get_row = mysqlFetchArray($get_service_category_res)){

				$data['service_category_id'] = $get_row['service_category_id'];
				$data['service_category_name'] = $get_row['service_category_name'];
				
				$response['service_category'][] = $data;
			}

		}
		
		$response_data['response_code'] = '1';
		$response_data['response_error'] = '';
		$response_data['response_data'] = $response;
		$response_data['response_success'] = '';	
							  
	}
echo json_encode($response_data, JSON_UNESCAPED_SLASHES);
exit;
?>