<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

		$service_category_id = $_POST['service_category_id'];

		$get_question_qry = "SELECT * FROM ".DB_PREFIX."question WHERE service_category_id = ".$service_category_id." 
		ORDER BY question_id ASC";
		
		$get_question_res = mysqlQuery($conn,$get_question_qry);

		$get_question_total = myasqlNumRow($get_question_res);
				
		if($get_question_total>0){
			
			while($get_row = mysqlFetchArray($get_question_res)){

				$data['question_id'] = $get_row['question_id'];
				$data['service_category_id'] = $get_row['service_category_id'];
				$data['label'] = $get_row['label'];
				$data['type'] = $get_row['type'];
				$data['parent_question_id'] = $get_row['parent_question_id'];
				
				if(!empty($get_row['option'])){
					$option = $get_row['option'];

					$get_option_qry = "SELECT * FROM ".DB_PREFIX."option WHERE option_id in(".$option.") 
										ORDER BY option_name ASC";
					
					$get_option_res = mysqlQuery($conn,$get_option_qry);

					$get_option_total = myasqlNumRow($get_option_res);
												
					if($get_option_total>0){

						$optionData = [];
						while($get_row = mysqlFetchArray($get_option_res)){

							$option_data['option_id'] = $get_row['option_id'];
							$option_data['option_name'] = $get_row['option_name'];
							if(!empty($get_row['image_url'])){
								$option_data['image_url'] = SITEURL."/".$get_row['image_url'];
							}
							$optionData[] = $option_data;
						}
						$data['option']	= $optionData;
					}

				}

				$response['question'][] = $data;
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