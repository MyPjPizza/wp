<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      	=> __( "TS Icon 3D Button", "ts_visual_composer_extend" ),
		"base"                      	=> "TS_VCSC_Icon_Button",
		"icon" 	                    	=> "ts-composer-element-icon-icon-button",
		"class"                     	=> "",
		"category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               	=> __("Place an icon 3D button element", "ts_visual_composer_extend"),
		"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_Icon3DButtonViewCustom" : ""),
		"admin_enqueue_js"            	=> "",
		"admin_enqueue_css"           	=> "",
		"params"                    	=> array(
			// Link Settings
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_1",
				"value"					=> "",
				"seperator"				=> "Link + Title Settings",
				"description"       	=> ""
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Use for Page Navigation', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_navigate",
				"value"                 => "false",
				"admin_label"       	=> true,
				"description"		    => __( "Switch the toggle if you want to use this button to navigate to another section on the same page.", "ts_visual_composer_extend" ),
			),
			array(
				"type" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_ParameterLinkPicker['enabled'] == "false" ? "vc_link" : "advancedlinks"),
				"heading" 				=> __("Link + Title", "ts_visual_composer_extend"),
				"param_name" 			=> "link",
				"description" 			=> __("Provide a link to another site/page for the Icon Button.", "ts_visual_composer_extend"),
				"dependency"    		=> array( 'element' => 'scroll_navigate', 'value' => "false" ),
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Page Scroll Target", "ts_visual_composer_extend" ),
				"param_name"            => "scroll_target",
				"value"                 => "",
				"description"           => __( "Enter the unique ID for the page section you want to scroll to.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
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
			),
			array(
				"type"					=> "nouislider",
				"heading"				=> __( "Page Scroll Speed", "ts_visual_composer_extend" ),
				"param_name"			=> "scroll_speed",
				"value"					=> "2000",
				"min"					=> "1000",
				"max"					=> "10000",
				"step"					=> "100",
				"unit"					=> 'ms',
				"description"			=> __( "Define the speed that should be used to scroll to the section.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
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
			),
			array(
				"type"                  => "switch_button",
				"heading"			    => __( 'Add Target as Hashtag', "ts_visual_composer_extend" ),
				"param_name"		    => "scroll_hashtag",
				"edit_field_class"		=> "vc_col-sm-6 vc_column",
				"value"                 => "false",
				"description"		    => __( "Switch the toggle if you want to add the scroll target to the browser URL via hashtag.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "scroll_navigate", 'value' => 'true' ),
			),			
			array(
				"type"					=> "switch_button",
				"heading"				=> __( "Use Advanced Tooltip", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_css",
				"value"					=> "false",
				"description"       	=> __( "Switch the toggle if you want to apply am advanced tooltip to the image.", "ts_visual_composer_extend" )
			),
			array(
				"type"					=> "dropdown",
				"class"					=> "",
				"heading"				=> __( "Tooltip Position", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_position",
				"value"					=> array(
					__( "Top", "ts_visual_composer_extend" )                            => "ts-simptip-position-top",
					__( "Bottom", "ts_visual_composer_extend" )                         => "ts-simptip-position-bottom",
				),
				"description"			=> __( "Select the tooltip position in relation to the image.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "tooltip_css", 'value' => 'true' )
			),
			array(
				"type"					=> "dropdown",
				"class"					=> "",
				"heading"				=> __( "Tooltip Style", "ts_visual_composer_extend" ),
				"param_name"			=> "tooltip_style",
				"value"             	=> array(
					__( "Black", "ts_visual_composer_extend" )                          => "",
					__( "Gray", "ts_visual_composer_extend" )                           => "ts-simptip-style-gray",
					__( "Green", "ts_visual_composer_extend" )                          => "ts-simptip-style-green",
					__( "Blue", "ts_visual_composer_extend" )                           => "ts-simptip-style-blue",
					__( "Red", "ts_visual_composer_extend" )                            => "ts-simptip-style-red",
					__( "Orange", "ts_visual_composer_extend" )                         => "ts-simptip-style-orange",
					__( "Yellow", "ts_visual_composer_extend" )                         => "ts-simptip-style-yellow",
					__( "Purple", "ts_visual_composer_extend" )                         => "ts-simptip-style-purple",
					__( "Pink", "ts_visual_composer_extend" )                           => "ts-simptip-style-pink",
					__( "White", "ts_visual_composer_extend" )                          => "ts-simptip-style-white"
				),
				"description"			=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "tooltip_css", 'value' => 'true' )
			),
			// Button Settings
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_2",
				"value"					=> "",
				"seperator"				=> "Button Settings",
				"description"       	=> ""
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Button Align", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_align",
				"width"             	=> 300,
				"value"             	=> array(
					__( 'Center', "ts_visual_composer_extend" )      	=> "center",
					__( 'Left', "ts_visual_composer_extend" )			=> "left",
					__( 'Right', "ts_visual_composer_extend" )  		=> "right",
				),
				"description"       	=> __( "Select how the icon button should be aligned.", "ts_visual_composer_extend" ),
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Button Width", "ts_visual_composer_extend" ),
				"param_name"            => "button_width",
				"value"                 => "100",
				"min"                   => "0",
				"max"                   => "100",
				"step"                  => "1",
				"unit"                  => '%',
				"description"       	=> __( "Define the button width in percent (responsive).", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill') )
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button Type", "ts_visual_composer_extend" ),
				"param_name"            => "button_type",
				"width"                 => 300,
				"value"                 => array (
					__( "Square", "ts_visual_composer_extend" )                         => "square",
					__( "Rounded", "ts_visual_composer_extend" )                        => "rounded",
					__( "Pill", "ts_visual_composer_extend" )                           => "pill",
					__( "Circle", "ts_visual_composer_extend" )                         => "circle",
				),
				"admin_label"           => true,
				"description"           => __( "Select the general button type for the 'Read More' Link.", "ts_visual_composer_extend" ),
				"dependency"        	=> ""
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_square",
				"width"                 => 300,
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Square,
				"admin_label"           => true,
				"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => 'square' )
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_rounded",
				"width"                 => 300,
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Rounded,
				"admin_label"           => true,
				"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => 'rounded' )
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_pill",
				"width"                 => 300,
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Pill,
				"admin_label"           => true,
				"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => 'pill' )
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
				"param_name"            => "button_circle",
				"width"                 => 300,
				"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Circle,
				"admin_label"           => true,
				"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => 'circle' )
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Button Size", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_size",
				"width"             	=> 300,
				"value"             	=> array(
					__( 'Normal', "ts_visual_composer_extend" )			=> "ts-button-normal",
					__( 'Small', "ts_visual_composer_extend" )      	=> "ts-button-small",
					__( 'Tiny', "ts_visual_composer_extend" )  			=> "ts-button-tiny",
					__( 'Large', "ts_visual_composer_extend" )  		=> "ts-button-large",
					__( 'Jumbo', "ts_visual_composer_extend" )  		=> "ts-button-jumbo",
				),
				"description"       	=> __( "Select the size for the icon button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill') )
			),
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Add Button Wrapper", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_wrapper",
				"value"             	=> "false",
				"description"       	=> __( "Switch the toggle to add a wrapper frame around the 'Read More' button (most suited for 'pill' and 'circle' buttons).", "ts_visual_composer_extend" )
			),
			array(
				"type"              	=> "textfield",
				"heading"           	=> __( "Button Text", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_text",
				"value"             	=> "Read More",
				"description"       	=> __( "Enter a text for the 'Read More' button.", "ts_visual_composer_extend" ),
				"dependency"        	=> ""
			),
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Change Font Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_change",
				"value"             	=> "false",
				"description"       	=> __( "Switch the toggle to apply a custom font color to the button text.", "ts_visual_composer_extend" )
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Text Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_color",
				"value"             	=> "#666666",
				"description"       	=> __( "Define the color of the text for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_change", 'value' => 'true' )
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Font Size", "ts_visual_composer_extend" ),
				"param_name"            => "button_font",
				"value"                 => "18",
				"min"                   => "4",
				"max"                   => "100",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"       	=> __( "Define the font size for the icon / text in the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "button_type", 'value' => 'circle' )
			),
			// Icon Settings
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_3",
				"value"					=> "",
				"seperator"				=> "Icon Settings",
				"description"       	=> "",
				"group" 				=> "Icon Settings",
			),
			array(
				'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
				'heading' 				=> __( 'Button Icon', 'ts_visual_composer_extend' ),
				'param_name' 			=> 'icon',
				'value'					=> '',
				'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
				'settings' 				=> array(
					'emptyIcon' 				=> true,
					'type' 						=> 'extensions',
					'iconsPerPage' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
					'source' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
				),
				"admin_label"       	=> true,
				"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in button.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
				"dependency"        	=> "",
				"group" 				=> "Icon Settings",
			),	
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Change Icon Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "icon_change",
				"value"             	=> "false",
				"description"       	=> __( "Switch the toggle to apply a custom color to the button icon.", "ts_visual_composer_extend" ),
				"group" 				=> "Icon Settings",
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Icon Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "icon_color",
				"value"             	=> "#666666",
				"description"       	=> __( "Define the color of the icon for the button.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "icon_change", 'value' => 'true' ),
				"group" 				=> "Icon Settings",
			),
			// Other Settings
			array(
				"type"				    => "seperator",
				"heading"			    => "",
				"param_name"		    => "seperator_4",
				"value"					=> "",
				"seperator"				=> "Other Settings",
				"description"		    => "",
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
				"param_name"            => "margin_top",
				"value"                 => "20",
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
				"value"                 => "20",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
				"param_name"            => "el_id",
				"value"                 => "",
				"description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Extra Class Name", "ts_visual_composer_extend" ),
				"param_name"            => "el_class",
				"value"                 => "",
				"description"           => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			// Load Custom CSS/JS File
			array(
				"type"              	=> "load_file",
				"heading"           	=> "",
				"param_name"        	=> "el_file",
				"value"             	=> "",
				"file_type"         	=> "js",
				"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
				"description"       	=> ""
			),
		)
	);
		
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>