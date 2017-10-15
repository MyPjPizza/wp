<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
	// CSS3 Animation Preview
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      	=> __( "TS CSS3 Animations", "ts_visual_composer_extend" ),
		"base"                      	=> "TS_VCSC_Icon_Animations",
		"icon" 	                    	=> "ts-composer-element-icon-demo-elements",
		"class"                     	=> "",
		"category"                  	=> __( "VC Demos", "ts_visual_composer_extend" ),
		"description"               	=> __("Place a preview of CSS3 animations", "ts_visual_composer_extend"),
		"admin_enqueue_js"        		=> "",
		"admin_enqueue_css"       		=> "",
		"params"                    	=> array(
			array(
				"type"              	=> "messenger",
				"heading"           	=> "",
				"param_name"        	=> "messenger",
				"color"					=> "#006BB7",
				"size"					=> "14",
				"value"					=> "",
				"message"            	=> __( "This element will display a preview of included CSS3 animations, using icons from a specified icon font.", "ts_visual_composer_extend" ),
				"description"       	=> ""
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Icon Font", "ts_visual_composer_extend" ),
				"param_name"        	=> "font",
				"width"             	=> 150,
				"value"             	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Default_Icon_Fonts,
				"admin_label"       	=> true,
			),
			array(
				"type"              	=> "nouislider",
				"heading"           	=> __( "Icon Size", "ts_visual_composer_extend" ),
				"param_name"       	 	=> "size",
				"value"             	=> "16",
				"min"               	=> "16",
				"max"               	=> "512",
				"step"              	=> "1",
				"unit"              	=> 'px',
				"admin_label"       	=> true,
				"dependency"        	=> ""
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Icon Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "color",
				"value"            	 	=> "#000000",
				"dependency"        	=> ""
			),
			array(
				"type"              	=> "dropdown",
				"heading"           	=> __( "Animation Type", "ts_visual_composer_extend" ),
				"param_name"        	=> "animationtype",
				"width"             	=> 150,
				"admin_label"       	=> true,
				"value"             	=> array(
					__( "Default", "ts_visual_composer_extend" )                      	=> "Default",
					__( "Hover", "ts_visual_composer_extend" )                    		=> "Hover",
					__( "Viewport", "ts_visual_composer_extend" )                   	=> "Viewport",
				),
			),
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