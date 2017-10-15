<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_UserRoles')) {
        class TS_Parameter_UserRoles {
            function __construct() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('wpuserroles',       array(&$this, 'wpuserroles_settings_field'));
                } else if (function_exists('add_shortcode_param')) {                    
                    add_shortcode_param('wpuserroles',          array(&$this, 'wpuserroles_settings_field'));
                }
            }        
            function wpuserroles_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                global $wp_roles;                
                if (!isset($wp_roles)) {
                    $wp_roles       = new WP_Roles();
                }
                $dependency     	= vc_generate_dependencies_attributes($settings);
                $param_name     	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           	= isset($settings['type']) ? $settings['type'] : '';
                $url            	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         	= '';
                $randomizer			= rand(100000, 999999);
                $value_arr 			= $value;
                if (!is_array($value_arr)) {
                    $value_arr      = array_map('trim', explode(',', $value_arr));
                }
                $output .= '<div id="ts-userroles-selector-holder-' . $randomizer . '" class="ts-userroles-selector-holder ts-settings-parameter-gradient-grey">';
                    $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="display: none;">' . $value . '</textarea >';
                    $output .= '<select multiple="multiple" name="' . $param_name . '_multiple" id="' . $param_name . '_multiple" data-holder="' . $param_name . '" class="ts-custompost-categories-selector wpb-input wpb-select dropdown ' . $param_name . '_multiple" value=" ' . $value . '" style="margin-bottom: 20px;" data-selectable="' . __( "Available User Roles:", "ts_visual_composer_extend" ) . '" data-selection="' . __( "Allowed User Roles:", "ts_visual_composer_extend" ) . '">';
                        foreach ($wp_roles->roles as $key => $value) {
                            $output .= '<option id="" class="" name="" data-id="" data-author="" value="' . $key . '" ' . selected(in_array($key, $value_arr), true, false) . '>' . $value['name'] . '</option>';
                        }
                    $output .= '</select>';
                    $output .= '<span class="ts-userroles-selector-message">' . __( "Click on a name in 'Available User Roles' to add role to element; click on a name in 'Allowed User Roles' to remove from element.", "ts_visual_composer_extend" ) . '</span>';
                $output .= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_UserRoles')) {
        $TS_Parameter_UserRoles = new TS_Parameter_UserRoles();
    }
?>