<?php
/*
 *
 *
 */

//>>AJAX to run if the DYT shortcode is running in the content
function rm_dyt_ajax() {

	global $post;
	
		?>
	<script>
		(function($){
			
			//Initialize the timer
			$(document).on('ready', function(){
				$('.timer').countimer({
					autoStart : false
				});

			});
			
			// start the timer
			$( document ).on( 'click', 'a.btn-start', function(){

				///Start the timer
				$('.timer').countimer('start');
				
				//Get the current date and time, then set the date to that value
				var today = new Date();
				var date = today.toJSON().slice(0,10).replace(/-/g,'-');
				var now = moment(today).format('hh:mm:ss');
				$( 'div[data-name="tcw_start_time"] input.hasDatepicker' ).val( date+' '+now );
				
				//Get the current Site & Set it as the current site ID
				var site_id = '<?php echo get_current_blog_id(); ?>';
				console.log( site_id );
				$('select#acf-field_5b411a9b5d95d').val( site_id );
				
				//If you are viewing a rm marker, then set it's ID as the 
				var post_type = '<?php echo get_post_type(); ?>';
				var post_id	= '<?php echo get_the_ID(); ?>';

				
				if( post_type == 'rm_markers' ){
					
					//Set the task to the current post ID
					$('select#acf-field_5b3ff82402b73').val( post_id );
				
				}

			});
			
			// pause the timer
			$( document ).on( 'click', 'a.btn-stop', function(){
				console.log( 'stop button!');
				$('.timer').countimer('stop');
				
				//Get the current date and time then set the date to that value
				var today = new Date();
				var date = today.toJSON().slice(0,10).replace(/-/g,'-');
				var now = moment(today).format('hh:mm:ss');
				$( 'div[data-name="tcw_stop_time"] input.hasDatepicker' ).val( date+' '+now );
			});
			
			$( document ).on( 'click', 'button#tcw-save', function(){
				
				console.log( 'test button' );
				
				var time_entry = {
					WP_UserID	: '<?php echo get_current_user_id(); ?>',
					Date		: '',
					Hours		: '',
					HourType	: '',
					TimeIn		: $( 'div[data-name="tcw_start_time"] input.hasDatepicker' ).val(),
					TimeOut		: $( 'div[data-name="tcw_stop_time"] input.hasDatepicker' ).val(),
					SiteID		: '<?php echo get_current_blog_id(); ?>',
					PostID		: '<?php echo get_the_ID(); ?>',
					Note		: $( 'textarea#acf-field_5b3ff85502b74').val()
				};
				
				console.log( time_entry );
				
				$.get('<?php echo admin_url('admin-ajax.php');?>',{
					row : time_entry,
					action : 'rm_dyt_save_entry'
				},function(resp){
					
					if( resp == 1 ){
						alert( 'Time Entry was successfully saved.' );
					} else {
						alert( 'There was an error saving the time entry.' );
					}
					
				});
				
			});
							
		})(jQuery);

	</script>
	<?php	
}

add_action('wp_footer', 'rm_dyt_ajax');