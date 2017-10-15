<?php
/**
 * Plugin Name: Popup Maker - Secure Idle User Logout
 * Plugin URI: https://wppopupmaker.com/extensions/secure-idle-user-logout
 * Description: 
 * Author: Daniel Iser
 * Version: 1.0.2
 * Author URI: https://wppopupmaker.com
 * Text Domain: popup-maker-secure-idle-user-logout
 * 
 * @package		POPMAKE_SIUL
 * @category	Addon\Security
 * @author		Daniel Iser
 * @copyright	Copyright (c) 2014, Wizard Internet Solutions
 * @since		1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Popup_Maker_Secure_Idle_User_Logout' ) ) :

/**
 * Main Popup_Maker_Secure_Idle_User_Logout Class
 *
 * @since 1.0
 */
final class Popup_Maker_Secure_Idle_User_Logout {
	/** Singleton *************************************************************/

	/**
	 * @var Popup_Maker_Secure_Idle_User_Logout The one true Popup_Maker_Secure_Idle_User_Logout
	 * @since 1.0
	 */
	private static $instance;
	public  static $license;

	/**
	 * Main Popup_Maker_Secure_Idle_User_Logout Instance
	 *
	 * Insures that only one instance of Popup_Maker_Secure_Idle_User_Logout exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @uses Popup_Maker_Secure_Idle_User_Logout::setup_constants() Setup the constants needed
	 * @uses Popup_Maker_Secure_Idle_User_Logout::includes() Include the required files
	 * @uses Popup_Maker_Secure_Idle_User_Logout::load_textdomain() load the language files
	 * @see PopMake()
	 * @return The one true Popup_Maker_Secure_Idle_User_Logout
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Popup_Maker_Secure_Idle_User_Logout ) ) {
			self::$instance = new Popup_Maker_Secure_Idle_User_Logout;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
			
			if ( class_exists( 'PopMake_License' ) && is_admin() ) {
			  self::$license = new PopMake_License( __FILE__, POPMAKE_SIUL_NAME, POPMAKE_SIUL_VERSION, 'Daniel Iser' );
			}
		}
		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-secure-idle-user-logout' ), '3' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-secure-idle-user-logout' ), '3' );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_constants() {

		if ( !defined('POPMAKE_SIUL') ) {
			define('POPMAKE_SIUL', __FILE__);	
		}

		if ( !defined('POPMAKE_SIUL_NAME') ) {
			define('POPMAKE_SIUL_NAME', 'Secure Idle User Logout');	
		}

		if ( !defined('POPMAKE_SIUL_SLUG') ) {
			define('POPMAKE_SIUL_SLUG', trim(dirname(plugin_basename(__FILE__)), '/'));	
		}

		if ( !defined('POPMAKE_SIUL_DIR') ) {
			define('POPMAKE_SIUL_DIR', WP_PLUGIN_DIR . '/' . POPMAKE_SIUL_SLUG . '/');	
		}

		if ( !defined('POPMAKE_SIUL_URL') ) {
			define('POPMAKE_SIUL_URL', plugins_url() . '/' . POPMAKE_SIUL_SLUG);	
		}

		if ( !defined('POPMAKE_SIUL_NONCE') ) {
			define('POPMAKE_SIUL_NONCE', POPMAKE_SIUL_SLUG.'_nonce' );	
		}

		if ( !defined('POPMAKE_SIUL_VERSION') ) {
			define('POPMAKE_SIUL_VERSION', '1.0.2' );
		}

	}

	/**
	 * Include required files
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {

		require_once POPMAKE_SIUL_DIR . 'includes/defaults.php';
		require_once POPMAKE_SIUL_DIR . 'includes/load-popups.php';
		require_once POPMAKE_SIUL_DIR . 'includes/popup-functions.php';
		require_once POPMAKE_SIUL_DIR . 'includes/scripts.php';
		require_once POPMAKE_SIUL_DIR . 'includes/ajax-calls.php';
		require_once POPMAKE_SIUL_DIR . 'includes/shortcodes.php';

		if ( is_admin() ) {
			require_once POPMAKE_SIUL_DIR . 'includes/admin/admin-setup.php';
			require_once POPMAKE_SIUL_DIR . 'includes/admin/popups/metabox.php';
			require_once POPMAKE_SIUL_DIR . 'includes/admin/popups/metabox-secure-idle-user-logout-fields.php';
		}
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function load_textdomain() {
		// Set filter for plugin's languages directory
		$popmake_siul_lang_dir = dirname( plugin_basename( POPMAKE_SIUL ) ) . '/languages/';
		$popmake_siul_lang_dir = apply_filters( 'popmake_siul_languages_directory', $popmake_siul_lang_dir );
		
		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'popup-maker-secure-idle-user-logout' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'popup-maker-secure-idle-user-logout', $locale );
		
		// Setup paths to current locale file
		$mofile_local  = $popmake_siul_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/popup-maker/' . $mofile;
		
		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/popup-maker folder
			load_textdomain( 'popup-maker-secure-idle-user-logout', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/popup-maker/languages/ folder
			load_textdomain( 'popup-maker-secure-idle-user-logout', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'popup-maker-secure-idle-user-logout', false, $popmake_siul_lang_dir );
		}
	}
}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Popup_Maker_Secure_Idle_User_Logout
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $popmake_siul = PopMakeSecureIdleUserLogout(); ?>
 *
 * @since 1.0
 * @return object The one true Popup_Maker_Secure_Idle_User_Logout Instance
 */
function PopMakeSecureIdleUserLogout() {
	return Popup_Maker_Secure_Idle_User_Logout::instance();
}


function popmake_siul_initialize() {
	PopMakeSecureIdleUserLogout();
}
add_action('popmake_initialize', 'popmake_siul_initialize');