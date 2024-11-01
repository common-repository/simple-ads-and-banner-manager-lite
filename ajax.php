<?php 

// spb_move_banner
add_action('wp_ajax_spb_move_banner', 'spb_move_banner_ajax_callback');
function spb_move_banner_ajax_callback()
{
	// VALIDASI
	if( !intval( $_POST['post_id'] ) )
		die();

	$post_id = intval($_POST['post_id']);

	$meta = get_post_meta( $post_id ,'spb_pos' , true );

	// empty old
	$meta[ 'position' ] = array();
	$meta[ 'key_banner' ] = array();

	// position
	$intloop = 0;
	foreach ( $_POST['data'] as $new_pos) {
		$meta[ 'position' ][ $new_pos ] = 'banner';
		$meta[ 'key_banner' ][ $new_pos ] = $_POST['key_banner'][$intloop];

		$intloop++;
	}

	update_post_meta($post_id , 'spb_pos',$meta );
	update_post_meta($post_id , 'spb_custom_hash',true );

	die();
}

// reset banner positions
add_action('wp_ajax_reset_positions', 'ajax_reset_positions' );
function ajax_reset_positions() 
{
	// ENYAH !
	delete_post_meta_by_key('spb_custom_hash');

	// update reset code kak biar keupdate di depan :)
	$random = wp_generate_password();

   	$new_hash = 'current-hash-'.$random;

	$options = spb_get_setting();

	$options['setting']['hash_positions'] = $random;

	update_option('spb_opt',$options);

	echo "reset ok";
	
    die();
}

// reset style editor
add_action('wp_ajax_reset_style_editor', 'ajax_reset_style_editor' );
function ajax_reset_style_editor()
{
	delete_option('spb_subopt');

    die();
}
