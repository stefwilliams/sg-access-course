<?php
function sgac_unsubscribe_email($email) {
	$subscriber = get_page_by_title($email, OBJECT, 'sgac_email_alert');

	wp_delete_post( $subscriber->ID, true);

	return '<h3>Sorry to see you go</h3><p>'.$email.' has been unsubscribed</p>';
}


function sgac_register_email_alert($email, $interest) {
	$email_exists = get_page_by_title($email, OBJECT, 'sgac_email_alert');

	if ($email_exists) {
		return 'email_exists';
	}

	else {
		$post = array(
			'post_title'	=> $email,
			'post_type'		=> 'sgac_email_alert',
	  		'post_status'   => 'publish',
			);

		$post_id = wp_insert_post( $post, true );

		add_post_meta( $post_id, 'interest', $interest, false);
	}
}

function sgac_confirmation_handler() {

$url = $_SERVER['REQUEST_URI'];
$url_parts = parse_url($url);
parse_str($url_parts['query'],$query_vars);

global $wpdb;
$md5_sent = $query_vars ['conf'];
$email = $query_vars ['email'];
$url_email = urlencode($email);

$hash_string = 'sgac'.$url_email;
$md5 = md5($hash_string);

if ($md5_sent != $md5) {
	echo '
	<h3>It looks like something went wrong.</h3> 
	<p>Please try the link you clicked again or, if you pasted it in, ensure you include the whole link.</p>
	<p>If it still doesn\'t work, then something must have gone very wrong. Please contact us directly via the website.</p>
	';
	goto confirm_end;
}

if (array_key_exists('unsubscribe', $query_vars)) {
	$return = sgac_unsubscribe_email($query_vars['email']);
	echo $return;
	goto confirm_end;
}

$interest = $query_vars ['interest'];
	if ($interest == "drumming") {
		$interest_string = "Drumming Course";
	}
	elseif ($interest == 'dancing') {
		$interest_string = "Dancing Course";
	}
	elseif ($interest == 'both') {
		$interest_string = "Drumming and/or Dancing Course";
	}

$register_email = sgac_register_email_alert($email,$interest);

if ($register_email == 'email_exists') {
	echo "
	<h3>Email already registered</h3>
	<p>It looks like that email address has already been registered.</p>
	<p>If you'd like to remove yourself from the email alerts list, <a href=\"".$url_parts['path']."?unsubscribe=true&email=".$url_email."&conf=".$md5_sent."\">unsubscribe now</a>.
	";
	goto confirm_end;
}

	echo '
	<h3>Nice one!</h3>
	<p>Thanks for registering your interest in a <strong>'.$interest_string.'</strong>!</p>
	<p>We\'ll send an email to <strong>'.$email.'</strong> as soon as we have a date for the next course.</p>
	'; 

	


confirm_end: //goto marker if md5 check fails.
}

add_shortcode( 'confirmation_handler', 'sgac_confirmation_handler' );