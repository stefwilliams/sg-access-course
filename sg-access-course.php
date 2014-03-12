<?php

/*
Plugin Name: SG Access Course 
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Add alert signup for Access Courses, and more stuff in due course
Version: 1.0
Author: Stef Williams
Author URI: http://URI_Of_The_Plugin_Author
License: GPL2
*/
include ('email-confirmation.php');
include ('access-course-widget.php');
include ('confirmation.php');
include ('cpt/email_alerts.php');

//AJAX actions for confirmation email in widget
add_action( 'wp_ajax_sgacemail', 'send_confirmation' );
add_action( 'wp_ajax_nopriv_sgacemail', 'send_confirmation' ); // need this to serve non logged in users

