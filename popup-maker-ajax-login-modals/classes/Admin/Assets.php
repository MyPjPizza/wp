<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class class PUM_ALM_Admin_Assets {

 */
class PUM_ALM_Admin_Assets {

	/**
	 * Initialization
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'scripts_styles' ) );
	}

	/**
	 * Enqueue the site scripts.
	 */
	public static function scripts_styles() {
		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( popmake_is_admin_page() ) {
			wp_enqueue_script( 'pum-alm-admin', PUM_ALM::$URL . 'assets/js/admin' . $suffix . '.js', array( 'popup-maker-admin' ), PUM_ALM::$VER, true );
		}
	}

}