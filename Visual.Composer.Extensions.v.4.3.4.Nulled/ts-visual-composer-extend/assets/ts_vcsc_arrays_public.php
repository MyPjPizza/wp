<?php
    // Create Public / Global Variables
    // --------------------------------
    if (TS_VCSC_WordPressCheckup('3.8') == "true") {
        $this->TS_VCSC_Installed_Icon_Fonts = array(
            "Font Awesome"                  	    => "Awesome",
            "Brankic 1979 Font"            		 	=> "Brankic",
            "Countricons Font"              		=> "Countricons",
            "Currencies Font"               		=> "Currencies",
            "Elegant Icons Font"            		=> "Elegant",
            "Entypo Font"                   		=> "Entypo",
            "Foundation Font"               		=> "Foundation",
            "Genericons Font"               		=> "Genericons",
            "IcoMoon Font"                  		=> "IcoMoon",
            "Ionicons Font"                  		=> "Ionicons",
            "MapIcons Font"                		    => "MapIcons",
            "Metrize Font"                		    => "Metrize",
            "Monuments Font"                		=> "Monuments",
            "Social Media Font"             		=> "SocialMedia",
            "Themify Font"                          => "Themify",
            "Typicons Font"                 		=> "Typicons",
            "Dashicons"                             => "Dashicons",
            "Custom User Font"              		=> "Custom",
        );
        $this->TS_VCSC_Icon_Font_Settings = array(
            "Font Awesome"                  	    => array("setting" => "Awesome",                "author" => "Dave Gandy",                           "type" => "Standard",       "default" => "true",		"active" => "true",     "always" => "false",        "class" => "ts-awesome-",               "count" => "605"),
            "Brankic 1979 Font"            		 	=> array("setting" => "Brankic",                "author" => "Brankic1979",                          "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-brankic-",               "count" => "350"),
            "Countricons Font"              		=> array("setting" => "Countricons",            "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-countricons-",           "count" => "194"),
            "Currencies Font"               		=> array("setting" => "Currencies",             "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-currencies-",            "count" => "89"),
            "Elegant Icons Font"            		=> array("setting" => "Elegant",                "author" => "Elegant Themes",                       "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-elegant-",               "count" => "360"),
            "Entypo Font"                   		=> array("setting" => "Entypo",                 "author" => "Entypo",                               "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-entypo-",                "count" => "284"),
            "Foundation Font"               		=> array("setting" => "Foundation",             "author" => "ZURB University",                      "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-foundation-",            "count" => "283"),
            "Genericons Font"               		=> array("setting" => "Genericons",             "author" => "Automatic",                            "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-genericons-",            "count" => "122"),
            "IcoMoon Font"                  		=> array("setting" => "IcoMoon",                "author" => "Keyamoon",                             "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-icomoon-",               "count" => "451"),
            "Ionicons Font"                  		=> array("setting" => "Ionicons",               "author" => "Ionic Framework",                      "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-ionicons-",              "count" => "601"),
            "MapIcons Font"                		    => array("setting" => "MapIcons",               "author" => "Scott De Jonge",                       "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-mapicons-",              "count" => "176"),
            "Metrize Font"                		    => array("setting" => "Metrize",                "author" => "Alessio Atzeni",                       "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-metrize-",               "count" => "300"),
            "Monuments Font"                		=> array("setting" => "Monuments",              "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-monuments-",             "count" => "255"),
            "Social Media Font"             		=> array("setting" => "SocialMedia",            "author" => "SimpleIcon",                           "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-socialmedia-",           "count" => "190"),
            "Themify Font"                 		    => array("setting" => "Themify",                "author" => "Themify",                              "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-themify-",               "count" => "352"),
            "Typicons Font"                 		=> array("setting" => "Typicons",               "author" => "Stephen Hutchings",                    "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-typicons-",              "count" => "308"),
            "Dashicons Font"              		    => array("setting" => "Dashicons",              "author" => "WordPress",                            "type" => "WordPress",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "dashicons-",                "count" => "201"),
            "Custom User Font"              		=> array("setting" => "Custom",                 "author" => "Custom User Font",                     "type" => "Custom",         "default" => "false",		"active" => "false",    "always" => "false",        "class" => "",                          "count" => "0"),
        );
    } else {
        $this->TS_VCSC_Installed_Icon_Fonts = array(
            "Font Awesome"                  	    => "Awesome",
            "Brankic 1979 Font"            		 	=> "Brankic",
            "Countricons Font"              		=> "Countricons",
            "Currencies Font"               		=> "Currencies",
            "Elegant Icons Font"            		=> "Elegant",
            "Entypo Font"                   		=> "Entypo",
            "Foundation Font"               		=> "Foundation",
            "Genericons Font"               		=> "Genericons",
            "IcoMoon Font"                  		=> "IcoMoon",
            "Ionicons Font"                  		=> "Ionicons",
            "MapIcons Font"                		    => "MapIcons",
            "Metrize Font"                		    => "Metrize",
            "Monuments Font"                		=> "Monuments",
            "Social Media Font"             		=> "SocialMedia",
            "Themify Font"                          => "Themify",
            "Typicons Font"                 		=> "Typicons",
            "Custom User Font"              		=> "Custom",
        );
        $this->TS_VCSC_Icon_Font_Settings = array(
            "Font Awesome"                  	    => array("setting" => "Awesome",                "author" => "Dave Gandy",                           "type" => "Standard",       "default" => "true",		"active" => "true",     "always" => "false",        "class" => "ts-awesome-",               "count" => "605"),
            "Brankic 1979 Font"            		 	=> array("setting" => "Brankic",                "author" => "Brankic1979",                          "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-brankic-",               "count" => "350"),
            "Countricons Font"              		=> array("setting" => "Countricons",            "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-countricons-",           "count" => "194"),
            "Currencies Font"               		=> array("setting" => "Currencies",             "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-currencies-",            "count" => "89"),
            "Elegant Icons Font"            		=> array("setting" => "Elegant",                "author" => "Elegant Themes",                       "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-elegant-",               "count" => "360"),
            "Entypo Font"                   		=> array("setting" => "Entypo",                 "author" => "Entypo",                               "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-entypo-",                "count" => "284"),
            "Foundation Font"               		=> array("setting" => "Foundation",             "author" => "ZURB University",                      "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-foundation-",            "count" => "283"),
            "Genericons Font"               		=> array("setting" => "Genericons",             "author" => "Automatic",                            "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-genericons-",            "count" => "122"),
            "IcoMoon Font"                  		=> array("setting" => "IcoMoon",                "author" => "Keyamoon",                             "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-icomoon-",               "count" => "451"),
            "Ionicons Font"                  		=> array("setting" => "Ionicons",               "author" => "Ionic Framework",                      "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-ionicons-",              "count" => "601"),
            "MapIcons Font"                		    => array("setting" => "MapIcons",               "author" => "Scott De Jonge",                       "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-mapicons-",              "count" => "176"),
            "Metrize Font"                		    => array("setting" => "Metrize",                "author" => "Alessio Atzeni",                       "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-metrize-",               "count" => "300"),
            "Monuments Font"                		=> array("setting" => "Monuments",              "author" => "Freepik",                              "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-monuments-",             "count" => "255"),
            "Social Media Font"             		=> array("setting" => "SocialMedia",            "author" => "SimpleIcon",                           "type" => "Specialty",      "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-socialmedia-",           "count" => "190"),
            "Themify Font"                 		    => array("setting" => "Themify",                "author" => "Themify",                              "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-themify-",               "count" => "352"),
            "Typicons Font"                 		=> array("setting" => "Typicons",               "author" => "Stephen Hutchings",                    "type" => "Standard",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "ts-typicons-",              "count" => "308"),
            "Custom User Font"              		=> array("setting" => "Custom",                 "author" => "Custom User Font",                     "type" => "Custom",         "default" => "false",		"active" => "false",    "always" => "false",        "class" => "",                          "count" => "0"),
        );
    }
    
    $this->TS_VCSC_Composer_Icon_Fonts = array(
        "Font Awesome (VC)"                  	    => "VC_Awesome",
        "Entypo Font (VC)"                          => "VC_Entypo",
        "Linecons Font (VC)"                        => "VC_Linecons",
        "Open Iconic Font (VC)"                     => "VC_OpenIconic",
        "Typicons Font (VC)"                        => "VC_Typicons",
    );
    $this->TS_VCSC_Composer_Font_Settings = array(
        "Font Awesome (VC)"                  	    => array("setting" => "VC_Awesome",             "author" => "Dave Gandy",                           "type" => "Composer",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "fa fa-",                    "count" => "605"),
        "Entypo Font (VC)"                          => array("setting" => "VC_Entypo",              "author" => "Entypo",                               "type" => "Composer",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "entypo-icon entypo-",       "count" => "284"),
        "Linecons Font (VC)"                        => array("setting" => "VC_Linecons",            "author" => "Smashing Magazine",                    "type" => "Composer",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "vc_li vc_li-",              "count" => "48"),
        "Open Iconic Font (VC)"                     => array("setting" => "VC_OpenIconic",          "author" => "Iconic",                               "type" => "Composer",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "vc-oi vc-oi-",              "count" => "151"),
        "Typicons Font (VC)"                        => array("setting" => "VC_Typicons",            "author" => "Stephen Hutchings",                    "type" => "Composer",       "default" => "false",		"active" => "false",    "always" => "false",        "class" => "typcn typcn-",              "count" => "336"),
    );

    
    // Single + Container Elements
    // ---------------------------
    $this->TS_VCSC_Visual_Composer_Elements = array(
        // Media Elements
        "TS Image Adipoli"						    => array("setting" => "ImageAdipoli",           "base" => "TS-VCSC-Image-Adipoli",                  "file" => "image_adipoli",              "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Picstrips"					    => array("setting" => "ImagePicstrips",         "base" => "TS-VCSC-Image-Picstrips",                "file" => "image_picstrips",            "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Caman"						    => array("setting" => "ImageCaman",             "base" => "TS-VCSC-Image-Caman",                    "file" => "image_caman",                "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Magnify"						    => array("setting" => "ImageMagnify",           "base" => "TS_VCSC_Image_Magnify",                  "file" => "image_magnify",              "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Switch"						    => array("setting" => "ImageSwitch",            "base" => "TS-VCSC-Image-Switch",                   "file" => "image_switch",               "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Scroll"						    => array("setting" => "ImageScroll",            "base" => "TS_VCSC_Image_Scroll",                   "file" => "image_scroll",               "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image 3D TiltFX"						=> array("setting" => "ImageTiltFX",            "base" => "TS_VCSC_Image_TiltFX",                   "file" => "image_tiltfx",               "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image SVG"						        => array("setting" => "ImageSVG",               "base" => "TS_VCSC_Image_SVG",                      "file" => "image_svg",                  "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Full"							    => array("setting" => "ImageFull",        	    "base" => "TS_VCSC_Image_Full",                     "file" => "image_full",                 "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Hotspot"					        => array("setting" => "ImageHotspot",           "base" => "TS_VCSC_Image_Hotspot_Container",        "file" => "image_hotspot",              "group" => "Media",         "type" => "class",		    "default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "4.3.0",  "children" => "0"),
        "TS Image Basic Overlay"				    => array("setting" => "ImageOverlay",           "base" => "TS-VCSC-Image-Overlay",                  "file" => "image_overlay",              "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Advanced Overlay"				    => array("setting" => "ImageEffects",           "base" => "TS_VCSC_Image_Hover_Effects",            "file" => "image_hovereffects",         "group" => "Media",         "type" => "class",		    "default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image iHover"					        => array("setting" => "ImageIHover",            "base" => "TS_VCSC_Image_IHover",                   "file" => "image_ihover",               "group" => "Media",         "type" => "class",		    "default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Link Grid"					    => array("setting" => "ImageGrid",              "base" => "TS_VCSC_Image_Link_Grid",                "file" => "image_grid",                 "group" => "Media",         "type" => "internal",       "default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Image Placeholder"					    => array("setting" => "ImagePlaceholder",       "base" => "TS_VCSC_Image_Placeholder",              "file" => "image_placeholder",          "group" => "Media",         "type" => "internal",       "default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Lightbox"						    => array("setting" => "LightboxImage",          "base" => "TS-VCSC-Lightbox-Image",                 "file" => "lightbox_image",             "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Image Gallery"					        => array("setting" => "LightboxGallery",        "base" => "TS_VCSC_Lightbox_Gallery",               "file" => "lightbox_gallery",           "group" => "Media",         "type" => "class",			"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Lightbox Gallery (Deprecated)"		    => array("setting" => "LightboxGalleryOld",     "base" => "TS-VCSC-Lightbox-Gallery",               "file" => "lightbox_gallery_old",       "group" => "Media",  		"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Soundcloud Player"                      => array("setting" => "Soundcloud",             "base" => "TS_VCSC_Soundcloud",                     "file" => "soundcloud",                 "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Mixcloud Player"                        => array("setting" => "Mixcloud",               "base" => "TS_VCSC_Mixcloud",                       "file" => "mixcloud",                   "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Audio HTML5"					        => array("setting" => "HTML5Audio",             "base" => "TS_VCSC_HTML5_Audio",                    "file" => "html5audio",                 "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Video HTML5"					        => array("setting" => "HTML5Video",             "base" => "TS_VCSC_HTML5_Video",                    "file" => "html5video",                 "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Video DailyMotion"					    => array("setting" => "DailyMotion",            "base" => "TS-VCSC-Motion",                         "file" => "dailymotion",                "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Video Vimeo"						    => array("setting" => "Vimeo",                  "base" => "TS-VCSC-Vimeo",                          "file" => "vimeo",                      "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Video YouTube"						    => array("setting" => "YouTube",                "base" => "TS-VCSC-Youtube",                        "file" => "youtube",                    "group" => "Media",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS YouTube Background (Deprecated)"        => array("setting" => "Background",             "base" => "TS-VCSC-YouTube-Background",             "file" => "background",                 "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Page Background"                        => array("setting" => "PageBackground",         "base" => "TS_VCSC_Page_Background",                "file" => "page_background",            "group" => "Media",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        // Google Elements
        "TS Google Charts"						    => array("setting" => "GoogleCharts",           "base" => "TS-VCSC-Google-Charts",                  "file" => "google_charts",              "group" => "Google",     	"type" => "internal",		"default" => "false",       "active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Google Tables"						    => array("setting" => "GoogleTables",           "base" => "TS-VCSC-Google-Tables",                  "file" => "google_tables",              "group" => "Google",     	"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Google Maps PLUS"			            => array("setting" => "GoogleMapsPlus",         "base" => "TS_VCSC_GoogleMapsPlus_Container",       "file" => "google_mapsplus",            "group" => "Google",       	"type" => "class",		    "default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "4.6.0",  "children" => "0"),
        "TS Google Maps (Deprecated)"			    => array("setting" => "GoogleMaps",             "base" => "TS-VCSC-Google-Maps",                    "file" => "google_maps",                "group" => "Google",       	"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Google Docs"						    => array("setting" => "GoogleDocs",             "base" => "TS-VCSC-Google-Docs",                    "file" => "google_docs",                "group" => "Google",       	"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Google Trends"						    => array("setting" => "GoogleTrends",           "base" => "TS-VCSC-Google-Trends",                  "file" => "google_trends",              "group" => "Google",     	"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Google Forms"						    => array("setting" => "GoogleForms",            "base" => "TS-VCSC-Google-Forms",                   "file" => "google_forms",               "group" => "Google",     	"type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        // Button + Link Elements
        "TS Icon 3D Button"						    => array("setting" => "IconButton",             "base" => "TS_VCSC_Icon_Button",                    "file" => "icon_button",                "group" => "Buttons",       "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Flex Button"					    => array("setting" => "IconFlexButton",         "base" => "TS_VCSC_Icon_Flex_Button",               "file" => "icon_flexbutton",            "group" => "Buttons",       "type" => "internal",		"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Flat Button"					    => array("setting" => "IconFlatButton",         "base" => "TS_VCSC_Icon_Flat_Button",               "file" => "icon_flatbutton",            "group" => "Buttons",       "type" => "internal",		"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Dual Button"					    => array("setting" => "IconDualutton",          "base" => "TS_VCSC_Icon_Dual_Button",               "file" => "icon_dualbutton",            "group" => "Buttons",       "type" => "internal",		"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Creative Link"					        => array("setting" => "CreativeLink",           "base" => "TS_VCSC_Creative_Link",                  "file" => "creativelink",               "group" => "Buttons",       "type" => "internal",		"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Figure Navigation"					    => array("setting" => "FigureNavigation",       "base" => "TS_VCSC_Figure_Navigation_Container",    "file" => "figure_navigation",          "group" => "Buttons",       "type" => "class",			"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),        
        // Counter Elements
        "TS Counter Icon"						    => array("setting" => "IconCounter",            "base" => "TS-VCSC-Icon-Counter",                   "file" => "icon_counter",      			"group" => "Counters",      "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Counter Circle"						    => array("setting" => "CircleCounter",          "base" => "TS-VCSC-Circliful",                      "file" => "circliful",         			"group" => "Counters",      "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Countdown"							    => array("setting" => "Countdown",              "base" => "TS-VCSC-Countdown",                      "file" => "countdown",         			"group" => "Counters",      "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Wave Gauge"						        => array("setting" => "WaveGauge",              "base" => "TS_VCSC_Wave_Gauge",                     "file" => "wavegauge",                  "group" => "Counters",      "type" => "internal",		"default" => "false",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),        
        // Post Type Elements
        "TS Posts Isotope Grid"					    => array("setting" => "Postsgrid",        	    "base" => "TS_VCSC_Posts_Grid_Standalone",          "file" => "postsgrid",                  "group" => "Posts",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Posts Image Grid"					    => array("setting" => "Postsimage",        	    "base" => "TS_VCSC_Posts_Image_Grid_Standalone",    "file" => "postsimage",                 "group" => "Posts",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Posts Slider"					        => array("setting" => "Postsslider",        	"base" => "TS_VCSC_Posts_Slider_Standalone",        "file" => "postsslider",                "group" => "Posts",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Posts Ticker"					        => array("setting" => "Poststicker",        	"base" => "TS_VCSC_Posts_Ticker_Standalone",        "file" => "poststicker",                "group" => "Posts",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Posts Timeline"					        => array("setting" => "Poststimeline",        	"base" => "TS_VCSC_Posts_Timeline_Standalone",      "file" => "poststimeline",              "group" => "Posts",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        // Title + Teaser Elements
        "TS Title Advanced"							=> array("setting" => "IconTitle",              "base" => "TS-VCSC-Icon-Title",                     "file" => "icon_title",                 "group" => "Titles",        "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Title Typed"						    => array("setting" => "TitleTyped",             "base" => "TS_VCSC_Title_Typed",                    "file" => "title_typed",                "group" => "Titles",        "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Title Ticker"						    => array("setting" => "TitleTicker",            "base" => "TS_VCSC_Title_Ticker",                   "file" => "title_ticker",               "group" => "Titles",        "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Title Textillate"					    => array("setting" => "Textillate",             "base" => "TS-VCSC-Textillate",                     "file" => "textillate",                 "group" => "Titles",        "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Title Flipboard"					    => array("setting" => "Flipboard",              "base" => "TS_VCSC_Title_Flipboard",                "file" => "title_flipboard",            "group" => "Titles",        "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Teaser Block"						    => array("setting" => "TeaserBlock",            "base" => "TS_VCSC_Teaser_Block_Standalone",        "file" => "teaser_block",      			"group" => "Titles",        "type" => "class",			"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        // Popup + Modal Elements
        "TS Modal Popup"						    => array("setting" => "ModalPopup",             "base" => "TS-VCSC-Modal-Popup",                    "file" => "modal",                      "group" => "Popups",        "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Amaran Popup"						    => array("setting" => "AmaranPopup",            "base" => "TS_VCSC_Amaran_Popup",                   "file" => "amaran",                     "group" => "Popups",        "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Element Focus"					        => array("setting" => "ElementFocus",    		"base" => "TS_VCSC_Element_Focus",                  "file" => "element_focus",  			"group" => "Popups",        "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        // Various (Other) Elements        
        "TS Advanced Textblock"                     => array("setting" => "TextBlock",    		    "base" => "TS_VCSC_Advanced_Textblock",             "file" => "textblock",  			    "group" => "Other",         "type" => "class",			"default" => "true",		"active" => "true",	    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Fonts"							    => array("setting" => "FontIcons",              "base" => "TS-VCSC-Font-Icons",                     "file" => "icon",              			"group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",	    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Box"							    => array("setting" => "IconBox",                "base" => "TS-VCSC-Icon-Box-Tiny",                  "file" => "icon_box_tiny",     			"group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Icon Box (Deprecated)"				    => array("setting" => "IconBoxOld",             "base" => "TS-VCSC-Icon-Box",                       "file" => "icon_box",          			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Icon List Item"						    => array("setting" => "IconList",               "base" => "TS-VCSC-Icon-List",                      "file" => "icon_listitem",     			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Info / Notice Panel"                    => array("setting" => "InfoNotice",             "base" => "TS_VCSC_Info_Notice",                    "file" => "info_notice",                "group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Content Flip"						    => array("setting" => "ContentFlip",            "base" => "TS-VCSC-Content-Flip",                   "file" => "content_flip",      			"group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Meet The Team (Deprecated)"			    => array("setting" => "MeetTeamOld",            "base" => "TS-VCSC-Meet-Team",                      "file" => "meet_team",         			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Single Teammate (Deprecated)"		    => array("setting" => "TeammateOld",            "base" => "TS-VCSC-Team-Mates",                     "file" => "teammates_old",         		"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Quick Skillset"						    => array("setting" => "QuickSkills",            "base" => "TS_VCSC_Quick_Skills",                   "file" => "quick_skills",     			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "4.4.0",  "children" => "0"),
        "TS Quick Testimonial"						=> array("setting" => "QuickTestimonial",       "base" => "TS_VCSC_Quick_Testimonial",              "file" => "quick_testimonial",          "group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Basic Pricing Table"                    => array("setting" => "PricingTable",           "base" => "TS-VCSC-Pricing-Table",                  "file" => "pricing_table",     			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Inspired Pricing Table"                 => array("setting" => "PricingInspired",        "base" => "TS_VCSC_Pricing_Inspired",               "file" => "pricing_inspired",           "group" => "Other",         "type" => "class",		    "default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Social Networks"					    => array("setting" => "SocialNetworks",         "base" => "TS-VCSC-Social-Icons",                   "file" => "social_networks",   			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Processes"							    => array("setting" => "TimelineOld",            "base" => "TS-VCSC-Timeline",                       "file" => "timeline",          			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Horizontal Steps"		                => array("setting" => "HorizontalSteps",        "base" => "TS_VCSC_Horizontal_Steps_Container",     "file" => "horizontal_steps",           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Circle Steps"                           => array("setting" => "CircleSteps",            "base" => "TS_VCSC_Circle_Steps_Container",         "file" => "circle_steps",               "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Isotope Timeline (Deprecated)"		    => array("setting" => "Timeline",        	    "base" => "TS_VCSC_Timeline_Container",             "file" => "timelines",          		"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "true",         "required" => "",       "children" => "0"),
        "TS Divider"							    => array("setting" => "Divider",                "base" => "TS-VCSC-Divider",                        "file" => "divider",           			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Shortcode"							    => array("setting" => "Shortcode",              "base" => "TS-VCSC-Shortcode",                      "file" => "shortcode",         			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Star Rating"						    => array("setting" => "StarRating",             "base" => "TS_VCSC_Star_Rating",                    "file" => "seostars",         			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS QR-Code"							    => array("setting" => "QRCode",                 "base" => "TS-VCSC-QRCode",                         "file" => "qrcode",            			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Fancy List"							    => array("setting" => "FancyList",              "base" => "TS_VCSC_Fancy_List",                     "file" => "fancylist",            		"group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",	    "deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS iPresenter"					            => array("setting" => "iPresenter",    		    "base" => "TS_VCSC_iPresenter_Container",           "file" => "ipresenter",  				"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS SlitSlider"					            => array("setting" => "SlitSlider",    		    "base" => "TS_VCSC_SlitSlider_Container",           "file" => "slitslider",  				"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS IFrame Embed"						    => array("setting" => "IFrame",                 "base" => "TS-VCSC-IFrame",                         "file" => "iframe",            			"group" => "Other",         "type" => "internal",		"default" => "true",		"active" => "true",		"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Spacer / Clear"						    => array("setting" => "Spacer",                 "base" => "TS-VCSC-Spacer",                         "file" => "spacer",            			"group" => "Other",         "type" => "internal",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Almost Anything Slider"					=> array("setting" => "AnySlider",    		    "base" => "TS_VCSC_Anything_Slider",                "file" => "anyslider",  				"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Almost Anything Grid"					=> array("setting" => "AnyGrid",    		    "base" => "TS_VCSC_Anything_Grid",                  "file" => "anygrid",  				    "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "TS Animations Frame"					    => array("setting" => "Animations",    		    "base" => "TS_VCSC_Animation_Frame",                "file" => "animations",  				"group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Row Center Frame"                       => array("setting" => "RowCenter",    		    "base" => "TS_VCSC_RowCenter_Frame",                "file" => "rowcenter",                  "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Icon Wall"                              => array("setting" => "IconWall",    		    "base" => "TS_VCSC_Icon_Wall_Container",            "file" => "iconwall",                   "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),        
        "TS Time / Date Dependency"                 => array("setting" => "TimeSensitive",          "base" => "TS_VCSC_TimeSensitive_Frame",            "file" => "timesensitive",              "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "",       "children" => "0"),
        // BETA Elements
        "TS Fancy Tabs (BETA)"					    => array("setting" => "FancyTabs",    		    "base" => "TS_VCSC_Fancy_Tabs_Container",           "file" => "fancytabs",                  "group" => "BETA",          "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => "4.3.0",  "children" => "0"),
        // 3rd Party Elements
        "GoPricing Table"						    => array("setting" => "GoPricing",              "base" => "go_pricing",                             "file" => "gopricing",                  "group" => "Plugins",       "type" => "external",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
        "QuForm"								    => array("setting" => "Quform",                 "base" => "iphorm",                                 "file" => "quform",                     "group" => "Plugins",       "type" => "external",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"), 
        "Real 3D FlipBook"                          => array("setting" => "Real3DFlipbook",         "base" => "real3dflipbook",                         "file" => "real3dflipbook",             "group" => "Plugins",       "type" => "external",		"default" => "false",		"active" => "false",	"deprecated" => "false",        "required" => "",       "children" => "0"),
    );

    
    // Container Child Elements
    // ------------------------
    $this->TS_VCSC_Visual_Composer_Children = array(        
        "TS Circle Steps Item"                      => array("parent" => "CircleSteps",             "base" => "TS_VCSC_Circle_Steps_Item",              "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Single Tab (BETA)"                      => array("parent" => "FancyTabs",               "base" => "TS_VCSC_Fancy_Tabs_Single",              "file" => "",                           "group" => "BETA",          "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Figure Navigation Item"                 => array("parent" => "FigureNavigation",        "base" => "TS_VCSC_Figure_Navigation_Item",         "file" => "",                           "group" => "Buttons",       "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Google Maps Marker"                     => array("parent" => "GoogleMapsPlus",          "base" => "TS_VCSC_GoogleMapsPlus_Marker",          "file" => "",                           "group" => "Google",        "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Google Maps Overlay"                    => array("parent" => "GoogleMapsPlus",          "base" => "TS_VCSC_GoogleMapsPlus_Overlay",         "file" => "",                           "group" => "Google",        "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Google Maps Single"                     => array("parent" => "GoogleMapsPlus",          "base" => "TS_VCSC_GoogleMapsPlus_Single",          "file" => "",                           "group" => "Google",        "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Horizontal Steps Item"                  => array("parent" => "HorizontalSteps",         "base" => "TS_VCSC_Horizontal_Steps_Item",          "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Icon Wall Item"                         => array("parent" => "IconWall",                "base" => "TS_VCSC_Icon_Wall_Item",                 "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Single Hotspot"                         => array("parent" => "ImageHotspot",            "base" => "TS_VCSC_Image_Hotspot_Single",           "file" => "",                           "group" => "Media",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS iPresenter Item"                        => array("parent" => "iPresenter",              "base" => "TS_VCSC_iPresenter_Item",                "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS SlitSlider Item"                        => array("parent" => "SlitSlider",              "base" => "TS_VCSC_SlitSlider_Item",                "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teaser Block Slider"                    => array("parent" => "TeaserBlock",             "base" => "TS_VCSC_Teaser_Block_Slider_Custom",     "file" => "",                           "group" => "Titles",        "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teaser Block Slide"                     => array("parent" => "TeaserBlock",             "base" => "TS_VCSC_Teaser_Block_Single",            "file" => "",                           "group" => "Titles",        "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Inspired Table Item"                    => array("parent" => "PricingInspired",         "base" => "TS_VCSC_InspiredPricing_Item",           "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Inspired Table Single"                  => array("parent" => "PricingInspired",         "base" => "TS_VCSC_InspiredPricing_Single",         "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Timeline Item (Deprecated)"             => array("parent" => "Timeline",                "base" => "TS_VCSC_Timeline_Single",                "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "true",         "required" => ""),
        "TS Timeline Break (Deprecated)"            => array("parent" => "Timeline",                "base" => "TS_VCSC_Timeline_Break",                 "file" => "",                           "group" => "Other",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "true",         "required" => ""),
    );
    
    
    // Post Type Elements
    // ------------------
    $this->TS_VCSC_Visual_Composer_Types = array(
        "TS Skillset Bars"                          => array("posttype" => "ts_skillsets",          "base" => "TS_VCSC_Skill_Sets_Standalone",          "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Skillset Raphael"                       => array("posttype" => "ts_skillsets",          "base" => "TS_VCSC_Skill_Sets_Raphael",             "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Single Teammate"                        => array("posttype" => "ts_team",               "base" => "TS_VCSC_Team_Mates_Standalone",          "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teammate Slide"                         => array("posttype" => "ts_team",               "base" => "TS_VCSC_Team_Mates_Single",              "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teammates Slider 1"                     => array("posttype" => "ts_team",               "base" => "TS_VCSC_Team_Mates_Slider_Custom",       "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teammates Slider 2"                     => array("posttype" => "ts_team",               "base" => "TS_VCSC_Team_Mates_Slider_Category",     "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Teampage Section"                       => array("posttype" => "ts_team",               "base" => "TS_VCSC_Team_Page_Elements",             "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Single Testimonial"                     => array("posttype" => "ts_testimonials",       "base" => "TS_VCSC_Testimonial_Standalone",         "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Testimonial Slide"                      => array("posttype" => "ts_testimonials",       "base" => "TS_VCSC_Testimonial_Single",             "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Testimonials Slider 1"                  => array("posttype" => "ts_testimonials",       "base" => "TS_VCSC_Testimonial_Slider_Custom",      "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Testimonials Slider 2"                  => array("posttype" => "ts_testimonials",       "base" => "TS_VCSC_Testimonial_Slider_Category",    "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Testimonial Form"                       => array("posttype" => "ts_testimonials",       "base" => "TS_VCSC_Testimonial_Frontend_Form",      "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS CSS Media Timeline"                     => array("posttype" => "ts_timeline",           "base" => "TS_VCSC_Timeline_CSS_Container",         "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Timeline Section"                       => array("posttype" => "ts_timeline",           "base" => "TS_VCSC_Timeline_CSS_Section",           "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Logo Layouts"                           => array("posttype" => "ts_logos",              "base" => "TS_VCSC_Logo_Layouts_Category",          "file" => "",                           "group" => "Types",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
    );
    
    
    // Extra Elements
    // --------------
    $this->TS_VCSC_Visual_Composer_Extra = array(
        // Enlighter Elements
        "TS EnlighterJS Single Code"                => array("feature" => "Enlighter",              "base" => "TS_EnlighterJS_Snippet_Single",          "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS EnlighterJS Group Code"                 => array("feature" => "Enlighter",              "base" => "TS_EnlighterJS_Snippet_Group",           "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS EnlighterJS Group Container"            => array("feature" => "Enlighter",              "base" => "TS_EnlighterJS_Snippet_Container",       "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        // Navigator Elements
        "TS SinglePage Navigator"                   => array("feature" => "Navigator",              "base" => "TS_VCSC_SinglePage_Container",           "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS Single Menu Item"                       => array("feature" => "Navigator",              "base" => "TS_VCSC_SinglePage_Item",                "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS ToTop Menu Item"                        => array("feature" => "Navigator",              "base" => "TS_VCSC_SinglePage_ToTop",               "file" => "",                           "group" => "Extra",         "type" => "class",			"default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
    );
    
    
    // Demo Elements
    // -------------
    $this->TS_VCSC_Visual_Composer_Demos = array(
        // Demo Elements
        "TS Icon Font Preview"                      => array("setting" => "IconFonts",              "base" => "TS_VCSC_Icon_Preview",                   "file" => "demo_iconfonts",             "group" => "Demos",         "type" => "internal",       "default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS CSS3 Animations"                        => array("setting" => "Animations",             "base" => "TS_VCSC_Icon_Animations",                "file" => "demo_animations",            "group" => "Demos",         "type" => "internal",       "default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "TS System Information"                     => array("setting" => "SystemInfo",             "base" => "TS_VCSC_System_Information",             "file" => "demo_system",                "group" => "Demos",         "type" => "internal",       "default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
        "Other Shortcodes (No Elements)"            => array("setting" => "Shortcodes",             "base" => "",                                       "file" => "demo_others",                "group" => "Demos",         "type" => "internal",       "default" => "false",		"active" => "false",    "deprecated" => "false",        "required" => ""),
    );
    
    
    // WooCommerce Elements
    // --------------------
    $this->TS_VCSC_WooCommerce_Elements = array(
        "Basic Products Slider"				        => array("setting" => "SliderBasic",            "base" => "TS_WooCommerce_Slider_Basic",            "file" => "custom_slider",             	"type" => "class",	        "default" => "false",		"active" => "false",	    "deprecated" => "false"),
        "Basic Products Isotope Grid"               => array("setting" => "GridBasic",              "base" => "TS_WooCommerce_Grid_Basic",              "file" => "custom_grid",             	"type" => "class",	        "default" => "false",		"active" => "false",	    "deprecated" => "false"),
        "Basic Products Image Grid"                 => array("setting" => "GridImage",              "base" => "TS_WooCommerce_ImageGrid_Basic",         "file" => "custom_image",             	"type" => "class",	        "default" => "false",		"active" => "false",	    "deprecated" => "false"),
        "Basic Products Ticker"				        => array("setting" => "TickerBasic",            "base" => "TS_VCSC_WooCommerce_Ticker_Basic",       "file" => "custom_ticker",             	"type" => "class",	        "default" => "false",		"active" => "false",	    "deprecated" => "false"),
        "Single Product Rating"				        => array("setting" => "RatingBasic",            "base" => "TS_WooCommerce_Rating_Basic",            "file" => "custom_rating",             	"type" => "class",	        "default" => "false",		"active" => "false",	    "deprecated" => "false"),
    );
    
    
    // bbPress Elements
    // ----------------
    $this->TS_VCSC_bbPress_Elements = array(
        "Forum Index"						        => array("setting" => "ForumIndex",             "base" => "bbp-forum-index",                        "file" => "forumindex",                 "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Forum Form"						        => array("setting" => "ForumForm",              "base" => "bbp-forum-form",                         "file" => "forumform",                  "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Single Forums Topics"                      => array("setting" => "ForumSingle",            "base" => "bbp-single-forum",                       "file" => "forumsingle",                "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Topic Index"						        => array("setting" => "TopicIndex",             "base" => "bbp-topic-index",                        "file" => "topicindex",                 "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Topic Form"						        => array("setting" => "TopicForm",              "base" => "bbp-topic-form",                         "file" => "topicform",                  "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Single Topic"						        => array("setting" => "TopicSingle",            "base" => "bbp-single-topic",                       "file" => "topicsingle",                "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Reply Form"						        => array("setting" => "ReplyForm",              "base" => "bbp-reply-form",                         "file" => "replyform",                  "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Single Reply"						        => array("setting" => "ReplySingle",            "base" => "bbp-single-reply",                       "file" => "replysingle",                "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Topic Tags"						        => array("setting" => "TagsTopic",              "base" => "bbp-topic-tags",                         "file" => "tagstopic",                  "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Single Tags"						        => array("setting" => "TagsSingle",             "base" => "bbp-single-tag",                         "file" => "tagssingle",                 "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Single View"						        => array("setting" => "ViewSingle",             "base" => "bbp-single-view",                        "file" => "viewsingle",                 "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Search Form"						        => array("setting" => "SearchForm",             "base" => "bbp-search",                             "file" => "searchform",                 "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Search Template"                           => array("setting" => "SearchTemplate",         "base" => "bbp-search-form",                        "file" => "searchtemplate",             "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Login Screen"                              => array("setting" => "AccountLogin",           "base" => "bbp-login",                              "file" => "accountlogin",               "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Register Screen"                           => array("setting" => "AccountRegister",        "base" => "bbp-register",                           "file" => "accountregister",            "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Lost Password Screen"                      => array("setting" => "AccountPassword",        "base" => "bbp-lost-pass",                          "file" => "accountpassword",            "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
        "Forum Statistics"                          => array("setting" => "ForumStatistics",        "base" => "bbp-stats",                              "file" => "forumstatistics",            "type" => "internal",	    "default" => "false",		"active" => "false",        "deprecated" => "false"),
    );
    
    
    // Setting Parameters
    // ------------------
    $this->TS_VCSC_ComposerParameters = array(
        "Post Type Paramater"                       => array("file" => "standardpost"),
        "Custom Post Type Parameter"                => array("file" => "custompost"),
        "Load File Parameter"              		    => array("file" => "loadfile"),
        "CSS3 Animation Parameter"                  => array("file" => "animations"),
        "Separator Parameter"            		    => array("file" => "separator"),
        "Messenger Parameter"                       => array("file" => "messenger"),
        "Video Select Parameter"                    => array("file" => "videoselect"),
        "Audio Select Parameter"                    => array("file" => "audioselect"),
        "Icons Panel Parameter"                     => array("file" => "iconspanel"),
        "Background Panel Parameter"                => array("file" => "backgroundpanel"),
        "Map Marker Parameter"                      => array("file" => "markerpanel"),
        "Switch Parameter"                          => array("file" => "switch"),
        "NoUiSlider Parameter"                      => array("file" => "nouislider"),
        "Image Hotspot Parameter"                   => array("file" => "imagehotspot"),
        "Google Fonts Parameter"                    => array("file" => "googlefonts"),
        "Hidden Input Parameter"                    => array("file" => "hiddeninput"),
        "Hidden Textarea Parameter"                 => array("file" => "hiddentextarea"),
        "Date / Time Picker Parameter"              => array("file" => "datetimepicker"),   
        "Advanced Setting Parameter"                => array("file" => "advancedsetting"),
        "Advanced Gradient Parameter"               => array("file" => "advancedgradient"),
        "Social Networks Parameter"                 => array("file" => "socialnetworks"),
        "Device Type Selectors"                     => array("file" => "devicetypes"),
        "ID / Number Auto-Generator Parameter"      => array("file" => "autogenerate"),
        "User Roles Parameter"                      => array("file" => "userroles"),
        "Viewport Animation Offset"                 => array("file" => "viewportoffset"),
        "Advanced Link Parameter"                   => array("file" => "advancedlinks"),
        //"Code Editor Parameter"                   => array("file" => "codeeditor"), 
        "WooCommerce Parameters"                    => array("file" => "woocommerce"),
        "bbPress Parameters"              		    => array("file" => "bbpress"),
    );
    
    
    // Post Type Names
    // ---------------
    $this->TS_VCSC_PostTypeMenuNames_Default = array(
        "ts_widgets"                                => "VC Templates",
        "ts_timeline"                               => "VC Timelines",
        "ts_team"                                   => "VC Team",
        "ts_testimonials"                           => "VC Testimonials",
        "ts_skillsets"                              => "VC Skillsets",
        "ts_logos"                                  => "VC Logos",
    );
    
    
    // Other Plublic Arrays
    // --------------------
    $this->TS_VCSC_TeamPageBuilder_Included = array (
        // Extensions Elements
        'TS_VCSC_Team_Page_Featured',
        'TS_VCSC_Team_Page_NameTitle',
        'TS_VCSC_Team_Page_Contact',
        'TS_VCSC_Team_Page_Social',
        'TS_VCSC_Team_Page_Description',
        'TS_VCSC_Team_Page_Opening',
        'TS_VCSC_Team_Page_Download',
        'TS_VCSC_Team_Page_Skills',
        'TS_VCSC_Star_Rating',
        'TS-VCSC-Icon-Counter',
        'TS-VCSC-Circliful',
        'TS-VCSC-Icon-Title',
        'TS_VCSC_Skill_Sets_Standalone',
        'TS-VCSC-Divider',
        'TS-VCSC-Spacer',
        'TS_VCSC_Spacer',
        'TS-VCSC-QRCode',
        // Original VC Elements
        'vc_column_text',
        'vc_toggle',
        'vc_message',
        'vc_separator',
        'vc_text_separator',
    );
    
    $this->TS_VCSC_AnyLayout_Excluded = array (
        // Extension Elements
        'TS_VCSC_Anything_Slider',
        'TS_VCSC_Anything_Grid',
        'TS_VCSC_Animation_Frame',
        'TS_VCSC_Horizontal_Steps_Container',
        'TS_VCSC_Circle_Steps_Container',
        'TS_VCSC_Timeline_Container',
        'TS_VCSC_Timeline_Single',
        'TS_VCSC_Timeline_Break',
        'TS_VCSC_Team_Mates_Single',
        'TS_VCSC_Team_Mates_Slider_Custom',
        'TS_VCSC_Team_Mates_Slider_Category',
        'TS_VCSC_Testimonial_Single',
        'TS_VCSC_Testimonial_Slider_Custom',
        'TS_VCSC_Testimonial_Slider_Category',
        'TS_VCSC_Teaser_Block_Single',
        'TS_VCSC_Teaser_Block_Slider_Custom',
        'TS_VCSC_Logo_Single',
        'TS_VCSC_Logo_Slider_Custom',
        'TS_VCSC_Logo_Slider_Category',
        'TS_VCSC_Posts_Grid_Standalone',
        'TS_VCSC_Posts_Slider_Standalone',
        'TS-VCSC-Image-Full',
        'TS_VCSC_Image_Full',
        'TS-VCSC-YouTube-Background',
        'TS_VCSC_YouTube_Background',
        'TS-VCSC-Google-Charts',
        'TS_VCSC_Google_Charts',
        'TS-VCSC-Google-Maps',
        'TS_VCSC_Google_Maps',
        'TS-VCSC-Google-Trends',
        'TS_VCSC_Google_Trends',
        'TS-VCSC-Google-Docs',
        'TS_VCSC_Google_Docs',
        'TS-VCSC-Textillate',
        'TS_VCSC_Textillate',
        'TS-VCSC-Icon-Title',
        'TS_VCSC_Icon_Title',
        'TS-VCSC-Timeline',
        'TS_VCSC_Timeline',
        'TS-VCSC-Divider',
        'TS_VCSC_Divider',
        'TS-VCSC-Spacer',
        'TS_VCSC_Spacer',
        // Original VC Elements
        'vc_row',
        'vc_gallery',
        'vc_images_carousel',
        'vc_carousel',
        'vc_posts_slider',
        'vc_accordion',
        'vc_tour',
        'vc_tabs',
        'vc_empty_space',
        'vc_pie',
        // WooCommerce Elements
        'woocommerce_cart',
        'woocommerce_checkout',
        'woocommerce_order_tracking',
        'woocommerce_my_account',
        'add_to_cart',
        'add_to_cart_url',
        'product_page',
        'related_products',
        // Other Elements
        'layerslider',
        'rev_slider',
    );
    
    $this->TS_VCSC_Focus_Excluded = array (
        // Extension Elements
        'TS_VCSC_Element_Focus',
        // Original VC Elements
        'vc_row',
        'vc_accordion',
        'vc_tour',
        'vc_tabs',
        // WooCommerce Elements
        'woocommerce_cart',
        'woocommerce_checkout',
        'woocommerce_order_tracking',
        'woocommerce_my_account',
        'add_to_cart',
        'add_to_cart_url',
        'product_page',
        'related_products',
        // Other Elements
        'layerslider',
        'rev_slider',
    );
?>