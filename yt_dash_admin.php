<?php
require_once 'functions.php';

if ( !current_user_can( 'manage_options' ) ) {
	return;
}
if (isset($_REQUEST['Clear'])){
	yt_dash_clear_cache();
	?><div class="updated"><p><strong><?php _e('Cleared Cache.', 'yt_dash' ); ?></strong></p></div>  
	<?php
}
if (isset($_REQUEST['Reset'])){

	yt_dash_reset_token();
	?><div class="updated"><p><strong><?php _e('Token Reseted.', 'yt_dash'); ?></strong></p></div>  
	<?php
}else if(yt_dash_safe_get('yt_dash_hidden') == 'Y') {  
        //Form data sent  
        $apikey = yt_dash_safe_get('yt_dash_apikey');  
        if ($apikey){
			update_option('yt_dash_apikey', sanitize_text_field($apikey));  
        }
		
        $clientid = yt_dash_safe_get('yt_dash_clientid');
        if ($clientid){		
			update_option('yt_dash_clientid', sanitize_text_field($clientid));  
        }
		
        $clientsecret = yt_dash_safe_get('yt_dash_clientsecret');  
        if ($clientsecret){			
			update_option('yt_dash_clientsecret', sanitize_text_field($clientsecret));  
		}
		
        $dashaccess = yt_dash_safe_get('yt_dash_access');  
        update_option('yt_dash_access', $dashaccess);
		
		$yt_dash_additional = yt_dash_safe_get('yt_dash_additional');
		update_option('yt_dash_additional', $yt_dash_additional);
		
		$yt_dash_style = yt_dash_safe_get('yt_dash_style');
		update_option('yt_dash_style', $yt_dash_style);

		$yt_dash_cachetime = yt_dash_safe_get('yt_dash_cachetime');
		update_option('yt_dash_cachetime', $yt_dash_cachetime);

		$yt_dash_userapi = yt_dash_safe_get('yt_dash_userapi');
		update_option('yt_dash_userapi', $yt_dash_userapi);			
		
		if (!isset($_REQUEST['Clear']) AND !isset($_REQUEST['Reset'])){
			?>  
			<div class="updated"><p><strong><?php _e('Options saved.', 'yt_dash'); ?></strong></p></div>  
			<?php
		}
    }else if(yt_dash_safe_get('yt_dash_hidden') == 'A') {
        $apikey = yt_dash_safe_get('yt_dash_apikey');  
        if ($apikey){
			update_option('yt_dash_apikey', sanitize_text_field($apikey));  
        }
		
        $clientid = yt_dash_safe_get('yt_dash_clientid');
        if ($clientid){		
			update_option('yt_dash_clientid', sanitize_text_field($clientid));  
        }
		
        $clientsecret = yt_dash_safe_get('yt_dash_clientsecret');  
        if ($clientsecret){			
			update_option('yt_dash_clientsecret', sanitize_text_field($clientsecret));  
		}

		$yt_dash_userapi = yt_dash_safe_get('yt_dash_userapi');
		update_option('yt_dash_userapi', $yt_dash_userapi);			
	}
	
if (isset($_REQUEST['Authorize'])){
	$adminurl = admin_url("#yt_dash-widget");
	echo '<script> window.location="'.$adminurl.'"; </script> ';
}
	
if(!get_option('yt_dash_access')){
	update_option('yt_dash_access', "manage_options");	
}

if(!get_option('yt_dash_style')){
	update_option('yt_dash_style', "red");	
}

$apikey = get_option('yt_dash_apikey');  
$clientid = get_option('yt_dash_clientid');  
$clientsecret = get_option('yt_dash_clientsecret');  
$dashaccess = get_option('yt_dash_access'); 
$yt_dash_additional = get_option('yt_dash_additional');
$yt_dash_style = get_option('yt_dash_style');
$yt_dash_cachetime = get_option('yt_dash_cachetime');
$yt_dash_userapi = get_option('yt_dash_userapi');

if ( is_rtl() ) {
	$float_main="right";
	$float_note="left";
}else{
	$float_main="left";
	$float_note="right";	
}

