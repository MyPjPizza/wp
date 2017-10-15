<?php
	// Class for Visual Composer Element
    if (!class_exists('TS_VCSC_VCWidgets_Element')){
        class TS_VCSC_VCWidgets_Element {
            function __construct() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
                        add_action('init',                                  array($this, 'TS_VCSC_Add_VCWidget_Lean'), 9999999);
                    } else if (function_exists('vc_map')) {
                        add_action('init',                                  array($this, 'TS_VCSC_Add_VCWidget_Elements'), 9999999);
                    }
                } else {
                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
                        add_action('admin_init',							array($this, 'TS_VCSC_Add_VCWidget_Lean'), 9999999);
                    } else if (function_exists('vc_map')) {
                        add_action('admin_init',							array($this, 'TS_VCSC_Add_VCWidget_Elements'), 9999999);
                    }
                }
                if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
                    add_shortcode('TS_VCSC_VCWidget_Output',				array($this, 'TS_VCSC_VCWidget_Output_Function'));
					add_shortcode('TS_VCSC_VCWidget_Direct',				array($this, 'TS_VCSC_VCWidget_Direct_Function'));
					TS_VCSC_Element_Widget_CSS::load();
                }                
            }
            
            // Register Element(s) via LeanMap
            function TS_VCSC_Add_VCWidget_Lean() {
                vc_lean_map('TS_VCSC_VCWidget_Output',						array($this, 'TS_VCSC_Add_VCWidget_Elements'), null);
            }
            
            // Convert all Outer Rows/Columns to Inner Rows/Columns
            function TS_VCSC_VCWidget_RowConverter($search, $replace, $subject) {
                return strtr($subject, array_combine($search, $replace));
            }
            
            // Output of VC Widgets Post Type via Element
            function TS_VCSC_VCWidget_Output_Function($atts, $content = null) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                global $shortcode_tags;
                ob_start();
                
				extract( shortcode_atts( array(
					'widgets_id'			        => '',
					'custompost_name'		        => '',
                    'content_unwrap'                => 'remove',
					'content_wpautop'				=> 'false',
					'margin_top'			        => 0,
					'margin_bottom'			        => 0,
					'el_id' 				        => '',
					'el_class'                      => '',
					'css'					        => '',
				), $atts ));
                
                $output								= '';
                $wpautop 							= ($content_wpautop == "true" ? true : false);
                
				// Check for Widget / Template and End Shortcode if Empty
				if (empty($widgets_id)) {
					$output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please select a VC Widget / Template in the element settings!</div>';
					echo $output;
					$myvariable = ob_get_clean();
					return $myvariable;
				}
                
                // Check for Frontend Editor
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$templateLink 					= str_replace(get_the_ID(), $widgets_id, get_edit_post_link());
					$output .= '<div style="border: 1px solid #ededed; padding: 10px; margin: 0;">';
						$output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">The content of this element has been created via the custom "VC Widgets" post type and can NOT be edited directly via the frontend editor.</div>';
						$output .= '<span style="display: block;">Widget / Template ID: ' . $widgets_id . '</span>';
						$output .= '<span style="display: block;">Widget / Template Name: ' . $custompost_name . '</span>';
						$output .= '<span style="display: block;"><a href="' . $templateLink . '" target="_blank">Edit VC Widget / Template</a></span>';
					$output .= '</div>';
					echo $output;
					$myvariable = ob_get_clean();
					return $myvariable;
                }
                
				// Retrieve VC Widgets Post Main Content
				$widget_array						= array();
				$args = array(
					'no_found_rows' 				=> 1,
					'ignore_sticky_posts' 			=> 1,
					'posts_per_page' 				=> -1,
					'post_type' 					=> 'ts_widgets',
					'post_status' 					=> 'publish',
					'orderby' 						=> 'title',
					'order' 						=> 'ASC',
				);
				$widget_query                       = new WP_Query($args);
				if ($widget_query->have_posts()) {
					foreach($widget_query->posts as $p) {
						if ($p->ID == $widgets_id) {
							$widget_data = array(
								'author'			=> $p->post_author,
								'name'				=> $p->post_name,
								'title'				=> $p->post_title,
								'id'				=> $p->ID,
								'content'			=> $p->post_content,
							);
							$widget_array[]         = $widget_data;
                            break;
						}
					}
				}
				wp_reset_postdata();
                
				// Build VC Widgets Post Main Content
				foreach ($widget_array as $index => $array) {
					$Widget_Title 					= $widget_array[$index]['title'];
					$Widget_ID 						= $widget_array[$index]['id'];
					$Widget_Content 				= $widget_array[$index]['content'];
				}                
                
				// Render VC Custom CSS Styling Parameter
				if (!TS_VCSC_Element_Widget_CSS::exists($Widget_ID)) {
					$design_options = TS_VCSC_Element_Widget_GetMeta($Widget_ID, '_wpb_post_custom_css');
					$design_options.= TS_VCSC_Element_Widget_GetMeta($Widget_ID, '_wpb_shortcodes_custom_css');
					TS_VCSC_Element_Widget_CSS::add($design_options, $Widget_ID);
				}
                
                // Row/Columns Removal/Replacement
                if ($content_unwrap == "remove") {
                    $codes_regex                    = get_shortcode_regex();
                    $codes_allowable                = array();
                    $codes_excluded                 = array('vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner');
                    foreach($shortcode_tags as $code => $function) {
                        if (!in_array($code, $codes_excluded)) {
                            array_push($codes_allowable, $code);
                        }
                    }
                    $codes_allowable                = implode("|", $codes_allowable);
                    $Widget_Content                 = preg_replace("~(?:\[/?)(?!(?:$codes_allowable))[^/\]]+/?\]~s", '', $Widget_Content);
                } else if ($content_unwrap == "replace") {
                    $codes_search                   = array('[vc_row ', '[vc_row]', '[vc_column ', '[vc_column]', '[/vc_row]', '[/vc_column]');
                    $codes_replace                  = array('[vc_row_inner ', '[vc_row_inner]', '[vc_column_inner ', '[vc_column_inner]', '[/vc_row_inner]', '[/vc_column_inner]');
                    $Widget_Content                 = $this->TS_VCSC_VCWidget_RowConverter($codes_search, $codes_replace, $Widget_Content);
                }

                // Render Final Widget Output
				if (function_exists('wpb_js_remove_wpautop')){
					echo wpb_js_remove_wpautop(do_shortcode($Widget_Content), $wpautop);
				} else {
					echo do_shortcode($Widget_Content);
				}
                
                $myvariable = ob_get_clean();
                return $myvariable;
            }            
            function TS_VCSC_VCWidget_Direct_Function($atts, $content = null) {
				
			}
			
			// Register VC Widgets Post Type Element
            function TS_VCSC_Add_VCWidget_Elements() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                // Add VC Widget Element
                $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
                    "name"                              => __( "TS VC Template", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_VCWidget_Output",
                    "icon" 	                            => "ts-composer-element-icon-vcwidgets",
                    "class"                             => "ts_vcsc_main_widgets_output",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Output a VC Template (Widget) post", "ts_visual_composer_extend"),
					"js_view"     						=> "TS_VCSC_VCWidgetTemplateViewCustom",
					//"front_enqueue_js"				=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-widget-template.min.js')),
                    "admin_enqueue_js"            		=> "",
                    "admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // VC Widgets Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => "",
                            "param_name"                => "seperator_1",
                            "value"						=> "",
                            "seperator"					=> "VC Widget Content",
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
							"message"            		=> __( "For best layout results, please use only VC Widgets posts that do not utilize nested rows and/or columns; neither should this element by itself be embedded in a nested row.", "ts_visual_composer_extend" ),
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),                        
                        array(
                            "type"                      => "custompost",
                            "heading"                   => __( "VC Widget / Template Output", "ts_visual_composer_extend" ),
                            "param_name"                => "widgets_id",
                            "posttype"                  => "ts_widgets",
                            "posttaxonomy"              => "ts_widgets_category",
                            "taxonomy"              	=> "ts_widgets_category",
                            "postsingle"				=> "VC Widget",
                            "postplural"				=> "VC Widgets",
                            "postclass"					=> "widget",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "hidden_input",
                            "heading"                   => __( "VC Widget Name", "ts_visual_composer_extend" ),
                            "param_name"                => "custompost_name",
                            "value"                     => "",
                            "admin_label"		        => true,
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "hidden_input",
                            "heading"                   => __( "VC Widget Link", "ts_visual_composer_extend" ),
                            "param_name"                => "custompost_link",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Content Processing", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_unwrap",
							"width"             		=> 150,
							"value"             		=> array(								
								__( "Remove All Rows + Columns", "ts_visual_composer_extend" )                  => "remove",
								__( "Replace Outer Rows/Columns with Inner", "ts_visual_composer_extend" )      => "replace",
                                __( "No Changes", "ts_visual_composer_extend" )                                 => "none",
							),
                            "admin_label"		        => true,
							"description"       		=> __( "Select if and how the widget content should be pre-processed before getting embedded into this page or post.", "ts_visual_composer_extend" ),
						),                        
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => "",
                            "param_name"                => "seperator_2",
                            "value"						=> "",
                            "seperator"					=> "Other Settings",
                            "description"               => "",
                            "group"                     => "Other Settings"
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
                            "group"                     => "Other Settings"
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
                            "group"                     => "Other Settings"
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
                            "param_name"                => "el_id",
                            "value"                     => "",
                            "description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
                            "group"                     => "Other Settings"
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
                            "param_name"                => "el_class",
                            "value"                     => "",
                            "description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
                            "group"                     => "Other Settings"
                        ),
                        // Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => "",
                            "param_name"                => "el_file",
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
		class WPBakeryShortCode_TS_VCSC_VCWidget_Output extends WPBakeryShortCode {};
	}
	// Initialize "TS VC Widgets Element" Class
	if (class_exists('TS_VCSC_VCWidgets_Element')) {
		$TS_VCSC_VCWidgets_Element = new TS_VCSC_VCWidgets_Element;
	}
?>