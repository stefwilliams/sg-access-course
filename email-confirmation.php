<?php
function send_confirmation(){
	check_ajax_referer('sgac_confirm', 'nonce'); 
	
	$email = $_POST['email'];
	$interest = $_POST['interest'];

	if ($interest == "drumming") {
		$interest_string = "Drumming Course";
	}
	elseif ($interest == 'dancing') {
		$interest_string = "Dancing Course";
	}
	elseif ($interest == 'both') {
		$interest_string = "Drumming and/or Dancing Course";
	}
	
	//path to the page with the confirmation
	$path = '/join-us/confirmation';
	//validate email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'bad_email';
		die();
	}

	//validate interest field
	elseif ($interest == "") {
		echo 'no_interest';
		die();
	}

	
	$hash_string = 'sgac'.$email;
	$conf = md5($hash_string);
	//setup url string to send in email
	$query_string = '/?email='.$email.'&interest='.$interest.'&conf='.$conf;
	$return_address = site_url($path.$query_string);

$message = 
<<<EML
<p>Hi!,</p>
<p>You recently requested to be kept informed of when Samba Galez would be running its next Access Course.</p>
<p>You expressed an interest in the next $interest_string .</p>
<p>If you requested this information and you're still interested, please <a href="$return_address">Confirm your interest</a>.</p>
<p>If you are no longer interested, or this email was sent in error, just ignore it.</p>
EML;


	$headers = 'From: Samba Galez <noreply@sambagalez.info>\r\n';
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
	wp_mail($email, "So you want to join the band?", $message, $headers);


//set up accompanying text to send in email


//send email


// send response to Ajax query

 	// die();
}