<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_MarkerPanel')) {
        class TS_Parameter_MarkerPanel {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('mapmarker', array(&$this, 'mapmarker_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('mapmarker', array(&$this, 'mapmarker_settings_field'));
				}
            }        
            function mapmarker_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $pattern_select	= isset($settings['value']) ? $settings['value'] : '';
                $encoding       = isset($settings['encoding']) ? $settings['encoding'] : '';
				$height		    = isset($settings['height']) ? $settings['height'] : 250;
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $dir 			= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginDir;
				$randomizer		= mt_rand(999999, 9999999);
                $output         = '';
				$counter		= 0;
				$output .= '<div id="ts-googlemap-markers-wrapper-' . $randomizer . '" class="ts-googlemap-markers-wrapper clearFixMe ts-settings-parameter-gradient-grey">';
					$output .= '<div id="ts-googlemap-markers-controls-' . $randomizer . '" class="ts-googlemap-markers-controls">';
						$output .= '<div id="ts-googlemap-markers-result-' . $randomizer . '" class="ts-googlemap-markers-result" data-path="' . TS_VCSC_GetResourceURL('images/marker/') . '">';
							$output .= '<img src="' . TS_VCSC_GetResourceURL('images/marker/') . $value . '">';
						$output .= '</div>';
						$output .= '<div id="ts-googlemap-markers-search-' . $randomizer . '" class="ts-googlemap-markers-search">';
							$output .= '<span class="ts-googlemap-markers-search-message-' . $randomizer . '">' . __( "Search for Marker:", "ts_visual_composer_extend" ) . '</span>';
							$output .= '<input name="ts-googlemap-markers-search-input" id="ts-googlemap-markers-search-input-' . $randomizer . '" class="ts-googlemap-markers-search-input" type="text" placeholder="Search ..." />';
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div id="ts-googlemap-markers-selector-' . $randomizer . '" class="ts-visual-selector ts-googlemap-markers-selector" style="max-height: ' . $height . 'px;">';						
						$markerpath 	= $dir . 'images/marker/';
						$images 		= glob($markerpath . "*.png");
						foreach($images as $img)     {
							$markername	= basename($img);
							$counter++;
							if (($value == '') && ($counter == 1)) {
								$output .= '<a class="TS_VCSC_Marker_Link current" href="#" title="' . __( "Marker Name:", "ts_visual_composer_extend" ) . ': ' . $markername . '" rel="' . $markername . '"><img src="' . TS_VCSC_GetResourceURL('images/marker/') . $markername . '" style="height: 37px; width: 32px;"><div class="selector-tick"></div></a>';
							} else if ($value == $markername) {
								$output .= '<a class="TS_VCSC_Marker_Link current" href="#" title="' . __( "Marker Name:", "ts_visual_composer_extend" ) . ': ' . $markername . '" rel="' . $markername . '"><img src="' . TS_VCSC_GetResourceURL('images/marker/') . $markername . '" style="height: 37px; width: 32px;"><div class="selector-tick"></div></a>';
							} else {
								$output .= '<a class="TS_VCSC_Marker_Link" href="#" title="' . __( "Marker Name:", "ts_visual_composer_extend" ) . ': ' . $markername . '" rel="' . $markername . '"><img src="' . TS_VCSC_GetResourceURL('images/marker/') . $markername . '" style="height: 37px; width: 32px;"></a>';
							}						
						}					
					$output .= '</div>';
					$output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-googlemap-markers-final wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '" style="display: none;"/>';
				$output .= '</div>'; 
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_MarkerPanel')) {
        $TS_Parameter_MarkerPanel = new TS_Parameter_MarkerPanel();
    }
?>