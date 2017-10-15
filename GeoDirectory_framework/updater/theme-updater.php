<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'GD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new GD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://wpgeodirectory.com', // Site where EDD is hosted
		'item_name' => 'GeoDirectory Framework', // Name of theme
		'theme_slug' => 'GeoDirectory_framework', // Theme slug
		'version' => GDF_VERSION, // The current version of this theme
		'author' => 'GD Team', // The author of this theme
		'download_id' => '65896', // Optional, used for generating a license renewal link
		'renew_url' => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'Theme License', 'geodirectory_framework' ),
		'enter-key' => __( 'Enter your theme license key.', 'geodirectory_framework' ),
		'license-key' => __( 'License Key', 'geodirectory_framework' ),
		'license-action' => __( 'License Action', 'geodirectory_framework' ),
		'deactivate-license' => __( 'Deactivate License', 'geodirectory_framework' ),
		'activate-license' => __( 'Activate License', 'geodirectory_framework' ),
		'status-unknown' => __( 'License status is unknown.', 'geodirectory_framework' ),
		'renew' => __( 'Renew?', 'geodirectory_framework' ),
		'unlimited' => __( 'unlimited', 'geodirectory_framework' ),
		'license-key-is-active' => __( 'License key is active.', 'geodirectory_framework' ),
		'expires%s' => __( 'Expires %s.', 'geodirectory_framework' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'geodirectory_framework' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'geodirectory_framework' ),
		'license-key-expired' => __( 'License key has expired.', 'geodirectory_framework' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'geodirectory_framework' ),
		'license-is-inactive' => __( 'License is inactive.', 'geodirectory_framework' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'geodirectory_framework' ),
		'site-is-inactive' => __( 'Site is inactive.', 'geodirectory_framework' ),
		'license-status-unknown' => __( 'License status is unknown.', 'geodirectory_framework' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'geodirectory_framework' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'geodirectory_framework' )
	)

);