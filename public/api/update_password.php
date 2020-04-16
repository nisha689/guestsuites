<?php
header('Content-type: application/json; charset=UTF-8;');
include_once('include/connectdb.php');
include_once('include/function.php');

$response = array();
$response_data = array();

$token = $_POST['token'];
$check_token = verify_token($token);

if($check_token[0]=='1'){

	$user_id = mysqlRealescapestring($conn,$_POST['user_id']);
	$password = mysqlRealescapestring($conn,$_POST['password']);
	$confirm_password = mysqlRealescapestring($conn,$_POST['confirm_password']);
	$char_count = strlen($password);

	
	if($user_id=='' || $user_id <=0){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Invalid user id!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	else if($password=='' || $confirm_password==''){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Please fill all required fields';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	elseif($char_count<7){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = "Please enter at least 7 characters for your password!";
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}
	else if($password!=$confirm_password){
		$response_data['response_code'] = '0';
		$response_data['response_error'] = 'Password and confirm password is not same!';
		$response_data['response_data'] = array();
		$response_data['response_success'] = '';
	}else{
		
		$user_data['password'] = PasswordGenerator($password);
		
		$update_id = upd_rec(DB_PREFIX."users",$user_data,"user_id='".$user_id."'");
			
		$get_qry_var = "SELECT first_name,last_name,email,role_id FROM ".DB_PREFIX."users WHERE role_id = 2 AND user_id='".$user_id."'";
		$get_qry = mysqlQuery($conn,$get_qry_var);
		$get_row = mysqlFetchArray($get_qry);

		$entity = 'business_password_change';
		$user_name = ucfirst($get_row['first_name'])." ".ucfirst($get_row['last_name']);

		$mail_content = get_email_template($entity);
		$email_subject = $mail_content['subject'];
		$templateFields = $mail_content['template_fields'];
	    $templateContent = $mail_content['template_content'];
	    $templateFieldValues = ['name' => $user_name,'email' =>$get_row['email'],'password' =>$password];
                                
        $mailContent = convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues );
        $email_content = replace_email_placeholders($mailContent,$email_subject);

		SendHTMLMail($get_row['email'],$email_subject,$email_content,$user_name,$config_array);
		
		$display_password_data['user_id'] = $user_id;
		
		$response_data['response_code'] = '1';
		$response_data['response_error'] = "";
		$response_data['response_data'] = $display_password_data;
		$response_data['response_success'] = 'Password has been updated successfully.';
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