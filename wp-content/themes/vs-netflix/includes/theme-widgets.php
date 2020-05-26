<?php

class WPVS_Social_Media_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wpvs_social_widget', // Base ID
			__( 'Social Accounts', 'vs-netflix' ), // Name
			array( 'description' => __( 'Displays social media accounts.', 'vs-netflix' ) )
		);
	}
	public function widget( $args, $instance ) {
		echo $args['before_widget']; 
        if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
        get_template_part('social-media');
        if(isset($args['after_widget'])) {
		  echo $args['after_widget'];
        }
	}
	public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Connect with us', 'vs-netflix' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'vs-netflix' ); ?>:</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p> 
        <p><?php _e('Displays social media accounts. Add social accounts', 'vs-netflix');
        echo ' <a href="'.admin_url('admin.php?page=net-social-options') .'">';
        _e('here', 'vs-netflix'); 
        echo '</a>.'; ?></p>
        <?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['number_of_posts'] = ( ! empty( $new_instance['number_of_posts'] ) ) ? strip_tags( $new_instance['number_of_posts'] ) : '';
		return $instance;
	}
}



function register_wpvs_theme_widgets() {
    register_widget( 'WPVS_Social_Media_Widget' );
}
add_action( 'widgets_init', 'register_wpvs_theme_widgets' );
