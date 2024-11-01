<?php 

add_action( 'init', 'spb_buttons' );
function spb_buttons() {
    add_filter( "mce_external_plugins", "spb_add_buttons" );
    add_filter( 'mce_buttons', 'spb_register_buttons' );
}
function spb_add_buttons( $plugin_array ) {
    $plugin_array['spb_banner_button'] = plugins_url( 'assets/spb-mce.js', __FILE__ ) ;
    return $plugin_array;
}
function spb_register_buttons( $buttons ) {
    array_push( $buttons, 'spb_banner' ); // dropcap', 'recentposts
    return $buttons;
}