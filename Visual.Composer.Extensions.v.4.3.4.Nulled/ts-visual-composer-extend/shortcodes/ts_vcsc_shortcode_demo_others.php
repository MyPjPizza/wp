<?php
	// Shortcode to get Icon Count for Specific Font
	add_shortcode('TS_VCSC_Icon_Font_IconCount', 'TS_VCSC_Icon_Font_IconCount');
	function TS_VCSC_Icon_Font_IconCount ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();		
		extract(shortcode_atts(array(
			'font' 						=> 'Awesome',
		), $atts));		
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
			if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] == $font)) {
				echo $iconfont['count'];
			}
		}		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	// Shortcode to get Total Number of all Icons
	add_shortcode('TS_VCSC_Icon_Font_IconsTotal', 'TS_VCSC_Icon_Font_IconsTotal');
	function TS_VCSC_Icon_Font_IconsTotal ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();		
		extract(shortcode_atts(array(
			'dashicons'				=> 'true',
			'custom'				=> 'false',			
		), $atts));
		$finalcount 				= 0;
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {				
			if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] != "Dashicons")) {
				$finalcount = $finalcount + $iconfont['count'];
			} else if (($iconfont['setting'] == "Dashicons") && ($dashicons == "true")) {
				$finalcount = $finalcount + $iconfont['count'];
			} else if (($iconfont['setting'] == "Custom") && ($custom == "true")) {
				$finalcount = $finalcount + $iconfont['count'];
			}
		}
		echo $finalcount;
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	// Shortcode to get Share of Icons in Specific Font in Relation to all Icons
	add_shortcode('TS_VCSC_Icon_Font_IconShare', 'TS_VCSC_Icon_Font_IconShare');
	function TS_VCSC_Icon_Font_IconShare ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();		
		extract(shortcode_atts(array(
			'font' 						=> 'Awesome',
		), $atts));		
		foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
			if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] == $font)) {
				if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
					echo $iconfont['count'] / ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count - $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_tinymceCustomCount);
				} else {
					echo $iconfont['count'] / $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count;
				}
			}
		}		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	// Shortcode to get Total Number of all Fonts
	add_shortcode('TS_VCSC_Icon_Font_FontCount', 'TS_VCSC_Icon_Font_FontCount');
	function TS_VCSC_Icon_Font_FontCount ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();		
		extract(shortcode_atts(array(), $atts));		
		if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
			echo count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts);
		} else {
			echo count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts) - 1;
		}		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	// Shortcode to Retrieve Author Data from Envato
	add_shortcode('TS_VCSC_GetAuthorInformation', 'TS_VCSC_GetAuthorInformation');
	function TS_VCSC_GetAuthorInformation ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		extract(shortcode_atts(array(
			'author'					=> '',
			'interval'					=> 3600,
			'format'                    => 'true',
		), $atts));
		
		$output                         = '';
		
		if ($author == '') {
			$author                     = "Tekanewa";
		}
		
		$api_path                       = "https://api.envato.com/v1/market/user:" . $author . ".json";
		$api_last                       = get_option('ts_vcsc_extend_settings_authorCheck', 	0);
		$api_current                    = time();
		$api_data                       = get_option('ts_vcsc_extend_settings_authorData', 		'');
		$api_break                      = $interval;
		
		if (($api_data == "") || (($api_last + $api_break) < $api_current)) {
			/* Fetch data using the WordPress function wp_remote_get() */
			if ((function_exists('wp_remote_get')) && (strlen($author) != 0)) {
				$response               		= wp_remote_get($api_path, array(
					'user-agent'        		=> 'Tekanewa Scripts - Author Data Request',
					'httpversion' 				=> '1.1',
					'headers'           		=> array(
						'Authorization' 		=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
					),
				));
			} else if ((function_exists('wp_remote_post')) && (strlen($author) != 0)) {
				$response               		= wp_remote_post($api_path, array(
					'user-agent'        		=> 'Tekanewa Scripts - Author Data Request',
					'httpversion' 				=> '1.1',
					'headers'           		=> array(
						'Authorization' 		=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
					),
				));
			}
			/* Check for errors, if there are some errors return false */
			if (is_wp_error($response) or (wp_remote_retrieve_response_code($response) != 200)) {
				$item 							= false;
			} else {
				/* Transform the JSON string into a PHP array */
				$item 							= json_decode(wp_remote_retrieve_body($response), true);
				/* Check for incorrect data */
				if (!is_array($item)) {
					$item						= false;
				}
			}
			if (($item == false) && ($api_data != "")) {
				$item 							= $api_data;
			}
		} else {
			$item								= $api_data;
		}
		
		if ($item === false) {
			$output                             = 'N/A';
		} else {
			// Parse Item Data
			$ts_vcsc_extend_authorItem_Data		= array();
			$ts_vcsc_extend_authorItem_Name     = (isset($item["user"]["username"])     ? $item["user"]["username"]         : "N/A");
			$ts_vcsc_extend_authorItem_Sales    = (isset($item["user"]["sales"])        ? $item["user"]["sales"] 			: "N/A");
			$ts_vcsc_extend_authorItem_Fans     = (isset($item["user"]["followers"])    ? $item["user"]["followers"]        : "N/A");
			$ts_vcsc_extend_authorItem_Check	= time();
			// Populate Data Array
			$ts_vcsc_extend_authorItem_Data["user"]["username"]     = $ts_vcsc_extend_authorItem_Name;
			$ts_vcsc_extend_authorItem_Data["user"]["sales"]        = $ts_vcsc_extend_authorItem_Sales;
			$ts_vcsc_extend_authorItem_Data["user"]["followers"]    = $ts_vcsc_extend_authorItem_Fans;
			update_option('ts_vcsc_extend_settings_authorData', 	$ts_vcsc_extend_authorItem_Data);
			update_option('ts_vcsc_extend_settings_authorCheck', 	$ts_vcsc_extend_authorItem_Check);
			$output                             = $ts_vcsc_extend_authorItem_Sales;
		}
		
		if (($format == "true") && ($output != '') && ($output != 'N/A')) {
			$output                             = number_format($output, 0);
		}
		
		echo $output;
		$myvariable                     		= ob_get_clean();
		
		return $myvariable;
	}
?>