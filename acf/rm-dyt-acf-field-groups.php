<?php
	/*
	 *
	 *
	 * Programmatically add all of the fields needed for the widget
	 *
	 */

function rm_add_timer_field_groups() {

acf_add_local_field_group( array(
	'key' => 'group_5b3ff813abd56',
	'title' => 'Time Card Widget',
	'fields' => array(
		array(
			'key' => 'field_5b4005d6605c2',
			'label' => 'Timer',
			'name' => '',
			'type' => 'timer',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => 'tcw-timer',
			),
			'rm-acf-timer-hour' => 24,
		),
		array(
			'key' => 'field_5b3ff87002b75',
			'label' => 'Start Time',
			'name' => 'tcw_start_time',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d H:i:s',
			'return_format' => 'Y-m-d H:i:s',
			'first_day' => 1,
		),
		array(
			'key' => 'field_5b3ff89502b76',
			'label' => 'Stop time',
			'name' => 'tcw_stop_time',
			'type' => 'date_time_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d H:i:s',
			'return_format' => 'Y-m-d H:i:s',
			'first_day' => 1,
		),
		array(
			'key' => 'field_5b3ff85502b74',
			'label' => 'Notes',
			'name' => 'tcw_notes',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'rm_markers',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

}

add_action('acf/init', 'rm_add_timer_field_groups');

