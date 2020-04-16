<?php
function SendHTMLMail($mailTo, $mailSubject, $mailBody, $toName,$config_array){

			$mailJetPublicApiKey = $config_array['mail_jet_public_api_key'];
			$mailJetPrivateApiKey = $config_array['mail_jet_private_api_key'];
        	$fromEmail = $config_array['mail_jet_email'];
        	$mailJetPrivateKey = $mailJetPublicApiKey.':'.$mailJetPrivateApiKey;

			$ch1 = curl_init();
			
            $data = [];
            $data['Messages'][0]['From']['Email'] = $fromEmail;
            $data['Messages'][0]['From']['Name'] = SITENAME;
            $data['Messages'][0]['To'][0]['Email'] = $mailTo;
            $data['Messages'][0]['To'][0]['Name'] = $toName;
            $data['Messages'][0]['Subject'] = $mailSubject;
            $data['Messages'][0]['HTMLPart'] = $mailBody;

            curl_setopt( $ch1, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch1, CURLOPT_POST, true );
            curl_setopt( $ch1, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch1, CURLOPT_URL, "https://api.mailjet.com/v3.1/send" );
            curl_setopt( $ch1, CURLOPT_POST, true );
            curl_setopt( $ch1, CURLOPT_POSTFIELDS, json_encode( $data ) );
            
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
				            "Content-Type: application/json",
				            "Authorization: Basic " . base64_encode($mailJetPrivateKey)
				        ));

            $result1 = curl_exec( $ch1 );
            return $result1;

}


function encode($value){
	$key = sha1('EnCRypT10nK#Y!RiSRNn');
	if(!$value){return false;}
	$strLen = strlen($value);
	$keyLen = strlen($key);
	$j=0;
	$crypttext= '';
	for ($i = 0; $i < $strLen; $i++) {
		$ordStr = ord(substr($value,$i,1));
		if ($j == $keyLen) { $j = 0; }
		$ordKey = ord(substr($key,$j,1));
		$j++;
		$crypttext .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	}
	return $crypttext;
}

function decode($value) {
     if(!$value){return false;}
        $key = sha1('EnCRypT10nK#Y!RiSRNn');
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j=0;
        $decrypttext= '';
        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($value,$i,2)),36,16));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $decrypttext .= chr($ordStr - $ordKey);
        }

    return $decrypttext;
}

function get_current_date_time(){
	/*$conn = mysqlConncet();
	$get_current_date_time_qry = mysqlQuery($conn,"SELECT NOW() as current_date_time");
	$get_current_date_time_row = mysqlFetchArray($get_current_date_time_qry);
	return $get_current_date_time_row['current_date_time'];*/
	date_default_timezone_set("Africa/Lagos");
	return date('Y-m-d H:i:s');
}

function ins_rec($tab,$array,$disp=false){
		
		$conn = mysqlConncet();
		//$array = add_slashes($array);
		$array = ($array);
		$qry = "insert into $tab set "; 
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				$qry .= "`$k`='".$v."',";
			}
		}

		$qry=trim($qry,",");
		if ($disp)
			echo $qry;

		$err = mysqlQuery($conn,$qry);
		if (!$err){
				return false;
		}
		else{
			return mysqlLastId($conn);

		}

}

function upd_rec($tab,$array,$where="1=1",$disp=false){	
		$conn = mysqlConncet();
		$array = ($array);
		$qry = "update $tab set ";
		if (count($array) > 0)
		{
			foreach ($array as $k=>$v)
			{
				$qry .= "$k='".$v."',";

			}

		}
		$qry=trim($qry,",")." where ".$where;				
		if ($disp)
			echo $qry;
		$err = mysqlQuery($conn,$qry);		
		if (!$err){
			return false;
		}
		else{
			return true;
		}

}

