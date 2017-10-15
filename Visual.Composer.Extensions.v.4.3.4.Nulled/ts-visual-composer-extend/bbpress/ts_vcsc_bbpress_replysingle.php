<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name" 							=> __("Single Reply", "ts_visual_composer_extend"),
		"base" 							=> "bbp-single-reply",
		"icon" 							=> "ts-composer-element-icon-bbpress", 
		"class" 						=> "", 
		"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
		"description"					=> __("Place a single reply", "ts_visual_composer_extend"),
		"admin_enqueue_js"				=> "",
		"admin_enqueue_css"				=> "",
		"show_settings_on_create" 		=> true,
		"params" 						=> array(
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_1",
				"value"					=> "",
				"seperator"         	=> "bbPress: " . __("Single Reply", "ts_visual_composer_extend"),
				"description"       	=> ""
			),
			array(
				"type"              	=> "messenger",
				"heading"           	=> "",
				"param_name"        	=> "messenger",
				"color"					=> "#006BB7",
				"size"					=> "14",
				"value"					=> "",
				"message"            	=> __( "This element will display a single reply.", "ts_visual_composer_extend" ),
				"description"       	=> __( "", "ts_visual_composer_extend" )
			),
			array(
				"type" 					=> "bbpress_replieslist",
				"heading" 				=> __("List of Replies", "ts_visual_composer_extend"),
				"param_name" 			=> "id"
			)
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>