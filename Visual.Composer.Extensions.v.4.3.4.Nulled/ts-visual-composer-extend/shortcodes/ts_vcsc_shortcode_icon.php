<?php
	add_shortcode('TS-VCSC-Font-Icons', 'TS_VCSC_Font_Icons_Function');
	function TS_VCSC_Font_Icons_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		extract(shortcode_atts(array(
			// General Settings
			'icon_replace'				=> 'false',
			'icon' 						=> '',
			'icon_image'				=> '',
			'icon_color'				=> '#cccccc',
			'icon_background'			=> '',
			'icon_size_slide'           => 16,
			'icon_frame_type' 			=> '',
			'icon_frame_thick'			=> 1,
			'icon_frame_radius'			=> '',
			'icon_frame_color'			=> '#000000',
			'padding' 					=> 'false',
			'icon_padding' 				=> 0,
			'icon_align' 				=> '',
			'link' 						=> '',
			'link_target'				=> '_parent',
			// Scroll Settings
			'scroll_navigate'			=> 'false',
			'scroll_target'				=> '',
			'scroll_speed'				=> 2000,
			'scroll_effect'				=> 'linear',
			'scroll_offset'				=> 'desktop:0px;tablet:0px;mobile:0px',
			'scroll_hashtag'			=> 'false',
			// Tooltip Settings
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> 'ts-simptip-style-black',
			'tooltip_animation'			=> 'swing',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			// Animation Settings
			'animation_active'			=> '',
			'animation_icon'			=> '',
			'animation_view' 			=> '',
			'animation_delay' 			=> 0,
			// Other Settings
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts));
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		if ($tooltip_css == "true") {
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');
		}
		wp_enqueue_style('ts-extend-animations');
		if (($scroll_navigate == "true") && ($scroll_target != '')) {
			wp_enqueue_script('jquery-easing');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		$icon_color = !empty($icon_color) ? ('color:' . $icon_color .';') : '';
		$output = $icon_frame_class = $icon_frame_style = $animation_css = '';
		
		if (!empty($el_id)) {
			$icon_font_id				= $el_id;
		} else {
			$icon_font_id				= 'ts-vcsc-font-icon-' . mt_rand(999999, 9999999);
		}
		
		if (!empty($icon_image)) {
			$icon_image_path 			= wp_get_attachment_image_src($icon_image, 'large');
		}
		
		if (($scroll_navigate == "true") && ($scroll_target != '')) {
			$scroll_target				= str_replace("#", "", $scroll_target);
			$a_href						= "#" . $scroll_target;
			if ($tooltip_css == "true") {
				$a_title 				= "";
			} else {
				$a_title 				= $tooltip_content;
			}
			$a_target 					= "_parent";
		} else {
			$a_href						= $link;
			if ($tooltip_css == "true") {
				$a_title 				= "";
			} else {
				$a_title 				= $tooltip_content;
			}
			$a_target 					= $link_target;
		}
		if (($scroll_navigate == "true") && ($scroll_target != '')) {			
			$scroll_offset 				= explode(';', $scroll_offset);			
			$offsetDesktop				= explode(':', $scroll_offset[0]);
			$offsetDesktop				= str_replace("px", "", $offsetDesktop[1]);
			$offsetTablet				= explode(':', $scroll_offset[1]);
			$offsetTablet				= str_replace("px", "", $offsetTablet[1]);
			$offsetMobile				= explode(':', $scroll_offset[2]);
			$offsetMobile				= str_replace("px", "", $offsetMobile[1]);			
			$scroll_class				= 'ts-button-page-navigator';			
			$scroll_data				= 'data-scroll-target="' . $scroll_target . '" data-scroll-speed="' . $scroll_speed . '" data-scroll-effect="' . $scroll_effect . '" data-scroll-offsetdesktop="' . $offsetDesktop . '" data-scroll-offsettablet="' . $offsetTablet . '" data-scroll-offsetmobile="' . $offsetMobile . '" data-scroll-hashtag="' . $scroll_hashtag . '"';
		} else {
			$scroll_class				= '';
			$scroll_data				= '';
		}
		
		if ($padding == "true") {
			$icon_frame_padding			= 'padding: ' . $icon_padding . 'px; ';
		} else {
			$icon_frame_padding			= '';
		}
		
		$icon_style                     = '' . $icon_frame_padding . 'background-color:' . $icon_background . '; width:' . $icon_size_slide . 'px; height:' . $icon_size_slide . 'px; font-size:' . $icon_size_slide . 'px; line-height:' . $icon_size_slide . 'px;';
		$icon_image_style				= '' . $icon_frame_padding . 'background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; ';
		
		if ($icon_frame_type != '') {
			$icon_frame_class 	        = 'frame-enabled';
			$icon_frame_style 	        = 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		}
		
		if ($animation_view != '') {
			$animation_css				= TS_VCSC_GetCSSAnimation($animation_view, "true");			
		}
		
		// Tooltip
		if ($tooltip_css == "true") {
			$tooltip_position			= TS_VCSC_TooltipMigratePosition($tooltip_position);
			$tooltip_style				= TS_VCSC_TooltipMigrateStyle($tooltip_style);
			if (strlen($tooltip_content) != 0) {
				$icon_tooltipclasses	= "ts-has-tooltipster-tooltip";
				$icon_tooltipcontent	= 'data-tooltipster-title="" data-tooltipster-text="' . $tooltip_content . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			} else {
				$icon_tooltipclasses	= "";
				$icon_tooltipcontent	= "";
			}
		} else {
			$icon_tooltipclasses		= "";
			$icon_tooltipcontent		= "";
		}
		
		$output 						= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-' . $icon_align . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Font-Icons', $atts);
		} else {
			$css_class					= 'ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-' . $icon_align . ' ' . $el_class;
		}

		$output .= '<div id="' . $icon_font_id . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" ' . $icon_tooltipcontent . ' class="' . $css_class . ' ' . $icon_tooltipclasses . ' ' . ($animation_view != '' ? 'ts-vcsc-font-icon-viewport' : '') . '" data-type="' . ($icon_replace == "false" ? "icon" : "image") . '" data-active="' . $animation_active . '" data-viewport="' . $animation_css . '" data-opacity="1" data-delay="' . $animation_delay . '" data-animation="' . $animation_icon . '">';		
			if ((($scroll_navigate == "true") && ($scroll_target != '')) || ($link != '')) {
				$output .= '<a class="ts-font-icons-link ' . $scroll_class . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" ' . $scroll_data . '>';
			}						
				if ($icon_replace == "false") {
					$output .= '<i class="ts-font-icon ' . $icon . ' ' . $icon_frame_class . ' ' . $icon_frame_radius . ' ' . $animation_active . '" style="' . $icon_style . $icon_frame_style . $icon_color . '"></i>';
				} else {
					$output .= '<img class="ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . ' ' . $icon_frame_radius . ' ' . $animation_active . '" src="' . $icon_image_path[0] . '" style="' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important;">';
				}			
			if ((($scroll_navigate == "true") && ($scroll_target != '')) || ($link != '')) {
				$output .= '</a>';
			}			
		$output .= '</div>';
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>