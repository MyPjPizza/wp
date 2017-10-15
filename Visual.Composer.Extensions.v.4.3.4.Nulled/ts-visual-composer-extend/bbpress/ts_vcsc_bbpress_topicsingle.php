<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name" 							=> __("Single Topic", "ts_visual_composer_extend"),
		"base" 							=> "bbp-single-topic",
		"icon" 							=> "ts-composer-element-icon-bbpress", 
		"class" 						=> "", 
		"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
		"description"					=> __("Place a single topic", "ts_visual_composer_extend"),
		"admin_enqueue_js"				=> "",
		"admin_enqueue_css"				=> "",
		"show_settings_on_create" 		=> true,
		"params" 						=> array(
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_1",
				"value"					=> "",
				"seperator"         	=> "bbPress: " . __("Single Topic", "ts_visual_composer_extend"),
				"description"       	=> ""
			),
			array(
				"type"              	=> "messenger",
				"heading"           	=> "",
				"param_name"        	=> "messenger",
				"color"					=> "#006BB7",
				"size"					=> "14",
				"value"					=> "",
				"message"            	=> __( "This element will display a single topic.", "ts_visual_composer_extend" ),
				"description"       	=> __( "", "ts_visual_composer_extend" )
			),
			array(
				"type" 					=> "bbpress_topicslist",
				"heading" 				=> __("List of Topics", "ts_visual_composer_extend"),
				"param_name" 			=> "forum_id"
			)
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>