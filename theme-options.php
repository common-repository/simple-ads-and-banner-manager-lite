<?php

defined( 'ABSPATH' ) OR exit;

add_action('admin_menu', 'spb_create_theme_options_page');
add_action('admin_init', 'spb_register_and_build_fields');

function spb_create_theme_options_page() {
   add_menu_page('Ads & Banner', 
      'Ads & Banner',
      'moderate_comments',
      'simple-ads-and-banner-manager',
      'spb_options_page_fn',
      'dashicons-editor-insertmore'
   );

   // Options page submenu   
   add_submenu_page('simple-ads-and-banner-manager',     
      __('Style Editor', TONJOO_SIMPLE_ADS), 
      __('Style Editor', TONJOO_SIMPLE_ADS),
      'moderate_comments',
      'tonjoo_simple_ads_options' ,
      'tonjoo_simple_ads_options_callback'
   );
}

function tonjoo_simple_ads_options_callback() {  
   require_once( plugin_dir_path( __FILE__ ) . 'theme-options/style_editor.php');
}

function spb_register_and_build_fields() {   
   register_setting('tonjoo_spb', 'spb_opt');
   register_setting('tonjoo_spb_subopt', 'spb_subopt');
}

function spb_options_page_fn() {
?>
   <div class="spb-wrappesr">
   <div class="wrap">
      <h2><?php echo TONJOO_SIMPLE_ADS_TITLE ?></h2>

      <div style="margin: 8px 0 10px;">
         <?php _e("Plugin by",TONJOO_SIMPLE_ADS_DIR_NAME) ?> 
         <a href='https://tonjoostudio.com' target="_blank">Tonjoo Studio</a> ~ 
         <a href='http://wordpress.org/support/view/plugin-reviews/simple-ads-and-banner-manager?filter=5' target="_blank"><?php _e("Please Rate :)",TONJOO_SIMPLE_ADS_DIR_NAME) ?></a> |
         <a href='http://wordpress.org/extend/plugins/simple-ads-and-banner-manager/' target="_blank"><?php _e("Comment",TONJOO_SIMPLE_ADS_DIR_NAME) ?></a> | 
         <a href='https://forum.tonjoostudio.com/thread-category/simple-ads-and-banner-manager/' target="_blank"><?php _e("Forum",TONJOO_SIMPLE_ADS_DIR_NAME) ?></a> |
         <a href='https://tonjoostudio.com/addons/simple-ads-and-banner-manager/#faq' target="_blank"><?php _e("FAQ",TONJOO_SIMPLE_ADS_DIR_NAME) ?></a>
      </div><hr> <!-- tonjoostudio links -->

      <div class="icon32" id="icon-tools"></div>
      <div id="spb_container" class="onerow">
         <form id="spb_settings" method="post" action="options.php" enctype="multipart/form-data">
            <?php 

            settings_fields('tonjoo_spb');
            do_settings_sections( 'tonjoo_spb' );
            $spb = spb_get_setting();

            ?>

            <div id="spb-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
         
            <div id="wp-admin-content-container">
               <div id="wp-admin-content-left">
                  <div id="wp-admin-content-left-first">
                     <!-- 1ST COL -->
                     <?php require_once(TONJOO_SIMPLE_ADS_DIR . 'theme-options/banners.php') ?>
                  </div>

                  <!-- 2ND COL -->
                  <?php require_once(TONJOO_SIMPLE_ADS_DIR . 'theme-options/settings.php') ?>
               </div>
               
               <div id="wp-admin-content-right"><!-- 3RD COL -->
                  <?php require_once(TONJOO_SIMPLE_ADS_DIR . 'theme-options/ads.php') ?>
               </div> 
            </div> 

            </div><!-- wp-admin-content-container -->
            </div>
            </div>


         </form>
      </div>
   </div>
   </div>

<?php
}

function get_available_post_types(){
   $av_post_types = get_post_types();
   unset($av_post_types['attachment']);
   unset($av_post_types['revision']);
   unset($av_post_types['nav_menu_item']);

   return $av_post_types;
}

function get_available_terms(){
   global $wpdb;

   $terms = $wpdb->get_results( "SELECT term_id, name FROM $wpdb->terms" );
   $return = array();
   foreach ($terms as $key => $term) {
      $return[$term->term_id] = $term->name;
   }

   return $return;
}

function get_available_banner_types() {
   $type = array(
      'banner' => 'Banner and Link',
      'googleads' => 'Google Ads',
      'editor' => 'Text Editor',      
      'shortcode' => 'Shortcode',
   );

   return $type;
}

