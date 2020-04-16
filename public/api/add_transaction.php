<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$transaction_id = mysqlRealescapestring($conn,$_POST['transaction_id']);
	$payment_method = mysqlRealescapestring($conn,$_POST['payment_method']);
	$amount = mysqlRealescapestring($conn,$_POST['amount']);
	$net_amount = mysqlRealescapestring($conn,$_POST['net_amount']);
	$user_id = mysqlRealescapestring($conn,$_POST['user_id']);
	$status = mysqlRealescapestring($conn,$_POST['status']);
	
	if($transaction_id == '' || $payment_method == '' || $amount == '' || $net_amount=='' || $user_id=='' || $status==''){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = BLANK_VALIDATION_MSG;
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		$response = $response_data;
	}
	elseif($payment_method != 1 && $payment_method != 2){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid payment method!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}else{
		
		$transaction_data['transaction_id'] = $transaction_id;
		$transaction_data['payment_method'] = $payment_method;
		$transaction_data['amount'] = $amount;
		$transaction_data['net_amount'] = $net_amount;
		$transaction_data['user_id'] = $user_id;
		$transaction_data['status'] = $status;
		$transaction_data['created_type'] = "App";
		$transaction_data['created_at'] = get_current_date_time();
		$transaction_data['updated_at'] = get_current_date_time();
		
		$last_id = ins_rec(DB_PREFIX."transaction",$transaction_data);
				
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data']['id'] = $last_id;
		$response_data['response_success'] = 'Transaction added successfully';
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