<?php
/**
 * Hook and filter actions used by the plugin.
 *
 * @since 1.0.0
 * @package GeoDir_Affiliate
 */
 
add_filter( 'affwp_integrations', 'geodir_affiliate_affwp_integration' );

/*
if ( is_admin() ) {
    add_filter( 'geodir_plugins_uninstall_settings', 'geodir_affiliate_uninstall_settings', 10, 1 );
}
*/