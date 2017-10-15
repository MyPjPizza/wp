<?php
	add_shortcode('TS_VCSC_Image_Placeholder', 'TS_VCSC_Image_Placeholder_Function');
	function TS_VCSC_Image_Placeholder_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-extend-placeholder');
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Extensions_Admin_Editor();
		}
		
		extract( shortcode_atts( array(
			// Generator
			'rendertype'				=> 'image',
			// Theme Settings
			'theme'						=> 'random',
			'background'				=> '2a2025',
			'foreground'				=> 'ffffff',
			'position'					=> 'center',
			'outline'					=> 'false',
			'radius'					=> '',
			// Ratio Size Settings
			'auto_ratio'				=> 'true',
			'auto_width'				=> 1280,
			'auto_height'				=> 720,
			// Other Size Settings
			'height_pixel'				=> 200,
			'width_responsive'			=> 'true',
			'width_percent'				=> 100,
			'width_pixel'				=> 250,		
			// Text Settings
			'text_type'					=> 'standard',
			'text_string'				=> '',
			'text_literal'				=> 'false',
			'text_break'				=> 'true',
			'text_size'					=> 18,
			'text_font'					=> '',
			'text_align'				=> 'center',
			'text_weight'				=> 'bold',
			'linewrap'					=> 100,
			// Other Settings
			'margin_bottom'				=> '0',
			'margin_top' 				=> '0',
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			$rendertype					= "image";			
		} else {
			$rendertype 				= "object";
		}
		
		$output 						= '';
		
		// Element ID
		if (!empty($el_id)) {
			$placeholder_id				= $el_id;
		} else {
			$placeholder_id				= 'ts-image-placeholder-' . mt_rand(999999, 9999999);
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_Placeholder', $atts);
		} else {
			$css_class					= '';
		}
		
		// Position Settings
		if ($position == "center") {
			$data_position				= 'padding: 0; margin: 0 auto; float: none; max-width: 100%;';
		} else if ($position == "left") {
			$data_position				= 'padding: 0; margin: 0; float: left; max-width: 100%;';
		} else if ($position == "right") {
			$data_position				= 'padding: 0; margin: 0; float: right; max-width: 100%;';
		}
		
		// Size Settings
		if ($auto_ratio == "true") {
			$data_size					= $auto_width . 'x' . $auto_height . '';
			$data_auto					= 'auto=yes' . ($text_literal == "false" ? "&textmode=exact" : "") . '&';
		} else {
			if ($width_responsive == "true") {
				$data_size				= $width_percent . 'px';
			} else {
				$data_size				= $width_pixel . 'x';
			}
			$data_size					.= $height_pixel . '';
			$data_auto					= '';
		}
		
		// Text Settings
		if (($text_type == "custom") && ($text_string != '')) {
			$data_mode					= ($text_literal == 'true' ? '&textmode=literal' : '');
			$data_text					= '&text=' . $text_string . '&align=' . $text_align . '&size=' . $text_size . '&fontweight=' . $text_weight . '&lineWrap=' . ($linewrap / 100) . '&nowrap=' . ($text_break == "true" ? "no" : "yes") . '&outline=' . ($outline == "true" ? "yes" : "no");
		} else if ($text_type == "none") {
			$data_mode					= '';
			$data_text					= '';
		} else {
			$data_mode					= ($text_literal == 'true' ? '&textmode=literal' : '');
			$data_text					= '&align=' . $text_align . '&size=' . $text_size . '&fontweight=' . $text_weight . '&lineWrap=' . ($linewrap / 100) . '&nowrap=' . ($text_break == "true" ? "no" : "yes") . '&outline=' . ($outline == "true" ? "yes" : "no");
		}
		
		// Theme Settings
		$themes_easy 					= array('gray', 'social', 'industrial', 'sky', 'vine', 'lava');
		$themes_easy					= $themes_easy[array_rand($themes_easy)];
		$themes_full 					= array(
			'gray' 			=> array(
				'background' 		=> '#EEEEEE',
				'foreground' 		=> '#AAAAAA'
			),
			'social' 		=> array(
				'background' 		=> '#3a5a97',
				'foreground' 		=> '#FFFFFF'
			),
			'industrial' 	=> array(
				'background' 		=> '#434A52',
				'foreground' 		=> '#C2F200'
			),
			'sky' 			=> array(
				'background' 		=> '#0D8FDB',
				'foreground' 		=> '#FFFFFF'
			),
			'vine' 			=> array(
				'background' 		=> '#39DBAC',
				'foreground' 		=> '#1E292C'
			),
			'lava' 			=> array(
				'background' 		=> '#F8591A',
				'foreground' 		=> '#1C2846'
			),
			'custom' 		=> array(
				'background' 		=> $background,
				'foreground' 		=> $foreground
			),
	    );
		if ($text_type != "none") {
			if ($theme == "random") {
				$theme					= $themes_easy;
				$data_theme				= 'theme=' . $theme;
			} else if ($theme == "custom") {
				$data_theme				= 'bg=' . $background . '&fg=' . $foreground;
			} else {
				$data_theme				= 'theme=' . $theme;
			}
		} else {
			if (($theme != "custom")) {
				if ($theme == "random") {
					$theme				= $themes_easy;
					$data_theme			= 'bg=' . $themes_full[$theme]['background'] . '&fg=' . $themes_full[$theme]['background'];
				} else {
					$data_theme			= 'bg=' . $themes_full[$theme]['background'] . '&fg=' . $themes_full[$theme]['background'];
				}
			} else {
				$data_theme				= 'bg=' . $background . '&fg=' . $background;
			}
		}
		
		// Final Output
		$output .= '<div id="' . $placeholder_id . '" class="ts-image-placeholder clearFixMe ' . $el_class . ' ' . $css_class . ' ' . $radius . '" style="margin: ' . $margin_top . 'px auto ' . $margin_bottom . 'px auto; clear: both; width: 100%; height: 100%; display: block;">';
			if ($rendertype == "image") {
				$output .= '<img id="' . $placeholder_id . '-image" class="ts-image-placeholder-image ' . $radius . '" data-holder-src="holder.js/' . $data_size . '?' . $data_auto . $data_theme . $data_mode . $data_text . '" style="' . $data_position . '">';
			} else if ($rendertype == "object") {
				$output .= '<object id="' . $placeholder_id . '-object" class="ts-image-placeholder-object ' . $radius . '" data-holder-src="holder.js/' . $data_size . '?' . $data_auto . $data_theme . $data_mode . $data_text . '" style="' . $data_position . '"></object>';
			}
			$output .= '<div class="clearFixMe"></div>';
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>