<div id="postbox-container-settings" class="postbox-container">

<!-- Settings -->
<div id="side-sortables" class="meta-box-sortables ui-sortable">
<div id="dashboard_quick_press" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div>
<h2 class="hndle ui-sortable-handle"><span><?php _e("Settings",TONJOO_SIMPLE_ADS) ?></span></h2>
<div class="inside">
<div class="main">
<div class="section_content">
   <div class="form-group-setting premium-features premium-features-images">
      <img src="<?php echo plugins_url(TONJOO_SIMPLE_ADS_DIR_NAME."/assets/premium-feature-1.jpg") ?>">
   </div>  

   <div class="form-group-setting">
      <label><?php _e("Limit Banner to logged in users",TONJOO_SIMPLE_ADS) ?></label>
      <select name="spb_opt[setting][only_loggedin]">
         <option value="yes" <?php selected( $spb['setting']['only_loggedin'], 'yes', true ); ?>><?php _e("Yes",TONJOO_SIMPLE_ADS) ?></option>
         <option value="no" <?php selected( $spb['setting']['only_loggedin'], 'no', true ); ?>><?php _e("No",TONJOO_SIMPLE_ADS) ?></option>
      </select>
   </div>

   <div class="form-group-setting">
      <label><?php _e("Mobile threshold (for css mobile detection)",TONJOO_SIMPLE_ADS) ?></label>
      <input type="number" class="setting-type-input" name="spb_opt[setting][mobile_threshold]" value="<?php echo $spb['setting']['mobile_threshold'] ?>">
   </div>
   
   <div class="form-group-setting checkbox-group">
      <label><?php _e("Show on homepage",TONJOO_SIMPLE_ADS) ?></label>
      <input type="checkbox" name="spb_opt[setting][show_on_homepage]" value="yes" <?php checked( $spb['setting']['show_on_homepage'], 'yes', true ); ?>> <?php _e("Yes",TONJOO_SIMPLE_ADS) ?>
   </div>

   <div class="form-group-setting checkbox-group">
      <label><?php _e("Show on archives",TONJOO_SIMPLE_ADS) ?></label>
      <input type="checkbox" name="spb_opt[setting][show_on_archives]" value="yes" <?php checked( $spb['setting']['show_on_archives'], 'yes', true ); ?>> <?php _e("Yes",TONJOO_SIMPLE_ADS) ?>
   </div>   

   <div class="form-group-setting">
      <div id="submit_float">
         <input name="Submit" type="submit" class="button button-primary button-hero" value="<?php esc_attr_e('Save Options'); ?>" />
         <a href="javascript:;" onclick="window.location.reload(true);" class="button button-cancel-save button-hero" ><?php esc_attr_e('Cancel'); ?></a>
      </div>
   </div>                                    
</div>
</div>
</div>
</div>
</div>

<!-- Reset Positions -->
<div id="side-sortables" class="meta-box-sortables ui-sortable">
<div id="dashboard_quick_press" class="postbox ">
<div class="handlediv" title="Click to toggle"><br></div>
<h2 class="hndle ui-sortable-handle"><span>Reset Positions</span></h2>
<div class="inside">
<div class="main">
<div class="section_content">   
   <p><?php _e("This action will reset all banners with manual positioning on each posts.",TONJOO_SIMPLE_ADS) ?></p>
   <?php 

   // Always reset hash on every save

   $random = wp_generate_password();

   $new_hash = 'current-hash-'.$random;
   ?>
   
   <input type="text" id="reset-positions-val" name="spb_opt[setting][hash_positions]" value="<?php echo $new_hash ?>">

   <div class="form-group-setting">
      <div id="submit_float">
         <a href="javascript:;" id="btn-reset-positions" class="button button-cancel-save button-hero" ><?php esc_attr_e('Reset'); ?></a>
         <span id="reset-loader"></span>
      </div>
   </div>                                    
</div>
</div>
</div>
</div>
</div>

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