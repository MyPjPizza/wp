<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                          => __( "TS Image Basic Overlay", "ts_visual_composer_extend" ),
		"base"                          => "TS-VCSC-Image-Overlay",
		"icon"                          => "ts-composer-element-icon-image-overlay",
		"class"                         => "ts_vcsc_main_image_overlay",
		"category"                      => __( "VC Extensions", "ts_visual_composer_extend" ),
		"description" 		        	=> __("Place an image with text overlay", "ts_visual_composer_extend"),
		"admin_enqueue_js"            	=> "",
		"admin_enqueue_css"           	=> "",
		"params"                        => array(
			// Image Selection and Dimensions
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_1",
				"value"					=> "",
				"seperator"				=> "Image Selection / Dimensions",
				"description"           => ""
			),
			array(
				"type"                  => "attach_image",
				"holder" 				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
				"heading"               => __( "Image", "ts_visual_composer_extend" ),
				"param_name"            => "image",
				"class"					=> "ts_vcsc_holder_image",
				"value"                 => "",
				"admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
				"description"           => __( "Select the image you want to use.", "ts_visual_composer_extend" )
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Add Custom ALT Attribute", "ts_visual_composer_extend" ),
				"param_name"		    => "attribute_alt",
				"value"				    => "false",
				"description"       	=> __( "Switch the toggle if you want add a custom ALT attribute value, otherwise file name will be set.", "ts_visual_composer_extend" )
			),
			array(
				"type"                  => "textfield",
				"heading"               => __( "Enter ALT Value", "ts_visual_composer_extend" ),
				"param_name"            => "attribute_alt_value",
				"value"                 => "",
				"description"           => __( "Enter a custom value for the ALT attribute for this image.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "attribute_alt", 'value' => 'true' )
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"               => __( "Use Fixed Image Dimensions", "ts_visual_composer_extend" ),
				"param_name"            => "image_fixed",
				"value"                 => "false",
				"description"       	=> __( "Switch the toggle if you want to use a responsive width in % instead of px.", "ts_visual_composer_extend" )
			),
			/*array(
				"type"                  => "nouislider",
				"heading"               => __( "Image Width", "ts_visual_composer_extend" ),
				"param_name"            => "image_width_percent",
				"value"                 => "100",
				"min"                   => "1",
				"max"                   => "100",
				"step"                  => "1",
				"unit"                  => '%',
				"description"           => __( "Define the image width in %.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "image_fixed", 'value' => 'false' )
			),*/
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Image Width", "ts_visual_composer_extend" ),
				"param_name"            => "image_width",
				"value"                 => "300",
				"min"                   => "100",
				"max"                   => "1000",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Define the image width in px.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "image_fixed", 'value' => 'true' )
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Image Height", "ts_visual_composer_extend" ),
				"param_name"            => "image_height",
				"value"                 => "200",
				"min"                   => "75",
				"max"                   => "750",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Define the image height in px.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "image_fixed", 'value' => 'true' )
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Image Position", "ts_visual_composer_extend" ),
				"param_name"            => "image_position",
				"width"                 => 300,
				"value"					=> array(
					__( "Center", "ts_visual_composer_extend" )                         => "ts-imagefloat-center",
					__( "Float Left", "ts_visual_composer_extend" )                     => "ts-imagefloat-left",
					__( "Float Right", "ts_visual_composer_extend" )                    => "ts-imagefloat-right",
				),
				"description"           => __( "Define how to position the image.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "image_fixed", 'value' => 'true' )
			),
			// Hover Styles
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_2",
				"value"					=> "",
				"seperator"				=> "Hover Styles",
				"description"           => ""
			),
			array(
				"type"                  => "dropdown",
				"heading"               => __( "Hover Style", "ts_visual_composer_extend" ),
				"param_name"            => "hover_type",
				"width"                 => 300,
				"value"					=> array(
					__( "Style 1", "ts_visual_composer_extend" )                        => "ts-imagehover-style1",
					__( "Style 2", "ts_visual_composer_extend" )                        => "ts-imagehover-style2",
					__( "Style 3", "ts_visual_composer_extend" )                        => "ts-imagehover-style3",
					__( "Style 4", "ts_visual_composer_extend" )                        => "ts-imagehover-style4",
					__( "Style 5", "ts_visual_composer_extend" )                        => "ts-imagehover-style5",
					__( "Style 6", "ts_visual_composer_extend" )                        => "ts-imagehover-style6",
					__( "Style 7", "ts_visual_composer_extend" )                        => "ts-imagehover-style7",
					__( "Style 8", "ts_visual_composer_extend" )                        => "ts-imagehover-style8",
				),
				"admin_label"           => true,
				"description"           => __( "Select the overlay effect for the image.", "ts_visual_composer_extend" )
			),
			array(
				"type"					=> "dropdown",
				"heading"				=> __( "Overlay Trigger", "ts_visual_composer_extend" ),
				"param_name"			=> "overlay_trigger",
				"value"					=> array(
					__( "Hover", "ts_visual_composer_extend" )                          => "ts-trigger-hover",
					__( "Click", "ts_visual_composer_extend" )                          => "ts-trigger-click",
				),
				"admin_label"           => true,
				"description"			=> "",
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Border Type", "ts_visual_composer_extend" ),
				"param_name"        	=> "frame_type",
				"width"             	=> 300,
				"value"             	=> array(
					__( "None", "ts_visual_composer_extend" )                          => "",
					__( "Solid Border", "ts_visual_composer_extend" )                  => "solid",
					__( "Dotted Border", "ts_visual_composer_extend" )                 => "dotted",
					__( "Dashed Border", "ts_visual_composer_extend" )                 => "dashed",
					__( "Double Border", "ts_visual_composer_extend" )                 => "double",
					__( "Grouve Border", "ts_visual_composer_extend" )                 => "groove",
					__( "Ridge Border", "ts_visual_composer_extend" )                  => "ridge",
					__( "Inset Border", "ts_visual_composer_extend" )                  => "inset",
					__( "Outset Border", "ts_visual_composer_extend" )                 => "outset",
				),
				"admin_label"           => true,
				"description"       	=> __( "Select the type of border around the icon / image.", "ts_visual_composer_extend" ),
				"dependency"        	=> ""
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Border Thickness", "ts_visual_composer_extend" ),
				"param_name"        	=> "frame_thick",
				"value"             	=> "1",
				"min"               	=> "1",
				"max"               	=> "10",
				"step"              	=> "1",
				"unit"              	=> 'px',
				"description"       	=> __( "Define the thickness of the icon / image border.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values )
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Border Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "frame_color",
				"value"             	=> "#000000",
				"description"       	=> __( "Define the color of the icon / image border.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values )
			),
			array(
				"type"					=> "switch_button",
				"heading"				=> __( "Show Overlay on Start", "ts_visual_composer_extend" ),
				"param_name"			=> "hover_active",
				"value"					=> "false",
				"description"			=> __( "Switch the toggle if you want to show the overlay on page load.", "ts_visual_composer_extend" ),
				"dependency"			=> array( 'element' => "overlay_trigger", 'value' => array('ts-trigger-click') ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"               => __( "Show Overlay Handle", "ts_visual_composer_extend" ),
				"param_name"            => "overlay_handle_show",
				"value"                 => "true",
				"description"       	=> __( "Use the toggle to show or hide a handle button below the image.", "ts_visual_composer_extend" )
			),
			array(
				"type"                  => "colorpicker",
				"heading"               => __( "Handle Color", "ts_visual_composer_extend" ),
				"param_name"            => "overlay_handle_color",
				"value"                 => "#0094FF",
				"description"           => __( "Define the color for the overlay handle button.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "overlay_handle_show", 'value' => 'true' )
			),
			// Hover Content
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_3",
				"value"					=> "",
				"seperator"				=> "Hover Content",
				"description"           => "",
				"group" 				=> "Hover Content",
			),
			array(
				"type"                  => "textfield",
				"class"                 => "",
				"heading"               => __( "Title", "ts_visual_composer_extend" ),
				"param_name"            => "title",
				"value"                 => "",
				"description"	        => __( "Enter the title for the overlay content.", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Allow HTML Code", "ts_visual_composer_extend" ),
				"param_name"        	=> "message_code",
				"value"             	=> "false",
				"description"       	=> __( "Switch the toggle to allow for HTML code to create the overlay content.", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"                  => "textarea",
				"class"                 => "",
				"heading"               => __( "Message", "ts_visual_composer_extend" ),
				"param_name"            => "message",
				"value"                 => "",
				"description"	        => __( "Enter the main content for the image overlay; HTML code can NOT be used.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "message_code", 'value' => 'false' ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"              	=> "textarea_raw_html",
				"heading"           	=> __( "Content", "ts_visual_composer_extend" ),
				"param_name"        	=> "message_html",
				"value"             	=> base64_encode(""),
				"description"       	=> __( "Enter the main icon box content; HTML code can be used.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "message_code", 'value' => 'true' ),
				"group" 				=> "Hover Content",
			),				
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Message Truncation", "ts_visual_composer_extend" ),
				"param_name"        	=> "message_truncate",
				"value"             	=> "false",
				"description"       	=> __( "Switch the toggle if you want to automatically truncate the message via JS if the container is too small to show all elements.", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			// Hover Link
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_4",
				"value"					=> "",
				"seperator"				=> "Hover Link",
				"description"           => "",
				"group" 				=> "Hover Content",
			),
			array(
				"type"					=> "switch_button",
				"heading"           	=> __( "Text Button", "ts_visual_composer_extend" ),
				"param_name"        	=> "button_style",
				"value"             	=> "true",
				"description"       	=> __( "Switch the toggle to display a normal text button or icon button.", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"			        => "textfield",
				"class"			        => "",
				"heading"		        => __( "Button: Text", "ts_visual_composer_extend" ),
				"param_name"	        => "button_text",
				"value"			        => "Read More",
				"description"	        => __( "Enter the text to be shown in the overlay link button.", "ts_visual_composer_extend" ),
				"dependency"        	=> array( 'element' => "button_style", 'value' => 'true' ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"			        => "textfield",
				"class"			        => "",
				"heading"               => __( "Button: URL", "ts_visual_composer_extend" ),
				"param_name"	        => "button_url",
				"value"			        => "",
				"description"	        => __( "Enter the URL for the image overlay link (start with http://).", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			array(
				"type"			        => "dropdown",
				"class"			        => "",
				"heading"               => __( "Button: Link Target", "ts_visual_composer_extend" ),
				"param_name"	        => "button_target",
				"value"                 => array(
					__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
					__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
				),
				"description"	        => __( "Select how the image link should be opened.", "ts_visual_composer_extend" ),
				"group" 				=> "Hover Content",
			),
			// Image Tooltip
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_5",
				"value"					=> "",
				"seperator"				=> "Image Tooltip",
				"description"           => "",
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"               => __( "Use Advanced Tooltip", "ts_visual_composer_extend" ),
				"param_name"            => "tooltip_css",
				"value"                 => "false",
				"description"       	=> __( "Switch the toggle if you want to apply am advanced tooltip to the image.", "ts_visual_composer_extend" ),
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"                  => "textarea",
				"class"                 => "",
				"heading"               => __( "Tooltip Content", "ts_visual_composer_extend" ),
				"param_name"            => "tooltip_content",
				"value"                 => "",
				"description"           => __( "Enter the tooltip content here (do not use quotation marks).", "ts_visual_composer_extend" ),
				"dependency"            => "",
				"group" 				=> "Tooltip Settings",
			),
			array(
				"type"			        => "dropdown",
				"class"			        => "",
				"heading"               => __( "Tooltip Style", "ts_visual_composer_extend" ),
				"param_name"	        => "tooltip_style",
				"value"                 => array(
					__( "Black", "ts_visual_composer_extend" )                         => "",
					__( "Gray", "ts_visual_composer_extend" )                          => "ts-simptip-style-gray",
					__( "Green", "ts_visual_composer_extend" )                         => "ts-simptip-style-green",
					__( "Blue", "ts_visual_composer_extend" )                          => "ts-simptip-style-blue",
					__( "Red", "ts_visual_composer_extend" )                           => "ts-simptip-style-red",
					__( "Orange", "ts_visual_composer_extend" )                        => "ts-simptip-style-orange",
					__( "Yellow", "ts_visual_composer_extend" )                        => "ts-simptip-style-yellow",
					__( "Purple", "ts_visual_composer_extend" )                        => "ts-simptip-style-purple",
					__( "Pink", "ts_visual_composer_extend" )                          => "ts-simptip-style-pink",
					__( "White", "ts_visual_composer_extend" )                         => "ts-simptip-style-white"
				),
				"description"           => __( "Select the tooltip style.", "ts_visual_composer_extend" ),
				"dependency"            => array( 'element' => "tooltip_css", 'value' => 'true' ),
				"group" 				=> "Tooltip Settings",
			),
			// Other Settings
			array(
				"type"                  => "seperator",
				"heading"               => "",
				"param_name"            => "seperator_6",
				"value"					=> "",
				"seperator"				=> "Other Settings",
				"description"           => "",
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
	}
?>