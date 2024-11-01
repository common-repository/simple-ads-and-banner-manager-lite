<?php

add_shortcode('tonjoo_spb', 'tonjoo_spb_shortcode' );
function tonjoo_spb_shortcode($args)
{
	$args = shortcode_atts( array(
        'cursor' => "false",
        'key' => "false"
    ), $args );

	$spb = spb_get_setting();
	$banner = (!empty($spb['banner'])) ? $spb['banner'] : array();

	return get_banner($banner, $args, $spb);
}

function get_banner($banners, $args, $spb)
{
	if( sizeof( $banners ) == 0 )
		return;

	global $randomized;

	// options
	$options = spb_get_options();
	$desktop_opt = $options['desktop'];
	$mobile_opt = $options['mobile'];
	$mobile_threshold = $spb['setting']['mobile_threshold'];

	$userdata_login = wp_get_current_user();
	
	ob_start();
	
	if( $randomized  === null ) 
	{
		$randomized = array();

		foreach ( $banners as $key => $banner ) 
		{			
			$banner['priority'] = 1;

			if( $banner['priority'] == 0 )
				$banner['priority'] = 1;

			for ( $i = 1 ;$i <= $banner['priority'] ; $i ++ ) {
				array_push( $randomized ,  $key );
			}
		}

		shuffle( $randomized );

		if ( in_array('editor',$userdata_login->roles) || in_array('administrator',$userdata_login->roles) ) {
			// Enqueue Style
			wp_enqueue_style( 'spb-icon', plugins_url('assets/icons.css', __FILE__ ) );
			wp_enqueue_script( 'spb-banner-move', plugins_url('assets/spb-banner-move.js', __FILE__ ) );
			wp_localize_script( 'spb-banner-move', 'spb_banner',array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'post_id'=>get_the_ID() ) );			
		}

		// desktop google fonts
		if($desktop_opt['enable_style'] == 'yes' && $desktop_opt['font'] != '') {
			$import_font = str_replace(' ', '+', $desktop_opt['font']);
			echo "<link href='https://fonts.googleapis.com/css?family=$import_font' rel='stylesheet' type='text/css'>";
		}

		// mobile google fonts
		if($mobile_opt['enable_style'] == 'yes' && $mobile_opt['font'] != '') {
			$import_font = str_replace(' ', '+', $mobile_opt['font']);
			echo "<link href='https://fonts.googleapis.com/css?family=$import_font' rel='stylesheet' type='text/css'>";
		}

		// desktop font size
		if($desktop_opt['text_size'] == '' || $desktop_opt['text_size'] <= 0) {
	      	$desktop_opt['text_size'] = 'inherit';
	   	} else {
	      	$desktop_opt['text_size'] = $desktop_opt['text_size'] . 'px';
	   	}

		// mobile font size
		if($mobile_opt['text_size'] == '' || $mobile_opt['text_size'] <= 0) {
	      	$mobile_opt['text_size'] = 'inherit';
	   	} else {
	      	$mobile_opt['text_size'] = $mobile_opt['text_size'] . 'px';
	   	}

		?>

		<style type="text/css">

			banner.spb_banner {
				display: block;
			    width: 100%;
			    text-align: center;
			    margin-top: 0px;
			    margin-bottom: 0px;
			    position:relative;
			}

			banner.spb_banner .spb_banner_text {
				margin-bottom: 15px;
			}

			<?php if($desktop_opt['enable_style'] == 'yes' ): ?>

			banner.spb_banner .spb_desktop_class {				
				background-color: <?php echo $desktop_opt['background_color'] ?>;				
				margin-top: <?php echo $desktop_opt['margin-top'] ?>;
				margin-right: <?php echo $desktop_opt['margin-right'] ?>;
				margin-bottom: <?php echo $desktop_opt['margin-bottom'] ?>;
				margin-left: <?php echo $desktop_opt['margin-left'] ?>;
				padding-top: <?php echo $desktop_opt['padding-top'] ?>;
				padding-right: <?php echo $desktop_opt['padding-right'] ?>;
				padding-bottom: <?php echo $desktop_opt['padding-bottom'] ?>;
				padding-left: <?php echo $desktop_opt['padding-left'] ?>;
			}

			banner.spb_banner .spb_desktop_class .spb_banner_text {
				color: <?php echo $desktop_opt['text_color'] ?>;
				font-family: "<?php echo $desktop_opt['font'] ?>";
				font-size: <?php echo $desktop_opt['text_size'] ?>;
				margin-top: <?php echo $desktop_opt['margin-text-top'] ?>;
				margin-right: <?php echo $desktop_opt['margin-text-right'] ?>;
				margin-bottom: <?php echo $desktop_opt['margin-text-bottom'] ?>;
				margin-left: <?php echo $desktop_opt['margin-text-left'] ?>;
				padding-top: <?php echo $desktop_opt['padding-text-top'] ?>;
				padding-right: <?php echo $desktop_opt['padding-text-right'] ?>;
				padding-bottom: <?php echo $desktop_opt['padding-text-bottom'] ?>;
				padding-left: <?php echo $desktop_opt['padding-text-left'] ?>;

				<?php 
					if($desktop_opt['text_bold'] == 'yes') {
						echo "font-weight: bold;";
					}

					if($desktop_opt['text_italic'] == 'yes') {
						echo "font-style: italic;";
					}
				?>
			}

			<?php endif ?>

			<?php if($mobile_opt['enable_style'] == 'yes' ): ?>

			banner.spb_banner .spb_mobile_class {
				background-color: <?php echo $mobile_opt['background_color'] ?>;				
				margin-top: <?php echo $mobile_opt['margin-top'] ?>;
				margin-right: <?php echo $mobile_opt['margin-right'] ?>;
				margin-bottom: <?php echo $mobile_opt['margin-bottom'] ?>;
				margin-left: <?php echo $mobile_opt['margin-left'] ?>;
				padding-top: <?php echo $mobile_opt['padding-top'] ?>;
				padding-right: <?php echo $mobile_opt['padding-right'] ?>;
				padding-bottom: <?php echo $mobile_opt['padding-bottom'] ?>;
				padding-left: <?php echo $mobile_opt['padding-left'] ?>;
			}

			banner.spb_banner .spb_mobile_class .spb_banner_text {
				color: <?php echo $mobile_opt['text_color'] ?>;
				font-family: "<?php echo $mobile_opt['font'] ?>";
				font-size: <?php echo $mobile_opt['text_size'] ?>;
				margin-top: <?php echo $mobile_opt['margin-text-top'] ?>;
				margin-right: <?php echo $mobile_opt['margin-text-right'] ?>;
				margin-bottom: <?php echo $mobile_opt['margin-text-bottom'] ?>;
				margin-left: <?php echo $mobile_opt['margin-text-left'] ?>;
				padding-top: <?php echo $mobile_opt['padding-text-top'] ?>;
				padding-right: <?php echo $mobile_opt['padding-text-right'] ?>;
				padding-bottom: <?php echo $mobile_opt['padding-text-bottom'] ?>;
				padding-left: <?php echo $mobile_opt['padding-text-left'] ?>;

				<?php 
					if($mobile_opt['text_bold'] == 'yes') {
						echo "font-weight: bold;";
					}

					if($mobile_opt['text_italic'] == 'yes') {
						echo "font-style: italic;";
					}
				?>
			}

			<?php endif ?>

			banner.spb_banner p {
				display: inline-block;
				margin: 0px auto;
				width: 100%;
			}

			banner.spb_banner img {
				display: inline-block;
				margin: 0px auto;
				width: 100%;
			}

			@media screen and (min-width: <?php echo $mobile_threshold + 1 ?>px) {
				banner .spb_view_desktop {
					display: block !important;
				}

				banner .spb_view_mobile {
					display: none !important;
				}
			}

			@media screen and (max-width: <?php echo $mobile_threshold ?>px) {
				banner .spb_view_desktop {
					display: none !important;
				}

				banner .spb_view_mobile {
					display: block !important;
				}
			}

			<?php 
				if ( in_array('editor',$userdata_login->roles) || in_array('administrator',$userdata_login->roles) ):;
			?>
				banner.spb_banner.no-control .spb-icon {
					display: none
				}

				banner.spb_banner .spb-icon  {
					position:absolute;
					right:-5px;
					top:0px;
				}

				banner.spb_banner .spb-icon span {
					position:absolute;
					background-color:black;
					color:white;
					cursor:pointer;
					padding:2px;
				}

				banner.spb_banner .icon-arrow-down {
					top:24px;
					left:0px;

				}

				banner.spb_banner .icon-arrow-up {
					top:0px;
					left:0px;
				}
			<?php
				endif;
			?>			

		</style>

		<?php
	}

	$stylesheet = ob_get_contents();
	
	ob_end_clean();

	$random = wp_rand(1,100);

	$random = $random % sizeof( $banners );

	// key
	if(isset($args['key']) && $args['key'] !== false && isset($banners[$args['key']])) {
		$arrContent = $banners[$args['key']];
	} 
	else {
		$arrContent = $banners[ $random ];
	}	

	$content = "<div>";


	if ( ( in_array('editor',$userdata_login->roles) || in_array('administrator',$userdata_login->roles) )
		  && is_single()
		 ) {
		
		$spb_pos_data = get_post_meta( get_the_ID(), 'spb_pos' , true );


		if($args['cursor']=='true')
		$content .= "<span class='spb-icon'>
						 <span class='icon-arrow-up'></span>
						 <span class='icon-arrow-down'></span>
					 </span>";
	
	}

	// enable_mobile or not
	if(isset($arrContent['enable_mobile']) && $arrContent['enable_mobile'] == 'yes')
	{
		if(isset($arrContent['php_mobile']) && $arrContent['php_mobile'] == 'yes') {
			$useragent=$_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
				$content .= "<div class='spb_mobile_class'>";
				$content .= all_content($arrContent, 'mobile');
				$content .= "</div>";
			}
			else {
				$content .= "<div class='spb_desktop_class'>";
				$content .= all_content($arrContent, 'desktop');
				$content .= "</div>";
			}
		}
		else 
		{
			$content .= "<div class='spb_view_desktop spb_desktop_class'>";		
			$content .= all_content($arrContent, 'desktop');
			$content .= "</div>";

			$content .= "<div class='spb_view_mobile spb_mobile_class'>";
			$content .= all_content($arrContent, 'mobile');
			$content .= "</div>";		
		}		
	}
	else 
	{
		$content .= "<div class='spb_desktop_class'>";
		$content .= all_content($arrContent, 'desktop');
		$content .= "</div>";
	}

	$content .= "</div>";	

	return $stylesheet.$content;
}

