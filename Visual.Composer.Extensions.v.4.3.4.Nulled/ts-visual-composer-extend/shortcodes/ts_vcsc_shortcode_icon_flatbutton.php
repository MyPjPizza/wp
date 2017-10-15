<?php
	add_shortcode('TS_VCSC_Icon_Flat_Button', 'TS_VCSC_Icon_Flat_Button_Function');
	function TS_VCSC_Icon_Flat_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
	
		extract( shortcode_atts( array(
			'link'						=> '',
			// Scroll Settings
			'scroll_navigate'			=> 'false',
			'scroll_target'				=> '',
			'scroll_speed'				=> 2000,
			'scroll_effect'				=> 'linear',
			'scroll_offset'				=> 'desktop:0px;tablet:0px;mobile:0px',
			'scroll_hashtag'			=> 'false',
			// Tooltip Settings
			'tooltip_html'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_content_html'		=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> 'ts-simptip-position-black',
			'tooltip_animation'			=> 'swing',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			// Button Stylinge
			'button_radius'				=> 'ts-flat-buttons-radius-none',
			'button_switch'				=> 'false',
			'button_style'				=> 'ts-color-button-sun-flower',			
			'button_style1'				=> 'ts-dual-buttons-color-default',
			'button_hover1'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			// Custom Styling
			'custom_single_color'		=> '#f9f9f9',
			'custom_single_shadow'		=> '#dadedf',
			'custom_single_text'		=> '#454545',
			'custom_single_icon'		=> '#454545',
			'custom_dual_color1'		=> '#f9f9f9',
			'custom_dual_shadow1'		=> '#dadedf',
			'custom_dual_text1'			=> '#454545',
			'custom_dual_icon1'			=> '#454545',
			'custom_dual_color2'		=> '#f9f9f9',
			'custom_dual_shadow2'		=> '#dadedf',
			'custom_dual_text2'			=> '#454545',
			'custom_dual_icon2'			=> '#454545',
			// Other Settings
			'button_width'				=> 100,
			'button_height'				=> 50,
			'button_align'				=> 'center',
			'button_text'				=> 'Read More',			
			'font_size'					=> 20,			
			'icon'						=> '',
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));
		
		$output 						= '';
		$style_body						= '';

		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');
		if (($scroll_navigate == "true") && ($scroll_target != '')) {
			wp_enqueue_script('jquery-easing');
		}
		if ($button_switch == "true") {
			wp_enqueue_style('ts-extend-buttonsdual');
		} else {
			wp_enqueue_style('ts-extend-buttonsflat');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');

		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-flatbutton-' . mt_rand(999999, 9999999);
		}
		
		// Link Values
		if (($scroll_navigate == "true") && ($scroll_target != '')) {
			$scroll_target				= str_replace("#", "", $scroll_target);
			$a_href						= "#" . $scroll_target;
			$a_title 					= "";
			$a_target 					= "_parent";
		} else {
			$link 						= TS_VCSC_Advancedlinks_GetLinkData($link);
			$a_href						= $link['url'];
			$a_title 					= $link['title'];
			$a_target 					= $link['target'];
		}

		// Tooltip
		$tooltipclasses					= 'ts-has-tooltipster-tooltip';		
		$tooltip_position				= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style					= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		if (($tooltip_html == "true") && (strlen($tooltip_content_html) != 0)) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= $tooltipclasses;
		} else if (($tooltip_html == "false") && (strlen($tooltip_content) != 0)) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . str_replace('<br/>', ' ', $tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= $tooltipclasses;
		} else {
			$Tooltip_Content			= '';
			$Tooltip_Class				= '';
		}		
		
		// Button Style
		if ($button_align == "center") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: none;";
		} else if ($button_align == "left") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: left;";
		} else if ($button_align == "right") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: right;";
		}
		
		// Button Class
		if ($button_switch == "true") {
			$buttonclass				= $button_style1 . ' ' . $button_hover1;
			if (($button_style1 == "ts-dual-buttons-color-custom-flat") || ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat")) {
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'stylestart', '', false, '', '', '', '');
				if ($button_style1 == "ts-dual-buttons-color-custom-flat") {
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style1, 'stylecss', '', false, $custom_dual_color1, $custom_dual_shadow1, 'container', '');
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style1, 'stylecss', '', false, '', '', 'text', $custom_dual_text1);
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style1, 'stylecss', '', false, '', '', 'icon', $custom_dual_icon1);
				}
				if ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat") {
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_hover1, 'stylecss', '', true, $custom_dual_color2, $custom_dual_shadow2, 'container', '');
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_hover1, 'stylecss', '', true, '', '', 'text', $custom_dual_text2);
					$style_body			.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_hover1, 'stylecss', '', true, '', '', 'icon', $custom_dual_icon2);
				}
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'styleend', '', false, '', '', '', '');
			}
		} else {
			$buttonclass				= $button_style;
			if ($button_style == "ts-color-button-custom-flat") {
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'stylestart', '', false, '', '', '', '');
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style, 'stylecss', '', false, $custom_single_color, $custom_single_shadow, 'container', '');
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style, 'stylecss', '', false, '', '', 'text', $custom_single_text);
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style, 'stylecss', '', false, '', '', 'icon', $custom_single_icon);				
				$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'styleend', '', false, '', '', '', '');
			}
		}
		
		$iconstyle						= "margin: " . (($button_height - $font_size - 10 - 2) / 2) . "px auto 0px auto";
		$textstyle						= "margin: " . (($button_height - $font_size - 10 - 2) / 2) . "px auto " . (($button_height - $font_size - 10 - 2) / 2) . "px auto";
		
		// Scroll Navigation
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

		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Flat_Button', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= TS_VCSC_MinifyCSS($style_body);
		$output .= '<div id="' . $button_id . '" class="ts-flat-button-wrapper clearFixMe ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style="' . $buttonstyle . '" title="' . $a_title . '" ' . $scroll_data . ' class="ts-color-button-container ' . $scroll_class . ' ' . $button_radius . ' ' . $buttonclass . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . '>';
				if (($icon != '') && ($icon != 'transparent')) {
					$output .= '<span class="ts-color-button-icon ' . $icon . '" style="font-size: ' . $font_size . 'px; line-height: ' . $font_size . 'px; ' . $iconstyle . '"></span>';
				}
				$output .= '<span class="ts-color-button-title" style="font-size: ' . $font_size . 'px; line-height: ' . $font_size . 'px; ' . $textstyle . '">' . $button_text . '</span>';
			$output .= '</a>';
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>