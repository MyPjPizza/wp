<?php
	// Class for Visual Composer Element
    if (!class_exists('TS_VCSC_TextBlock_Element')){
        class TS_VCSC_TextBlock_Element {
            function __construct() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
                        add_action('init',                                  array($this, 'TS_VCSC_Add_TextBlock_Lean'), 9999999);
                    } else if (function_exists('vc_map')) {
                        add_action('init',                                  array($this, 'TS_VCSC_Add_Textblock_Elements'), 9999999);
                    }
                } else {
                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
                        add_action('admin_init',							array($this, 'TS_VCSC_Add_TextBlock_Lean'), 9999999);
                    } else if (function_exists('vc_map')) {
                        add_action('admin_init',							array($this, 'TS_VCSC_Add_Textblock_Elements'), 9999999);
                    }
                }
                if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
                    add_shortcode('TS_VCSC_Advanced_Textblock',				array($this, 'TS_VCSC_TextBlock_Output_Function'));
                }                
            }
            
            // Register Element(s) via LeanMap
            function TS_VCSC_Add_TextBlock_Lean() {
                vc_lean_map('TS_VCSC_Advanced_Textblock',					array($this, 'TS_VCSC_Add_Textblock_Elements'), null);
            }
            
            // Output of Advanced Textblock Element
            function TS_VCSC_TextBlock_Output_Function($atts, $content = null) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                ob_start();
				
				wp_enqueue_style('ts-visual-composer-extend-front');
				
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$block_frontend					= "true";
				} else {
					$block_frontend					= "false";
				}
                
				extract( shortcode_atts( array(
					// Default Settings
					'styling_display'				=> 'block',					
					'styling_float'					=> 'none',
					'styling_width'					=> 100,
					'styling_position'				=> 'relative',
					'styling_left'					=> 0,
					'styling_top'					=> 0,
					'styling_right'					=> 'auto',
					'styling_bottom'				=> 'auto',
					'styling_color' 				=> '#696969',
					'styling_weight' 				=> 'normal',
					'styling_style'					=> 'normal',
					'styling_decoration'			=> 'none',
					'styling_align' 				=> 'left',
					'styling_transform' 			=> 'none',
					'styling_family' 				=> 'Default:regular',
					'styling_font' 					=> 'default',
					'styling_size'					=> 14,					
					'styling_linetype'				=> 'relative',
					'styling_linerelative'			=> 150,
					'styling_linefixedpx'			=> 21,
					'styling_indent'				=> 0,
					'styling_padding' 				=> 'padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;',
					'styling_margin' 				=> 'margin-top:0px;margin-right:0px;margin-right:auto;margin-bottom:0px;margin-left:0px;margin-left:auto;',
					'styling_border' 				=> '',
					'styling_custom'				=> '',
					'styling_override'				=> 'false',
					'styling_segments' 				=> '',
					'styling_wpautop'				=> 'false',
					// Effect Settings
					'effect_shadow'					=> '',
					'effect_viewportclass' 			=> '',
					'effect_viewportname' 			=> '',
					'effect_viewportoffset' 		=> 'bottom-in-view',
					'effect_viewportmobile'			=> 'false',
					'effect_viewportdelay'			=> 0,
					// Background Settings
					'background_type' 				=> 'transparent',
					'background_color' 				=> '#ffffff',
					'background_gradient' 			=> '',
					'background_pattern' 			=> '',
					'background_image' 				=> '',
					'background_size' 				=> 'cover',
					'background_repeat' 			=> 'no-repeat',
					'background_position'			=> 'center center',
					// Special Settings
					'patternbolt_type'				=> 'ts-patternbolt-buseca',
					'patternbolt_color'				=> '#ff9659',
					'patternbolt_size'				=> 40,
					'patternbolt_opacity'			=> 75,
					// Link Settings
					'link_textbox'					=> 'false',
					'link_data'						=> '',
					// Other Settings					
					'el_id' 				        => '',
					'el_class'                      => '',
					'css'					        => '',
				), $atts ));
				
				$identifier							= mt_rand(999999, 9999999);
				
				// Load Files if Viewport Animation
				$animation_css						= '';
				if (($effect_viewportclass != '') && ($block_frontend == "false")) {
					wp_enqueue_style('ts-extend-animations');
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
						if (wp_script_is('waypoints', $list = 'registered')) {
							wp_enqueue_script('waypoints');
						} else {
							wp_enqueue_script('ts-extend-waypoints');
						}
					}
					wp_enqueue_script('ts-visual-composer-extend-front');					
				}

				// Shadow Effect
				if (($effect_shadow != '') && ($background_type != "transparent")) {
					$shadow_class					= 'ts-css-shadow ' . $effect_shadow;
					$shadow_active					= 'true';
				} else {
					$shadow_class					= '';
					$shadow_active					= 'false';
				}
				
				// Retrieve / Set Element ID
				if (!empty($el_id)) {
					$textbox_id						= $el_id;
				} else {
					$textbox_id						= 'ts-advanced-textblock-container-' . $identifier;
				}
                
				// Define Global Variables
                $output								= '';
				$styling							= '';
				$styling_types						= '';
                $wpautop 							= ($styling_wpautop == "true" ? true : false);
				$class_background					= '';
				$data_background					= '';
				$link_start 						= '';
				$link_end 							= '';
				
				// Link Settings
				if (($link_textbox == "true") && ($link_data != '')) {
					$link 							= TS_VCSC_Advancedlinks_GetLinkData($link_data);
					$a_href							= $link['url'];
					$a_title 						= $link['title'];
					$a_target 						= $link['target'];
					if ($a_href != '') {
						$link_start					= '<a id="ts-advanced-textblock-link-' . $identifier . '" class="ts-advanced-textblock-link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">';
						$link_end					= '</a>';
					}
				}
				
				// Create Default Styling
				if (strpos($styling_family, 'Default') === false) {
					$font_default					= TS_VCSC_GetFontFamily($textbox_id, $styling_family, $styling_font, false, true, false);
				} else {
					$font_default					= '';
				}
				$background_style					= '';
				if ($background_type == "pattern") {
					$background_style				.= "background-color: transparent;";
					$background_style				.= "background-image: url('" . $background_pattern . "');";
					$background_style				.= "background-repeat: repeat;";
				} else if ($background_type == "color") {
					$background_style				.= "background-image: none;";
					$background_style				.= "background-color: " . $background_color . ";";
				} else if ($background_type == "gradient") {
					$background_style				.= $background_gradient;
				} else if ($background_type == "image") {
					$background_image				= wp_get_attachment_image_src($background_image, 'full');
					$background_image				= $background_image[0];
					$background_style				.= "background-color: " . $background_color . ";";
					$background_style				.= "background-image: url('" . $background_image . "');";
					$background_style				.= "background-repeat: " . $background_repeat . ";";
					$background_style				.= "background-position: " . $background_position . ";";
					$background_style				.= "-webkit-background-size: " . $background_size . ";";
					$background_style				.= "-moz-background-size: " . $background_size . ";";
					$background_style				.= "-o-background-size: " . $background_size . ";";
					$background_style				.= "background-size: " . $background_size . ";";
				} else if ($background_type == "transparent") {
					$background_style				.= "background-image: none;";
					$background_style				.= "background-color: transparent;";
				} else if ($background_type == "patternbolt") {
					wp_enqueue_style('ts-extend-patternbolt');
					$background_style				.= "background-color: " . $patternbolt_color . ";";
					$background_style				.= "background-size: " . $patternbolt_size . "px;";
					$data_background				.= 'data-patternbolt-type="' . $patternbolt_type . '" data-patternbolt-color="' . $patternbolt_color . '" data-patternbolt-size="' . $patternbolt_size . '" data-patternbolt-opacity="' . $patternbolt_opacity . '"';
					$class_background				.= 'ts-general-patternbolt ' . $patternbolt_type . '';
				}
				
				// Effect Settings
				$effect_settings					= '';
				if (($effect_viewportclass != '') && ($block_frontend == "false")) {
					$viewport_effect				= 'ts-advanced-textblock-viewport';
				} else {
					$viewport_effect				= '';
				}				
				
				// Process Group Values
				if ($styling_override == "true") {
					$styling_groups					= array();
					$styling_types					= '';
					if (isset($styling_segments) && strlen($styling_segments) > 0 ) {			
						$styling_entries 			= json_decode(urldecode($styling_segments), true);
						if (!is_array($styling_entries)) {
							$styling_entries		= array();
						}
					}
					foreach ((array) $styling_entries as $key => $entry) {
						if (isset($entry['segment_type'])) {
							$styling_groups[$entry['segment_type']] = array(
								'type'				=> $entry['segment_type'],							
								'id' 				=> (isset($entry['segment_id']) ? esc_html($entry['segment_id']) : ""),
								'class' 			=> (isset($entry['segment_class']) ? esc_html($entry['segment_class']) : ""),
								'display' 			=> (isset($entry['segment_display']) ? esc_html($entry['segment_display']) : "block"),
								'float' 			=> (isset($entry['segment_float']) ? esc_html($entry['segment_float']) : "none"),
								'color' 			=> (isset($entry['segment_type']) ? esc_html($entry['segment_color']) : $styling_color),
								'background' 		=> (isset($entry['segment_background']) ? esc_html($entry['segment_background']) : 'transparent'),
								'weight'			=> (isset($entry['segment_weight']) ? esc_html($entry['segment_weight']) : $styling_weight),
								'style'				=> (isset($entry['segment_style']) ? esc_html($entry['segment_style']) : $styling_style),
								'decoration'		=> (isset($entry['segment_decoration']) ? esc_html($entry['segment_decoration']) : 'none'),
								'align'				=> (isset($entry['segment_align']) ? esc_html($entry['segment_align']) : $styling_align),
								'transform'			=> (isset($entry['segment_transform']) ? esc_html($entry['segment_transform']) : $styling_transform),
								'family'			=> (isset($entry['segment_family']) ? esc_html($entry['segment_family']) : $styling_family),
								'font'				=> (isset($entry['segment_font']) ? esc_html($entry['segment_font']) : $styling_font),
								'size'				=> (isset($entry['segment_size']) ? esc_html($entry['segment_size']) : $styling_size),								
								'linetype'			=> (isset($entry['segment_linetype']) ? esc_html($entry['segment_linetype']) : $styling_linetype),
								'linerelative'		=> (isset($entry['segment_linerelative']) ? esc_html($entry['segment_linerelative']) : $styling_linerelative),
								'linefixedpx'		=> (isset($entry['segment_linefixedpx']) ? esc_html($entry['segment_linefixedpx']) : $styling_linefixedpx),								
								'indent'			=> (isset($entry['segment_indent']) ? esc_html($entry['segment_indent']) : $styling_indent),
								'padding'			=> (isset($entry['segment_padding']) ? esc_html($entry['segment_padding']) : ""),
								'margin'			=> (isset($entry['segment_margin']) ? esc_html($entry['segment_margin']) : ""),
								'border'			=> (isset($entry['segment_border']) ? esc_html($entry['segment_border']) : ""),
								'custom'			=> (isset($entry['segment_custom']) ? esc_html($entry['segment_custom']) : ""),
							);
						}
					}
					foreach ($styling_groups as $type => $style) {
						$type_narrow				= '';
						if ($style['id'] != '') {
							$type_narrow			.= '#' . $style['id'];
						}
						if ($style['class'] != '') {
							$type_narrow			.= '.' . $style['class'];
						}
						$styling_types .= 'body #' . $textbox_id . ' .ts-advanced-textblock-content ' . $type . $type_narrow . ' {';
							if (strpos($style['family'], 'Default') === false) {
								$styling_types .= TS_VCSC_GetFontFamily($textbox_id, $style['family'], $style['font'], false, true, false);
							}
							$styling_types .= 'display: ' . $style['display'] . ';';
							$styling_types .= 'float: ' . $style['float'] . ';';
							$styling_types .= 'color: ' . $style['color'] . ';';
							$styling_types .= 'background: ' . $style['background'] . ';';
							$styling_types .= 'font-weight: ' . $style['weight'] . ';';
							$styling_types .= 'font-style: ' . $style['style'] . ';';
							$styling_types .= 'font-size: ' . $style['size'] . 'px;';							
							if ($style['linetype'] == "relative") {
								$styling_types .= 'line-height: ' . ($style['linerelative'] / 100) . ';';
							} else if ($style['linetype'] == "fixedpx") {
								$styling_types .= 'line-height: ' . $style['linefixedpx'] . 'px;';
							}
							$styling_types .= 'text-align: ' . $style['align'] . ';';
							$styling_types .= 'text-transform: ' . $style['transform'] . ';';
							$styling_types .= 'text-decoration: ' . $style['decoration'] . ';';
							$styling_types .= 'text-indent: ' . $style['indent'] . 'px;';
							$styling_types .= $style['padding'];
							$styling_types .= $style['margin'];
							$styling_types .= str_replace('|', '', $style['border']);
							if ($style['custom'] != '') {
								$styling_types .= rawurldecode(base64_decode(strip_tags($style['custom'])));
							}
						$styling_types .= '}';
					}					
				}
				// Create Styling Output
				$styling .= '<style id="' . $textbox_id . '-style" type="text/css">';
					// Default Styling
					$styling .= 'body #' . $textbox_id . ' {';
						$styling .= $font_default;
						$styling .= 'position: ' . $styling_position . ';';
						if ($styling_position == 'absolute') {
							
						}
						$styling .= 'width: ' . $styling_width . '%;';
						$styling .= 'display: ' . $styling_display . ';';
						$styling .= 'float: ' . $styling_float . ';';
						$styling .= 'color: ' . $styling_color . ';';
						$styling .= 'font-size: ' . $styling_size . 'px;';
						$styling .= 'font-style: ' . $styling_style . ';';
						if ($styling_linetype == 'relative') {
							$styling .= 'line-height: ' . ($styling_linerelative / 100) . ';';
						} else if ($styling_linetype == 'fixedpx') {
							$styling .= 'line-height: ' . $styling_linefixedpx . 'px;';
						}
						$styling .= 'font-weight: ' . $styling_weight . ';';
						$styling .= 'text-align: ' . $styling_align . ';';
						$styling .= 'text-transform: ' . $styling_transform . ';';
						$styling .= 'text-decoration: ' . $styling_decoration . ';';
						$styling .= 'text-indent: ' . $styling_indent .'px;';
						$styling .= $styling_padding;
						$styling .= $styling_margin;
						$styling .= str_replace('|', '', $styling_border);
						$styling .= $background_style;
						if ($styling_custom != '') {
							$styling .= rawurldecode(base64_decode(strip_tags($styling_custom)));
						}
					$styling .= '}';
					// Segment Styling
					$styling .= $styling_types;
				$styling .= '</style>';
				
				// VC Internal Override Filter
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-advanced-textblock-container ' . $el_class . $animation_css . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Advanced_Textblock', $atts);
				} else {
					$css_class						= 'ts-advanced-textblock-container ' . $el_class . $animation_css . ' ';
				}
				
				// Create Content Output
				$data_viewport 						= 'data-viewport-class="ts-infinite-css-' . $effect_viewportclass . '" data-viewport-offset="' . $effect_viewportoffset . '" data-viewport-delay="' . $effect_viewportdelay . '" data-viewport-opacity="1" data-viewport-mobile="' . $effect_viewportmobile . '"';
				$data_shadow						= 'data-shadow-active="' . $shadow_active . '" data-shadow-class="' . $shadow_class . '"';				
				$output .= TS_VCSC_MinifyCSS($styling);
				$output .= $link_start;
					$output .= '<div id="' . $textbox_id . '" class="' . $css_class . ' ' . $shadow_class . ' ' . $viewport_effect . '" ' . $data_viewport . ' ' . $data_shadow . ' ' . $data_background . '>';
						if ($background_type == "patternbolt") {
							$output .= '<div id="ts-advanced-textblock-background-' . $identifier . '" class="ts-advanced-textblock-background ' . $class_background . '"></div>';
						}
						$output .= '<div id="ts-advanced-textblock-content-' . $identifier . '" class="ts-advanced-textblock-content">';
							if (function_exists('wpb_js_remove_wpautop')){
								$output .= wpb_js_remove_wpautop(do_shortcode($content), $wpautop);
							} else {
								$output .= do_shortcode($content);
							}
						$output .= '</div>';					
					$output .= '</div>';
				$output .= $link_end;
				
				echo $output;
				
				unset($styling_entries);
				unset($styling_groups);
                
                $myvariable = ob_get_clean();
                return $myvariable;
            }            
			
			// Register Advanced Textblock Element
            function TS_VCSC_Add_Textblock_Elements() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                // Add Advanced Textblock Element
                $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
                    "name"                              => __( "TS Textblock Advanced", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Advanced_Textblock",
                    "icon" 	                            => "ts-composer-element-icon-advanced-textblock",
                    "class"                             => "ts_vcsc_main_widgets_output",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Create an advanced textblock", "ts_visual_composer_extend"),
                    "admin_enqueue_js"            		=> "",
                    "admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Textblock Content
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_1",
                            "seperator"					=> "Textblock Content"
                        ),
						array(
							"type"						=> "textarea_html",
							"holder"					=> "div",
							"class"						=> "",
							"heading"					=> __( "Content", "ts_visual_composer_extend" ),
							"param_name"				=> "content",
							"value"						=> "",
							"description"				=> __( "Create the content for the advanced textblock.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
						),
						// Textblock Link
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_2",
                            "seperator"					=> "Textblock Link",
                        ),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Link Textbox", "ts_visual_composer_extend" ),
							"param_name"		    	=> "link_textbox",
							"value"             		=> "false",
							"description"		    	=> __( "Switch the toggle if you want to link the element to another page; will not work if the content itself already includes one or more links.", "ts_visual_composer_extend" ),
						),
						array(
							"type" 						=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
							"heading" 					=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 				=> "link_data",
							"description" 				=> __("Provide a link to another page to be used for the element.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "link_textbox", 'value' => 'true' ),
						),
						// Background Settings
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_3",
                            "seperator"					=> "Background Styling",
							"group"						=> "Global Styling",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Background Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "background_type",
							"width"             		=> 300,
							"value"             		=> array(
								__( "Transparent Background", "ts_visual_composer_extend" )		=> "transparent",
								__( "Solid Color", "ts_visual_composer_extend" )				=> "color",
								__( "Gradient Background", "ts_visual_composer_extend" )		=> "gradient",
								__( "Background Pattern", "ts_visual_composer_extend" )			=> "pattern",
								__( "Custom Image", "ts_visual_composer_extend" )				=> "image",
								__( "Patternbolt Pattern", "ts_visual_composer_extend" )		=> "patternbolt",
								//__( "Trianglify Pattern", "ts_visual_composer_extend" )		=> "trianglify",
								//__( "Particilify Pattern", "ts_visual_composer_extend" )		=> "particlify",
							),
							"description"       		=> __( "Select the background type for the element.", "ts_visual_composer_extend" ),
							"admin_label"				=> true,
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Background Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "background_color",
							"value"             		=> "#ffffff",
							"description"       		=> __( "Select the background color for the element.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => array('color', 'image') ),
							"group"						=> "Global Styling",
						),			
						array(
							"type"						=> "advanced_gradient",
							"class"						=> "",
							"heading"					=> __("Gradient Background", "ts_visual_composer_extend"),						
							"param_name"				=> "background_gradient",
							"description"				=> __('Use the controls above to create a custom gradient background for the element.', 'ts_visual_composer_extend'),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'gradient' ),
							"group"						=> "Global Styling",
						),			
						array(
							"type"              		=> "background",
							"heading"           		=> __( "Background Pattern", "ts_visual_composer_extend" ),
							"param_name"        		=> "background_pattern",
							"height"            		=> 200,
							"pattern"           		=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Background_List,
							"value"						=> "",
							"encoding"          		=> "false",
							"empty"						=> "true",
							"description"       		=> __( "Select the background pattern for the element.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'pattern' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "attach_image",
							"heading"           		=> __( "Background Image", "ts_visual_composer_extend" ),
							"param_name"        		=> "background_image",
							"value"             		=> "",
							"description"       		=> __( "Select an image or pattern to be used as background for the icon box.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'image' ),
							"group"						=> "Global Styling",
						),		
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Background Size", "ts_visual_composer_extend" ),
							"param_name"				=> "background_size",
							"width"						=> 150,
							"value"						=> array(
								__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
								__( "150%", "ts_visual_composer_extend" )			=> "150%",
								__( "200%", "ts_visual_composer_extend" )			=> "200%",
								__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
								__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
								__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
							),
							"description"				=> __( "Select how the custom background image should be sized.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'image' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Background Repeat", "ts_visual_composer_extend" ),
							"param_name"				=> "background_repeat",
							"width"						=> 150,
							"value"						=> array(
								__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
								__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
								__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
								__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
							),
							"description"				=> __( "Select if and how the background image should be repeated.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'image' ),
							"group"						=> "Global Styling",
						),						
						array(
							"type" 						=> "dropdown",
							"class" 					=> "",
							"heading" 					=> __( "Background Position", "ts_visual_composer_extend" ),
							"param_name" 				=> "background_position",
							"value" 					=> array(
								__( "Center Center", "ts_visual_composer_extend" ) 				=> "center center",
								__( "Center Top", "ts_visual_composer_extend" )					=> "center top",
								__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "center bottom",
								__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
								__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
								__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
								__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
								__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
								__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
							),
							"description" 				=> __("Select the position of the background image; will have most effect on smaller screens.", "ts_visual_composer_extend"),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'image' ),
							"group"						=> "Global Styling",
						),
						array(
							"type" 						=> "dropdown",
							"class" 					=> "",
							"heading" 					=> __( "Patternbolt Pattern", "ts_visual_composer_extend"),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"param_name" 				=> "patternbolt_type",
							"value" 					=> array(
								__( "Buseca", "ts_visual_composer_extend")						=> "ts-patternbolt-buseca",
								__( "Candy Bold", "ts_visual_composer_extend")					=> "ts-patternbolt-candy-bold",
								__( "Candy Medium", "ts_visual_composer_extend")				=> "ts-patternbolt-candy-medium",
								__( "Candy Light", "ts_visual_composer_extend")					=> "ts-patternbolt-candy-light",				
								__( "Cross (Standard) Bold", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-bold",
								__( "Cross (Standard) Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-medium",
								__( "Cross (Standard) Light", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-light",				
								__( "Cross (Thin) Bold", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-bold",
								__( "Cross (Thin) Medium", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-medium",
								__( "Cross (Thin) Light", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-light",				
								__( "Horizontal Lines Bold", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-bold",
								__( "Horizontal Lines Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-medium",
								__( "Horizontal Lines Light", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-light",				
								__( "Diagonal Lines Bold", "ts_visual_composer_extend")			=> "ts-patternbolt-diagonal-lines-bold",
								__( "Diagonal Lines Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-diagonal-lines-medium",
								__( "Diagonal Lines Light", "ts_visual_composer_extend")		=> "ts-patternbolt-diagonal-lines-light",					
							),
							"description" 				=> __("Select which Patternbolt pattern you want to use as row background.", "ts_visual_composer_extend"),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'patternbolt' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Patternbolt Color", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"param_name"        		=> "patternbolt_color",
							"value"            	 		=> "#ff9659",
							"description"       		=> __( "Define the background color for the pattern blocks.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'patternbolt' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Patternbolt Size", "ts_visual_composer_extend" ),
							"param_name"            	=> "patternbolt_size",
							"value"                 	=> "40",
							"min"                   	=> "10",
							"max"                   	=> "250",
							"step"                  	=> "1",
							"unit"                  	=> 'px',
							"description"           	=> __( "Define the size of the pattern blocks.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'patternbolt' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Patternbolt Opacity", "ts_visual_composer_extend" ),
							"param_name"            	=> "patternbolt_opacity",
							"value"                 	=> "75",
							"min"                   	=> "10",
							"max"                   	=> "100",
							"step"                  	=> "1",
							"unit"                  	=> '%',
							"description"           	=> __( "Define the opacity of the pattern blocks.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => 'patternbolt' ),
							"group"						=> "Global Styling",
						),
						// Default Font Settings
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_4",
                            "seperator"					=> "Font Styling",
							"group"						=> "Global Styling",
                        ),
						array(
							'type' 						=> 'colorpicker',
							'heading' 					=> __( 'Font Color', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'styling_color',
							'value'						=> '#696969',
							'description' 				=> __( 'Select the default font color for the element.', 'ts_visual_composer_extend' ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),										
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Font Weight", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_weight",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Normal', "ts_visual_composer_extend" )       => "normal",
								__( 'Bolder', "ts_visual_composer_extend" )       => "bolder",			 
								__( 'Bold', "ts_visual_composer_extend" )         => "bold",
								__( 'Light', "ts_visual_composer_extend" )        => "300",
								__( 'Lighter', "ts_visual_composer_extend" )      => "100",
								__( 'Default', "ts_visual_composer_extend" )      => "inherit",
							),
							"description"       		=> __( "Select the default font weight for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),						
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Font Style", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_style",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Normal', "ts_visual_composer_extend" )      	=> "normal",
								__( 'Italic', "ts_visual_composer_extend" )       	=> "italic",			 
								__( 'Oblique', "ts_visual_composer_extend" )		=> "oblique",
							),
							"description"       		=> __( "Select the default font style for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),						
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Text Alignment", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_align",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Left', "ts_visual_composer_extend" )			=> "left",
								__( 'Right', "ts_visual_composer_extend" )			=> "right",			 
								__( 'Center', "ts_visual_composer_extend" )			=> "center",
								__( 'Justify', "ts_visual_composer_extend" )		=> "justify",
							),
							"description"       		=> __( "Select the default text alignment for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),								
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Text Transform", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_transform",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'None', "ts_visual_composer_extend" )			=> "none",
								__( 'Capitalize', "ts_visual_composer_extend" )		=> "capitalize",			 
								__( 'Uppercase', "ts_visual_composer_extend" )		=> "uppercase",
								__( 'Lowercase', "ts_visual_composer_extend" )		=> "lowercase",
							),
							"description"       		=> __( "Select the default text transform for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Text Decoration", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_decoration",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'None', "ts_visual_composer_extend" )       	=> "none",
								__( 'Underline', "ts_visual_composer_extend" )		=> "underline",			 
								__( 'Overline', "ts_visual_composer_extend" )		=> "overline",
								__( 'Line Through', "ts_visual_composer_extend" )	=> "line-through",
							),
							"description"       		=> __( "Select the default font decoration for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),	
						array(
							"type"						=> "fontsmanager",
							"heading"					=> __( "Font Family", "ts_visual_composer_extend" ),
							"param_name"				=> "styling_family",
							"value"						=> "Default:regular",
							"default"					=> "true",
							"connector"					=> "styling_font",
							"description"				=> __( "Select the default font family to be used for the element.", "ts_visual_composer_extend" ),
							"admin_label"				=> true,
							"group"						=> "Global Styling",
						),
						array(
							"type"						=> "hidden_input",
							"param_name"				=> "styling_font",
							"value"						=> "default",
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Font Size", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_size",
							"value"             		=> "14",
							"min"               		=> "10",
							"max"               		=> "100",
							"step"              		=> "1",
							"unit"              		=> 'px',
							"description"       		=> "Define the font size to be used for the element.",
							"admin_label"				=> true,
							"group"						=> "Global Styling",
						),						
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Line Height Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_linetype",
							"width"             		=> 300,
							"value"             		=> array(								
								__( "Relative (Based on Font Size)", "ts_visual_composer_extend" )	=> "relative",
								__( "Fixed Pixels Value", "ts_visual_composer_extend" )				=> "fixedpx",
							),
							"description"       		=> __( "Select how the general line height for this element should be determined.", "ts_visual_composer_extend" ),
							"admin_label"				=> true,
							"group"						=> "Global Styling",
						),						
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Line Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_linerelative",
							"value"             		=> "150",
							"min"               		=> "100",
							"max"               		=> "500",
							"step"              		=> "1",
							"unit"              		=> '%',
							"description"       		=> "Define the relative line height to be used for the element; 100% equals the selected font size.",
							"dependency"        		=> array( 'element' => "styling_linetype", 'value' => 'relative' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Line Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_linefixedpx",
							"value"             		=> "21",
							"min"               		=> "12",
							"max"               		=> "120",
							"step"              		=> "1",
							"unit"              		=> 'px',
							"description"       		=> "Define the fixed line height in pixels to be used for the element.",
							"dependency"        		=> array( 'element' => "styling_linetype", 'value' => 'fixedpx' ),
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Text Indentation", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_indent",
							"value"             		=> "0",
							"min"               		=> "-100",
							"max"               		=> "100",
							"step"              		=> "1",
							"unit"              		=> 'px',
							"description"       		=> "Define the general text indentation to be used for the element.",
							"group"						=> "Global Styling",
						),
						// Paddings / Margins
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_5",
                            "seperator"					=> "Paddings + Margins",
							"group"						=> "Global Styling",
                        ),	
						array(
							"type" 						=> "advanced_styling",
							"heading" 					=> __("Internal Paddings", "ts_visual_composer_extend"),
							"param_name" 				=> "styling_padding",
							"style_type"				=> "padding",
							"show_main"					=> "false",
							"show_preview"				=> "false",
							"show_width"				=> "true",
							"show_style"				=> "false",
							"show_radius" 				=> "false",					
							"show_color"				=> "false",
							"show_unit_width"			=> "false",
							"show_unit_radius"			=> "false",
							"label_width"				=> "",
							"override_all"				=> "false",
							"default_positions"			=> array(
								//"All"							=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
								"Top"							=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
								"Right"							=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
								"Bottom"						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
								"Left"							=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
							),
							"value"						=> "padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;",
							"description"       		=> __( "Define the internal paddings for the element.", "ts_visual_composer_extend" ),
							"group"						=> "Global Styling",
						),
						array(
							"type" 						=> "advanced_styling",
							"heading" 					=> __("External Margins", "ts_visual_composer_extend"),
							"param_name" 				=> "styling_margin",
							"style_type"				=> "margin",
							"show_main"					=> "false",
							"show_preview"				=> "false",
							"show_width"				=> "true",
							"show_style"				=> "false",
							"show_radius" 				=> "false",					
							"show_color"				=> "false",
							"show_unit_width"			=> "false",
							"show_unit_radius"			=> "false",
							"label_width"				=> "",
							"override_all"				=> "false",
							"default_positions"			=> array(
								//"All"							=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
								"Top"							=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "false"),
								"Right"							=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "true"),
								"Bottom"						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "false"),
								"Left"							=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "true"),
							),
							"value"						=> "margin-top:0px;margin-right:0px;margin-right:auto;margin-bottom:0px;margin-left:0px;margin-left:auto;",
							"description"       		=> __( "Define the external margins for the element.", "ts_visual_composer_extend" ),
							"group"						=> "Global Styling",
						),
						// Border Settings
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_6",
                            "seperator"					=> "Border Styling",
							"group"						=> "Global Styling",
                        ),	
						array(
							"type" 						=> "advanced_styling",
							"heading" 					=> __("Border Settings", "ts_visual_composer_extend"),
							"param_name" 				=> "styling_border",
							"style_type"				=> "border",
							"show_main"					=> "false",
							"show_preview"				=> "true",
							"show_width"				=> "true",
							"show_style"				=> "true",
							"show_radius" 				=> "true",					
							"show_color"				=> "true",
							"show_unit_width"			=> "true",
							"show_unit_radius"			=> "true",
							"override_all"				=> "false",
							"default_positions"			=> array(
								//"All"							=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
								"Top"							=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
								"Right"							=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
								"Bottom"						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
								"Left"							=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
							),
							"description"       		=> __( "Define the border settings for each side and corner of the element.", "ts_visual_composer_extend" ),
							"group"						=> "Global Styling",
						),
						// Display Settings
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_7",
                            "seperator"					=> "Display Settings",
							"group"						=> "Global Styling",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Textblock Display", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_display",
							"width"             		=> 300,
							"value"             		=> array(
								__( "Block", "ts_visual_composer_extend" )			=> "block",
								__( "Inline Block", "ts_visual_composer_extend" )	=> "inline-block",
								__( "Inline", "ts_visual_composer_extend" )			=> "inline",
								__( "Flex", "ts_visual_composer_extend" )			=> "flex",
								__( "Inline Flex", "ts_visual_composer_extend" )	=> "inline-flex",
								__( "Table", "ts_visual_composer_extend" )			=> "table",
								__( "Table Cell", "ts_visual_composer_extend" )		=> "table-cell",
								__( "Table Column", "ts_visual_composer_extend" )	=> "table-column",
								__( "Table Row", "ts_visual_composer_extend" )		=> "table-row",
								__( "Inline Table ", "ts_visual_composer_extend" )	=> "inline-table",
								__( "List Item", "ts_visual_composer_extend" )		=> "list-item",
								__( "Run-In", "ts_visual_composer_extend" )			=> "run-in",
								__( "None", "ts_visual_composer_extend" )			=> "none",
							),
							"description"       		=> __( "Select the display rule to be used for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),	
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Textblock Float", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_float",
							"width"             		=> 300,
							"value"             		=> array(
								__( "None", "ts_visual_composer_extend" )			=> "none",
								__( "Left", "ts_visual_composer_extend" )			=> "left",
								__( "Right", "ts_visual_composer_extend" )			=> "right",
							),
							"description"       		=> __( "Select the float rule to be used for the element.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"group"						=> "Global Styling",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Textblock Width", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_width",
							"value"             		=> "100",
							"min"               		=> "10",
							"max"               		=> "100",
							"step"              		=> "1",
							"unit"              		=> '%',
							"description"       		=> "Define the textblock width to be used for the element.",
							"group"						=> "Global Styling",
						),
						// Custom Styling
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_8",
                            "seperator"					=> "Custom CSS Code",
							"group"						=> "Global Styling",
                        ),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Custom CSS Code", "ts_visual_composer_extend" ),
							"param_name"        		=> "styling_custom",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter any custom CSS code you want to apply to the textbox container directly here.", "ts_visual_composer_extend" ),
							"group"						=> "Global Styling",
						),					
						// Segment Styling (H1 - H6, DIV, SPAN, DIV, P)
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_9",
                            "seperator"					=> "Segment Styling",
							"group"						=> "Segment Styling",
                        ),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Segment Styling Rules", "ts_visual_composer_extend" ),
							"param_name"		    	=> "styling_override",
							"value"             		=> "false",
							"description"		    	=> __( "Switch the toggle if you want to define custom rules for individual segements inside the content (i.e. H1-H6, SPAN, etc.).", "ts_visual_composer_extend" ),
							"group" 					=> "Segment Styling",
						),
						array(
							'type' 						=> 'param_group',
							'heading' 					=> __( 'Segment Styles', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'styling_segments',
							'description' 				=> __( 'Define the styling for any content segments you might have used.', 'ts_visual_composer_extend' ),
							'save_always' 				=> true,
							"group"						=> "Segment Styling",
							"dependency"            	=> array( 'element' => "styling_override", 'value' => 'true' ),
							'value' 					=> urlencode(json_encode(array(
								array(
									'segment_type' 				=> 'h1',
									'segment_id'				=> '',
									'segment_class'				=> '',									
									'segment_display'			=> 'block',
									'segment_float'				=> 'none',									
									'segment_color' 			=> '#696969',
									'segment_background'		=> 'transparent',
									'segment_weight'			=> '300',
									'segment_style'				=> 'normal',
									'segment_decoration'		=> 'none',
									'segment_family'			=> 'Default:regular',
									'segment_font'				=> 'default',
									'segment_size'				=> 36,
									'segment_linertype'			=> 'relative',
									'segment_linerelative'		=> 150,
									'segment_linefixedpx'		=> 54,
									'segment_indent'			=> 0,
									'segment_transform'			=> 'uppercase',
									'segment_align'				=> 'center',
									'segment_padding'			=> 'padding-top:10px;padding-right:0px;padding-bottom:20px;padding-left:0px;',
									'segment_margin'			=> '',
									'segment_border'			=> '',
								),
							))),
							'params' 					=> array(
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Segment Type", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_type",
									"width"             		=> 300,
									"value"             		=> array(
										__( "H1", "ts_visual_composer_extend" )				=> "h1",
										__( "H2", "ts_visual_composer_extend" )				=> "h2",
										__( "H3", "ts_visual_composer_extend" )				=> "h3",
										__( "H4", "ts_visual_composer_extend" )				=> "h4",
										__( "H5", "ts_visual_composer_extend" )				=> "h5",
										__( "H6", "ts_visual_composer_extend" )				=> "h6",
										__( "Paragraph", "ts_visual_composer_extend" )		=> "p",
										__( "DIV", "ts_visual_composer_extend" )			=> "div",
										__( "Span", "ts_visual_composer_extend" )			=> "span",
										__( "Link", "ts_visual_composer_extend" )			=> "a",
										__( "Image", "ts_visual_composer_extend" )			=> "img",
										__( "Figure", "ts_visual_composer_extend" )			=> "figure",
										__( "Blockquote", "ts_visual_composer_extend" )		=> "blockquote",
										__( "Strong", "ts_visual_composer_extend" )			=> "strong",
										__( "Bold", "ts_visual_composer_extend" )			=> "bold",
									),
									"admin_label" 				=> true,
									"description"       		=> __( "Select the segment type you want to style.", "ts_visual_composer_extend" )
								),								
								array(
									"type"              		=> "textfield",
									"heading"           		=> __( "Segment ID", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_id",
									"value"             		=> "",
									"admin_label" 				=> true,
									"description"       		=> __( "Enter an unique ID for the segment type you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									"type"              		=> "textfield",
									"heading"           		=> __( "Segment Class", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_class",
									"value"             		=> "",
									"admin_label" 				=> true,
									"description"       		=> __( "Enter a class name for the segment type you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),								
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Segment Display", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_display",
									"width"             		=> 300,
									"value"             		=> array(
										__( "Block", "ts_visual_composer_extend" )			=> "block",
										__( "Inline Block", "ts_visual_composer_extend" )	=> "inline-block",
										__( "Inline", "ts_visual_composer_extend" )			=> "inline",
										__( "Flex", "ts_visual_composer_extend" )			=> "flex",
										__( "Inline Flex", "ts_visual_composer_extend" )	=> "inline-flex",
										__( "Table", "ts_visual_composer_extend" )			=> "table",
										__( "Table Cell", "ts_visual_composer_extend" )		=> "table-cell",
										__( "Table Column", "ts_visual_composer_extend" )	=> "table-column",
										__( "Table Row", "ts_visual_composer_extend" )		=> "table-row",
										__( "Inline Table ", "ts_visual_composer_extend" )	=> "inline-table",
										__( "List Item", "ts_visual_composer_extend" )		=> "list-item",
										__( "Run-In", "ts_visual_composer_extend" )			=> "run-in",
										__( "None", "ts_visual_composer_extend" )			=> "none",
									),
									"description"       		=> __( "Select the display rule for the segment type you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),	
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Segment Float", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_float",
									"width"             		=> 300,
									"value"             		=> array(
										__( "None", "ts_visual_composer_extend" )			=> "none",
										__( "Left", "ts_visual_composer_extend" )			=> "left",
										__( "Right", "ts_visual_composer_extend" )			=> "right",
									),
									"description"       		=> __( "Select the float rule for the segment type you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),									
								array(
									'type' 						=> 'colorpicker',
									'heading' 					=> __( 'Segment Background', 'ts_visual_composer_extend' ),
									'param_name' 				=> 'segment_background',
									'value'						=> 'transparent',
									'description' 				=> __( 'Select the font color for the segment type you want to style.', 'ts_visual_composer_extend' ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									'type' 						=> 'colorpicker',
									'heading' 					=> __( 'Font Color', 'ts_visual_composer_extend' ),
									'param_name' 				=> 'segment_color',
									'value'						=> '#696969',
									'description' 				=> __( 'Select the font color for the segment type you want to style.', 'ts_visual_composer_extend' ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Font Weight", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_weight",
									"width"             		=> 300,
									"value"             		=> array(
										__( 'Normal', "ts_visual_composer_extend" )       => "normal",
										__( 'Bolder', "ts_visual_composer_extend" )       => "bolder",			 
										__( 'Bold', "ts_visual_composer_extend" )         => "bold",
										__( 'Light', "ts_visual_composer_extend" )        => "300",
										__( 'Lighter', "ts_visual_composer_extend" )      => "100",
										__( 'Default', "ts_visual_composer_extend" )      => "inherit",
									),
									"description"       		=> __( "Select the font weight for the segment you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Font Style", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_style",
									"width"             		=> 300,
									"value"             		=> array(
										__( 'Normal', "ts_visual_composer_extend" )      	=> "normal",
										__( 'Italic', "ts_visual_composer_extend" )       	=> "italic",			 
										__( 'Oblique', "ts_visual_composer_extend" )		=> "oblique",
									),
									"description"       		=> __( "Select the font style for the segment you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Text Alignment", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_align",
									"width"             		=> 300,
									"value"             		=> array(
										__( 'Left', "ts_visual_composer_extend" )			=> "left",
										__( 'Right', "ts_visual_composer_extend" )			=> "right",			 
										__( 'Center', "ts_visual_composer_extend" )			=> "center",
										__( 'Justify', "ts_visual_composer_extend" )		=> "justify",
									),
									"description"       		=> __( "Select the text alignment for the segment you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),								
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Text Transform", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_transform",
									"width"             		=> 300,
									"value"             		=> array(
										__( 'None', "ts_visual_composer_extend" )			=> "none",
										__( 'Capitalize', "ts_visual_composer_extend" )		=> "capitalize",			 
										__( 'Uppercase', "ts_visual_composer_extend" )		=> "uppercase",
										__( 'Lowercase', "ts_visual_composer_extend" )		=> "lowercase",
									),
									"description"       		=> __( "Select the text transform for the segment you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
								),
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Text Decoration", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_decoration",
									"width"             		=> 300,
									"value"             		=> array(
										__( 'None', "ts_visual_composer_extend" )       	=> "none",
										__( 'Underline', "ts_visual_composer_extend" )		=> "underline",			 
										__( 'Overline', "ts_visual_composer_extend" )		=> "overline",
										__( 'Line Through', "ts_visual_composer_extend" )	=> "line-through",
									),
									"description"       		=> __( "Select the font decoration for the segment you want to style.", "ts_visual_composer_extend" ),
									"edit_field_class"			=> "vc_col-sm-6 vc_column",
									"group"						=> "Global Styling",
								),
								array(
									"type"						=> "fontsmanager",
									"heading"					=> __( "Font Family", "ts_visual_composer_extend" ),
									"param_name"				=> "segment_family",
									"value"						=> "",
									"default"					=> "true",
									"connector"					=> "styling_segments_segment_font", // add group name to param name
									"description"				=> __( "Select the font to be used for the segment type you want to style.", "ts_visual_composer_extend" ),
								),
								array(
									"type"						=> "hidden_input",
									"param_name"				=> "segment_font",
									"value"						=> "default",
									"description"				=> "",
								),
								array(
									"type"              		=> "nouislider",
									"heading"           		=> __( "Font Size", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_size",
									"value"             		=> "14",
									"min"               		=> "10",
									"max"               		=> "100",
									"step"              		=> "1",
									"unit"              		=> 'px',
									"description"       		=> "Define the font size to be used for the segment type you want to style."
								),
								array(
									"type"              		=> "dropdown",
									"heading"           		=> __( "Line Height Type", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_linetpye",
									"width"             		=> 300,
									"value"             		=> array(
										__( "Relative (Based on Font Size)", "ts_visual_composer_extend" )	=> "relative",
										__( "Fixed Pixels Value", "ts_visual_composer_extend" )				=> "fixedpx",
									),
									"description"       		=> __( "Select how the general line height for this section should be determined.", "ts_visual_composer_extend" ),
								),
								array(
									"type"              		=> "nouislider",
									"heading"           		=> __( "Line Height", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_linerelative",
									"value"             		=> "150",
									"min"               		=> "100",
									"max"               		=> "500",
									"step"              		=> "1",
									"unit"              		=> '%',
									"description"       		=> "Define the relative line height to be used for this section; 100% equals the selected font size.",
									"dependency"            	=> array( 'element' => "segment_linetpye", 'value' => 'relative' ),
								),
								array(
									"type"              		=> "nouislider",
									"heading"           		=> __( "Line Height", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_linefixedpx",
									"value"             		=> "18",
									"min"               		=> "10",
									"max"               		=> "100",
									"step"              		=> "1",
									"unit"              		=> 'px',
									"description"       		=> "Define the fixed line height in pixels to be used for this section.",
									"dependency"            	=> array( 'element' => "segment_linetpye", 'value' => 'fixedpx' ),
								),
								array(
									"type"              		=> "nouislider",
									"heading"           		=> __( "Text Indentation", "ts_visual_composer_extend" ),
									"param_name"        		=> "segment_indent",
									"value"             		=> "0",
									"min"               		=> "-100",
									"max"               		=> "100",
									"step"              		=> "1",
									"unit"              		=> 'px',
									"description"       		=> "Define the text indentation to be used for the segment type you want to style.",
									"group"						=> "Global Styling",
								),								
								array(
									"type" 						=> "advanced_styling",
									"heading" 					=> __("Internal Paddings", "ts_visual_composer_extend"),
									"param_name" 				=> "segment_padding",
									"style_type"				=> "padding",
									"show_main"					=> "false",
									"show_preview"				=> "false",
									"show_width"				=> "true",
									"show_style"				=> "false",
									"show_radius" 				=> "false",					
									"show_color"				=> "false",
									"show_unit_width"			=> "false",
									"show_unit_radius"			=> "false",
									"label_width"				=> "",
									"override_all"				=> "false",
									"default_positions"			=> array(
										//"All"     					=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
										"Top"     						=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "5", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
										"Right"   						=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
										"Bottom"  						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "5", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
										"Left"    						=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
									),
									"description"       		=> __( "Define the internal paddings for the segment type you want to style.", "ts_visual_composer_extend" ),
								),
								array(
									"type" 						=> "advanced_styling",
									"heading" 					=> __("External Margins", "ts_visual_composer_extend"),
									"param_name" 				=> "segment_margin",
									"style_type"				=> "margin",
									"show_main"					=> "false",
									"show_preview"				=> "false",
									"show_width"				=> "true",
									"show_style"				=> "false",
									"show_radius" 				=> "false",					
									"show_color"				=> "false",
									"show_unit_width"			=> "false",
									"show_unit_radius"			=> "false",
									"label_width"				=> "",
									"override_all"				=> "false",
									"default_positions"			=> array(
										//"All"							=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px"),
										"Top"							=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "false"),
										"Right"							=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "true"),
										"Bottom"						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "false"),
										"Left"							=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#000000", "radius" => "0", "unitradius" => "px", "auto" => "true"),
									),
									"description"       		=> __( "Define the external margins for the segment type you want to style.", "ts_visual_composer_extend" ),
								),								
								array(
									"type" 						=> "advanced_styling",
									"heading" 					=> __("Border Settings", "ts_visual_composer_extend"),
									"param_name" 				=> "segment_border",
									"style_type"				=> "border",
									"show_main"					=> "false",
									"show_preview"				=> "true",
									"show_width"				=> "true",
									"show_style"				=> "true",
									"show_radius" 				=> "true",					
									"show_color"				=> "true",
									"show_unit_width"			=> "true",
									"show_unit_radius"			=> "true",
									"override_all"				=> "false",
									"default_positions"			=> array(
										//"All"							=> array("string" => __("All", "ts_visual_composer_extend"),	"width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
										"Top"							=> array("string" => __("Top", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
										"Right"							=> array("string" => __("Right", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
										"Bottom"						=> array("string" => __("Bottom", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
										"Left"							=> array("string" => __("Left", "ts_visual_composer_extend"),	"width" => "0", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
									),
									"description"       		=> __( "Define the border for the segment type you want to style.", "ts_visual_composer_extend" ),
								),								
							),							
						),
						// Shadow Effect
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_10",
                            "seperator"					=> "Shadow Effect",
							"dependency"        		=> array( 'element' => "background_type", 'value' => array('color', 'image', 'pattern', 'gradient', 'patternbolt') ),
							"group"						=> "Animation & Effects",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Shadow Effect", "ts_visual_composer_extend" ),
							"param_name"        		=> "effect_shadow",
							"width"             		=> 300,
							"value"             		=> array(
								__( "None", "ts_visual_composer_extend" )                          => "",
								__( "Lifted", "ts_visual_composer_extend" )                        => "lifted",
								__( "Raised", "ts_visual_composer_extend" )                        => "raised",
								__( "Perspective - Right", "ts_visual_composer_extend" )           => "perspective-right",
								__( "Perspective - Left", "ts_visual_composer_extend" )            => "perspective-left",
								__( "Curved - Horizontal", "ts_visual_composer_extend" )           => "curved",
								__( "Curved - Horizontal (Top)", "ts_visual_composer_extend" )     => "curved-top",
								__( "Curved - Horizontal (Bottom)", "ts_visual_composer_extend" )  => "curved-bottom",
								__( "Curved - Vertical", "ts_visual_composer_extend" )             => "curved-vertical",
								__( "Curved - Vertical (Left)", "ts_visual_composer_extend" )      => "curved-vertical-left",
								__( "Curved - Vertical (Right)", "ts_visual_composer_extend" )     => "curved-vertical-right",
							),
							"admin_label"				=> true,
							"description"       		=> __( "Select the shadow effect for the advanced textblock.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "background_type", 'value' => array('color', 'image', 'pattern', 'gradient', 'patternbolt') ),
							"group" 					=> "Animation & Effects",
						),
						// Viewport Animation
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_11",
                            "seperator"					=> "Viewport Animation",
							"group"						=> "Animation & Effects",
                        ),
						array(
							"type"						=> "css3animations",
							"class"						=> "",
							"heading"					=> __("Viewport Animation", "ts_visual_composer_extend"),
							"param_name"				=> "effect_viewportclass",
							"standard"					=> "false",
							"prefix"					=> "",
							"connector"					=> "effect_viewportname",
							"noneselect"				=> "true",
							"default"					=> "",
							"value"						=> "",
							"description"				=> __("Select the viewport animation for the advanced textblock.", "ts_visual_composer_extend"),
							"group"						=> "Animation & Effects",
						),
						array(
							"type"						=> "hidden_input",
							"heading"					=> __( "Viewport Animation", "ts_visual_composer_extend" ),
							"param_name"				=> "effect_viewportname",
							"value"						=> "",
							"description"				=> "",
							"admin_label"				=> true,
							"group"						=> "Animation & Effects",
						),
						array(
							"type" 						=> "viewport_offset",
							"class" 					=> "",
							"heading" 					=> __( "Viewport Offset", "ts_visual_composer_extend"),
							"param_name" 				=> "effect_viewportoffset",
							"value" 					=> 'bottom-in-view',
							"description" 				=> __("Define the offset (top of screen) that should trigger the viewport animation.", "ts_visual_composer_extend"),
							"dependency" 				=> array("element" => "effect_viewportclass", "not_empty" => true),
							"group"						=> "Animation & Effects",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Viewport Delay", "ts_visual_composer_extend" ),
							"param_name"        		=> "effect_viewportdelay",
							"value"             		=> "0",
							"min"               		=> "0",
							"max"               		=> "5000",
							"step"              		=> "100",
							"unit"              		=> 'ms',
							"description"       		=> "Define the delay in ms after which the animation should start, once initially triggered.",
							"dependency" 				=> array("element" => "effect_viewportclass", "not_empty" => true),
							"group"						=> "Animation & Effects",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Viewport Mobile", "ts_visual_composer_extend" ),
							"param_name"        		=> "effect_viewportmobile",
							"value"             		=> "false",
							"description"       		=> __( "Switch the toggle if you want to use the viewport animation on mobile devices.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" => "effect_viewportclass", "not_empty" => true),
							"group"						=> "Animation & Effects",
						),		
						// Other Settings
                        array(
                            "type"                      => "seperator",
                            "param_name"                => "seperator_12",
                            "seperator"					=> "Other Settings",
							"group"						=> "Other Settings",
                        ),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_id",
							"value"             		=> "",
							"description"       		=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_class",
							"value"             		=> "",
							"description"       		=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),						
                        // Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => "",
                            "param_name"                => "el_file1",
                            "value"                     => "",
                            "file_type"                 => "js",
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
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Advanced_Textblock extends WPBakeryShortCode {};
	}
	// Initialize "TS Advanced Textblock Element" Class
	if (class_exists('TS_VCSC_TextBlock_Element')) {
		$TS_VCSC_TextBlock_Element = new TS_VCSC_TextBlock_Element;
	}
?>