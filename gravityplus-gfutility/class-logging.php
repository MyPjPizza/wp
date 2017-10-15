<?php

/**
 * Class GFP_GF_Utility_Logging
 *
 * Taken from Gravity Forms + Stripe https://wordpress.org/plugins/gravity-forms-stripe
 *
 * @since 1.4.0
 * 
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_GF_Utility_Logging {

	/**
	 * @var string
	 */
	private static $slug = 'gravityformsutility';

	/**
	 * GFP_GF_Utility_Logging constructor.
	 */
	public function __construct() {

		add_filter( 'gform_logging_supported', array( $this, 'gform_logging_supported' ) );

	}

	//------------------------------------------------------
	//------------- LOGGING --------------------------
	//------------------------------------------------------

	/**
	 * Add this plugin to Gravity Forms Logging Add-On
	 *
	 * @since 1.4.0
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $plugins
	 *
	 * @return mixed
	 */
	public function gform_logging_supported( $plugins ) {

		$plugins[ self::$slug ] = 'Gravity Forms Utility';

		return $plugins;

	}

	/**
	 * Log an error message
	 *
	 * @since 1.4.0
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @uses GFLogging::include_logger()
	 * @uses GFLogging::log_message
	 *
	 * @param $message
	 *
	 * @return void
	 */
	public static function log_error( $message ) {

		if ( class_exists( 'GFLogging' ) ) {

			GFLogging::include_logger();

			GFLogging::log_message( self::$slug, $message, KLogger::ERROR );

		}

	}

	/**
	 * Log a debug message
	 *
	 * @since 1.4.0
	 * 
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @uses GFLogging::include_logger()
	 * @uses GFLogging::log_message
	 *
	 * @param $message
	 *
	 * @return void
	 */
	public static function log_debug( $message ) {

		if ( class_exists( 'GFLogging' ) ) {

			GFLogging::include_logger();

			GFLogging::log_message( self::$slug, $message, KLogger::DEBUG );

		}
	}

}

new GFP_GF_Utility_Logging();