?>  
<div class="wrap">
<div style="width:70%;float:<?php echo $float_main; ?>;">  
    <?php echo "<h2>" . __( 'Youtube Analytics Dashboard Settings', 'yt_dash' ) . "</h2>"; ?>  
        <form name="yt_dash_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<?php echo "<h3>". __( 'Youtube Analytics API', 'yt_dash' )."</h3>"; ?>  
        <?php echo "<i>".__("You should watch this", 'yt_dash')." <a href='http://www.deconf.com/en/projects/youtube-analytics-dashboard-for-wordpress/' target='_blank'>". __("Step by step video tutorial")."</a> ".__("before proceeding with authorization.", 'yt_dash')."</i>";?>
		<p><input name="yt_dash_userapi" type="checkbox" id="yt_dash_userapi" onchange="this.form.submit()" value="1"<?php if (get_option('yt_dash_userapi')) echo " checked='checked'"; ?>  /><?php echo "<b>".__(" use your own API Project credentials", 'yt_dash' )."</b>"; ?></p>
		<?php
		if (get_option('yt_dash_userapi')){?>
			<p><?php echo "<b>".__("API Key:", 'yt_dash')." </b>"; ?><input type="text" name="yt_dash_apikey" value="<?php echo $apikey; ?>" size="61"></p>  
			<p><?php echo "<b>".__("Client ID:", 'yt_dash')." </b>"; ?><input type="text" name="yt_dash_clientid" value="<?php echo $clientid; ?>" size="60"></p>  
			<p><?php echo "<b>".__("Client Secret:", 'yt_dash')." </b>"; ?><input type="text" name="yt_dash_clientsecret" value="<?php echo $clientsecret; ?>" size="55"></p>  
		<?php }?>
		<p><?php 
			if (get_option('yt_dash_token')){
				echo "<input type=\"submit\" name=\"Reset\" class=\"button button-primary\" value=\"".__("Clear Authorization", 'yt_dash')."\" />";
				?> <input type="submit" name="Clear" class="button button-primary" value="<?php _e('Clear Cache', 'yt_dash' ) ?>" /><?php		
				echo '<input type="hidden" name="yt_dash_hidden" value="Y">';  
			} else{
				echo "<input type=\"submit\" name=\"Authorize\" class=\"button button-primary\" value=\"".__("Authorize Application", 'yt_dash')."\" />";
				?> <input type="submit" name="Clear" class="button button-primary" value="<?php _e('Clear Cache', 'yt_dash' ) ?>" /><?php
				echo '<input type="hidden" name="yt_dash_hidden" value="A">';
				echo "</form>";
				_e("(the rest of the settings will show up after completing the authorization process)", 'yt_dash' );
				echo "</div>";
				?>
				<div class="note" style="float:<?php echo $float_note; ?>;text-align:<?php echo $float_main; ?>;"> 
						<center>
							<h3><?php _e("Setup Tutorial",'yt_dash') ?></h3>
							<a href="http://www.deconf.com/en/projects/youtube-analytics-dashboard-for-wordpress/" target="_blank"><img src="../wp-content/plugins/youtube-analytics/img/video-tutorial.png" width="95%" /></a>
						</center>
						<center>
							<br /><h3><?php _e("Support Links",'yt_dash') ?></h3>
						</center>			
						<ul>
							<li><a href="http://www.deconf.com/en/projects/youtube-analytics-dashboard-for-wordpress/" target="_blank"><?php _e("Youtube Analytics Dashboard Official Page",'yt_dash') ?></a></li>
							<li><a href="http://wordpress.org/support/plugin/youtube-analytics/" target="_blank"><?php _e("Youtube Analytics Dashboard Wordpress Support",'yt_dash') ?></a></li>
							<li><a href="http://forum.deconf.com/en/wordpress-plugins-f182/" target="_blank"><?php _e("Youtube Analytics Dashboard on Deconf Forum",'yt_dash') ?></a></li>			
						</ul>
						<center>
							<br /><h3><?php _e("Useful Plugins",'yt_dash') ?></h3>
						</center>			
						<ul>
							<li><a href="http://wordpress.org/extend/plugins/google-analytics-dashboard-for-wp/" target="_blank"><?php _e("Google Analytics Dashboard",'yt_dash') ?></a></li>
							<li><a href="http://wordpress.org/extend/plugins/google-adsense-dashboard-for-wp/" target="_blank"><?php _e("Google Adsense Dashboard",'yt_dash') ?></a></li>
							<li><a href="http://wordpress.org/extend/plugins/clicky-analytics/" target="_blank"><?php _e("Clicky Analytics",'yt_dash') ?></a></li>						
							<li><a href="http://wordpress.org/extend/plugins/follow-us-box/" target="_blank"><?php _e("Follow Us Box",'yt_dash') ?></a></li>			
						</ul>			
				</div></div><?php				
				return;
			} ?>
		</p>  
		<?php echo "<h3>" . __( 'Access Level', 'yt_dash' ). "</h3>";?>
		<p><?php _e("View Access Level: ", 'yt_dash' ); ?>
		<select id="yt_dash_access" name="yt_dash_access">
			<option value="manage_options" <?php if (($dashaccess=="manage_options") OR (!$dashaccess)) echo "selected='yes'"; echo ">".__("Administrators", 'yt_dash');?></option>
			<option value="edit_pages" <?php if ($dashaccess=="edit_pages") echo "selected='yes'"; echo ">".__("Editors", 'yt_dash');?></option>
			<option value="publish_posts" <?php if ($dashaccess=="publish_posts") echo "selected='yes'"; echo ">".__("Authors", 'yt_dash');?></option>
			<option value="edit_posts" <?php if ($dashaccess=="edit_posts") echo "selected='yes'"; echo ">".__("Contributors", 'yt_dash');?></option>
		</select></p>

		<?php echo "<h3>" . __( 'Additional Stats', 'yt_dash' ). "</h3>";?>
		<p><input name="yt_dash_additional" type="checkbox" id="yt_dash_additional" value="1"<?php if (get_option('yt_dash_additional')) echo " checked='checked'"; ?>  /><?php _e(" show additional stats like engagement and annotations performance", 'yt_dash' ); ?></p>
		<p><?php _e("CSS Settings: ", 'yt_dash' ); ?>
		<select id="yt_dash_style" name="yt_dash_style">
			<option value="red" <?php if (($yt_dash_style=="red") OR (!$yt_dash_style)) echo "selected='yes'"; echo ">".__("Red Theme", 'yt_dash');?></option>
			<option value="light" <?php if ($yt_dash_style=="light") echo "selected='yes'"; echo ">".__("Light Theme", 'yt_dash');?></option>
		</select></p>
		
		<?php echo "<h3>" . __( 'Cache Settings', 'yt_dash' ). "</h3>";?>
		<p><?php _e("Cache Time: ", 'yt_dash' ); ?>
		<select id="yt_dash_cachetime" name="yt_dash_cachetime">
			<option value="18000" <?php if ($yt_dash_cachetime=="18000") echo "selected='yes'"; echo ">".__("5 hours", 'yt_dash');?></option>
			<option value="36000" <?php if ($yt_dash_cachetime=="36000") echo "selected='yes'"; echo ">".__("10 hours", 'yt_dash');?></option>
			<option value="86400" <?php if (($yt_dash_cachetime=="86400") OR (!$yt_dash_cachetime)) echo "selected='yes'"; echo ">".__("1 day", 'yt_dash');?></option>
		</select></p>

		<p class="submit">  
        <input type="submit" name="Submit" class="button button-primary" value="<?php _e('Update Options', 'yt_dash' ) ?>" />
        </p>  
    </form>  
