<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_NoUiSlider')) {
        class TS_Parameter_NoUiSlider {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('nouislider', array(&$this, 'nouislider_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('nouislider', array(&$this, 'nouislider_settings_field'));
				}
            }        
            function nouislider_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     		= vc_generate_dependencies_attributes($settings);
                $param_name     		= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           		= isset($settings['type']) ? $settings['type'] : '';
                $min            		= isset($settings['min']) ? $settings['min'] : '';
                $max            		= isset($settings['max']) ? $settings['max'] : '';
                $step           		= isset($settings['step']) ? $settings['step'] : '';
                $unit           		= isset($settings['unit']) ? $settings['unit'] : '';
                $decimals				= isset($settings['decimals']) ? $settings['decimals'] : 0;
				// Single Input Only
				$pips					= isset($settings['pips']) ? $settings['pips'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterNoUiSlider['pips'];
				$tooltip				= isset($settings['tooltip']) ? $settings['tooltip'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterNoUiSlider['tooltip'];
				// Range Additions
				$range					= isset($settings['range']) ? $settings['range'] : "false";
				$start					= isset($settings['start']) ? $settings['start'] : $min;
				$end					= isset($settings['end']) ? $settings['end'] : $max;				
				// Other Settings
			    $suffix         		= isset($settings['suffix']) ? $settings['suffix'] : '';
                $class          		= isset($settings['class']) ? $settings['class'] : '';				
                $url            		= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         		= '';
				$randomizer             = mt_rand(999999, 9999999);
				$containerclass			= '';
				if ($range == "false") {
					if ($tooltip == "true") {
						$containerclass	.= " ts-nouislider-input-slider-tooltip";
					}
					if ($pips == "true") {
						$containerclass	.= " ts-nouislider-input-slider-pips";
					}
					if (($tooltip == "false") && ($pips == "false")) {
						$containerclass	= "ts-nouislider-input-slider-basic";
					}
					$output .= '<div id="ts-nouislider-input-slider-wrapper' . $randomizer . '" class="ts-nouislider-input-slider-wrapper clearFixMe ts-settings-parameter-gradient-grey ' . $containerclass . '">';
						$output .= '<div id="ts-nouislider-input-slider-' . $randomizer . '" class="ts-nouislider-input-slider">';
							$output .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px; background: #f5f5f5; color: #666666;" name="' . $param_name . '"  class="ts-nouislider-serial nouislider-input-selector nouislider-input-composer wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="text" min="' . $min . '" max="' . $max . '" step="' . $step . '" value="' . $value . '"/>';
							$output .= '<span style="float: left; margin-right: 20px; margin-top: 10px; min-width: 10px;" class="unit">' . $unit . '</span>';
							$output .= '<span class="ts-nouislider-input-down dashicons-arrow-left-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0;"></span>';
							$output .= '<span class="ts-nouislider-input-up dashicons-arrow-right-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0 20px 0 0;"></span>';
							$output .= '<div id="ts-nouislider-input-element-' . $randomizer . '" class="ts-nouislider-input ts-nouislider-input-element" data-pips="' . $pips . '" data-tooltip="' . $tooltip . '" data-value="' . $value . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="' . $decimals . '" data-step="' . $step . '" data-unit="' . $unit . '" style="width: 320px; float: left; margin-top: 10px;"></div>';
						$output .= '</div>';
					$output .= '</div>';
				} else if ($range == "true") {
					$output .= '<div id="ts-nouislider-range-slider-' . $randomizer . '" class="ts-nouislider-range-slider clearFixMe ts-settings-parameter-gradient-grey">';
						$output .= '<div id="ts-nouislider-range-output-' . $randomizer . '" class="ts-nouislider-range-output" data-controls="ts-nouislider-range-controls-' . $randomizer . '">';
							$output .= '<div id="ts-nouislider-range-human-' . $randomizer . '" class="ts-nouislider-range-human">';	
								$output .= '<span class="ts-nouislider-range-start"></span> - <span class="ts-nouislider-range-end"></span>';							
							$output .= '</div>';
						$output .= '</div>';
						$output .= '<div id="ts-nouislider-range-controls-' . $randomizer . '" class="ts-nouislider-range-controls" data-output="ts-nouislider-range-output-' . $randomizer . '">';
							$output .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="' . $param_name . '"  class="ts-nouislider-serial nouislider-range-selector nouislider-input-composer wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '" style="display: none;"/>';
							$output .= '<span class="ts-nouislider-range-lower-down dashicons-arrow-left-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0;"></span>';
							$output .= '<span class="ts-nouislider-range-lower-up dashicons-arrow-right-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0 20px 0 0;"></span>';						
							$output .= '<div id="ts-nouislider-range-element-' . $randomizer . '" class="ts-nouislider-range ts-nouislider-range-element" data-value="' . $value . '" data-start="' . $start . '" data-end="' . $end . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="' . $decimals . '" data-step="' . $step . '" style="width: 400px; float: left; margin: 10px auto;"></div>';
							$output .= '<span class="ts-nouislider-range-upper-down dashicons-arrow-left-alt2" style="position: relative; float: none; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0 0 0 20px;"></span>';
							$output .= '<span class="ts-nouislider-range-upper-up dashicons-arrow-right-alt2" style="position: relative; float: none; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0;"></span>';
						$output .= '</div>';
					$output .= '</div>';
				}
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_NoUiSlider')) {
        $TS_Parameter_NoUiSlider = new TS_Parameter_NoUiSlider();
    }
?>