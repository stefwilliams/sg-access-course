<?php

//Define sgac_email_alert content type.

add_action( 'init', 'register_cpt_sgac_email_alert' );

function register_cpt_sgac_email_alert() {

    $labels = array( 
        'name' => _x( 'Email alert', 'sgac_email_alert' ),
        'singular_name' => _x( 'Email alerts', 'sgac_email_alert' ),
        'add_new' => _x( 'Add New', 'sgac_email_alert' ),
        'add_new_item' => _x( 'Add New Email alerts', 'sgac_email_alert' ),
        'edit_item' => _x( 'Edit Email alerts', 'sgac_email_alert' ),
        'new_item' => _x( 'New Email alerts', 'sgac_email_alert' ),
        'view_item' => _x( 'View Email alerts', 'sgac_email_alert' ),
        'search_items' => _x( 'Search Email alert', 'sgac_email_alert' ),
        'not_found' => _x( 'No email alerts found', 'sgac_email_alert' ),
        'not_found_in_trash' => _x( 'No email alert found in Trash', 'sgac_email_alert' ),
        'parent_item_colon' => _x( 'Parent Email alerts:', 'sgac_email_alert' ),
        'menu_name' => _x( 'Access Course Email alerts', 'sgac_email_alert' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Email addresses of people who want to know when the next Access / Dance course will be run.',
        'supports' => array( 'title' ),        
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-editor-distractionfree',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => false, )
    );

    register_post_type( 'sgac_email_alert', $args );
}

//ADD CUSTOM COLUMNS TO POSTS SCREEN to include Course Name 

//add column head
function sgac_add_enq_columns_head($defaults) {
	$defaults['course'] = 'Interested in';
	return $defaults;
}


//add column content
function sgac_course_enq_data($column_name, $post_ID) {
	if ($column_name == "course") {
		$course_name = get_post_meta( $post_ID, 'interest', true );
		echo $course_name;
	}
}

add_filter('manage_sgac_email_alert_posts_columns', 'sgac_add_enq_columns_head');  
add_action('manage_sgac_email_alert_posts_custom_column', 'sgac_course_enq_data', 10, 2);