</div>
<div class="note" style="float:<?php echo $float_note; ?>;text-align:<?php echo $float_main; ?>;"> 
		<center>
			<h3><?php _e("Setup Tutorial",'yt_dash') ?></h3>
			<a href="http://www.deconf.com/en/projects/youtube-analytics-dashboard-for-wordpress/" target="_blank"><img src="../wp-content/plugins/youtube-analytics/img/video-tutorial.png" width="95%" /></a>
		</center>
		<center>
			<br /><h3><?php _e("Support Links",'yt_dash') ?></h3>
		</center>			
		<ul>
			<li><a href="http://www.deconf.com/en/projects/youtube-analytics-dashboard-for-wordpress/" target="_blank"><?php _e("Youtube Analytics Dashboard Official Page",'yt_dash') ?></a></li>
			<li><a href="http://wordpress.org/support/plugin/youtube-analytics/" target="_blank"><?php _e("Youtube Analytics Dashboard Wordpress Support",'yt_dash') ?></a></li>
			<li><a href="http://forum.deconf.com/en/wordpress-plugins-f182/" target="_blank"><?php _e("Youtube Analytics Dashboard on Deconf Forum",'yt_dash') ?></a></li>			
		</ul>
		<center>
			<br /><h3><?php _e("Useful Plugins",'yt_dash') ?></h3>
		</center>			
		<ul>
			<li><a href="http://wordpress.org/extend/plugins/google-analytics-dashboard-for-wp/" target="_blank"><?php _e("Google Analytics Dashboard",'yt_dash') ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/google-adsense-dashboard-for-wp/" target="_blank"><?php _e("Google Adsense Dashboard",'yt_dash') ?></a></li>
			<li><a href="http://wordpress.org/extend/plugins/clicky-analytics/" target="_blank"><?php _e("Clicky Analytics",'yt_dash') ?></a></li>						
			<li><a href="http://wordpress.org/extend/plugins/follow-us-box/" target="_blank"><?php _e("Follow Us Box",'yt_dash') ?></a></li>			
		</ul>			
</div>
</div>