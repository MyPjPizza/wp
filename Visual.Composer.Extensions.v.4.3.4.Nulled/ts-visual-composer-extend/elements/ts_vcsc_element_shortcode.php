<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      => __( "TS Shortcode", "ts_visual_composer_extend" ),
		"base"                      => "TS-VCSC-Shortcode",
		"icon" 	                    => "ts-composer-element-icon-shortcode",
		"class"                     => "",
		"category"                  => __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               => __("Place any shortcode in your page", "ts_visual_composer_extend"),
		"admin_enqueue_js"        	=> "",
		"admin_enqueue_css"       	=> "",
		"params"                    => array(
			// Shortcode Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_1",
				"value"				=> "",
				"seperator"			=> "Shortcode Input",
				"description"       => ""
			),
			array(
				"type"              => "textarea_raw_html",
				"class"             => "",
				"heading"           => __( "Shortcode", "ts_visual_composer_extend" ),
				"param_name"        => "tscode",
				"value"             => base64_encode(""),
				"description"       => __( "Enter the shortcode with its full syntax here.", "ts_visual_composer_extend" ),
				"dependency"		=> ""
			),
			array(
				"type"				=> "hidden_textarea",
				"class"				=> "",
				"heading"			=> __( "Shortcode Key", "ts_visual_composer_extend" ),
				"param_name"		=> "tscodenormal",
				"value"				=> "",
				"description"       => "",
				"admin_label"		=> true,
				"dependency"		=> ""
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