<?php
/**
 * Plugin Name: Popup Maker - AJAX Login Modals
 * Plugin URI: https://wppopupmaker.com/extensions/ajax-login-modals/
 * Description: Adds ajax login & registration form capabilities to Popup Maker.
 * Author: WP Popup Maker
 * Version: 1.2.0
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-ajax-login-modals
 * GitLab Plugin URI: https://gitlab.com/PopupMaker/AJAX-Login-Modals
 * GitHub Branch:     master
 *
 * @author       WP Popup Maker
 * @copyright    Copyright (c) 2016, WP Popup Maker
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Autoloader
 *
 * @param $class
 */
function pum_alm_autoloader( $class ) {

	// project-specific namespace prefix
	$prefix = 'PUM_ALM_';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/classes/';

	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr( $class, $len );

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace( '_', '/', $relative_class ) . '.php';

	// if the file exists, require it
	if ( file_exists( $file ) ) {
		require_once $file;
	}

}

if ( ! function_exists( 'spl_autoload_register' ) ) {
	include 'includes/compat.php';
}

spl_autoload_register( 'pum_alm_autoloader' ); // Register autoloader

/**
 * Class PUM_ALM
 */
class PUM_ALM {

	/**
	 * @var string
	 */
	public static $NAME = 'AJAX Login Modals';

	/**
	 * @var string
	 */
	public static $VER = '1.2.0';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 3;

	/**
	 * @var string
	 */
	public static $URL = '';

	/**
	 * @var string
	 */
	public static $DIR = '';

	/**
	 * @var string
	 */
	public static $FILE = '';

	/**
	 * @var         PUM_ALM $instance The one true PUM_ALM
	 * @since       1.2.0
	 */
	private static $instance;

	/**
	 * Get active instance
	 *
	 * @access      public
	 * @since       1.2.0
	 * @return      object self::$instance The one true PUM_ALM
	 */
	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
			self::$instance->setup_constants();

			self::$instance->load_textdomain();

			self::$instance->includes();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access      private
	 * @since       1.2.0
	 * @return      void
	 */
	private function setup_constants() {
		self::$DIR  = self::$instance->plugin_path();
		self::$URL  = self::$instance->plugin_url();
		self::$FILE = __FILE__;
		self::$NAME = __( 'AJAX Login Modals', 'popup-maker-ajax-login-modals' );
	}

	/**
	 * Include necessary files
	 *
	 * @access      private
	 * @since       1.2.0
	 * @return      void
	 */
	private function includes() {
		require_once self::$DIR . 'includes/template-functions.php';
	}

	/**
	 * Initialize everything
	 *
	 * @access      private
	 * @since       1.2.0
	 * @return      void
	 */
	private function init() {

		PUM_ALM_Site::init();
		PUM_ALM_Triggers::init();
		PUM_ALM_Cookies::init();
		PUM_ALM_Shortcodes::init();
		PUM_ALM_Admin::init();
		PUM_ALM_Popup::init();
		PUM_ALM_Ajax::init();
		PUM_ALM_Validation::init();
		PUM_ALM_Forms::init();
		PUM_ALM_Migration::init();
		// Integrations
		PUM_ALM_Integration_ProfileBuilder::init();

		add_filter( 'popmake_template_paths', array( __CLASS__, 'template_path' ) );

		// Handle licensing
		if ( class_exists( 'PopMake_License' ) ) {
			new PopMake_License( __FILE__, 'AJAX Login Modals', self::$VER, 'WP Popup Maker' );
		}
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url() {
		return plugins_url( '/', __FILE__ );
	}

	/**
	 * Internationalization
	 *
	 * @access      public
	 * @since       1.2.0
	 * @return      void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'popup-maker-ajax-login-modals', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Get Ajax URL.
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * @param $file_paths
	 *
	 * @return mixed
	 */
	public static function template_path( $file_paths ) {
		$key                = max( array_keys( $file_paths ) ) + 1;
		$file_paths[ $key ] = self::$DIR . 'templates';

		return $file_paths;
	}

}

/**
 * Get the ball rolling. Fire up the correct version.
 */
function pum_alm_init() {
	if ( ! class_exists( 'Popup_Maker' ) && ! class_exists( 'PUM' ) ) {
		if ( ! class_exists( 'PUM_Extension_Activation' ) ) {
			require_once 'includes/pum-sdk/class-pum-extension-activation.php';
		}

		$activation = new PUM_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation->run();
	} else {
		PUM_ALM::instance();
	}
}
add_action( 'plugins_loaded', 'pum_alm_init' );
