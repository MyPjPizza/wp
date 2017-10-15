<?php
/**
 * Uninstall GeoDirectory AffiliateWP Integration
 *
 * Uninstalling GeoDirectory AffiliateWP Integration deletes the plugin options.
 *
 * @package GeoDir_Affiliate
 * @since 1.0.6
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

if ( get_option( 'geodir_un_geodir_affiliate' ) ) {
    /*
    if ( !defined( 'GDAFFILIATE_VERSION' ) ) {
        // Load plugin file.
        include_once('geodir_affiliate.php' );
    }
    */
}