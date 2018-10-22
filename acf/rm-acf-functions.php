<?php
/*
 *
 *
 *
 */

//Populate a select field with each of the site ID's and Name
//function rm_dyt_site_id_select( $field ) {
//	
//	global $wpdb;
//	
//	$table_name = $wpdb->prefix . 'sitemeta';
//	
//	//Get the site names and their IDs
//	$site_list = $wpdb->get_results(
//		"
//		SELECT site_id, meta_value
//		FROM $table_name
//		WHERE meta_key = 'site_name'
//		",
//		ARRAY_A
//	);
//    
//	//If the db results are an array
//	if( is_array( $site_list ) ){
//		
//		//loop through the lists
//		foreach( $site_list as $s => $site ){
//			
//			//>>Add each of the sites to the select list
//			//The value is the site ID
//			//The Label is the site name
//			$field['choices'][ $site['site_id'] ] = $site['meta_value'];
//		
//		}
//	
//	}
//     
//    // return the field
//    return $field;
//    
//}
//
//add_filter('acf/load_field/name=tcw_client', 'rm_dyt_site_id_select');
//
