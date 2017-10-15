<?php
/**
 * This file contains all functions used within plugin.
 *
 * @since 1.0.0
 * @package GeoDir_Affiliate
 */
 
/**
 * Load geodirectory affiliate plugin textdomain.
 *
 * @since 1.0.0
 */
function geodir_affiliate_load_textdomain() {
	/**
	 * Filter a plugin's locale.
	 *
	 * @since 1.0.0
	 *
	 * @param string $locale The plugin's current locale.
	 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
	 */
	$locale = apply_filters('plugin_locale', get_locale(), 'gdaffiliate');
	
	load_textdomain('gdaffiliate', WP_LANG_DIR . '/' . 'gdaffiliate' . '/' . 'gdaffiliate' . '-' . $locale . '.mo');
	load_plugin_textdomain('gdaffiliate', false, dirname(plugin_basename(__FILE__)) . '/gdaffiliate-languages');
	
	/**
	 * Define language constants.
	 *
	 * @since 1.0.0
	 */
	require_once( GDAFFILIATE_PLUGIN_PATH . '/language.php' );
	
	/**
	 * Includes all AffiliateWP related functions.
	 *
	 * @since 1.0.0
	 */
	if ( is_plugin_active( 'geodir_payment_manager/geodir_payment_manager.php' ) && class_exists( 'Affiliate_WP' ) ) {
		require_once( GDAFFILIATE_PLUGIN_PATH . '/includes/class-geodirectory.php' );
	}
}

/**
 * Called after geodirctory affiliate plugin activated.
 *
 * @since 1.0.0
 *
 * @param string $plugin Plugin directory path.
 */
function geodir_affiliate_plugin_activated( $plugin ) {
	if (!get_option('geodir_installed'))  {
		$file = plugin_basename(__FILE__);
		
		if ($file == $plugin) {
			$all_active_plugins = get_option( 'active_plugins', array() );
			
			if (!empty($all_active_plugins) && is_array($all_active_plugins)) {
				foreach ($all_active_plugins as $key => $plugin) {
					if ($plugin ==$file) {
						unset($all_active_plugins[$key]);
					}
				}
			}
			update_option('active_plugins', $all_active_plugins);
		}
		
		wp_die(__('<span style="color:#FF0000">There was an issue determining where GeoDirectory Plugin is installed and activated. Please install or activate GeoDirectory Plugin.</span>', 'gdaffiliate'));
	}
}

/**
 * Called on geodirctory affiliate plugin activation.
 *
 * @since 1.0.0
 */
function geodir_affiliate_activation(){
	if ( !class_exists( 'Affiliate_WP' ) ) {
		// is this plugin active?
		if ( is_plugin_active( 'geodir_affiliate/geodir_affiliate.php' ) ) {
			// deactivate the plugin
			deactivate_plugins( 'geodir_affiliate/geodir_affiliate.php' );

			if ( isset( $_GET[ 'activate' ] ) ) {
				// unset activation notice
				unset( $_GET[ 'activate' ] );
			}

			// display notice
			add_action( 'admin_notices', 'geodir_affiliate_admin_notices' );
		}
	}
}

/**
 * Called on geodirctory affiliate plugin deactivation.
 *
 * @since 1.0.0
 */
function geodir_affiliate_deactivation() {
}

/**
 * Redirect to page after plugin activated.
 *
 * @since 1.0.0
 */
function geodir_affiliate_activation_redirect(){
}

/**
 * Get the all activated integrations in AffiliateWP.
 *
 * @since 1.0.0
 *
 * @param array $integrations Array of activated AffiliateWP integrations.
 * @return array Array of activated integrations in AffiliateWP.
 */
function geodir_affiliate_affwp_integration($integrations = array()) {
	$integrations['geodirectory'] = 'GeoDirectory';
	
	return $integrations;
}

/**
 * Shows admin notice if AffiliateWP isn't installed
 *
 * @since 1.0.0
 */
function geodir_affiliate_admin_notices() {
	if ( !class_exists( 'Affiliate_WP' ) ) {
		echo '<div class="error"><p>' . __( 'You must install and activate <strong><a href="https://affiliatewp.com/pricing" title="AffiliateWP" target="_blank">AffiliateWP</a></strong> to use <strong>GeoDirectory AffiliateWP Integration</strong>.', 'gdaffiliate' ) . '</p></div>';
	}
}

/**
 * Add the plugin to uninstall settings.
 *
 * @since 1.0.6
 *
 * @return array $settings the settings array.
 * @return array The modified settings.
 */
function geodir_affiliate_uninstall_settings($settings) {
    $settings[] = plugin_basename(dirname(__FILE__));
    
    return $settings;
}