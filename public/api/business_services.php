<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

		$get_business_services_qry = "SELECT * FROM ".DB_PREFIX."business_services ORDER BY business_service_name ASC";
					
		$get_business_services_res = mysqlQuery($conn,$get_business_services_qry);

		$get_business_services_total = myasqlNumRow($get_business_services_res);
				
		if($get_business_services_total>0){
			
			while($get_business_services_row = mysqlFetchArray($get_business_services_res)){

				$business_services_data['business_service_id'] = $get_business_services_row['business_service_id'];
				$business_services_data['business_service_name'] = $get_business_services_row['business_service_name'];
				
				$response['business_service'][] = $business_services_data;
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