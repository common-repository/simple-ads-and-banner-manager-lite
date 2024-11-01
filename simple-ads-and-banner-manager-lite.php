<?php
/**
 * Plugin Name: Inline Banner and Ads Manager LITE
 * Plugin URI: https://tonjoostudio.com/product/simple-ads-and-banner-manager/
 * Description: LITE Version. Automatically put a banner on the middle of the paragraph / post.
 * Version: 2.0.0
 * Author: tonjoo 
 * Author URI: http://todiadiyatmo.com/
 * Text Domain: simple-ads-and-banner-manager
 * Domain Path: /languages/
 * License: GPLv2
 */

if (! defined('TONJOO_SIMPLE_ADS_VERSION'))
{
	define("TONJOO_SIMPLE_ADS_VERSION", '2.0.0');
    define("TONJOO_SIMPLE_ADS", 'simple-ads-and-banner-manager');
    define("TONJOO_SIMPLE_ADS_FILE", 'simple-ads-and-banner-manager-lite');
	define("TONJOO_SIMPLE_ADS_LITE", 'simple-ads-and-banner-manager-lite');
	define("TONJOO_SIMPLE_ADS_TITLE", 'Inline Banner and Ads Manager LITE');
	define('TONJOO_SIMPLE_ADS_DIR', plugin_dir_path( __FILE__ ) );
	define('TONJOO_SIMPLE_ADS_DIR_NAME', str_replace("/" . TONJOO_SIMPLE_ADS_LITE . ".php", "", plugin_basename(__FILE__)));

    // Localization
    add_action('plugins_loaded', 'spb_plugins_loaded');
    function spb_plugins_loaded() {
        load_plugin_textdomain(TONJOO_SIMPLE_ADS, false, dirname(plugin_basename( __FILE__ )) . '/languages');
    }
}

$tonjoo_simple_ads_version = 'Lite';
require_once(plugin_dir_path( __FILE__ ) . 'activate.php');

/** 
 * Display a notice that can be dismissed 
 */
add_action('admin_notices', 'tonjoo_simple_ads_lite_notice');
function tonjoo_simple_ads_lite_notice() 
{
    global $current_user ;

    $user_id = $current_user->ID;
    $ignore_notice = get_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_notice', true);
    $ignore_count_notice = get_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice', true);
    $max_count_notice = 15;

    // if usermeta(ignore_count_notice) is not exist
    if($ignore_count_notice == "")
    {
        add_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice', $max_count_notice, true);

        $ignore_count_notice = 0;
    }

    // display the notice or not
    if($ignore_notice == 'forever')
    {
        $is_ignore_notice = true;
    }
    else if($ignore_notice == 'later' && $ignore_count_notice < $max_count_notice)
    {
        $is_ignore_notice = true;

        update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice', intval($ignore_count_notice) + 1);
    }
    else
    {
        $is_ignore_notice = false;
    }

    /* Check that the user hasn't already clicked to ignore the message & if premium not installed */
    if (! $is_ignore_notice  && ! function_exists("is_tonjoo_simple_ads_lite_exist")) 
    {
        printf(__('%1$s Unleash the full potential of %2$s Inline Banner and Ads Manager %3$s by upgrading to pro version! %4$s Do not bug me again %5$s Not Now %6$s %7$s',TONJOO_SIMPLE_ADS), 
            '<div class="updated"><p>',
            '<a href="https://tonjoostudio.com/product/simple-ads-and-banner-manager/" target="_blank"><b>', 
            '</b></a>', '<span style="float:right;"><a href="?tonjoo_simple_ads_lite_nag_ignore=forever" style="color:#a00;">', 
            '</a> <a href="?tonjoo_simple_ads_lite_nag_ignore=later" class="button button-primary" style="margin:-5px -5px 0 5px;vertical-align:baseline;">',
            '</a></span>', '</p></div>');
    }
}

add_action('admin_init', 'tonjoo_simple_ads_lite_nag_ignore');
function tonjoo_simple_ads_lite_nag_ignore() 
{
    global $current_user;
    $user_id = $current_user->ID;

    // Redirecting
    function redirecting() 
    {
    	$location = admin_url("admin.php?page=simple-ads-and-banner-manager") . '&settings-updated=true';

        wp_die(sprintf('%1$s <h3>Redirecting..</h3> <p>Click %2$shere%3$s if the auto redirecting is take a long time.</p>',
	        "<meta http-equiv='refresh' content='0;url=$location' />",
	        "<a href='$location'><strong>", "</strong></a>"));
    }

    // If user clicks to ignore the notice, add that to their user meta
    if (isset($_GET['tonjoo_simple_ads_lite_nag_ignore']) && $_GET['tonjoo_simple_ads_lite_nag_ignore'] == 'forever') 
    {
        update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_notice', 'forever');

        redirecting();
    }
    else if (isset($_GET['tonjoo_simple_ads_lite_nag_ignore']) && $_GET['tonjoo_simple_ads_lite_nag_ignore'] == 'later') 
    {
        update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_notice', 'later');
        update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice', 0);

        $total_ignore_notice = get_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice_total', true); 

        if($total_ignore_notice == '') $total_ignore_notice = 0;

        update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_count_notice_total', intval($total_ignore_notice) + 1);

        if(intval($total_ignore_notice) >= 5)
        {
            update_user_meta($user_id, 'tonjoo_simple_ads_lite_ignore_notice', 'forever');
        }

        redirecting();
    }        
}