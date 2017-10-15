<?php
    global $VISUAL_COMPOSER_EXTENSIONS;

	$TS_VCSC_QuForms 				= array ();
	if (function_exists('iphorm_get_all_forms')) {
		$quforms_forms 				= iphorm_get_all_forms();			
		foreach ($quforms_forms as $form) {
			$formID 				= $form['id'];
			$formName				= $form['name'];
			$formStatus				= $form['active'];
			if ($formStatus == 0) {
				$formName			= $formName . ' ' . __( "Inactive", "ts_visual_composer_extend" );
			}
			$TS_VCSC_QuForms[$formName]	= $formID;
		};
	}
	if (count($TS_VCSC_QuForms) == 0) {
		$TS_VCSC_QuForms[__("No QuForms found!", "ts_visual_composer_extend")]	= '-1';
	}
	
	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      => __( "Quform", "ts_visual_composer_extend" ),
		"base"                      => "iphorm",
		"icon" 	                    => "ts-composer-element-icon-quform",
		"class"                     => "",
		"category"                  => __( '3rd Party Plugins', "ts_visual_composer_extend" ),
		"description"               => __("Place a Quform form element", "ts_visual_composer_extend"),
		"admin_enqueue_js"			=> "",
		"admin_enqueue_css"			=> "",
		"params"                    => array(
			// QuForm Settings
			array(
				"type"              => "seperator",
				"heading"           => "",
				"param_name"        => "seperator_1",
				"value"				=> "",
				"seperator"			=> "Quform Form",
				"description"       => __( "", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "dropdown",
				"heading"           => __( "Quform Form", "ts_visual_composer_extend" ),
				"param_name"        => "id",
				"width"             => 300,
				"value"             => $TS_VCSC_QuForms,
				"admin_label"       => true,
				"save_always" 		=> true,
				"description"       => __( "Select the Quform Form you want to use.", "ts_visual_composer_extend" ),
			),				
			array(
				"type"              => "hidden_input",
				"heading"           => __( "Form Name", "ts_visual_composer_extend" ),
				"param_name"        => "name",
				"value"             => "",
				"admin_label"		=> true,
				"description"       => __( "", "ts_visual_composer_extend" )
			),
			array(
				"type"              => "messenger",
				"heading"           => "",
				"param_name"        => "messenger",
				"color"				=> "#FF0000",
				"value"				=> "",
				"message"           => __( "Please make sure that the QuForm Plugin is installed and activated.", "ts_visual_composer_extend" ),
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