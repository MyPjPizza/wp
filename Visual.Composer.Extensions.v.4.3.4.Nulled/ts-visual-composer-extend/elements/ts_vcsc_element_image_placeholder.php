<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      => __( "TS Image Placeholder", "ts_visual_composer_extend" ),
		"base"                      => "TS_VCSC_Image_Placeholder",
		"icon" 	                    => "ts-composer-element-icon-image-placeholder",
		"class"                     => "",
		"category"                  => __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               => __("Place a image placeholder element", "ts_visual_composer_extend"),
		"admin_enqueue_js"        	=> "",
		"admin_enqueue_css"       	=> "",
		"front_enqueue_js"			=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-image-placeholder.min.js')),
		"front_enqueue_css"			=> "",
		"params"                    => array(		
			// Style Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_2",
				"value"				=> "",
				"seperator"         => "Placeholder Styling",
				"description"       => ""
			),	
			array(
				"type"              => "dropdown",
				"heading"           => __( "Placeholder Theme", "ts_visual_composer_extend" ),
				"param_name"        => "theme",
				"width"             => 150,
				"value"             => array(
					__( "Random", "ts_visual_composer_extend" )					=> "random",
					__( "Sky", "ts_visual_composer_extend" )					=> "sky",
					__( "Vine", "ts_visual_composer_extend" )					=> "vine",
					__( "Lava", "ts_visual_composer_extend" )					=> "lava",
					__( "Gray", "ts_visual_composer_extend" )					=> "gray",
					__( "Industrial", "ts_visual_composer_extend" )				=> "industrial",
					__( "Social", "ts_visual_composer_extend" )					=> "social",
					__( "Custom", "ts_visual_composer_extend" )					=> "custom",
				),
				"admin_label"		=> true,
				"description"       => "",
			),				
			array(
				"type"              => "colorpicker",
				"heading"           => __( "Background Color", "ts_visual_composer_extend" ),
				"param_name"        => "background",
				"value"             => "#2a2025",
				"description"       => "",
				"dependency"        => array( 'element' => "theme", 'value' => 'custom' ),
			),
			array(
				"type"              => "colorpicker",
				"heading"           => __( "Foreground Color", "ts_visual_composer_extend" ),
				"param_name"        => "foreground",
				"value"             => "#ffffff",
				"description"       => "",
				"dependency"        => array( 'element' => "theme", 'value' => 'custom' ),
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Alignment", "ts_visual_composer_extend" ),
				"param_name"        => "position",
				"width"             => 150,
				"value"             => array(
					__( "Center", "ts_visual_composer_extend" )                        	=> "center",
					__( "Left", "ts_visual_composer_extend" )                          	=> "left",						
					__( "Right", "ts_visual_composer_extend" )                         	=> "right",
				),
				"description"       => "",
			),
			array(
				"type"              => "switch_button",
				"heading"           => __( "Outline / Diagonals", "ts_visual_composer_extend" ),
				"param_name"        => "outline",
				"value"             => "false",
				"admin_label"		=> true,
				"description"       => __( "Switch the toggle if you want to add an outline and diagonals to the placeholder image.", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Border Radius", "ts_visual_composer_extend" ),
				"param_name"        => "radius",
				"width"             => 150,
				"value"             => array(
					__( "None", "ts_visual_composer_extend" )                          	=> "",
					__( "Small Radius", "ts_visual_composer_extend" )                  	=> "ts-radius-small",
					__( "Medium Radius", "ts_visual_composer_extend" )                 	=> "ts-radius-medium",
					__( "Large Radius", "ts_visual_composer_extend" )                  	=> "ts-radius-large",
					__( "Full Circle", "ts_visual_composer_extend" )                   	=> "ts-radius-full"
				),
				"description"       => "",
			),	
			// Auto-Size Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_3",
				"value"				=> "",
				"seperator"         => "Size Settings",
				"description"       => "",
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "switch_button",
				"heading"           => __( "Ratio Placeholder", "ts_visual_composer_extend" ),
				"param_name"        => "auto_ratio",
				"value"             => "true",
				"admin_label"		=> true,
				"description"       => __( "Switch the toggle if you want to use a responsive placeholder that maintains its ratio based on fixed width and height settings.", "ts_visual_composer_extend" ),
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Placeholder Width", "ts_visual_composer_extend" ),
				"param_name"        => "auto_width",
				"value"             => "1280",
				"min"               => "100",
				"max"               => "1920",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Define the maximum width for the placeholder image in pixel.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "auto_ratio", 'value' => 'true' ),
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Placeholder Height", "ts_visual_composer_extend" ),
				"param_name"        => "auto_height",
				"value"             => "720",
				"min"               => "100",
				"max"               => "1080",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Define the maximum height for the placeholder image in pixel.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "auto_ratio", 'value' => 'true' ),
				"group"				=> "Size Settings"
			),
			// Other Size Settings
			array(
				"type"              => "switch_button",
				"heading"           => __( "Responsive Width", "ts_visual_composer_extend" ),
				"param_name"        => "width_responsive",
				"value"             => "true",
				"description"       => __( "Switch the toggle if you want the width of the placeholder image to be responsive.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "auto_ratio", 'value' => 'false' ),
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Placeholder Width", "ts_visual_composer_extend" ),
				"param_name"        => "width_percent",
				"value"             => "100",
				"min"               => "10",
				"max"               => "100",
				"step"              => "1",
				"unit"              => '%',
				"description"       => __( "Define the responsive width for the placeholder image in percent.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "width_responsive", 'value' => 'true' ),
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Placeholder Width", "ts_visual_composer_extend" ),
				"param_name"        => "width_pixel",
				"value"             => "250",
				"min"               => "50",
				"max"               => "1980",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Define the fixed width for the placeholder image in pixel.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "width_responsive", 'value' => 'false' ),
				"group"				=> "Size Settings"
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Placeholder Height", "ts_visual_composer_extend" ),
				"param_name"        => "height_pixel",
				"value"             => "200",
				"min"               => "10",
				"max"               => "1024",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Define the fixed height for the placeholder image in pixel.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "auto_ratio", 'value' => 'false' ),
				"group"				=> "Size Settings"
			),
			// Text Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_4",
				"value"				=> "",
				"seperator"         => "Text Settings",
				"description"       => "",
				"group"				=> "Text Settings",
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Placeholder Text", "ts_visual_composer_extend" ),
				"param_name"        => "text_type",
				"width"             => 150,
				"value"             => array(
					__( "Dimensions Only", "ts_visual_composer_extend" )				=> "standard",
					__( "Custom Text String", "ts_visual_composer_extend" )				=> "custom",						
					__( "None", "ts_visual_composer_extend" )                         	=> "none",
				),
				"description"       => "",
				"group"				=> "Text Settings",
			),		
			array(
				"type"              => "textfield",
				"heading"           => __( "Title", "ts_visual_composer_extend" ),
				"param_name"        => "text_string",
				"value"             => "",
				"description"       => __( "Enter the custom text string for the placeholder image; use 'holder_dimensions' to automatically show size settings.", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "text_type", 'value' => 'custom' ),
				"group"				=> "Text Settings",
			),
			array(
				"type"              => "switch_button",
				"heading"           => __( "Literal Dimensions", "ts_visual_composer_extend" ),
				"param_name"        => "text_literal",
				"value"             => "false",
				"admin_label"		=> true,
				"description"       => __( "Switch the toggle if you want to show the placeholder dimensions as a literal text string (otherwise, exact dimensions will be shown).", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "text_type", 'value' => array('standard', 'custom') ),
				"group"				=> "Text Settings",
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Minimum Font Size", "ts_visual_composer_extend" ),
				"param_name"        => "text_size",
				"value"             => "18",
				"min"               => "10",
				"max"               => "100",
				"step"              => "1",
				"unit"              => 'pt',
				"description"       => __( "Define the minimum font size for the placeholder text string (in points).", "ts_visual_composer_extend" ),
				"dependency"        => array( 'element' => "text_type", 'value' => array('standard', 'custom') ),
				"group"				=> "Text Settings",
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Text Weight", "ts_visual_composer_extend" ),
				"param_name"        => "text_weight",
				"width"             => 150,
				"value"             => array(
					__( 'Bold', "ts_visual_composer_extend" )     						=> "bold",
					__( 'Bolder', "ts_visual_composer_extend" )   						=> "bolder",
					__( 'Normal', "ts_visual_composer_extend" )   						=> "normal",
					__( 'Light', "ts_visual_composer_extend" )    						=> "300",
					__( 'Lighter', "ts_visual_composer_extend" )						=> "100",
				),
				"dependency"        => array( 'element' => "text_type", 'value' => array('standard', 'custom') ),
				"group"				=> "Text Settings",
			),
			/*array(
				"type"              => "dropdown",
				"heading"           => __( "Text Alignment", "ts_visual_composer_extend" ),
				"param_name"        => "text_align",
				"width"             => 150,
				"value"             => array(
					__( "Center", "ts_visual_composer_extend" )                        	=> "center",
					__( "Left", "ts_visual_composer_extend" )                          	=> "left",						
					__( "Right", "ts_visual_composer_extend" )                         	=> "right",
				),
				"description"       => "",
				"dependency"        => array( 'element' => "text_type", 'value' => array('standard', 'custom') ),
				"group"				=> "Text Settings",
			),*/
			// Other Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_8",
				"seperator"			=> "Other Settings",
				"value"				=> "",
				"description"       => "",
				"group" 			=> "Other Settings",
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Margin: Top", "ts_visual_composer_extend" ),
				"param_name"        => "margin_top",
				"value"             => "0",
				"min"               => "-50",
				"max"               => "500",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
				"group" 			=> "Other Settings",
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Margin: Bottom", "ts_visual_composer_extend" ),
				"param_name"        => "margin_bottom",
				"value"             => "20",
				"min"               => "-50",
				"max"               => "500",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
				"group" 			=> "Other Settings",
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "Define ID Name", "ts_visual_composer_extend" ),
				"param_name"        => "el_id",
				"value"             => "",
				"description"       => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
				"group" 			=> "Other Settings",
			),
			array(
				"type"              => "textfield",
				"heading"           => __( "Extra Class Name", "ts_visual_composer_extend" ),
				"param_name"        => "el_class",
				"value"             => "",
				"description"       => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
				"group" 			=> "Other Settings",
			),
			// Load Custom CSS/JS File
			array(
				"type"              => "load_file",
				"heading"           => "",
				"param_name"        => "el_file",
				"value"             => "",
				"file_type"         => "js",
				"file_path"         => "js/ts-visual-composer-extend-element.min.js",
				"description"       => ""
			),
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>