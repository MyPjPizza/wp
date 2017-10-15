<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    
	// Shortcode to Build Table with CSS3 Animations Preview
	add_shortcode('TS_VCSC_Icon_Animations', 'TS_VCSC_Icon_Font_Animations');
	function TS_VCSC_Icon_Font_Animations ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false") {
			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		}
		
		extract(shortcode_atts(array(
			'font' 						=> 'Awesome',
			'size'           			=> 16,
			
			'color'						=> '#000000',
			'background'				=> '',
	
			'animationtype'				=> 'Default',
		), $atts));
		
		// Load CSS for Selected Font
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
			if (($iconfont != "Custom") && ($iconfont == $font)) {
				wp_enqueue_style('ts-font-' . strtolower($iconfont));
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
	
		// Define Animation Array
		$animationloop 	= array();
		$animationname 	= array();
		$animationgroup = array();
		if (strlen($animationtype) > 0) {
			if ($animationtype == "Hover") {
				foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Animations_Array as $Animation_Class => $animations) {
					if (($Animation_Class) && ($animations['group'] != "Standard Visual Composer")) {
						$animationloop[] 	= "ts-hover-css-" . $animations['class'];
						$animationname[] 	= $Animation_Class;
						$animationgroup[]	= $animations['group'];
					}
				}
			} else if ($animationtype == "Default") {
				foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Animations_Array as $Animation_Class => $animations) {
					if (($Animation_Class) && ($animations['group'] != "Standard Visual Composer")) {
						$animationloop[] 	= "ts-infinite-css-" . $animations['class'];
						$animationname[] 	= $Animation_Class;
						$animationgroup[]	= $animations['group'];
					}
				}
			} else if ($animationtype == "Viewport") {
				foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Animations_Array as $Animation_Class => $animations) {
					if (($Animation_Class) && ($animations['group'] != "Standard Visual Composer")) {
						$animationloop[] 	= "ts-viewport-css-" . $animations['class'];
						$animationname[] 	= $Animation_Class;
						$animationgroup[]	= $animations['group'];
					}
				}
			}
		}
		$animationcount = count($animationloop) - 1;
		
		$output = '';
		$output .= '<div id="ts-vcsc-extend-preview-' . $font . '" class="ts-vcsc-extend-preview" data-font="' . $font . '">';
			$output .= '<div id="ts-vcsc-extend-preview-list-' . $font . '" class="ts-vcsc-extend-preview-list" data-font="' . $font . '">';
				$outputcount = 1;
				$output .= '<table class="ts-vcsc-icon-animations" style="width: 100%;">';
				$output .= '<thead>';
				$output .= '<tr><th>#</th><th>Animation Name</th><th>Default (Class Name)</th><th>Hover (Class Name)</th><th>Viewport (Class Name)</th><th>Animation Effect</th></tr>';
				$output .= '</thead>';
				$output .= '<tbody>';
					$effectgroups	= array();
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
						if (($iconfont != "Custom") && ($iconfont == $font)){
							foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont . ''} as $group => $icons) {
								if (!is_array($icons) || !is_array(current($icons))) {
									$class_key = key($icons);
									if ($outputcount <= $animationcount) {
										if (!in_array($animationgroup[$outputcount], $effectgroups)) {
											array_push($effectgroups, $animationgroup[$outputcount]);
											$output .= '<tr style="background: #ededed;"><td colspan="6" style="font-size: 12px; font-weight: bold; text-align: center;">' . $animationgroup[$outputcount] . '</td></tr>';
										}									
										$output .= '<tr>';
										$output .= '<td>' . $outputcount . '</td>';
										$output .= '<td style="font-size: 14px; font-weight: bold;">' . $animationname[$outputcount] . '</td>';
										if ($animationtype == "Hover") {
											$output .= '<td>' . str_replace("hover", "infinite", $animationloop[$outputcount]) . '</td>';
											$output .= '<td>' . $animationloop[$outputcount] . '</td>';
											$output .= '<td>' . str_replace("hover", "viewport", $animationloop[$outputcount]) . '</td>';
										} else if ($animationtype == "Default") {
											$output .= '<td>' . $animationloop[$outputcount] . '</td>';
											$output .= '<td>' . str_replace("infinite", "hover", $animationloop[$outputcount]) . '</td>';
											$output .= '<td>' . str_replace("infinite", "viewport", $animationloop[$outputcount]) . '</td>';
										} else if ($animationtype == "Viewport") {
											$output .= '<td>' . str_replace("viewport", "infinite", $animationloop[$outputcount]) . '</td>';
											$output .= '<td>' . str_replace("viewport", "hover", $animationloop[$outputcount]) . '</td>';
											$output .= '<td>' . $animationloop[$outputcount] . '</td>';
										}
										if ($animationtype == "Viewport") {
											$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="' . $animationloop[$outputcount] . '" class="ts-font-icon ' . esc_attr($class_key) . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
										} else if ($animationtype == "Default") {
											$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="" class="ts-font-icon ' . esc_attr($class_key) . ' ' . $animationloop[$outputcount] . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
										} else if ($animationtype == "Hover") {
											$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="" class="ts-font-icon ' . esc_attr($class_key) . ' ' . $animationloop[$outputcount] . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
										}
									} else {
										break;
									}
									$outputcount = $outputcount + 1;
								} else {
									foreach ($icons as $key => $label) {
										$class_key = key($label);
										if ($outputcount <= $animationcount) {
											if (!in_array($animationgroup[$outputcount], $effectgroups)) {
												array_push($effectgroups, $animationgroup[$outputcount]);
												$output .= '<tr style="background: #ededed;"><td colspan="6" style="font-size: 12px; font-weight: bold; text-align: center;">' . $animationgroup[$outputcount] . '</td></tr>';
											}									
											$output .= '<tr>';
											$output .= '<td>' . $outputcount . '</td>';
											$output .= '<td style="font-size: 14px; font-weight: bold;">' . $animationname[$outputcount] . '</td>';
											if ($animationtype == "Hover") {
												$output .= '<td>' . str_replace("hover", "infinite", $animationloop[$outputcount]) . '</td>';
												$output .= '<td>' . $animationloop[$outputcount] . '</td>';
												$output .= '<td>' . str_replace("hover", "viewport", $animationloop[$outputcount]) . '</td>';
											} else if ($animationtype == "Default") {
												$output .= '<td>' . $animationloop[$outputcount] . '</td>';
												$output .= '<td>' . str_replace("infinite", "hover", $animationloop[$outputcount]) . '</td>';
												$output .= '<td>' . str_replace("infinite", "viewport", $animationloop[$outputcount]) . '</td>';
											} else if ($animationtype == "Viewport") {
												$output .= '<td>' . str_replace("viewport", "infinite", $animationloop[$outputcount]) . '</td>';
												$output .= '<td>' . str_replace("viewport", "hover", $animationloop[$outputcount]) . '</td>';
												$output .= '<td>' . $animationloop[$outputcount] . '</td>';
											}
											if ($animationtype == "Viewport") {
												$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="' . $animationloop[$outputcount] . '" class="ts-font-icon ' . esc_attr($class_key) . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
											} else if ($animationtype == "Default") {
												$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="" class="ts-font-icon ' . esc_attr($class_key) . ' ' . $animationloop[$outputcount] . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
											} else if ($animationtype == "Hover") {
												$output .= '<td><div class="ts-vcsc-icon-preview" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($font) . '" data-count="' . $outputcount . '" rel="' . esc_attr($class_key) . '"><span class="ts-vcsc-icon-preview-icon"><i data-viewport="" class="ts-font-icon ' . esc_attr($class_key) . ' ' . $animationloop[$outputcount] . '" style="' . $icon_size . $icon_color . $icon_background . ' " title="' . esc_attr($class_key) . '"></i></span></div></td>';
											}
										} else {
											break;
										}
										$outputcount = $outputcount + 1;
									}
								}
							}
						}
					}
				$output .= '</tbody>';
				$output .= '</table>';
			$output .= '</div>';
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>