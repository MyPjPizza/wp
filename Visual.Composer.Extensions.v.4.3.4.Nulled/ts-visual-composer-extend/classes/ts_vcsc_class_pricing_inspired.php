<?php
	if (!class_exists('TS_InspiredPricing')){
		class TS_InspiredPricing {
			function __construct() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('init',                                  array($this, 'TS_VCSC_Add_InspiredPricing_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('init',									array($this, 'TS_VCSC_Add_InspiredPricing_Element_Container'), 9999999);
						add_action('init',									array($this, 'TS_VCSC_Add_InspiredPricing_Element_Item'), 9999999);
						add_action('init',									array($this, 'TS_VCSC_Add_InspiredPricing_Element_Single'), 9999999);
					}
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('admin_init',							array($this, 'TS_VCSC_Add_InspiredPricing_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('admin_init',							array($this, 'TS_VCSC_Add_InspiredPricing_Element_Container'), 9999999);
						add_action('admin_init',							array($this, 'TS_VCSC_Add_InspiredPricing_Element_Item'), 9999999);
						add_action('admin_init',							array($this, 'TS_VCSC_Add_InspiredPricing_Element_Single'), 9999999);
					}
				}
				if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
					add_shortcode('TS_VCSC_InspiredPricing_Item',			array($this, 'TS_VCSC_InspiredPricing_Item'));
					add_shortcode('TS_VCSC_InspiredPricing_Container',		array($this, 'TS_VCSC_InspiredPricing_Container'));
					add_shortcode('TS_VCSC_InspiredPricing_Single',			array($this, 'TS_VCSC_InspiredPricing_Single'));
				}
			}
			
			// Register Element(s) via LeanMap
			function TS_VCSC_Add_InspiredPricing_Lean() {
				vc_lean_map('TS_VCSC_InspiredPricing_Container', 			array($this, 'TS_VCSC_Add_InspiredPricing_Element_Container'), null);
				vc_lean_map('TS_VCSC_InspiredPricing_Item', 				array($this, 'TS_VCSC_Add_InspiredPricing_Element_Item'), null);
				vc_lean_map('TS_VCSC_InspiredPricing_Single', 				array($this, 'TS_VCSC_Add_InspiredPricing_Element_Single'), null);
			}
			
			// Function to Render Inner Table Syntax
			function TS_VCSC_InspiredPricing_Inner($table_style, $table_title, $table_currency, $table_cost, $table_period, $table_message, $table_icon, $content, $wpautop, $button_text) {
				$output 						= '';
				if (($table_style == "sonam") || ($table_style == "jinpa")) {
					if ($table_icon != '') {
						$output .= '<div class="ts-pricing-inspired-icon ' . $table_icon . '"></div>';
					}
					if ($table_title != '') {
						$output .= '<h3 class="ts-pricing-inspired-title">' . $table_title . '</h3>';
					}
					$output .= '<div class="ts-pricing-inspired-price"><span class="ts-pricing-inspired-currency">' . $table_currency . '</span>' . $table_cost . '</div>';
					if ($table_period != '') {
						$output .= '<div class="ts-pricing-inspired-period">' . $table_period . '</div>';
					}
					if ($table_message != '') {
						$output .= '<div class="ts-pricing-inspired-message">' . $table_message . '</div>';
					}
				} else if ($table_style == "tenzin") {
					if ($table_icon != '') {
						$output .= '<div class="ts-pricing-inspired-icon ' . $table_icon . '"></div>';
					}
					if ($table_title != '') {
						$output .= '<h3 class="ts-pricing-inspired-title">' . $table_title . '</h3>';
					}
					$output .= '<div class="ts-pricing-inspired-price"><span class="ts-pricing-inspired-currency">' . $table_currency . '</span>' . $table_cost . '<span class="ts-pricing-inspired-period">' . $table_period . '</span></div>';
					if ($table_message != '') {
						$output .= '<div class="ts-pricing-inspired-message">' . $table_message . '</div>';
					}
				} else if ($table_style == "rabten") {
					if ($table_icon != '') {
						$output .= '<div class="ts-pricing-inspired-icon ' . $table_icon . '"></div>';
					}
					if ($table_title != '') {
						$output .= '<h3 class="ts-pricing-inspired-title">' . $table_title . '</h3>';
					}
					if ($table_message != '') {
						$output .= '<p class="ts-pricing-inspired-message">' . $table_message . '</p>';
					}
					$output .= '<div class="ts-pricing-inspired-price">';
						$output .= '<span class="ts-pricing-inspired-animation ts-pricing-inspired-animation-1"><span class="ts-pricing-inspired-currency">' . $table_currency . '</span>' . $table_cost . '</span>';
						if ($table_period != '') {
							$output .= '<span class="ts-pricing-inspired-animation ts-pricing-inspired-animation-2"><span class="ts-pricing-inspired-period">' . $table_period . '</span></span>';
						}
					$output .= '</div>';
				} else if (($table_style == "yama") || ($table_style == "yonten") || ($table_style == "dawa") || ($table_style == "norbu") || ($table_style == "karma") || ($table_style == "pema") || ($table_style == "tashi")) {
					if ($table_icon != '') {
						$output .= '<div class="ts-pricing-inspired-icon ' . $table_icon . '"></div>';
					}
					if ($table_title != '') {
						$output .= '<h3 class="ts-pricing-inspired-title">' . $table_title . '</h3>';				
					}
					if ($table_message != '') {
						$output .= '<div class="ts-pricing-inspired-message">' . $table_message . '</div>';
					}
					$output .= '<div class="ts-pricing-inspired-price"><span class="ts-pricing-inspired-currency">' . $table_currency . '</span>' . $table_cost . '<span class="ts-pricing-inspired-period">' . $table_period . '</span></div>';
				} else if ($table_style == "palden") {
					$output .= '<div class="ts-pricing-inspired-decoration">';
						$output .= '<svg class="ts-pricing-inspired-imagesvg" version="1.1" id="Layer_1" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100px" viewBox="0 0 300 100" enable-background="new 0 0 300 100" xml:space="preserve">';
							$output .= '<path class="ts-pricing-inspired-decolayer ts-pricing-inspired-decolayer-1" opacity="0.50" fill="transparent" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" />';
							$output .= '<path class="ts-pricing-inspired-decolayer ts-pricing-inspired-decolayer-2" opacity="0.50" fill="transparent" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" />';
							$output .= '<path class="ts-pricing-inspired-decolayer ts-pricing-inspired-decolayer-3" opacity="0.75" fill="transparent" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716H42.401L43.415,98.342z" />';
							$output .= '<path class="ts-pricing-inspired-decolayer ts-pricing-inspired-decolayer-4" opacity="1.00" fill="transparent" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" />';
						$output .= '</svg>';
						$output .= '<div class="ts-pricing-inspired-price"><span class="ts-pricing-inspired-currency">' . $table_currency . '</span>' . $table_cost . '<span class="ts-pricing-inspired-period">' . $table_period . '</span></div>';
						if ($table_title != '') {
							$output .= '<h3 class="ts-pricing-inspired-title">' . $table_title . '</h3>';
						}
						if ($table_message != '') {
							$output .= '<div class="ts-pricing-inspired-message">' . $table_message . '</div>';
						}
					$output .= '</div>';
					if ($table_icon != '') {
						$output .= '<div class="ts-pricing-inspired-icon ' . $table_icon . '"></div>';
					}
				}
				// Process Table Content
				$output .= '<div class="ts-pricing-inspired-featurelist">';
					if (!function_exists('wpb_js_remove_wpautop')){
						$output .= do_shortcode(wpb_js_remove_wpautop($content, $wpautop));
					} else {
						$output .= do_shortcode($content);
					}
				$output .= '</div>';
				return $output;
			}
			
			// Function to Render Table Button
			function TS_VCSC_InspiredPricing_Button($randomizer, $table_style, $scroll_navigate, $scroll_target, $scroll_offset, $scroll_speed, $scroll_effect, $scroll_hashtag, $button_link, $button_text) {
				$output								= '';
				// Link Values
				if (($scroll_navigate == "true") && ($scroll_target != '')) {
					$scroll_target					= str_replace("#", "", $scroll_target);
					$a_href							= "#" . $scroll_target;
					$a_title 						= "";
					$a_target 						= "_parent";
				} else {
					$link 							= TS_VCSC_Advancedlinks_GetLinkData($button_link);
					$a_href							= $link['url'];
					$a_title 						= $link['title'];
					$a_target 						= $link['target'];
				}
				// Button Classes
				if (($scroll_navigate == "true") && ($scroll_target != '')) {			
					$scroll_offset 					= explode(';', $scroll_offset);			
					$offsetDesktop					= explode(':', $scroll_offset[0]);
					$offsetDesktop					= str_replace("px", "", $offsetDesktop[1]);
					$offsetTablet					= explode(':', $scroll_offset[1]);
					$offsetTablet					= str_replace("px", "", $offsetTablet[1]);
					$offsetMobile					= explode(':', $scroll_offset[2]);
					$offsetMobile					= str_replace("px", "", $offsetMobile[1]);			
					$scroll_class					= 'ts-button-page-navigator';			
					$scroll_data					= 'data-scroll-target="' . $scroll_target . '" data-scroll-speed="' . $scroll_speed . '" data-scroll-effect="' . $scroll_effect . '" data-scroll-offsetdesktop="' . $offsetDesktop . '" data-scroll-offsettablet="' . $offsetTablet . '" data-scroll-offsetmobile="' . $offsetMobile . '" data-scroll-hashtag="' . $scroll_hashtag . '"';
				} else {
					$scroll_class					= '';
					$scroll_data					= '';
				}
				// Load Easing Script				
				if (($scroll_navigate == "true") && ($scroll_target != '')) {
					wp_enqueue_script('jquery-easing');
				}				
				// Process Table Link/Button
				if ($a_href != '') {
					if ($table_style == "tashi") {
						$output .= '<a href="' . esc_url($a_href) . '" target="' .esc_attr($a_target) . '" id="ts-pricing-inspired-buttondefault-' . $randomizer . '" class="ts-pricing-inspired-buttondefault ' . $scroll_class . '" title="' . esc_attr($a_title) . '" data-text="' . $button_text . '" ' . $scroll_data . '><span class="ts-ecommerce-arrowright7"></span></a>';
					} else {
						$output .= '<a href="' . esc_url($a_href) . '" target="' .esc_attr($a_target) . '" id="ts-pricing-inspired-buttondefault-' . $randomizer . '" class="ts-pricing-inspired-buttondefault ' . $scroll_class . '" title="' . esc_attr($a_title) . '" data-text="' . $button_text . '" ' . $scroll_data . '>' . $button_text . '</a>';
					}
				}
				return $output;
			}
			
			// Function to Enqueue + Load Default Fonts
			function TS_VCSC_InspiredPricing_Fonts ($table_style) {
				// Enqueue Font based on Style
				if ($table_style == "jinpa") {
					wp_enqueue_style('ts-font-sahitya', 			'https://fonts.googleapis.com/css?family=Sahitya:400,700', null, false, 'all');
				} else if ($table_style == "pema") {
					wp_enqueue_style('ts-font-alegreya+sans', 		'https://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,800', null, false, 'all');
				} else if ($table_style == "dawa") {
					wp_enqueue_style('ts-font-homemade+apple', 		'https://fonts.googleapis.com/css?family=Homemade+Apple', null, false, 'all');
				} else if ($table_style == "tashi") {
					wp_enqueue_style('ts-font-roboto+condensed', 	'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700', null, false, 'all');
				} else if ($table_style == "palden") {
					wp_enqueue_style('ts-font-nunito', 				'https://fonts.googleapis.com/css?family=Nunito:400,300,700', null, false, 'all');
				} else if ($table_style == "rabten") {
					wp_enqueue_style('ts-font-roboto', 				'https://fonts.googleapis.com/css?family=Roboto:400,700', null, false, 'all');
				} else if ($table_style == "yonten") {
					wp_enqueue_style('ts-font-pt-sans', 			'https://fonts.googleapis.com/css?family=PT+Sans:400,700', null, false, 'all');	
				} else if ($table_style == "yama") {
					wp_enqueue_style('ts-font-playfair+display', 	'https://fonts.googleapis.com/css?family=Playfair+Display:900', null, false, 'all');		
				}				
			}
	
			// Single Inspired Pricing Table Item
			function TS_VCSC_InspiredPricing_Single ($atts, $content = null) {
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				extract( shortcode_atts( array(
					'table_style'					=> 'sonam',
					'table_type'					=> 'standard',
					'table_title'					=> 'Recommended',
					'table_currency'				=> '$',
					'table_cost'					=> '20',
					'table_period'					=> 'per month',
					'table_message'					=> '',
					'table_icon'					=> '',
					'table_wpautop'					=> 'false',
					'table_defaults'				=> 'true',
					'table_effect'					=> 'none',
					'table_radius'					=> 'none',
					'table_widthmax'				=> 'none',
					'table_widthpercent'			=> 100,
					'table_widthpixels'				=> 320,
					// Button Settings
					'button_type'					=> 'default',
					'button_link'					=> '',
					'button_text'					=> 'Purchase',
					'button_custom'					=> '',
					// Scroll Settings
					'scroll_navigate'				=> 'false',
					'scroll_target'					=> '',
					'scroll_speed'					=> 2000,
					'scroll_effect'					=> 'linear',
					'scroll_offset'					=> 'desktop:0px;tablet:0px;mobile:0px',
					'scroll_hashtag'				=> 'false',
					// Other Settings
					'margin_top'					=> 0,
					'margin_bottom'					=> 0,
					'el_id'							=> '',
					'el_class'						=> '',
					'css'							=> '',
				), $atts ) );
				
				wp_enqueue_style('ts-font-ecommerce');
				wp_enqueue_style('ts-extend-pricinginspired');
				
				// Load Default Fonts
				if ($table_defaults == "true") {
					$this->TS_VCSC_InspiredPricing_Fonts($table_style);
				}
				
				$randomizer							= mt_rand(999999, 9999999);
				$output 							= '';
				$styles								= '';
				$wpautop 							= ($table_wpautop == "true" ? true : false);
				$class								= '';
				
				// Determine Maximum Width
				if ($table_widthmax == "none") {
					$maxwidth						= 'max-width: none;';
				} else if ($table_widthmax == "percent") {
					$maxwidth						= 'max-width: ' . $table_widthpercent . '%;';
				} else if ($table_widthmax == "pixels") {
					$maxwidth						= 'max-width: ' . $table_widthpixels . 'px;';
				}

				// Determine Table ID
				if (!empty($el_id)) {
					$pricetable_id					= $el_id;
				} else {
					$pricetable_id					= 'ts-pricing-inspired-single-' . $randomizer;
				}

				if ($table_type == "intro") {
					$button_type					= "none";
					if (($table_icon == '') || ($table_icon == 'none') || ($table_icon == 'blank')) {
						$table_icon					= '';
					}
				}
				
				$class_standard						= ($table_type == "standard" ? "ts-pricing-inspired-standard" : "");
				$class_featured						= ($table_type == "featured" ? "ts-pricing-inspired-featured" : "");
				$class_intro						= ($table_type == "intro" ? "ts-pricing-inspired-intro" : "");
				$class_effect						= 'ts-pricing-inspired-' . $table_effect;
				$class_radius						= 'ts-pricing-inspired-radius-' . $table_radius;
				
				// Visual Composer CSS Filter Override
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_InspiredPricing_Single', $atts);
				} else {
					$css_class						= '';
				}		
				
				// Create Table Output
				$output .= '<div id="' . $pricetable_id . '" class="ts-pricing-inspired-table ' . $css_class . ' ts-pricing-inspired-global ts-pricing-inspired-' . $table_style . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $maxwidth . '">';
					$output .= '<div class="ts-pricing-inspired-item ' . $class_standard . ' ' . $class_featured . ' ' . $class_intro . ' ' . $class_effect . ' ' . $class_radius . '" data-style="' . $table_style . '">';
						$output .= $this->TS_VCSC_InspiredPricing_Inner($table_style, $table_title, $table_currency, $table_cost, $table_period, $table_message, $table_icon, $content, $wpautop, $button_text);
						if ($button_type == "default") {
							$output .= $this->TS_VCSC_InspiredPricing_Button($randomizer, $table_style, $scroll_navigate, $scroll_target, $scroll_offset, $scroll_speed, $scroll_effect, $scroll_hashtag, $button_link, $button_text);
						} else if ($button_type == "custom") {
							$output .= '<div class="ts-pricing-inspired-buttoncustom">';
								$output .= rawurldecode(base64_decode(strip_tags($button_custom)));
							$output .= '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			
			// Inspired Pricing Tables Container
			function TS_VCSC_InspiredPricing_Container ($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				extract( shortcode_atts( array(
					// Table Settings
					'table_style'					=> 'sonam',
					'table_width'					=> 320,
					'table_wpautop'					=> 'false',
					'table_defaults'				=> 'true',
					'table_margins'					=> 'false',
					'table_lineadjust'				=> 'false',
					'table_lineheight'				=> 24,
					// Font Settings
					'title_family'					=> 'Default:regular',
					'title_type'					=> '',					
					'message_family'				=> 'Default:regular',
					'message_type'					=> '',
					'price_family'					=> 'Default:regular',
					'price_type'					=> '',
					'features_family'				=> 'Default:regular',
					'features_type'					=> '',
					'button_family'					=> 'Default:regular',
					'button_type'					=> '',
					// Other
					'margin_top'                    => 0,
					'margin_bottom'                 => 0,
					'el_id' 						=> '',
					'el_class'                  	=> '',
					'css'							=> '',
				), $atts ));
				
				// Check for Front End Editor
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$frontend_edit					= 'true';
				} else {
					$frontend_edit					= 'false';
				}
				
				wp_enqueue_style('ts-font-ecommerce');
				wp_enqueue_style('ts-extend-pricinginspired');
				
				// Load Default Fonts
				if ($table_defaults == "true") {
					$this->TS_VCSC_InspiredPricing_Fonts($table_style);
				}
				
				$randomizer							= mt_rand(999999, 9999999);
				$output 							= '';
				$styles								= '';
				$wpautop 							= ($table_wpautop == "true" ? true : false);
				
				if (!empty($el_id)) {
					$inspired_id					= $el_id;
				} else {
					$inspired_id					= 'ts-pricing-inspired-container-' . $randomizer;
				}
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-pricing-inspired-container ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_InspiredPricing_Container', $atts);
				} else {
					$css_class						= 'ts-pricing-inspired-wrap ' . $el_class;
				}
				
				// Remove Any Stored Style Attributes
				$content 							= preg_replace('/ table_style="[\s\S]+?"/', '', $content);
				$content 							= preg_replace("/ table_style='[\s\S]+?'/", "", $content);
				// Inject Inspired Style to Tables as New Attribute
				$replace_search						= '[TS_VCSC_InspiredPricing_Item ';
				$replace_replace					= '[TS_VCSC_InspiredPricing_Item table_style="' . $table_style . '" ';
				$replace_subject					= $content;
				$content  							= str_replace($replace_search, $replace_replace, $replace_subject);

				// Create Custom Styling
				$styles .= '<style id="ts-pricing-inspired-styles-' . $randomizer . '-styles" type="text/css">';
					$styles .= 'body #' . $inspired_id . '.ts-pricing-inspired-' . $table_style . ' .ts-pricing-inspired-item {';
						$styles .= '-webkit-flex: 0 1 ' . $table_width . 'px;';
						$styles .= '-moz-flex: 0 1 ' . $table_width . 'px;';
						$styles .= '-ms-flex: 0 1 ' . $table_width . 'px;';
						$styles .= '-o-flex: 0 1 ' . $table_width . 'px;';
						$styles .= 'flex: 0 1 ' . $table_width . 'px;';					
						if ($table_margins == "true") {
							$styles .= 'margin: 0 !important;';		
						}
					$styles .= '}';
					if ($table_lineadjust == "true") {
						$styles .= 'body #' . $inspired_id . '.ts-pricing-inspired-' . $table_style . ' .ts-pricing-inspired-featurelist ul li {';
							$styles .= 'line-height: ' . $table_lineheight . 'px;';
						$styles .= '}';
					}
				$styles .= '</style>';
				
				// Create Final Output
				$output .= TS_VCSC_MinifyCSS($styles);
				$output .= '<div id="' . $inspired_id . '" class="' . $css_class . ' clearFixMe ts-pricing-inspired-' . $table_style . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					if (function_exists('wpb_js_remove_wpautop')){
						$output .= wpb_js_remove_wpautop(do_shortcode($content), $wpautop);
					} else {
						$output .= do_shortcode($content);
					}
				$output .= '</div>';

				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			
			// Inspired Pricing Tables Item
			function TS_VCSC_InspiredPricing_Item ($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				extract( shortcode_atts( array(
					'table_style'					=> 'inherit',
					'table_type'					=> 'standard',
					'table_title'					=> 'Recommended',
					'table_currency'				=> '$',
					'table_cost'					=> '20',
					'table_period'					=> 'per month',
					'table_message'					=> '',
					'table_icon'					=> '',
					'table_wpautop'					=> 'false',
					'table_effect'					=> 'none',
					'table_radius'					=> 'none',
					// Button Settings
					'button_type'					=> 'default',
					'button_link'					=> '',
					'button_text'					=> 'Purchase',
					'button_custom'					=> '',
					// Scroll Settings
					'scroll_navigate'				=> 'false',
					'scroll_target'					=> '',
					'scroll_speed'					=> 2000,
					'scroll_effect'					=> 'linear',
					'scroll_offset'					=> 'desktop:0px;tablet:0px;mobile:0px',
					'scroll_hashtag'				=> 'false',
					// Other Settings
					'css'							=> '',
				), $atts ) );
				
				$randomizer							= mt_rand(999999, 9999999);
				$output 							= '';
				$styles								= '';
				$wpautop 							= ($table_wpautop == "true" ? true : false);
				$class								= '';
		
				// Determine Table ID
				$pricetable_id						= 'ts-pricing-inspired-item-' . $randomizer;
				
				if ($table_type == "intro") {
					$button_type					= "none";
					if (($table_icon == '') || ($table_icon == 'none') || ($table_icon == 'blank')) {
						$table_icon					= '';
					}
				}
				
				$class_standard						= ($table_type == "standard" ? "ts-pricing-inspired-standard" : "");
				$class_featured						= ($table_type == "featured" ? "ts-pricing-inspired-featured" : "");
				$class_intro						= ($table_type == "intro" ? "ts-pricing-inspired-intro" : "");
				$class_effect						= 'ts-pricing-inspired-' . $table_effect;
				$class_radius						= 'ts-pricing-inspired-radius-' . $table_radius;
				
				// Visual Composer CSS Filter Override
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_InspiredPricing_Item', $atts);
				} else {
					$css_class						= '';
				}

				// Create Table Output
				$output .= '<div id="' . $pricetable_id . '" class="ts-pricing-inspired-item ' . $class_featured . ' ' . $css_class . ' ' . $class_standard . ' ' . $class_intro . ' ' . $class_effect . ' ' . $class_radius . '" data-style="' . $table_style . '">';
					$output .= $this->TS_VCSC_InspiredPricing_Inner($table_style, $table_title, $table_currency, $table_cost, $table_period, $table_message, $table_icon, $content, $wpautop, $button_text);
					if ($button_type == "default") {
						$output .= $this->TS_VCSC_InspiredPricing_Button($randomizer, $table_style, $scroll_navigate, $scroll_target, $scroll_offset, $scroll_speed, $scroll_effect, $scroll_hashtag, $button_link, $button_text);
					} else if ($button_type == "custom") {
						$output .= '<div class="ts-pricing-inspired-buttoncustom">';
							$output .= rawurldecode(base64_decode(strip_tags($button_custom)));
						$output .= '</div>';
					}
				$output .= '</div>';
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
		
			// Add Inspired Pricing Table Elements
			function TS_VCSC_Add_InspiredPricing_Element_Single() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Single Inspired Pricing Table
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name"                          => __( "TS Inspired Pricing (Single)", "ts_visual_composer_extend" ),
					"base"                          => "TS_VCSC_InspiredPricing_Single",
					"icon"                          => "ts-composer-element-icon-inspiredpricing-single",
					"class"                         => "",
					"category"                      => __( "VC Extensions", "ts_visual_composer_extend" ),
					"description" 		            => __("Place an inspired pricing table", "ts_visual_composer_extend"),
					"admin_enqueue_js"            	=> "",
					"admin_enqueue_css"           	=> "",
					"params"                        => array(
						// Pricing Table Settings
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_1",
							"seperator"				=> "Table Settings",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Inspired Design", "ts_visual_composer_extend" ),
							"param_name"            => "table_style",
							"admin_label"           => true,
							"value"			        => array(
								__( "Sonam", "")          	=> "sonam",
								__( "Jinpa", "" )         	=> "jinpa",
								__( "Tenzin", "" )         	=> "tenzin",
								__( "Yama", "" )         	=> "yama",
								__( "Rabten", "" )         	=> "rabten",
								__( "Pema", "" )         	=> "pema",
								__( "Karma", "" )         	=> "karma",
								__( "Norbu", "" )         	=> "norbu",
								__( "Dawa", "" )         	=> "dawa",
								__( "Yonten", "" )         	=> "yonten",
								__( "Tashi", "" )         	=> "tashi",
								__( "Palden", "" )         	=> "palden",
							),
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"			=> __( "Select the inspired design for the tables.", "ts_visual_composer_extend" ),
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Table Type", "ts_visual_composer_extend" ),
							"param_name"            => "table_type",
							"admin_label"           => true,
							"value"			        => array(
								__( "Standard", "ts_visual_composer_extend")				=> "standard",
								__( "Featured", "ts_visual_composer_extend")				=> "featured",
							),
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"           => __( "Select the type of pricing table you want to add.", "ts_visual_composer_extend" )
						),						
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Table Radius", "ts_visual_composer_extend" ),
							"param_name"            => "table_radius",
							"admin_label"           => true,
							"value"			        => array(
								__( "None", "ts_visual_composer_extend")					=> "none",
								__( "Extra Small", "ts_visual_composer_extend")				=> "extrasmall",
								__( "Small", "ts_visual_composer_extend" )					=> "small",
								__( "Medium", "ts_visual_composer_extend" )					=> "medium",
								__( "Large", "ts_visual_composer_extend" )					=> "large",
								__( "Extra Large", "ts_visual_composer_extend" )			=> "extralare",
							),
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"           => __( "Select an optional radius to be applied to the table edges.", "ts_visual_composer_extend" )
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Hover Effect", "ts_visual_composer_extend" ),
							"param_name"            => "table_effect",
							"admin_label"           => true,
							"value"			        => array(
								__( "None", "ts_visual_composer_extend")					=> "none",
								__( "Tilt Y Top", "ts_visual_composer_extend")				=> "effect1",
								__( "Tilt Y Bottom", "ts_visual_composer_extend" )			=> "effect2",
								__( "Tilt X Left", "ts_visual_composer_extend" )			=> "effect3",
								__( "Tilt X Right", "ts_visual_composer_extend" )			=> "effect4",
								__( "Tilt X/Y Top/Left", "ts_visual_composer_extend" )		=> "effect5",
								__( "Tilt X/Y Bottom/Right", "ts_visual_composer_extend" )	=> "effect6",
								__( "Scale", "ts_visual_composer_extend" )         			=> "effect7",
							),
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"           => __( "Select an optional effect to be applied to the table when hovering.", "ts_visual_composer_extend" )
						),
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_2",
							"seperator"				=> "Table Content",
						),
						array(
							'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 				=> __( 'Table Icon', 'ts_visual_composer_extend' ),
							'param_name' 			=> 'table_icon',
							'value'					=> '',
							'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 				=> array(
								'emptyIcon' 			=> true,
								'type' 					=> 'extensions',
								'iconsPerPage' 			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"        	=> "",
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Title", "ts_visual_composer_extend" ),
							"param_name"            => "table_title",
							"value"                 => "Recommended",
							"dependency"            => ""
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Currency", "ts_visual_composer_extend" ),
							"param_name"            => "table_currency",
							"value"                 => "$",
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Cost", "ts_visual_composer_extend" ),
							"param_name"            => "table_cost",
							"value"                 => "$20",
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Per (Optional)", "ts_visual_composer_extend" ),
							"param_name"            => "table_period",
							"value"                 => "per month",
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Message", "ts_visual_composer_extend" ),
							"param_name"            => "table_message",
							"value"                 => "",
							"dependency"            => ""
						),
						array(
							"type"		            => "textarea_html",
							"class"		            => "",
							"heading"               => __( "Features", "ts_visual_composer_extend" ),
							"param_name"            => "content",
							"value"                 => "<ul>
														<li>30GB Storage</li>
														<li>512MB Ram</li>
														<li>10 databases</li>
														<li>1,000 Emails</li>
														<li>25GB Bandwidth</li>
													</ul>",
						),
						// Link Settings
						array(
							"type"              	=> "seperator",
							"param_name"        	=> "seperator_3",
							"seperator"				=> "Link + Title Settings",
							"dependency"        	=> array( 'element' => "table_type", 'value' => array('standard', 'featured') ),
							"group"					=> "Link Settings",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Button: Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_type",
							"admin_label"           => true,
							"value"			        => array(
								__( "Default Link Button", "ts_visual_composer_extend")		=> "default",
								__( "Custom Code Block", "ts_visual_composer_extend" )		=> "custom",
								__( "No Link", "ts_visual_composer_extend" )         		=> "none",
							),
							"dependency"        	=> array( 'element' => "table_type", 'value' => array('standard', 'featured') ),
							"group"					=> "Link Settings"
						),						
						array(
							"type"              	=> "textarea_raw_html",
							"heading"           	=> __( "Custom Code", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_custom",
							"value"             	=> base64_encode(""),
							"description"       	=> __( "Enter the HTML code to build your custom link (button).", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'custom' ),
							"group"					=> "Link Settings"
						),						
						array(
							"type"                  => "switch_button",
							"heading"			    => __( 'Use for Page Navigation', "ts_visual_composer_extend" ),
							"param_name"		    => "scroll_navigate",
							"value"                 => "false",
							"admin_label"       	=> true,
							"description"		    => __( "Switch the toggle if you want to use this button to navigate to another section on the same page.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'default' ),
							"group"					=> "Link Settings"
						),
						array(
							"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
							"heading" 				=> __("Button: Link + Title", "ts_visual_composer_extend"),
							"param_name" 			=> "button_link",
							"description" 			=> __("Provide a link to another site/page for the Icon Button.", "ts_visual_composer_extend"),
							"dependency"    		=> array( 'element' => 'scroll_navigate', 'value' => "false" ),
							"group"					=> "Link Settings"
						),
						array(
							"type"			        => "textfield",
							"class"			        => "",
							"heading"		        => __( "Button: Text", "ts_visual_composer_extend" ),
							"param_name"	        => "button_text",
							"value"			        => "Purchase",
							"description"	        => __( "Button: Text", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'default' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"                  => "textfield",
							"heading"               => __( "Page Scroll Target", "ts_visual_composer_extend" ),
							"param_name"            => "scroll_target",
							"value"                 => "",
							"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type" 					=> "devicetype_selectors",
							"heading"           	=> __( "Device Type Scroll Offset", "ts_visual_composer_extend" ),
							"param_name"        	=> "scroll_offset",
							"unit"  				=> "px",
							"collapsed"				=> "true",
							"devices" 				=> array(
								"Desktop"           		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Tablet"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Mobile"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
							),
							"value"					=> "desktop:0px;tablet:0px;mobile:0px",
							"description"			=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"					=> "nouislider",
							"heading"				=> __( "Page Scroll Speed", "ts_visual_composer_extend" ),
							"param_name"			=> "scroll_speed",
							"value"					=> "2000",
							"min"					=> "500",
							"max"					=> "10000",
							"step"					=> "100",
							"unit"					=> 'ms',
							"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),							
						array(
							"type"                 	=> "dropdown",
							"heading"               => __( "Page Scroll Easing", "ts_visual_composer_extend" ),
							"param_name"            => "scroll_effect",
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"width"                 => 150,
							"value" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
							"description"           => __( "Select the easing animation that should be applied to the page scroll.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"                  => "switch_button",
							"heading"			    => __( 'Add Target as Hashtag', "ts_visual_composer_extend" ),
							"param_name"		    => "scroll_hashtag",
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"value"                 => "false",
							"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						// Other Settings
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_4",
							"seperator"				=> "Maximum Width",
							"group" 				=> "Other Settings",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Maximum Width", "ts_visual_composer_extend" ),
							"param_name"            => "table_widthmax",
							"value"			        => array(
								__( "None", "ts_visual_composer_extend")					=> "none",
								__( "Percent of Column", "ts_visual_composer_extend")		=> "percent",
								__( "Fixed Pixel Width", "ts_visual_composer_extend" )		=> "pixels",
							),
							"description"           => __( "Select if you want to apply a maximum width to the table.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Width in Percent", "ts_visual_composer_extend" ),
							"param_name"            => "table_widthpercent",
							"value"                 => "100",
							"min"                   => "50",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => '%',
							"description"           => __( "Define the maximum width of the table as percentage of the column the table is embedded in.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "table_widthmax", 'value' => 'percent' ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Width in Pixels", "ts_visual_composer_extend" ),
							"param_name"            => "table_widthpixels",
							"value"                 => "320",
							"min"                   => "150",
							"max"                   => "1024",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"           => __( "Define the maximum width of the table as a fixed pixels value.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "table_widthmax", 'value' => 'pixels' ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_5",
							"seperator"				=> "Table Margins",
							"group" 				=> "Other Settings",
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
							"param_name"            => "margin_top",
							"value"                 => "0",
							"min"                   => "0",
							"max"                   => "200",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
							"param_name"            => "margin_bottom",
							"value"                 => "0",
							"min"                   => "0",
							"max"                   => "200",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_6",
							"seperator"				=> "Other Settings",
							"group" 				=> "Other Settings",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"        	=> "el_id",
							"value"             	=> "",
							"description"       	=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"        	=> "el_class",
							"value"             	=> "",
							"description"       	=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						// Load Custom CSS/JS File
						array(
							"type"                  => "load_file",
							"heading"               => "",
							"param_name"            => "el_file",
							"value"                 => "",
							"file_type"             => "js",
							"file_path"             => "js/ts-visual-composer-extend-element.min.js",
							"description"           => ""
						),
					)
				);
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
					return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
				} else {			
					vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
				};
			}
			function TS_VCSC_Add_InspiredPricing_Element_Container() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Inspired Pricing Container
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name"                              => __("TS Inspired Pricing (Container)", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_InspiredPricing_Container",
					"class"                             => "",
					"icon"                              => "ts-composer-element-icon-inspiredpricing-container",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                         => array('only' => 'TS_VCSC_InspiredPricing_Item'),
					"description"                       => __("Build inspired pricing tables", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"front_enqueue_js"					=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-inspiredpricing-container.min.js')),
					"front_enqueue_css"					=> "",
					"js_view" 							=> 'VcColumnView',
					"params"                            => array(
						// General Settings
						array(
							"type"                      => "seperator",
							"param_name"                => "seperator_1",
							"seperator"                 => "Tables Design",
						),
						array(
							"type"			        	=> "dropdown",
							"class"			        	=> "",
							"heading"               	=> __( "Inspired Design", "ts_visual_composer_extend" ),
							"param_name"            	=> "table_style",
							"admin_label"           	=> true,
							"value"			        	=> array(
								__( "Sonam", "")          	=> "sonam",
								__( "Jinpa", "" )         	=> "jinpa",
								__( "Tenzin", "" )         	=> "tenzin",
								__( "Yama", "" )         	=> "yama",
								__( "Rabten", "" )         	=> "rabten",
								__( "Pema", "" )         	=> "pema",
								__( "Karma", "" )         	=> "karma",
								__( "Norbu", "" )         	=> "norbu",
								__( "Dawa", "" )         	=> "dawa",
								__( "Yonten", "" )         	=> "yonten",
								__( "Tashi", "" )         	=> "tashi",
								__( "Palden", "" )         	=> "palden",
							),
							"description"				=> __( "Select the inspired design for the tables.", "ts_visual_composer_extend" ),
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Maximum Width", "ts_visual_composer_extend" ),
							"param_name"				=> "table_width",
							"value"						=> "320",
							"min"						=> "200",
							"max"						=> "1024",
							"step"						=> "1",
							"unit"						=> 'px',
							"admin_label"           	=> true,
							"description"				=> __( "Define the maximum inner flex width of the tables.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  	=> "switch_button",
							"heading"               	=> __( "Remove Spacing", "ts_visual_composer_extend" ),
							"param_name"            	=> "table_margins",
							"value"                 	=> "false",
							"admin_label"           	=> true,
							"description"           	=> __( "Switch the toggle if you want to remove all spacings between the individual tables.", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "switch_button",
							"heading"               	=> __( "Adjust Line Height", "ts_visual_composer_extend" ),
							"param_name"            	=> "table_lineadjust",
							"value"                 	=> "false",
							"description"           	=> __( "Switch the toggle if you need to adjust the line height for the feature listing in the tables.", "ts_visual_composer_extend" )
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "List Line Height", "ts_visual_composer_extend" ),
							"param_name"                => "table_lineheight",
							"value"                     => "24",
							"min"                       => "12",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"dependency"        		=> array( 'element' => "table_lineadjust", 'value' => 'true' ),
							"description"               => __( "Select the line height to be used for the feature listing section in each table.", "ts_visual_composer_extend" ),
						),
						// Other Settings
						array(
							"type"                      => "seperator",
							"param_name"                => "seperator_2",
							"seperator"                 => "Other Settings",
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
			function TS_VCSC_Add_InspiredPricing_Element_Item() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Single Inspired Pricing Table
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name"                          => __( "TS Inspired Pricing (Item)", "ts_visual_composer_extend" ),
					"base"                          => "TS_VCSC_InspiredPricing_Item",
					"icon"                          => "ts-composer-element-icon-inspiredpricing-item",
					"class"                         => "",
					"category"                      => __( "VC Extensions", "ts_visual_composer_extend" ),
					"description" 		            => __("Place an inspired pricing table", "ts_visual_composer_extend"),
					"content_element"				=> true,
					"controls"						=> "full",						
					'is_container' 					=> false,
					"admin_enqueue_js"            	=> "",
					"admin_enqueue_css"           	=> "",
					"front_enqueue_js"				=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-inspiredpricing-item.min.js')),
					"front_enqueue_css"				=> "",
					"as_child" 						=> array('only' => 'TS_VCSC_InspiredPricing_Container'),
					"params"                        => array(
						// Pricing Table Settings
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_1",
							"seperator"				=> "Table Settings",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Table Type", "ts_visual_composer_extend" ),
							"param_name"            => "table_type",
							"admin_label"           => true,
							"value"			        => array(
								__( "Standard", "ts_visual_composer_extend")				=> "standard",
								__( "Featured", "ts_visual_composer_extend")				=> "featured",
								__( "Intro / Overview", "ts_visual_composer_extend" )		=> "intro",
							),
							"admin_label"           => true,
							"description"           => __( "Select the type of pricing table you want to add.", "ts_visual_composer_extend" )
						),						
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Table Radius", "ts_visual_composer_extend" ),
							"param_name"            => "table_radius",
							"admin_label"           => true,
							"value"			        => array(
								__( "None", "ts_visual_composer_extend")					=> "none",
								__( "Extra Small", "ts_visual_composer_extend")				=> "extrasmall",
								__( "Small", "ts_visual_composer_extend" )					=> "small",
								__( "Medium", "ts_visual_composer_extend" )					=> "medium",
								__( "Large", "ts_visual_composer_extend" )					=> "large",
								__( "Extra Large", "ts_visual_composer_extend" )			=> "extralare",
							),
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"           => __( "Select an optional radius to be applied to the table edges.", "ts_visual_composer_extend" )
						),	
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Hover Effect", "ts_visual_composer_extend" ),
							"param_name"            => "table_effect",
							"admin_label"           => true,
							"value"			        => array(
								__( "None", "ts_visual_composer_extend")					=> "none",
								__( "Tilt Y Top", "ts_visual_composer_extend")				=> "effect1",
								__( "Tilt Y Bottom", "ts_visual_composer_extend" )			=> "effect2",
								__( "Tilt X Left", "ts_visual_composer_extend" )			=> "effect3",
								__( "Tilt X Right", "ts_visual_composer_extend" )			=> "effect4",
								__( "Tilt X/Y Top/Left", "ts_visual_composer_extend" )		=> "effect5",
								__( "Tilt X/Y Bottom/Right", "ts_visual_composer_extend" )	=> "effect6",
								__( "Scale", "ts_visual_composer_extend" )         			=> "effect7",
							),
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"description"           => __( "Select an optional effect to be applied to the table when hovering.", "ts_visual_composer_extend" )
						),
						// Table Content
						array(
							"type"				    => "seperator",
							"param_name"		    => "seperator_2",
							"seperator"				=> "Table Content",
						),
						array(
							'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 				=> __( 'Table Icon', 'ts_visual_composer_extend' ),
							'param_name' 			=> 'table_icon',
							'value'					=> '',
							'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 				=> array(
								'emptyIcon' 			=> true,
								'type' 					=> 'extensions',
								'iconsPerPage' 			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"        	=> "",
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Title", "ts_visual_composer_extend" ),
							"param_name"            => "table_title",
							"value"                 => "Recommended",
							"dependency"            => ""
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Currency", "ts_visual_composer_extend" ),
							"param_name"            => "table_currency",
							"value"                 => "$",
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"                  => "textfield",
							"class"                 => "",
							"heading"               => __( "Cost", "ts_visual_composer_extend" ),
							"param_name"            => "table_cost",
							"value"                 => "$20",
							"admin_label"           => true,
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Per (Optional)", "ts_visual_composer_extend" ),
							"param_name"            => "table_period",
							"value"                 => "per month",
							"edit_field_class"		=> "vc_col-sm-4 vc_column",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Message", "ts_visual_composer_extend" ),
							"param_name"            => "table_message",
							"value"                 => "",
							"dependency"            => ""
						),
						array(
							"type"		            => "textarea_html",
							"class"		            => "",
							"heading"               => __( "Features", "ts_visual_composer_extend" ),
							"param_name"            => "content",
							"value"                 => "<ul>
														<li>30GB Storage</li>
														<li>512MB Ram</li>
														<li>10 databases</li>
														<li>1,000 Emails</li>
														<li>25GB Bandwidth</li>
													</ul>",
						),
						// Link Settings
						array(
							"type"              	=> "seperator",
							"param_name"        	=> "seperator_3",
							"seperator"				=> "Link + Title Settings",
							"dependency"        	=> array( 'element' => "table_type", 'value' => array('standard', 'featured') ),
							"group"					=> "Link Settings",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Button: Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_type",
							"admin_label"           => true,
							"value"			        => array(
								__( "Default Link Button", "ts_visual_composer_extend")		=> "default",
								__( "Custom Code Block", "ts_visual_composer_extend" )		=> "custom",
								__( "No Link", "ts_visual_composer_extend" )         		=> "none",
							),
							"dependency"        	=> array( 'element' => "table_type", 'value' => array('standard', 'featured') ),
							"group"					=> "Link Settings"
						),						
						array(
							"type"              	=> "textarea_raw_html",
							"heading"           	=> __( "Custom Code", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_custom",
							"value"             	=> base64_encode(""),
							"description"       	=> __( "Enter the HTML code to build your custom link (button).", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'custom' ),
							"group"					=> "Link Settings"
						),						
						array(
							"type"                  => "switch_button",
							"heading"			    => __( 'Use for Page Navigation', "ts_visual_composer_extend" ),
							"param_name"		    => "scroll_navigate",
							"value"                 => "false",
							"admin_label"       	=> true,
							"description"		    => __( "Switch the toggle if you want to use this button to navigate to another section on the same page.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'default' ),
							"group"					=> "Link Settings"
						),
						array(
							"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
							"heading" 				=> __("Button: Link + Title", "ts_visual_composer_extend"),
							"param_name" 			=> "button_link",
							"description" 			=> __("Provide a link to another site/page for the Icon Button.", "ts_visual_composer_extend"),
							"dependency"    		=> array( 'element' => 'scroll_navigate', 'value' => "false" ),
							"group"					=> "Link Settings"
						),
						array(
							"type"			        => "textfield",
							"class"			        => "",
							"heading"		        => __( "Button: Text", "ts_visual_composer_extend" ),
							"param_name"	        => "button_text",
							"value"			        => "Purchase",
							"description"	        => __( "Button: Text", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "button_type", 'value' => 'default' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"                  => "textfield",
							"heading"               => __( "Page Scroll Target", "ts_visual_composer_extend" ),
							"param_name"            => "scroll_target",
							"value"                 => "",
							"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type" 					=> "devicetype_selectors",
							"heading"           	=> __( "Device Type Scroll Offset", "ts_visual_composer_extend" ),
							"param_name"        	=> "scroll_offset",
							"unit"  				=> "px",
							"collapsed"				=> "true",
							"devices" 				=> array(
								"Desktop"           		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Tablet"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Mobile"            		=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
							),
							"value"					=> "desktop:0px;tablet:0px;mobile:0px",
							"description"			=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"					=> "nouislider",
							"heading"				=> __( "Page Scroll Speed", "ts_visual_composer_extend" ),
							"param_name"			=> "scroll_speed",
							"value"					=> "2000",
							"min"					=> "500",
							"max"					=> "10000",
							"step"					=> "100",
							"unit"					=> 'ms',
							"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),							
						array(
							"type"                 	=> "dropdown",
							"heading"               => __( "Page Scroll Easing", "ts_visual_composer_extend" ),
							"param_name"            => "scroll_effect",
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"width"                 => 150,
							"value" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
							"description"           => __( "Select the easing animation that should be applied to the page scroll.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						array(
							"type"                  => "switch_button",
							"heading"			    => __( 'Add Target as Hashtag', "ts_visual_composer_extend" ),
							"param_name"		    => "scroll_hashtag",
							"edit_field_class"		=> "vc_col-sm-6 vc_column",
							"value"                 => "false",
							"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
							"group"					=> "Link Settings"
						),
						// Load Custom CSS/JS File
						array(
							"type"                  => "load_file",
							"heading"               => "",
							"param_name"            => "el_file",
							"value"                 => "",
							"file_type"             => "js",
							"file_path"             => "js/ts-visual-composer-extend-element.min.js",
							"description"           => ""
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
		class WPBakeryShortCode_TS_VCSC_InspiredPricing_Container extends WPBakeryShortCodesContainer {};
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_InspiredPricing_Item extends WPBakeryShortCode {};
		class WPBakeryShortCode_TS_VCSC_InspiredPricing_Single extends WPBakeryShortCode {};
	}
	// Initialize "TS Inspired Pricing" Class
	if (class_exists('TS_InspiredPricing')) {
		$TS_InspiredPricing = new TS_InspiredPricing;
	}
?>