function verify_token($token){

	if($token!=''){
		// get time after 3 hour token time
		$get_token_time = base64_decode($token);
		$cenvertedTime = date('H:i',strtotime('+9 hour',$get_token_time));
		//$cenvertedTime = date('H:i',strtotime('+2 minutes',$get_token_time));
	
		$get_current_time = date('H:i');
		
		if(strtotime($cenvertedTime)>=strtotime($get_current_time)){
			return array('1','valid_token');
		}else{
			//return array('0','Token has expired!');
			return array('1','valid_token');
		}
	}else{
		return array('0','Invalid token!');
	}
}

function RandomPassword($length){
	
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
	$numbers = '0123456789';
    $numbersLength = strlen($numbers);
    $numbersrandomString = '';
    for ($j = 0; $j < $length; $j++) {
        $numbersrandomString .= $numbers[rand(0, $numbersLength - 1)];
    }
    return $randomString.$numbersrandomString;
}
function PasswordGenerator($password){
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,SITEURL."/password_generate");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"password=$password");
	
	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($ch);
	$err = curl_error($ch);
	
	curl_close ($ch);
	
	if (!$err) {
		$resultArray = json_decode($response,true);
		$return_data = $resultArray['data'];
	}else{
		$return_data = '';
	}
	
	return $return_data;
	
}
function mc_checklist($email, $debug, $apikey, $listid, $server) {
    $userid = md5($email);
    $auth = base64_encode( 'user:'. $apikey );
    $data = array(
        'apikey'        => $apikey,
        'email_address' => $email
        );
    $json_data = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://'.$server.'.api.mailchimp.com/3.0/lists/'.$listid.'/members/' . $userid);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic '. $auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    $result = curl_exec($ch);
    if ($debug) {
        var_dump($result);
    }
    $json = json_decode($result);
    return $json->{'status'};
}

function subscribeToMailchimpOnRegitser($email, $fname, $lname, $server, $listID, $apiKey){
	
	// MailChimp API URL
	$memberID = md5(strtolower($email));
	$url = 'https://' . $server . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
	
	$json = json_encode([
		'email_address' => $email,
		'status'        => 'subscribed',
		'merge_fields'  => [
			'FNAME'     => $fname,
			'LNAME'     => $lname
		]
	]);
	// send a HTTP POST request with curl
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	$result = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	// store the status message based on response code
	if ($httpCode == 200) {
		return 1;
	} else {
		switch ($httpCode) {
			case 214:
				return 2;
				break;
			default:
				return 0;
				break;
		}
	}

}

function string_formate($str_data, $iscolor="N"){
	$allow_tags = strip_tags($str_data, '<strong><bold><br></br><ul></ul><li></li>');
	$strcolor = "";
	if($iscolor=="Y"){
		$strcolor = "color:white;";
	}
	//$allow_tags_style = '<p style="font:Karla-Regular 10.0;">'.$allow_tags.'</p>';
	$allow_tags_style = '<p style="font:Karla-Regular 10.0;'.$strcolor.'">'.$allow_tags.'</p>';
	return $allow_tags_style;
}

function convertEmailTemplateContent( $templateFields, $templateContent, $templateFieldValues )
{
        $templateFields = trim( $templateFields );

        if ( ! empty( $templateFields ) && ! empty( $templateFieldValues ) ) {
            $templateFieldNameArray = explode( ',', $templateFields );
        }
        $templateContent = nl2br( $templateContent );
        $templateContent = $templateContent;

        foreach ( $templateFieldNameArray as $templateFieldNameKey => $templateFieldName ) {
            /*if ( ! empty( $templateFieldValues[$templateFieldName] ) ) {
                $value = $templateFieldValues[$templateFieldName];
                $templateContent = str_replace( '%' . $templateFieldName . '%', $value, $templateContent );
            }*/
            $value = $templateFieldValues[$templateFieldName];
            $templateContent = str_replace( '%' . $templateFieldName . '%', $value, $templateContent );
        }
        return $templateContent;
}

