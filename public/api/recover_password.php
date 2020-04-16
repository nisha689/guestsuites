<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$email = mysqlRealescapestring($conn,$_POST['email']);	

	// check if email exists in the database
	$check_email_qry_var = "SELECT user_id,email,first_name,
							last_name,role_id FROM ".DB_PREFIX."users WHERE role_id = 2 AND email='".$email."'";
	$check_qry = mysqlQuery($conn,$check_email_qry_var);
	$check_row = myasqlNumRow($check_qry);
	$get_row = mysqlFetchArray($check_qry);
	
	if($email==''){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = BLANK_VALIDATION_MSG;
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Invalid email address!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	
	}else if($check_row=='0'){
		
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "We do not have that email in our database, please try again.";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
		
	}else{
		$user_data['user_id'] = $get_row['user_id'];
	    $get_random_password = RandomPassword(4);
		$update_password_data['password'] = PasswordGenerator($get_random_password);
		//$update_password_data['password'] = $get_random_password;

		$update_id = upd_rec(DB_PREFIX."users",$update_password_data,"user_id='".$get_row['user_id']."'");

		$entity = 'business_password_change'; 

		$user_name = ucfirst($get_row['first_name'])." ".ucfirst($get_row['last_name']);

		$mail_content = get_email_template($entity);
		$email_subject = $mail_content['subject'];
		$templateFields = $mail_content['template_fields'];
	    $templateContent = $mail_content['template_content'];
	    $templateFieldValues = ['name' => $user_name,'email' => $get_row['email'], 'password' => $get_random_password];
    	    
        $mailContent = convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues );
        $email_content = replace_email_placeholders($mailContent,$email_subject);
        
		SendHTMLMail($get_row['email'],$email_subject,$email_content,$user_name,$config_array);
		
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data'] = $user_data;
		$response_data['response_success'] = 'Password reset instructions have been sent to your email.';
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