<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_ViewportOffset')) {
        class TS_Parameter_ViewportOffset {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('viewport_offset', array(&$this, 'viewportoffset_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('viewport_offset', array(&$this, 'viewportoffset_settings_field'));
				}
            }        
			function viewportoffset_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     	= vc_generate_dependencies_attributes($settings);
                $param_name     	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           	= isset($settings['type']) ? $settings['type'] : '';
				$class				= isset($settings['class']) ? $settings['class'] : '';
				// Other Settings
				$random_id_number	= rand(100000, 999999);
                $url            	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         	= '';				
				if (strpos($value, '%') !== FALSE) {
					$handler		= 'percentage';
					$offset_p		= str_replace("%", "", $value);
					$offset_f		= 250;
				} else if ($value == 'bottom-in-view') {
					$handler		= 'bottom-in-view';
					$offset_p		= 50;
					$offset_f		= 250;
				} else {
					$handler		= 'pixels';
					$offset_p		= 50;
					$offset_f		= $value;
				}
				// Create Output
				$output .= '<div id="ts-viewportoffset-type-container-' . $random_id_number . '" class="ts-viewportoffset-type-container clearFixMe ts-settings-parameter-gradient-grey" data-identifier="' . $random_id_number . '">';
					$output .= '<div id="ts-viewportoffset-type-holder-' . $random_id_number . '" class="ts-viewportoffset-type-holder">';
						$output .= '<div id="ts-viewportoffset-type-label-' . $random_id_number . '" class="wpb_element_label" style="padding-top: 10px; clear: both; font-weight: normal; font-style: italic;">' . __("Select Offset Type", "ts_visual_composer_extend") . '</div>';
						$output .= '<select id="ts-viewportoffset-type-selector-' . $random_id_number . '" class="ts-viewportoffset-type-selector" data-identifier="' . $random_id_number . '" style="">						
							<option value="percent" data-value="percentage" ' . ($handler == 'percentage' ? 'selected' : '') . '>' . __('Offset In Percent', 'ts_visual_composer_extend') . '</option>
							<option value="pixels" data-value="pixels" ' . ($handler == 'pixels' ? 'selected' : '') . '>' . __('Offset In Pixels', 'ts_visual_composer_extend') . '</option>
							<option value="bottom-in-view" data-value="bottom-in-view" ' . ($handler == 'bottom-in-view' ? 'selected' : '') . '>' . __('Bottom In View Offset', 'ts_visual_composer_extend') . '</option>
						</select>';
					$output .= '</div>';
					// Percentage Offset
					$output .= '<div id="ts-viewportoffset-percentage-nouislider-' . $random_id_number . '" class="ts-viewportoffset-percentage-nouislider-input-slider" style="display: ' . ($handler == 'percentage' ? 'block' : 'none') . ';">';
						$output .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px; background: #f5f5f5; color: #666666;" class="ts-viewportoffset-nouislider-serial nouislider-input-selector nouislider-input-composer ts-viewportoffset-percentage-nouislider-input" type="text" min="1" max="100" step="1" value="' . $offset_p . '"/>';
						$output .= '<span style="float: left; margin-right: 20px; margin-top: 10px; min-width: 10px;" class="unit">%</span>';
						$output .= '<span class="ts-viewportoffset-nouislider-input-down dashicons-arrow-left-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0;"></span>';
						$output .= '<span class="ts-viewportoffset-nouislider-input-up dashicons-arrow-right-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0 20px 0 0;"></span>';
						$output .= '<div id="ts-viewportoffset-nouislider-input-element-percentage-' . $random_id_number . '" class="ts-viewportoffset-nouislider-input-percentage ts-viewportoffset-nouislider-input-element" data-class="responsive" data-value="' . $offset_p . '" data-unit="%" data-extract="false" data-min="-100" data-max="100" data-decimals="0" data-step="1" style="width: 320px; float: left; margin-top: 10px;"></div>';
					$output .= '</div>';
					// Pixels Offset
					$output .= '<div id="ts-viewportoffset-pixels-nouislider-' . $random_id_number . '" class="ts-viewportoffset-pixels-nouislider-input-slider" style="display: ' . ($handler == 'pixels' ? 'block' : 'none') . ';">';
						$output .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px; background: #f5f5f5; color: #666666;" class="ts-viewportoffset-nouislider-serial nouislider-input-selector nouislider-input-composer ts-viewportoffset-pixels-nouislider-input" type="text" min="1" max="2048" step="1" value="' . $offset_f . '"/>';
						$output .= '<span style="float: left; margin-right: 20px; margin-top: 10px; min-width: 10px;" class="unit">px</span>';
						$output .= '<span class="ts-viewportoffset-nouislider-input-down dashicons-arrow-left-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0;"></span>';
						$output .= '<span class="ts-viewportoffset-nouislider-input-up dashicons-arrow-right-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0 20px 0 0;"></span>';
						$output .= '<div id="ts-viewportoffset-nouislider-input-element-pixels-' . $random_id_number . '-2" class="ts-viewportoffset-nouislider-input-pixels ts-viewportoffset-nouislider-input-element" data-class="fixed" data-value="' . $offset_f . '" data-unit="%" data-extract="false" data-min="-500" data-max="500" data-decimals="0" data-step="1" style="width: 320px; float: left; margin-top: 10px;"></div>';
					$output .= '</div>';				
					// Hidden Input with Final Value
					$output .= '<input id="ts-viewportoffset-final-value-' . $random_id_number . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ts-viewportoffset-final-value" name="' . $param_name . '"  type="hidden" style="display: none;"  value="' . $value . '" ' . $dependency . '/>';
				$output .= '</div>';
				return $output;
			}
        }
    }
    if (class_exists('TS_Parameter_ViewportOffset')) {
        $TS_Parameter_ViewportOffset = new TS_Parameter_ViewportOffset();
    }
?>