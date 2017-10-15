<?php
    // Check if Provided via Extended License
    // --------------------------------------
    $this->TS_VCSC_PluginExtended				        = (get_option('ts_vcsc_extend_settings_extended', 0) == 1 ? "true" : "false");
    
    
    // Check and Store VC Version, Applicable Post Types and Icon Picker
    // -----------------------------------------------------------------
    if (defined('WPB_VC_VERSION')){
        $this->TS_VCSC_VisualComposer_Version 			= WPB_VC_VERSION;
        if (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.3.0') >= 0) {
            if (get_option('ts_vcsc_extend_settings_backendPreview', 1) == 1) {
                $this->TS_VCSC_EditorLivePreview		= "true";
            } else {
                $this->TS_VCSC_EditorLivePreview		= "false";
            }
        } else {
            $this->TS_VCSC_EditorLivePreview			= "false";
        }
        if (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.4.0') >= 0) {
            $this->TS_VCSC_EditorIconFontsInternal		= "true";
            $this->TS_VCSC_VisualComposer_Compliant		= "true";
            $this->TS_VCSC_EditorFullWidthInternal		= "true";
        } else {
            $this->TS_VCSC_EditorIconFontsInternal		= "false";
            $this->TS_VCSC_VisualComposer_Compliant		= "false";
            $this->TS_VCSC_EditorFullWidthInternal		= "false";
        }
        if ((TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.9.0') >= 0) && (function_exists('vc_lean_map'))) {
            $this->TS_VCSC_VisualComposer_LeanMap 		= "true";
        } else {
            $this->TS_VCSC_VisualComposer_LeanMap 		= "false";
        }
    } else {
        $this->TS_VCSC_EditorLivePreview				= "false";
        $this->TS_VCSC_EditorIconFontsInternal			= "false";
        $this->TS_VCSC_VisualComposer_Compliant			= "false";
        $this->TS_VCSC_VisualComposer_LeanMap 			= "false";
        $this->TS_VCSC_EditorFullWidthInternal			= "false";
    }
    
    
    // Check for Jetpack Plugin + Photon Extensions
    // --------------------------------------------
    if (class_exists('Jetpack') && Jetpack::is_module_active('photon')) {
        $this->TS_VCSC_JetpackPhoton_Active				= "true";
    } else {
        $this->TS_VCSC_JetpackPhoton_Active				= "false";
    }
    
    
    // Default Lightbox Animation
    // --------------------------
    $this->TS_VCSC_Default_Animation 			        = get_option('ts_vcsc_extend_settings_defaultLightboxAnimation', $this->TS_VCSC_Lightbox_Setting_Defaults['animation']);
    
    
    // Load Social Networks API's
    // --------------------------
    $this->TS_VCSC_SocialNetworkAPIs 			        = ((get_option('ts_vcsc_extend_settings_defaultLightboxSocialAPIs', $this->TS_VCSC_Lightbox_Setting_Defaults['loadapis'])) == 1 ? "true" : "false");
    
    
    // Define Menu Position for Post Types
    // -----------------------------------
    $this->TS_VCSC_CustomPostTypesPositions		        = get_option('ts_vcsc_extend_settings_menuPositions', $this->TS_VCSC_Menu_Positions_Defaults);			
    
    
    // Check for MultiSite Activation
    // ------------------------------
    $this->TS_VCSC_PluginIsMultiSiteActive 		        = (is_plugin_active_for_network(COMPOSIUM_SLUG) == true ? "true" : "false");
    
    
    // Activation Redirection
    // ----------------------
    $this->TS_VCSC_ActivationRedirect                   = (get_option('ts_vcsc_extend_settings_redirect', 0) == 1 ? "true" : "false");
    
    
    // Check and Set other Global Variables
    // ------------------------------------
    // Check if All Files should be loaded
    if (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 0) 	        { $this->TS_VCSC_LoadFrontEndForcable = "false"; } 			else { $this->TS_VCSC_LoadFrontEndForcable = "true"; }
    // Check if Waypoints should be loaded
    if (get_option('ts_vcsc_extend_settings_loadWaypoints', 1) == 1) 	        { $this->TS_VCSC_LoadFrontEndWaypoints = "true"; } 			else { $this->TS_VCSC_LoadFrontEndWaypoints = "false"; }
    // Check if Modernizr should be loaded
    if (get_option('ts_vcsc_extend_settings_loadModernizr', 1) == 1) 	        { $this->TS_VCSC_LoadFrontEndModernizr = "true"; } 			else { $this->TS_VCSC_LoadFrontEndModernizr = "false"; }
    // Check if CountTo should be loaded
    if (get_option('ts_vcsc_extend_settings_loadCountTo', 1) == 1) 		        { $this->TS_VCSC_LoadFrontEndCountTo = "true"; }			else { $this->TS_VCSC_LoadFrontEndCountTo = "false"; }
    // Check if CountUp should be loaded
    if (get_option('ts_vcsc_extend_settings_loadCountUp', 1) == 1) 		        { $this->TS_VCSC_LoadFrontEndCountUp = "true"; }			else { $this->TS_VCSC_LoadFrontEndCountUp = "false"; }
    // Check if MooTools should be loaded
    if (get_option('ts_vcsc_extend_settings_loadMooTools', 1) == 1)				{ $this->TS_VCSC_LoadFrontEndMooTools = "true"; }			else { $this->TS_VCSC_LoadFrontEndMooTools = "false"; }
    // Check if Lightbox should be loaded
    if (get_option('ts_vcsc_extend_settings_loadLightbox', 0) == 1) 	        { $this->TS_VCSC_LoadFrontEndLightbox = "true"; } 			else { $this->TS_VCSC_LoadFrontEndLightbox = "false"; }
    // Check if Tooltips should be loaded
    if (get_option('ts_vcsc_extend_settings_loadTooltip', 0) == 1) 		        { $this->TS_VCSC_LoadFrontEndTooltips = "true"; } 			else { $this->TS_VCSC_LoadFrontEndTooltips = "false"; }
    // Check which Hammer.js should be loaded
    if (get_option('ts_vcsc_extend_settings_loadHammerNew', 1) == 1)			{ $this->TS_VCSC_LoadFrontEndHammerNew = "true"; } 			else { $this->TS_VCSC_LoadFrontEndHammerNew = "false"; }
    // Check if ForceLoad of jQuery
    if (get_option('ts_vcsc_extend_settings_loadjQuery', 0) == 1) 		        { $this->TS_VCSC_LoadFrontEndJQuery = "true"; }				else { $this->TS_VCSC_LoadFrontEndJQuery = "false"; }
    // Check for Editor Image Preview
    if (get_option('ts_vcsc_extend_settings_previewImages', 1) == 1)	        { $this->TS_VCSC_EditorImagePreview = "true"; }				else { $this->TS_VCSC_EditorImagePreview = "false"; }
    // Check for Background Indicator
    if (get_option('ts_vcsc_extend_settings_backgroundIndicator', 1) == 1)	    { $this->TS_VCSC_EditorBackgroundIndicator = "true"; }		else { $this->TS_VCSC_EditorBackgroundIndicator = "false"; }   
    // Check for Visual Icon Selector
    if (get_option('ts_vcsc_extend_settings_visualSelector', 1) == 1)	        { $this->TS_VCSC_EditorVisualSelector = "true"; } 			else { $this->TS_VCSC_EditorVisualSelector = "false"; }
    // Check for Native Icon Selector
    if (get_option('ts_vcsc_extend_settings_nativeSelector', 1) == 1)	        { $this->TS_VCSC_EditorNativeSelector = "true"; } 			else { $this->TS_VCSC_EditorNativeSelector = "false"; }
    // Check for Built-In Lightbox
    if (get_option('ts_vcsc_extend_settings_builtinLightbox', 1) == 1)	        { $this->TS_VCSC_UseInternalLightbox = "true"; } 			else { $this->TS_VCSC_UseInternalLightbox = "false"; }
    // Google Font Manager
    if (get_option('ts_vcsc_extend_settings_allowGoogleManager', 1) == 1)		{ $this->TS_VCSC_UseGoogleFontManager = "true"; } 			else { $this->TS_VCSC_UseGoogleFontManager = "false"; }
    // Single Page Navigator Builder
    if (get_option('ts_vcsc_extend_settings_allowPageNavigator', 0) == 1)		{ $this->TS_VCSC_UsePageNavigator = "true"; } 				else { $this->TS_VCSC_UsePageNavigator = "false"; }
    // SmoothScroll Activation
    if (get_option('ts_vcsc_extend_settings_additionsSmoothScroll', 0) == 1)	{ $this->TS_VCSC_UseSmoothScroll = "true"; } 				else { $this->TS_VCSC_UseSmoothScroll = "false"; }
    // Provide Code Editors
    if (get_option('ts_vcsc_extend_settings_codeeditors', 1) == 1)				{ $this->TS_VCSC_UseCodeEditors = "true"; }					else { $this->TS_VCSC_UseCodeEditors = "false"; }
    // Provide Deprecated Elements
    if (get_option('ts_vcsc_extend_settings_allowDeprecated', 0) == 1)			{ $this->TS_VCSC_UseDeprecatedElements = "true"; }			else { $this->TS_VCSC_UseDeprecatedElements = "false"; }
    // Plugin Menu Location
    if (get_option('ts_vcsc_extend_settings_mainmenu', 1) == 1)                 { $this->TS_VCSC_PluginMainMenu = "true"; }                 else { $this->TS_VCSC_PluginMainMenu = "false"; }  
    // Enlighter JS
    if (get_option('ts_vcsc_extend_settings_allowEnlighterJS', 0) == 1)			{ $this->TS_VCSC_UseEnlighterJS = "true"; } 				else { $this->TS_VCSC_UseEnlighterJS = "false"; }
    // ThemeBuilder
    if ($this->TS_VCSC_UseEnlighterJS == "true") {
        if (get_option('ts_vcsc_extend_settings_allowThemeBuilder', 0) == 1)	{ $this->TS_VCSC_UseThemeBuider = "true"; } 				else { $this->TS_VCSC_UseThemeBuider = "false"; }
    } else {
        $this->TS_VCSC_UseThemeBuider 			        = "false";
    }
    
    
    // Extended Row + Column Options
    // -----------------------------
    if ((($this->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || (($this->TS_VCSC_PluginExtended == "false"))) {
        if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
            $this->TS_VCSC_UseExtendedRows		        = "true";
        } else {
            $this->TS_VCSC_UseExtendedRows 		        = "false";
        }
        if (get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) {
            $this->TS_VCSC_UseExtendedColumns 	        = "true";
        } else {
            $this->TS_VCSC_UseExtendedColumns 	        = "false";
        }
    } else {
        $this->TS_VCSC_UseExtendedRows 			        = "false";
        $this->TS_VCSC_UseExtendedColumns 		        = "false";
    }
    
    
    // Define Output Priority for JS Variables
    // ---------------------------------------
    $this->TS_VCSC_Extensions_VariablesPriority         = get_option('ts_vcsc_extend_settings_variablesPriority', '6');
    
    
    // Status of WooCommerce Elements
    // ------------------------------
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $this->TS_VCSC_WooCommerceVersion 			    = $this->TS_VCSC_WooCommerceVersion();
        $this->TS_VCSC_WooCommerceActive 			    = "true";				
    } else {
        $this->TS_VCSC_WooCommerceVersion 			    = "";
        $this->TS_VCSC_WooCommerceActive 			    = "false";
    }
    
    
    // Status of bbPress Elements
    // --------------------------
    if (in_array('bbpress/bbpress.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $this->TS_VCSC_bbPressVersion 			        = "";
        $this->TS_VCSC_bbPressActive 			        = "true";
    } else {
        $this->TS_VCSC_bbPressVersion 			        = "";
        $this->TS_VCSC_bbPressActive 			        = "false";
    }
    
    
    // Other Routine Checks
    // --------------------
    if (($this->TS_VCSC_PluginLicense != '') && ($this->TS_VCSC_PluginLicense != 'emptydelimiterfix') && (in_array(base64_encode($this->TS_VCSC_PluginLicense), $this->TS_VCSC_Avoid_Duplications))) {
        $this->TS_VCSC_PluginUsage				        = "false";
    } else {
        $this->TS_VCSC_PluginUsage				        = "true";
    }
    if ($this->TS_VCSC_PluginUsage == "false") {
        if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
            update_site_option('ts_vcsc_extend_settings_licenseInfo', '');
            update_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
            update_site_option('ts_vcsc_extend_settings_licenseValid', 0);
        } else {
            update_option('ts_vcsc_extend_settings_licenseInfo', '');
            update_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
            update_option('ts_vcsc_extend_settings_licenseValid', 0);
        }
    }
    if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
        $this->TS_VCSC_PluginLicense			        = get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
        $this->TS_VCSC_PluginValid				        = (get_site_option('ts_vcsc_extend_settings_licenseValid', 0) == 1 ? "true" : "false");
        $this->TS_VCSC_PluginEnvato				        = get_site_option('ts_vcsc_extend_settings_licenseInfo', '');
    } else {
        $this->TS_VCSC_PluginLicense			        = get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
        $this->TS_VCSC_PluginValid				        = (get_option('ts_vcsc_extend_settings_licenseValid', 0) == 1 ? "true" : "false");
        $this->TS_VCSC_PluginEnvato				        = get_option('ts_vcsc_extend_settings_licenseInfo', '');
    }
    
    
    // Check for Standalone Iconicum Plugin
    // ------------------------------------
    if ((in_array('ts-iconicum-icon-fonts/ts-iconicum-icon-fonts.php', apply_filters('active_plugins', get_option('active_plugins')))) || (class_exists('ICONICUM_ICON_FONTS'))) {
        $this->TS_VCSC_IconicumStandard			        = "true";
    } else {
        $this->TS_VCSC_IconicumStandard			        = "false";
    }
    // Submenu Generator
    if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
        if (((($this->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1)) || (($this->TS_VCSC_PluginExtended == "false") && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1) && ($this->TS_VCSC_PluginValid == "true"))) && ($this->TS_VCSC_PluginUsage == 'true')) {
            $this->TS_VCSC_IconicumMenuGenerator 	    = "true";
        } else {
            $this->TS_VCSC_IconicumMenuGenerator 	    = "false";
        }
    } else {
        if (((($this->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1)) || (($this->TS_VCSC_PluginExtended == "false") && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1) && ($this->TS_VCSC_PluginValid == "true"))) && ($this->TS_VCSC_PluginUsage == 'true')) {
            $this->TS_VCSC_IconicumMenuGenerator 	    = "true";
        } else {
            $this->TS_VCSC_IconicumMenuGenerator 	    = "false";
        }
    }
    // tinyMCE Editor Generator
    if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
        if (((($this->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) || (($this->TS_VCSC_PluginExtended == "false") && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1) && ($this->TS_VCSC_PluginValid == "true"))) && ($this->TS_VCSC_PluginUsage == 'true')) {
            $this->TS_VCSC_IconicumActivated 		    = "true";
        } else {
            $this->TS_VCSC_IconicumActivated 		    = "false";
        }
    } else {
        if (((($this->TS_VCSC_PluginExtended == "true") && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) || (($this->TS_VCSC_PluginExtended == "false") && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1) && ($this->TS_VCSC_PluginValid == "true"))) && ($this->TS_VCSC_PluginUsage == 'true')) {
            $this->TS_VCSC_IconicumActivated 		    = "true";
        } else {
            $this->TS_VCSC_IconicumActivated 		    = "false";
        }
    }
    
    
    // -------------------------
    // Custom Setting Parameters
    // -------------------------
    $TS_VCSC_CustomSettingParameters                    = get_option('ts_vcsc_extend_settings_parametersCustom', '');
    if (!is_array($TS_VCSC_CustomSettingParameters)) {
        $TS_VCSC_CustomSettingParameters                = array();
    }
    // Advanced Link Picker
    $TS_VCSC_Advanced_Linkpicker_Settings               = ((array_key_exists('LinkPicker', $TS_VCSC_CustomSettingParameters)) ? $TS_VCSC_CustomSettingParameters['LinkPicker'] : array());
    if (($TS_VCSC_Advanced_Linkpicker_Settings == false) || (empty($TS_VCSC_Advanced_Linkpicker_Settings))) {
        $TS_VCSC_Advanced_Linkpicker_Settings           = array();
    }
    $this->TS_VCSC_ParameterLinkPicker = array(
        'enabled'                                       => (((array_key_exists('enabled', $TS_VCSC_Advanced_Linkpicker_Settings))   ? $TS_VCSC_Advanced_Linkpicker_Settings['enabled']      : $this->TS_VCSC_Advanced_Linkpicker_Defaults['enabled'])       == 1 ? "true" : "false"),
        'global'                                        => (((array_key_exists('global', $TS_VCSC_Advanced_Linkpicker_Settings))    ? $TS_VCSC_Advanced_Linkpicker_Settings['global']       : $this->TS_VCSC_Advanced_Linkpicker_Defaults['global'])        == 1 ? "true" : "false"),
        'offset'                                        => ((array_key_exists('offset', $TS_VCSC_Advanced_Linkpicker_Settings))     ? $TS_VCSC_Advanced_Linkpicker_Settings['offset']       : $this->TS_VCSC_Advanced_Linkpicker_Defaults['offset']),
        'posts'                                         => (((array_key_exists('posts', $TS_VCSC_Advanced_Linkpicker_Settings))     ? $TS_VCSC_Advanced_Linkpicker_Settings['posts']        : $this->TS_VCSC_Advanced_Linkpicker_Defaults['posts'])         == 1 ? "true" : "false"),
        'custom'                                        => (((array_key_exists('custom', $TS_VCSC_Advanced_Linkpicker_Settings))    ? $TS_VCSC_Advanced_Linkpicker_Settings['custom']       : $this->TS_VCSC_Advanced_Linkpicker_Defaults['custom'])        == 1 ? "true" : "false"),
        'orderby'                                       => ((array_key_exists('orderby', $TS_VCSC_Advanced_Linkpicker_Settings))    ? $TS_VCSC_Advanced_Linkpicker_Settings['orderby']      : $this->TS_VCSC_Advanced_Linkpicker_Defaults['orderby']),
        'order'                                         => ((array_key_exists('order', $TS_VCSC_Advanced_Linkpicker_Settings))      ? $TS_VCSC_Advanced_Linkpicker_Settings['order']        : $this->TS_VCSC_Advanced_Linkpicker_Defaults['order']),
    );
    // Numeric Slider Inputs (noUiSlider)
    $TS_VCSC_NoUiSlider_Input_Settings                  = ((array_key_exists('NoUiSlider', $TS_VCSC_CustomSettingParameters)) ? $TS_VCSC_CustomSettingParameters['NoUiSlider'] : array());
    if (($TS_VCSC_NoUiSlider_Input_Settings == false) || (empty($TS_VCSC_NoUiSlider_Input_Settings))) {
        $TS_VCSC_NoUiSlider_Input_Settings              = array();
    }
    $this->TS_VCSC_ParameterNoUiSlider = array(
        'enabled'                                       => (((array_key_exists('enabled', $TS_VCSC_NoUiSlider_Input_Settings))      ? $TS_VCSC_NoUiSlider_Input_Settings['enabled']         : $this->TS_VCSC_NoUiSlider_Inputs_Defaults['enabled'])         == 1 ? "true" : "false"),
        'pips'                                          => (((array_key_exists('pips', $TS_VCSC_NoUiSlider_Input_Settings))         ? $TS_VCSC_NoUiSlider_Input_Settings['pips']            : $this->TS_VCSC_NoUiSlider_Inputs_Defaults['pips'])            == 1 ? "true" : "false"),
        'tooltip'                                       => (((array_key_exists('tooltip', $TS_VCSC_NoUiSlider_Input_Settings))      ? $TS_VCSC_NoUiSlider_Input_Settings['tooltip']         : $this->TS_VCSC_NoUiSlider_Inputs_Defaults['tooltip'])         == 1 ? "true" : "false"),
        'input'                                         => (((array_key_exists('input', $TS_VCSC_NoUiSlider_Input_Settings))        ? $TS_VCSC_NoUiSlider_Input_Settings['input']           : $this->TS_VCSC_NoUiSlider_Inputs_Defaults['input'])           == 1 ? "true" : "false"),
    );
    // Unset Unneeded Variables
    /*
    unset($TS_VCSC_CustomSettingParameters);
    unset($TS_VCSC_Advanced_NoUiSlider_Settings);
    unset($TS_VCSC_NoUiSlider_Input_Settings);
    */
?>