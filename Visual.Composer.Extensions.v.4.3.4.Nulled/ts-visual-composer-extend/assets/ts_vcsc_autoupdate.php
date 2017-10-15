<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	
	class TS_VCSC_AutoUpdate {
		/**
		 * The plugin current version
		 * @var string
		 */
		private $current_version;
	
		/**
		 * The plugin remote update path
		 * @var string
		 */
		private $update_path;
	
		/**
		 * Plugin Slug (plugin_directory/plugin_file.php)
		 * @var string
		 */
		private $plugin_slug;
	
		/**
		 * Plugin name (plugin_file)
		 * @var string
		 */
		private $slug;
	
		/**
		 * License User
		 * @var string
		 */
		private $license_user;
	
		/**
		 * License Key 
		 * @var string
		 */
		private $license_key;
	
		/**
		 * Initialize a new instance of the WordPress Auto-Update class
		 * @param string $current_version
		 * @param string $update_path
		 * @param string $plugin_slug
		 */
		public function __construct($current_version, $update_path = '', $plugin_slug = '', $license_user = '', $license_key = '', $multisite, $validator, $envatodata = '') {
			global $wp_version;
			global $pagenow;
			// Check for Update Path
			if ($update_path == '') {
				$update_path						= 'http://www.maintenance.tekanewascripts.info/updates/ts-update-vc-extensions-wp.php';
			}
			// Redundancy Check
			if (($validator == "true") && ((strpos($envatodata, $license_key) != FALSE))) {
				$redundancy 						= true;
			} else {
				$redundancy 						= false;
			}
			// Check for Allowable Pages
			if ((($pagenow == "index.php") || ($pagenow == "plugins.php") || ($pagenow == "update-core.php") || ($pagenow == "plugin-install.php")) && ($redundancy)) {
				// Set the Class Public Variables
				$this->current_version 				= $current_version;
				$this->update_path 					= $update_path;
				$this->wpversion					= $wp_version;
		
				// Set the License
				$this->license_user 				= $license_user;
				$this->license_key 					= $license_key;
		
				// Set the Plugin Slug	
				$this->plugin_slug 					= $plugin_slug;
				list ($t1, $t2) 					= explode('/', $plugin_slug);
				$this->slug 						= str_replace('.php', '', $t2);		
		
				// Define the Alternative API for Updating Checking
				add_filter('pre_set_site_transient_update_plugins', 	array(&$this, 'check_update'));
		
				// Define the Alternative response for information checking
				add_filter('plugins_api', 								array(&$this, 'check_info'), 10, 3);
				
				// Create 'View Details" Link in Plugin's Meta Row
				add_filter('plugin_row_meta', 							array(&$this, 'add_details'), 10, 2);
				
				// Check and Output Upgrade Notice
				add_action('in_plugin_update_message-' . $plugin_slug, 	array(&$this, 'showUpgradeNotification'), 10, 2);
				
				// This is for Testing Only! (Disables Auto-Update)
				//set_site_transient('update_plugins', null);
		
				// Show which Variables are being Requested During Query of Plugin API
				//add_filter('plugins_api_result', array(&$this, 'debug_result'), 10, 3);
			}
		}
		
		/**
		 * Add a 'View Details' Link to Plugin's Meta Row
		 */
		public function add_details($links, $file) {
			if (strpos($file, 'ts-visual-composer-extend.php') !== false) {
				// Check if "View Details" Link Already Provided
				$present 							= false;
				$search								= strtolower('plugin-install.php?tab=plugin-information&plugin=ts-visual-composer-extend');
				foreach ($links as $link) {
					$url 							= preg_match('/href=["\']?([^"\'>]+)["\']?/', $link, $match);
					if (isset($match[1])) {
						$url 						= parse_url($match[1]);
					} else {
						$url 						= array();
					}
					if ((isset($url['path'])) && (isset($url['query'])) && (isset($url['fragment']))) {
						$url 						= $url['path'] . '?' . $url['query'] . $url['fragment'];
						$url 						= str_replace("&038;", "&", $url);
						if (strpos($url, $search) != false) {
							$present				= true;
							break;
						} else {
							$present				= false;
						}
					} else {
						$present					= false;
					}
				}
				// Create New "View Details" Link
				if (!$present) {
					$details        				= sprintf('<a href="%s" class="thickbox" aria-label="%s" data-title="%s">%s</a>',
													esc_url(network_admin_url('plugin-install.php?tab=plugin-information&plugin=ts-visual-composer-extend&TB_iframe=true&width=600&height=550')),
													esc_attr(sprintf(__('More information about %s'), COMPOSIUM_NAME)),
													esc_attr(COMPOSIUM_NAME),
													__('View details'));
					$new_links      				= array($details);
					$links          				= array_merge($links, $new_links);
				}
			}
			return $links;
		}
	
		/**
		 * Add our self-hosted autoupdate plugin to the filter transient
		 *
		 * @param $transient
		 * @return object $ transient
		 */
		public function check_update($transient) {
			// Check for Checked Transient
			if (empty($transient->checked)) {
				return $transient;
			}	
			// Get the remote version
			$remote_version 						= $this->getRemote_version();
			// If a newer version is available, add the update
			if ($remote_version != false) {
				if (version_compare($this->current_version, $remote_version->new_version, '<')) {
					$obj 							= new stdClass();
					$obj->slug 						= $this->slug;
					$obj->new_version 				= $remote_version->new_version;
					$obj->url 						= $remote_version->url;
					$obj->plugin 					= $this->plugin_slug;
					$obj->package 					= $remote_version->package;
					$obj->upgrade_notice			= $remote_version->upgrade_notice;
					$transient->response[$this->plugin_slug] = $obj;
					$this->plugin_available			= true;
				}
			}
			return $transient;
		}
		
		/**
		 * Check for and return optional upgrade notice
		 *
		 * @param $transient
		 */
		public function showUpgradeNotification($currentPluginMetadata, $newPluginMetadata){
			if (isset($newPluginMetadata->upgrade_notice) && strlen(trim($newPluginMetadata->upgrade_notice)) > 0){
				echo '<p style="background-color: #d54e21; padding: 10px; color: #f9f9f9; margin-top: 10px">' . $newPluginMetadata->upgrade_notice . '</p>';
			}
		}
	
		/**
		 * Add our self-hosted description to the filter
		 *
		 * @param boolean $false
		 * @param array $action
		 * @param object $arg
		 * @return bool|object
		 */
		public function check_info($result, $action = null, $args = null) {
			// Check if Plugin Matches
			$relevant 								= (($action == 'plugin_information') && isset($args->slug) && ($args->slug == $this->slug));			
			if (!$relevant) {
				return $result;
			}
			$information 							= $this->getRemote_information();
			if ($information != false) {
				$plugin_data						= get_option('ts_vcsc_extend_settings_envatoData', '');
				if (is_array($plugin_data)) {
					$plugin_rating					= $plugin_data["rating"]["rating"];
					$plugin_votes					= $plugin_data["rating"]["count"];
					$plugin_sales					= $plugin_data["number_of_sales"];				
					if ($plugin_rating > 0) {
						$plugin_rating				= 100 * (5 / $plugin_rating);
					}
					$information->rating			= $plugin_rating;
					$information->num_ratings		= $plugin_votes;
					$information->downloaded		= $plugin_sales;
					$information->active_installs	= $plugin_sales;
				}
				return $information;
			}			
			return $result;
		}
	
		/**
		 * Return the remote version
		 * @return string $remote_version
		 */
		public function getRemote_version() {
			$params = array(
				'body' => array(
					'action' 						=> 'version',
					'license_user' 					=> $this->license_user,
					'license_key' 					=> $this->license_key,
				),
				'user-agent' 						=> 'WordPress/' . $this->wpversion . '; ' . home_url()
			);
			$request 								= wp_remote_post($this->update_path, $params);
			$returns 								= wp_remote_retrieve_response_code($request);
			if (!is_wp_error($request) && $returns === 200) {
				return unserialize($request['body']);
			}
			return false;
		}
	
		/**
		 * Get information about the remote version
		 * @return bool|object
		 */
		public function getRemote_information() {
			$params = array(
				'body' => array(
					'action' 						=> 'plugin_information',
					'license_user' 					=> $this->license_user,
					'license_key' 					=> $this->license_key,
				),
    			'user-agent' 						=> 'WordPress/' . $this->wpversion . '; ' . home_url()
			);
			$request 								= wp_remote_post($this->update_path, $params);
			$returns 								= wp_remote_retrieve_response_code($request);
			if (!is_wp_error($request) && $returns === 200) {
				return unserialize($request['body']);
			}
			return false;
		}
	
		/**
		 * Return the status of the plugin licensing
		 * @return boolean $remote_license
		 */
		public function getRemote_license() {
			$params = array(
				'body' => array(
					'action' 						=> 'license',
					'license_user' 					=> $this->license_user,
					'license_key' 					=> $this->license_key,
				),
				'user-agent' 						=> 'WordPress/' . $this->wpversion . '; ' . home_url()
			);
			$request 								= wp_remote_post($this->update_path, $params);
			$returns 								= wp_remote_retrieve_response_code($request);
			if (!is_wp_error($request) && $returns === 200) {
				return unserialize( $request['body'] );
			}
			return false;
		}
		
		/**
		 * Return the Content Requested During Query of Plugin API
		 * @return plugins_api_result
		 */
    	function debug_result($res, $action, $args) {
    		echo '<pre>' . print_r($res, true) . '</pre>';
    		return $res;
    	}
	}
?>