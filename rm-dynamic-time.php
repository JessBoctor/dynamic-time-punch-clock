<?php
/*
Plugin Name: Rimoht Dynamic Time Extension
Plugin URI:  http://rimoht.com/dynamic-time
Description: Custom functionality for the Dynamic Time Plugin 
Version:     0.1
Author:      Jess Boctor
Author URI:  http://jessboctor.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: rm-dynamic-time
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Makes sure the plugin is defined before trying to use it
if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}
 
//Check to see if the advanced custom fields plugin is activated
if ( !is_plugin_active_for_network( 'advanced-custom-fields-pro/acf.php' ) ){
	add_action( 'admin_notices', 'rm_acf_notice' );
}

function rm_acf_notice() {
  ?>
  <div class="update-nag notice">
      <p><?php _e( 'Please network activate Advanced Custom Fields, it is required for this plugin to work properly!', 'rm-dynamic-time' ); ?></p>
  </div>
  <?php
}

//Check to see if the rimoht timer field is installed
if ( !is_plugin_active_for_network( 'rm-acf-timer/rm-acf-timer.php' ) ){
	add_action( 'admin_notices', 'rm_timer_notice' );
}

function rm_timer_notice() {
  ?>
  <div class="update-nag notice">
      <p><?php _e( 'Please install the Rimoht Timer Field for Advanced Custom Fields, it is required for this plugin to work properly!', 'rm-dynamic-time' ); ?></p>
  </div>
  <?php
}

//Check to see if the advanced custom fields plugin is activated
if( !is_plugin_active( 'dynamic-time/time_functions.php' ) && get_current_blog_id() == 1 ) {
  add_action( 'admin_notices', 'rm_dyt_notice' );
}

function rm_dyt_notice() {
  ?>
  <div class="update-nag notice">
      <p><?php _e( 'Please install Dynamic Time, it is required for this plugin to work properly!', 'rm-dynamic-time' ); ?></p>
  </div>
  <?php
}


//Define the plugin path
define( 'RM_DYNAMIC_TIME_EXT', plugin_dir_path( __FILE__ ));
define( 'RM_DYNAMIC_TIME_URL', plugin_dir_url( __FILE__ ) );

//Enqueue Styles & Scripts 
add_action( 'wp_enqueue_scripts', 'rm_dyt_enqueue_scripts' );

function rm_dyt_enqueue_scripts(){
	write_log( 'Enquing Scripts' );
	
	//>>Register the stylesheet
	$test = wp_register_style( 'rm-dyt-style', RM_DYNAMIC_TIME_URL . 'rm-dyt-style.css', array('dyt_style') );
	write_log( $test );
	
	//>>Check if the page or post is a single item
	if( is_single() || is_page() ){
		
		//>>>>Get the global variable
		global $post;
		
		//>>>> Get the content of the post
		$content = get_post_field('post_content', $post->ID);
		
		//>>>>Check to see if it contains the dyt shortcode
		if( has_shortcode( $content, 'dynamicTime' ) ){
			write_log( 'passed shortcode test' );
			//>>>>>>Enqueue the stylesheet
			wp_enqueue_style( 'rm-dyt-style' );
		}
	
	}

}


//Include the ajax file
include( RM_DYNAMIC_TIME_EXT . 'rm-dyt-ajax.php' );
include( RM_DYNAMIC_TIME_EXT . 'rm-ajax-functions.php' );
include( RM_DYNAMIC_TIME_EXT . 'rm-timer-widget.php' );

if( class_exists('ACF') ) { 
	include( RM_DYNAMIC_TIME_EXT . 'acf/rm-dyt-acf-field-groups.php' ); 
	include( RM_DYNAMIC_TIME_EXT . 'acf/rm-acf-functions.php' );
}

//Change the location of the js file
add_filter( 'dyt_js_file', 'rm_dyt_js_file' );

function rm_dyt_js_file( $js_url ){
	
	//Give it a new url
	$js_url = RM_DYNAMIC_TIME_URL . 'dyt/rm_time_unmin.js';
	
	//return it to be enqueed
	return $js_url;
	
}

//Change the information that is saved on the calendar page
add_filter( 'dyt/entries/time_meta', 'rm_dyt_time_meta' );

function rm_dyt_time_meta( $time_meta_array ){
	write_log( $_POST );
	write_log( $time_meta_array );
	
	//Add in the site and post ID's
	if(!empty($_POST['site'])) $time_meta_array['site_id']=array_map('sanitize_text_field',$_POST['site']);
	if(!empty($_POST['post']))$time_meta_array['post_id']=array_map('sanitize_text_field',$_POST['post']);
	
	return( $time_meta_array );
}

//Change the query that inserts the information
add_filter( 'dyt/entries/save_query', 'rm_dyt_save_query', 10, 4);

function rm_dyt_save_query( $entry_save_query_string, $time_meta_array, $dateval, $index ){
	
	//Get the current user Id
	$wp_userid = get_current_user_id();
	
	//Get the global Var
	global $wpdb;
	
	$entry_save_query_string = 
		"
		INSERT INTO {$wpdb->prefix}time_entry (WP_UserID,Date,Hours,HourType,TimeIn,TimeOut,SiteID,PostID,Note)
		VALUES(
			$wp_userid,
			'$dateval',
			'{$time_meta_array['hours'][$index]}',
			'{$time_meta_array['hourtype'][$index]}',
			'{$time_meta_array['time_in'][$index]}',
			'{$time_meta_array['time_out'][$index]}',
			'{$time_meta_array['site_id'][$index]}',
			'{$time_meta_array['post_id'][$index]}',
			'{$time_meta_array['note'][$index]}'); 
		";
	
	return $entry_save_query_string;	
		
}

//Change the location of the time_entry file
add_filter( 'dyt/entries/load_entry_path', 'rm_dyt_load_entry_path' );

function rm_dyt_load_entry_path( $load_entry_path ){
	
	//Change the path dir of the file
	$load_entry_path = RM_DYNAMIC_TIME_EXT . 'dyt/rm_time_load_entries.php';
	
	//return to be included
	return $load_entry_path;
	
}

//Edit the entry query on time_cal.php
add_filter( 'dyt/entries/query', 'rm_dyt_entry_query' );

function rm_dyt_entry_query( $entry_query_string ){
	
	//Initiate the global database variable
	global $wpdb;	
	
	$user_id = get_current_user_id();
	
	//Modify the query string
	$entry_query_string = "
		SELECT WP_UserID,Date,SUM(Hours) as Hours,HourType,TimeIn,TimeOut,SiteID,PostID,Note
		FROM {$wpdb->prefix}time_entry
		WHERE WP_UserID='$user_id'
		GROUP BY WP_UserID,Date,HourType,TimeIn,TimeOut,Note
		ORDER BY Date ASC, HourType DESC, TimeIn;
	  ";
	  
	 write_log( 'Entry Query String' ); 
	 write_log( $entry_query_string );
	
	//Return it to be executed
	return $entry_query_string;	

}

function rm_dyt_activate() {
	
	write_log( 'activation hook' );
	
	//>>Add a column for a post_id to associate a time entry with a post / task
	//Acess the global variable
	global $wpdb;
	

	//Create the column name from the DB prefix and the column name
	$post_column = 'PostID';
	$site_column = 'SiteID';
	$table_name = $wpdb->prefix . 'time_entry';

	//Check to see if the table exists
	$table = $wpdb->get_results(
		"
		SELECT * 
		FROM information_schema.tables
		WHERE table_schema = '$table_name' 
		LIMIT 1
		"
		);

	//Test and see if the column has already been added
	$post_row = null;
	if( $table ){
		$post_row = $wpdb->get_results(  
			"
			SELECT '$post_column'' 
			FROM '$table_name' 
			WHERE column_name = '$post_column'
			"  
		);
	}
	
	write_log( $post_row );
	

	//If not, add the column 
	if( $table && ( empty($post_row) || $post_row == '' ) ){
	   $wpdb->query(
		   "
		   ALTER TABLE $table_name
		   ADD $post_column INT
		   "
	   );
	}

	//Test and see if the column has already been added
	$site_row = null;
	if( $table ){
		$site_row = $wpdb->get_results(  
			"
			SELECT '$site_column'' 
			FROM '$table_name' 
			WHERE column_name = '$site_column'
			"  
		);
	}
	
	write_log( $site_row );

	//If not, add the column 
	if( $table && ( empty($site_row) || $site_row == '' ) ){
	   $wpdb->query(
		   "
		   ALTER TABLE $table_name
		   ADD $site_column INT
		   "
	   );
	}
}

register_activation_hook( __FILE__, 'rm_dyt_activate' );

//Get the post title by post_id and site_id
function rm_get_multisite_post_title( $post_id, $site_id ){
	
	//>>Check the passed Variables
	if( !$post_id || !$site_id ){
		//If either the post id or site id are null, return an empty string
		$title = '';
		return $title;
	}
	
	//>>Access the global variable
	global $wpdb;
	
	//>>Get the DB Table Name
	$wp_prefix = $wpdb->prefix;
	
	//>>>>If the current blog is not the main blog, the db prefix will include the current blog id, so we need to remove it
	$current_blog_id =  get_current_blog_id();
	
	if( $current_blog_id != 1 ){
		$wp_prefix = str_replace( $current_blog_id . '_', '', $wp_prefix );
	}
	
	$table_name = $wp_prefix . $site_id . '_posts';
	
	//>>Get the post title
	$title = $wpdb->get_var(
		"
		SELECT post_title
		FROM $table_name
		WHERE ID = $post_id
		"
	);
	
	//>>Return the title
	return $title;

}
