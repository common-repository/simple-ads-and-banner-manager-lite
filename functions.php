<?php

require_once(TONJOO_SIMPLE_ADS_DIR . 'theme-options.php');
require_once(TONJOO_SIMPLE_ADS_DIR . 'shortcode.php');
require_once(TONJOO_SIMPLE_ADS_DIR . 'post-meta.php');
require_once(TONJOO_SIMPLE_ADS_DIR . 'ajax.php');
require_once(TONJOO_SIMPLE_ADS_DIR . 'button-mce.php');

add_action('admin_enqueue_scripts', 'spb_admin_scripts' );
function spb_admin_scripts($hooks)
{
	wp_enqueue_style( 'spb', plugins_url('assets/spb-mce.css', __FILE__ ) );

	if($hooks == 'toplevel_page_simple-ads-and-banner-manager')
	{
		wp_enqueue_script('jquery');
		wp_enqueue_style("wp-jquery-ui-dialog");
		wp_enqueue_script('jquery-ui-dialog');

		wp_enqueue_script( 'repeatable-fields', plugins_url( 'assets/repeatable-fields.js', __FILE__ ), array('jquery'), TONJOO_SIMPLE_ADS_VERSION, true );
		wp_enqueue_script( 'selectize', plugins_url( 'assets/selectize.js', __FILE__ ), array('jquery'), TONJOO_SIMPLE_ADS_VERSION, true );	
		wp_enqueue_script( 'spb', plugins_url( 'assets/spb.js', __FILE__ ), array('jquery', 'repeatable-fields'), TONJOO_SIMPLE_ADS_VERSION, true );	
		wp_enqueue_style( 'spb-style', plugins_url('assets/spb.css', __FILE__ ) );
		wp_enqueue_style( 'spb-mce-style', plugins_url('assets/spb-mce.css', __FILE__ ) );
		wp_localize_script( 'spb', 'spb_obj', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			)
		);

	    // ace editor
		wp_enqueue_script('ace-js',plugin_dir_url( __FILE__ )."assets/ace-min-noconflict-css-monokai/ace.js",array(),TONJOO_SIMPLE_ADS_VERSION);

		// for upload image
		if(function_exists('wp_enqueue_media')) {
	        wp_enqueue_media();
	    }
	    else {
	        wp_enqueue_script('media-upload');
	        wp_enqueue_script('thickbox');
	        wp_enqueue_style('thickbox');
	    }
	}
	else if($hooks == 'ads-banner_page_tonjoo_simple_ads_options')
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style("wp-jquery-ui-dialog");

		// minicolor
    	wp_enqueue_style('spb-minicolor',plugin_dir_url( __FILE__ )."assets/jquery-minicolors/jquery.minicolors.css",array(),TONJOO_SIMPLE_ADS_VERSION);
    	wp_enqueue_script('spb-minicolor',plugin_dir_url( __FILE__ )."assets/jquery-minicolors/jquery.minicolors.js",array(),TONJOO_SIMPLE_ADS_VERSION);
	
    	// css and js
    	wp_enqueue_style('spb-style-editor', plugins_url('assets/style-editor.css', __FILE__ ) );
    	wp_enqueue_script('spb-style-editor',plugin_dir_url( __FILE__ )."assets/style-editor.js",array(),TONJOO_SIMPLE_ADS_VERSION);
	}    
}

add_action( 'wp_enqueue_scripts', 'spb_scripts' );
function spb_scripts(){
	wp_register_style( 'spb-front', plugins_url( 'assets/tonjoo_spb.css', __FILE__ ) );
	wp_register_script( 'spb-front', plugins_url( 'assets/tonjoo_spb.js', __FILE__ ), array('jquery'), TONJOO_SIMPLE_ADS_VERSION, true );
}

/**
 * Do Filter after this 
 * add_filter('the_content', 'do_shortcode', 11); // AFTER wpautop()
 * So we can preserve shortcode
 */
add_filter('the_content', 'spb_content', 10 );

