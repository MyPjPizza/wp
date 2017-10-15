<?php
	if (!class_exists('TS_Parameter_DeviceTypes')) {
		class TS_Parameter_DeviceTypes 	{
			function __construct() {
				if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('devicetype_selectors', array(&$this, 'devicetype_selectors_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
					add_shortcode_param('devicetype_selectors', array(&$this, 'devicetype_selectors_settings_field'));
				}
			}		
			function devicetype_selectors_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
				$dependency                     = vc_generate_dependencies_attributes($settings);
				$unit 							= isset($settings['unit']) ? $settings['unit'] : 'px';
				$devices 						= isset($settings['devices']) ? $settings['devices'] : array();
				$collapsed						= isset($settings['collapsed']) ? $settings['collapsed'] : 'true';
				$pips							= isset($settings['pips']) ? $settings['pips'] : 'true';
                $min            				= isset($settings['min']) ? $settings['min'] : '0';
                $max           	 				= isset($settings['max']) ? $settings['max'] : '2048';
                $step           				= isset($settings['step']) ? $settings['step'] : '1';
                $unit           				= isset($settings['unit']) ? $settings['unit'] : 'px';
                $decimals						= isset($settings['decimals']) ? $settings['decimals'] : 0;				
				// Other Settings
				$random_id_number               = rand(100000, 999999);
				$random_id_container            = 'ts-devicetypes-datastring-' . $random_id_number;
				$random_id_counter				= 0;
				$random_id_slider				= $random_id_number + '-' + $random_id_counter;
				if (($value != '') && (is_numeric($value))) {
					$value 						= "desktop: " . $value . 'px;';
				}
				$output							= '';
				$output  .= '<div id="ts-devicetypes-container-' . $random_id_slider . '" class="ts-devicetypes-container clearFixMe ' . ($collapsed == "true" ? 'ts-devicetypes-container-closed' : 'ts-devicetypes-container-open') . '" data-pips="' . $pips . '">';
					$output .= ' <div class="ts-devicetypes-listing" >';
					foreach ($devices as $device => $defaults) {
						$random_id_counter++;
						$random_id_slider		= $random_id_number . '-' . $random_id_counter;
						switch ($device) {
							case 'Desktop':       
								$class = 'required';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-desktop'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								$output .= "<div id='ts-devicetypes-toggle-" . $random_id_slider . "' class='ts-devicetypes-toggle' data-container='ts-devicetypes-container-" . $random_id_number . "' data-toggle='" . ($collapsed == "true" ? 'collapsed' : 'expanded') . "'>
											<i class='ts-devicetypes-toggle-icon dashicons " . ($collapsed == "true" ? 'dashicons-arrow-down-alt2' : 'dashicons-arrow-up-alt2') . "'></i>
										  </div>";
								$output .= '<div class="ts-devicetypes-subtypes" style="display: ' . ($collapsed == "true" ? 'none' : 'block') . '">';
								break;
							case 'Tablet':        
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-tablet' style='transform: rotate(90deg); -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg);'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
							case 'Tablet Landscape':        
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-tablet' style='transform: rotate(90deg); -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg);'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
							case 'Tablet Portrait':       
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-tablet'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
							case 'Mobile':        
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-smartphone'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
							case 'Mobile Landscape':        
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-smartphone' style='transform: rotate(90deg); -webkit-transform: rotate(90deg); -moz-transform: rotate(90deg);'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
							case 'Mobile Portrait':        
								$class = 'optional';
								$data_id  = strtolower((preg_replace('/\s+/', '_', $device)));
								$dashicon = "<i class='dashicons dashicons-smartphone'></i>";
								$output .= $this->TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $defaults['default'], $defaults['min'], $defaults['max'], $defaults['step'], $unit, $data_id, $random_id_slider);
								break;
						}
					}
				$output .= '</div></div>';
					// Create Hidden Input to store final values
					$output .= '<input id="' . $random_id_container . '" type="hidden" data-unit="' . $unit . '"  name="' . $settings['param_name'] . '" class="wpb_vc_param_value ts-devicetypes-datastring ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" ' . $dependency . ' />';
				$output .= '</div>';			
				return $output;
			}
			// Function to Create Device Type Inputs
			function TS_VCSC_DeviceTypes_Media_Item($class, $dashicon, $device, $default, $min, $max, $step, $unit, $data_id, $identifier) {
				$tooltipVal  = str_replace('_', ' ', $data_id);
				$output  = '<div class="ts-devicetypes-item clearFixMe ' . $class . ' ' . $data_id . ' " style="">';			
					$output .= '<div id="ts-nouislider-input-slider-' . $identifier . '" class="ts-nouislider-input-slider" style="display: inline-block;">';
						$output .= '<div class="ts-devicetypes-icon" style="display: inline-block">';
							$output .= '<div class="ts-devicetypes-tooltip">' . ucwords($tooltipVal) . '</div>';
							$output .= $dashicon;
						$output .= '</div>';
						$output .= '<input id="ts-devicetypes-item-input-' . $identifier . '" class="ts-devicetypes-item-input ts-nouislider-serial nouislider-input-selector nouislider-input-composer" style="width: 100px; display: inline-block; margin-left: 0px; margin-right: 10px;" data-default="' . $default . '" data-unit="' . $unit . '" data-id="' . $data_id . '" type="text" min="' . $min . '" max="' . $max . '" step="' . $step . '" value="' . $default . '"/>';
						$output .= '<span style="float: left; margin-right: 20px; margin-top: 10px; min-width: 10px;" class="unit">' . $unit . '</span>';
						$output .= '<span class="ts-nouislider-input-down dashicons-arrow-left-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0;"></span>';
						$output .= '<span class="ts-nouislider-input-up dashicons-arrow-right-alt2" style="position: relative; float: left; display: inline-block; font-size: 30px; top: 5px; cursor: pointer; margin: 0 20px 0 0;"></span>';
						$output .= '<div id="ts-nouislider-devicetype-element-' . $identifier . '" class="ts-nouislider-input ts-nouislider-devicetype-element" data-type="' . $class . '" data-unit="' . $unit . '" data-value="' . $default . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="0" data-step="' . $step . '" style="width: 250px; display: inline-block; margin-top: 10px; vertical-align: top;"></div>';
					$output .= '</div>';					
				$output .= '</div>';
				return $output;
			}
		}
	}
	if (class_exists('TS_Parameter_DeviceTypes')) {
		$TS_Parameter_DeviceTypes = new TS_Parameter_DeviceTypes();
	}
?>