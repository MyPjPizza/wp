<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	if (function_exists('vc_add_param')) {
		// Column Setting Parameters
		vc_add_param("vc_column", array(
			"type"              		=> "seperator",
			"heading"           		=> "",
			"param_name"        		=> "seperator_1",
			"value"						=> "",
			"seperator"					=> "Viewport Animation",
			"description"       		=> "",
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_column", array(
			"type" 						=> "css3animations",
			"class" 					=> "",
			"heading" 					=> __("Viewport Animation", "ts_visual_composer_extend"),
			"param_name" 				=> "animation_view",
			"standard"					=> "false",
			"prefix"					=> "",
			"connector"					=> "css3animations_in",
			"noneselect"				=> "true",
			"default"					=> "",
			"value" 					=> "",
			"admin_label"				=> false,
			"description" 				=> __("Select a Viewport Animation for this Column.", "ts_visual_composer_extend"),
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_column", array(
			"type"                      => "hidden_input",
			"heading"                   => __( "Animation Type", "ts_visual_composer_extend" ),
			"param_name"                => "css3animations_in",
			"value"                     => "",
			"admin_label"		        => true,
			"description"               => "",
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_column", array(
			"type" 						=> "viewport_offset",
			"class" 					=> "",
			"heading" 					=> __( "Animation Offset", "ts_visual_composer_extend"),
			"param_name" 				=> "animation_offset",
			"value" 					=> '50%',
			"description" 				=> __("Define the offset (top of screen) that should trigger the viewport animation.", "ts_visual_composer_extend"),
			"dependency" 				=> array("element" => "animation_view", "not_empty" => true),
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_column", array(
			"type"						=> "switch_button",
			"heading"           		=> __( "Repeat Effect", "ts_visual_composer_extend" ),
			"param_name"        		=> "animation_scroll",
			"value"             		=> "false",
			"description"       		=> __( "Switch the toggle to repeat the viewport effect when element has come out of view and comes back into viewport.", "ts_visual_composer_extend" ),
			"dependency" 				=> array("element" => "animation_view", "not_empty" => true),
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_column", array(
			"type"                  	=> "nouislider",
			"heading"               	=> __( "Animation Speed", "ts_visual_composer_extend" ),
			"param_name"            	=> "animation_speed",
			"value"                 	=> "2000",
			"min"                   	=> "1000",
			"max"                   	=> "5000",
			"step"                  	=> "100",
			"unit"                  	=> 'ms',
			"description"           	=> __( "Define the Length of the Viewport Animation in ms.", "ts_visual_composer_extend" ),
			"dependency" 				=> array("element" => "animation_view", "not_empty" => true),
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_column", array(
			"type"                  	=> "load_file",
			"class" 					=> "",
			"heading"               	=> "",
			"param_name"            	=> "el_file1",
			"value"                 	=> "",
			"file_type"             	=> "js",
			"file_path"             	=> "js/ts-visual-composer-extend-element.min.js",
			"description"           	=> "",
			"group" 					=> __( "VC Extensions", "ts_visual_composer_extend"),
		));
	}
?>