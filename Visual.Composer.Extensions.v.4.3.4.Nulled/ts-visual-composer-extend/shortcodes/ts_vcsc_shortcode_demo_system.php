<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    
	// Shortcode to generate System Information Overview
	add_shortcode('TS_VCSC_System_Information', 'TS_VCSC_System_Information');
	function TS_VCSC_System_Information ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		global $VISUAL_COMPOSER_EXTENSIONS;
		global $wpdb, $edd_options;
		
		wp_enqueue_style('dashicons');
		wp_enqueue_style('ts-visual-composer-extend-demos');
		wp_enqueue_script('ts-visual-composer-extend-demos');	
		
		if (!class_exists('Browser')) {
			require_once $VISUAL_COMPOSER_EXTENSIONS->detector_dir . 'ts_browser_detect.php';
		}
		$browser = new Browser();
		if (get_bloginfo('version') < '3.4') {
			$theme_data = get_theme_data(get_stylesheet_directory() . '/style.css');
			$theme      = $theme_data['Name'] . ' ' . $theme_data['Version'];
		} else {
			$theme_data = wp_get_theme();
			$theme      = $theme_data->Name . ' ' . $theme_data->Version;
		}
		
		$mysql_version_info 			= "N/A";
		if (function_exists('mysqli_connect')) {
			if (defined('WP_USE_EXT_MYSQL')) {
				$mysql_version_info 	= mysql_get_server_info($wpdb->dbh);
			} elseif (version_compare(phpversion(), '5.5', '>=') || ! function_exists('mysql_connect')) {
				$mysql_version_info 	= mysqli_get_server_info($wpdb->dbh);
			} elseif (false !== strpos($GLOBALS['wp_version'], '-')) {
				$mysql_version_info 	= mysqli_get_server_info($wpdb->dbh);
			} else {
				$mysql_version_info 	= mysql_get_server_info($wpdb->dbh);
			}
		} else {
			$mysql_version_info 		= mysql_get_server_info($wpdb->dbh);
		}
		
		echo '<div class="ts-vcsc-system-information-wrap wrap" style="width: 100%;">';	
			echo '<div class="ts-vcsc-settings-group-header">';
				echo '<div class="display_header">';
					echo '<h2><span class="dashicons dashicons-desktop"></span>Visual Composer Extensions - System Information</h2>';
				echo '</div>';
				echo '<div class="clear"></div>';
			echo '</div>';	
			echo '<div class="ts-vcsc-system-information-main">';
				// Basic WordPress Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-wordpress"></i>Basic WordPress Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							echo '<tr><td>WordPress Version:</td><td>' . get_bloginfo('version') . '</td></tr>';
							echo '<tr><td>Multisite:</td><td>' . (is_multisite() ? 'Yes' . "\n" : 'No' . "\n") . '</td></tr>';
							echo '<tr><td>Site URL:</td><td>' . site_url() . '</td></tr>';
							echo '<tr><td>Home URL:</td><td>' . home_url() . '</td></tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
				// General Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-info"></i>General Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							echo '<tr><td>PHP Version:</td><td>' . PHP_VERSION . '</td></tr>';
							echo '<tr><td>MySQL Version:</td><td>' . $mysql_version_info . '</td></tr>';
							echo '<tr><td>Web Server Info:</td><td>' . $_SERVER['SERVER_SOFTWARE'] . '</td></tr>';
							echo '<tr><td>Browser:</td><td>' . $browser . '</td></tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
				// Memory Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-align-none"></i>Memory Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';					
						echo '<div style="text-align: justify; margin: 20px 0;">';
							echo 'The listed PHP Memory Limit only represents the amount of memory that is requested from the server via the php.ini file. That number does not mean that the server is actually providing
							that amount. Depending upon hosting service, many servers have internal limits that can not be changed by simply requesting a larger amount with the php.ini file. Please contact your hosting
							service to obtain the actualy amount of PHP memory your (shared) server is able to provide to you.';
						echo'</div>';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							echo '<tr><td>WordPress Memory Limit:</td><td>' . (TS_VCSC_LetToNumber(WP_MEMORY_LIMIT)/(1024)) . 'MB (as requested in wp-config.php)</td></tr>';
							echo '<tr><td>PHP Memory Limit:</td><td>' . ini_get('memory_limit') . 'B (as requested in php.ini)</td></tr>';
							$memoryusage 		= TS_VCSC_Memory_Usage();
							echo '<tr><td>PHP Current Memory:</td><td>' . ($memoryusage) . ' MB</td></tr>';
							$memoryutilization 	= (number_format((($memoryusage / ini_get('memory_limit')) * 100), 2, '.', ''));
							echo '<tr><td>PHP Memory Utilization:</td><td>' . $memoryutilization . '%</td></tr>';
							$peakmemory = (number_format(memory_get_peak_usage(false)/1024/1024, 2, '.', ''));
							echo '<tr><td>PHP Peak Memory:</td><td>' . $peakmemory . ' MB</td></tr>';
							echo '<tr><td>PHP Max. Upload Size:</td><td>' . ini_get('upload_max_filesize') . '</td></tr>';
							echo '<tr><td>PHP Max. Post Size:</td><td>' . ini_get('post_max_size') . '</td></tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
				// Theme Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-art"></i>Active Theme Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							echo '<tr><td>Active Theme:</td><td>' . $theme . '</td></tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
				// Plugin Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-plugins"></i>Active Plugins Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							echo '<tr>';
								echo '<td>Subsite Plugins:</td>';
								$plugins 					= get_plugins();
								$active_plugins 			= get_option('active_plugins', array());
								$wpbakery					= 'No';
								$vcextensions				= 'Not Activated';
								echo '<td><ul>';
								foreach ($plugins as $plugin_path => $plugin) {
									// If the plugin isn't active, don't show it.
									if (!in_array($plugin_path, $active_plugins)) {
										continue;
									} else {
										if (stripos($plugin['Name'], 'WPBakery') !== false) {
											$wpbakery		= 'Yes';
										} else if (stripos($plugin['TextDomain'], 'ts_visual_composer_extend') !== false) {
											$vcextensions	= 'v' . $plugin['Version'];
										}
										echo '<li>' . $plugin['Name'] . ' v' . $plugin['Version'] . "</li>";
									}
								}
								echo '</ul></td>';
							echo '</tr>';	
							if (is_multisite()) {
								echo '<tr><td colspan="2" style="height: 20px;"></td></tr>';
								echo '<tr>';
									echo '<td>Network Plugins:</td>';
									$plugins 			= wp_get_active_network_plugins();
									$active_plugins 	= get_site_option( 'active_sitewide_plugins', array() );
								echo '<td><ul>';
								foreach ($plugins as $plugin_path) {
									$plugin_base 		= plugin_basename($plugin_path);				
									// If the plugin isn't active, don't show it.
									if (!array_key_exists( $plugin_base, $active_plugins)) {
										continue;
									}				
									$plugin 			= get_plugin_data($plugin_path);				
									echo '<li>' . $plugin['Name'] . ' v' . $plugin['Version'] . "</li>";
								}
								echo '</ul></td>';			
							};
						echo '</table>';
					echo '</div>';
				echo '</div>';
				// Visual Composer Extensions Info			
				echo '<div class="ts-vcsc-section-main">';
					echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-nametag"></i>Composium - Visual Composer Extensions Info</div>';
					echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
						echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
							if (defined('WPB_VC_VERSION')){
								echo '<tr><td>Visual Composer:</td><td>v' . WPB_VC_VERSION . '</td></tr>';
							}
							echo '<tr><td>Standalone Visual Composer:</td><td>' . $wpbakery . '</td></tr>';
							echo '<tr><td>Visual Composer Extensions:</td><td>' . $vcextensions . '</td></tr>';					
							if (is_multisite()) {
								echo '<tr><td>Network Activated:</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") ? "Yes" : "No") . '</td></tr>';
							}
							echo '<tr><td>Available / Active Elements:</td><td>' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements . '</td></tr>';
							if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") {
								$TS_VCSC_TotalIconFontsInstalled = (count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts) + count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Icon_Fonts));
							} else {
								$TS_VCSC_TotalIconFontsInstalled = count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts);
							}	
							if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
								echo '<tr><td>Available / Active Icon Fonts:</td><td>' . $TS_VCSC_TotalIconFontsInstalled . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</td></tr>';
							} else {
								echo '<tr><td>Available / Active Icon Fonts:</td><td>' . ($TS_VCSC_TotalIconFontsInstalled - 1) . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</td></tr>';
							}							
							echo '<tr><td>Available / Active Icons:</td><td>' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count) . ' / ' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count) . '</td></tr>';
							echo '<tr><td>"Iconicum - WordPress Icon Fonts":</td><td>' . ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconicumStandard == "false") && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) ? "Enabled" : "Disabled") . '</td></tr>';
							echo '<tr><td>"WooCommerce":</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerceActive == "true") ? "Active" : "Inactive") . '</td></tr>';
							echo '<tr><td>"bbPress":</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPressActive == "true") ? "Active" : "Inactive") . '</td></tr>';
							echo '<tr><td>Custom Post Types:</td><td>' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesLoaded == "true" ? "Active" : "Inactive") . '</td></tr>';
							echo '<tr><td>Extended Row Options:</td><td>' . ((get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) ? "Active" : "Inactive") . '</td></tr>';
							echo '<tr><td>Extended Column Options:</td><td>' . ((get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) ? "Active" : "Inactive") . '</td></tr>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>