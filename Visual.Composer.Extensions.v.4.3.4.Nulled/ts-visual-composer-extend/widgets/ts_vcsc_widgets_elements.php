<?php
    global $VISUAL_COMPOSER_EXTENSIONS;	
	
	// Class to Retrieve Design Options CSS Settings
	if (!class_exists('TS_VCSC_Element_Widget_CSS')){
		class TS_VCSC_Element_Widget_CSS {
			static $styles;	
			static function load() {
				self::$styles = array();
				add_action('wp_footer', __class__.'::output');
				add_action('wp_enqueue_scripts', __class__.'::enqueue');
			}	
			static function exists($id) {
				return isset(self::$styles[$id]);
			}	
			static function enqueue($id) {
				wp_enqueue_style('js_composer_front');
				wp_enqueue_script('js_composer_front');
			}	
			static function add($css, $id='default') {
				if ($css) {
					if(!self::exists($id)) {
						self::$styles[$id] = '';
					}
					self::$styles[$id] .= $css;
				}
			}		
			static function output() {
				$style_string = '';
				if (is_array(self::$styles)) {
					foreach (self::$styles as $style) {
						$style_string .= $style;
					}
					if ($style_string != '') {
						echo '<style type="text/css">' . TS_VCSC_MinifyCSS($style_string) . '</style>';
					}
				} else {
					if (self::$styles != '') {
						echo '<style type="text/css">' . TS_VCSC_MinifyCSS(self::$styles) . '</style>';
					}
				}			
				/*$css = implode('\n', self::$styles);
				if ($css) {
					$css = str_replace('\n', '', $css);
					echo '<style type="text/css">' . $css . '</style>';
				}*/
			}
		}
	}
	if (!function_exists('TS_VCSC_Element_Widget_GetPost')) {
		function TS_VCSC_Element_Widget_GetPost($id) {
			if (function_exists('icl_object_id')) {
				$id = icl_object_id($id, 'post', true, ICL_LANGUAGE_CODE);
			}
			return get_post($id);
		}
	}
	if (!function_exists('TS_VCSC_Element_Widget_GetMeta')) {
		function TS_VCSC_Element_Widget_GetMeta($id, $key) {
			if (function_exists('icl_object_id')) {
				$id = icl_object_id($id, 'post', true, ICL_LANGUAGE_CODE);
			}
			return get_post_meta($id, $key, true);
		}
	}
	
	// Class for "VC Widgets" Post Type Widget
	class TS_VCSC_Element_Widget_Single extends WP_Widget {
		// Define Widget
		function __construct() {
			global $wp_version;
			$widget_ops 								= array('classname' => 'TS_VCSC_Element_Widget_Single', 'description' => __('Show Visual Composer and add-on element in your sidebar via widget.', 'ts_visual_composer_extend'));
			$control_ops 								= array();
			if (version_compare($wp_version, '4.3', '>=')) {
				parent::__construct(false, $name = __('VC Widgets / Templates', 'ts_visual_composer_extend'), $widget_ops, $control_ops);
			} else {
				parent::WP_Widget(false, $name = __('VC Widgets / Templates', 'ts_visual_composer_extend'), $widget_ops, $control_ops);
			}
			TS_VCSC_Element_Widget_CSS::load();
		}
		
		// Define Widget Default Values
		var $TS_VCSC_Element_Widget_Single_Defaults = array(
			'title'										=> '',
			'widget'									=> '',
			'posttitle'									=> 1,
        );
		
		// Create Widget Front-End
		public function widget($args, $instance) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			extract($args);
			$title 										= apply_filters('widget_title', $instance['title']);			
			$widget 									= (isset($instance['widget']) ? esc_attr($instance['widget']) : "");
			$posttitle 									= (isset($instance['posttitle']) ? ($instance['posttitle'] ? "true" : "false") : "true");
			$post 										= TS_VCSC_Element_Widget_GetPost($widget);
			if ($post) {
				// Render Widget Title
				$output 								= $args['before_widget'];
				if ((!empty($title)) && ($posttitle == "false")) {
					$output.= $args['before_title'] . $title . $args['after_title'];
				} else if ($posttitle == "true") {
					$posttitle 							= apply_filters('the_content', $post->post_title);
					$output.= $args['before_title'] . $posttitle . $args['after_title'];
				}
				// Render Widget Content
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
					$content 							= apply_filters('the_content', $post->post_content);
				} else {
					$templateLink 						= str_replace(get_the_ID(), $widget, get_edit_post_link());
					$content = '';
					$content .= '<div class="ts-composer-frontedit-message" style="border: 1px solid #ededed; padding: 10px; margin: 0;">';
						$content .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">The content of this element has been created via the custom "VC Widgets" post type and can NOT be edited directly via the frontend editor.</div>';
						$content .= '<span style="display: block;">Widget / Template ID: ' . $widget . '</span>';
						$content .= '<span style="display: block;">Widget / Template Name: ' . get_the_title($widget) . '</span>';
						$content .= '<span style="display: block;"><a href="' . $templateLink . '" target="_blank">Edit VC Widget / Template</a></span>';
					$content .= '</div>';
				}
				$output.= $content;
				// Render VC CSS Styling Parameter
				$post_id 								= "$widget";
				if (!TS_VCSC_Element_Widget_CSS::exists($post_id)) {
					$design_options = TS_VCSC_Element_Widget_GetMeta($widget, '_wpb_post_custom_css');
					$design_options.= TS_VCSC_Element_Widget_GetMeta($widget, '_wpb_shortcodes_custom_css');					
					TS_VCSC_Element_Widget_CSS::add($design_options, $post_id);
				}	
				$output.= $args['after_widget'];
				echo $output;
			}
			
		}

		// Create Widget Backend 
		public function form( $instance ) {
			$instance 									= wp_parse_args((array) $instance, $this->TS_VCSC_Element_Widget_Single_Defaults);
			echo '<div class="ts-vcsc-widget-title-input">';
				echo '<p>';
					echo '<label class="ts-vcsc-widget-label-block" for="' . $this->get_field_id('title') . '">' . __('Title:', 'ts_visual_composer_extend') . '</label>';
					echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($instance['title']) . '"/>';
				echo '</p>';
			echo '</div>';
			echo '<p class="ts-vcsc-widget-title"><i class="dashicons-index-card" style="font-size: 20px; line-height: 20px; top: 2px;"></i>Widget Item:</p>';
			echo '<p>';
				$posts_count							= 0;
				$posts_fields 							= array();
				$categories								= '';
				$category_fields 						= array();
				$categories_count						= 0;
				$terms_slugs 							= array();
				$args = array(
					'no_found_rows' 					=> 1,
					'ignore_sticky_posts' 				=> 1,
					'posts_per_page' 					=> -1,
					'post_type' 						=> 'ts_widgets',
					'post_status' 						=> 'publish',
					'orderby' 							=> 'title',
					'order' 							=> 'ASC',
				);
				$widgetpost_nocategory_name				= 'ts-widget-none-applied';
				$widgetpost_nocategory					= 0;
				$widgetpost_query 						= new WP_Query($args);
				if ($widgetpost_query->have_posts()) {
					foreach($widgetpost_query->posts as $p) {
						// Get Categories
						$categories 					= TS_VCSC_GetTheCategoryByTax($p->ID, 'ts_widgets_category');							
						if ($categories && !is_wp_error($categories)) {
							$category_slugs_arr 		= array();
							foreach ($categories as $category) {
								$category_slugs_arr[] 	= $category->slug;
								$category_data = array(
									'slug'		=> $category->slug,
									'name'		=> $category->cat_name,
									'count'		=> $category->count,
								);
								$category_fields[] = $category_data;
							}
							$categories_slug_str 		= join(",", $category_slugs_arr);
						} else {
							$widgetpost_nocategory++;
							$categories_slug_str = '';
						};                            
						// Create Post Data
						$posts_data = array(
							'postid'					=> $p->ID,
							'posttitle'					=> $p->post_title,
							'postdate'					=> $p->post_date,
							'postlink'					=> '',
							'categories'				=> $categories_slug_str,
						);			
						$posts_fields[] 				= $posts_data;
						$posts_count++;
					}
				}
				wp_reset_postdata();
				$category_fields 						= array_map("unserialize", array_unique(array_map("serialize", $category_fields)));
				if ($posts_count > 1) {
					echo '<label class="ts-vcsc-widget-label-block" for="ts-vcsc-widget-filter" style="font-weight: normal; font-style: italic;">' . __('Widgets Filter:', 'ts_visual_composer_extend') . '</label>';
					echo '<input class="ts-vcsc-widget-filter" name="ts-vcsc-widget-filter" type="text" value="" style="margin-bottom: 5px;" placeholder="' . __('Enter Keyword to Filter Widgets', 'ts_visual_composer_extend') . '"/>';
				}
				echo '<div class="ts-vcsc-widget-element-select">';
					echo '<label class="ts-vcsc-widget-label-block" for="' . $this->get_field_id('widget'). '">' . __('Select Widget:', 'ts_visual_composer_extend') . '</label>';
					echo '<select id="' . $this->get_field_id('widget') . '" class="ts-vcsc-widget-select-full" name="' . $this->get_field_name('widget') . '" required>';
						if (esc_attr($instance['widget']) == '') {
							echo '<option data-title="" data-id="" data-link="" data-categories="" value="" disabled selected>' . __('Select a Widget / Template', 'ts_visual_composer_extend') . '</option>';
						}
						foreach ($posts_fields as $index => $array) {
							echo '<option data-title="' . $posts_fields[$index]['posttitle'] . '" data-id="' . $posts_fields[$index]['postid'] . '" data-link="' . $posts_fields[$index]['postlink'] . '" data-categories="' . $posts_fields[$index]['categories'] . '" value="' . $posts_fields[$index]['postid'] . '" ' . selected(esc_attr($instance['widget']), $posts_fields[$index]['postid'], false) . '>' . $posts_fields[$index]['posttitle'] . ' (ID: ' . $posts_fields[$index]['postid'] . ')</option>';
						}
					echo '</select>';
				echo '</div>';
				echo '<span class="ts-vcsc-widget-noresult">No widget items matching your search criteria could be found!</span>';
				$editText								= __('Edit Widget', 'ts_visual_composer_extend');
				$editAdminPre							= get_admin_url() . 'post.php?post=';
				$editAdminPost							= '&action=edit';
				if (esc_attr($instance['widget']) != '') {
					$editWidget							= esc_attr($instance['widget']);
					$editLink							= get_edit_post_link($editWidget);
					$editView							= 'display: inline-block;';
				} else {
					$editWidget							= '';
					$editLink							= '';
					$editView							= 'display: none;';
				}
				$editLabel								= '<a class="ts-vcsc-widget-element-edit button button-secondary" style="width: auto; margin-top: 10px; ' . $editView . '" data-link-text="' . $editText . '" data-link-pre="' . $editAdminPre . '" data-link-post="' . $editAdminPost . '" href="' . $editLink . '" target="_blank">' . $editText . ' #' . $editWidget . '</a>';
				echo $editLabel;				
				echo '<div class="ts-vcsc-widget-title-checkbox">';
					echo '<p>';
						echo '<label class="ts-vcsc-widget-label-inline" for="' . $this->get_field_id('posttitle') . '">Post Title as Widget Title:</label>';
						echo '<input class="checkbox" type="checkbox" value="1" ' . checked('1', esc_attr($instance['posttitle']), false) . ' id="' . $this->get_field_id('posttitle') . '" name="' . $this->get_field_name('posttitle') . '" />';
					echo '</p>';
				echo '</div>';
			echo '</p>';
		}

		// Update Widget
		public function update($new_instance, $old_instance) {
			$instance 									= $old_instance;
			$instance['title'] 							= (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
			$instance['widget'] 						= strip_tags($new_instance['widget']);
			$instance['posttitle'] 						= strip_tags($new_instance['posttitle']);
			return $instance;
		}
	}	

	// Register and Load Widgets
	function TS_VCSC_Element_Widget_Single_Register() {
		register_widget('TS_VCSC_Element_Widget_Single');
	}	
	add_action('widgets_init', 'TS_VCSC_Element_Widget_Single_Register');

	// Custom Template Registration for "VC Widgets" Post Type
	add_filter('single_template', 'TS_VCSC_WidgetsTemplate_Chooser');
	function TS_VCSC_WidgetsTemplate_Chooser($single_template) {
		global $post;
		global $VISUAL_COMPOSER_EXTENSIONS;
		if ($post->post_type == 'ts_widgets') {
			$single_template = $VISUAL_COMPOSER_EXTENSIONS->widgets_dir . 'ts_vcsc_widgets_template.php';
		}
		return $single_template;
	}	
	/*
	add_filter('template_include', 'TS_VCSC_WidgetsTemplate_Chooser');
	if (!function_exists('TS_VCSC_WidgetsTemplate_Chooser')) {
		function TS_VCSC_WidgetsTemplate_Chooser($template) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if (get_post_type() == 'ts_widgets') {
				if (is_single()) {
					// checks if the file exists in the theme first, otherwise serve the file from the plugin
					if ($theme_file = locate_template(array('single-ts_widgets.php'))) {
						$template = $theme_file;
					} else {						
						$template = $VISUAL_COMPOSER_EXTENSIONS->widgets_dir . 'ts_vcsc_widgets_template.php';
					}
				}
			}
			return $template;
		}
	}
	*/
?>