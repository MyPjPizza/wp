<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	if (function_exists('vc_add_param')) {
		$TS_VCSC_RowToggleLimits			= get_option('ts_vcsc_extend_settings_rowVisibilityLimits', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Row_Toggle_Defaults);
		$TS_VCSC_RowOffsetSettings			= get_option('ts_vcsc_extend_settings_additionsOffsets', 	0);
		// ---------------------------
		// Main Row Setting Parameters
		// ---------------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger1",
			"color"							=> "#D10000",
			"size"							=> "14",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_1",
			"seperator"             		=> "Background Settings",
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Effects", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_bg_effects",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")							=> "",
				__( "Simple Image", "ts_visual_composer_extend")					=> "image",
				__( "Fixed Image", "ts_visual_composer_extend")						=> "fixed",
				__( "Image Slideshow", "ts_visual_composer_extend")					=> "slideshow",
				__( "Parallax Image", "ts_visual_composer_extend")					=> "parallax",
				__( "Automove Image", "ts_visual_composer_extend")					=> "automove",
				__( "Movement Image", "ts_visual_composer_extend")					=> "movement",
				__( "Single Color", "ts_visual_composer_extend")					=> "single",
				__( "Gradient Color", "ts_visual_composer_extend")					=> "gradient",				
				__( "Patternbolt Pattern", "ts_visual_composer_extend")				=> "patternbolt",				
				__( "Particlify Animation", "ts_visual_composer_extend")			=> "particles",
				__( "Trianglify Pattern", "ts_visual_composer_extend")				=> "triangle",
				__( "YouTube Video I", "ts_visual_composer_extend")					=> "youtubemb",
				__( "YouTube Video II", "ts_visual_composer_extend")				=> "youtube",
				__( "Selfhosted Video I", "ts_visual_composer_extend")				=> "videomb",
				__( "Selfhosted Video II", "ts_visual_composer_extend")				=> "video",
			),
			"admin_label" 					=> true,
			"description" 					=> __("Select the effect you want to apply to the row background.", "ts_visual_composer_extend"),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// ---------------------
		// Allow Mobile Settings
		// ---------------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Allow on Mobile", "ts_visual_composer_extend" ),
			"param_name"        			=> "enable_mobile",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to allow the effect to be applied on mobile devices as well; otherwise, a simple background image will be shown.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("parallax", "automove", "movement")),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// ---------------------------
		// Full Screen Height Settings
		// ---------------------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Full Screen Height", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_screen_height",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to set this row to full screen height (EXPERIMENTAL).", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Height Offset", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_screen_offset",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "500",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define an optional height offset to account for menu bars or other top fixed elements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_screen_height", "value" => "true"),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// -------------------
		// Min Height Settings
		// -------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Minimum Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_min_height",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "2048",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the minimum height for the row; use only if your theme doesn't provide a similar option and if there is no row content; set to 0 (zero) to disable.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_screen_height", "value" => "false"),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// -------------------
		// Full Width Settings
		// -------------------
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorFullWidthInternal == "false") {
			$TS_VCSC_FullWidthRowMessage	= __( "Define the number of parent containers the background should attempt to break away from.", "ts_visual_composer_extend" );
		} else {
			$TS_VCSC_FullWidthRowMessage	= __( "Define the number of parent containers the background should attempt to break away from; do NOT use in conjunction with VC's native full width setting, which should be used preferrably.", "ts_visual_composer_extend" );
		}
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Full Width Breakouts", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_break_parents",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "99",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> $TS_VCSC_FullWidthRowMessage,
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// -------
		// Z-Index
		// -------
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Z-Index for Background", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_zindex",
			"value"                 		=> "0",
			"min"                   		=> "-100",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the z-Index for the background; use only if theme requires an adjustment!", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
		));
		// --------------
		// Image Settings
		// --------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_2",
			"seperator"             		=> "Image Settings",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Background Image Retrieval", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_retrieve",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'Internal Single Image', "ts_visual_composer_extend" )	=> "single",
				__( 'External Single Image', "ts_visual_composer_extend" )	=> "external",
				__( 'Random Group Image', "ts_visual_composer_extend" )		=> "random",
			),
			"description"           		=> __( "Select whether you want to always show the same image or a random one from an image group.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_row_bg_image",
			"value"							=> "",
			"description"					=> __( "Select the background image for your row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_retrieve", "value" => 'single'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "External Image Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_extimage",
			"value"             			=> "",
			"description"       			=> __( "Enter the full path to the external image you want to use as background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_retrieve", "value" => 'external'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "attach_images",
			"heading"               		=> __( "Background Images Group", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_group",
			"value"                 		=> "",
			"description"       			=> __( "Select the background images for your row; will randomly select from group upon page load.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_retrieve", "value" => 'random'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "attach_images",
			"heading"               		=> __( "Select Images", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_slide_images",
			"value"                 		=> "",
			"description"       			=> __( "Select the images to be used for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Background Image Source", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_source",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'Full Size Image', "ts_visual_composer_extend" )			=> "full",
				__( 'Large Size Image', "ts_visual_composer_extend" )			=> "large",
				__( 'Medium Size Image', "ts_visual_composer_extend" )			=> "medium",
			),
			"description"           		=> __( "Select which image size based on WordPress settings should be used for the lightbox image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_position",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
				__( "Custom Value", "ts_visual_composer_extend" ) 				=> "custom",
			),
			"description" 					=> __("Select the position of the background image; will have most effect on smaller screens.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));		
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "Custom Image Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_position_custom",
			"value"             			=> "",
			"description"       			=> __( "Enter the custom position of the image, using either px or % (i.e. '25% 15%').", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_position", "value" => array("custom")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_size_standard",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_size_parallax",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "100%", "ts_visual_composer_extend" )			=> "100%",
				__( "110%", "ts_visual_composer_extend" )			=> "110%",
				__( "120%", "ts_visual_composer_extend" )			=> "120%",
				__( "130%", "ts_visual_composer_extend" )			=> "130%",
				__( "140%", "ts_visual_composer_extend" )			=> "140%",
				__( "150%", "ts_visual_composer_extend" )			=> "150%",
				__( "160%", "ts_visual_composer_extend" )			=> "160%",
				__( "170%", "ts_visual_composer_extend" )			=> "170%",
				__( "180%", "ts_visual_composer_extend" )			=> "180%",
				__( "190%", "ts_visual_composer_extend" )			=> "190%",
				__( "200%", "ts_visual_composer_extend" )			=> "200%",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("automove", "movement")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_repeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "parallax")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -------------------
		// Back Layer Settings
		// -------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_3",
			"seperator"             		=> "Fixed Background Layer",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("parallax", "automove")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Fixed Background Layer", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_backlayer",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'No Fixed Background Layer', "ts_visual_composer_extend" )			=> "none",
				__( 'Fixed Background Layer (Internal)', "ts_visual_composer_extend" )	=> "internal",
				__( 'Fixed Background Layer (External)', "ts_visual_composer_extend" )	=> "external",
			),
			"description"           		=> __( "Select whether you want to add a fixed non-animated background layer to the animated background image (background image needs to be semi-transparent).", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("parallax", "automove")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Layer Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_row_bg_backimage",
			"value"							=> "",
			"description"					=> __( "Select an image to be used as fixed background layer for the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_backlayer", "value" => 'internal'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "External Background Layer Image Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_backexternal",
			"value"             			=> "",
			"description"       			=> __( "Enter the full path to the external image you want to use as fixed background layer for the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_backlayer", "value" => 'external'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Layer Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_backrepeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"dependency" 					=> array("element" => "ts_row_bg_backlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Layer Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_backsize",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"dependency" 					=> array("element" => "ts_row_bg_backlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Layer Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_backposition",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
				__( "Custom Value", "ts_visual_composer_extend" ) 				=> "custom",
			),
			"dependency" 					=> array("element" => "ts_row_bg_backlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "Custom Image Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_backcustom",
			"value"             			=> "",
			"description"       			=> __( "Enter the custom position of the image, using either px or % (i.e. '25% 15%').", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_backposition", "value" => array("custom")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));
		// --------------------
		// Front Layer Settings
		// --------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_4",
			"seperator"             		=> "Fixed Foreground Layer",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("parallax", "automove")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "dropdown",
			"heading"               		=> __( "Fixed Foreground Layer", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_bg_frontlayer",
			"width"                 		=> 150,
			"value"                 		=> array(
				__( 'No Fixed Foreground Layer', "ts_visual_composer_extend" )			=> "none",
				__( 'Fixed Foreground Layer (Internal)', "ts_visual_composer_extend" )	=> "internal",
				__( 'Fixed Foreground Layer (External)', "ts_visual_composer_extend" )	=> "external",
			),
			"description"           		=> __( "Select whether you want to add a fixed non-animated foreground layer to the animated background image (layer image needs to be semi-transparent).", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("parallax", "automove")),			
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Foreground Layer Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_row_bg_frontimage",
			"value"							=> "",
			"description"					=> __( "Select a semi-transparent image to be used as fixed foreground layer for the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => 'internal'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "External Foreground Layer Image Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_frontexternal",
			"value"             			=> "",
			"description"       			=> __( "Enter the full path to the external image you want to use as fixed foreground layer for the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => 'external'),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Foreground Layer Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_frontrepeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Foreground Layer Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_frontsize",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Foreground Layer Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_frontposition",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
				__( "Custom Value", "ts_visual_composer_extend" ) 				=> "custom",
			),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
        vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "Custom Image Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_frontcustom",
			"value"             			=> "",
			"description"       			=> __( "Enter the custom position of the image, using either px or % (i.e. '25% 15%').", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_frontposition", "value" => array("custom")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "nouislider",
			"heading"           			=> __( "Foreground Opacity", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_bg_frontopacity",
			"value"             			=> "100",
			"min"               			=> "10",
			"max"               			=> "100",
			"step"              			=> "1",
			"unit"              			=> '%',
			"description"       			=> __( "Define the opacity for the foreground layer (useful if a non-transparent image is used).", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_frontlayer", "value" => array('internal', 'external')),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// ------------------
		// Slideshow Settings
		// ------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_5",
			"seperator"             		=> "Slideshow Settings",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Shuffle Images", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_shuffle",
			"value"             			=> "false",
			"description"           		=> __( "Switch the toggle to shuffle the images for a random order.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Show Controls", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_controls",
			"value"             			=> "true",
			"description"           		=> __( "Switch the toggle to show previous / next controls for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Use AutoPlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_auto",
			"value"             			=> "true",
			"description"           		=> __( "Switch the toggle to use an autoplay feature for the background slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "nouislider",
			"heading"           			=> __( "Transition Delay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_delay",
			"value"             			=> "5000",
			"min"               			=> "2000",
			"max"               			=> "20000",
			"step"              			=> "100",
			"unit"              			=> 'ms',
			"description"       			=> __( "Select the delay between each slide transition.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "switch_button",
			"heading"           			=> __( "Show Progress Bar", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_bar",
			"value"             			=> "true",
			"description"           		=> __( "Switch the toggle to show a progressbar for the delay timer.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Transition Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_transition",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Random", "ts_visual_composer_extend" )							=> "random",
				__( "Fade 1", "ts_visual_composer_extend" )							=> "fade",
				__( "Fade 2", "ts_visual_composer_extend" )							=> "fade2",
				__( "Blur 1", "ts_visual_composer_extend" )							=> "blur",
				__( "Blur 2", "ts_visual_composer_extend" )							=> "blur2",						
				__( "Flash 1", "ts_visual_composer_extend" )						=> "flash",
				__( "Flash 2", "ts_visual_composer_extend" )						=> "flash2",
				__( "Negative 1", "ts_visual_composer_extend" )						=> "negative",
				__( "Negative 2", "ts_visual_composer_extend" )						=> "negative2",						
				__( "Burn 1", "ts_visual_composer_extend" )							=> "burn",
				__( "Burn 2", "ts_visual_composer_extend" )							=> "burn2",
				__( "Slide Left 1", "ts_visual_composer_extend" )					=> "slideLeft",
				__( "Slide Left 2", "ts_visual_composer_extend" )					=> "slideLeft2",
				__( "Slide Right 1", "ts_visual_composer_extend" )					=> "slideRight",
				__( "Slide Right 2", "ts_visual_composer_extend" )					=> "slideRight2",						
				__( "Slide Up 1", "ts_visual_composer_extend" )						=> "slideUp",
				__( "Slide Up 2", "ts_visual_composer_extend" )						=> "slideUp2",
				__( "Slide Down 1", "ts_visual_composer_extend" )					=> "slideDown",
				__( "Slide Down 2", "ts_visual_composer_extend" )					=> "slideDown2",						
				__( "Zoom In 1", "ts_visual_composer_extend" )						=> "zoomIn",
				__( "Zoom In 2", "ts_visual_composer_extend" )						=> "zoomIn2",
				__( "Zoom Out 1", "ts_visual_composer_extend" )						=> "zoomOut",
				__( "Zoom Out 2", "ts_visual_composer_extend" )						=> "zoomOut2",						
				__( "Swirl Left 1", "ts_visual_composer_extend" )					=> "swirlLeft",
				__( "Swirl Left 2", "ts_visual_composer_extend" )					=> "swirlLeft2",
				__( "Swirl Right 1", "ts_visual_composer_extend" )					=> "swirlRight",
				__( "Swirl Right 2", "ts_visual_composer_extend" )					=> "swirlRight2",
			),
			"description"           		=> __( "Select the effect type to be used to transition between each slide.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "nouislider",
			"heading"           			=> __( "Transition Duration", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_slide_switch",
			"value"             			=> "2000",
			"min"               			=> "100",
			"max"               			=> "4000",
			"step"              			=> "100",
			"unit"              			=> 'ms',
			"description"       			=> __( "Select the duration each slide transition should last.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Horizontal Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "slide_halign",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Center", "ts_visual_composer_extend" )							=> "center",
				__( "Top", "ts_visual_composer_extend" )							=> "top",
				__( "Right", "ts_visual_composer_extend" )							=> "right",
				__( "Bottom", "ts_visual_composer_extend" )							=> "bottom",
				__( "Left", "ts_visual_composer_extend" )							=> "left",
			),
			"description"           		=> __( "Select the horizontal position of each image in the slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "Vertical Position", "ts_visual_composer_extend" ),
			"param_name"        			=> "slide_valign",
			"width"             			=> 300,
			"value"             			=> array(
				__( "Center", "ts_visual_composer_extend" )							=> "center",
				__( "Top", "ts_visual_composer_extend" )							=> "top",
				__( "Right", "ts_visual_composer_extend" )							=> "right",
				__( "Bottom", "ts_visual_composer_extend" )							=> "bottom",
				__( "Left", "ts_visual_composer_extend" )							=> "left",
			),
			"description"           		=> __( "Select the vertical position of each image in the slideshow.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("slideshow")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		// -----------------
		// Parallax Settings
		// -----------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_6",
			"seperator"             		=> "Parallax Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "parallax"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Parallax", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_parallax_type",
			"value" 						=> array(
				"Up"			=> "up",
				"Down"			=> "down",
				"Left"			=> "left",
				"Right"			=> "right",
			),
			"description" 					=> __("Select the parallax effect for your background image. You must have a background image to use this.", "ts_visual_composer_extend"),
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "parallax"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_alignment_v",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend" )				=> "center",
				__( "Left", "ts_visual_composer_extend" ) 				=> "left",
				__( "Right", "ts_visual_composer_extend" ) 				=> "right"
			),
			"description" 					=> __(""),
			"dependency" 					=> array( "element" => "ts_row_parallax_type", "value" => array("up", "down")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_row_bg_alignment_h",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend" )				=> "center",
				__( "Top", "ts_visual_composer_extend" ) 				=> "top",
				__( "Bottom", "ts_visual_composer_extend" ) 			=> "bottom",
			),
			"description" 					=> __(""),
			"dependency" 					=> array("element" => "ts_row_parallax_type", "value" => array("left", "right")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Parallax Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_parallax_speed",
			"value"                 		=> "20",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the animation speed for the parallax effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "parallax"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "FadeIn Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_parallax_fade",
			"value"                 		=> "1000",
			"min"                   		=> "0",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the duration for the FadeIn effect for the parallax background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "parallax"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// ------------------
		// Auto Move Settings
		// ------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_7",
			"seperator"             		=> "AutoMove Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "automove"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Motio Routine", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_automove_motio",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if the auto-movement effect should use the smoother Motio routine, or a basic interval setting.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "automove"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Automove Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_automove_speed",
			"value"                 		=> "75",
			"min"                   		=> "0",
			"max"                   		=> "1000",
			"step"                  		=> "1",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the AutoMove interval; the higher the value, the slower the movement.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_automove_motio", "value" => "false"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Automove Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_automove_pixels",
			"value"                 		=> "75",
			"min"                   		=> "0",
			"max"                   		=> "150",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the AutoMove speed in pixels; the higher the value, the faster the movement.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_automove_motio", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Automove Scroll", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_automove_scroll",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if the auto-moving image should scroll with the page or be fixed.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "automove"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Automove Path", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_align",
			"value" 						=> array(
				"Horizontal" => "horizontal",
				"Vertical" => "vertical",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "automove"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));	
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Moving Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_path_h",
			"value" 						=> array(
				"Left to Right"		=> "leftright",
				"Right to Left"		=> "rightleft",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_automove_align", "value" => "horizontal"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Moving Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_automove_path_v",
			"value" 						=> array(
				"Top to Bottom"		=> "topbottom",
				"Bottom to Top"		=> "bottomtop",
			),
			"description" 					=> __("Select the path the auto-moving image should be using.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_automove_align", "value" => "vertical"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -----------------
		// Movement Settings
		// -----------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_8",
			"seperator"             		=> "Movement Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "movement"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Horizontal (X) Movement", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_x_allow",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to have the background follow horizontal (x) movements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "movement"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Horizontal Ratio", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_movement_x_ratio",
			"value"                 		=> "10",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the ratio in pixels by how much the background is allowed to move horizontally.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_movement_x_allow", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Vertical (Y) Movement", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_y_allow",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to have the background follow vertical (y) movements.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "movement"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Vertical Ratio", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_row_movement_y_ratio",
			"value"                 		=> "10",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the ratio in pixels by how much the background is allowed to move vertically.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_movement_y_allow", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Move Content Elements", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_movement_content",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to move content elements with the background image.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "movement"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -----------------------
		// Single Color Background
		// -----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_9",
			"seperator"             		=> "Color Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "single"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Background Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "single_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the background color for the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "single"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -------------------------
		// Gradient Color Background
		// -------------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_10",
			"seperator"             		=> "Gradient Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "gradient"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Advanced Gradient", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradiant_advanced",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to use an advanced gradient generator with more options.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "gradient"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient Angle", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_angle",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "360",
			"step"                  		=> "1",
			"unit"                  		=> 'deg',
			"description"           		=> __( "Define the angle at which the gradient should spread.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Start Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradient_color_start",
			"value"            	 			=> "#cccccc",
			"description"       			=> __( "Define the start color for the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "End Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "gradient_color_end",
			"value"            	 			=> "#cccccc",
			"description"       			=> __( "Define the end color for the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient Start", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_start_offset",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '%',
			"description"           		=> __( "Define the beginning section of the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),			
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Gradient End", "ts_visual_composer_extend" ),
			"param_name"            		=> "gradient_end_offset",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '%',
			"description"           		=> __( "Define the end section of the gradient.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "false"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"heading" 						=> __("Gradient Generator", "ts_visual_composer_extend"),						
			"param_name" 					=> "gradient_generator",
			"description" 					=> __('Use the controls above to create a custom gradient background for the row.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "gradiant_advanced", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -------------------
		// Patternbolt Pattern
		// -------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_11",
			"seperator"             		=> "Patternbolt Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "patternbolt"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Patternbolt Pattern", "ts_visual_composer_extend"),
			"param_name" 					=> "patternbolt_type",
			"value" 						=> array(
				__( "Buseca", "ts_visual_composer_extend")						=> "ts-patternbolt-buseca",
				__( "Candy Bold", "ts_visual_composer_extend")					=> "ts-patternbolt-candy-bold",
				__( "Candy Medium", "ts_visual_composer_extend")				=> "ts-patternbolt-candy-medium",
				__( "Candy Light", "ts_visual_composer_extend")					=> "ts-patternbolt-candy-light",				
				__( "Cross (Standard) Bold", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-bold",
				__( "Cross (Standard) Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-medium",
				__( "Cross (Standard) Light", "ts_visual_composer_extend")		=> "ts-patternbolt-cross-default-light",				
				__( "Cross (Thin) Bold", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-bold",
				__( "Cross (Thin) Medium", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-medium",
				__( "Cross (Thin) Light", "ts_visual_composer_extend")			=> "ts-patternbolt-cross-thin-light",				
				__( "Horizontal Lines Bold", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-bold",
				__( "Horizontal Lines Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-medium",
				__( "Horizontal Lines Light", "ts_visual_composer_extend")		=> "ts-patternbolt-horizontal-lines-light",				
				__( "Diagonal Lines Bold", "ts_visual_composer_extend")			=> "ts-patternbolt-diagonal-lines-bold",
				__( "Diagonal Lines Medium", "ts_visual_composer_extend")		=> "ts-patternbolt-diagonal-lines-medium",
				__( "Diagonal Lines Light", "ts_visual_composer_extend")		=> "ts-patternbolt-diagonal-lines-light",					
			),
			"description" 					=> __("Select which Patternbolt pattern you want to use as row background.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "patternbolt"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Patternbolt Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "patternbolt_color",
			"value"            	 			=> "#ff9659",
			"description"       			=> __( "Define the background color for the pattern blocks.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "patternbolt"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Patternbolt Size", "ts_visual_composer_extend" ),
			"param_name"            		=> "patternbolt_size",
			"value"                 		=> "40",
			"min"                   		=> "10",
			"max"                   		=> "250",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the size of the pattern blocks.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "patternbolt"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Patternbolt Opacity", "ts_visual_composer_extend" ),
			"param_name"            		=> "patternbolt_opacity",
			"value"                 		=> "75",
			"min"                   		=> "10",
			"max"                   		=> "100",
			"step"                  		=> "1",
			"unit"                  		=> '%',
			"description"           		=> __( "Define the opacity of the pattern blocks.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "patternbolt"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -----------------
		// Trianglify Canvas
		// -----------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_12",
			"seperator"             		=> "Trianglify Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Trianglify Render", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_render",
			"value" 						=> array(
				__( "Canvas Element", "ts_visual_composer_extend")				=> "canvas",
				__( "Fixed Image", "ts_visual_composer_extend")					=> "fixed",
				__( "Scroll Image", "ts_visual_composer_extend")				=> "scroll",
			),
			"description" 					=> __("Select how the pattern for the Trianglify background should be rendered.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element"=> "ts_row_bg_effects", "value"=> "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Trianglify Pattern (X)", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_colorsx",
			"value" 						=> array(
				__( "Random Pattern", "ts_visual_composer_extend")				=> "random",
				__( "Custom Pattern", "ts_visual_composer_extend")				=> "custom",
				__( "Yellow - Green", "ts_visual_composer_extend")				=> "YlGn",
				__( "Yellow - Green - Blue", "ts_visual_composer_extend")		=> "YlGnBu",
				__( "Blue - Green", "ts_visual_composer_extend")				=> "BuGn",
				__( "Green - Blue", "ts_visual_composer_extend")				=> "GnBu",
				__( "Purple - Blue - Green", "ts_visual_composer_extend")		=> "PuBuGn",
				__( "Purple - Blue", "ts_visual_composer_extend")				=> "PuBu",
				__( "Red - Purple", "ts_visual_composer_extend")				=> "RdPu",
				__( "Purple - Red", "ts_visual_composer_extend")				=> "PuRd",
				__( "Orange - Red", "ts_visual_composer_extend")				=> "OrRd",
				__( "Yellow - Orange - Red", "ts_visual_composer_extend")		=> "YlOrRd",
				__( "Yellow - Orange - Brown", "ts_visual_composer_extend")		=> "YlOrBr",
				__( "Purples", "ts_visual_composer_extend")						=> "Purples",
				__( "Blues", "ts_visual_composer_extend")						=> "Blues",
				__( "Greens", "ts_visual_composer_extend")						=> "Greens",
				__( "Oranges", "ts_visual_composer_extend")						=> "Oranges",
				__( "Reds", "ts_visual_composer_extend")						=> "Reds",
				__( "Greys", "ts_visual_composer_extend")						=> "Greys",
				__( "Orange - Purple", "ts_visual_composer_extend")				=> "PuOr",
				__( "Brown - Green", "ts_visual_composer_extend")				=> "BrBG",
				__( "Purple - Green", "ts_visual_composer_extend")				=> "PRGn",
				__( "Pink - Yellow - Green", "ts_visual_composer_extend")		=> "PiYG",
				__( "Red - Blue", "ts_visual_composer_extend")					=> "RdBu",
				__( "Red - Grey", "ts_visual_composer_extend")					=> "RdGy",
				__( "Red - Yellow - Blue", "ts_visual_composer_extend")			=> "RdYlBu",
				__( "Spectral", "ts_visual_composer_extend")					=> "Spectral",
				__( "Red - Yellow - Green", "ts_visual_composer_extend")		=> "RdYlGn",
				__( "Accent", "ts_visual_composer_extend")						=> "Accent",
				__( "Dark", "ts_visual_composer_extend")						=> "Dark2",
				__( "Paired", "ts_visual_composer_extend")						=> "Paired",
				__( "Pastel 1", "ts_visual_composer_extend")					=> "Pastel1",
				__( "Pastel 2", "ts_visual_composer_extend")					=> "Pastel2",
				__( "Set 1", "ts_visual_composer_extend")						=> "Set1",
				__( "Set 2", "ts_visual_composer_extend")						=> "Set2",
				__( "Set 3", "ts_visual_composer_extend")						=> "Set3",
			),
			"description" 					=> __("Select the horizontal pattern for the Trianglify background.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"heading" 						=> __("Trianglify Generator (X)", "ts_visual_composer_extend"),						
			"param_name" 					=> "trianglify_generatorx",
			"trianglify"					=> "true",
			"message_picker"				=> __("The exact position of the color stops does not matter, only their general order.", "ts_visual_composer_extend"),
			"label_picker"					=> __("Define Color Stops", "ts_visual_composer_extend"),	
			"description" 					=> __('Use the controls above to create a custom horizontal color set for the Trianglify background.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "trianglify_colorsx", "value" => "custom"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Trianglify Pattern (Y)", "ts_visual_composer_extend"),
			"param_name" 					=> "trianglify_colorsy",
			"value" 						=> array(
				__( "Match Horizontal", "ts_visual_composer_extend")			=> "match_x",
				__( "Random Pattern", "ts_visual_composer_extend")				=> "random",
				__( "Custom Pattern", "ts_visual_composer_extend")				=> "custom",
				__( "Yellow - Green", "ts_visual_composer_extend")				=> "YlGn",
				__( "Yellow - Green - Blue", "ts_visual_composer_extend")		=> "YlGnBu",
				__( "Blue - Green", "ts_visual_composer_extend")				=> "BuGn",
				__( "Green - Blue", "ts_visual_composer_extend")				=> "GnBu",
				__( "Purple - Blue - Green", "ts_visual_composer_extend")		=> "PuBuGn",
				__( "Purple - Blue", "ts_visual_composer_extend")				=> "PuBu",
				__( "Red - Purple", "ts_visual_composer_extend")				=> "RdPu",
				__( "Purple - Red", "ts_visual_composer_extend")				=> "PuRd",
				__( "Orange - Red", "ts_visual_composer_extend")				=> "OrRd",
				__( "Yellow - Orange - Red", "ts_visual_composer_extend")		=> "YlOrRd",
				__( "Yellow - Orange - Brown", "ts_visual_composer_extend")		=> "YlOrBr",
				__( "Purples", "ts_visual_composer_extend")						=> "Purples",
				__( "Blues", "ts_visual_composer_extend")						=> "Blues",
				__( "Greens", "ts_visual_composer_extend")						=> "Greens",
				__( "Oranges", "ts_visual_composer_extend")						=> "Oranges",
				__( "Reds", "ts_visual_composer_extend")						=> "Reds",
				__( "Greys", "ts_visual_composer_extend")						=> "Greys",
				__( "Orange - Purple", "ts_visual_composer_extend")				=> "PuOr",
				__( "Brown - Green", "ts_visual_composer_extend")				=> "BrBG",
				__( "Purple - Green", "ts_visual_composer_extend")				=> "PRGn",
				__( "Pink - Yellow - Green", "ts_visual_composer_extend")		=> "PiYG",
				__( "Red - Blue", "ts_visual_composer_extend")					=> "RdBu",
				__( "Red - Grey", "ts_visual_composer_extend")					=> "RdGy",
				__( "Red - Yellow - Blue", "ts_visual_composer_extend")			=> "RdYlBu",
				__( "Spectral", "ts_visual_composer_extend")					=> "Spectral",
				__( "Red - Yellow - Green", "ts_visual_composer_extend")		=> "RdYlGn",
				__( "Accent", "ts_visual_composer_extend")						=> "Accent",
				__( "Dark", "ts_visual_composer_extend")						=> "Dark2",
				__( "Paired", "ts_visual_composer_extend")						=> "Paired",
				__( "Pastel 1", "ts_visual_composer_extend")					=> "Pastel1",
				__( "Pastel 2", "ts_visual_composer_extend")					=> "Pastel2",
				__( "Set 1", "ts_visual_composer_extend")						=> "Set1",
				__( "Set 2", "ts_visual_composer_extend")						=> "Set2",
				__( "Set 3", "ts_visual_composer_extend")						=> "Set3",
			),
			"description" 					=> __("Select the vertical pattern for the Trianglify background.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "advanced_gradient",
			"heading" 						=> __("Trianglify Generator (Y)", "ts_visual_composer_extend"),						
			"param_name" 					=> "trianglify_generatory",
			"trianglify"					=> "true",
			"message_picker"				=> __("The exact position of the color stops does not matter, only their general order.", "ts_visual_composer_extend"),
			"label_picker"					=> __("Define Color Stops", "ts_visual_composer_extend"),	
			"description" 					=> __('Use the controls above to create a custom vertical color set for the Trianglify background.', 'ts_visual_composer_extend'),
			"dependency" 					=> array("element" => "trianglify_colorsy", "value" => "custom"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Trianglify Cellsize", "ts_visual_composer_extend" ),
			"param_name"            		=> "trianglify_cellsize",
			"value"                 		=> "75",
			"min"                   		=> "25",
			"max"                   		=> "150",
			"step"                  		=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Specify the size of the mesh used to generate triangles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Trianglify Variance", "ts_visual_composer_extend" ),
			"param_name"            		=> "trianglify_variance",
			"value"                 		=> "0.75",
			"min"                   		=> "0",
			"max"                   		=> "1",
			"step"                  		=> "0.01",
			"decimals"						=> "2",
			"unit"                  		=> '',
			"description"           		=> __( "Specify the amount of randomness used when generating triangles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "triangle"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// --------------------
		// Particlify Animation
		// --------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_13",
			"seperator"             		=> "Particlify Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Number of Particles", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_count",
			"value"                 		=> "30",
			"min"                   		=> "2",
			"max"                   		=> "150",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'x',
			"description"           		=> __( "Specify the amount of particle elements; the more particles, the more the browser has work.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Particle Source", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_shape_source",
			"value" 						=> array(
				__( "Built-In Shapes", "ts_visual_composer_extend")				=> "internal",
				__( "Custom Image", "ts_visual_composer_extend")				=> "external",
			),
			"description" 					=> __("Select the type of shape you want to use for the particles.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			'type' 							=> "checkbox",
			'heading' 						=> __( 'Particle Shapes', 'ts_visual_composer_extend' ),
			'param_name' 					=> 'ts_particles_shape_types',								
			'value' 						=> array(
				__( 'Circle', 'ts_visual_composer_extend' ) 			=> 'circle',
				__( 'Edge', 'ts_visual_composer_extend' ) 				=> 'edge',
				__( 'Triangle', 'ts_visual_composer_extend' ) 			=> 'triangle',
				__( 'Polygon', 'ts_visual_composer_extend' ) 			=> 'polygon',
				__( 'Star', 'ts_visual_composer_extend' ) 				=> 'star',
				//__( 'Image', 'ts_visual_composer_extend' ) 			=> 'image',
			),
			"std"							=> "circle",
			"default"						=> "circle",
			"description" 					=> __( 'Select the particle shapes you want to use; you need to select at least one or enable the particle link option to see any animations.', 'ts_visual_composer_extend' ),
			"dependency" 					=> array("element" => "ts_particles_shape_source", "value" => "internal"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Particle Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_particles_shape_image",
			"value"							=> "",
			"description"					=> __( "Select the image you want to use for the particles; image should have a transparent background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_shape_source", "value" => "external"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Maximum Particle Size", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_size_max",
			"value"                 		=> "10",
			"min"                   		=> "5",
			"max"                   		=> "400",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'px',
			"description"           		=> __( "Specify the maximum size a particle can have.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particle Scaling", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_size_scale",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want the particles to be shown in various scaled sizes.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Scaling Animation", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_size_anim",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want particles to be animated when scaling.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_size_scale", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the color for the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Stroke Width", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_stroke_width",
			"value"                 		=> "0",
			"min"                   		=> "0",
			"max"                   		=> "10",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the stroke width for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Stroke Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_stroke_color",
			"value"            	 			=> "#000000",
			"description"       			=> __( "Define the stroke color for the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Type", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_back_type",
			"value" 						=> array(
				__( "Color", "ts_visual_composer_extend")						=> "color",
				__( "Image", "ts_visual_composer_extend")						=> "image",
			),
			"description" 					=> __("Select the type of background you want to show behind the particles.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Background Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_back_color",
			"value"            	 			=> "#b61924",
			"description"       			=> __( "Define the background color for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "color"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "ts_particles_back_image",
			"value"							=> "",
			"description"					=> __( "Select the background image for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Repeat", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_repeat",
			"value" 						=> array(
				__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
				__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
				__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
				__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
			),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Size", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_size",
			"value" 						=> array(
				__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
				__( "100%", "ts_visual_composer_extend" )			=> "100%",
				__( "110%", "ts_visual_composer_extend" )			=> "110%",
				__( "120%", "ts_visual_composer_extend" )			=> "120%",
				__( "130%", "ts_visual_composer_extend" )			=> "130%",
				__( "140%", "ts_visual_composer_extend" )			=> "140%",
				__( "150%", "ts_visual_composer_extend" )			=> "150%",
				__( "160%", "ts_visual_composer_extend" )			=> "160%",
				__( "170%", "ts_visual_composer_extend" )			=> "170%",
				__( "180%", "ts_visual_composer_extend" )			=> "180%",
				__( "190%", "ts_visual_composer_extend" )			=> "190%",
				__( "200%", "ts_visual_composer_extend" )			=> "200%",
				__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
				__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
				__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
			),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Background Position", "ts_visual_composer_extend" ),
			"param_name" 					=> "ts_particles_back_place",
			"value" 						=> array(
				__( "Center Center", "ts_visual_composer_extend" ) 				=> "center center",
				__( "Center Top", "ts_visual_composer_extend" )					=> "center top",
				__( "Center Bottom", "ts_visual_composer_extend" ) 				=> "center bottom",
				__( "Left Top", "ts_visual_composer_extend" ) 					=> "left top",
				__( "Left Center", "ts_visual_composer_extend" ) 				=> "left center",
				__( "Left Bottom", "ts_visual_composer_extend" ) 				=> "left bottom",
				__( "Right Top", "ts_visual_composer_extend" ) 					=> "right top",
				__( "Right Center", "ts_visual_composer_extend" ) 				=> "right center",
				__( "Right Bottom", "ts_visual_composer_extend" ) 				=> "right bottom",
			),
			"description" 					=> __("Select the position of the background image; will have most effect on smaller screens.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_particles_back_type", "value" => "image"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Link Particles", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_link_lines",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to link the particles with a line once in proximity to each other.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Particles Link Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_link_color",
			"value"            	 			=> "#ffffff",
			"description"       			=> __( "Define the color of the link line between the particles; you can only use HEX values and no alpha/opacity settings.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_link_lines", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Link Strength", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_link_width",
			"value"                 		=> "1",
			"min"                   		=> "1",
			"max"                   		=> "10",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> "px",
			"description"           		=> __( "Define the strength for the link lines between the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_link_lines", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_move",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want the particles to move.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Move Direction", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_particles_direction",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")				=> "none",
				__( "Top", "ts_visual_composer_extend")					=> "top",
				__( "Top - Right", "ts_visual_composer_extend")			=> "top-right",
				__( "Right", "ts_visual_composer_extend")				=> "right",
				__( "Bottom - Right", "ts_visual_composer_extend")		=> "bottom-right",
				__( "Bottom", "ts_visual_composer_extend")				=> "bottom",
				__( "Left", "ts_visual_composer_extend")				=> "left",
				__( "Top - Left", "ts_visual_composer_extend")			=> "top-left",
				
			),
			"description" 					=> __("Select how the background video should be attached to the row.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Randomizer", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_random",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to apply an additional randomizer to the move effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Move Straight", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_straight",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to straighten out the move effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Particle Move Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "ts_particles_speed",
			"value"                 		=> "6",
			"min"                   		=> "1",
			"max"                   		=> "20",
			"step"                  		=> "1",
			"decimals"						=> "0",
			"unit"                  		=> "",
			"description"           		=> __( "Define the moving speed for the particles.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_particles_move", "value" => "true"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Hover Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_hover",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want the particles to be affected when hovering over the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Particles Click Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_particles_click",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want the particles to be affected when clicking on the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => "particles"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// -------------------------
		// Video Attachment / Effect
		// -------------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_14",
			"seperator"             		=> "Video Settings",
			"dependency" 					=> array( "element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Video Attachment", "ts_visual_composer_extend"),
			"param_name" 					=> "multi_effect",
			"value" 						=> array(
				__( "Scroll", "ts_visual_composer_extend")				=> "fixed",
				__( "Fixed", "ts_visual_composer_extend")				=> "static",
				__( "Parallax", "ts_visual_composer_extend")			=> "parallax",
			),
			"description" 					=> __("Select how the background video should be attached to the row.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtubemb", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Parallax Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "multi_speed",
			"value"                 		=> "1",
			"min"                   		=> "-2",
			"max"                   		=> "2",
			"step"                  		=> "0.1",
			"decimals"						=> "1",
			"unit"                  		=> '',
			"description"           		=> __( "Define the speed and direction of the parallax; a negative value equals a downward parallax, while a positive value equals an upwards parallax movement.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "multi_effect", "value" => "parallax"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		// ------------------------
		// YouTube Video Background
		// ------------------------
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "YouTube Video ID", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_youtube",
			"value"             			=> "",
			"description"       			=> __( "Enter the YouTube video ID.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Background Image", "ts_visual_composer_extend" ),
			"param_name"					=> "video_background",
			"value"							=> "",
			"description"					=> __( "Select an alternative background image for the video on mobile devices; otherwise YouTube cover image will be used.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// ----------------------
		// HTML5 Video Background
		// ----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "MP4 Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_mp4",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the MP4 video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "OGV Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_ogv",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the OGV video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "textfield",
			"heading"           			=> __( "WEBM Video Path", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_webm",
			"value"             			=> "",
			"description"       			=> __( "Enter the path to the WEBM video version.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "attach_image",
			"heading"						=> __( "Video Screenshot Image", "ts_visual_composer_extend" ),
			"param_name"					=> "video_image",
			"value"							=> "",
			"description"					=> __( "Select the a screenshot image for the video.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Mute Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_mute",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to mute the video while playing.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Loop Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_loop",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to loop the video after it has finished.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_remove",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to remove (hide) the video after it has finished playing.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "video_loop", "value" => "false"),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Start Video on Pageload", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_start",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to if you want to start the video once the page has loaded.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));		
		/*vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Play Video on Hover", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_hover",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to if you want to play the video only when hovering over it.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));	*/	
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Stop Video once out of View", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_stop",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to if you want to stop the video once it is out of view and restart when it comes back into view.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Show Video Controls", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_controls",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to if you want to show basic video controls.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube", "youtubemb", "video", "videomb")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Show Raster over Video", "ts_visual_composer_extend" ),
			"param_name"        			=> "video_raster",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to if you want to show a raster over the video.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("youtube")),
			"group" 						=> __( "VCE Background", "ts_visual_composer_extend"),
		));
		// ---------------
		// Global Settings
		// ---------------		
		if ($TS_VCSC_RowOffsetSettings == 1) {
			vc_add_param("vc_row", array(
				"type"              			=> "seperator",
				"param_name"        			=> "seperator_15",
				"seperator"             		=> "Global Settings",
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Padding: Top", "ts_visual_composer_extend" ),
				"param_name"            		=> "padding_top",
				"value"                 		=> "30",
				"min"                   		=> "0",
				"max"                   		=> "250",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional top padding for the row.", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Padding: Bottom", "ts_visual_composer_extend" ),
				"param_name"            		=> "padding_bottom",
				"value"                 		=> "30",
				"min"                   		=> "0",
				"max"                   		=> "250",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional bottom padding for the row.", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles", "single", "gradient")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Left", "ts_visual_composer_extend" ),
				"param_name"            		=> "margin_left",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional left margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Right", "ts_visual_composer_extend" ),
				"param_name"            		=> "margin_right",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional right margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
		} else {
			vc_add_param("vc_row", array(
				"type"              			=> "seperator",
				"param_name"        			=> "seperator_15",
				"seperator"             		=> "Global Settings",
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Left", "ts_visual_composer_extend" ),
				"param_name"            		=> "ts_margin_left",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional left margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
			vc_add_param("vc_row", array(
				"type"                  		=> "nouislider",
				"heading"               		=> __( "Margin: Right", "ts_visual_composer_extend" ),
				"param_name"            		=> "ts_margin_right",
				"value"                 		=> "0",
				"min"                   		=> "-50",
				"max"                   		=> "100",
				"step"                  		=> "1",
				"unit"                  		=> 'px',
				"description"           		=> __( "Define an optional right margin for the background element (not the row).", "ts_visual_composer_extend" ),
				"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "triangle", "particles")),
				"group" 						=> __( "VCE Main", "ts_visual_composer_extend"),
			));
		}
		// -----------------------
		// Row Shapes / Separators
		// -----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger2",
			"color"							=> "#D10000",
			"size"							=> "14",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_16",
			"seperator"             		=> "KenBurns CSS3 Effect",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "gradient", "slideshow")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "dropdown",
			"heading"           			=> __( "KenBurns / Zoom Effect Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_kenburns_animation",
			"width"             			=> 300,
			"value"             			=> array(
				__( "None", "ts_visual_composer_extend" )							=> "null",
				__( "Random", "ts_visual_composer_extend" )							=> "random",
				__( "Basic Center Zoom", "ts_visual_composer_extend" )				=> "centerZoom",
				__( "Center Zoom + Fade Out", "ts_visual_composer_extend" )			=> "centerZoomFadeOut",
				__( "Center Zoom + Fade In", "ts_visual_composer_extend" )			=> "centerZoomFadeIn",
				__( "KenBurns Center", "ts_visual_composer_extend" )				=> "kenburns",
				__( "KenBurns Left", "ts_visual_composer_extend" )					=> "kenburnsLeft",
				__( "KenBurns Right", "ts_visual_composer_extend" )					=> "kenburnsRight",
				__( "KenBurns Up", "ts_visual_composer_extend" )					=> "kenburnsUp",						
				__( "KenBurns Up Left", "ts_visual_composer_extend" )				=> "kenburnsUpLeft",
				__( "KenBurns Up Right", "ts_visual_composer_extend" )				=> "kenburnsUpRight",
				__( "KenBurns Down", "ts_visual_composer_extend" )					=> "kenburnsDown",
				__( "KenBurns Down Left", "ts_visual_composer_extend" )				=> "kenburnsDownLeft",						
				__( "KenBurns Down Right", "ts_visual_composer_extend" )			=> "kenburnsDownRight",
			),
			"description"           		=> __( "Select the KenBurns or Zoom effect type to be applied to the background.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "gradient", "slideshow")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_17",
			"seperator"             		=> "Top Shapes",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Top Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_on",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to apply a SVG shape to the top of the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array(
				"element" 	=> "ts_row_bg_effects",
				"value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")
			),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Top SVG Shape", "ts_visual_composer_extend" ),
			"param_name" 					=> "svg_top_style",
			"value" 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_List,
			"description" 					=> __("Select the type of separator your want to apply to the top shape."),
			"dependency" 					=> array("element" => "svg_top_on", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Flip Top Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_flip",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to flip the top SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_top_style", "value" => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_FlipMe),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Top SVG Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_top_height",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description" 					=> __("Define the height of the top shape."),
			"dependency" 					=> array("element" => "svg_top_on", "value" => "true"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Top SVG Position", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_top_position",
			"value"                 		=> "0",
			"min"                   		=> "-300",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the exact position for the top SVG shape; you might have to adjust margins to avoid overlaps.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_top_style", "value" => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_FlipMe),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Top SVG Color Main", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_color1",
			"value"            	 			=> "#ffffff",
			"description" 					=> __("Define the main background color for the top SVG shape."),
			"dependency" 					=> array("element" => "svg_top_on", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Top SVG Color Alternate", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_top_color2",
			"value"            	 			=> "#ededed",
			"description" 					=> __( "Define the alternate background color for the top SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_top_style", "value" => array("14", "16")),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_18",
			"seperator"             		=> "Bottom Shapes",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Use Bottom Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_on",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to apply a SVG shape to the bottom of the row.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" 	=> "ts_row_bg_effects", "value" 	=> array("image", "fixed", "slideshow", "parallax", "gradient", "youtube", "youtubemb", "single", "automove", "movement", "particles", "video", "videomb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"class" 						=> "",
			"heading" 						=> __( "Bottom SVG Shape", "ts_visual_composer_extend" ),
			"param_name" 					=> "svg_bottom_style",
			"value" 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_List,
			"description" 					=> __("Select the type of separator your want to apply to the bottom shape."),
			"dependency" 					=> array("element" => "svg_bottom_on", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend" ),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Flip Bottom Shape", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_flip",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to flip the bottom SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_bottom_style", "value" => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_FlipMe),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Bottom SVG Height", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_bottom_height",
			"value"                 		=> "100",
			"min"                   		=> "0",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description" 					=> __("Define the height of the bottom shape."),
			"dependency" 					=> array("element" => "svg_bottom_on", "value" => "true"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Bottom SVG Position", "ts_visual_composer_extend" ),
			"param_name"            		=> "svg_bottom_position",
			"value"                 		=> "0",
			"min"                   		=> "-300",
			"max"                   		=> "300",
			"step"                  		=> "1",
			"unit"                  		=> 'px',
			"description"           		=> __( "Define the exact position for the bottom SVG shape; you might have to adjust margins to avoid overlaps.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_bottom_style", "value" => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_SVG_RowShapes_FlipMe),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Bottom SVG Color Main", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_color1",
			"value"            	 			=> "#ffffff",
			"description"           		=> __( "Define the main background color for the bottom SVG shape.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "svg_bottom_on", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Bottom SVG Color Alternate", "ts_visual_composer_extend" ),
			"param_name"        			=> "svg_bottom_color2",
			"value"            	 			=> "#ededed",
			"description" 					=> __("Define the alternate background color for the bottom SVG shape."),
			"dependency" 					=> array("element" => "svg_bottom_style", "value" => array("14", "16")),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// -------------
		// Other Effects
		// -------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_19",
			"seperator"             		=> "Other Effects",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "single", "automove", "movement", "particles", "video", "videomb", "youtubemb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ---------------
		// Raster Settings
		// ---------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Raster Overlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_raster_use",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to use a raster overlay with the background effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "gradient", "single", "automove", "movement", "particles", "video", "videomb", "youtubemb", "triangle", "patternbolt")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "background",
			"heading"           			=> __( "Raster Type", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_raster_type",
			"height"             			=> 200,
			"pattern"             			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Rasters_List,
			"value"							=> "",
			"encoding"          			=> "false",
			"asimage"						=> "false",
			"thumbsize"						=> 40,
			"description"       			=> __( "Select the raster pattern for the background effect.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_raster_use", "value" => "true"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// -------------
		// Color Overlay
		// -------------
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Color Overlay", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_overlay_use",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if you want to use a color overlay with the background effect; will only work with browser with RGBA support.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement", "video", "videomb", "youtubemb", "triangle")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "colorpicker",
			"heading"           			=> __( "Overlay Color", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_row_overlay_color",
			"value"            	 			=> "rgba(30,115,190,0.25)",
			"description" 					=> __("Define the overlay color; use the alpha channel setting to define the opacity of the overlay.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_overlay_use", "value" => "true"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// --------------------
		// Blur Effect Settings
		// --------------------
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Blur Strength", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_row_blur_strength",
			"value" 						=> array(
				__( "None", "ts_visual_composer_extend")					=> "",
				__( "Small Blur", "ts_visual_composer_extend")				=> "ts-background-blur-small",
				__( "Medium Blur", "ts_visual_composer_extend")				=> "ts-background-blur-medium",
				__( "Strong Blur", "ts_visual_composer_extend")				=> "ts-background-blur-strong",
			),
			"description" 					=> __("Define an optional blur strength for the background effect.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("image", "fixed", "slideshow", "parallax", "automove", "movement")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ----------------
		// Column Equalizer
		// ----------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_20",
			"seperator"             		=> "Column Height Equalizer",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_20",
			"seperator"             		=> "Column Height Equalizer",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Equal Column Heights", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_columns",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if all columns in this row should use an equal height, based on the tallest column.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Equal Column Heights", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_columns",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if all columns in this row should use an equal height, based on the tallest column.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Content Alignment", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_equalize_align",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend")					=> "center",
				__( "Top", "ts_visual_composer_extend")						=> "top",
				__( "Bottom", "ts_visual_composer_extend")					=> "bottom",
			),
			"description" 					=> __("Define how the column content should be vertically aligned inside each column.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_equalize_columns", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type" 							=> "dropdown",
			"heading" 						=> __( "Content Alignment", "ts_visual_composer_extend"),
			"param_name" 					=> "ts_equalize_align",
			"value" 						=> array(
				__( "Center", "ts_visual_composer_extend")					=> "center",
				__( "Top", "ts_visual_composer_extend")						=> "top",
				__( "Bottom", "ts_visual_composer_extend")					=> "bottom",
			),
			"description" 					=> __("Define how the column content should be vertically aligned inside each column.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_equalize_columns", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Maintain on Column Stack", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_stack",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if the equal column heights should be maintained even when columns are stacked on top of each other on small screens.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_equalize_columns", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Maintain on Column Stack", "ts_visual_composer_extend" ),
			"param_name"        			=> "ts_equalize_stack",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle if the equal column heights should be maintained even when columns are stacked on top of each other on small screens.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "ts_equalize_columns", "value" => "true"),
			"edit_field_class"				=> "vc_col-sm-6 vc_column",
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ------------------
		// Viewport Animation
		// ------------------
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_21",
			"seperator"             		=> "Animation Settings",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("", "image", "gradient", "single")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_21",
			"seperator"             		=> "Animation Settings",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("", "image", "gradient", "single")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type" 							=> "css3animations",
			"heading" 						=> __("Viewport Animation", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_view",
			"standard"						=> "false",
			"prefix"						=> "",
			"connector"						=> "css3animations_in",
			"noneselect"					=> "true",
			"default"						=> "",
			"value" 						=> "",
			"admin_label"					=> false,
			"description" 					=> __("Select a viewport animation for this row; it is advised not to use with (animated) parallax backgrounds.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("", "image", "gradient", "single")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type" 							=> "css3animations",
			"heading" 						=> __("Viewport Animation", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_view",
			"standard"						=> "false",
			"prefix"						=> "",
			"connector"						=> "css3animations_in",
			"noneselect"					=> "true",
			"default"						=> "",
			"value" 						=> "",
			"admin_label"					=> false,
			"description" 					=> __("Select a viewport animation for this row; it is advised not to use with (animated) parallax backgrounds.", "ts_visual_composer_extend"),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                      	=> "hidden_input",
			"heading"                   	=> __( "Animation Type", "ts_visual_composer_extend" ),
			"param_name"                	=> "css3animations_in",
			"value"                     	=> "",
			"admin_label"		        	=> true,
			"description"               	=> "",
			"dependency" 					=> array("element" => "ts_row_bg_effects", "value" => array("", "image", "gradient", "single")),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"                      	=> "hidden_input",
			"heading"                   	=> __( "Animation Type", "ts_visual_composer_extend" ),
			"param_name"                	=> "css3animations_in",
			"value"                     	=> "",
			"admin_label"		        	=> true,
			"description"               	=> "",			
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type" 							=> "viewport_offset",
			"class" 						=> "",
			"heading" 						=> __( "Animation Offset", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_offset",
			"value" 						=> '50%',
			"description" 					=> __("Define the offset (top of screen) that should trigger the viewport animation.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type" 							=> "viewport_offset",
			"class" 						=> "",
			"heading" 						=> __( "Animation Offset", "ts_visual_composer_extend"),
			"param_name" 					=> "animation_offset",
			"value" 						=> '50%',
			"description" 					=> __("Define the offset (top of screen) that should trigger the viewport animation.", "ts_visual_composer_extend"),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Repeat Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "animation_scroll",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to repeat the viewport effect when element has come out of view and comes back into viewport.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Repeat Effect", "ts_visual_composer_extend" ),
			"param_name"        			=> "animation_scroll",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to repeat the viewport effect when element has come out of view and comes back into viewport.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Animation Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "animation_speed",
			"value"                 		=> "2000",
			"min"                   		=> "1000",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the Length of the Viewport Animation in ms.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"                  		=> "nouislider",
			"heading"               		=> __( "Animation Speed", "ts_visual_composer_extend" ),
			"param_name"            		=> "animation_speed",
			"value"                 		=> "2000",
			"min"                   		=> "1000",
			"max"                   		=> "5000",
			"step"                  		=> "100",
			"unit"                  		=> 'ms',
			"description"           		=> __( "Define the Length of the Viewport Animation in ms.", "ts_visual_composer_extend" ),
			"dependency" 					=> array("element" => "animation_view", "not_empty" => true),
			"group" 						=> __( "VCE Effects", "ts_visual_composer_extend"),
		));
		// ----------------------
		// Row Visibility Toggles
		// ----------------------
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger3",
			"color"							=> "#D10000",
			"size"							=> "14",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger3",
			"color"							=> "#D10000",
			"size"							=> "14",
			"message"            			=> __( "The frontend editor of Visual Composer will not render any of the following settings. Changes will only be visible when viewing the page normally.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> 0,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_22",
			"seperator"             		=> "Device Visibility",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "seperator",
			"param_name"        			=> "seperator_22",
			"seperator"             		=> "Device Visibility",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));	
		vc_add_param("vc_row", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger5",
			"color"							=> "#006BB7",
			"size"							=> "14",
			"message"            			=> __( "You can define the minimum screen size requirements for each device in the general settings page for 'Composium - Visual Composer Extensions'.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"              			=> "messenger",
			"param_name"        			=> "messenger6",
			"color"							=> "#006BB7",
			"size"							=> "14",
			"message"            			=> __( "You can define the minimum screen size requirements for each device in the general settings page for 'Composium - Visual Composer Extensions'.", "ts_visual_composer_extend" ),
			"border_top"					=> "false",
			"margin_top" 					=> -10,
			"padding_top"					=> 0,
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));		
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Large Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_large",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on large screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Large Devices'] . " px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Large Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_large",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on large screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Large Devices'] . " px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Medium Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_medium",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on medium screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Medium Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Large Devices'] . "px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Medium Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_medium",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on medium screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Medium Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Large Devices'] . "px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_small",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on small screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Medium Devices'] . "px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_small",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on small screen devices", "ts_visual_composer_extend" ) . " (>= " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px / < " . $TS_VCSC_RowToggleLimits['Medium Devices'] . "px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Extra Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_extra",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on extra small screen devices", "ts_visual_composer_extend" ) . " (< " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Extra Small Devices", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_extra",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle if you want to show the row on extra small screen devices", "ts_visual_composer_extend" ) . " (< " . $TS_VCSC_RowToggleLimits['Small Devices'] . " px).",
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Row from DOM", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_remove",
			"value"             			=> "false",
			"description"       			=> __( "Switch the toggle to either fully remove the row from the page or just hide it.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		vc_add_param("vc_row_inner", array(
			"type"							=> "switch_button",
			"heading"           			=> __( "Remove Row from DOM", "ts_visual_composer_extend" ),
			"param_name"        			=> "show_remove",
			"value"             			=> "true",
			"description"       			=> __( "Switch the toggle to either fully remove the row from the page or just hide it.", "ts_visual_composer_extend" ),
			"group" 						=> __( "VCE Visibility", "ts_visual_composer_extend"),
		));
		// -------------------
		// Load Required Files
		// -------------------
		vc_add_param("vc_row", array(
			"type"                  		=> "load_file",
			"class" 						=> "",
			"heading"               		=> "",
			"param_name"            		=> "el_file1",
			"value"                 		=> "",
			"file_type"             		=> "js",
			"file_path"             		=> "js/ts-visual-composer-extend-element.min.js",
			"description"           		=> "",
		));
		vc_add_param("vc_row_inner", array(
			"type"                  		=> "load_file",
			"class" 						=> "",
			"heading"               		=> "",
			"param_name"            		=> "el_file1",
			"value"                 		=> "",
			"file_type"             		=> "js",
			"file_path"             		=> "js/ts-visual-composer-extend-element.min.js",
			"description"           		=> "",
		));
	}	
?>