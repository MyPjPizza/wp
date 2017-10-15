<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
	
    $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
		"name"                      	=> __( "TS Soundcloud", "ts_visual_composer_extend" ),
		"base"                      	=> "TS_VCSC_Soundcloud",
		"icon" 	                    	=> "ts-composer-element-icon-soundcloud",
		"class"                     	=> "",
		"category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
		"description"               	=> __("Place a Soundcloud element", "ts_visual_composer_extend"),
		"admin_enqueue_js"        		=> "",
		"admin_enqueue_css"       		=> "",
		"params"                    	=> array(
			// Soundcloud Settings
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_1",
				"value"					=> "",
				"seperator"             => "Soundcloud URL",
				"description"       	=> ""
			),
			array (
				"type" 					=> "textfield",
				"class" 				=> "",
				"heading" 				=> __("Soundcloud URL", "ts_visual_composer_extend"),
				"param_name" 			=> "url",
				"value" 				=> "",
				"description" 			=> __("Enter Soundcloud URL; for example 'https://soundcloud.com/the-bugle/bugle-179-playas-gon-play'.", "ts_visual_composer_extend"),
				"admin_label"       	=> true,
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Start Track", "ts_visual_composer_extend" ),
				"param_name"            => "start_track",
				"value"                 => "0",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => '',
				"description"           => __( "If link above represents a playlist, select the track the playlist should be started with.", "ts_visual_composer_extend" ),
			),
			array(
				"type"              	=> "seperator",
				"heading"           	=> "",
				"param_name"        	=> "seperator_2",
				"value"					=> "",
				"seperator"             => "Player Settings",
				"description"       	=> ""
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Auto-Play Audio", "ts_visual_composer_extend" ),
				"param_name"		    => "auto_play",
				"value"				    => "false",
				"description"		    => __( "Switch the toggle if you want to start playing the audio automatically.", "ts_visual_composer_extend" ),
				"admin_label"       	=> true,
			),
			array(
				"type"              	=> "colorpicker",
				"heading"           	=> __( "Button Color", "ts_visual_composer_extend" ),
				"param_name"        	=> "color",
				"value"             	=> "#ff7700",
				"description"       	=> __( "Define the color for the Play/Pause button.", "ts_visual_composer_extend" ),
				"dependency"        	=> ""
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show User Name", "ts_visual_composer_extend" ),
				"param_name"		    => "show_user",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the user name in the player.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Artwork", "ts_visual_composer_extend" ),
				"param_name"		    => "show_artwork",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the audio artwork in the player.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Playcount", "ts_visual_composer_extend" ),
				"param_name"		    => "show_playcount",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show a play count for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Comments", "ts_visual_composer_extend" ),
				"param_name"		    => "show_comments",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the comments for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Reposts", "ts_visual_composer_extend" ),
				"param_name"		    => "show_reposts",
				"value"				    => "false",
				"description"		    => __( "Switch the toggle if you want to show the reposts for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Hide Related", "ts_visual_composer_extend" ),
				"param_name"		    => "hide_related",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to hide related audio files.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Sharing", "ts_visual_composer_extend" ),
				"param_name"		    => "sharing",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the share options for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Download", "ts_visual_composer_extend" ),
				"param_name"		    => "download",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the download option for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Liking", "ts_visual_composer_extend" ),
				"param_name"		    => "liking",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the like options for the audio.", "ts_visual_composer_extend" ),
			),
			array(
				"type"             	 	=> "switch_button",
				"heading"			    => __( "Show Buying", "ts_visual_composer_extend" ),
				"param_name"		    => "buying",
				"value"				    => "true",
				"description"		    => __( "Switch the toggle if you want to show the buying options for the audio.", "ts_visual_composer_extend" ),
			),				
			// Other Settings
			array(
				"type"				    => "seperator",
				"heading"			    => "",
				"param_name"		    => "seperator_3",
				"value"					=> "",
				"seperator"				=> "Other Settings",
				"description"		    => "",
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
				"param_name"            => "margin_top",
				"value"                 => "0",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			array(
				"type"                  => "nouislider",
				"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
				"param_name"            => "margin_bottom",
				"value"                 => "0",
				"min"                   => "0",
				"max"                   => "200",
				"step"                  => "1",
				"unit"                  => 'px',
				"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
				"group" 				=> "Other Settings",
			),
			// Load Custom CSS/JS File
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