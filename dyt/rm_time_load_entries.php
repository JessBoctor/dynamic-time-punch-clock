<?php
/*
 * Separating out this section allows devs to update the way data is loaded into the calendar
 *
 *
 */

  $date='';
  $hours='';
  $hourtype='';
  $time_in='';
  $time_out='';
  $note='';
  $site_id='';
  $post_id='';
  $post_name='';
  $site_name='';
  
  if($entries):
    foreach($entries as $row): 
	    $date=$date."'".$row->Date."',";
	    $hours=$hours."'".$row->Hours."',";
	    $hourtype=$hourtype."'".$row->HourType."',";
	    $time_in=$time_in."'".$row->TimeIn."',";
	    $time_out=$time_out."'".$row->TimeOut."',";
	    $site_id=$site_id."'".$row->SiteID."',";
	    $post_id=$post_id."'".$row->PostID."',";
	    $note=$note."'".addslashes($row->Note)."',";
	    
	    //>>Get the Post Titles
	    $title = rm_get_multisite_post_title( $row->PostID, $row->SiteID );
	    $post_name=$post_name."'".addslashes( $title )."',";
	    
	    //>>Get the site names
	    $site_details = get_blog_details( $row->SiteID );
	    if( is_object( $site_details ) ){
		    $site_name=$site_name."'".addslashes( $site_details->blogname )."',";
	    } else {
		    $site_name=$site_name."'',";
	    }
	    
	endforeach;
  endif;
  
?>

<meta name="viewport" content="width=device-width, user-scalable=no" />
<script type="text/javascript">
  var input_saved="<?php echo $input_saved;?>";
  var setup_path="<?php echo get_admin_url(null,'admin.php?page=dynamic-time');?>";
  var rate="<?php echo $rate;?>";
  var prompt="<?php echo $prompt;?>";
  var notes="<?php echo $notes;?>";
  var exempt="<?php echo $exempt;?>";
  var period="<?php echo $period;?>";
  var weekbegin="<?php echo $weekbegin;?>";
  var currency="<?php echo $currency;?>";

  var period_end=<?php echo '['.substr($period_end,0,-1).']';?>;
  var period_rate=<?php echo '['.substr($period_rate,0,-1).']';?>;
  var period_bonus=<?php echo '['.substr($period_bonus,0,-1).']';?>;
  var period_note=<?php echo '['.substr($period_note,0,-1).']';?>;
  var submitted=<?php echo '['.substr($submitted,0,-1).']';?>;
  var submitter=<?php echo '['.substr($submitter,0,-1).']';?>;
  var approved=<?php echo '['.substr($approved,0,-1).']';?>;
  var approver=<?php echo '['.substr($approver,0,-1).']';?>;
  var processed=<?php echo '['.substr($processed,0,-1).']';?>;

  var db_date=<?php echo '['.substr($date,0,-1).']';?>;
  var db_hours=<?php echo '['.substr($hours,0,-1).']';?>;
  var db_hourtype=<?php echo '['.substr($hourtype,0,-1).']';?>;
  var db_time_in=<?php echo '['.substr($time_in,0,-1).']';?>;
  var db_time_out=<?php echo '['.substr($time_out,0,-1).']';?>;
  var db_site_id=<?php echo '['.substr($site_id,0,-1).']';?>;
  var db_site_name=<?php echo '['.substr($site_name,0,-1).']';?>;
  var db_post_id=<?php echo '['.substr($post_id,0,-1).']';?>;
  var db_post_name=<?php echo '['.substr($post_name,0,-1).']';?>;
  var db_note=<?php echo '['.substr($note,0,-1).']';?>;
  
  var dyt_interval=setInterval(function() {if(document.readyState==='complete') { clearInterval(dyt_interval); dyt_load();}},100);
</script>

