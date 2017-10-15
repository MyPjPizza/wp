<?php
	if (!class_exists('TS_TimeSensitive')){
		class TS_TimeSensitive{
			function __construct(){
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('init',                                  array($this, 'TS_VCSC_Add_TimeSensitive_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('init',                                  array($this, 'TS_VCSC_Add_TimeSensitive_Elements'), 9999999);
					}
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
						add_action('admin_init',							array($this, 'TS_VCSC_Add_TimeSensitive_Lean'), 9999999);
					} else if (function_exists('vc_map')) {
						add_action('admin_init',							array($this, 'TS_VCSC_Add_TimeSensitive_Elements'), 9999999);
					}
				}
				if ((is_admin() == false) || ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true")) {
					add_shortcode('TS_VCSC_TimeSensitive_Frame',          	array($this, 'TS_VCSC_TimeSensitive_Frame_Function'));
				}
			}
			
			// Register Element(s) via LeanMap
			function TS_VCSC_Add_TimeSensitive_Lean() {
				vc_lean_map('TS_VCSC_TimeSensitive_Frame', 					array($this, 'TS_VCSC_Add_TimeSensitive_Elements'), null);
			}
			
			// Create Array with Date/Time Values
			function TS_VCSC_CreateTimeValueArray($ts = null){ 
				$k = array('seconds', 'minutes', 'hours', 'mday', 'wday', 'mon', 'year', 'yday', 'weekday', 'month', 0); 
				//return(array_combine($k, split(":", gmdate('s:i:G:j:w:n:Y:z:l:F:U', is_null($ts) ? time() : $ts))));
				//return(array_combine($k, preg_split(":", gmdate('s:i:G:j:w:n:Y:z:l:F:U', is_null($ts) ? time() : $ts))));
				return(array_combine($k, explode(":", gmdate('s:i:G:j:w:n:Y:z:l:F:U', is_null($ts) ? time() : $ts)))); 
			}
			
			// Check Current Time Against Time Range
			function TS_VCSC_DateTimeRangeAgainstCurrent($timeonly, $scope = null, $period, $current){
				$render						= "false";
				if ($scope == "full") {
					$render					= "true";
				} else if ($scope == "none") {
					$render					= "false";
				} else if (($scope == "period") || (($scope == null) && ($timeonly == true))) {
					$period 				= explode(",", $period);
					$start					= $period[0] * 5;
					$stop					= $period[1] * 5;
					$start					= date('H:i:s', mktime(0, $start, 0));
					$stop					= date('H:i:s', mktime(0, $stop, 0));
					if (($current >= $start) && ($current <= $stop)) {
						$render				= "true";
					}
				}
				return $render;
			}
			
			// Shortcode Output
			function TS_VCSC_TimeSensitive_Frame_Function($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				$current_offset				= get_option('gmt_offset');
				
				extract(shortcode_atts(array(
					'processing'			=> 'server', 		// server, client, shortcode, function
					'dependency'			=> 'datetime', 		// datetime, dateonly, timeonly, weekdays, always
					'timezone'				=> $current_offset,
					// Date + Time Period
					'datetime_range'		=> '|',
					// Date Only Period
					'dateonly_range'		=> '|',
					// Time Only Period
					'timeonly_period'		=> '96,192',
					'timeonly_weekend'		=> 'false',
					// Mondays
					'mondays_scope'			=> 'full',
					'mondays_period'		=> '96,192',
					// Tuesdays
					'tuesdays_scope'		=> 'full',
					'tuesdays_period'		=> '96,192',
					// Wednesdays
					'wednesdays_scope'		=> 'full',
					'wednesdays_period'		=> '96,192',
					// Thursdays
					'thursdays_scope'		=> 'full',
					'thursdays_period'		=> '96,192',
					// Fridays
					'fridays_scope'			=> 'full',
					'fridays_period'		=> '96,192',
					// Saturdays
					'saturdays_scope'		=> 'none',
					'saturdays_period'		=> '108,180',
					// Sundays
					'sundays_scope'			=> 'none',
					'sundays_period'		=> '144,216',
					// Custom Callbacks
					'callback_shortcode'	=> '',
					'callback_function'		=> '',
				),$atts));
				
				$output						= '';
				$randomizer					= mt_rand(999999, 9999999);
				$render_content				= "false";
				$render_start				= date('H:i:s', mktime(0, 0, 0));
				$render_stop				= date('H:i:s', mktime(0, 0, 0));
				
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$render_frontend		= "false";
				} else {
					$render_frontend		= "true";
				}

				if (($processing == "server") && ($render_frontend == "true")) {
					// Get Current Date/Time Values
					$current_local 			= current_time('timestamp', 1);
					$current_local			= $current_local + $timezone * 3600;		
					$current_moment			= $this->TS_VCSC_CreateTimeValueArray($current_local);
					$current_day			= $current_moment['mday'];
					$current_month			= $current_moment['mon'];
					$current_year			= $current_moment['year'];
					$current_weekday		= $current_moment['weekday'];
					$current_seconds		= $current_moment['seconds'];
					$current_minutes		= $current_moment['minutes'];
					$current_hours			= $current_moment['hours'];
					$current_unix			= $current_moment['0'];
					$current_date			= '';
					$current_time			= date('H:i:s', mktime($current_hours, $current_minutes, $current_seconds));
					// Check for Dependency
					if ($dependency == 'datetime') {
						$datetimerange		= explode("|", $datetime_range);
						$datetimestart		= $datetimerange[0];
						$datetimeend		= $datetimerange[1];
						if (($current_local >= strtotime($datetimestart)) && ($current_local <= strtotime($datetimeend))) {
							$render_content	= "true";
						}
					} else if ($dependency == 'dateonly') {
						$dateonlyrange		= explode("|", $dateonly_range);
						$dateonlystart		= $dateonlyrange[0];
						$dateonlyend		= $dateonlyrange[1];
						if (($current_local >= strtotime($dateonlystart)) && ($current_local <= strtotime($dateonlyend))) {
							$render_content	= "true";
						}
					} else if ($dependency == 'timeonly') {
						$render_content		= $this->TS_VCSC_DateTimeRangeAgainstCurrent(true, null, $timeonly_period, $current_time);
						if (($timeonly_weekend == "false") && (($current_weekday == "Saturday") || ($current_weekday == "Sunday"))) {
							$render_content	= "false";
						}
					} else if ($dependency == 'weekdays') {
						if ($current_weekday == 'Monday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $mondays_scope, $mondays_period, $current_time);
						} else if ($current_weekday == 'Tuesday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $tuesdays_scope, $tuesdays_period, $current_time);
						} else if ($current_weekday == 'Wednesday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $wednesdays_scope, $wednesdays_period, $current_time);
						} else if ($current_weekday == 'Thursday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $thursdays_scope, $thursdays_period, $current_time);
						} else if ($current_weekday == 'Friday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $fridays_scope, $fridays_period, $current_time);
						} else if ($current_weekday == 'Saturday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $saturdays_scope, $saturdays_period, $current_time);
						} else if ($current_weekday == 'Sunday') {
							$render_content	= $this->TS_VCSC_DateTimeRangeAgainstCurrent(false, $sundays_scope, $sundays_period, $current_time);
						}
					} else if ($dependency == 'always') {
						$render_content		= "true";
					}
				} else if (($processing == "client") && ($render_frontend == "true")) {
					wp_enqueue_script('ts-extend-momentjs');
					wp_enqueue_script('ts-visual-composer-extend-dependencies');
					// Data Attributes
					$data_general			= 'data-processing="' . $processing . '" data-dependency="' . $dependency . '" data-timezone="' . $timezone . '"';
					// Date + Time Range
					$datetime_array			= explode("|", $datetime_range);
					$datetime_start			= $datetime_array[0];
					$datetime_end			= $datetime_array[1];
					$data_datetime			= 'data-datetime-range="' . $datetime_range . '" data-datetime-start="' . $datetime_start . '" data-datetime-end="' . $datetime_end . '"';
					// Date Only Range
					$dateonly_array			= explode("|", $dateonly_range);
					$dateonly_start			= $dateonly_array[0];
					$dateonly_end			= $dateonly_array[1];
					$data_dateonly			= 'data-dateonly-range="' . $dateonly_range . '" data-dateonly-start="' . $dateonly_start . '" data-dateonly-end="' . $dateonly_end . '"';
					// Time Only Range
					$timeonly_array			= explode(",", $timeonly_period);
					$timeonly_start			= $timeonly_array[0];
					$timeonly_end			= $timeonly_array[1];
					$data_timeonly			= 'data-timeonly-range="' . $timeonly_period . '" data-timeonly-start="' . $timeonly_start . '" data-timeonly-end="' . $timeonly_end . '" data-timeonly-weekend="' . $timeonly_weekend . '"';
					// Days of the Week
					$data_days_scope		= 'data-mondays-scope="' . $mondays_scope . '" data-tuesdays-scope="' . $tuesdays_scope . '" data-wednesdays-scope="' . $wednesdays_scope . '" data-thursdays-scope="' . $thursdays_scope . '" data-fridays-scope="' . $fridays_scope . '" data-saturdays-scope="' . $saturdays_scope . '" data-sundays-scope="' . $sundays_scope . '"';
					$data_days_period		= 'data-mondays-period="' . $mondays_period . '" data-tuesdays-period="' . $tuesdays_period . '" data-wednesdays-period="' . $wednesdays_period . '" data-thursdays-period="' . $thursdays_period . '" data-fridays-period="' . $fridays_period . '" data-saturdays-period="' . $saturdays_period . '" data-sundays-period="' . $sundays_period . '"';
					if ($dependency != 'always') {
						$output .= '<div id="ts-datetime-dependency-container-' . $randomizer . '" class="ts-datetime-dependency-container" style="position: fixed; top: -9999px; left: -9999px; opacity: 0; margin: 0; padding: 0;" ' . $data_general . ' ' . $data_datetime . ' ' . $data_dateonly . ' ' . $data_timeonly . ' ' . $data_days_scope . ' ' . $data_days_period .'>';
					}
						$output .= do_shortcode($content);
					if ($dependency != 'always') {
						$output .= '</div>';
					}
				} else if (($processing == "shortcode") && ($render_frontend == "true")) {
					// Shortcode must return "true"/true/"1"/1 or "false"/false/"0"/0
					$callback_shortcode		= rawurldecode(base64_decode(strip_tags($callback_shortcode)));
					$callback_shortcode		= do_shortcode($callback_shortcode);
					if (($callback_shortcode != "") && (($callback_shortcode === "true") || ($callback_shortcode === true) || ($callback_shortcode === "1") || ($callback_shortcode === 1))) {
						$render_content		= "true";
					} else {
						$render_content		= "false";
					}					
				} else if (($processing == "function") && ($render_frontend == "true")) {
					// Function must return "true"/true/"1"/1 or "false"/false/"0"/0
					$callback_function		= rawurldecode(base64_decode(strip_tags($callback_function)));
					preg_match('#\((.*?)\)#', $callback_function, $match);					
					$callback_params		= $match[1];
					$callback_userfunc		= str_replace($match[0], "", $callback_function);
					if ($callback_params != '') {
						$callback_params	= explode(",", $callback_params);
						$callback_result	= call_user_func_array($callback_userfunc, $callback_params);
					} else {
						$callback_result	= call_user_func($callback_userfunc, '');
					}
					if (($callback_result != '') && (($callback_result === "true") || ($callback_result === true) || ($callback_result === "1") || ($callback_result === 1))) {
						$render_content		= "true";
					} else {
						$render_content		= "false";
					}
				} else if (($processing == "always") && ($render_frontend == "true")) {
					$render_content			= "true";
				}
				
				// Render Content if Fulfilled
				if (($render_content == "true") && ($processing != "client") && ($render_frontend == "true")) {
					$output .= do_shortcode($content);
				} else if  ($render_frontend == "false") {
					$output .= '<div class="ts-datetime-dependency-frontend" style="width: 100%; margin: 35px auto 0 auto; padding: 0; position: relative;">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				}
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			
			function TS_VCSC_Add_TimeSensitive_Elements() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				$current_local 							= current_time('timestamp', 0);
				$current_moment							= $this->TS_VCSC_CreateTimeValueArray($current_local);
				$current_time							= date('h:i A', mktime($current_moment['hours'] + 1, 0, 0));
				$current_offset							= get_option('gmt_offset');
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element = array(
					"name" 								=> __("TS Time / Date Dependency", "ts_visual_composer_extend"),
					"base" 								=> "TS_VCSC_TimeSensitive_Frame",
					"icon" 								=> "ts-composer-element-icon-timesensitive-container",
					"class" 							=> "",
					"as_parent" 						=> array('except' => 'TS_VCSC_TimeSensitive_Frame'),
					"category" 							=> "VC Extensions",
					"description" 						=> "Show elements with a date/time dependency.",
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"js_view" 							=> 'VcColumnView',
					"params" 							=> array(
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "General Settings",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Content: Processing", "ts_visual_composer_extend" ),
							"param_name"		    	=> "processing",
							"value"                 	=> array(
								__("Website Server (PHP)", "ts_visual_composer_extend")					=> "server",
								__("Client Browser (JS/CSS)", "ts_visual_composer_extend")				=> "client",
								__("Callback: Custom Shortcode", "ts_visual_composer_extend")			=> "shortcode",
								__("Callback: Custom Function", "ts_visual_composer_extend")			=> "function",								
							),
							"admin_label"				=> true,
							"description"		    	=> __( "Select how the dependency for the content should be processed and/or determined.", "ts_visual_composer_extend" ),
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Content: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "dependency",
							"value"                 	=> array(
								__("Date Range with Time", "ts_visual_composer_extend")					=> "datetime",
								__("Date Range Only", "ts_visual_composer_extend")						=> "dateonly",
								__("Time Range Only", "ts_visual_composer_extend")						=> "timeonly",
								__("Weekday Specific", "ts_visual_composer_extend")						=> "weekdays",
								__("Always Show Content", "ts_visual_composer_extend")					=> "always",
							),
							"admin_label"				=> true,
							"description"		    	=> __( "Select how the dependency for the content should be defined.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "processing", 'value' => array('server', 'client') )
						),				
						// Custom Shortcode
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Callback: Custom Shortcode", "ts_visual_composer_extend" ),
							"param_name"        		=> "callback_shortcode",
							"value"             		=> base64_encode(""),
							"description"       		=> __( "Enter the full shortcode syntax (attributes allowed) that will generate the required callback ('true'/true/'1'/1 or 'false'/false/'0'/0).", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "processing", 'value' => 'shortcode' ),
						),
						// Custom Function
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Callback: Custom Function", "ts_visual_composer_extend" ),
							"param_name"        		=> "callback_function",
							"value"             		=> base64_encode(""),
							"description"       		=> __( "Enter the full function syntax (attributes allowed) that will generate the required callback ('true'/true/1 or 'false'/false/0).", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "processing", 'value' => 'function' ),
						),
						// Timezone Adjustment
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Content: Timezone", "ts_visual_composer_extend" ),
							"param_name"        		=> "timezone",
							"width"             		=> 150,
							"value"             		=> array(
								'GMT -12:00'															=> "-12",
								'GMT -11:00'															=> "-11",
								'GMT -10:00'															=> "-10",
								'GMT -09:00'															=> "-9",
								'GMT -08:00'															=> "-8",
								'GMT -07:00'															=> "-7",
								'GMT -06:00'															=> "-6",
								'GMT -05:00'															=> "-5",
								'GMT -04:00'															=> "-4",
								'GMT -03:00'															=> "-3",
								'GMT -03:30'															=> "-3.5",
								'GMT -02:00'															=> "-2",
								'GMT -01:00'															=> "-1",
								'GMT 00:00'																=> "0",
								'GMT +01:00'															=> "1",
								'GMT +02:00'															=> "2",
								'GMT +03:00'															=> "3",
								'GMT +03:30'															=> "3.5",
								'GMT +04:00'															=> "4",
								'GMT +04:30'															=> "4.5",
								'GMT +05:00'															=> "5",
								'GMT +05:30'															=> "5.5",
								'GMT +05:45'															=> "5.75",
								'GMT +06:00'															=> "6",
								'GMT +06:30'															=> "6.5",
								'GMT +07:00'															=> "7",
								'GMT +08:00'															=> "8",
								'GMT +09:00'															=> "9",
								'GMT +09:30'															=> "9.5",
								'GMT +10:00'															=> "10",
								'GMT +11:00'															=> "11",
								'GMT +12:00'															=> "12",
								'GMT +13:00'															=> "13",
							),
							"std"						=> $current_offset,
							"default"					=> $current_offset,
							"description"       		=> __( "Please define the timezone offset the date and/or time dependent content should be based on. Learn more:", "ts_visual_composer_extend" ) . ' <a href="http://www.timeanddate.com/time/map/" target="_blank">' . __( 'Time Zones', "ts_visual_composer_extend" ) . '</a>',
							"dependency"        		=> array( 'element' => "dependency", 'value' => array('datetime', 'dateonly', 'timeonly', 'weekdays') )
						),
						// Date + Time Range
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_3",
							"value"						=> "",
							"seperator"					=> "Date + Time Range",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "datetime"),
						),
						array(
							"type"              		=> "datetime_picker",
							"heading"           		=> __( "Date / Time Range", "ts_visual_composer_extend" ),
							"param_name"        		=> "datetime_range",
							"range"						=> "true",
							"period"					=> "datetime",
							"spacing"					=> 0,
							"value"             		=> date("m/d/Y") . " " . $current_time . "|", // date("m/d/Y", time() + 86400) . " 06:00 AM",
							"description"       		=> __( "Select the date and time to which you want to count down to.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "datetime"),
						),						
						// Date Range Only
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_4",
							"value"						=> "",
							"seperator"					=> "Date Only Range",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "dateonly"),
						),
						array(
							"type"              		=> "datetime_picker",
							"heading"           		=> __( "Date Range", "ts_visual_composer_extend" ),
							"param_name"        		=> "dateonly_range",
							"range"						=> "true",
							"period"					=> "date",
							"spacing"					=> 20,
							"value"             		=> date("m/d/Y") . "|", // date("m/d/Y", time() + 86400),
							"description"       		=> __( "Select the date and time to which you want to count down to.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "dateonly"),
						),	
						// Time Range Only
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_5",
							"value"						=> "",
							"seperator"					=> "Daily Time Range",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "timeonly"),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "timeonly_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for each day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "timeonly"),
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Time Range on Weekends", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeonly_weekend",
							"value"             		=> "true",				
							"description"       		=> __( "Switch the toggle if you want to use the time range above for weekends as well.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "timeonly"),
						),
						// Weekdays Settings
						// Mondays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_1",
							"value"						=> "",
							"seperator"					=> "Mondays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Mondays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "mondays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "full",
							"default"					=> "full",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Mondays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "mondays_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "mondays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Tuesdays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_2",
							"value"						=> "",
							"seperator"					=> "Tuesdays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Tuesdays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "tuesdays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "full",
							"default"					=> "full",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Tuesdays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "tuesdays_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "tuesdays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Wednesday
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_3",
							"value"						=> "",
							"seperator"					=> "Wednesdays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Wednesdays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "wednesdays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "full",
							"default"					=> "full",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Wednesdays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "wednesdays_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "wednesdays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Thursdays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_4",
							"value"						=> "",
							"seperator"					=> "Thursdays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Thursdays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "thursdays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "full",
							"default"					=> "full",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Thursdays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "thursdays_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "thursdays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Fridays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_5",
							"value"						=> "",
							"seperator"					=> "Fridays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Fridays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "fridays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "full",
							"default"					=> "full",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Fridays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "fridays_period",
							"value"                     => "96,192", 	// 8:00 AM - 4:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "fridays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Saturdays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_6",
							"value"						=> "",
							"seperator"					=> "Saturdays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Saturdays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "saturdays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "none",
							"default"					=> "none",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Saturdays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "saturdays_period",
							"value"                     => "108,180", 	// 9:00 AM - 3:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "saturdays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),
						// Sundays
						array(
							"type"              		=> "seperator",
							"heading"           		=> "",
							"param_name"        		=> "seperator_6_7",
							"value"						=> "",
							"seperator"					=> "Sundays",
							"description"       		=> "",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Sundays: Visibility Scope", "ts_visual_composer_extend" ),
							"param_name"		    	=> "sundays_scope",
							"value"                 	=> array(
								__("Show Content All Day", "ts_visual_composer_extend")			=> "full",
								__("Show Content For A Period", "ts_visual_composer_extend")	=> "period",
								__("Do Not Show Content", "ts_visual_composer_extend")			=> "none",
							),							
							"description"		    	=> __( "Define if and when the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"std"						=> "none",
							"default"					=> "none",
							"dependency"		    	=> array("element" 	=> "dependency", "value" 	=> "weekdays"),
							"group"						=> "Days Of The Week"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Sundays: Time Range", "ts_visual_composer_extend" ),
							"param_name"                => "sundays_period",
							"value"                     => "144,216", 	// 12:00 AM - 6:00 PM
							"min"                       => "1",			// 5 Minutes
							"max"                       => "288",		// 12:00 AM
							"step"                      => "1",			// 5 Minutes
							"range"						=> "true",
							"start"						=> "96",		// 8:00 AM
							"end"						=> "192",		// 4:00 PM
							"description"               => __( "Define the time range during which the content should be shown for this day of the week.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array("element" 	=> "sundays_scope", "value" 	=> "period"),
							"group"						=> "Days Of The Week"
						),	
						// Load Custom CSS/JS File
						array(
							"type"              		=> "load_file",
							"heading"           		=> "",
							"value"             		=> "Animation Files",
							"param_name"        		=> "el_file",
							"file_type"         		=> "js",
							"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
					)						
				);
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_LeanMap == "true") {
					return $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element;
				} else {			
					vc_map($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Element);
				};
			}
		}
	}
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_TS_VCSC_TimeSensitive_Frame extends WPBakeryShortCodesContainer {};
	}
	
	// Initialize "TS Time Sensitive" Class
	if (class_exists('TS_TimeSensitive')) {
		$TS_TimeSensitive = new TS_TimeSensitive;
	}
?>