function all_content($arrContent, $view) 
{
	$options = spb_get_options();	
	$content = "";

	if($view == 'desktop') {
		$banner_name = 'banner_content';
		$text = $options['desktop']['text'];
	} 
	else {
		$banner_name = isset($arrContent['banner_mobile_content']) ? 'banner_mobile_content' : 'banner_content';
		$text = $options['mobile']['text'];
	}

	// text
	if($text != '') {
		$content.= "<div class='spb_banner_text'>$text</div>";
	}

	if(! isset($arrContent['type'])) $arrContent['type'] = 'banner';

	// switch by type
	switch ($arrContent['type']) {
		case 'banner':
			$imgurl = wp_get_attachment_url( $arrContent[$banner_name]['img_id'] ); 
			
			if($imgurl) {
				$content.= '<a href="'.$arrContent[$banner_name]['link'].'"><img class="spb_banner_img" src="'.$imgurl.'"></a>';
			}
			break;

		case 'shortcode':
			$content.= do_shortcode( $arrContent[$banner_name] );
			break;
		
		default:
			$content.= $arrContent[$banner_name];
			break;
	}

	return $content;
}



/**
 * @param string $code name of the shortcode
 * @param string $content
 * @return string content with shortcode striped
 */
function spb_strip_shortcode($code, $content) {
    global $shortcode_tags;

    $stack = $shortcode_tags;
    $shortcode_tags = array($code => 1);

    $content = strip_shortcodes($content);

    $shortcode_tags = $stack;
    return $content;
}