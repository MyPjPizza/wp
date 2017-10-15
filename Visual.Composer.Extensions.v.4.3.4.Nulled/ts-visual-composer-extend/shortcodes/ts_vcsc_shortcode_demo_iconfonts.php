<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    
	// Shortcode to Build Icon Preview for Specific Font
	add_shortcode('TS_VCSC_Icon_Preview', 'TS_VCSC_Icon_Font_Preview');
	function TS_VCSC_Icon_Font_Preview ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		
		extract(shortcode_atts(array(
			'font' 						=> 'Awesome',
			'size'           			=> 16,
			
			'color'						=> '#000000',
			'background'				=> '',
	
			'animation'					=> '',
		), $atts));
		
		// Load CSS for Selected Font
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
			if (($iconfont != "Custom") && ($iconfont == $font)) {
				wp_enqueue_style('ts-font-' . strtolower($iconfont));
			}
			if ($iconfont == "Dashicons") {
				wp_enqueue_style('dashicons');
			}
		}
		
		// Rebuild Font Data Array in Case Font is Disabled
		update_option('ts_vcsc_extend_settings_tinymceFontsAll', 1);
		$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconFontsArrays();
		update_option('ts_vcsc_extend_settings_tinymceFontsAll', 0);
		
		// Define Size for Element
		if ($size != 16) {
			$icon_size					= "height:" . $size . "px; width:" . $size . "px; line-height:" . $size . "px; font-size:" . $size . "px; ";
		} else {
			$icon_size					= "";
		}
		
		// Define Color for Element
		if ($color != "#000000") {
			$icon_color					= "color: " . $color . "; ";
		} else {
			$icon_color					= "";
		}
		
		// Define Background for Element
		if (strlen($background) > 0) {
			$icon_background 			= " background-color: " . $background . "; ";
		} else {
			$icon_background			= "";
		}
	
		// Define Class for Animation
		if (strlen($animation) > 0) {
			$icon_animation				= $animation;
		} else {
			$icon_animation				= "";
		}
		
		// Tooltip Settings
		$tooltip_settings 				= 'data-tooltipster-html="false" data-tooltipster-title="" data-tooltipster-image="" data-tooltipster-position="top" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="tooltipster-black" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="0" data-tooltipster-offsety="0"';
		
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
			if (($iconfont != "Custom") && ($iconfont == $font) && ($iconfont != "Dashicons")){
				$output = '';
				$output .= '<div id="ts-vcsc-extend-preview-' . $iconfont . '" class="ts-vcsc-extend-preview" data-font="' . $Icon_Font . '">';
					$output .= '<div id="ts-vcsc-extend-preview-list-' . $Icon_Font . '" class="ts-vcsc-extend-preview-list" data-font="' . $Icon_Font . '">';
						$icon_counter = 0;
						foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont . ''} as $group => $icons) {
							if (!is_array($icons) || !is_array(current($icons))) {
								$class_key = key($icons);
								$output .= '<div class="ts-vcsc-icon-preview ts-has-tooltipster-tooltip" style="position: relative; display: inline-block;" data-tooltipster-text="' . esc_attr($class_key) . '" ' . $tooltip_settings . ' data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($font) . '" data-count="' . $icon_counter . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i class="ts-font-icon ts-font-icon ' . esc_attr($class_key) . ' ' . $icon_animation . '" style="' . $icon_size . $icon_color . $icon_background . ' "></i></span></div>';
								$icon_counter = $icon_counter + 1;
							} else {
								foreach ($icons as $key => $label) {
									$class_key = key($label);
									$output .= '<div class="ts-vcsc-icon-preview ts-has-tooltipster-tooltip" style="position: relative; display: inline-block;" data-tooltipster-text="' . esc_attr($class_key) . '" ' . $tooltip_settings . ' data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($font) . '" data-count="' . $icon_counter . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i class="ts-font-icon ts-font-icon ' . esc_attr($class_key) . ' ' . $icon_animation . '" style="' . $icon_size . $icon_color . $icon_background . ' "></i></span></div>';
									$icon_counter = $icon_counter + 1;
								}
							}							
						}
					$output .= '</div>';
				$output .= '</div>';
			} else if (($iconfont != "Custom") && ($iconfont == $font) && ($iconfont == "Dashicons")){
				$output = '';
				$output .= '<div id="ts-vcsc-extend-preview-' . $iconfont . '" class="ts-vcsc-extend-preview" data-font="' . $Icon_Font . '">';
					$output .= '<div id="ts-vcsc-extend-preview-list-' . $Icon_Font . '" class="ts-vcsc-extend-preview-list" data-font="' . $Icon_Font . '">';
						$icon_counter = 0;
						foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont . ''} as $group => $icons) {
							if (!is_array($icons) || !is_array(current($icons))) {
								$class_key = key($icons);
								$output .= '<div class="ts-vcsc-icon-preview ts-has-tooltipster-tooltip" style="position: relative; display: inline-block;" data-tooltipster-text="' . esc_attr($class_key) . '" ' . $tooltip_settings . ' data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($font) . '" data-count="' . $icon_counter . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i class="ts-font-icon ts-font-icon ' . esc_attr($class_key) . ' ' . $icon_animation . '" style="' . $icon_size . $icon_color . $icon_background . ' "></i></span></div>';
								$icon_counter = $icon_counter + 1;
							} else {
								foreach ($icons as $key => $label) {
									$class_key = key($label);
									$output .= '<div class="ts-vcsc-icon-preview ts-has-tooltipster-tooltip" style="position: relative; display: inline-block;" data-tooltipster-text="' . esc_attr($class_key) . '" ' . $tooltip_settings . ' data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($font) . '" data-count="' . $icon_counter . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i class="ts-font-icon ts-font-icon ' . esc_attr($class_key) . ' ' . $icon_animation . '" style="' . $icon_size . $icon_color . $icon_background . ' "></i></span></div>';
									$icon_counter = $icon_counter + 1;
								}
							}							
						}
					$output .= '</div>';
				$output .= '</div>';
			}
		}

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>