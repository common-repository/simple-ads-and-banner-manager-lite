<?php

register_activation_hook( plugin_dir_path( __DIR__ ) . TONJOO_SIMPLE_ADS_FILE . '.php', 'tonjoo_simple_ads_activate');

if(! function_exists('tonjoo_simple_ads_activate'))
{
	define('TONJOO_SIMPLE_ADS_ACTIVATED',$tonjoo_simple_ads_version);

    function tonjoo_simple_ads_activate() { /* silent is golden */ }

    add_action('plugins_loaded','tonjoo_simple_ads_plugins_loaded_on_activated');
    function tonjoo_simple_ads_plugins_loaded_on_activated() {
    	require_once( plugin_dir_path( __FILE__ ) . 'functions.php');
    }
}
else
{
    deactivate_plugins( plugin_dir_path( __DIR__ ) . TONJOO_SIMPLE_ADS_FILE . '.php' );

    $str = '<p><strong>' . TONJOO_SIMPLE_ADS_TITLE . ' '  .TONJOO_SIMPLE_ADS_ACTIVATED .'</strong> is still active! <br>';
    $str.= 'Please <strong>Deactivate</strong> it first before activate this '.$tonjoo_simple_ads_version.' version.</p>';
    $str.= '<p><a class="button button-primary" href='.admin_url('plugins.php').'>Back to Plugin Page</a></p>';
    
    wp_die($str);
}