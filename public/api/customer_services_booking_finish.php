<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$customer_booked_id = mysqlRealescapestring($conn,$_POST['customer_booked_id']);

	if($customer_booked_id=='' || $customer_booked_id <=0){
	
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Invalid customer booked id!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}else{
		
		$customer_booked_data = [ 'finish_date_time' => get_current_date_time()];
		upd_rec(DB_PREFIX."customer_booked", $customer_booked_data, "customer_booked_id='".$customer_booked_id."'");		

		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data']['customer_booked_id'] = $customer_booked_id;
		$response_data['response_success'] = 'Order finished successfully';
	
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