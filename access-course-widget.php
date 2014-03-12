<?php
class sgac_widget extends WP_Widget {	

	function __construct() {
		parent::__construct(
		'sgac_widget', // Base ID
		__('Access Course Interest', 'sgac'), // Name
		array( 'description' => __( 'User signup for Access Course notifications', 'sgac' ), ) // Args
		);
	}
// THE FRONT-END WIDGET CODE
	public function widget( $args, $instance ) {

		$pluginsurl = plugins_url ('sg-access-course');
		wp_enqueue_script( 'sgac_emailconfirm', $pluginsurl. '/js/sgac_emailconfirm.js', array( 'jquery' ) );
		wp_localize_script( 'sgac_emailconfirm', 'ajaxsgac_object', array( 'ajaxsgac_url' => admin_url( 'admin-ajax.php' ) ) );	
		$ajax_nonce = wp_create_nonce('sgac_confirm');



		$title = apply_filters( 'widget_title', $instance['title'] );
		$intro_text = apply_filters( 'widget_intro_text', $instance['intro_text'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo '<h3>'.$title.'</h3>';
			// echo $args['before_title'] . $title . $args['after_title'];
		}
		if ( ! empty( $intro_text)) {
			echo $intro_text;
		}
		?>
		
		<div id="confirm_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Thanks for your interest.</h3>
			</div>
			<div class="modal-body">
				<h4>Just one more thing to do</h4>
				<p>We've sent you a confirmation email with a link in it.</p>
				<p>Please click the link to ensure you get added to the list. </p>
				<p>This is to: 
					<ol>
						<li>Prevent people submitting false email addresses</li> 
						<li>Make sure the email address you just put in was correct</li>
					</ol>
				</p>
				<p><strong>NOTE: </strong>Please check your spam folder if the email doesn't arrive promptly.</p>
			</div>
			<div class="modal-footer">
				<button id="exit_modal" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>

		</div>

		<form id="access_course_interest" data-nonce="<?php echo $ajax_nonce; ?>">
			<div id="response_area">
				<label>Your email address:</label>
				<div id="email_error" class="text-error" style="display:none;">Please double-check your email address</div>
				<input id="sgac_email" type="text" name="sgac_email" class="input-block-level"/>
				<div class="control-group">
					<label>Your interest:</label>
					<div id="interest_error" class="text-error" style="display:none;">Please tell us which courses interest you</div>
					<label class="radio inline">
						<input type="radio" name="sgac_interest" value="drumming" />Drumming
					</label>
					<label class="radio inline">
						<input type="radio" name="sgac_interest" value="dancing" />Dancing
					</label>
					<label class="radio inline">		
						<input type="radio" name="sgac_interest" value="both" />Both
					</label>
				</div>
				<button id="sgac_confirmationemail" class="btn btn-inverse btn-block">Keep me in the loop!</button>
			</div>
		</form>

		<?php
		echo $args['after_widget'];
	}

// THE BACK-END WIDGET ADMIN CODE
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Insert title here', 'text_domain' );
		}
		if ( isset( $instance[ 'intro_text' ] ) ) {
			$intro_text = $instance[ 'intro_text' ];
		}
		else {
			$intro_text = __( 'Insert intro text here', 'text_domain' );
		}		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'intro_text' ); ?>"><?php _e( 'Intro Text (including html):' ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id('intro_text'); ?>" name="<?php echo $this->get_field_name('intro_text'); ?>" type="text" rows="10"><?php echo $intro_text; ?></textarea>		
		</p>		
		<?php 
	} 		

// SAVE BACKEND ADMIN OPTIONS
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['intro_text'] = $new_instance['intro_text'];
		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'sgac_widget' );
});