function spb_get_setting() {
   $spb = get_option('spb_opt');

   $spb['setting']['show_on_homepage'] = isset( $spb['setting']['show_on_homepage'] ) ? $spb['setting']['show_on_homepage'] : "no";
   $spb['setting']['show_on_archives'] = isset( $spb['setting']['show_on_archives'] ) ? $spb['setting']['show_on_archives'] : "no"; 
   $spb['setting']['mobile_threshold'] = isset( $spb['setting']['mobile_threshold'] ) ? $spb['setting']['mobile_threshold'] : "414"; 
   $spb['setting']['only_loggedin']    = isset( $spb['setting']['only_loggedin'] ) ? $spb['setting']['only_loggedin'] : "no";    
   $spb['setting']['show_on']          = isset( $spb['setting']['show_on'] ) ? $spb['setting']['show_on'] : array('post');
   $spb['setting']['hash_positions']   = isset( $spb['setting']['hash_positions'] ) ? $spb['setting']['hash_positions'] : 'current-hash-' . wp_rand();

   return $spb;
}

function spb_get_options() {
   $spb = get_option('spb_subopt');

   // desktop
   $desktop = isset($spb['desktop']) ? $spb['desktop'] : array();

   if(count($desktop) == 0) {
      $enable_style = "yes";
   }
   else {
      $enable_style = isset( $desktop['enable_style'] ) ? $desktop['enable_style'] : "";
   }

   $desktop['enable_style'] = $enable_style;
   $desktop['background_color'] = isset( $desktop['background_color'] ) ? $desktop['background_color'] : "";   
   $desktop['text'] = isset( $desktop['text'] ) ? $desktop['text'] : "";   
   $desktop['text_size'] = isset( $desktop['text_size'] ) ? $desktop['text_size'] : "10";   
   $desktop['text_color'] = isset( $desktop['text_color'] ) ? $desktop['text_color'] : "#333333";   
   $desktop['font'] = isset( $desktop['font'] ) ? $desktop['font'] : "";   

   $desktop['padding-top'] = isset( $desktop['padding-top'] ) ? $desktop['padding-top'] : "0px";
   $desktop['padding-right'] = isset( $desktop['padding-right'] ) ? $desktop['padding-right'] : "0px";
   $desktop['padding-bottom'] = isset( $desktop['padding-bottom'] ) ? $desktop['padding-bottom'] : "0px";
   $desktop['padding-left'] = isset( $desktop['padding-left'] ) ? $desktop['padding-left'] : "0px";

   $desktop['padding-text-top'] = isset( $desktop['padding-text-top'] ) ? $desktop['padding-text-top'] : "5px";
   $desktop['padding-text-right'] = isset( $desktop['padding-text-right'] ) ? $desktop['padding-text-right'] : "5px";
   $desktop['padding-text-bottom'] = isset( $desktop['padding-text-bottom'] ) ? $desktop['padding-text-bottom'] : "5px";
   $desktop['padding-text-left'] = isset( $desktop['padding-text-left'] ) ? $desktop['padding-text-left'] : "5px";

   $desktop['margin-text-top'] = isset( $desktop['margin-text-top'] ) ? $desktop['margin-text-top'] : "0px";
   $desktop['margin-text-right'] = isset( $desktop['margin-text-right'] ) ? $desktop['margin-text-right'] : "0px";
   $desktop['margin-text-bottom'] = isset( $desktop['margin-text-bottom'] ) ? $desktop['margin-text-bottom'] : "0px";
   $desktop['margin-text-left'] = isset( $desktop['margin-text-left'] ) ? $desktop['margin-text-left'] : "0px";

   $desktop['margin-top'] = isset( $desktop['margin-top'] ) ? $desktop['margin-top'] : "0px";
   $desktop['margin-right'] = isset( $desktop['margin-right'] ) ? $desktop['margin-right'] : "0px";
   $desktop['margin-bottom'] = isset( $desktop['margin-bottom'] ) ? $desktop['margin-bottom'] : "0px";
   $desktop['margin-left'] = isset( $desktop['margin-left'] ) ? $desktop['margin-left'] : "0px";

   $desktop['text_bold'] = isset( $desktop['text_bold'] ) ? $desktop['text_bold'] : "";
   $desktop['text_italic'] = isset( $desktop['text_italic'] ) ? $desktop['text_italic'] : "";

   // mobile
   $mobile = isset($spb['mobile']) ? $spb['mobile'] : array();

   if(count($mobile) == 0) {
      $enable_style = "yes";
   }
   else {
      $enable_style = isset( $mobile['enable_style'] ) ? $mobile['enable_style'] : "";
   }

   $mobile['enable_style'] = $enable_style;
   $mobile['background_color'] = isset( $mobile['background_color'] ) ? $mobile['background_color'] : "";   
   $mobile['text'] = isset( $mobile['text'] ) ? $mobile['text'] : "";   
   $mobile['text_size'] = isset( $mobile['text_size'] ) ? $mobile['text_size'] : "10";   
   $mobile['text_color'] = isset( $mobile['text_color'] ) ? $mobile['text_color'] : "#333333";   
   $mobile['font'] = isset( $mobile['font'] ) ? $mobile['font'] : "";   
   
   $mobile['padding-text-top'] = isset( $mobile['padding-text-top'] ) ? $mobile['padding-text-top'] : "5px";
   $mobile['padding-text-right'] = isset( $mobile['padding-text-right'] ) ? $mobile['padding-text-right'] : "5px";
   $mobile['padding-text-bottom'] = isset( $mobile['padding-text-bottom'] ) ? $mobile['padding-text-bottom'] : "5px";
   $mobile['padding-text-left'] = isset( $mobile['padding-text-left'] ) ? $mobile['padding-text-left'] : "5px";

   $mobile['margin-text-top'] = isset( $mobile['margin-text-top'] ) ? $mobile['margin-text-top'] : "0px";
   $mobile['margin-text-right'] = isset( $mobile['margin-text-right'] ) ? $mobile['margin-text-right'] : "0px";
   $mobile['margin-text-bottom'] = isset( $mobile['margin-text-bottom'] ) ? $mobile['margin-text-bottom'] : "0px";
   $mobile['margin-text-left'] = isset( $mobile['margin-text-left'] ) ? $mobile['margin-text-left'] : "0px";

   $mobile['padding-top'] = isset( $mobile['padding-top'] ) ? $mobile['padding-top'] : "0px";
   $mobile['padding-right'] = isset( $mobile['padding-right'] ) ? $mobile['padding-right'] : "0px";
   $mobile['padding-bottom'] = isset( $mobile['padding-bottom'] ) ? $mobile['padding-bottom'] : "0px";
   $mobile['padding-left'] = isset( $mobile['padding-left'] ) ? $mobile['padding-left'] : "0px";

   $mobile['margin-top'] = isset( $mobile['margin-top'] ) ? $mobile['margin-top'] : "0px";
   $mobile['margin-right'] = isset( $mobile['margin-right'] ) ? $mobile['margin-right'] : "0px";
   $mobile['margin-bottom'] = isset( $mobile['margin-bottom'] ) ? $mobile['margin-bottom'] : "0px";
   $mobile['margin-left'] = isset( $mobile['margin-left'] ) ? $mobile['margin-left'] : "0px";

   $mobile['text_bold'] = isset( $mobile['text_bold'] ) ? $mobile['text_bold'] : "";
   $mobile['text_italic'] = isset( $mobile['text_italic'] ) ? $mobile['text_italic'] : "";

   // merge
   $new_spb = array();
   $new_spb['desktop'] = $desktop;
   $new_spb['mobile'] = $mobile;

   return $new_spb;
}

