<?php
	if (!class_exists('TS_Anything_Grid')){
		class TS_Anything_Grid {
			function __construct() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('init',                                  array($this, 'TS_VCSC_Anything_Grid_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('init',                                  array($this, 'TS_VCSC_Anything_Grid_Elements'), 9999999);
					}
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('admin_init',							array($this, 'TS_VCSC_Anything_Grid_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('admin_init',							array($this, 'TS_VCSC_Anything_Grid_Elements'), 9999999);
					}
				}
				if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
					add_shortcode('TS_VCSC_Anything_Grid',       			array($this, 'TS_VCSC_Anything_Grid'));
				}
			}
			
			// Register Element(s) via LeanMap
			function TS_VCSC_Anything_Grid_Lean() {
				vc_lean_map('TS_VCSC_Anything_Grid', 						array($this, 'TS_VCSC_Anything_Grid_Elements'), null);
			}
			
			// Anything Grid
			function TS_VCSC_Anything_Grid ($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
	
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
				
				extract( shortcode_atts( array(			
					'data_grid_type'				=> 'gridalicious',
					'data_grid_width'				=> 350,
					'data_grid_space'				=> 2,
					'data_grid_animate'				=> 'true',
					'data_grid_simple'				=> 'true',
					
					'fullwidth'						=> 'false',
					'breakouts'						=> 6,
					
					'margin_top'                    => 0,
					'margin_bottom'                 => 0,
					'el_id' 						=> '',
					'el_class'                  	=> '',
					'css'							=> '',
				), $atts ));
				
				$grid_random                    	= mt_rand(999999, 9999999);
				
				// Check for Front End Editor
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$grid_class						= 'ts-vcsc-anygrid-edit';
					$grid_message					= '<div class="ts-composer-frontedit-message">' . __( 'The grid is currently viewed in front-end edit mode; grid features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
					$frontend_edit					= 'true';
				} else {
					$grid_class						= 'ts-vcsc-anygrid-parent';
					$grid_message					= '';
					$frontend_edit					= 'false';
				}
				
				if (!empty($el_id)) {
					$any_grid_id			    	= $el_id;
				} else {
					$any_grid_id			    	= 'ts-vcsc-anygrid-' . $grid_random;
				}
				
				$output = '';
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-anygrid ' . $grid_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Anything_Grid', $atts);
				} else {
					$css_class	= 'ts-vcsc-anygrid ' . $grid_class . ' ' . $el_class;
				}			
				
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$output .= '<div id="' . $any_grid_id . '-container" class="ts-vcsc-anygrid-container" style="margin-top: 30px; margin-bottom: ' . $margin_bottom . 'px;">';
						// Front-Edit Message
						if ($frontend_edit == "true") {
							$output .= $grid_message;
						}
						// Add Style Output
						$output .= '<style id="' . $any_grid_id . '-styles" type="text/css">';
							$output .= '#' . $any_grid_id . '.ts-vcsc-anygrid-edit > div {';
								$output .= 'display: inline-block !important;';
								$output .= 'width: ' . $data_grid_width . 'px !important;';
								$output .= 'margin: 0 ' . ($data_grid_space / 2) . ' !important;';
							$output .= '}';
						$output .= '</style>';
						// Add Grid
						$output .= '<div id="' . $any_grid_id . '" class="' . $css_class . ' ts-vcsc-anygrid-edit">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				} else {
					if ($data_grid_type == "gridalicious") {
						wp_enqueue_script('ts-extend-gridalicious');
						$output .= '<div id="' . $any_grid_id . '-container" class="ts-vcsc-anygrid-container ' . ($fullwidth == "true" ? "ts-other-full-frame" : "") . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-inline="' . $frontend_edit . '" data-fullwidth="' . $fullwidth . '" data-break-parents="' . $breakouts . '">';
							// Add Content Holder
							$output .= '<div id="' . $any_grid_id . '-content" class="ts-vcsc-anygrid-content" data-id="' . $grid_random . '" data-holder="' . $any_grid_id . '-holder" style="display: none;">';
								$output .= do_shortcode($content);
							$output .= '</div>';
							// Add Grid Holder
							$output .= '<div id="' . $any_grid_id . '-holder" class="' . $css_class . ' ts-vcsc-anygrid-gridalicious" data-id="' . $grid_random . '" data-content="' . $any_grid_id . '-content" data-animate="' . $data_grid_animate . '" data-simple="' . $data_grid_simple . '" data-width="' . $data_grid_width . '" data-gutter="' . $data_grid_space . '"></div>';
						$output .= '</div>';
					}
				}
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
		
			// Add Anything Grid Elements
			function TS_VCSC_Anything_Grid_Elements() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Anything Grid
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name"                              => __("TS Almost Anything Grid", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_Anything_Grid",
					"class"                             => "",
					"icon"                              => "ts-composer-element-icon-anything-grid",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                       	=> array('except' => implode(",", $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_AnyLayout_Excluded)),
					"description"                       => __("Build a custom grid with almost any content", "ts_visual_composer_extend"),
					"js_view"                           => "VcColumnView",
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"        			=> "",
					"admin_enqueue_css"       			=> "",
					"front_enqueue_js"					=> "",
					"front_enqueue_css"					=> "",	
					"params"							=> array(
						// Slider Settings
						array(
							"type"                      => "seperator",
							"heading"                   => "",
							"param_name"                => "seperator_1",
							"value"						=> "",
							"seperator"					=> "Grid Settings",
							"description"               => __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "messenger",
							"heading"           		=> "",
							"param_name"        		=> "messenger",
							"color"						=> "#c60000",
							"size"						=> "14",
							"value"						=> "",
							"border_top"				=> "false",
							"padding_top"				=> 0,
							"margin-top"				=> 0,
							"message"            		=> __( "Not every element is suitable to be used inside another element, such as this grid, and not every element feature or style will work when used inside another element. Please select the elements you want to add to this grid carefully in order to avoid style or feature conflicts.", "ts_visual_composer_extend" ),
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Minimum Item Width", "ts_visual_composer_extend" ),
							"param_name"                => "data_grid_width",
							"value"                     => "350",
							"min"                       => "150",
							"max"                       => "480",
							"step"                      => "1",
							"unit"                      => 'px',
							"admin_label"				=> true,
							"description"               => __( "Define the minimum width for each item the grid that should attempt to maintain.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Item Spacing", "ts_visual_composer_extend" ),
							"param_name"                => "data_grid_space",
							"value"                     => "2",
							"min"                       => "0",
							"max"                       => "20",
							"step"                      => "1",
							"unit"                      => 'px',
							"admin_label"				=> true,
							"description"               => __( "Define the spacing between each item inside the grid.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Item Animation", "ts_visual_composer_extend" ),
							"param_name"                => "data_grid_animate",
							"value"                     => "true",
							"admin_label"				=> true,
							"description"               => __( "Switch the toggle if you want to apply a fade-in animation to all grid items.", "ts_visual_composer_extend" )
						),						
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Basic Grid Only", "ts_visual_composer_extend" ),
							"param_name"                => "data_grid_simple",
							"value"                     => "true",
							"admin_label"				=> true,
							"description"               => __( "Switch the toggle if instead of a basic grid, you want the grid to attempt to render in a masonry like layout.", "ts_visual_composer_extend" )
						),						
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Full Width Grid", "ts_visual_composer_extend" ),
							"param_name"		    	=> "fullwidth",
							"value"                 	=> "false",
							"admin_label"				=> true,
							"description"		    	=> __( "Switch the toggle if you want to attempt to make the grid full width.", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Full Width Breakouts", "ts_visual_composer_extend" ),
							"param_name"				=> "breakouts",
							"value"						=> "6",
							"min"						=> "0",
							"max"						=> "99",
							"step"						=> "1",
							"unit"						=> '',
							"description"				=> __( "Define the number of parent containers the grid should attempt to break away from.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "fullwidth", 'value' => 'true' ),
						),
						// Other Settings
						array(
							"type"                      => "seperator",
							"heading"                   => "",
							"param_name"                => "seperator_2",
							"value"						=> "",
							"seperator"					=> "Other Settings",
							"description"               => "",
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
							"param_name"                => "margin_top",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Bottom", "ts_visual_composer_extend" ),
							"param_name"                => "margin_bottom",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_id",
							"value"                     => "",
							"description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_class",
							"value"                     => "",
							"description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						// Load Custom CSS/JS File
						array(
							"type"                      => "load_file",
							"heading"                   => "",
							"param_name"                => "el_file",
							"value"                     => "",
							"file_type"                 => "js",
							"file_id"         			=> "ts-extend-element",
							"file_path"                 => "js/ts-visual-composer-extend-element.min.js",
							"description"               => __( "", "ts_visual_composer_extend" )
						),
					)						
				);
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
					return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
				} else {			
					vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
				};
			}
		}
	}
	// Register Container and Child Shortcode with Visual Composer
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_TS_VCSC_Anything_Grid extends WPBakeryShortCodesContainer {};
	}
	// Initialize "TS Anything Grid" Class
	if (class_exists('TS_Anything_Grid')) {
		$TS_Anything_Grid = new TS_Anything_Grid;
	}
?>