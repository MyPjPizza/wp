<?php
    global $VISUAL_COMPOSER_EXTENSIONS;

	$TS_VCSC_GoPricing_Switch					= "false";
	$TS_VCSC_GoPricing_Array 					= array ();
	// GoPricing Version BEFORE 3.x
	$TS_VCSC_GoPricing_Tables					= get_option('go_pricing_tables', "");
	if (!is_array($TS_VCSC_GoPricing_Tables)) {		
		// GoPricing Version AFTER 3.x
		if (class_exists("GW_GoPricing_Data")) {
			$TS_VCSC_GoPricing_Switch			= "true";
			$TS_VCSC_GoPricing_Tables			= GW_GoPricing_Data::get_tables('', false, 'title', 'ASC');
			if (!is_array($TS_VCSC_GoPricing_Tables)) {
				$TS_VCSC_GoPricing_Tables		= array();
			}
		} else {
			$TS_VCSC_GoPricing_Tables			= array();
		}
	}
	// Loop Existing Tables
	foreach ($TS_VCSC_GoPricing_Tables as $pricing_table) {
		if ($TS_VCSC_GoPricing_Switch == "false") {
			$tableID 							= $pricing_table['table-id'];
			$tableName							= $pricing_table['table-name'];
		} else {
			$tableID 							= $pricing_table['id'];
			$tableName							= $pricing_table['name'];
		}
		$TS_VCSC_GoPricing_Array[$tableName]	= $tableID;
	};
	if (count($TS_VCSC_GoPricing_Array) == 0) {
		$TS_VCSC_GoPricing_Array[__("No GoPricing Tables found!", "ts_visual_composer_extend")]	= '-1';
	}
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      => __( "GoPricing Table", "ts_visual_composer_extend" ),
		"base"                      => "go_pricing",
		"icon" 	                    => "ts-composer-element-icon-go-pricing",
		"class"                     => "",
		"category"                  => __( '3rd Party Plugins', "ts_visual_composer_extend" ),
		"description"               => __("Place a GoPricing element", "ts_visual_composer_extend"),
		"admin_enqueue_js"			=> "",
		"admin_enqueue_css"			=> "",
		"params"                    => array(
			// GoPricing Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_1",
				"value"				=> "",
				"seperator"			=> "GoPricing Tables",
				"description"       => __( "", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Pricing Table", "ts_visual_composer_extend" ),
				"param_name"        => "id",
				"width"             => 300,
				"value"             => $TS_VCSC_GoPricing_Array,
				"admin_label"       => true,
				"save_always" 		=> true,
				"description"		=> __( "Select the GoPricing Table you want to insert.", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "nouislider",
				"heading"           => __( "Bottom Margin", "ts_visual_composer_extend" ),
				"param_name"        => "margin_bottom",
				"value"             => "20",
				"min"               => "0",
				"max"               => "500",
				"step"              => "1",
				"unit"              => 'px',
				"description"       => __( "Define a bottom margin for the GoPricing Table.", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "messenger",
				"heading"           => "",
				"param_name"        => "messenger",
				"color"				=> "#FF0000",
				"value"				=> "",
				"message"           => __( "Please make sure that the GoPricing Tables Plugin is installed and activated.", "ts_visual_composer_extend" ),
				"description"       => __( "", "ts_visual_composer_extend" )
			),
			// Load Custom CSS/JS File
			array(
				"type"              => "load_file",
				"heading"           => "",
				"param_name"        => "el_file",
				"value"             => "",
				"file_type"         => "js",
				"file_path"         => "js/ts-visual-composer-extend-element.min.js",
				"description"       => __( "", "ts_visual_composer_extend" )
			),
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	};
?>