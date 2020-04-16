<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

		$get_plan_qry = "SELECT * FROM ".DB_PREFIX."plan WHERE status = 1 ORDER BY plan_name ASC";
					
		$get_plan_res = mysqlQuery($conn,$get_plan_qry);

		$get_plan_total = myasqlNumRow($get_plan_res);
				
		if($get_plan_total>0){
			
			while($get_plan_row = mysqlFetchArray($get_plan_res)){

				$plan_data['plan_id'] = $get_plan_row['plan_id'];
				$plan_data['plan_name'] = $get_plan_row['plan_name'];
				$plan_data['price'] = $get_plan_row['price'];
				$plan_data['description'] = $get_plan_row['description'];
				$plan_data['created_type'] = $get_plan_row['created_type'];
				$plan_data['created_at'] = $get_plan_row['created_at'];
				
				$response['plan'][] = $plan_data;
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