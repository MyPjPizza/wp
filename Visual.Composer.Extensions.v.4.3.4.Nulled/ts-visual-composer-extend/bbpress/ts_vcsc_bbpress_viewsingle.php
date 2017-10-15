<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name" 							=> __("Single View", "ts_visual_composer_extend"),
		"base" 							=> "bbp-single-view",
		"icon" 							=> "ts-composer-element-icon-bbpress", 
		"class" 						=> "", 
		"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
		"description"					=> __("Place a cloud of topic tags", "ts_visual_composer_extend"),
		"admin_enqueue_js"				=> "",
		"admin_enqueue_css"				=> "",
		"show_settings_on_create" 		=> true,
		"params" 						=> array(
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_1",
				"value"					=> "",
				"seperator"         	=> "bbPress: " . __("Single View", "ts_visual_composer_extend"),
				"description"       	=> ""
			),
			array(
				"type"              	=> "messenger",
				"heading"           	=> "",
				"param_name"        	=> "messenger",
				"color"					=> "#006BB7",
				"size"					=> "14",
				"value"					=> "",
				"message"            	=> __( "This element will display topics associated with a specific view.", "ts_visual_composer_extend" ),
				"description"       	=> __( "", "ts_visual_composer_extend" )
			),
			array(
				"type" 					=> "dropdown",
				"heading" 				=> __("View", "ts_visual_composer_extend"),
				"param_name" 			=> "id",
				"value" 				=> array(
					__("Popular", "ts_visual_composer_extend")			=>'popular',
					__("No replies", "ts_visual_composer_extend")		=>'no-replies'
				)
			)
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>