function spb_content($content) {
	global $post;

	$shortcode = '[tonjoo_spb]';

	$spb = spb_get_setting();

	$postype_arr = ( !empty($spb['setting']['show_on'])) ? $spb['setting']['show_on'] : array();

	// Default 
	if(!$content||$content==''||!in_array(get_post_type(), $postype_arr))
		return $content;

	// not used in archive or home base on setting
	if(!is_singular() && $spb['setting']['show_on_archives'] == 'no'  && $spb['setting']['show_on_homepage'] == 'no' )
		return $content;

	// if current page is front page and disable for home
	if( $spb['setting']['show_on_homepage'] == 'no' && is_front_page())
		return $content;
	// if current page is archive and disable for home
	if( $spb['setting']['show_on_archives'] == 'no' && is_archive())
		return $content;

	// if set to only logged in user
	if(!is_user_logged_in() && $spb['setting']['only_loggedin'] == 'yes'){
		return spb_strip_shortcode('tonjoo_spb', $content);
	}

	// if have post meta disable spb
	if(get_post_meta( $post->ID,'disable_spb', true ) == 'yes'){
		return $content;
	}

    // If shortcode banner found, skip
	if (has_shortcode( $content, 'tonjoo_spb' )) {

		return $content;
	}

    $docDOM = new DOMDocument();

    /* Hide warning for invalid html structure */
 	libxml_use_internal_errors(true);
 	$docDOM->loadHTML('<?xml encoding="UTF-8">' .$content);

 	$items = $docDOM->documentElement;

 	// Variable to determine return original content without insert any shortcode
 	$exit = false;

 	// HTML Element
 	if (!$items->hasChildNodes()) 
 		$exit = true;

 	// Tag Body
 	if( !$exit ) {
 		$item = $items->childNodes->item(0);

 		if ( !$exit && !$item->hasChildNodes()) 
			$exit = true;

		if ( !$exit )
			$childs = $item->childNodes;
 	}
	

 	// IF ECAE
 	if( !$exit && defined("TONJOO_ECAE") && $items->childNodes->length == 2){
		$item = $items->childNodes->item(1);

		if ( !$exit && !$item->hasChildNodes()) 
			$exit = true;

		if ( !$exit )
			$childs = $item->childNodes->item(0)->childNodes;
 	}
	
	// The real content -> post_content
	if ( !$exit && ( $childs->length==0||$childs->length==1 ) ) 
		$exit = true;

	$finalChildsDOM = array();

	foreach ($childs as $childsDOM) {
		if( is_a($childsDOM,'DOMElement')   )
			array_push($finalChildsDOM, $childsDOM);
	}

	$content = spb_add_banner($docDOM,$content,$finalChildsDOM,$item,$items,$spb);

	return $content;		
}

