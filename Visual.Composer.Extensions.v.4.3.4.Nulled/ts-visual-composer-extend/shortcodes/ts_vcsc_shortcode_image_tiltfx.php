<?php
	add_shortcode('TS_VCSC_Image_TiltFX', 'TS_VCSC_Image_TiltFX_Function');
	function TS_VCSC_Image_TiltFX_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$hover_frontent					= "true";
		} else {
			$hover_frontent					= "false";
		}
		
		extract( shortcode_atts( array(
			'image'							=> '',
			
			'tiltfx_trigger'				=> 'mousetouch',
			'tiltfx_extraimgs'				=> 2,
			'tiltfx_opacity'				=> 70,
			'tiltfx_bgfixed'				=> 'true',
			'tiltfx_perspective'			=> 1000,
			'tiltfx_translatex'				=> -10,
			'tiltfx_translatey'				=> -10,
			'tiltfx_translatez'				=> 20,
			'tiltfx_rotatex'				=> 2,
			'tiltfx_rotatey'				=> 2,
			'tiltfx_rotatez'				=> 0,
			
			'hover_event'					=> 'none',
			'hover_show_title'				=> 'true',
			'hover_link'					=> '',
			'hover_text'					=> '',
			'hover_title'					=> '',
			'hover_image'					=> '',
			'hover_link'					=> '',				
			'hover_video_link'				=> '',
			'hover_video_auto'				=> 'true',
			'hover_video_related'			=> 'false',
			
			'content_wpautop'				=> 'false',
			
			'overlay_handle_show'			=> 'true',
			'overlay_handle_color'			=> '#0094FF',
			
			'lightbox_group'				=> 'true',
			'lightbox_group_name'			=> '',
			'lightbox_size'					=> 'full',
			'lightbox_effect'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Default_Animation,
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'false',
			'lightbox_backlight'			=> 'auto',
			'lightbox_backlight_color'		=> '#ffffff',
			
			'tooltip_content_html'			=> '',
			'tooltip_position'				=> 'ts-simptip-position-top',
			'tooltip_style'					=> 'ts-simptip-style-black',
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,
			
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id' 						=> '',
			'el_class'                  	=> '',
			'css'							=> '',
		), $atts ));

		if ($hover_frontent == "false") {
			wp_enqueue_style('dashicons');
			wp_enqueue_script('ts-extend-hammer');
			wp_enqueue_script('ts-extend-nacho');
			wp_enqueue_style('ts-extend-nacho');
			if (strlen($tooltip_content_html) != 0) {
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');
			}
			wp_enqueue_script('ts-extend-tiltfx');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		} else {
			wp_enqueue_style('ts-visual-composer-extend-front');
		}
	
		$tiltfx_image 						= wp_get_attachment_image_src($image, 'full');
	
		$randomizer							= mt_rand(999999, 9999999);
		$output 							= "";
		$wpautop 							= ($content_wpautop == "true" ? true : false);
		
		if (!empty($el_id)) {
			$tiltfx_image_id				= $el_id;
		} else {
			$tiltfx_image_id				= 'ts-vcsc-image-tiltfx-' . $randomizer;
		}

		// Tooltip
		$tooltip_position					= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style						= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		$tooltip_class						= 'ts-has-tooltipster-tooltip';	
		if (strlen($tooltip_content_html) != 0) {
			$Tooltip_Content				= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class					= $tooltip_class;
		} else {
			$Tooltip_Content				= '';
			$Tooltip_Class					= '';
		}
		
		// iFrame / Link
		if (($hover_event == "link") || ($hover_event == "iframe")) {
			$link 							= TS_VCSC_Advancedlinks_GetLinkData($hover_link);
			$a_href							= $link['url'];
			$a_title 						= '';
			$a_target 						= $link['target'];
		} else {
			$a_href							= 'javascript:void(0);';
			$a_title						= '';
			$a_target						= '_blank';
		}
		if ($a_href == '') {
			$a_href							= 'javascript:void(0);';
		}		
		// YouTube Video
		if ($hover_event == "youtube") {
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $hover_video_link)) {
				$hover_video_link		= $hover_video_link;
			} else {
				$hover_video_link		= 'https://www.youtube.com/watch?v=' . $hover_video_link;
			}
		}
		// DailyMotion Video
		if ($hover_event == "dailymotion") {
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $hover_video_link)) {
				$hover_video_link	= $hover_video_link;
			} else {			
				$hover_video_link	= $hover_video_link;
			}
		}
		
		// Handle Padding
		if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
			$overlay_margin					= "padding-bottom: 15px;";
			$switch_handle_adjust  			= "bottom: 0px;";
		} else {
			$overlay_margin					= "";
			$switch_handle_adjust  			= "";
		}
		$tiltfx_margins 					= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		// Custom Width / Height
		$lightbox_dimensions				= '';
		
		// Data Tilt Options
		$tiltfx_data						= 'data-randomizer="' . $randomizer . '" data-trigger="' . $tiltfx_trigger . '" data-extraimgs="' . $tiltfx_extraimgs . '" data-opacity="' . $tiltfx_opacity . '" data-bgfixed="' . $tiltfx_bgfixed . '" data-perspective="' . $tiltfx_perspective . '"';
		$tiltfx_data						.= ' data-translatex="' . $tiltfx_translatex . '" data-translatey="' . $tiltfx_translatey . '" data-translatez="' . $tiltfx_translatez . '"';
		$tiltfx_data						.= ' data-rotatex="' . $tiltfx_rotatex . '" data-rotatey="' . $tiltfx_rotatey . '" data-rotatez="' . $tiltfx_rotatez . '"';
		
		if ($lightbox_backlight == "auto") {
			$nacho_color					= '';
		} else if ($lightbox_backlight == "custom") {
			$nacho_color					= 'data-color="' . $lightbox_backlight_color . '"';
		} else if ($lightbox_backlight == "hideit") {
			$nacho_color					= 'data-color="rgba(0, 0, 0, 0)"';
		}
		
		// Link Output
		$linkString 						= '';
		if ($hover_frontent == "false") {
			if (($hover_event != "none") && ($hover_event == "popup")) {
				// Modal Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="#' . $tiltfx_image_id . '-modal" class="ts-image-tiltfx-link ts-image-tiltfx-link-popup ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-modal no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "iframe")) {
				// iFrame Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="' . $a_href . '" target="' . $a_target . '" class="ts-image-tiltfx-link ts-image-tiltfx-link-iframe ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="iframe" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "image")) {
				// Image Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="' . $tiltfx_image[0] . '" class="ts-image-tiltfx-link ts-image-tiltfx-link-image ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "youtube")) {
				// YouTube Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-image-tiltfx-link ts-image-tiltfx-link-youtube ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-related="' . $hover_video_related .'" data-videoplay="' . $hover_video_auto .'" data-type="youtube" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "vimeo")) {
				// Vimeo Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="' . $hover_video_link . '" class="ts-image-tiltfx-link ts-image-tiltfx-link-vimeo ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-videoplay="' . $hover_video_auto . '" data-type="vimeo" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "dailymotion")) {
				// DailyMotion Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-image-tiltfx-link ts-image-tiltfx-link-dailymotion ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-videoplay="' . $hover_video_auto . '" data-type="dailymotion" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "html5")) {
				// HTML5 Video Popup
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" href="#' . $modal_id . '" class="ts-image-tiltfx-link ts-image-tiltfx-link-html5 ' . $tiltfx_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "link")) {
				// Link Event
				$linkString .= '<a id="' . $tiltfx_image_id . '-trigger" class="ts-image-tiltfx-link ts-image-tiltfx-link-page" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '"></a>';
			} else {
				// No Link Event
				$linkString .= '';
			}
		}		
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_TiltFX', $atts);
		} else {
			$css_class						= '';
		}
		
		$content_title						= '';

		if ($hover_frontent == "false") {
			$output .= '<div id="' . $tiltfx_image_id . '" class="ts-image-tiltfx-container ts-image-hover-frame ' . $Tooltip_Class . ' ' . $el_class . ' ' . $css_class . '"' . $Tooltip_Content . ' style="' . $tiltfx_margins . '">';
				if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
					$output .= '<div class="" style="width: 100%; height: 100%; ' . $overlay_margin . '">';
				}
					// TiltFX Image
					$output .= '<div class="ts-image-tiltfx-wrapper" style="" data-image-path="' . $tiltfx_image[0] . '" data-image-height="' . $tiltfx_image[1] . '" data-image-width="' . $tiltfx_image[2] . '">';
						$output .= '<img class="ts-image-tiltfx-placeholder" src="' . $tiltfx_image[0] . '" data-no-lazy="1">';
						$output .= '<img class="ts-image-tiltfx-applyeffect" src="' . $tiltfx_image[0] . '" data-no-lazy="1" ' . $tiltfx_data . '>';
						$output .= $linkString;
					$output .= '</div>';				
					// Overlay Handle
					if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
						$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_hover" style="background-color: ' . $overlay_handle_color . '"><i class="handle_hover"></i></span></div>';
					}
				if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
					$output .= '</div>';
				}			
				// Create hidden DIV with Modal Popup iHover Content
				if (($hover_frontent == "false") && ($hover_event == "popup")) {
					$output .= '<div id="' . $tiltfx_image_id . '-modal" class="ts-modal-content nch-hide-if-javascript" style="display: none; padding: 15px;">';
						$output .= '<div class="ts-modal-white-header"></div>';
						$output .= '<div class="ts-modal-white-frame" style="">';
							$output .= '<div class="ts-modal-white-inner">';
								if ($hover_title != "") {
									$output .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; margin-bottom: 10px;">' . $hover_title . '</h2>';
								}
								if (function_exists('wpb_js_remove_wpautop')){
									$output .= wpb_js_remove_wpautop(do_shortcode($content), $wpautop);
								} else {
									$output .= do_shortcode($content);
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
			$output .= '</div>';
		} else {
			$output .= '<div id="' . $tiltfx_image_id . '" class="ts-image-tiltfx-container ts-image-hover-frame ' . $Tooltip_Class . ' ' . $el_class . ' ' . $css_class . '"' . $Tooltip_Content . ' style="' . $tiltfx_margins . '">';
				if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
					$output .= '<div class="" style="width: 100%; height: 100%; ' . $overlay_margin . '">';
				}
				$output .= '<div class="ts-image-tiltfx-wrapper" style="" data-image-path="' . $tiltfx_image[0] . '" data-image-height="' . $tiltfx_image[1] . '" data-image-width="' . $tiltfx_image[2] . '">';
					$output .= '<img class="ts-image-tiltfx-frontendeditor" src="' . $tiltfx_image[0] . '" data-no-lazy="1" ' . $tiltfx_data . '>';
				$output .= '</div>';
					// Overlay Handle
					if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
						$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_hover" style="background-color: ' . $overlay_handle_color . '"><i class="handle_hover"></i></span></div>';
					}
				if (($overlay_handle_show == "true") && ($tiltfx_trigger != 'scroll')) {
					$output .= '</div>';
				}	
			$output .= '</div>';
		}
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>