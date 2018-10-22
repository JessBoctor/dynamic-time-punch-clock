<?php
/*
 *
 *
 *
 */

//Get the row information from the DB
add_action('wp_ajax_rm_dyt_save_entry', 'rm_dyt_save_entry');
add_action('wp_ajax_nopriv_rm_dyt_save_entry', 'rm_dyt_save_entry');

function rm_dyt_save_entry(){
	
	//Get the time entry
	$time_entry = $_GET['row'];
	
	write_log( 'Time entry!!');
	write_log( $time_entry );
	
	$start_time = strtotime( $time_entry['TimeIn']  );
	$end_time	= strtotime( $time_entry['TimeOut'] );
	$time_in	= explode(' ', $time_entry['TimeIn']);
	$time_out	= explode(' ', $time_entry['TimeOut']);

	//Add the date and hours to the $time_entry array
	$time_entry['Date']		= floor((strtotime(date($time_in[0]))*1000)/8.64e7)  ;
	$time_entry['Hours'] 	= round((( $end_time - $start_time ) / 3600),2);
	$time_entry['HourType'] = 'Reg';
	$time_entry['TimeIn']	= $time_in[1];
	$time_entry['TimeOut']	= $time_out[1];
	
	global $wpdb;
	
	$table_name = 'wp_time_entry';
	
	write_log( $table_name );
	write_log( $time_entry );
	
	$response = $wpdb->insert( 
		$table_name, 
		$time_entry, 
		array( 
			'%d', 
			'%d',
			'%d',
			'%s',
			'%s',
			'%s',
			'%d',
			'%d',
			'%s'
		) 
	);
	write_log( $time_entry );
	
	//return to browser
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
	
}