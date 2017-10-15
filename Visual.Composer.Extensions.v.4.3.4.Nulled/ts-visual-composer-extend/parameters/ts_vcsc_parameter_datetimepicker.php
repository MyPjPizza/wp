<?php
    /*
		No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_DateTimePicker')) {
        class TS_Parameter_DateTimePicker {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('datetime_picker', array(&$this, 'datetimepicker_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('datetime_picker', array(&$this, 'datetimepicker_setting_field'));
				}
            }
			function datetimepicker_minuteinterval($minute) {
				$minutes_full		= array('0', 0, '00');
				$minutes_half		= array('30', 30);
				$minutes_quarter	= array('15', 15, '45', 45);
				$minutes_dozens		= array('5', 5, '10', 10, '20', 20, '25', 25, '35', 35, '40', 40, '50', 50, '55', 55);
				$minutes_intval		= 60;
				if ($minute == '') {
					$minutes_intval	= 60;
				} else if ((in_array($minute, $minutes_full)) && (!in_array($minute, $minutes_half))) {
					$minutes_intval	= 60;
				} else if (in_array($minute, $minutes_half)) {
					$minutes_intval	= 30;
				} else if (in_array($minute, $minutes_quarter)) {
					$minutes_intval	= 15;
				} else if (in_array($minute, $minutes_dozens)) {
					$minutes_intval	= 5;
				} else {
					$minutes_intval	= 1;
				}
				return $minutes_intval;
			}
            function datetimepicker_setting_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     	= vc_generate_dependencies_attributes($settings);
                $param_name     	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           	= isset($settings['type']) ? $settings['type'] : '';
                $radios         	= isset($settings['options']) ? $settings['options'] : '';
                $period         	= isset($settings['period']) ? $settings['period'] : '';
				$range				= isset($settings['range']) ? $settings['range'] : 'false';
				$text_start			= isset($settings['text_start']) ? $settings['text_start'] : __('Start:', 'ts_visual_composer_extend');
				$text_end			= isset($settings['text_end']) ? $settings['text_end'] : __('End:', 'ts_visual_composer_extend');
				$spacing			= isset($settings['spacing']) ? $settings['spacing'] : 0;
                $url            	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
				$randomizer			= rand(100000, 999999);
				// Other Variables
				$minutes_full		= array('0', 0, '00');
				$minutes_half		= array('30', 30);
				$minutes_quarter	= array('15', 15, '45', 45);
				$minutes_dozens		= array('5', 5, '10', 10, '20', 20, '25', 25, '35', 35, '40', 40, '50', 50, '55', 55);
				$minutes_start		= 60;
				$minutes_end		= 60;
				$minutes_interval	= 60;
                $output 			= '';
				if ($range == "false") {
					if ($period == "datetime") {
						$time_start 		= strtotime($value);
						$time_start			= intval(date('i', $time_start));
						// Check Start Value
						if ($value == "") {
							$minutes_start	= 60;
						} else {
							$minutes_start	= $this->datetimepicker_minuteinterval($time_start);
						}
						$minutes_interval	= $minutes_start;
						$output .= '<div id="ts-datetime-picker-element-' . $randomizer . '" class="ts-datetime-picker-element clearFixMe ts-xdsoft-datetimepicker-wrapper ts-settings-parameter-gradient-grey">';
							$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-datetimepicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
							$output .= '<label class="ts-datetimepicker-label" for="ts-datetimepicker-minutes-' . $randomizer . '">' . __( "Select the interval for the time selector:", "ts_visual_composer_extend" ) . '</label>';
							$output .= '<select id="ts-datetimepicker-minutes-' . $randomizer . '" class="ts-datetimepicker-minutes" data-identifier="' . $randomizer . '">';
								$output .= '<option value="60" ' . selected('60', 	$minutes_interval) . '>' . __('60 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="30" ' . selected('30', 	$minutes_interval) . '>' . __('30 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="15" ' . selected('15', 	$minutes_interval) . '>' . __('15 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="10" ' . selected('10', 	$minutes_interval) . '>' . __('10 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="5" ' . selected('5', 	$minutes_interval) . '>' . __('5 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="1" ' . selected('1', 	$minutes_interval) . '>' . __('1 Minute', 'ts_visual_composer_extend') . '</option>';
							$output .= '</select>';
							$output .= '<input class="ts-datetimepicker ts-datetimepicker-single" type="text" placeholder="" value="' . $value . '"/>';
						$output .= '</div>';
					} else if ($period == "date") {
						$output .= '<div id="ts-dateonly-picker-element-' . $randomizer . '" class="ts-dateonly-picker-element clearFixMe ts-xdsoft-datetimepicker-wrapper ts-settings-parameter-gradient-grey">';
							$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-datepicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
							$output .= '<input class="ts-datepicker ts-datepicker-single" type="text" placeholder="" value="' . $value . '"/>';
						$output .= '</div>';
					} else if ($period == "time") {
						// Time Picker via Calendar
						/*
						$time_start 		= strtotime($value);
						$time_start			= intval(date('i', $time_start));
						if ($value == "") {
							$minutes_start	= 60;
						} else {
							$minutes_start	= $this->datetimepicker_minuteinterval($time_start);
						}
						$minutes_interval	= $minutes_start;
						$output .= '<div id="ts-timeonly-picker-element-' . $randomizer . '" class="ts-timeonly-picker-element clearFixMe ts-xdsoft-datetimepicker-wrapper ts-settings-parameter-gradient-grey">';						
							$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-timeonlypicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
							$output .= '<label class="ts-timeonlypicker-label" for="ts-timeonlypicker-minutes-' . $randomizer . '">' . __( "Select the interval for the time selector:", "ts_visual_composer_extend" ) . '</label>';
							$output .= '<select id="ts-timeonlypicker-minutes-' . $randomizer . '" class="ts-timeonlypicker-minutes" data-identifier="' . $randomizer . '">';
								$output .= '<option value="60" ' . selected('60', 	$minutes_interval) . '>' . __('60 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="30" ' . selected('30', 	$minutes_interval) . '>' . __('30 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="15" ' . selected('15', 	$minutes_interval) . '>' . __('15 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="10" ' . selected('10', 	$minutes_interval) . '>' . __('10 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="5" ' . selected('5', 	$minutes_interval) . '>' . __('5 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="1" ' . selected('1', 	$minutes_interval) . '>' . __('1 Minute', 'ts_visual_composer_extend') . '</option>';
							$output .= '</select>';
							$output .= '<input class="ts-timeonlypicker ts-timeonlypicker-single" type="text" placeholder="" value="' . $value . '"/>';
						$output .= '</div>';
						*/
						// Time Picker via Slider
						if ($value != '') {
							$convert 		= date_parse($value);
							$minutes		= $convert['hour'] * 60 + $convert['minute'];
						} else {
							$minutes		= 1;
						}
						$output .= '<div id="ts-nouislider-time-slider-' . $randomizer . '" class="ts-nouislider-time-slider clearFixMe ts-settings-parameter-gradient-grey">';
							$output .= '<div id="ts-nouislider-time-output-' . $randomizer . '" class="ts-nouislider-time-output" data-controls="ts-nouislider-time-controls-' . $randomizer . '">';
								$output .= '<div id="ts-nouislider-time-human-' . $randomizer . '" class="ts-nouislider-time-human">';	
									$output .= '<span class="ts-nouislider-time-final">' . $value . '</span>';							
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<div id="ts-nouislider-time-controls-' . $randomizer . '" class="ts-nouislider-time-controls" data-output="ts-nouislider-time-output-' . $randomizer . '">';
								$output .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="' . $param_name . '"  class="ts-nouislider-serial nouislider-time-selector nouislider-input-composer wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '" style="display: none;"/>';
								$output .= '<span class="ts-nouislider-time-faster-down dashicons-controls-back" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0;"></span>';	
								$output .= '<span class="ts-nouislider-time-lower-down dashicons-arrow-left" style="position: relative; float: left; display: inline-block; font-size: 50px; top: 20px; cursor: pointer; margin: 0;"></span>';								
								$output .= '<div id="ts-nouislider-time-element-' . $randomizer . '" class="ts-nouislider-time ts-nouislider-time-element" data-value="' . $minutes . '" data-unit="" data-min="1" data-max="1440" data-decimals="0" data-step="1" style="width: 400px; float: left; margin: 10px auto;"></div>';
								$output .= '<span class="ts-nouislider-time-lower-up dashicons-arrow-right" style="position: relative; float: left; display: inline-block; font-size: 50px; top: 20px; cursor: pointer; margin: 0;"></span>';	
								$output .= '<span class="ts-nouislider-time-faster-up dashicons-controls-forward" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 30px; cursor: pointer; margin: 0;"></span>';
							$output .= '</div>';
						$output .= '</div>';					
					}
				} else {
					$value_array			= explode("|", $value);
					$value_start			= $value_array[0];
					$value_end				= $value_array[1];
					if ($period == "datetime") {
						$time_start 		= strtotime($value_start);
						$time_end 			= strtotime($value_end);
						$time_start			= intval(date('i', $time_start));
						$time_end			= intval(date('i', $time_end));
						// Check Start Value
						if ($value_start == "") {
							$minutes_start	= 60;
						} else {
							$minutes_start	= $this->datetimepicker_minuteinterval($time_start);
						}
						// Check End Value
						if ($value_end == "") {
							$minutes_end	= 60;
						} else {
							$minutes_end	= $this->datetimepicker_minuteinterval($time_end);
						}
						// Determine Final Interval
						if ($minutes_start > $minutes_end) {
							$minutes_interval	= $minutes_end;
						} else {
							$minutes_interval	= $minutes_start;
						}
						// Create Output
						$output .= '<div id="ts-datetime-range-element-' . $randomizer . '" class="ts-datetime-range-element clearFixMe ts-xdsoft-datetimepicker-wrapper ts-settings-parameter-gradient-grey" data-step="' . $minutes_interval . '">';
							$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-datetimerange-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
							$output .= '<div id="ts-datetime-range-human-' . $randomizer . '" class="ts-datetime-range-human">';
								$output .= '<div class="ts-datetimerange-output">';
									$output .= '<span class="ts-datetimerange-output-start">' . ($value_start != "" ? $value_start : "...") . '</span> - <span class="ts-datetimerange-output-end">' . ($value_end != "" ? $value_end : "...") . '</span>';
								$output .= '</div>';
							$output .= '</div>';
							$output .= '<label class="ts-datetimerange-label" for="ts-datetimerange-minutes-' . $randomizer . '">' . __( "Select the intervals for the time selectors:", "ts_visual_composer_extend" ) . '</label>';
							$output .= '<select id="ts-datetimerange-minutes-' . $randomizer . '" class="ts-datetimerange-minutes" data-identifier="' . $randomizer . '">';
								$output .= '<option value="60" ' . selected('60', 	$minutes_interval) . '>' . __('60 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="30" ' . selected('30', 	$minutes_interval) . '>' . __('30 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="15" ' . selected('15', 	$minutes_interval) . '>' . __('15 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="10" ' . selected('10', 	$minutes_interval) . '>' . __('10 Minutes', 'ts_visual_composer_extend') . '</option>';
								$output .= '<option value="5" ' . selected('5', 	$minutes_interval) . '>' . __('5 Minutes', 'ts_visual_composer_extend') . '</option>';
								//$output .= '<option value="1" ' . selected('1', 	$minutes_interval) . '>' . __('1 Minute', 'ts_visual_composer_extend') . '</option>';
							$output .= '</select>';
							$output .= '<div class="ts-datetimerange-picker ts-datetimerange-picker-start">';
								$output .= '<span class="ts-datetimerange-header">' . $text_start . '</span>';
								$output .= '<input id="ts-datetimerange-start-' . $randomizer . '" class="ts-datetimerange-start" data-time="' . date('h:i A', strtotime($value_start)) . '" data-date="' . date('m/d/Y', strtotime($value_start)) . '" type="text" placeholder="" value="' . $value_start . '"/>';
							$output .= '</div>';
							$output .= '<div class="ts-datetimerange-picker ts-datetimerange-picker-end">';
								$output .= '<span class="ts-datetimerange-header">' . $text_end . '</span>';
								$output .= '<input id="ts-datetimerange-end-' . $randomizer . '" class="ts-datetimerange-end" data-time="' . date('h:i A', strtotime($value_end)) . '" data-date="' . date('m/d/Y', strtotime($value_end)) . '" type="text" placeholder="" value="' . $value_end . '"/>';
							$output .= '</div>';
						$output .= '</div>';
					} else if ($period == "date") {
						$output .= '<div id="ts-dateonly-range-element-' . $randomizer . '" class="ts-dateonly-range-element clearFixMe ts-xdsoft-datetimepicker-wrapper ts-settings-parameter-gradient-grey">';
							$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-dateonlyrange-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
							$output .= '<div id="ts-dateonly-range-human-' . $randomizer . '" class="ts-dateonly-range-human">';
								$output .= '<div class="ts-dateonlyrange-output"><span class="ts-dateonlyrange-output-start">' . ($value_start != "" ? $value_start : "...") . '</span> - <span class="ts-dateonlyrange-output-end">' . ($value_end != "" ? $value_end : "...") . '</span></div>';
							$output .= '</div>';
							$output .= '<div class="ts-dateonlyrange-picker-center">';
								$output .= '<div class="ts-dateonlyrange-picker ts-dateonlyrange-picker-start">';
									$output .= '<span class="ts-dateonlyrange-header">' . $text_start . '</span>';
									$output .= '<input class="ts-dateonlyrange-start" type="text" placeholder="" value="' . $value_start . '"/>';
								$output .= '</div>';
								$output .= '<div class="ts-dateonlyrange-picker ts-dateonlyrange-picker-end">';
									$output .= '<span class="ts-dateonlyrange-header">' . $text_end . '</span>';
									$output .= '<input class="ts-dateonlyrange-end" type="text" placeholder="" value="' . $value_end . '"/>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					}
				}
                return $output;
            }  
        }
    }
    if (class_exists('TS_Parameter_DateTimePicker')) {
        $TS_Parameter_DateTimePicker = new TS_Parameter_DateTimePicker();
    }
?>