<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$token = $_POST['token'];

$check_token = verify_token($token);

if($check_token[0]=='1'){

	$code = strtolower( mysqlRealescapestring($conn,$_POST['code']) );

	if( empty($code) ){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Code is required';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}else{
		$select_qry_var = "SELECT * FROM ".DB_PREFIX."discounts WHERE LOWER(code)='".$code."'";
						   
		$select_qry = mysqlQuery($conn,$select_qry_var);
		$select_row = mysqlFetchArray($select_qry);
		
		if(myasqlNumRow($select_qry)>0){

			$discounts_id = $select_row['discounts_id'];
			
			$code_data['discounts_id'] = $select_row['discounts_id'];
			$code_data['validity_date'] = $select_row['validity_date'];
			$code_data['code'] = $select_row['code'];
			$code_data['discounts_type'] = $select_row['discounts_type'];
			$code_data['percent'] = $select_row['percent'];
			$code_data['fixed_amount'] = $select_row['address'];
			
			$response_data['response_data'] = $code_data;
			
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