<?php
	add_shortcode('TS-VCSC-Image-Adipoli', 'TS_VCSC_Image_Adipoli_Function');
	function TS_VCSC_Image_Adipoli_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		extract( shortcode_atts( array(
			'image'						=> '',
			'attribute_alt'				=> 'false',
			'attribute_alt_value'		=> '',
			'image_responsive'			=> 'true',
			"image_width_percent"		=> 100,
			'image_width'				=> 300,
			'image_height'				=> 200,
			'image_height_r'			=> 'height: 100%;',
			'image_position'			=> 'ts-imagefloat-center',
			'adipoli_start'           	=> 'grayscale',
			'adipoli_hover'           	=> 'normal',
			'adipoli_text'           	=> '',
			'adipoli_handle_show'		=> 'true',
			'adipoli_handle_color'		=> '#0094FF',
			'link_url'					=> '',
			'link_target'				=> '_parent',
			// Tooltip Settings
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> 'ts-simptip-style-black',
			'tooltip_animation'			=> 'swing',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			// Other Settings
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		wp_enqueue_script('ts-extend-adipoli');
		if (($tooltip_css == "true") && ($tooltip_content != '')) {
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');
		}
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		$adipoli_margin 				= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$output 						= "";
		
		if (!empty($el_id)) {
			$adipoli_image_id			= $el_id;
		} else {
			$adipoli_image_id			= 'ts-vcsc-image-adipoli-' . mt_rand(999999, 9999999);
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_JetpackPhoton_Active == "true") {
			add_filter('jetpack_photon_skip_image', '__return_true');
		}
		
		if ($image_responsive == "true") {
			$adipoli_image				= wp_get_attachment_image_src($image, 'full');
		} else {
			$adipoli_image				= wp_get_attachment_image_src($image, array($image_width, $image_height));
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_JetpackPhoton_Active == "true") {
			$photon_active				= "true";
			if (strpos($adipoli_image[0], 'wp.com') !== false) {
				$photon_remove 			= parse_url($adipoli_image[0], PHP_URL_PATH);
				$photon_remove 			= substr($photon_remove, 1);
				if (is_ssl()) {
					$adipoli_path 		= 'https://' . $photon_remove;
				} else {
					$adipoli_path 		= 'http://' . $photon_remove;
				}
				$photon_path 			= parse_url($adipoli_image[0], PHP_URL_QUERY);
				$photon_params 			= parse_str($photon_path, $params);			
				if (strpos($adipoli_image[0], '?resize=') !== false) {		
					$photon_size		= $params['resize'];
				} else if (strpos($adipoli_image[0], '?fit=') !== false) {
					$photon_size		= $params['fit'];
				} else {
					$photon_size		= '';
				}
				$photon_size 			= str_replace("%2C", ",", $photon_size);
				$photon_size			= explode(",", $photon_size);
				$data_width 			= $photon_size[0];
				$data_height 			= $photon_size[1];
			} else {
				$adipoli_path			= $adipoli_image[0];
				$data_width 			= $adipoli_image[1];
				$data_height 			= $adipoli_image[2];
			}
		} else {
			$photon_active				= "false";
			$adipoli_path				= $adipoli_image[0];
			$data_width 				= $adipoli_image[1];
			$data_height 				= $adipoli_image[2];
		}

		if (intval($data_width) < intval($image_height)) {
			$height_adjust				= intval($image_height) - intval($data_width);
			$image_height				= intval($image_height) - intval($height_adjust);
		} else {
			$image_height				= $image_height;
		}
		
		// Handle Padding
		if ($adipoli_handle_show == "true") {
			$adipoli_padding			= "padding-bottom: 16px;";
		} else {
			$adipoli_padding			= "";
		}
		
		// Tooltip
		$tooltip_position				= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style					= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		if (strlen($tooltip_content) != 0) {
			$adipoli_tooltipclasses		= "ts-has-tooltipster-tooltip";
			$adipoli_tooltipcontent		= 'data-tooltipster-title="" data-tooltipster-text="' . $tooltip_content . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
		} else {
			$adipoli_tooltipclasses		= "";
			$adipoli_tooltipcontent		= "";
		}
		
		// Image Size
		if ($image_responsive == "true") {
			$adipoli_dimensions			= "width: " . $image_width_percent . "%; " . $image_height_r;
			$adipoli_frame_size			= "width: 100%;";
			$adipoli_wrapper_size		= "width: 100%; height: auto;";
			$adipoli_tag				= "responsive";
			$adipoli_height				= "auto";
			$adipoli_width				= $image_width_percent;
		} else {
			$adipoli_dimensions			= "width: " . $image_width . "px; height: " . $image_height . "px;";
			$adipoli_frame_size			= "width: " . $image_width . "px;";
			$adipoli_wrapper_size		= "width: " . $image_width . "px; height: auto;";
			$adipoli_tag				= "fixed";
			$adipoli_height				= $image_height;
			$adipoli_width				= $image_width;
		}
		
		$switch_handle_adjust			= '';
		
		$image_extension 				= pathinfo($adipoli_image[0], PATHINFO_EXTENSION);
		
		if ($attribute_alt == "true") {
			$alt_attribute				= $attribute_alt_value;
		} else {
			$alt_attribute				= get_post_meta($image, '_wp_attachment_image_alt', true);
			if ($alt_attribute == "") {
				$alt_attribute			= basename($adipoli_image[0], "." . $image_extension);
			}			
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Image-Adipoli', $atts);
		} else {
			$css_class	= '';
		}
		
		if (!empty($link_url)) {
			$output .= '<a href="' . $link_url . '" target="' . $link_target . '">';
		}
			$output .= '<div id="' . $adipoli_image_id . '" class="ts-image-adipoli-frame ' . $image_position . ' ' . $el_class . ' ' . $css_class . ' ' . $adipoli_tooltipclasses . '" ' . $adipoli_tooltipcontent . ' style="' . $adipoli_frame_size . ' ' . $adipoli_margin . '">';
				$output .= '<div id="' . $adipoli_image_id . '-counter" class="ts-fluid-wrapper " style="' . $adipoli_wrapper_size . '">';
					if ($adipoli_handle_show == "true") {
						$output .= '<div class="ts-image-adipoli-padding" style="' . $adipoli_padding . '">';
					}
						$output .= '<img class="ts-imageadipoli" data-handle="' . $adipoli_handle_show . '" data-no-lazy="1" data-frame="' . $adipoli_image_id . '" data-responsive="' . $image_responsive . '" data-width="' . $adipoli_width . '" data-height="' . $adipoli_height . '" data-tag="' . $adipoli_tag . '" data-start="' . $adipoli_start . '" data-hover="' . $adipoli_hover . '" data-text="' . $adipoli_text . '" src="' . $adipoli_path . '" alt="' . $alt_attribute . '" style="' . $adipoli_dimensions . '"/>';
						if ($adipoli_handle_show == "true") {
							if (!empty($link_url)) {
								$output .= '<div class="ts-image-adipoli-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_adipoli" style="background-color: ' . $adipoli_handle_color . '"><i class="handle-click"></i></span></div>';
							} else {
								$output .= '<div class="ts-image-adipoli-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_adipoli" style="background-color: ' . $adipoli_handle_color . '"><i class="handle-hover"></i></span></div>';
							}
						}
					if ($adipoli_handle_show == "true") {
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>'; 
		if (!empty($link_url)) {
			$output .= '</a>';
		}

		echo $output;

		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>