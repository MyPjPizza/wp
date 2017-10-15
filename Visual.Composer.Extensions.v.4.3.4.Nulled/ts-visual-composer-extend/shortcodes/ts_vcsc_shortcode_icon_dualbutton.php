<?php
	add_shortcode('TS_VCSC_Icon_Dual_Button', 'TS_VCSC_Icon_Dual_Button_Function');
	function TS_VCSC_Icon_Dual_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		extract( shortcode_atts( array(
			'button_align'				=> 'ts-dual-buttons-center',
			'button_effects'			=> 'none',
			'button_width'				=> 100,
			'button_radius'				=> 'ts-dual-buttons-radius-large',
			
			'button_animation'			=> '',
			'button_string'				=> '',
			'button_delay'				=> 0,
			
			'separator_content'			=> 'text',
			'separator_color'			=> '#444444',
			'separator_background'		=> '#ffffff',
			'separator_text'			=> 'or',
			'separator_icon'			=> '',
			'separator_animation'		=> '',
			'separator_string'			=> '',
			'separator_delay'			=> 0,

			'button_link1'				=> '',
			'button_text1'				=> 'Read More 1',
			'button_style1'				=> 'ts-dual-buttons-color-default',
			'button_hover1'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'button_link2'				=> '',
			'button_text2'				=> 'Read More 2',
			'button_style2'				=> 'ts-dual-buttons-color-default',
			'button_hover2'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			
			'animation_button1'			=> '',
			'animation_string1'			=> '',
			'animation_delay1'			=> 0,
			'animation_button2'			=> '',
			'animation_string2'			=> '',
			'animation_delay2'			=> 0,
			
			// Scroll Settings
			'scroll_navigate1'			=> 'false',
			'scroll_target1'			=> '',
			'scroll_speed1'				=> 2000,
			'scroll_effect1'			=> 'linear',
			'scroll_offset1'			=> 'desktop:0px;tablet:0px;mobile:0px',
			'scroll_hashtag1'			=> 'false',
			'scroll_navigate2'			=> 'false',
			'scroll_target2'			=> '',
			'scroll_speed2'				=> 2000,
			'scroll_effect2'			=> 'linear',
			'scroll_offset2'			=> 'desktop:0px;tablet:0px;mobile:0px',
			'scroll_hashtag2'			=> 'false',
			
			'custom1_dual_color1'		=> '#f9f9f9',
			'custom1_dual_shadow1'		=> '#dadedf',
			'custom1_dual_text1'		=> '#454545',
			'custom1_dual_color2'		=> '#f9f9f9',
			'custom1_dual_shadow2'		=> '#dadedf',
			'custom1_dual_text2'		=> '#454545',
			
			'custom2_dual_color1'		=> '#f9f9f9',
			'custom2_dual_shadow1'		=> '#dadedf',
			'custom2_dual_text1'		=> '#454545',
			'custom2_dual_color2'		=> '#f9f9f9',
			'custom2_dual_shadow2'		=> '#dadedf',
			'custom2_dual_text2'		=> '#454545',
			
			'tooltip_content1'			=> '',
			'tooltip_content2'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> 'ts-simptip-position-black',
			'tooltip_animation'			=> 'swing',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));
		
		if (($animation_button1 != '') || ($animation_button2 != '') || ($separator_animation != '') || ($button_animation != '')) {
			wp_enqueue_style('ts-extend-animations');
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
				if (wp_script_is('waypoints', $list = 'registered')) {
					wp_enqueue_script('waypoints');
				} else {
					wp_enqueue_script('ts-extend-waypoints');
				}
			}
		}
		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');	
		wp_enqueue_style('ts-extend-buttonsdual');
		if ((($scroll_navigate1 == "true") && ($scroll_target1 != '')) || (($scroll_navigate2 == "true") && ($scroll_target2 != ''))) {
			wp_enqueue_script('jquery-easing');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		$output 						= '';
		$style_body						= '';
		
		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-dualbutton-' . mt_rand(999999, 9999999);
		}
		
		// Link Values
		if (($scroll_navigate1 == "true") && ($scroll_target1 != '')) {
			$scroll_target1				= str_replace("#", "", $scroll_target1);
			$a1_href					= "#" . $scroll_target1;
			$a1_title 					= "";
			$a1_target 					= "_parent";
		} else {
			$button_link1 				= TS_VCSC_Advancedlinks_GetLinkData($button_link1);
			$a1_href					= $button_link1['url'];
			$a1_title 					= $button_link1['title'];
			$a1_target 					= $button_link1['target'];
		}		
		if (($scroll_navigate2 == "true") && ($scroll_target2 != '')) {
			$scroll_target2				= str_replace("#", "", $scroll_target2);
			$a2_href					= "#" . $scroll_target2;
			$a2_title 					= "";
			$a2_target 					= "_parent";
		} else {
			$button_link2 				= TS_VCSC_Advancedlinks_GetLinkData($button_link2);
			$a2_href					= $button_link2['url'];
			$a2_title 					= $button_link2['title'];
			$a2_target 					= $button_link2['target'];
		}
		
		// Scroll Navigation
		if (($scroll_navigate1 == "true") && ($scroll_target1 != '')) {
			$scroll_offset1 			= explode(';', $scroll_offset1);			
			$offsetDesktop1				= explode(':', $scroll_offset1[0]);
			$offsetDesktop1				= str_replace("px", "", $offsetDesktop1[1]);
			$offsetTablet1				= explode(':', $scroll_offset1[1]);
			$offsetTablet1				= str_replace("px", "", $offsetTablet1[1]);
			$offsetMobile1				= explode(':', $scroll_offset1[2]);
			$offsetMobile1				= str_replace("px", "", $offsetMobile1[1]);	
			$scroll_class1				= 'ts-button-page-navigator';			
			$scroll_data1				= 'data-scroll-target="' . $scroll_target1 . '" data-scroll-speed="' . $scroll_speed1 . '" data-scroll-effect="' . $scroll_effect1 . '" data-scroll-offsetdesktop="' . $offsetDesktop1 . '" data-scroll-offsettablet="' . $offsetTablet1 . '" data-scroll-offsetmobile="' . $offsetMobile1 . '" data-scroll-hashtag="' . $scroll_hashtag1 . '"';
		} else {
			$scroll_class1				= '';
			$scroll_data1				= '';
		}
		if (($scroll_navigate2 == "true") && ($scroll_target2 != '')) {
			$scroll_offset2 			= explode(';', $scroll_offset2);			
			$offsetDesktop2				= explode(':', $scroll_offset2[0]);
			$offsetDesktop2				= str_replace("px", "", $offsetDesktop2[1]);
			$offsetTablet2				= explode(':', $scroll_offset2[1]);
			$offsetTablet2				= str_replace("px", "", $offsetTablet2[1]);
			$offsetMobile2				= explode(':', $scroll_offset2[2]);
			$offsetMobile2				= str_replace("px", "", $offsetMobile2[1]);	
			$scroll_class2				= 'ts-button-page-navigator';			
			$scroll_data2				= 'data-scroll-target="' . $scroll_target2 . '" data-scroll-speed="' . $scroll_speed2 . '" data-scroll-effect="' . $scroll_effect2 . '" data-scroll-offsetdesktop="' . $offsetDesktop2 . '" data-scroll-offsettablet="' . $offsetTablet2 . '" data-scroll-offsetmobile="' . $offsetMobile2 . '" data-scroll-hashtag="' . $scroll_hashtag2 . '"';
		} else {
			$scroll_class2				= '';
			$scroll_data2				= '';
		}
		
		// Tooltip
		$tooltipclasses					= 'ts-has-tooltipster-tooltip';		
		$tooltip_position				= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style					= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		if (strlen($tooltip_content1) != 0) {
			$Tooltip_Content1			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content1) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class1				= $tooltipclasses;
		} else {
			$Tooltip_Content1			= '';
			$Tooltip_Class1				= '';
		}
		if (strlen($tooltip_content2) != 0) {
			$Tooltip_Content2			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content2) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class2				= $tooltipclasses;
		} else {
			$Tooltip_Content2			= '';
			$Tooltip_Class2				= '';
		}
		
		// Viewport Animation
		if (($button_effects == 'sections') && ($animation_button1 != '')) {
			$Viewport_Class1			= 'ts-dual-buttons-link-viewport';
			$Viewport_Data1				= 'data-type="viewport" data-opacity="100" data-animation="' . TS_VCSC_GetCSSAnimation($animation_button1, "true") . '" data-delay="' . $animation_delay1 . '"';
		} else {
			$Viewport_Class1			= '';
			$Viewport_Data1				= '';
		}
		if (($button_effects == 'sections') && ($animation_button2 != '')) {
			$Viewport_Class2			= 'ts-dual-buttons-link-viewport';
			$Viewport_Data2				= 'data-type="viewport" data-opacity="100" data-animation="' . TS_VCSC_GetCSSAnimation($animation_button2, "true") . '" data-delay="' . $animation_delay2 . '"';
		} else {
			$Viewport_Class2			= '';
			$Viewport_Data2				= '';
		}
		if (($button_effects == 'sections') && ($separator_animation != '')) {
			$Viewport_Class3			= 'ts-dual-buttons-separator-viewport';
			$Viewport_Data3				= 'data-type="viewport" data-opacity="100" data-animation="' . TS_VCSC_GetCSSAnimation($separator_animation, "true") . '" data-delay="' . $separator_delay . '"';
		} else {
			$Viewport_Class3			= '';
			$Viewport_Data3				= '';
		}
		if (($button_effects == 'single') && ($button_animation != '')) {
			$Viewport_Class4			= 'ts-dual-buttons-container-viewport';
			$Viewport_Data4				= 'data-type="viewport" data-opacity="100" data-animation="' . TS_VCSC_GetCSSAnimation($button_animation, "true") . '" data-delay="' . $button_delay . '"';
		} else {
			$Viewport_Class4			= '';
			$Viewport_Data4				= '';
		}
		
		// Custom Styling
		if (($button_style1 == "ts-dual-buttons-color-custom-flat") || ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat") || ($button_style2 == "ts-dual-buttons-color-custom-flat") || ($button_hover2 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat")) {
			$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'stylestart', '', false, '', '', '', '');
			// Left Button
			if (($button_style1 == "ts-dual-buttons-color-custom-flat") || ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat")) {				
				if ($button_style1 == "ts-dual-buttons-color-custom-flat") {
					$style_body		.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style1, 'stylecss', '.ts-dual-buttons-link-left', false, $custom1_dual_color1, $custom1_dual_shadow1, 'container', $custom1_dual_text1);
				}
				if ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat") {
					$style_body		.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_hover1, 'stylecss', '.ts-dual-buttons-link-left', true, $custom1_dual_color2, $custom1_dual_shadow2, 'container', $custom1_dual_text2);
				}				
			}
			// Right Button
			if (($button_style2 == "ts-dual-buttons-color-custom-flat") || ($button_hover2 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat")) {
				if ($button_style1 == "ts-dual-buttons-color-custom-flat") {
					$style_body		.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_style2, 'stylecss', '.ts-dual-buttons-link-right', false, $custom2_dual_color1, $custom2_dual_shadow1, 'container', $custom2_dual_text1);
				}
				if ($button_hover1 == "ts-dual-buttons-preview-custom-flat ts-dual-buttons-hover-custom-flat") {
					$style_body		.= TS_VCSC_GetCustomFlatButtonStyle($button_id, $button_hover2, 'stylecss', '.ts-dual-buttons-link-right', true, $custom2_dual_color2, $custom2_dual_shadow2, 'container', $custom2_dual_text2);
				}	
			}
			$style_body				.= TS_VCSC_GetCustomFlatButtonStyle($button_id, '', 'styleend', '', false, '', '', '', '');
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Dual_Button', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= $style_body;
		$output .= '<div id="' . $button_id . '" class="ts-dual-buttons-container clearFixMe ' . $Viewport_Class4 . '" ' . $Viewport_Data4 . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<div class="ts-dual-buttons-wrapper ' . $button_align . ' ' . $button_radius . '" style="width: ' . $button_width . '%;">';
				$output .= '<a class="ts-dual-buttons-link-left ' . $scroll_class1 . ' ' . $button_style1 . ' ' . $button_hover1 . ' ' . $Tooltip_Class1 . ' ' . $Viewport_Class1 . '" ' . $scroll_data1 . ' ' . $Viewport_Data1 . ' href="' . $a1_href . '" target="' . $a1_target . '" title="' . $a1_title . '" ' . $Tooltip_Content1 . '>' . $button_text1 . '</a>';
				if ($separator_content != 'none') {
					if ($separator_content == "icon") {
						if (($separator_icon != '') && ($separator_icon != 'transparent')) {
							$output .= '<span class="ts-dual-buttons-separator ' . $Viewport_Class3 . '" ' . $Viewport_Data3 . ' style="background: ' . $separator_background . ';"><i class="' . $separator_icon . '" style="color: ' . $separator_color . ';"></i></span>';
						} else {
							$output .= '<span class="ts-dual-buttons-separator ' . $Viewport_Class3 . '" ' . $Viewport_Data3 . ' style="background: ' . $separator_background . ';"></span>';
						}
					} else if ($separator_content == "text") {
						$output .= '<span class="ts-dual-buttons-separator ' . $Viewport_Class3 . '" ' . $Viewport_Data3 . ' style="background: ' . $separator_background . '; color: ' . $separator_color . ';">' . $separator_text . '</span>';
					} else if ($separator_content == "empty") {
						$output .= '<span class="ts-dual-buttons-separator ' . $Viewport_Class3 . '" ' . $Viewport_Data3 . ' style="background: ' . $separator_background . ';"></span>';
					}
				}
				$output .= '<a class="ts-dual-buttons-link-right ' . $scroll_class2 . ' ' . $button_style2 . ' ' . $button_hover2 . ' ' . $Tooltip_Class2 . ' ' . $Viewport_Class2 . '" ' . $scroll_data2 . ' ' . $Viewport_Data2 . ' href="' . $a2_href . '" target="' . $a2_target . '" title="' . $a2_title . '" ' . $Tooltip_Content2 . '>' . $button_text2 . '</a>';
			$output .= '</div>';
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>