<?php
    /*
        No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_LinkPicker')) {
        class TS_Parameter_LinkPicker {
            function __construct() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('advancedlinks',     array(&$this, 'advancedlinks_settings_field'));
                } else if (function_exists('add_shortcode_param')) {                    
                    add_shortcode_param('advancedlinks',        array(&$this, 'advancedlinks_settings_field'));
                }
            }        
            function advancedlinks_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     	    = vc_generate_dependencies_attributes($settings);
                $param_name     	    = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           	    = isset($settings['type']) ? $settings['type'] : '';
                // Post Retrieval
                $load_offset            = isset($settings['load_count']) ? $settings['load_count'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['offset'];
                $load_orderby           = isset($settings['load_orderby']) ? $settings['load_orderby'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['orderby'];
                $load_order             = isset($settings['load_order']) ? $settings['load_order'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['order'];
                // Text Strings
                $text_page              = isset($settings['text_page']) ? $settings['text_page'] : __("Page", "ts_visual_composer_extend");
                $text_post              = isset($settings['text_post']) ? $settings['text_post'] : __("Post", "ts_visual_composer_extend");
                $text_blank             = isset($settings['text_blank']) ? $settings['text_blank'] : __("New Window", "ts_visual_composer_extend");
                $text_parent            = isset($settings['text_parent']) ? $settings['text_parent'] : __("Same Window", "ts_visual_composer_extend");
                // Parse Link Data
                $link_json              = TS_VCSC_Advancedlinks_BuildLinkArray($value);
                $link_url               = urldecode($link_json['url']);
                $link_target            = $link_json['target'];
                $link_title             = $link_json['title'];
                $link_source            = $link_json['source'];
                $link_id                = $link_json['id'];
                $link_name              = $link_json['name'];
                if (($link_url != '') && ($link_source == 'external') || ($link_source == '')) {
                    $link_source        = 'external';
                    $display_link       = 'display: block;';
                } else {
                    $display_link       = 'display: none;';
                }
                if (($link_id != '') && ($link_source == 'page')) {
                    $display_page       = 'display: block;';
                } else {
                    $display_page       = 'display: none;';
                }
                if (($link_id != '') && ($link_source == 'post')) {
                    $display_post       = 'display: block;';
                } else {
                    $display_post       = 'display: none;';
                }
                if (($link_id != '') && ($link_source == 'custom')) {
                    $display_custom     = 'display: block;';
                } else {
                    $display_custom     = 'display: none;';
                }
                if (($link_id != '') && (($link_source == 'page') || ($link_source == 'post') || ($link_source == 'custom'))) {
                    $display_find       = 'display: block;';
                    $link_name          = get_the_title($link_id);
                } else {
                    $display_find       = 'display: none;';
                }
                // Contingency Checks
                if (($link_source =='post') && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['posts'] == "false")) {
                    $link_source        = 'page';
                } else if (($link_source =='custom') && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['custom'] == "false")) {
                    $link_source        = 'page';
                }
                if (($link_target == "_blank") || ($link_target == " _blank") || ($link_target == "%20_blank")) {
                    $link_target        = " _blank";                    
                } else if (($link_target == "_parent") || ($link_target == " _parent") || ($link_target == "%20_parent") || ($link_target == "") || ($link_target == " ")) {
                    $link_target        = "";
                }
                // Other Settings
                $randomizer             = mt_rand(999999, 9999999);
                $url            	    = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         	    = '';
                // Get Custom Post Types
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['custom'] == "true") {
                    $args = array(
                       'public'                 => true,
                       'publicly_queryable'     => true,
                       'exclude_from_search'    => false,
                       '_builtin'               => false
                    );
                    $availableTypes     = get_post_types($args, 'names', 'and');
                }
                // Get Pages and Posts
                $totalPages             = 0;
                $totalPosts             = 0;
                $totalCustom            = 0;
                $countPages             = 0;
                $countPosts             = 0;
                $countCustom            = 0;
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['global'] == "false") {
                    $totalPages         = wp_count_posts('page')->publish;
                    $totalPosts         = wp_count_posts('post')->publish;
                    $availablePages		= TS_VCSC_GetPostOptions(array('post_type' => 'page', 'posts_per_page' => $load_offset, 'offset' => 0, 'orderby' => $load_orderby, 'order' => $load_order));
                    $availablePosts		= TS_VCSC_GetPostOptions(array('post_type' => 'post', 'posts_per_page' => $load_offset, 'offset' => 0, 'orderby' => $load_orderby, 'order' => $load_order));
                    $availableCustom    = array();
                    $availableRequest   = array();
                    if (count($availableTypes) > 0) {
                        foreach ($availableTypes as $type) {
                            $totalCustom        = $totalCustom + wp_count_posts($type)->publish;
                            $availableRequest   = TS_VCSC_GetPostOptions(array('post_type' => $type, 'posts_per_page' => $load_offset, 'offset' => 0, 'orderby' => $load_orderby, 'order' => $load_order));
                            $availableCustom    = array_merge($availableCustom, $availableRequest);
                        }
                    }
                    //TS_VCSC_SortMultiArray($availablePages, 'name');
                    //TS_VCSC_SortMultiArray($availablePosts, 'name');
                    //TS_VCSC_SortMultiArray($availableCustom, 'name');
                }
                // Data Attributes
                $data_values        = 'data-randomizer="' . $randomizer . '" data-link-url="' . $link_url . '" data-link-target="' . $link_target . '" data-link-title="' . $link_title . '" data-link-source="' . $link_source . '" data-link-id="' . $link_id . '" data-link-name="' . $link_name . '"';
                $data_settings      = ' data-loadcount="' . $load_offset . '" data-offset="' . $load_offset . '" data-orderby="' . $load_orderby . '" data-order="' . $load_order . '"';
                $data_strings       = ' data-text-page="' . $text_page . '" data-text-post="' . $text_post . '" data-text-blank="' . $text_blank . '" data-text-parent="' . $text_parent . '"';
                // Parameter Output
                $output .= '<div id="ts-advancedlinks-holder-' . $randomizer . '" class="ts-advancedlinks-holder ts-settings-parameter-gradient-grey" ' . $data_values . $data_settings . $data_strings . '>';
                    // Hidden Input with Value
                    $output .= '<input type="hidden" id="ts-advancedlinks-value-' . $randomizer . '" name="' . $param_name . '" class="ts-advancedlinks-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" value="' . htmlentities($value, ENT_QUOTES, 'utf-8') . '" data-json="' . htmlentities(json_encode($link_json), ENT_QUOTES, 'utf-8') . '" style="display: none;">';
                    // Controls Toggle
                    $output .= '<div id="ts-advancedlinks-controls-' . $randomizer . '" class="ts-advancedlinks-controls" data-post="' . __('Post ID', 'ts_visual_composer_extend') . '" data-page="' . __('Page ID', 'ts_visual_composer_extend') . '">';
                        $output .= '<div id="ts-advancedlinks-toggle-' . $randomizer . '" class="ts-advancedlinks-toggle" data-status="false" data-settings="ts-advancedlinks-settings-' . $randomizer . '"><span class="dashicons dashicons-admin-generic"></span>' . __( 'Link Settings', 'ts_visual_composer_extend' ) . '</div>';
                        $output .= '<div id="ts-advancedlinks-data-icon-' . $randomizer . '" class="ts-advancedlinks-data-icon dashicons dashicons-admin-links"></div>';
                        $output .= '<div id="ts-advancedlinks-data-holder-' . $randomizer . '" class="ts-advancedlinks-data-holder">';                            
                            $output .= '<div class="ts-advancedlinks-data-set ts-advancedlinks-data-set-title"><span class="ts-advancedlinks-data-label">' . __('Link Title', 'ts_visual_composer_extend') . ':</span> <span id="ts-advancedlinks-data-title-' . $randomizer . '" class="ts-advancedlinks-data-title">' . $link_title . '</span></div>';
                            $output .= '<div class="ts-advancedlinks-data-set ts-advancedlinks-data-set-target"><span class="ts-advancedlinks-data-label">' . __('Link Target', 'ts_visual_composer_extend') . ':</span> <span id="ts-advancedlinks-data-target-' . $randomizer . '" class="ts-advancedlinks-data-target">' . ($link_target == " _blank" ? $text_blank : $text_parent) . '</span></div>';
                            $output .= '<div class="ts-advancedlinks-data-set ts-advancedlinks-data-set-url" style="display: ' . ($link_source == 'external' ? 'block' : 'none') . ';"><span class="ts-advancedlinks-data-label">' . __('Link URL', 'ts_visual_composer_extend') . ':</span> <span id="ts-advancedlinks-data-url-' . $randomizer . '" class="ts-advancedlinks-data-url">' . $link_url . '</span></div>';
                            $output .= '<div class="ts-advancedlinks-data-set ts-advancedlinks-data-set-id" style="display: ' . ($link_source != 'external' ? 'block' : 'none') . ';"><span class="ts-advancedlinks-data-label">' . __('ID', 'ts_visual_composer_extend') . ':</span> <span id="ts-advancedlinks-data-id-' . $randomizer . '" class="ts-advancedlinks-data-id">' . $link_id . '</span></div>';
                            $output .= '<div class="ts-advancedlinks-data-set ts-advancedlinks-data-set-name" style="display: ' . ($link_source != 'external' ? 'block' : 'none') . ';"><span class="ts-advancedlinks-data-label">' . __('Name', 'ts_visual_composer_extend') . ':</span> <span id="ts-advancedlinks-data-name-' . $randomizer . '" class="ts-advancedlinks-data-name">' . $link_name . '</span></div>';
                        $output .= '</div>';      
                    $output .= '</div>';                    
                    // Controls Output
                    $output .= '<div id="ts-advancedlinks-settings-' . $randomizer . '" class="ts-advancedlinks-settings" style="display: none;">';
                        // Selector for Link Source
                        $output .= '<div id="ts-advancedlinks-selector-holder-' . $randomizer . '" class="ts-advancedlinks-selector-holder" style="display: inline-block; width: 48%; margin: 0 2% 0 0; padding: 0;">';
                            $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-selector-' . $randomizer . '">' . __( "Select how the link should be defined:", "ts_visual_composer_extend" ) . '</label>';
                            $output .= '<select name="ts-advancedlinks-selector-' . $randomizer . '" id="ts-advancedlinks-selector-' . $randomizer . '" class="ts-advancedlinks-selector" value="' . $link_source . '" style="">';
                                $output .= '<option id="" class="" name="" value="external" ' . selected($link_source, "external", false) . '>' . __( "External / Custom Link", "ts_visual_composer_extend" ) . '</option>';
                                $output .= '<option id="" class="" name="" value="page" ' . selected($link_source, "page", false) . '>' . __( "Standard Page via ID", "ts_visual_composer_extend" ) . '</option>';
                                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['posts'] == "true") {
                                    $output .= '<option id="" class="" name="" value="post" ' . selected($link_source, "post", false) . '>' . __( "Standard Post via ID", "ts_visual_composer_extend" ) . '</option>';
                                }
                                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['custom'] == "true") {
                                    if (count($availableTypes) > 0) {
                                        $output .= '<option id="" class="" name="" value="custom" ' . selected($link_source, "custom", false) . '>' . __( "Custom Post via ID", "ts_visual_composer_extend" ) . '</option>';
                                    }
                                }
                            $output .= '</select>';
                        $output .= '</div>';
                        // Link Target
                        $output .= '<div class="ts-advancedlinks-target-holder" style="display: inline-block; width: 48%; margin: 0 0 0 2%; padding: 0;">';
                            $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-target-' . $randomizer . '">' . __( "Define how the link should be opened:", "ts_visual_composer_extend" ) . '</label>';
                            $output .= '<select name="ts-advancedlinks-target-' . $randomizer . '" id="ts-advancedlinks-target-' . $randomizer . '" class="ts-advancedlinks-target" value="' . $link_target . '" style="">';
                                $output .= '<option id="" class="" name="" value="" ' . selected($link_target, "", false) . '>' . $text_parent . '</option>';
                                $output .= '<option id="" class="" name="" value=" _blank" ' . selected($link_target, " _blank", false) . '>' . $text_blank . '</option>';
                            $output .= '</select>';
                        $output .= '</div>';
                        // External / Custom Link
                        $output .= '<div class="ts-advancedlinks-external-holder" style="' . $display_link . ' margin: 10px 0 0 0; padding: 0;">';
                            $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-external-' . $randomizer . '">' . __( "Define the external or custom link; start with http(s) or #:", "ts_visual_composer_extend" ) . '</label>';
                            $output .= '<input type="text" id="ts-advancedlinks-external-' . $randomizer . '" name="ts-advancedlinks-external-' . $randomizer . '" class="ts-advancedlinks-external" value="' . $link_url . '">';
                        $output .= '</div>';
                        // Link Title
                        $output .= '<div class="ts-advancedlinks-title-holder" style="margin: 10px 0 0 0; padding: 0;">';
                            $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-title-' . $randomizer . '">' . __( "Define an optional title for the link:", "ts_visual_composer_extend" ) . '</label>';
                            $output .= '<input type="text" id="ts-advancedlinks-title-' . $randomizer . '" name="ts-advancedlinks-title-' . $randomizer . '" class="ts-advancedlinks-title" value="' . $link_title . '">';
                        $output .= '</div>';
                        // Page / Post Search
                        $output .= '<div id="ts-advancedlinks-search-holder-' . $randomizer . '" class="ts-advancedlinks-search-holder" style="' . $display_find . ' margin: 10px 0 0 0; padding: 0;">';
                            $output .= '<input type="text" id="ts-advancedlinks-search-' . $randomizer . '" name="ts-advancedlinks-search-' . $randomizer . '" class="ts-advancedlinks-search" value="" placeholder="' . __( "Enter a name or ID to search for a post or page ...", "ts_visual_composer_extend" ) . '">';
                            $output .= '<div id="ts-advancedlinks-search-error-' . $randomizer . '" class="ts-advancedlinks-search-error">' . __( "No matches could be found!", "ts_visual_composer_extend" ) . '</div>';
                        $output .= '</div>';
                        // Standard Page Link via ID
                        $output .= '<div id="ts-advancedlinks-pages-holder-' . $randomizer . '" class="ts-advancedlinks-pages-holder" style="' . $display_page . ' margin: 10px 0 0 0; padding: 0;">';
                            $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-pages-' . $randomizer . '">' . __( "Select the page you want to link to:", "ts_visual_composer_extend" ) . '<span class="ts-advancedlinks-spinner ts-advancedlinks-spinner-hidden"></span></label>';
                            $output .= '<ul name="ts-advancedlinks-pages-' . $randomizer . '" id="ts-advancedlinks-pages-' . $randomizer . '" class="ts-advancedlinks-scroller ts-advancedlinks-pages" value="' . ($link_source == "page" ? $link_id : '') . '" data-total="' . $totalPages . '">';
                                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['global'] == "false") {
                                    foreach ($availablePages as $page) {
                                        $countPages++;
                                        $output .= '<li class="" data-link="' . $page['link'] . '" data-name="' . $page['name'] . '" data-id="' . $page['value'] . '"';
                                            $output .= '' . $page['name'] . ' (' . $page['value'] . ')';
                                        $output .= '</li>';
                                    }
                                }
                            $output .= '</ul>';
                        $output .= '</div>';
                        // Standard Post Link via ID
                        if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['posts'] == "true") {
                            $output .= '<div id="ts-advancedlinks-posts-holder-' . $randomizer . '" class="ts-advancedlinks-posts-holder" style="' . $display_post . ' margin: 10px 0 0 0; padding: 0;">';
                                $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-posts-' . $randomizer . '">' . __( "Select the standard post you want to link to:", "ts_visual_composer_extend" ) . '<span class="ts-advancedlinks-spinner ts-advancedlinks-spinner-hidden"></label>';                        
                                $output .= '<ul name="ts-advancedlinks-posts-' . $randomizer . '" id="ts-advancedlinks-posts-' . $randomizer . '" class="ts-advancedlinks-scroller ts-advancedlinks-posts" value="' . ($link_source == "post" ? $link_id : '') . '" data-total="' . $totalPosts . '">';
                                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['global'] == "false") {
                                        foreach ($availablePosts as $post) {
                                            $countPosts++;
                                            $output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $post['name'] . '" data-id="' . $post['value'] . '">';
                                                $output .= '' . $post['name'] . ' (' . $post['value'] . ')';
                                            $output .= '</li>';
                                        }
                                    }
                                $output .= '</ul>';                            
                            $output .= '</div>';
                        }
                        // Custom Post Link via ID
                        if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['custom'] == "true") {
                            $output .= '<div id="ts-advancedlinks-custom-holder-' . $randomizer . '" class="ts-advancedlinks-custom-holder" style="' . $display_custom . ' margin: 10px 0 0 0; padding: 0;">';
                                $output .= '<label class="ts-advancedlinks-label" for="ts-advancedlinks-custom-' . $randomizer . '">' . __( "Select the custom post you want to link to:", "ts_visual_composer_extend" ) . '<span class="ts-advancedlinks-spinner ts-advancedlinks-spinner-hidden"></label>';
                                $output .= '<ul name="ts-advancedlinks-custom-' . $randomizer . '" id="ts-advancedlinks-custom-' . $randomizer . '" class="ts-advancedlinks-scroller ts-advancedlinks-custom" value="' . ($link_source == "custom" ? $link_id : '') . '" data-total="' . $totalCustom . '">';
                                    if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['global'] == "false") {
                                        foreach ($availableCustom as $post) {
                                            $countCustom++;
                                            $output .= '<li class="" data-link="' . $post['link'] . '" data-name="' . $post['name'] . '" data-id="' . $post['value'] . '">';
                                                $output .= '' . $post['type'] . ' - ' . $post['name'] . ' (' . $post['value'] . ')';
                                            $output .= '</li>';
                                        }
                                    }
                                $output .= '</ul>';   
                            $output .= '</div>';
                        }
                    $output .= '</div>';
                $output .= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_LinkPicker')) {
        $TS_Parameter_LinkPicker = new TS_Parameter_LinkPicker();
    }
?>