function spb_add_banner($docDOM,$content,$finalChildsDOM,$item,$items,$spb) 
{
	$spb_pos_data = get_post_meta( get_the_ID(), 'spb_pos' , true );

	// Only change article hash if element are added or changed 
	$article_hash_key = "";

	foreach ($finalChildsDOM as $node) {
		$article_hash_key .= $node->tagName;
	}

	$article_hash = $spb['setting']['hash_positions'];
	$current_hash = isset($spb_pos_data['hash']) ? $spb_pos_data['hash'] : 'current-hash-' . wp_rand();
	$custom_hash = get_post_meta(  get_the_ID() ,'spb_custom_hash' , true );

	if(! is_singular()) {
		if($current_hash != $article_hash && isset($spb_pos_data['hash_plural'])) {
			$current_hash = $spb_pos_data['hash_plural'];
		}
	}

	// Dont do positioning if key exist
	// Create New Ads Position if : no custom hash && hash is change

	// if(true)
	if( !$custom_hash && ( $current_hash != $article_hash ) )
	{
		// Final result
		$spb_final_pos = array();
		$key_banner = array();
		$safeDoms = array();

		$forbiddenTagName = array('h1','h2','h3','h4','h5','h6','hr','br','strong','b');
		
		foreach ($finalChildsDOM as $key => $domAnak) {
			if ( !in_array( $domAnak->tagName, $forbiddenTagName ) && $domAnak->nodeValue != "" && $domAnak->nodeValue != "&nbsp;" ) {
				$safeDoms[ $key ] =  $domAnak->tagName;
			}
		}

		if(WP_DEBUG && isset($_GET['spb_debug'])) {	
			echo "<b>Original : <b/>";
			echo "<pre>";
			foreach ($finalChildsDOM as $domAnak) {
				echo $domAnak->tagName;
				echo "<br>";
				
			}
			echo "</pre>";
			echo "<b>Safe : <b/>";
			echo "<pre>";
			foreach ($safeDoms as $key => $safeDom) {
				echo $key." => ".$safeDom;
				echo "<br>";				
			}
			echo "</pre>";
		}


		/**
		 * Begin Banner positioning, save it to array and retrive later.  
		 */
		if(count($spb['banner']) > 0)
		{
			$spb_final_pos = array();
			$key_banner = array();
			$key_number = 0;

			foreach ($spb['banner'] as $key => $value) 
			{
				$counter = 1;
				$current_location = $value['location'];
				$total_dom = count($finalChildsDOM);

				// first or last
				if($current_location == 'first') {
					$spb_final_pos[0] = "banner";
					$key_banner[0] = $key_number;
				}
				else if($current_location == 'last') {
					$spb_final_pos[$total_dom] = "banner";
					$key_banner[$total_dom] = $key_number;
				}
				else {
					// by number
					foreach ($safeDoms as $key_two => $value_two) 
					{
						if($current_location == $counter) {
							// put after selected dom
							$new_position = $key_two + 1;

							$spb_final_pos[$new_position] = "banner";
							$key_banner[$new_position] = $key_number;
							
							break;
						}

						$counter++;
					}	
				}

				$key_number++;
			}
		}

		// Save
		$spb_pos_data['key_banner'] = $key_banner;
		$spb_pos_data['position'] = $spb_final_pos;
		$spb_pos_data['safe_size'] = sizeof( $safeDoms );

		if(is_singular()) {
			$spb_pos_data['hash'] = $article_hash;
		} else {
			$spb_pos_data['hash_plural'] = $article_hash;
		}

		// sort position
		ksort($spb_pos_data[ 'position' ]);

		update_post_meta( get_the_ID(), 'spb_pos' ,$spb_pos_data );
	}


	/**
	 * Replace Line with banner 
	 */
	$addon_key = 0;	
	foreach ($spb_pos_data[ 'position' ] as $key => $value) 
	{
		if(! isset($spb_pos_data['key_banner'][$key])) continue;
		
		$key_banner = $spb_pos_data['key_banner'][$key];

		$shortcode = '[tonjoo_spb cursor=true key=' . $key_banner . ' ]';
		
		if( $key==="first" || $key==="last" )
			$shortcode = '[tonjoo_spb key=' . $key_banner . ' ]';

		$data_key = $key;

		$banner = $docDOM->createElement('banner', $shortcode);
		$banner->setAttribute('data-spb-position',$data_key);
		$banner->setAttribute('data-spb-key-banner',$key_banner);
		$bannerClass = $docDOM->createAttribute('class');

		if( $key==="first" || $key==="last" )
			$bannerClass->value = 'spb_banner no-control';
		else
			$bannerClass->value = 'spb_banner spb_middle';
		
		$banner->appendChild($bannerClass);

		if( $key === "first" ) {
			array_unshift( $finalChildsDOM , $banner);
			continue;
		}

		if( $key === "last" ) {
			array_push( $finalChildsDOM , $banner );
			continue;
		}

		array_splice( $finalChildsDOM, $key + $addon_key, 0, array( $banner) );
		$addon_key++; // add count for every banner added
	}

	if(WP_DEBUG && isset($_GET['spb_debug'])) {	
		echo "<b>Finale : <b/>";
		echo "<pre>";
		foreach ($finalChildsDOM as $domAnak) {
			echo $domAnak->tagName;
			echo "<br>";
			
		}
		echo "</pre>";
	}

	$tempChildsDOM = $finalChildsDOM;
	$finalChildsDOM = array();
	
	foreach ($tempChildsDOM as $key => $value) {

		$finalChildsDOM[$key] = $value;

		// IF ECAE
		// remove banner before and after readmore button	
		if($value->hasAttribute('class') && defined("TONJOO_ECAE") && !is_singular()) {
			if (strpos($value->getAttribute('class'), 'ecae-button') !== false) {
				$beforekey = $key - 1;

				// remove banner before readmore button
				if(isset($finalChildsDOM[$beforekey]) && $finalChildsDOM[$beforekey]->tagName == 'banner') {
					unset($finalChildsDOM[$beforekey]);
				}

				break;
			}
		}
	}

	return spb_save_content_with_banner( $finalChildsDOM );
}

function spb_save_content_with_banner($finalChildsDOM) {

	$docDOMFinale = new DOMDocument('1.0',  'UTF-8');

	foreach ($finalChildsDOM as $node) {
		$newnode = $docDOMFinale->importNode($node, true);		
		$docDOMFinale->appendChild($newnode);
	}

	$content =  preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $docDOMFinale->saveHTML()));

	return $content;
}