function get_email_template($entity){

		$conn = mysqlConncet();
    	$template_qry = "SELECT subject,template_fields,template_content FROM ".DB_PREFIX."email_template  WHERE entity = '".$entity."'";
    	$template_res = mysqlQuery($conn,$template_qry);
		$total_template = myasqlNumRow($template_res);
		
		return $template_row = mysqlFetchArray($template_res);
		
}

function replace_email_placeholders($mailContent,$email_subject){
	$email_template = file_get_contents('email_template/email_template.blade.php');
	$email_template = str_replace('[subject]',$email_subject,$email_template);
	$email_template = str_replace('[top_image]',EMAIL_TEMPLATE_HEADER_IMAGE_URL,$email_template);
	     
	$email_template = str_replace('[mailContent]',$mailContent,$email_template);
	/*$email_template = str_replace('[phone_number]',EMAIL_TEMPLATE_PHONE_NUMBER,$email_template);*/
	$email_template = str_replace('[facebook_url]',EMAIL_TEMPLATE_FACEBOOK_URL,$email_template);
	$email_template = str_replace('[facebook_image]',EMAIL_TEMPLATE_FACEBOOK_IMAGE_URL,$email_template);
	$email_template = str_replace('[twitter_url]',EMAIL_TEMPLATE_TWITTER_URL,$email_template);
	$email_template = str_replace('[twitter_image]',EMAIL_TEMPLATE_TWITTER_IMAGE_URL,$email_template);
	$email_template = str_replace('[bottom_image]',EMAIL_TEMPLATE_FOOTER_IMAGE_URL,$email_template);
	
	return $email_template;
}

function SendNotificationToAndroidDevice( $token, $message, $id = '0' )
{
	
    if ( ! empty( $token ) && ! empty( $message ) ) {
        $appServerKey = APPSERVERKEY;
        $notification = ['body'  => $message,
                         'title' => 'Kidrend',                             
                         'id'    => $id,
						 'type'  => 'directmsg',
                         'sound' => 'default',];
        $arrayToSend = ['to'       => $token,
                        'data'     => $notification,
                        'priority' => 'high',];


        $json = json_encode( $arrayToSend );
        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $appServerKey;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        $notifyResponse = curl_exec( $ch ); //Send the request
        $responseData = json_decode( $notifyResponse, true );
        //var_dump($notifyResponse);
        $response = [];
        if ( isset( $responseData['success'] ) && $responseData['success'] == 1 ) {
            $response['success'] = true;
            $response['message'] = 'Notification Send Successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = isset( $responseData[0]['error'] ) ? $responseData[0]['error'] : 'Issue in sending Successfully.';
        }
        curl_close( $ch );
        return $response;
    }
}

function SendNotificationToIosDevice( $token, $message, $id = 0 )
{
    if ( ! empty( $token ) && ! empty( $message ) ) {
		$appServerKey = APPSERVERKEY;
        $notification = ['body'  => $message,
                         'title' => 'Kidrend',                            
                         'sound' => 'default',
						 'id'    => $id,
						 'type'  => 'directmsg',
                         'badge' => '1'];
        $arrayToSend = ['to'                => $token,
                        'notification'      => $notification,
                        'priority'          => 'high',
                        'content_available' => true];
        $json = json_encode( $arrayToSend );

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $appServerKey;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
        $notifyResponse = curl_exec( $ch ); //Send the request
        $responseData = json_decode( $notifyResponse, true );
        //var_dump($notifyResponse);
        $response = [];
        if ( isset( $responseData['success'] ) && $responseData['success'] == 1 ) {
            $response['success'] = true;
            $response['message'] = 'Notification Send Successfully.';
        } else {
            $response['success'] = false;
            $response['message'] = isset( $responseData[0]['error'] ) ? $responseData[0]['error'] : 'Issue in sending Successfully.';
        }
        curl_close( $ch );
        return $response;
    }
}

function unique_group_id(){
	$unique_group_id = md5(date('YmdHis'));
	return $unique_group_id;
}
?>