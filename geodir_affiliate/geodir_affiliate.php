<?php
/**
 * This is the main GeoDirectory AffiliateWP Integration plugin file, here we declare and call the important stuff
 *
 * @since 1.0.0
 * @package GeoDir_Affiliate
 */
 
/*
Plugin Name: GeoDirectory AffiliateWP Integration
Plugin URI: http://wpgeodirectory.com
Description: Allows to build integration between GeoDirectory & AffiliateWP.
Version: 1.0.8
Author: GeoDirectory
Author URI: http://wpgeodirectory.com
Requires at least: 3.1
Tested up to: 4.7
Update URL: https://wpgeodirectory.com
Update ID: 65079
*/

/**
 * The current version number of GeoDirectory AffiliateWP Integration.
 *
 * @since 1.0.0
 */
define( 'GDAFFILIATE_VERSION', '1.0.8' );

//GEODIRECTORY UPDATE CHECKS
if (is_admin()) {
	if (!function_exists('ayecode_show_update_plugin_requirement')) {//only load the update file if needed
		require_once('gd_update.php'); // require update script
	}
}

/**
 * The absolut path for the plugin.
 *
 * @since 1.0.0
 */
define( 'GDAFFILIATE_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) );

/**
 * The relative path for the plugin.
 *
 * @since 1.0.0
 */
define( 'GDAFFILIATE_PLUGIN_URL',  plugins_url('',__FILE__) );

/**
 * Declare some global variables for later use.
 *
 * @since 1.0.0
 *
 * @global object $wpdb WordPress Database object.
 * @global string $plugin_prefix Geodirectory plugin table prefix.
 * @global array  $geodir_addon_list Array of all geodirectory addons.
 */
global $wpdb, $plugin_prefix, $geodir_addon_list;

/**
 * Plugin textdomain.
 *
 * @since 1.0.0
 */
if ( !defined( 'GDAFFILIATE_TEXTDOMAIN' ) ) {
    define( 'GDAFFILIATE_TEXTDOMAIN', 'gdaffiliate' );
}


if ( is_admin() ) {
	/**
	 * Include WordPress core file so we can use core functions to check for active plugins.
	 *
	 * @since 1.0.0
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	if ( !is_plugin_active( 'geodirectory/geodirectory.php' ) ) {
		return;
	}

	if ( !class_exists( 'Affiliate_WP' ) ) {
		// is this plugin active?
		if ( is_plugin_active( 'geodir_affiliate/geodir_affiliate.php' ) ) {

			// deactivate the plugin
			deactivate_plugins( 'geodir_affiliate/geodir_affiliate.php' );
			
			// display notice
			add_action( 'admin_notices', 'geodir_affiliate_admin_notices' );
		}

	}
}

$geodir_addon_list['geodir_affiliate'] = 'yes' ;

if ( !isset( $plugin_prefix ) ) {
	$plugin_prefix = $wpdb->prefix . 'geodir_';
}




// Load geodirectory plugin textdomain.
add_action( 'plugins_loaded', 'geodir_affiliate_load_textdomain' );

/**
 * Include all plugin functions.
 *
 * @since 1.0.0
 */
require_once( 'geodir_affiliate_functions.php' ); 

/**
 * Most actions/hooks are called from here.
 *
 * @since 1.0.0
 */ 
require_once( 'geodir_affiliate_hooks_actions.php' );

/**
 * Admin init + activation hooks
 **/
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	register_activation_hook( __FILE__ , 'geodir_affiliate_activation' );
	register_deactivation_hook( __FILE__ , 'geodir_affiliate_deactivation' );
}

add_action( 'activated_plugin','geodir_affiliate_plugin_activated' ) ;