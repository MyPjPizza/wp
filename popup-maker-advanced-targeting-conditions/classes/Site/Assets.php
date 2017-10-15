<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_ATC_Site_Assets
 */
class PUM_ATC_Site_Assets {

	/**
	 * Initialization
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts_styles' ) );
	}

	/**
	 * Enqueue the site scripts.
	 */
	public static function scripts_styles() {
		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script( 'pum-atc', PUM_ATC::$URL . 'assets/js/site' . $suffix . '.js' . '?defer', array( 'popup-maker-site', 'mobile-detect' ), PUM_ATC::$VER, true );
	}

}