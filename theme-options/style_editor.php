<div class="wrap general-options">
	<h2>Ads & Banner Style Editor</h2>

	<?php 
		/**
		 * saved notification
		 */
		if(isset($_REQUEST['settings-updated']) && $_REQUEST['settings-updated']==true) {
		    echo "<div id='message' class='updated'><p><strong>" . __("Settings saved",TONJOO_SIMPLE_ADS) . "</strong></p></div>";
		} 
	?>

	<form method="post" action="options.php"> 
		<?php 
			/**
			 * load settings field
			 * load saved / default options
			 */
			settings_fields('tonjoo_spb_subopt');
			$options = spb_get_options();
			$desktop = $options['desktop'];
			$mobile = $options['mobile'];
		?>

		<div class="metabox-holder columns-2" style="margin-right: 300px;">
		
		<!-- Section container -->
		<div id='opt-readmore' class="postbox-container group" style="width: 100%;min-width: 463px;float: left; ">
		
		<!-- Desktop -->
		<div class="meta-box-sortables ui-sortable">
		<div id="adminform" class="postbox">
		<h3 class="hndle"><span><?php _e('Desktop View',TONJOO_SIMPLE_ADS) ?></span></h3>
		<div class="inside" style="z-index:1;">
		<table class="form-table">
			
			<tr>
				<th><?php _e("Enable Style",TONJOO_SIMPLE_ADS) ?></th>
				<td><input type="checkbox" name="spb_subopt[desktop][enable_style]" value="yes" <?php if($desktop['enable_style'] == 'yes') echo "checked" ?> ></td>
			</tr>			
			<tr>
				<th><?php _e("Background Color",TONJOO_SIMPLE_ADS) ?></th>
				<td><input type="text" class="regular-text minicolors" name="spb_subopt[desktop][background_color]"  value="<?php echo $desktop['background_color'] ?>"></td>
			</tr>
			<tr>
				<th><?php _e("Text Above Banner",TONJOO_SIMPLE_ADS) ?></th>
				<td><input type="text" class="regular-text" name="spb_subopt[desktop][text]"  value="<?php echo $desktop['text'] ?>"></td>
			</tr>
	
			<tr><td colspan="3"><h3 class="meta-subtitle"><?php _e("Text above banner options below is available in PRO version",TONJOO_SIMPLE_ADS) ?></h3></td></tr>

			<tr>
				<th colspan="2" class="premium-features">
					<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-2.jpg") ?>">
				</th>
			</tr>
			
			<tr><td colspan="3"><h3 class="meta-subtitle"><?php _e("Banner options below is available in PRO version",TONJOO_SIMPLE_ADS) ?></h3></td></tr>

			<tr>
				<th colspan="2" class="premium-features">
					<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-3.jpg") ?>">
				</th>
			</tr>

		</table>
		</div>			
		</div>			
		</div>	

		<!-- Mobile -->
		<div class="meta-box-sortables ui-sortable">
		<div id="adminform" class="postbox">
		<h3 class="hndle"><span><?php _e('Mobile View (Available in PRO Version)',TONJOO_SIMPLE_ADS) ?></span></h3>
		<div class="inside" style="z-index:1;">
		<table class="form-table">
			
			<tr>
				<th colspan="2" class="premium-features">
					<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-4.jpg") ?>">
				</th>
			</tr>
	
			<tr><td colspan="3"><h3 class="meta-subtitle"><?php _e("Text above banner options below is available in PRO version",TONJOO_SIMPLE_ADS) ?></h3></td></tr>

			<tr>
				<th colspan="2" class="premium-features">
					<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-2.jpg") ?>">
				</th>
			</tr>

			<tr><td colspan="3"><h3 class="meta-subtitle"><?php _e("Banner options below is available in PRO version",TONJOO_SIMPLE_ADS) ?></h3></td></tr>

			<tr>
				<th colspan="2" class="premium-features">
					<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-3.jpg") ?>">
				</th>
			</tr>
			
		</table>
		</div>			
		</div>			
		</div>

		<!-- End sections -->
		</div>


		<!-- SIDEBAR -->
		<div class="postbox-container" style="float: right;margin-right: -300px;width: 280px;">
		<div class="metabox-holder" style="padding-top:0px;">	
		<div class="meta-box-sortables ui-sortable">
			<div id="email-signup" class="postbox">
				<h3 class="hndle"><span><?php _e('Save Options',TONJOO_SIMPLE_ADS) ?></span></h3>
				<div class="inside" style="padding-top:10px;">
					<?php _e('Save your changes to apply the options',TONJOO_SIMPLE_ADS) ?>
					<br><br>
					<input type="submit" class="button-primary" value="<?php _e('Save Options',TONJOO_SIMPLE_ADS) ?>" />					
				</div>
			</div>
		</div>
		</div>

		<div class="metabox-holder" style="padding-top:0px;">	
		<div class="meta-box-sortables ui-sortable">
			<div id="email-signup" class="postbox">
				<h3 class="hndle"><span><?php _e('Reset Options',TONJOO_SIMPLE_ADS) ?></span></h3>
				<div class="inside" style="padding-top:10px;">
					<?php _e('Reset to the default options. Warning, this cannot be undone.',TONJOO_SIMPLE_ADS) ?>
					<br><br>
					<a href="javascript:;" id="reset_options" class="button"><?php _e('Reset Options',TONJOO_SIMPLE_ADS) ?></a>					
				</div>
			</div>
		</div>
		</div>

		<?php require_once(TONJOO_SIMPLE_ADS_DIR . 'theme-options/ads.php') ?>
		
		</div>
		</div>

	</form>
</div>

<!-- Modal delete confirm -->
<div id="spb-premium-notification" title="<?php _e('PRO Version',TONJOO_SIMPLE_ADS) ?>">
	<div class="spb-notification-img">
		<img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/simple_ads_banner_250px_premium.jpg") ?>">    	
	</div>

	<p class="spb-notification-text">
		<?php _e('These features are available in Pro Version. Unleash the full potential of Inline Banner and Ads Manager by upgrading to PRO Version!',TONJOO_SIMPLE_ADS) ?>
	</p>

	<div class="spb-notification-button">
		<a href="https://tonjoostudio.com/product/simple-ads-and-banner-manager/?utm_source=wp_dashboard&utm_medium=banner&utm_campaign=uc" target="_blank" class="button"><?php _e('Upgrade To PRO!',TONJOO_SIMPLE_ADS) ?></a>
	</div>
</div>