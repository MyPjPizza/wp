<?php
/**
 * Uninstall GeoDirectory Marker Cluster
 *
 * Uninstalling GeoDirectory Marker Cluster deletes the plugin options.
 *
 * @package GeoDirectory_Marker_Cluster
 * @since 1.2.7
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

if ( get_option( 'geodir_un_geodir_marker_cluster' ) ) {
    if (!defined('GDCLUSTER_VERSION')) {
        // Load plugin file.
        include_once('geodir_marker_cluster.php');
    }
    
    // Delete options.
    $options = geodir_map_marker_cluster( array() );
    if ( !empty( $options ) ) {
        foreach ( $options as $option) {
            if ( isset( $option['id'] ) && $option['id'] != '' ) {
                delete_option( $option['id'] );
            }
        }
    }
}