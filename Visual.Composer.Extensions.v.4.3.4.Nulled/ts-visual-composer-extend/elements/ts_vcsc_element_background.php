<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                              => __( "TS YouTube Background (Deprecated)", "ts_visual_composer_extend" ),
		"base"                              => "TS-VCSC-YouTube-Background",
		"icon" 	                            => "ts-composer-element-icon-background-youtube",
		"class"                             => "",
		"category"                          => __( "Deprecated", "ts_visual_composer_extend" ),
		"description"                       => __("Place a YouTube video as page background.", "ts_visual_composer_extend"),
		"admin_enqueue_js"            		=> "",
		"admin_enqueue_css"           		=> "",
		"deprecated" 						=> "3.0.0",
		"content_element"					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseDeprecatedElements == "true" ? true : false,
		"params"                            => array(
			// Divider Settings
			array(
				"type"                      => "seperator",
				"heading"                   => "",
				"param_name"                => "seperator_1",
				"value"						=> "",
				"seperator"					=> "Video Settings",
				"description"               => ""
			),		
			array(
				"type"              		=> "textfield",
				"heading"           		=> __( "YouTube Video ID", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_youtube",
				"value"             		=> "",                    
				"description"       		=> __( "Enter the YouTube video ID.", "ts_visual_composer_extend" ),
				"dependency"        		=> "",
			),
			array(
				"type"              		=> "switch_button",
				"heading"           		=> __( "Mute Video", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_mute",
				"value"             		=> "true",
				"admin_label" 				=> true,
				"description"           	=> __( "Switch the toggle to mute the video while playing.", "ts_visual_composer_extend" ),
				"dependency"            	=> ""
			),
			array(
				"type"              		=> "switch_button",
				"heading"           		=> __( "Loop Video", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_loop",
				"value"             		=> "false",
				"admin_label" 				=> true,
				"description"           	=> __( "Switch the toggle to loop the video after it has finished.", "ts_visual_composer_extend" ),
				"dependency"            	=> ""
			),
			array(
				"type"              		=> "switch_button",
				"heading"           		=> __( "Start Video on Pageload", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_start",
				"value"             		=> "false",
				"admin_label" 				=> true,
				"description"           	=> __( "Switch the toggle to if you want to start the video once the page has loaded.", "ts_visual_composer_extend" ),
				"dependency"            	=> ""
			),
			array(
				"type"              		=> "switch_button",
				"heading"           		=> __( "Show Video Controls", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_controls",
				"value"             		=> "true",
				"description"           	=> __( "Switch the toggle to if you want to show basic video controls.", "ts_visual_composer_extend" ),
				"dependency"            	=> ""
			),
			array(
				"type"              		=> "switch_button",
				"heading"           		=> __( "Show Raster over Background", "ts_visual_composer_extend" ),
				"param_name"        		=> "video_raster",
				"value"             		=> "false",
				"description"           	=> __( "Switch the toggle to if you want to show a raster over the background.", "ts_visual_composer_extend" ),
				"dependency"        		=> "",
			),
			// Load Custom CSS/JS File
			array(
				"type"                      => "load_file",
				"heading"                   => "",
				"param_name"                => "el_file",
				"value"                     => "",
				"file_type"                 => "js",
				"file_path"                 => "js/ts-visual-composer-extend-element.min.js",
				"description"               => ""
			),
		)
	);
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
		return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
	} else {			
		vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
	}
?>