<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	add_filter('TS_VCSC_ComposerColumnAdditions_Filter',	'TS_VCSC_ComposerColumnAdditions', 		10, 2);

	function TS_VCSC_ComposerColumnAdditions($output, $atts, $content='') {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		extract( shortcode_atts( array(
			'animation_factor'			=> '0.33',
			'animation_scroll'			=> 'false',
			'animation_view'			=> '',
			'animation_offset'			=> '50%',
			'animation_speed'			=> 2000,
		), $atts ) );
		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") && ($animation_view != "")) {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false") && ($animation_view != "")) {
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-backgrounds');
		}
		
		if ($animation_view != '') {
			$animation_css			= "ts-viewport-css-" . $animation_view;
			echo '<div class="ts-viewport-column ts-viewport-animation" data-offset="' . $animation_offset . '" data-scrollup = "' . $animation_scroll . '" data-factor="' . $animation_factor . '" data-viewport="' . $animation_css . '" data-speed="' . $animation_speed . '"></div>';
		} else {
			echo '';
		}
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	
	if (!function_exists('vc_theme_before_vc_column')){
		function vc_theme_before_vc_column($atts, $content = null){
			return apply_filters( 'TS_VCSC_ComposerColumnAdditions_Filter', '', $atts, $content );
		}
	}
?>