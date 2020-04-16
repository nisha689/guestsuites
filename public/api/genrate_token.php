<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$genrate_token = base64_encode(strtotime(date('H:i')));

$response_data['token'] = $genrate_token;

$response['response_code'] = '1';
$response['response_data'] = $response_data;
echo json_encode($response);
exit(0);

?>