function spb_get_fonts() 
{   
   $fonts_array = array(
      '0' => array(
         'value' =>  '',
         'label' =>  'Use Content Font'
         ),
      '1' => array(
         'value' =>  'Open Sans',
         'label' =>  'Open Sans'
         ),
      '2' => array(
         'value' =>  'Lobster',
         'label' =>  'Lobster'
         ),
      '3' => array(
         'value' =>  'Lobster Two',
         'label' =>  'Lobster Two'
         ),
      '4' => array(
         'value' =>  'Ubuntu',
         'label' =>  'Ubuntu'
         ),
      '5' => array(
         'value' =>  'Ubuntu Mono',
         'label' =>  'Ubuntu Mono'
         ),
      '6' => array(
         'value' =>  'Titillium Web',
         'label' =>  'Titillium Web'
         ),
      '7' => array(
         'value' =>  'Grand Hotel',
         'label' =>  'Grand Hotel'
         ),
      '8' => array(
         'value' =>  'Pacifico',
         'label' =>  'Pacifico'
         ),
      '9' => array(
         'value' =>  'Crafty Girls',
         'label' =>  'Crafty Girls'
         ),
      '10' => array(
         'value' =>  'Bevan',
         'label' =>  'Bevan'
         )
   );

   return $fonts_array;
}


function spb_print_select_option($options){
   $r='';

   foreach ( $options['select_array'] as $select ) {
      $label = $select['label'];

      if ( $options['value'] == $select['value'] ) // Make default first in list
         $r .= "<option selected='selected' value='" . esc_attr( $select['value'] ) . "'>$label</option>";
      else
         $r .= "<option value='" . esc_attr( $select['value'] ) . "'>$label</option>";
   }
   
   $options['id'] = isset($options['id']) ? $options['id'] : '';
   $options['description'] = isset($options['description']) ? $options['description'] : '';

   $print_select= "<tr valign='top' id='{$options['id']}'>
                  <th scope='row'>{$options['label']}</th>
                  <td>
                     <select name='{$options['name']}'>
                     {$r}
                     </select>                     
                  </td>
                  <td>
                     {$options['description']}
                  </td>
               </tr>
               ";

   echo $print_select;
}