<?php
	if (!class_exists('TS_Anything_Slider')){
		class TS_Anything_Slider {
			function __construct() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('init',                                  array($this, 'TS_VCSC_Anything_Slider_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('init',                                  array($this, 'TS_VCSC_Anything_Slider_Elements'), 9999999);
					}
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('admin_init',							array($this, 'TS_VCSC_Anything_Slider_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('admin_init',							array($this, 'TS_VCSC_Anything_Slider_Elements'), 9999999);
					}
				}
				if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
					add_shortcode('TS_VCSC_Anything_Slider',				array($this, 'TS_VCSC_Anything_Slider'));
				}
			}
			
			// Register Element(s) via LeanMap
			function TS_VCSC_Anything_Slider_Lean() {
				vc_lean_map('TS_VCSC_Anything_Slider', 						array($this, 'TS_VCSC_Anything_Slider_Elements'), null);
			}
			
			// Anything Slider
			function TS_VCSC_Anything_Slider ($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();

				extract( shortcode_atts( array(
					'slider_type'					=> 'owlslider',					
					// Owl Slider Settings
					'number_teasers'				=> 1,
					'break_custom'					=> 'false',
					'break_string'					=> '1,2,3,4,5,6,7,8',
					'auto_height'                   => 'true',
					'page_rtl'						=> 'false',
					'auto_play'                     => 'false',
					'show_playpause'				=> 'true',
					'show_bar'                      => 'true',
					'bar_color'                     => '#dd3333',
					'show_speed'                    => 5000,
					'stop_hover'                    => 'true',
					'show_navigation'               => 'true',
					'show_dots'						=> 'true',
					'page_numbers'                  => 'false',
					'items_loop'					=> 'true',
					'items_center'					=> 'false',
					'slide_margin'					=> 10,
					'hash_navigation'				=> 'false',
					'hash_name'						=> 'anyhashname',					
					'animation_in'					=> 'ts-viewport-css-flipInX',
					'animation_out'					=> 'ts-viewport-css-slideOutDown',
					'animation_mobile'				=> 'false',
					// Slick Slider Settings
					'slickmain_lazyload'			=> 'false',
					'slickmain_vertical'			=> 'false',
					'slickmain_singlemode'			=> 'singlenone', 		// singlefade, singleroll, singlenone ... only if slick_thumbnails => nothumbs
					'slickmain_scrollitems'			=> 'single', 			// single, visible ... only if slick_singlemode => singlenone
					'slickmain_centermode'			=> 'false',				// only if slick_scrollitems => single
					'slickmain_initialitem'			=> 0,					//
					'slickmain_maxitems'			=> 3,					// only if slick_singlemode => singlenone
					'slickmain_spacing'				=> 10,					// only if slick_singlemode => singlenone
					'slickmain_breakpoints'			=> '1440/4,1280/3,1024/2,480/1',		// only if slick_singlemode => singlenone						
					'slickmain_infinite'			=> 'true',
					'slickmain_graylayer'			=> 'true',
					'slickmain_theme'				=> 'dark',
					'slickmain_wingshow'			=> 'true',				// only if slick_singlemode => singlenone or singleroll
					'slickmain_wingwidth'			=> 6,
					'slickmain_bullets'				=> 'true',				//
					'slickmain_autoplay'			=> 'false',				//
					'slickmain_interval'			=> 4000,				//
					'slickmain_rtlmode'				=> 'false',				//
					// Other Settings
					'margin_top'                    => 0,
					'margin_bottom'                 => 0,
					'el_id' 						=> '',
					'el_class'                  	=> '',
					'css'							=> '',
				), $atts ));
				
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
				
				$randomizer                    	= mt_rand(999999, 9999999);
				
				// Check for Front End Editor
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$owl_class						= 'owl-carousel2-edit';
					$slick_class					= 'slick-carousel-edit';
					$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
					$frontend_edit					= 'true';
				} else {
					$owl_class						= 'ts-owlslider-parent owl-carousel2';
					$slick_class					= 'ts-slickslider-parent slick-carousel';
					$slider_message					= '';
					$frontend_edit					= 'false';
				}
				if ($slider_type == "owlslider") {
					$slider_class					= $owl_class;
				} else if ($slider_type == "slickslider") {
					$slider_class					= $slick_class;
				}
				
				if (!empty($el_id)) {
					$any_slider_id			    	= $el_id;
				} else {
					$any_slider_id			    	= 'ts-vcsc-anyslider-' . $randomizer;
				}
				
				$output = '';
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-anyslider ' . $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Anything_Slider', $atts);
				} else {
					$css_class						= 'ts-vcsc-anyslider ' . $slider_class . ' ' . $el_class;
				}			
				
				if ($slider_type == "owlslider") {
					if ($frontend_edit == "false") {
						wp_enqueue_style('ts-font-ecommerce');
						wp_enqueue_style('ts-extend-animations');
						wp_enqueue_style('ts-extend-owlcarousel2');
						wp_enqueue_script('ts-extend-owlcarousel2');
					}
					$output .= '<div id="' . $any_slider_id . '-container" class="ts-vcsc-anyslider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						// Front-Edit Message
						if ($frontend_edit == "true") {
							$output .= $slider_message;
						}
						// Add Progressbar
						if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
							$output .= '<div id="ts-owlslider-progressbar-' . $randomizer . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
						}
						// Add Navigation Controls
						if ($frontend_edit == "false") {
							$output .= '<div id="ts-owlslider-controls-' . $randomizer . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
								$output .= '<div id="ts-owlslider-controls-next-' . $randomizer . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
								$output .= '<div id="ts-owlslider-controls-prev-' . $randomizer . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
								if (($auto_play == "true") && ($show_playpause == "true")) {
									$output .= '<div id="ts-owlslider-controls-play-' . $randomizer . '" class="ts-owlslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
								}
							$output .= '</div>';
						}
						// Add Slider
						$output .= '<div id="' . $any_slider_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-id="' . $randomizer . '" data-items="' . $number_teasers . '" data-hashlinks="' . $hash_navigation . '" data-hashname="' . $hash_name . '" data-breakpointscustom="' . $break_custom . '" data-breakpointitems="' . $break_string . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-center="' . $items_center . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '" data-margin="' . $slide_margin . '">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				}
				if ($slider_type == "slickslider") {
					if ($frontend_edit == "false") {
						wp_enqueue_style('ts-extend-slickslider');
						wp_enqueue_script('ts-extend-slickslider');
					}
					$slickthumb_data				= '';
					$slickmain_data					= 'data-frontendedit="' . $frontend_edit . '" data-asnavfor="" data-singlemode="' . $slickmain_singlemode . '" data-centermode="' . $slickmain_centermode . '" data-spacing="' . $slickmain_spacing . '" data-scrollitems="' . $slickmain_scrollitems . '" data-wingshow="' . $slickmain_wingshow . '" data-wingwidth="' . $slickmain_wingwidth . '" data-breakpoints="' . $slickmain_breakpoints . '" data-initialitem="' . $slickmain_initialitem . '" data-maxitems="' . $slickmain_maxitems . '" data-infinite="' . $slickmain_infinite . '" data-variable="true" data-adaptive="false" data-autoplay="' . $slickmain_autoplay . '" data-interval="' . $slickmain_interval . '" data-bullets="' . $slickmain_bullets . '" data-rtlmode="' . $slickmain_rtlmode . '"';
					$slickmain_filter				= '';
					$output .= '<div id="ts-slickslider-general-container-' . $randomizer . '-container" data-identifier="' . $randomizer . '" class="ts-slickslider-slider-container ts-slickslider-general-container ' . $css_class . ' ts-slickslider-movement-' . ($slickmain_vertical == "true" ? "vertical" : "horizontal") . ' ts-slickslider-direction-' . ($slickmain_rtlmode == "true" ? "rtl" : "ltr") . '" data-thumbnails="thumbsnone" ' . $slickmain_filter . '>';
						// Front-Edit Message
						if ($frontend_edit == "true") {
							$output .= $slider_message;
						}
						$output .= '<div id="ts-slickslider-general-slider-' . $randomizer . '" class="ts-slickslider-general-slider ts-slickslider-theme-' . $slickmain_theme . ' slick-slider ' . ($slickmain_graylayer == "true" ? "ts-slickslider-general-gray" : "") . '" ' . $slickmain_data . ' style="' . ($slickmain_bullets == "true" ? "margin-bottom: 40px;" : "") . '">';
							$output .= do_shortcode($content);
							if (($slickmain_centermode == "true") && ($slickmain_singlemode != "singlefade") && ($slickmain_wingshow == "true") && ($frontend_edit == "false")) {
								$output .= '<div id="ts-slickslider-general-wingleft-' . $randomizer . '" class="ts-slickslider-general-wings ts-slickslider-general-wingleft" style="width: ' . $slickmain_wingwidth . '%;"></div>';
								$output .= '<div id="ts-slickslider-general-wingright-' . $randomizer . '" class="ts-slickslider-general-wings ts-slickslider-general-wingright" style="width: ' . $slickmain_wingwidth . '%;"></div>';
							}
							if (($slickmain_autoplay == "true") && ($frontend_edit == "false")) {
								$output .= '<div id="ts-slickslider-general-autoplay-' . $randomizer . '" class="ts-slickslider-general-autoplay">';
									$output .= '<div id="ts-slickslider-general-start-' . $randomizer . '" class="ts-slickslider-general-start"></div>';
									$output .= '<div id="ts-slickslider-general-pause-' . $randomizer . '" class="ts-slickslider-general-pause"></div>';
								$output .= '</div>';
							}
						$output .= '</div>';
					$output .= '</div>';
				}

				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
		
			// Add Anything Slider Elements
			function TS_VCSC_Anything_Slider_Elements() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Anything Slider (Custom Build)
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name"                              => __("TS Almost Anything Slider", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_Anything_Slider",
					"class"                             => "",
					"icon"                              => "ts-composer-element-icon-anything-slider",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                       	=> array('except' => implode(",", $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_AnyLayout_Excluded)),
					"description"                       => __("Build a custom slider with almost any content", "ts_visual_composer_extend"),
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
							"param_name"                => "seperator_1",
							"seperator"					=> "Slider Settings",
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
							"message"            		=> __( "Not every element is suitable to be used inside another element, such as this slider, and not every element feature or style will work when used inside another element. Please select the elements you want to add to this slider carefully in order to avoid style or feature conflicts.", "ts_visual_composer_extend" ),
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),						
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Slider Type", "ts_visual_composer_extend" ),
							"param_name"            	=> "slider_type",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Owl Slider', "ts_visual_composer_extend" )					=> "owlslider",
								__( 'Slick Slider', "ts_visual_composer_extend" )				=> "slickslider",
							),
							"admin_label"		        => true,
							"description"           	=> __( "Select which slider script you want to use for this element.", "ts_visual_composer_extend" ),
						),						
						// Owl Slider Settings
						array(
							"type"                      => "seperator",
							"param_name"                => "seperator_2",
							"seperator"					=> "OwlSlider Settings",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("In-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_in",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_in",
							"default"					=> "flipInX",
							"value" 					=> "",
							"description" 				=> __("Select the CSS3 in-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"description"               => "",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),						
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("Out-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_out",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_out",
							"default"					=> "slideOutDown",
							"value" 					=> "",
							"description" 				=> __("Select the CSS3 out-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"description"               => "",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Animate on Mobile", "ts_visual_composer_extend" ),
							"param_name"                => "animation_mobile",
							"value"                     => "false",
							"description"               => __( "Switch the toggle if you want to show the CSS3 animations on mobile devices.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Height", "ts_visual_composer_extend" ),
							"param_name"                => "auto_height",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want the slider to auto-adjust its height.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Max. Number of Elements", "ts_visual_composer_extend" ),
							"param_name"                => "number_teasers",
							"value"                     => "1",
							"min"                       => "1",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of elements per slide.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),						
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Custom Number Settings", "ts_visual_composer_extend" ),
							"param_name"				=> "break_custom",
							"value"						=> "false",
							"description"				=> __( "Switch the toggle if you want to define different numbers of elements per slide for pre-defined slider widths.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Items per Slide", "ts_visual_composer_extend" ),
							"param_name"            	=> "break_string",
							"value"                 	=> "1,2,3,4,5,6,7,8",
							"description"           	=> __( "Define the number of items per slide based on the following slider widths: 0,360,720,960,1280,1440,1600,1920; seperate by comma (total of 8 values required).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "break_custom", 'value' => 'true' ),
							"group"						=> "OwlSlider Settings",
						),						
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Element Spacing", "ts_visual_composer_extend" ),
							"param_name"                => "slide_margin",
							"value"                     => "10",
							"min"                       => "0",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the spacing between slide elements (if more than one element is shown per slide).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "RTL Page", "ts_visual_composer_extend" ),
							"param_name"                => "page_rtl",
							"value"                     => "false",
							"description"               => __( "Switch the toggle if the slider is used on a page with RTL (Right-To-Left) alignment.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Play", "ts_visual_composer_extend" ),
							"param_name"                => "auto_play",
							"value"                     => "false",
							"description"               => __( "Switch the toggle if you want the auto-play the slider on page load.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Play / Pause", "ts_visual_composer_extend" ),
							"param_name"                => "show_playpause",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want to show a play / pause button to control the autoplay.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" => "true"),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Progressbar", "ts_visual_composer_extend" ),
							"param_name"                => "show_bar",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want to show a progressbar during auto-play.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "colorpicker",
							"heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
							"param_name"                => "bar_color",
							"value"                     => "#dd3333",
							"description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Auto-Play Speed", "ts_visual_composer_extend" ),
							"param_name"                => "show_speed",
							"value"                     => "5000",
							"min"                       => "1000",
							"max"                       => "20000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "Define the speed used to auto-play the slider.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play","value" 	=> "true"),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Stop on Hover", "ts_visual_composer_extend" ),
							"param_name"                => "stop_hover",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want the stop the auto-play while hovering over the slider.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "auto_play", 'value' => 'true' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Use Infinity Loop", "ts_visual_composer_extend" ),
							"param_name"                => "items_loop",
							"value"                     => "true",
							"description"               => __( "Switch the toggle to provide an inifnity loop, where last and first items get duplicated in order to get loop illusion.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Center Active Item", "ts_visual_composer_extend" ),
							"param_name"                => "items_center",
							"value"                     => "false",
							"description"               => __( "Switch the toggle to center the active item; works well with even and odd number of items.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),						
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Top Navigation", "ts_visual_composer_extend" ),
							"param_name"                => "show_navigation",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want to show left/right navigation buttons for the slider.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Dots", "ts_visual_composer_extend" ),
							"param_name"                => "show_dots",
							"value"                     => "true",
							"description"               => __( "Switch the toggle if you want to show dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),						
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Allow Hash Navigation", "ts_visual_composer_extend" ),
							"param_name"                => "hash_navigation",
							"value"                     => "false",							
							"description"               => __( "Switch the toggle if you want to allow the slider to be controlled via hashtag navigation links.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Define Hash Prefix", "ts_visual_composer_extend" ),
							"param_name"                => "hash_name",
							"value"                     => "anyhashname",
							"description"               => __( "Enter an unique prefix for the hashtag links to be applied to all slider elements. Each slide will use the prefix plus its numeric position in the slider (starting with 0), i.e. 'anyhashname0'.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "hash_navigation", 'value' => 'true' ),
							"group"						=> "OwlSlider Settings",
						),
						// Slick Slider Settings
						array(
							"type"                      => "seperator",
							"param_name"                => "seperator_3",
							"seperator"					=> "SlickSlider Settings",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 			        => "SlickSlider Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Display Mode", "ts_visual_composer_extend" ),
							"param_name"            	=> "slickmain_singlemode",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Multiple Slides', "ts_visual_composer_extend" )				=> "singlenone",
								__( 'Single Slides (Roll)', "ts_visual_composer_extend" )			=> "singleroll",
								__( 'Single Slides (Fade)', "ts_visual_composer_extend" )			=> "singlefade",
							),
							"description"           	=> __( "Select how the SlickSlider should display its slides.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Slides to Scroll", "ts_visual_composer_extend" ),
							"param_name"            	=> "slickmain_scrollitems",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Single Slide', "ts_visual_composer_extend" )					=> "single",
								__( 'Visible Slides', "ts_visual_composer_extend" )					=> "visible",
							),
							"description"           	=> __( "Select how many slides should be moved when used the next/previous navigation controls.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_singlemode", 'value' => 'singlenone' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use Center Mode", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_centermode",
							"value"						=> "false",
							"description"				=> __( "Switch the toggle if the slider should attempt to center the active slide among all visible slides.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_scrollitems", 'value' => 'single' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Slide Spacing", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_spacing",
							"value"						=> "10",
							"min"						=> "0",
							"max"						=> "30",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define the spacing (margin) between the slides.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_singlemode", 'value' => 'singlenone' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Initial Slide", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_initialitem",
							"value"						=> "0",
							"min"						=> "0",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> '',
							"description"				=> __( "Define the initial active slide; use 0 (zero) for the first slide.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_singlemode", 'value' => 'singlenone' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Maximum Number of Slides", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_maxitems",
							"value"						=> "3",
							"min"						=> "1",
							"max"						=> "10",
							"step"						=> "1",
							"unit"						=> '',
							"description"				=> __( "Define the maximum number of slides that can be visible at the same time.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_singlemode", 'value' => 'singlenone' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Slide Break Points", "ts_visual_composer_extend" ),
							"param_name"            	=> "slickmain_breakpoints",
							"value"                 	=> "1440/4,1280/3,1024/2,480/1",
							"description"           	=> __( "Define the break points (to determine slide count) for the slider based on available screen size; seperate by comma and assign the number of slider to each breakpoint using the '/' character.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_singlemode", 'value' => 'singlenone' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use Infinite Scroll", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_infinite",
							"value"						=> "true",
							"description"				=> __( "Switch the toggle if you want to use an infinite scroll with the slider (will automatically clone first and last slides).", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use Grayfilter", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_graylayer",
							"value"						=> "true",
							"description"				=> __( "Switch the toggle if you want to apply a gray filter to all non-current slides or thumbnails.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Slider Theme", "ts_visual_composer_extend" ),
							"param_name"            	=> "slickmain_theme",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Dark Theme', "ts_visual_composer_extend" )						=> "dark",
								__( 'Light Theme', "ts_visual_composer_extend" )					=> "light",
							),
							"description"           	=> __( "Select the overall color scheme for slider controls.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use Bullet Navigation", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_bullets",
							"value"						=> "true",
							"description"				=> __( "Switch the toggle if you want to provide bullets below the slider to directly navigate to slides.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use RTL Mode", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_rtlmode",
							"value"						=> "false",
							"description"				=> __( "Switch the toggle if you want to use the slider on a page in RTL layout.", "ts_visual_composer_extend" ),
							"edit_field_class"			=> "vc_col-sm-6 vc_column",
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Use AutoPlay Mode", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_autoplay",
							"value"						=> "false",
							"description"				=> __( "Switch the toggle if you want to use the slider in auto-play mode.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slider_type", 'value' => 'slickslider' ),
							"group" 					=> "SlickSlider Settings"
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "AutoPlay Speed", "ts_visual_composer_extend" ),
							"param_name"				=> "slickmain_interval",
							"value"						=> "4000",
							"min"						=> "1000",
							"max"						=> "20000",
							"step"						=> "100",
							"unit"						=> '',
							"description"				=> __( "Define the interval (speed) at which the slider should auto-play to the next slide.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "slickmain_autoplay", 'value' => 'true' ),
							"group" 					=> "SlickSlider Settings"
						),
						// Other Settings
						array(
							"type"                      => "seperator",
							"param_name"                => "seperator_4",
							"seperator"					=> "Other Settings",
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
							"param_name"                => "el_file1",
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
		class WPBakeryShortCode_TS_VCSC_Anything_Slider extends WPBakeryShortCodesContainer {};
	}
	// Initialize "TS Anything Slider" Class
	if (class_exists('TS_Anything_Slider')) {
		$TS_Anything_Slider = new TS_Anything_Slider;
	}
?>