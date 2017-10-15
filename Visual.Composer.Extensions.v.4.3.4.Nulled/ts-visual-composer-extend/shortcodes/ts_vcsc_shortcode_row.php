<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	add_filter('TS_VCSC_ComposerRowAdditions_Filter',		'TS_VCSC_ComposerRowAdditions', 		10, 2);
	
	function TS_VCSC_ComposerRowAdditions($output, $atts, $content = '') {
		global $VISUAL_COMPOSER_EXTENSIONS;
		$TS_VCSC_RowToggleLimits		= get_option('ts_vcsc_extend_settings_rowVisibilityLimits', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Row_Toggle_Defaults);
		$TS_VCSC_RowOffsetSettings		= get_option('ts_vcsc_extend_settings_additionsOffsets',	0);
		ob_start();

		extract(shortcode_atts( array(
			'ts_row_bg_retrieve'		=> 'single',
			'ts_row_bg_image'			=> '',
			'ts_row_bg_extimage'		=> '',
			'ts_row_bg_addition'		=> 'none',
			
			'ts_row_bg_frontlayer'		=> 'none',
			'ts_row_bg_frontimage'		=> '',
			'ts_row_bg_frontexternal'	=> '',
			'ts_row_bg_frontrepeat'		=> 'no-repeat',
			'ts_row_bg_frontposition'	=> 'center',
			'ts_row_bg_frontcustom'		=> '',
			'ts_row_bg_frontsize'		=> 'cover',
			'ts_row_bg_frontopacity'	=> 100,
			
			'ts_row_bg_backlayer'		=> 'none',
			'ts_row_bg_backimage'		=> '',
			'ts_row_bg_backexternal'	=> '',
			'ts_row_bg_backrepeat'		=> 'no-repeat',
			'ts_row_bg_backposition'	=> 'center',
			'ts_row_bg_backcustom'		=> '',
			'ts_row_bg_backsize'		=> 'cover',
			
			'ts_row_bg_group'			=> '',
			'ts_row_bg_source'			=> 'full',
			'ts_row_bg_effects'			=> '',
			'ts_row_break_parents'		=> 0,
			
			'ts_row_blur_strength'		=> '',
			'ts_row_raster_use'			=> 'false',
			'ts_row_raster_type'		=> '',
			
			'ts_row_overlay_use'		=> 'false',
			'ts_row_overlay_color'		=> 'rgba(30,115,190,0.25)',
			'ts_row_overlay_opacity'	=> 25,
			
			'ts_row_zindex'				=> 0,
			'ts_row_min_height'			=> 0,
			'ts_row_screen_height'		=> 'false',
			'ts_row_screen_offset'		=> 0,
			
			'svg_top_on'				=> 'false',
			'svg_top_style'				=> '1',
			'svg_top_height'			=> 100,
			'svg_top_flip'				=> 'false',
			'svg_top_position'			=> 0,
			'svg_top_color1'			=> '#ffffff',
			'svg_top_color2'			=> '#ededed',
			
			'svg_bottom_on'				=> 'false',
			'svg_bottom_style'			=> '1',
			'svg_bottom_height'			=> 100,
			'svg_bottom_flip'			=> 'false',
			'svg_bottom_position'		=> 0,
			'svg_bottom_color1'			=> '#ffffff',
			'svg_bottom_color2'			=> '#ededed',
			
			'ts_row_bg_position'		=> 'center',
			'ts_row_bg_position_custom'	=> '',
			'ts_row_bg_alignment_h'		=> 'center',
			'ts_row_bg_alignment_v'		=> 'center',
			'ts_row_bg_repeat'			=> 'no-repeat',
			'ts_row_bg_size_parallax'	=> 'cover',
			'ts_row_bg_size_standard'	=> 'cover',
			'ts_row_parallax_type'		=> 'up',
			'ts_row_parallax_speed'		=> 20,
			'ts_row_parallax_fade'		=> 1000,
			
			'ts_row_slide_images'		=> '',
			'ts_row_slide_auto'			=> 'true',
			'ts_row_slide_controls'		=> 'true',
			'ts_row_slide_shuffle'		=> 'false',
			'ts_row_slide_delay'		=> 5000,
			'ts_row_slide_bar'			=> 'true',
			'ts_row_slide_transition'	=> 'random',
			'ts_row_slide_switch'		=> 2000,			
			'ts_row_slide_halign'		=> 'center',
			'ts_row_slide_valign'		=> 'center',
			
			'ts_row_kenburns_animation'	=> 'null',
			
			'ts_row_automove_scroll'	=> 'true',
			'ts_row_automove_align'		=> 'horizontal',
			'ts_row_automove_path_v'	=> 'topbottom',
			'ts_row_automove_path_h'	=> 'leftright',
			'ts_row_automove_motio'		=> 'true',
			'ts_row_automove_speed'		=> 75,
			'ts_row_automove_pixel'		=> 75,
			
			'ts_row_movement_x_allow'	=> 'true',
			'ts_row_movement_x_ratio'	=> 20,
			'ts_row_movement_y_allow'	=> 'true',
			'ts_row_movement_y_ratio'	=> 20,
			'ts_row_movement_content'	=> 'false',
			
			'ts_margin_left'			=> 0,
			'ts_margin_right'			=> 0,
			'margin_left'				=> 0,
			'margin_right'				=> 0,
			'padding_top'				=> 30,
			'padding_bottom'			=> 30,
			'enable_mobile'				=> 'false',
			
			'single_color'				=> '#ffffff',
			
			'gradiant_advanced'			=> 'false',
			'gradient_generator'		=> '',
			'gradient_angle'			=> 0,
			'gradient_color_start'		=> '#cccccc',
			'gradient_start_offset'		=> 0,
			'gradient_color_end'		=> '#cccccc',
			'gradient_end_offset'		=> 100,
			
			'trianglify_render'			=> 'canvas',
			'trianglify_colorsx'		=> 'random',
			'trianglify_colorsy'		=> 'match_x',
			'trianglify_generatorx'		=> '',
			'trianglify_generatory'		=> '',
			'trianglify_cellsize'		=> 50,
			'trianglify_variance'		=> 0.75,
			
			'patternbolt_type'			=> 'ts-patternbolt-buseca',
			'patternbolt_color'			=> '#ff9659',
			'patternbolt_size'			=> 40,
			'patternbolt_opacity'		=> 75,
			
			'ts_particles_count'		=> 30,
			'ts_particles_size_max'		=> 10,
			'ts_particles_size_scale'	=> 'true',
			'ts_particles_size_anim'	=> 'false',
			'ts_particles_color'		=> '#ffffff',
			'ts_particles_stroke_width'	=> 0,
			'ts_particles_stroke_color'	=> '#000000',
			'ts_particles_back_type'	=> 'color',
			'ts_particles_back_color'	=> '#b61924',
			'ts_particles_back_image'	=> '',
			'ts_particles_back_repeat'	=> 'no-repeat',
			'ts_particles_back_place'	=> 'center center',
			'ts_particles_back_size'	=> 'cover',
			'ts_particles_shape_source'	=> 'internal',
			'ts_particles_shape_types'	=> 'circle',
			'ts_particles_shape_image'	=> '',
			'ts_particles_link_lines'	=> 'true',
			'ts_particles_link_color'	=> '#ffffff',
			'ts_particles_link_width'	=> 1,
			'ts_particles_hover'		=> 'false',
			'ts_particles_click'		=> 'false',
			'ts_particles_move'			=> 'true',
			'ts_particles_direction'	=> 'none',
			'ts_particles_speed'		=> 6,
			'ts_particles_random'		=> 'false',
			'ts_particles_straight'		=> 'false',
			
			'video_youtube'				=> '',
			'video_background'			=> '',
			'video_mute'				=> 'true',
			'video_loop'				=> 'false',
			'video_remove'				=> 'false',
			'video_start'				=> 'false',
			'video_hover'				=> 'false',
			'video_stop'				=> 'true',
			'video_controls'			=> 'true',
			'video_raster'				=> 'false',
			
			'video_mp4'					=> '',
			'video_ogv'					=> '',
			'video_webm'				=> '',
			'video_image'				=> '',
			
			'multi_effect'				=> 'fixed',
			'multi_speed'				=> 1,
			
			'ts_equalize_columns'		=> 'false',
			'ts_equalize_align'			=> 'center',
			'ts_equalize_stack'			=> 'false',
			'ts_equalize_spacing'		=> 0,

			'animation_factor'			=> '0.33',
			'animation_scroll'			=> 'false',
			'animation_view'			=> '',
			'animation_offset'			=> '50%',
			'animation_speed'			=> 2000,
			
			'show_large'				=> 'true',
			'show_medium'				=> 'true',
			'show_small'				=> 'true',
			'show_extra'				=> 'true',
			'show_remove'				=> 'false',
		), $atts));
		
		// Check for Frontend Editor Mode
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$frontend_edit				= 'true';
		} else {
			$frontend_edit				= 'false';
		}
		
		// Check if Extended Row Options Utilized
		if (($ts_row_bg_effects != "") || (!empty($animation_view)) || ($ts_equalize_columns == 'true')) {
			$extended_effects			= "true";
		} else {
			$extended_effects			= "false";
		}
		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") && ($extended_effects == "true")) {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}		
		if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false") && ($extended_effects == "true")) {
			wp_enqueue_style('ts-extend-animations');			
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-backgrounds');
			wp_enqueue_script('ts-visual-composer-extend-front');			
		}

		$output 						= "";
		
		$randomizer						= mt_rand(999999, 9999999);
		
		// Check for Row Padding/Margin Offsets
		if ($TS_VCSC_RowOffsetSettings == 0) {
			$row_offsetsallow			= 'data-offsetsallow="false"';
			$padding_top				= '0';
			$padding_bottom				= '0';
			$margin_left				= $ts_margin_left;
			$margin_right				= $ts_margin_right;
		} else {
			$row_offsetsallow			= 'data-offsetsallow="true"';
		}

		// Viewport Animations
		if (!empty($animation_view)) {
			$animation_css				= "ts-viewport-css-" . $animation_view;
			$output						.= '<div class="ts-viewport-row ts-viewport-animation" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-offset="' . $animation_offset . '" data-scrollup = "' . $animation_scroll . '" data-factor="' . $animation_factor . '" data-viewport="' . $animation_css . '" data-speed="' . $animation_speed . '"></div>';
		} else {
			$animation_css				= '';
		}

		// CSS3 Blur Effect
		if ($ts_row_blur_strength != '') {
			$blur_class					= "ts-background-blur " . $ts_row_blur_strength;
			if ($ts_row_blur_strength == "ts-background-blur-small") {
				$blur_factor			= 2;
			} else if ($ts_row_blur_strength == "ts-background-blur-medium") {
				$blur_factor			= 5;
			} else if ($ts_row_blur_strength == "ts-background-blur-strong") {
				$blur_factor			= 8;
			}
		} else {
			$blur_class					= "";
			$blur_factor				= 0;
		}
		
		// Raster (Noise) Overlay
		if (($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) {
			$raster_content				= '<div class="ts-background-raster" style="background-image: url(' . $ts_row_raster_type . ');"></div>';
		} else {
			$raster_content				= '';
		}
		
		// Color Overlay
		if (($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) {
			$overlay_content			= '<div class="ts-background-overlay" style="background: ' . $ts_row_overlay_color . ';"></div>';
		} else {
			$overlay_content			= '';
		}
		
		// SVG Shape Overlays
		$svg_enabled					= 'false';
		if ($svg_top_on == "true") {
			$svg_top_content			= '<div id="ts-background-separator-top-' . $randomizer . '" class="ts-background-separator-container" style="height: ' . $svg_top_height . 'px; top: ' . $svg_top_position . 'px; bottom: auto; z-index: ' . (1 + $ts_row_zindex) . ';"><div class="ts-background-separator-wrap ts-background-separator-top' . ($svg_top_flip == "true" ? "-flip" : "") . '" data-random="' . $randomizer . '" data-height="' . $svg_top_height . '" data-position="top" style="height: ' . $svg_top_height . 'px;">' . TS_VCSC_GetRowSeparator($svg_top_style, $svg_top_color1, $svg_top_color2, $svg_top_height, "") . '</div></div>';
			$svg_enabled				= 'true';
		} else {
			$svg_top_content			= '';
		}
		if ($svg_bottom_on == "true") {
			$svg_bottom_content			= '<div id="ts-background-separator-bottom-' . $randomizer . '" class="ts-background-separator-container" style="height: ' . $svg_bottom_height . 'px; top: auto; bottom: ' . $svg_bottom_position . 'px; z-index: ' . (1 + $ts_row_zindex) . ';"><div class="ts-background-separator-wrap ts-background-separator-bottom' . ($svg_bottom_flip == "true" ? "-flip" : "") . '" data-random="' . $randomizer . '" data-height="' . $svg_bottom_height . '" data-position="bottom" style="height: ' . $svg_bottom_height . 'px;">' . TS_VCSC_GetRowSeparator($svg_bottom_style, $svg_bottom_color1, $svg_bottom_color2, $svg_bottom_height, "") . '</div></div>';
			$svg_enabled				= 'true';
		} else {
			$svg_bottom_content			= '';
		}
		
		// Column Equalize Settings
		if ($ts_equalize_columns == 'true') {
			if ((defined('WPB_VC_VERSION')) && (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.9.0') >= 0)) {
				$column_equalize_string	= 'data-column-native="true" data-column-equalize="true" data-column-align="' . $ts_equalize_align . '" data-column-stack="' . $ts_equalize_stack . '" data-column-spacing="' . $ts_equalize_spacing . '"';
			} else {
				$column_equalize_string	= 'data-column-native="false" data-column-equalize="true" data-column-align="' . $ts_equalize_align . '" data-column-stack="' . $ts_equalize_stack . '" data-column-spacing="' . $ts_equalize_spacing . '"';
			}			
			$column_equalize_class		= 'ts-columns-equalize-enabled';
		} else {
			$column_equalize_string		= 'data-column-equalize="false"';
			$column_equalize_class		= 'ts-columns-equalize-disabled';
		}
		
		// Row Toggle Settings
		$row_toggle_limits				= $TS_VCSC_RowToggleLimits;
		$large_default					= 'true';
		$large_limit					= $row_toggle_limits['Large Devices'];
		$medium_default					= 'true';
		$medium_limit					= $row_toggle_limits['Medium Devices'];
		$small_default					= 'true';
		$small_limit					= $row_toggle_limits['Small Devices'];
		$extra_default					= 'true';
		$extra_limit					= 0;
		if ((($large_default != $show_large) || ($medium_default != $show_medium) || ($small_default != $show_small) || ($extra_default != $show_extra)) && ($frontend_edit == "false")) {
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-backgrounds');
			wp_enqueue_script('ts-visual-composer-extend-front');
			$row_toggle_trigger			= 'true';
			$row_toggle_class			= $column_equalize_class . ' ts-composium-row-background ts-device-visibility';
			$row_toggle_string			= $column_equalize_string . ' data-width-current="" data-width-break="' . get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak', '600') . '" data-showremove="' . $show_remove . '" data-largeshow="' . $show_large . '" data-largelimit="' . $large_limit . '" data-mediumshow="' . $show_medium . '" data-mediumlimit="' . $medium_limit . '" data-smallshow="' . $show_small . '" data-smalllimit="' . $small_limit . '" data-extrashow="' . $show_extra . '" data-extralimit="' . $extra_limit . '"';
		} else {
			$row_toggle_trigger			= 'false';
			$row_toggle_class			= $column_equalize_class . ' ts-composium-row-background';
			$row_toggle_string			= $column_equalize_string . ' data-width-current="" data-width-break="' . get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak', '600') . '"';
		}
		
		// Ken Burns Effect
		if ($ts_row_kenburns_animation != 'null') {			
			if ($ts_row_kenburns_animation == 'random') {
				$kenburns_effects 		= array('centerZoom', 'centerZoomFadeOut', 'centerZoomFadeIn', 'kenburns', 'kenburnsLeft', 'kenburnsRight', 'kenburnsUp', 'kenburnsUpLeft', 'kenburnsUpRight', 'kenburnsDown', 'kenburnsDownLeft', 'kenburnsDownRight');
				$kenburns_animation 	= 'ts-css-animation-' . $kenburns_effects[array_rand($kenburns_effects, 1)];
			} else {
				$kenburns_animation 	= 'ts-css-animation-' . $ts_row_kenburns_animation;
			}
			$kenburns_string			= 'data-kenburns-set="true" data-kenburns-animation="' . $kenburns_animation . '"';
		} else {
			$kenburns_animation			= '';
			$kenburns_string			= 'data-kenburns-set="false"';			
		}
		
		// No Background Effect
		if ($row_toggle_trigger == "true") {
			if ($ts_row_bg_effects == "") {
				$output					.= '<div id="ts-composium-row-background-' . $randomizer . '" class="' . $row_toggle_class . '" ' . $row_toggle_string . '></div>';
			}
		} else if ($ts_equalize_columns == 'true') {
			if ($ts_row_bg_effects == "") {
				$output					.= '<div id="ts-composium-row-background-' . $randomizer . '" class="' . $row_toggle_class . '" ' . $row_toggle_string . '></div>';
			}
		}
		
		// Single Image or Group
		if (($ts_row_bg_effects == "image") || ($ts_row_bg_effects == "fixed") || ($ts_row_bg_effects == "parallax") || ($ts_row_bg_effects == "automove") || ($ts_row_bg_effects == "movement")) {
			if ($ts_row_bg_retrieve == 'random') {
				$ts_row_bg_group		= explode(',', $ts_row_bg_group);
				if (is_array($ts_row_bg_group)) {
					$ts_row_bg_image	= $ts_row_bg_group[array_rand($ts_row_bg_group)];
				} else {
					$ts_row_bg_image	= '';
				}
			} else if ($ts_row_bg_retrieve == 'single') {
				$ts_row_bg_image		= $ts_row_bg_image;
			} else if ($ts_row_bg_retrieve == 'external') {
				$ts_row_bg_image		= '';
			}
			if ($ts_row_bg_image != '') {
				$ts_row_bg_image_url	= wp_get_attachment_image_src($ts_row_bg_image, $ts_row_bg_source);
				$ts_row_bg_image_link	= $ts_row_bg_image_url[0];
				$ts_row_bg_image_width	= $ts_row_bg_image_url[1];
				$ts_row_bg_image_height	= $ts_row_bg_image_url[2];
			} else if (($ts_row_bg_retrieve == 'external') && ($ts_row_bg_extimage != '')) {
				$ts_row_bg_image_link	= $ts_row_bg_extimage;
				$ts_row_bg_image_width	= 1;
				$ts_row_bg_image_height	= 1;
			} else {
				$ts_row_bg_effects		= '';
				$ts_row_bg_image_link	= '';
				$ts_row_bg_image_width	= 1;
				$ts_row_bg_image_height	= 1;
			}
		}
		if (($ts_row_bg_effects == "parallax") || ($ts_row_bg_effects == "automove")) {
			// Fixed Background Layer
			if (($ts_row_bg_backlayer == "internal") && ($ts_row_bg_backimage != '')) {
				$ts_row_bg_back_url		= wp_get_attachment_image_src($ts_row_bg_backimage, $ts_row_bg_source);
				$ts_row_bg_back_link	= $ts_row_bg_back_url[0];
				$layer_back				= '<div class="ts-background-layer-back" style="background-image: url(' . $ts_row_bg_back_link . '); background-repeat: ' . $ts_row_bg_backrepeat . '; background-position: ' . $ts_row_bg_backposition . '; background-size: ' . $ts_row_bg_backsize . ';"></div>';
			} else if (($ts_row_bg_backlayer == "external") && ($ts_row_bg_backexternal != '')) {
				$ts_row_bg_back_url	= $ts_row_bg_backexternal;
				$layer_back				= '<div class="ts-background-layer-back" style="background-image: url(' . $ts_row_bg_back_link . '); background-repeat: ' . $ts_row_bg_backrepeat . '; background-position: ' . $ts_row_bg_backposition . '; background-size: ' . $ts_row_bg_backsize . ';"></div>';
			} else {
				$layer_back				= '';
			}
			// Fixed Foreground Layer
			if (($ts_row_bg_frontlayer == "internal") && ($ts_row_bg_frontimage != '')) {
				$ts_row_bg_front_url	= wp_get_attachment_image_src($ts_row_bg_frontimage, $ts_row_bg_source);
				$ts_row_bg_front_link	= $ts_row_bg_front_url[0];
				$layer_front			= '<div class="ts-background-layer-front" style="background-image: url(' . $ts_row_bg_front_link . '); background-repeat: ' . $ts_row_bg_frontrepeat . '; background-position: ' . $ts_row_bg_frontposition . '; background-size: ' . $ts_row_bg_frontsize . '; opacity: ' . ($ts_row_bg_frontopacity / 100) . ';"></div>';
			} else if (($ts_row_bg_frontlayer == "external") && ($ts_row_bg_frontexternal != '')) {
				$ts_row_bg_front_url	= $ts_row_bg_frontexternal;
				$layer_front			= '<div class="ts-background-layer-front" style="background-image: url(' . $ts_row_bg_front_link . '); background-repeat: ' . $ts_row_bg_frontrepeat . '; background-position: ' . $ts_row_bg_frontposition . '; background-size: ' . $ts_row_bg_frontsize . '; opacity: ' . ($ts_row_bg_frontopacity / 100) . ';"></div>';
			} else {
				$layer_front			= '';
			}
		} else {
			$layer_front				= '';
			$layer_back					= '';
		}
		
		// Simple Background Image
		if ($ts_row_bg_effects == "image") {
			if ($ts_row_bg_position == "custom") {
				$ts_row_bg_position		= $ts_row_bg_position_custom;
			}
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-image ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $kenburns_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_width . "' data-image-height='" . $ts_row_bg_image_height . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_link . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				if ($ts_row_kenburns_animation != 'null') {
					$output 			.= '<div class="ts-background-kenburns-wrapper"><div class="ts-background-kenburns-parent"><div class="ts-background-kenburns-image ' . $kenburns_animation . '"></div></div></div>';
				}
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Fixed Background Image
		if ($ts_row_bg_effects == "fixed") {
			if ($ts_row_bg_position == "custom") {
				$ts_row_bg_position		= $ts_row_bg_position_custom;
			}
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-fixed ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_width . "' data-image-height='" . $ts_row_bg_image_height . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_link . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Image Slideshow Background
		if ($ts_row_bg_effects == "slideshow") {
			wp_enqueue_style('ts-extend-vegas');
			wp_enqueue_script('ts-extend-vegas');
			$slider_settings			= 'data-initialized="false" data-autoplay="' .$ts_row_slide_auto . '" data-playing="' .$ts_row_slide_auto . '" data-halign="' . $ts_row_slide_halign . '" data-valign="' . $ts_row_slide_valign . '" data-controls="' . $ts_row_slide_controls . '" data-shuffle="' . $ts_row_slide_shuffle . '" data-delay="' . $ts_row_slide_delay . '" data-bar="' . $ts_row_slide_bar . '" data-transition="' . $ts_row_slide_transition . '" data-switch="' . $ts_row_slide_switch . '" data-animation="' . $ts_row_kenburns_animation . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-slideshow ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' " . $slider_settings . " data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-size='". $ts_row_bg_size_standard . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$slide_images 			= explode(',', $ts_row_slide_images);
				$i 						= 0;
				foreach ($slide_images as $single_image) {
					$i++;
					$slide_image		= wp_get_attachment_image_src($single_image, $ts_row_bg_source);
					$output .= '<div class="ts-background-slideshow-holder" style="display: none;" data-image="' . $slide_image[0] . '" data-width="' . $slide_image[1] . '" data-height="' . $slide_image[2] . '" data-ratio="' . ($slide_image[1] / $slide_image[2]) . '"></div>';
				}
				$output 				.= '<div class="ts-background-slideshow-wrapper"></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
				if ($ts_row_slide_controls == 'true') {
					// Left / Right Navigation
					$output .= '<nav id="nav-arrows-' . $randomizer . '" class="nav-arrows">';
						$output .= '<span class="nav-arrow-prev" style="text-indent: -90000px;">Previous</span>';
						$output .= '<span class="nav-arrow-next" style="text-indent: -90000px;">Next</span>';
					$output .= '</nav>';
				}
				if ($ts_row_slide_auto == 'true') {
					// Auto-Play Controls
					$output .= '<nav id="nav-auto-' . $randomizer . '" class="nav-auto">';
						$output .= '<span class="nav-auto-play" style="display: none; text-indent: -90000px;">Play</span>';
						$output .= '<span class="nav-auto-pause" style="text-indent: -90000px;">Pause</span>';
					$output .= '</nav>';
				}
			$output .= '</div>';
		}
		
		// Parallax Background
		if ($ts_row_bg_effects == "parallax") {
			$parallaxClass				= ($ts_row_parallax_type == "none") ? "" : "ts-background-parallax";
			$parallaxClass				= in_array( $ts_row_parallax_type, array( "none", "fixed", "up", "down", "left", "right", "ts-background-parallax" ) ) ? $parallaxClass : "";			
			if (($ts_row_parallax_type == "up") || ($ts_row_parallax_type == "down")) {
				$ts_row_bg_alignment	= $ts_row_bg_alignment_v;
			} else if (($ts_row_parallax_type == "left") || ($ts_row_parallax_type == "right")) {
				$ts_row_bg_alignment	= $ts_row_bg_alignment_h;
			}			
			if (!empty($parallaxClass)) {
				$ts_row_parallax_speed	= round(($ts_row_parallax_speed / 100), 2);
				$output					.= "<div id='ts-background-main-" . $randomizer . "' class='" . esc_attr($parallaxClass) . " ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " data-completed='false' data-fadespeed='" . $ts_row_parallax_fade . "' " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_width . "' data-image-height='" . $ts_row_bg_image_height . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_link . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-alignment='" . $ts_row_bg_alignment . "' data-repeat='" . $ts_row_bg_repeat . "' data-direction='" . esc_attr($ts_row_parallax_type) . "' data-momentum='" . esc_attr((float)$ts_row_parallax_speed) . "' data-mobile-enabled='" . esc_attr($enable_mobile) . "' data-break-parents='" . esc_attr($ts_row_break_parents) . "'>";
					$output				.= $layer_back;
					$output				.= "<div id='ts-background-parallax-holder-" . $randomizer . "' class='ts-background-parallax-holder'></div>";
					$output				.= $layer_front;
					$output				.= $svg_top_content;
					$output				.= $overlay_content;
					$output				.= $raster_content;
					$output				.= $svg_bottom_content;
				$output 				.= "</div>";
			}
		}
		
		// AutoMove Background
		if ($ts_row_bg_effects == "automove") {
			if ($ts_row_automove_align == "horizontal") {
				$ts_row_automove_path	= $ts_row_automove_path_h;
			} else if ($ts_row_automove_align == "vertical") {
				$ts_row_automove_path	= $ts_row_automove_path_v;
			}
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-automove ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_width . "' data-image-height='" . $ts_row_bg_image_height . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_link . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='repeat 0 0' data-use-motio='" . $ts_row_automove_motio . "' data-mobile-enabled='" . esc_attr($enable_mobile) . "' data-scroll='" . $ts_row_automove_scroll . "' data-alignment='" . $ts_row_automove_align . "' data-direction='" . $ts_row_automove_path . "' data-speed='" . $ts_row_automove_speed . "' data-pixel='" . $ts_row_automove_pixel . "' data-break-parents='" . esc_attr( $ts_row_break_parents ) . "'>";
				$output					.= $layer_back;
				$output					.= "<div id='ts-background-automove-holder-" . $randomizer . "' class='ts-background-automove-holder'></div>";
				$output					.= $layer_front;
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Movement Background
		if ($ts_row_bg_effects == "movement") {
			wp_enqueue_script('ts-extend-parallaxify');	
			$ts_row_movement_data		= ' data-allowx="' . $ts_row_movement_x_allow . '" data-movex="' . $ts_row_movement_x_ratio . '" data-allowy="' . $ts_row_movement_y_allow . '" data-movey="' . $ts_row_movement_y_ratio . '" data-allowcontent="' . $ts_row_movement_content . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-movement ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-image-width='" . $ts_row_bg_image_width . "' data-image-height='" . $ts_row_bg_image_height . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-image='" . $ts_row_bg_image_link . "' data-size='". $ts_row_bg_size_parallax . "' data-position='" . esc_attr($ts_row_bg_position) . "' data-repeat='" . $ts_row_bg_repeat . "' data-mobile-enabled='" . esc_attr($enable_mobile) . "' data-break-parents='" . esc_attr($ts_row_break_parents) . "' " . $ts_row_movement_data . ">";
				$output					.= $svg_top_content;
				$output					.= $overlay_content;				
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Particles Background
		if ($ts_row_bg_effects == "particles") {
			wp_enqueue_script('ts-extend-particles');
			if ($ts_particles_back_type == "image") {
				$ts_particles_back_image	= wp_get_attachment_image_src($ts_particles_back_image, 'full');
				$ts_particles_back_image	= $ts_particles_back_image[0];
			}
			if ($ts_particles_shape_source == "external") {
				$ts_particles_shape_image	= wp_get_attachment_image_src($ts_particles_shape_image, 'full');				
				$ts_particles_shape_width	= $ts_particles_shape_image[1];
				$ts_particles_shape_height	= $ts_particles_shape_image[2];
				$ts_particles_shape_image	= $ts_particles_shape_image[0];				
			} else {
				$ts_particles_shape_width	= 100;
				$ts_particles_shape_height	= 100;
			}
			$ts_row_particles_data		= 'data-particles-count="' . $ts_particles_count . '" data-particles-sizemax="' . $ts_particles_size_max . '" data-particles-sizescale="' . $ts_particles_size_scale . '" data-particles-sizeanimate="' . $ts_particles_size_anim . '"';
			$ts_row_particles_data		.= ' data-particles-shapesource="' . $ts_particles_shape_source . '" data-particles-shapetypes="' . $ts_particles_shape_types . '" data-particles-shapeimage="' . $ts_particles_shape_image . '" data-particles-shapewidth="' . $ts_particles_shape_width . '"';			
			$ts_row_particles_data		.= ' data-particles-color="'  .$ts_particles_color . '" data-particles-strokewidth="' . $ts_particles_stroke_width . '" data-particles-strokecolor="' . $ts_particles_stroke_color . '" data-particles-linklines="' . $ts_particles_link_lines . '" data-particles-linkcolor="' . $ts_particles_link_color . '" data-particles-linkwidth="' . $ts_particles_link_width . '" data-particles-interhover="' . $ts_particles_hover . '" data-particles-interclick="' . $ts_particles_click . '"';
			$ts_row_particles_data		.= ' data-particles-backtype="' . $ts_particles_back_type . '" data-particles-backcolor="' . $ts_particles_back_color . '" data-particles-backimage="' . $ts_particles_back_image . '" data-particles-backrepeat="' . $ts_particles_back_repeat . '" data-particles-backposition="' . $ts_particles_back_place . '" data-particles-backsize="' . $ts_particles_back_size . '" data-particles-shapeheight="' . $ts_particles_shape_height . '"';
			$ts_row_particles_data		.= ' data-particles-moveallow="' . $ts_particles_move . '" data-particles-movedirection="' . $ts_particles_direction . '" data-particles-movespeed="' . $ts_particles_speed . '" data-particles-moverandom="' . $ts_particles_random . '" data-particles-movestraight="' . $ts_particles_straight . '"';
			$output						.= "<div id='ts-background-main-" . $randomizer . "' class='ts-background-particles ts-background " . $row_toggle_class . " " . $blur_class . "' " . $row_toggle_string . " " . $row_offsetsallow . " data-svgshape='" . $svg_enabled . "' data-random='" . $randomizer . "' data-type='" . $ts_row_bg_effects . "' data-inline='" . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . "' data-disabled='false' data-height='" . $ts_row_min_height . "' data-screen='" . $ts_row_screen_height . "' data-offset='" . $ts_row_screen_offset . "' data-blur='" . $blur_factor . "' data-index='" . $ts_row_zindex . "' data-marginleft='" . $margin_left . "' data-marginright='" . $margin_right . "' data-paddingtop='" . $padding_top . "' data-paddingbottom='" . $padding_bottom . "' data-size='cover' data-position='center center' data-repeat='no-repeat' data-mobile-enabled='false' data-break-parents='" . esc_attr($ts_row_break_parents) . "' " . $ts_row_particles_data . ">";
				$output 				.= '<div id="ts-background-particles-holder-' . $randomizer . '" class="ts-background-particles-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= "</div>";
		}
		
		// Selfhosted Video Background I
		if ($ts_row_bg_effects == "videomb") {			
			wp_enqueue_style('ts-font-mediaplayer');
			wp_enqueue_script('ts-extend-multibackground');
			if (!empty($video_image)) {
				$video_image_url		= wp_get_attachment_image_src($video_image, 'full');
				$video_image_url		= $video_image_url[0];
			} else {
				$video_image_url		= "";
			}			
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-multiback ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-attachment="' . $multi_effect . '" data-parallax="' . $multi_speed . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . ((($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) ? $ts_row_raster_type : "") . '" data-overlay="' . ((($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) ? $ts_row_overlay_color : "") . '" data-mp4="' . $video_mp4 . '" data-ogv="' . $video_ogv . '" data-webm="' . $video_webm . '" data-image="' . $video_image_url . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-mute="' . $video_mute . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Selfhosted Video Background II
		if ($ts_row_bg_effects == "video") {			
			wp_enqueue_style('ts-font-mediaplayer');
			wp_enqueue_style('ts-extend-wallpaper');
			wp_enqueue_script('ts-extend-wallpaper');
			if (!empty($video_image)) {
				$video_image_url		= wp_get_attachment_image_src($video_image, 'full');
				$video_image_url		= $video_image_url[0];
			} else {
				$video_image_url		= "";
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-video ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . ((($ts_row_raster_use == "true") && ($ts_row_raster_type != '')) ? $ts_row_raster_type : "") . '" data-overlay="' . ((($ts_row_overlay_use == "true") && ($ts_row_overlay_color != '')) ? $ts_row_overlay_color : "") . '" data-mp4="' . $video_mp4 . '" data-ogv="' . $video_ogv . '" data-webm="' . $video_webm . '" data-image="' . $video_image_url . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-mute="' . $video_mute . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Youtube Video Background I
		if ($ts_row_bg_effects == "youtubemb") {
			wp_enqueue_style('ts-font-mediaplayer');
			wp_enqueue_script('ts-extend-multibackground');
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $video_youtube)) {
				$video_youtube			= TS_VCSC_VideoID_Youtube($video_youtube);
			} else {
				$video_youtube			= $video_youtube;
			}
			if (!empty($video_background)) {
				$video_background		= wp_get_attachment_image_src($video_background, 'full');
				$video_background		= $video_background[0];
			} else {
				$video_background		= TS_VCSC_VideoImage_Youtube($video_youtube);
			}				
			wp_enqueue_script('ts-extend-multibackground');
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-multiback ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-attachment="' . $multi_effect . '" data-parallax="' . $multi_speed . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-image="' . $video_background . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-video-holder multibackground" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Youtube Video Background II
		if ($ts_row_bg_effects == "youtube") {
			wp_enqueue_script('ts-extend-ytplayer');
			wp_enqueue_style('ts-extend-ytplayer');
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $video_youtube)) {
				$video_youtube			= $video_youtube;
			} else {
				$video_youtube			= 'https://www.youtube.com/watch?v=' . $video_youtube;
			}
			if (!empty($video_background)) {
				$video_background		= wp_get_attachment_image_src($video_background, 'full');
				$video_background		= $video_background[0];
			} else {
				$video_background		= TS_VCSC_VideoImage_Youtube($video_youtube);
			}			
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-youtube ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-image="' . $video_background . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-stop="' . $video_stop . '" data-hover="' . $video_hover . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '" data-remove="' . $video_remove . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';		
		}
		
		// Vimeo Video Background
		if ($ts_row_bg_effects == "vimeo") {

		}
		
		// Trianglify Background
		if ($ts_row_bg_effects == "triangle") {
			wp_enqueue_script('ts-extend-trianglify');			
			$trianglify_predefined = array(
				"YlGn" 			=> "#ffffe5,#f7fcb9,#d9f0a3,#addd8e,#78c679,#41ab5d,#238443,#006837,#004529",                          	// Yellow - Green
				"YlGnBu" 		=> "#ffffd9,#edf8b1,#c7e9b4,#7fcdbb,#41b6c4,#1d91c0,#225ea8,#253494,#081d58",                        	// Yellow - Green - Blue
				"GnBu" 			=> "#f7fcf0,#e0f3db,#ccebc5,#a8ddb5,#7bccc4,#4eb3d3,#2b8cbe,#0868ac,#084081",                          	// Green - Blue
				"BuGn" 			=> "#f7fcfd,#e5f5f9,#ccece6,#99d8c9,#66c2a4,#41ae76,#238b45,#006d2c,#00441b",                          	// Blue - Green
				"PuBuGn" 		=> "#fff7fb,#ece2f0,#d0d1e6,#a6bddb,#67a9cf,#3690c0,#02818a,#016c59,#014636",                        	// Purple - Blue - Green
				"PuBu" 			=> "#fff7fb,#ece7f2,#d0d1e6,#a6bddb,#74a9cf,#3690c0,#0570b0,#045a8d,#023858",                          	// Purple - Blue
				"BuPu" 			=> "#f7fcfd,#e0ecf4,#bfd3e6,#9ebcda,#8c96c6,#8c6bb1,#88419d,#810f7c,#4d004b",                          	// Blue - Purple
				"RdPu" 			=> "#fff7f3,#fde0dd,#fcc5c0,#fa9fb5,#f768a1,#dd3497,#ae017e,#7a0177,#49006a",                          	// Red - Purple
				"PuRd" 			=> "#f7f4f9,#e7e1ef,#d4b9da,#c994c7,#df65b0,#e7298a,#ce1256,#980043,#67001f",                          	// Purple - Red
				"OrRd" 			=> "#fff7ec,#fee8c8,#fdd49e,#fdbb84,#fc8d59,#ef6548,#d7301f,#b30000,#7f0000",                          	// Orange - Red
				"YlOrRd" 		=> "#ffffcc,#ffeda0,#fed976,#feb24c,#fd8d3c,#fc4e2a,#e31a1c,#bd0026,#800026",                        	// Yellow - Orange - Red
				"YlOrBr" 		=> "#ffffe5,#fff7bc,#fee391,#fec44f,#fe9929,#ec7014,#cc4c02,#993404,#662506",                        	// Yellow - Orange - Brown
				"Purples" 		=> "#fcfbfd,#efedf5,#dadaeb,#bcbddc,#9e9ac8,#807dba,#6a51a3,#54278f,#3f007d",                       	// Purples
				"Blues" 		=> "#f7fbff,#deebf7,#c6dbef,#9ecae1,#6baed6,#4292c6,#2171b5,#08519c,#08306b",                         	// Blues
				"Greens" 		=> "#f7fcf5,#e5f5e0,#c7e9c0,#a1d99b,#74c476,#41ab5d,#238b45,#006d2c,#00441b",                        	// Greens
				"Oranges" 		=> "#fff5eb,#fee6ce,#fdd0a2,#fdae6b,#fd8d3c,#f16913,#d94801,#a63603,#7f2704",                       	// Oranges
				"Reds" 			=> "#fff5f0,#fee0d2,#fcbba1,#fc9272,#fb6a4a,#ef3b2c,#cb181d,#a50f15,#67000d",                          	// Reds
				"Greys" 		=> "#ffffff,#f0f0f0,#d9d9d9,#bdbdbd,#969696,#737373,#525252,#252525,#000000",                         	// Greys
				"PuOr" 			=> "#7f3b08,#b35806,#e08214,#fdb863,#fee0b6,#f7f7f7,#d8daeb,#b2abd2,#8073ac,#542788,#2d004b",      		// Orange - Purple
				"BrBG" 			=> "#543005,#8c510a,#bf812d,#dfc27d,#f6e8c3,#f5f5f5,#c7eae5,#80cdc1,#35978f,#01665e,#003c30",      		// Brown - Green
				"PRGn" 			=> "#40004b,#762a83,#9970ab,#c2a5cf,#e7d4e8,#f7f7f7,#d9f0d3,#a6dba0,#5aae61,#1b7837,#00441b",      		// Purple - Green
				"PiYG" 			=> "#8e0152,#c51b7d,#de77ae,#f1b6da,#fde0ef,#f7f7f7,#e6f5d0,#b8e186,#7fbc41,#4d9221,#276419",      		// Pink - Yellow - Green
				"RdBu" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#f7f7f7,#d1e5f0,#92c5de,#4393c3,#2166ac,#053061",      		// Red - Blue
				"RdGy" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#ffffff,#e0e0e0,#bababa,#878787,#4d4d4d,#1a1a1a",      		// Red - Grey
				"RdYlBu" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee090,#ffffbf,#e0f3f8,#abd9e9,#74add1,#4575b4,#313695",    		// Red - Yellow - Blue
				"Spectral" 		=> "#9e0142,#d53e4f,#f46d43,#fdae61,#fee08b,#ffffbf,#e6f598,#abdda4,#66c2a5,#3288bd,#5e4fa2",  			// Spectral
				"RdYlGn" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee08b,#ffffbf,#d9ef8b,#a6d96a,#66bd63,#1a9850,#006837",     		// Red - Yellow - Green
				"Accent"		=> "#7fc97f,#beaed4,#fdc086,#ffff99,#386cb0,#f0027f,#bf5b17,#666666",									// Accent
				"Dark2" 		=> "#1b9e77,#d95f02,#7570b3,#e7298a,#66a61e,#e6ab02,#a6761d,#666666",									// Dark
				"Paired" 		=> "#a6cee3,#1f78b4,#b2df8a,#33a02c,#fb9a99,#e31a1c,#fdbf6f,#ff7f00,#cab2d6,#6a3d9a,#ffff99,#b15928",	// Paired
				"Pastel1" 		=> "#fbb4ae,#b3cde3,#ccebc5,#decbe4,#fed9a6,#ffffcc,#e5d8bd,#fddaec,#f2f2f2",							// Pastel 1
				"Pastel2" 		=> "#b3e2cd,#fdcdac,#cbd5e8,#f4cae4,#e6f5c9,#fff2ae,#f1e2cc,#cccccc",									// Pastel 2
				"Set1" 			=> "#e41a1c,#377eb8,#4daf4a,#984ea3,#ff7f00,#ffff33,#a65628,#f781bf,#999999",							// Set 1
				"Set2" 			=> "#66c2a5,#fc8d62,#8da0cb,#e78ac3,#a6d854,#ffd92f,#e5c494,#b3b3b3",									// Set 2
				"Set3" 			=> "#8dd3c7,#ffffb3,#bebada,#fb8072,#80b1d3,#fdb462,#b3de69,#fccde5,#d9d9d9,#bc80bd,#ccebc5,#ffed6f",	// Set 3				
			);
			// Horizontal Pattern
			if ($trianglify_colorsx == "random") {
				//$trianglify_random			= rand(0, count($trianglify_predefined) - 1);
				//$trianglify_allkeys			= array_keys($trianglify_predefined)[$trianglify_random];
				//$trianglify_stringx			= $trianglify_predefined[$trianglify_allkeys];
				$trianglify_stringx				= $trianglify_predefined[array_rand($trianglify_predefined)];
			} else if ($trianglify_colorsx == "custom") {
				$trianglify_array 				= explode(";", $trianglify_generatorx);
				$trianglify_array				= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
				$trianglify_stringx				= array();
				$trianglyfy_position			= 0;
				foreach ($trianglify_array as $key => $value) {
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
					$trianglyfy_position		= TS_VCSC_STRRPOS_String($value, '#', 0);
					$trianglify_stringx[]		= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";
				}
				$trianglify_stringx				= implode(",", $trianglify_stringx);
			} else {
				$trianglify_stringx				= $trianglify_predefined[$trianglify_colorsx];
			}
			// Vertical Pattern
			if ($trianglify_colorsy == "match_x") {
				$trianglify_stringy				= $trianglify_stringx;
			} else {
				if ($trianglify_colorsy == "random") {
					//$trianglify_random		= rand(0, count($trianglify_predefined) - 1);
					//$trianglify_allkeys		= array_keys($trianglify_predefined)[$trianglify_random];
					//$trianglify_stringy		= $trianglify_predefined[$trianglify_allkeys];
					$trianglify_stringy			= $trianglify_predefined[array_rand($trianglify_predefined)];
				} else if ($trianglify_colorsy == "custom") {
					$trianglify_array 			= explode(";", $trianglify_generatory);
					$trianglify_array			= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
					$trianglify_stringy			= array();
					$trianglyfy_position		= 0;
					foreach ($trianglify_array as $key => $value) {
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
						$trianglyfy_position	= TS_VCSC_STRRPOS_String($value, '#', 0);
						$trianglify_stringy[]	= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";
					}
					$trianglify_stringy			= implode(",", $trianglify_stringy);
				} else {
					$trianglify_stringy			= $trianglify_predefined[$trianglify_colorsy];
				}
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-trianglify ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' data-render="' . $trianglify_render . '" data-cellsize="' . $trianglify_cellsize . '" data-variance="' . $trianglify_variance . '" data-colorsx="' . $trianglify_stringx . '" data-colorsy="' . $trianglify_stringy . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-raster="' . $video_raster . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output 				.= '<div class="ts-background-trianglify-holder" style=""></div>';
				$output					.= $svg_top_content;
				$output					.= $overlay_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output						.= '</div>';
		}
		
		// Single Color Background
		if ($ts_row_bg_effects == "single") {
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-single ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' style="display: none; background-color: ' . $single_color . ';" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-color="' . $single_color . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= '</div>';
		}
		
		// Gradient Background
		if ($ts_row_bg_effects == "gradient") {
			if ($gradiant_advanced == 'false') {
				$gradient_css_attr[] 	= 'background: ' . $gradient_color_start . '';
				$gradient_css_attr[] 	= 'background: -moz-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -webkit-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -o-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: -ms-linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr[] 	= 'background: linear-gradient(' . $gradient_angle . 'deg, ' . $gradient_color_start . ' ' . $gradient_start_offset . '%, ' . $gradient_color_end . ' ' . $gradient_end_offset . '%)';
				$gradient_css_attr 		= implode('; ', $gradient_css_attr);
			} else {
				$gradient_css_attr		= $gradient_generator;
			}
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-gradient ts-background ' . $row_toggle_class . '" ' . $row_toggle_string . ' ' . $kenburns_string . ' style="display: none; ' . ($ts_row_kenburns_animation == 'null' ? $gradient_css_attr : '') . '" ' . $row_offsetsallow . ' data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				if ($ts_row_kenburns_animation != 'null') {
					$output 			.= '<div class="ts-background-kenburns-wrapper"><div class="ts-background-kenburns-parent"><div class="ts-background-kenburns-image ' . $kenburns_animation . '" style="' . $gradient_css_attr . '"></div></div></div>';
				}
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= '</div>';
		}
		
		// Patternbolt Background
		if ($ts_row_bg_effects == "patternbolt") {
			wp_enqueue_style('ts-extend-patternbolt');
			$output						.= '<div id="ts-background-main-' . $randomizer . '" class="ts-background-patternbolt ts-background ' . $row_toggle_class . ' ' . $patternbolt_type . '" ' . $row_toggle_string . ' style="display: none; background-size: ' . $patternbolt_size . 'px; background-color: ' . $patternbolt_color . ';" ' . $row_offsetsallow . ' data-opacity="' . $patternbolt_opacity . '" data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" data-type="' . $ts_row_bg_effects . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-color="' . $single_color . '" data-height="' . $ts_row_min_height . '" data-screen="' . $ts_row_screen_height . '" data-offset="' . $ts_row_screen_offset . '" data-blur="' . $blur_factor . '" data-index="' . $ts_row_zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-paddingtop="' . $padding_top . '" data-paddingbottom="' . $padding_bottom . '" data-break-parents="' . esc_attr( $ts_row_break_parents ) . '">';
				$output					.= $svg_top_content;
				$output					.= $raster_content;
				$output					.= $svg_bottom_content;
			$output 					.= '</div>';
		}		
		
		if ($frontend_edit == "false") {
			echo $output;
		}
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	
	if (!function_exists('vc_theme_before_vc_row')){
		function vc_theme_before_vc_row($atts, $content = null) {
			return apply_filters('TS_VCSC_ComposerRowAdditions_Filter', '', $atts, $content);
		}
	}
	if (!function_exists('vc_theme_before_vc_row_inner')){
		function vc_theme_before_vc_row_inner($atts, $content = null){
			return apply_filters('TS_VCSC_ComposerRowAdditions_Filter', '', $atts, $content);
		}
	}
?>