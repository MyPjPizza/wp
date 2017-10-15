<?php
	add_shortcode('TS_VCSC_Icon_Flex_Button', 'TS_VCSC_Icon_Flex_Button_Function');
	function TS_VCSC_Icon_Flex_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
	
		extract( shortcode_atts( array(
			// General Settings			
			'button_link'				=> '',
			'button_fontfamily'			=> 'Default:regular',
			'button_fonttype'			=> '',
			'button_theme'         		=> 'lightblue',
			'button_width'				=> 100,
			'button_float'				=> 'center',
			'button_align'				=> 'center',
			'button_text'				=> 'Read More',
			'button_size'				=> 'medium',
			'button_border'				=> 'false',
			'button_bartop'				=> 'false',
			'button_barbottom'			=> 'false',
			'button_barleft'			=> 'false',
			'button_barright'			=> 'false',
			'button_title'				=> 'true',
			'button_tooltip'			=> 'false',
			'button_radius'				=> 'none',
			'button_slanted'			=> 'none',
			// Scroll Settings
			'scroll_navigate'			=> 'false',
			'scroll_target'				=> '',
			'scroll_speed'				=> 2000,
			'scroll_effect'				=> 'linear',
			'scroll_offset'				=> 'desktop:0px;tablet:0px;mobile:0px',
			'scroll_hashtag'			=> 'false',
			// Icon Settings
			'icon_select'          		=> '',
			'icon_position'      		=> 'left',
			'icon_hover'				=> 'false',
			// Custom Styling
			'default_text'				=> '#ffffff',
			'default_background'		=> '#1ca2f1',
			'hover_text'				=> '#ffffff',
			'hover_background'			=> '#0094e0',
			// Tooltip Settings
			'tooltip_advanced'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> 'ts-simptip-style-black',
			'tooltip_animation'			=> 'swing',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			// Other Settings
			'margin_top'				=> 10,
			'margin_bottom'				=> 10,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ) );
		
		if (($button_tooltip == "true") && ($tooltip_advanced != '')) {
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');
		}
		wp_enqueue_style('ts-extend-buttonsflex');
		if ((($button_tooltip == "true") && ($tooltip_advanced != '')) || (($scroll_navigate == "true") && ($scroll_target != ''))) {
			if (($scroll_navigate == "true") && ($scroll_target != '')) {
				wp_enqueue_script('jquery-easing');
			}			
		}
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		$output							= '';
		$styling						= '';
	
		// Button ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-flexbutton-' . mt_rand(999999, 9999999);
		}
		
		// Contingency Checkups
		if ($button_tooltip == "true") {
			$button_title				= "false";
		}
		
		// Link Values
		if (($scroll_navigate == "true") && ($scroll_target != '')) {
			$scroll_target				= str_replace("#", "", $scroll_target);
			$a_href						= "#" . $scroll_target;
			$a_title 					= "";
			$a_target 					= "_parent";
		} else {
			$link 						= TS_VCSC_Advancedlinks_GetLinkData($button_link);
			$a_href						= $link['url'];
			$a_title 					= $link['title'];
			$a_target 					= $link['target'];
		}
	
		// Tooltip Settings
		$tooltip_position				= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style					= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		if (($button_tooltip == "true") && (strlen($tooltip_advanced) != 0)) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_advanced))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
		} else {
			$Tooltip_Content			= '';
		}
	
		// Custom Theme Styling
		if ($button_theme == 'custom') {
			$styling = '<style id="' . $button_id . '-styling" type="text/css">';
				$styling.= $button_border == 'false' ? '#' . $button_id . '.ts-flex-button {background-color: '.$default_background.';}' : '';
				$styling.= $button_border == 'false' ? '#' . $button_id . '.ts-flex-button:hover {background-color: '.$hover_background.';}' : '';
				$styling.= '#' . $button_id . '.ts-flex-button .ts-flex-button-icon,';
				$styling.= '#' . $button_id . '.ts-flex-button .ts-flex-button-title {color:' . $default_text . ';}';
				$styling.= '#' . $button_id . '.ts-flex-button:hover .ts-flex-button-icon,';
				$styling.= '#' . $button_id . '.ts-flex-button:hover .ts-flex-button-title {color:' . $hover_text . ';}';			  
				if ($button_border == 'true'){
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button {border-color: ' . $default_background . ';}';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button,';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button .ts-flex-button-title,';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button .ts-flex-button-icon {color: ' . $default_text . ';}';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button:hover {border-color: ' . $hover_background . '; background-color: ' . $hover_background . ';}';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button:hover,';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button:hover .ts-flex-button-title,';
					$styling.= '#' . $button_id . '.ts-flex-border-button.ts-flex-button:hover .ts-flex-button-icon {color: ' . $hover_text . ';}';
				}
			$styling.= '</style>';
		}
		
		// Button Font
		if (strpos($button_fontfamily, 'Default') === false) {
			$google_font_button			= TS_VCSC_GetFontFamily($button_id . " .ts-flex-button-title", $button_fontfamily, $button_fonttype, false, true, false);
		} else {
			$google_font_button			= "";
		}

		// Button Classes
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
		$class_theme					= 'ts-flex-theme-' . $button_theme;
		$class_radius					= 'ts-flex-button-radius-' . $button_radius;
		$class_size						= 'ts-flex-button-' . $button_size;
		$class_alignment				= 'ts-flex-button-align-' . $button_float;
		$class_slanted					= 'ts-flex-slanted-' . $button_slanted;
		$class_border					= '';
		if ($button_border == 'true') {
			$class_border				.= 'ts-flex-border-button';
		} else {
			if ($button_bartop == "true") {
				$class_border			.= ' ts-flex-button-bordertop';
			}
			if ($button_barbottom == "true") {
				$class_border			.= ' ts-flex-button-borderbottom';
			}
			if ($button_barleft == "true") {
				$class_border			.= ' ts-flex-button-borderleft';
			}
			if ($button_barright == "true") {
				$class_border			.= ' ts-flex-button-borderright';
			}
		}		
		$class_icon						= $icon_position && $icon_select ? 'ts-flex-button-icon-' . $icon_position : '';
		$class_hover					= $icon_hover == 'true' && $icon_select ? ' ts-flex-button-hover' : '';
		$class_final					= $scroll_class . ' ' . $class_theme . ' ' . $class_radius . ' ' . $class_size . ' ' . $class_alignment . ' ' . $class_slanted . ' ' . $class_border . ' ' . $class_icon . ' ' . $class_hover;
		
		// Final Output
		$output .= TS_VCSC_MinifyCSS($styling);
		$output .= '<a id="' . $button_id . '" class="ts-flex-button ' . $class_final . '" href="' . esc_url($a_href) . '" target="' .esc_attr($a_target) . '" data-iconhover="' . $icon_hover . '" title="' . ($button_title == "true" ? esc_attr($a_title) : "") . '" ' . $scroll_data . ' style="text-align: ' . $button_align . '; width: ' . $button_width . '%;">';
			if (($button_tooltip == "true") && (strlen($tooltip_advanced) != 0)) {
				$output .= '<div class="ts-flex-button-tooltip ts-has-tooltipster-tooltip" ' . $Tooltip_Content . '>';
			}
				$icon_string 			= ($icon_select != '') ? '<span class="ts-flex-button-icon"><span class="ts-flex-button-icon-inner ' . $icon_select . '"></span></span>' : '';				
				$output .= $icon_select && ($icon_position == 'top' || $icon_position == 'left' || $icon_position == 'right') ? $icon_string : '';
				$output .= '<span class="ts-flex-button-title" style="' . $google_font_button . '">' . $button_text . '</span>';
				$output .= $icon_select && ($icon_position == 'bottom') ? $icon_string : '';								
			if (($button_tooltip == "true") && (strlen($tooltip_advanced) != 0)) {
				$output .= '</div>';
			}
		$output .= '</a>';
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>