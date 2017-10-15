<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_CodeEditor')) {
        class TS_Parameter_CodeEditor {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('codeeditor', array(&$this, 'codeeditor_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('codeeditor', array(&$this, 'codeeditor_settings_field'));
				}
            }        
            function codeeditor_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $suffix         = isset($settings['suffix']) ? $settings['suffix'] : '';
                $class          = isset($settings['class']) ? $settings['class'] : '';
                $codetype		= isset($settings['codetype']) ? $settings['codetype'] : 'css';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
				$randomizer		= mt_rand(999999, 9999999);
                $output         = '';
				$output .= '<div id="ts-codeeditor-parameter-container-' . $randomizer . '" class="ts-codeeditor-parameter-container" style="position: relative;">';
					$output .= '<div class="ts-codeeditor-parameter-ace" style="width: 100%; height: 300px; position: absolute; top: 0; right: 0; bottom: 0; left: 0;">' . htmlentities(rawurldecode(base64_decode($value)), ENT_COMPAT, 'UTF-8' ) . '</div>';
					$output .= '<textarea  name="' . $param_name . '" class="ts-codeeditor-parameter-value wpb_vc_param_value wpb-textarea_raw_html ' . $param_name . ' ' . $type . '" rows="16" data-mode="' . $codetype . '" style="display: none;">' . htmlentities(rawurldecode(base64_decode($value)), ENT_COMPAT, 'UTF-8' ) . '</textarea>';
				$output .= '</div>';
				return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_CodeEditor')) {
        $TS_Parameter_CodeEditor = new TS_Parameter_CodeEditor();
    }
?>