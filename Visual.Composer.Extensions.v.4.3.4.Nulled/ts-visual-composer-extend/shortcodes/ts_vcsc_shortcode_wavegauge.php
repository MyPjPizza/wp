<?php
	add_shortcode('TS_VCSC_Wave_Gauge', 'TS_VCSC_Wave_Gauge_Function');
	function TS_VCSC_Wave_Gauge_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$gage_frontend					= "true";
		} else {
			$gage_frontend					= "false";
		}
	
		extract( shortcode_atts( array(
			// Gauge Values
			'gauge_value'					=> 0,
			'gauge_click'					=> 'false',
			'gauge_second'					=> 0,
			'gauge_min'						=> 0,
			'gauge_max'						=> 100,
			'gauge_countup'					=> 'true',
			'gauge_percent'					=> 'true',
			// Gauge Styling
			'circle_sizemax'				=> 360,
			'circle_position'				=> 'center',
			'circle_color'					=> '#178BCA',
			'circle_thick'					=> 10,
			'circle_gap'					=> 5,
			'circle_text'					=> '#045681',
			'circle_label'					=> 50,
			// Wave styling
			'wave_count'					=> 1,
			'wave_height'					=> 10,
			'wave_color'					=> '#178BCA',
			'wave_text'						=> '#A4DBf8',
			'wave_rise_allow'				=> "true",
			'wave_rise_time'				=> 2000,
			'wave_animate_allow'			=> 'true',
			'wave_animate_time'				=> 10000,
			'wave_offset'					=> 'false',
			// Tooltip Settings
			'tooltip_allow'					=> 'false',
			'tooltip_advanced'				=> '',
			'tooltip_position'				=> 'ts-simptip-position-top',
			'tooltip_style'					=> 'ts-simptip-style-black',
			'tooltip_animation'				=> 'swing',
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,
			// Other Settings
			'viewport_trigger'				=> "true",
			'viewport_offset'				=> 'bottom-in-view',
			'viewport_delay'				=> 0,
			'viewport_mobile'				=> 'false',
			// Other Settings
			'margin_top'                	=> 0,
			'margin_bottom'             	=> 0,
			'el_id' 						=> '',
			'el_class' 						=> '',
			'css'							=> '',
		), $atts ));
		
		$randomizer							= mt_rand(999999, 9999999);
		
		if (!empty($el_id)) {
			$gauge_id						= $el_id;
		} else {
			$gauge_id						= 'ts-liquid-gauge-wrapper-' . $randomizer;
		}
		
		if ($gage_frontend == "false") {
			if ($viewport_trigger == "true") {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
					if (wp_script_is('waypoints', $list = 'registered')) {
						wp_enqueue_script('waypoints');
					} else {
						wp_enqueue_script('ts-extend-waypoints');
					}
				}
			}
			if (($tooltip_allow == "true") && ($tooltip_advanced != '')) {
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');
			}
			wp_enqueue_script('ts-extend-d3v3');
			wp_enqueue_script('ts-extend-wavegauge');
			wp_enqueue_script('ts-visual-composer-extend-front');
		}
		
		$output = $notice = $visible = '';
		
		// Tooltip Settings
		$tooltip_position					= TS_VCSC_TooltipMigratePosition($tooltip_position);
		$tooltip_style						= TS_VCSC_TooltipMigrateStyle($tooltip_style);
		if (($tooltip_allow == "true") && (strlen($tooltip_advanced) != 0)) {
			$Tooltip_Content				= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_advanced) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class					= 'ts-has-tooltipster-tooltip';
		} else {
			$Tooltip_Content				= '';
			$Tooltip_Class					= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Liquid_Gauge', $atts);
		} else {
			$css_class						= '';
		}
		
		$data_gauge							= 'data-gauge-value="' . $gauge_value . '" data-gauge-second="' . $gauge_second . '" data-gauge-click="' . $gauge_click . '" data-gauge-alternate="false" data-gauge-min="' . $gauge_min . '" data-gauge-max="' . $gauge_max . '" data-gauge-countup="' . $gauge_countup . '" data-gauge-percent="' . $gauge_percent . '"';
		$data_circle						= 'data-circle-maxsize="' . $circle_sizemax . '" data-circle-position="' . $circle_position . '" data-circle-color="' . $circle_color . '" data-circle-text="' . $circle_text . '" data-circle-label="' . $circle_label . '" data-circle-thickness="' . $circle_thick . '" data-circle-gap="' . $circle_gap . '"';
		$data_wave							= 'data-wave-count="' . $wave_count . '" data-wave-height="' . $wave_height . '" data-wave-color="' . $wave_color . '" data-wave-text="' . $wave_text . '" data-wave-riseallow="' . $wave_rise_allow . '" data-wave-risetime="' . $wave_rise_time . '" data-wave-animateallow="' . $wave_animate_allow . '" data-wave-animatetime="' . $wave_animate_time . '" data-wave-offset="' . ($wave_offset == "true" ? "1" : "0") . '"';
		$data_viewport						= 'data-viewport-active="' . $viewport_trigger . '" data-viewport-mobile="' . $viewport_mobile . '" data-viewport-offset="' . $viewport_offset . '" data-viewport-delay="' . $viewport_delay . '" data-viewport-triggered="false"';
		
		if ($gage_frontend == "false") {
			$output .= '<div id="' . $gauge_id . '" class="ts-liquid-gauge-wrapper ' . $el_class . ' ' . $Tooltip_Class . '" style="display: block; width: 100%; height: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" ' . $Tooltip_Content . ' data-current="0" data-randomizer="' . $randomizer . '" ' . $data_gauge . ' ' . $data_circle . ' ' . $data_wave . ' ' . $data_viewport . '></div>';
		} else {
			$output .= '<div id="ts-liquid-gauge-editor-' . $randomizer . '" class="ts-liquid-gauge-editor" style="display: block; height: 100%; padding: 10px; margin: 0; border: 1px solid #cccccc;">';
				$output .= '<div style="font-weight: bold; text-align: justify; margin: 0px auto 10px auto;">TS Wave Gauge</div>';
				$output .= '<div style="display: block; font-weight: bold; color: red; text-align: justify;">For performance and compatibility reasons, this element will not render when editing via the frontend editor.</div>';
				$output .= '<div style="font-weight: normal; text-align: justify; margin: 10px auto 0px auto;">Value: ' . $gauge_value . '%</div>';
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>