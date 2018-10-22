<?php 
class RM_Timer_Widget extends WP_Widget {
  /**
  * To create the example widget all four methods will be 
  * nested inside this single instance of the WP_Widget class.
  **/
  
  public function __construct() {
	//Create the Widget Info & Title  
    $widget_options = array( 
      'classname' => 'timer_widget',
      'description' => 'This is an Timer Widget for the Rimoht Dynamic Time Extension',
    );
    parent::__construct( 'time_widget', 'Timer Widget', $widget_options );
  }
  
  
  public function widget( $args, $instance ) {
	  
	  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
	  $blog_title = get_bloginfo( 'name' );
	  $tagline = get_bloginfo( 'description' );
	  
	  //Get the field group ID
	  global $wpdb;
	  
	  $post_meta_table = $wpdb->prefix . 'posts';
	  
	  $field_group_id = $wpdb->get_var(
		  "
		  SELECT ID
		  FROM $post_meta_table
		  	WHERE post_title = 'Time Card Widget'
		  	AND post_type = 'acf-field-group'
		  "
	  );
	  
	  write_log( 'Field Group ID' );
	  write_log( $field_group_id );
	  
	  echo $args['before_widget'] . $args['before_title'] . $blog_title . ' Timer' . $args['after_title'];
	  
	  $form_args = array(
		  'id' => 'rm-timer-form',
		  'field_groups' => array( $field_group_id ),
		  'form' => false,
		  'submit' => '<button id="tcw-save">Save Time Punch</button>'
		  
	  );
	  acf_form_head();
	  acf_form( $form_args );
	  
	  echo '<a href="javascript:void(0)"><button id="tcw-save">Save Time Punch</button><a>';
	  
	  echo $args['after_widget'];
	  
	  ?>
	  <script>
	  	acf.do_action('append', $('.acf-form'));
	  </script>
	  <?php	
	
	}
	
	public function form( $instance ) {
	  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
	  <p>
	    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
	  </p><?php 
	}
	
	public function update( $new_instance, $old_instance ) {
	  $instance = $old_instance;
	  $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
	  return $instance;
	}

}

function rm_register_timer_widget() { 
  register_widget( 'RM_Timer_Widget' );
}

add_action( 'widgets_init', 'rm_register_timer_widget' );
?>