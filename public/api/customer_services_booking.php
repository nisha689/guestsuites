<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$data = json_decode(file_get_contents("php://input"), true);

$response = array();
$response_data = array();

$token = $data['token'];

$check_token = verify_token($token);

if($check_token[0]=='1'){

	$business_service_id = $data['business_service_id'];	
	$business_id = $data['business_id'];	
	$customer_id = $data['customer_id'];	
	$current_date_time = get_current_date_time(); 

	$customer_booked_data = ['business_service_id' => $business_service_id,
							'business_id' => $business_id,
							'customer_id' => $customer_id,
							'start_date_time' => $current_date_time,
							'created_at' => $current_date_time,
							'updated_at' => $current_date_time,
							];

	$customer_booked_id = ins_rec(DB_PREFIX."customer_booked",$customer_booked_data);

	if(!empty($data['answer'])){
		$answers = $data['answer'];
		foreach ($answers as $key => $answer) {
			$answerData = ['customer_booked_id' => $customer_booked_id,
							'service_category_id' => $answer['service_category_id'],
							'question_id' => $answer['question_id'],
							'option_id' => $answer['option_id'],
							'created_at' => $current_date_time,
							'updated_at' => $current_date_time,
						];

						if(!empty($answer['answer'])){
							$answerData['answer'] = $answer['answer'];	
						}

			ins_rec(DB_PREFIX."customer_booked_detail",$answerData);
		}
	}

	$response_data['response_code'] = '1';
	$response_data['response_error'] = "";
	$response_data['response_data']['customer_booked_id'] = $customer_booked_id;
	$response_data['response_success'] = 'Order added successfully';
		
}else{
	
	$response_data['response_code'] = '0';
	$response_data['response_error'] = $check_token[1];
	$response_data['response_data'] = array();
	$response_data['response_success'] = '';
}

echo json_encode($response_data, JSON_UNESCAPED_SLASHES);
exit;

?>