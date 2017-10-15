<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name" 							=> __("Lost Password Screen", "ts_visual_composer_extend"),
		"base" 							=> "bbp-lost-pass",
		"icon" 							=> "ts-composer-element-icon-bbpress", 
		"class" 						=> "", 
		"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
		"description"					=> __("Place a lost password screen", "ts_visual_composer_extend"),
		"admin_enqueue_js"				=> "",
		"admin_enqueue_css"				=> "",
		"show_settings_on_create" 		=> false,
		"php_class_name" 				=> "Vc_WooCommerce_NotEditable",
		"params" 						=> array(
			array(
				"type"              	=> "messenger",
				"heading"           	=> "",
				"param_name"        	=> "messenger",
				"color"					=> "#006BB7",
				"size"					=> "14",
				"value"					=> "",
				"message"            	=> __( "This element will display the lost password screen.", "ts_visual_composer_extend" ),
				"description"       	=> __( "", "ts_visual_composer_extend" )
			),
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>