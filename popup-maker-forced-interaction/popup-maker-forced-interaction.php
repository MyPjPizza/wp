<?php
/**
 * Plugin Name: Popup Maker - Forced Interaction
 * Plugin URI: https://wppopupmaker.com/extensions/forced-interaction/
 * Description: 
 * Author: WP Popup Maker
 * Version: 1.0.2
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-forced-interaction
 * 
 * @package		POPMAKE_FI
 * @category	Addon\User Engagement
 * @author		WP Popup Maker
 * @copyright	Copyright (c) 2016, WP Popup Maker
 * @since		1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Popup_Maker_Forced_Interaction' ) ) :

/**
 * Main Popup_Maker_Forced_Interaction Class
 *
 * @since 1.0
 */
final class Popup_Maker_Forced_Interaction {
	/** Singleton *************************************************************/

	/**
	 * @var Popup_Maker_Forced_Interaction The one true Popup_Maker_Forced_Interaction
	 * @since 1.0
	 */
	private static $instance;
	public  static $license;

	/**
	 * Main Popup_Maker_Forced_Interaction Instance
	 *
	 * Insures that only one instance of Popup_Maker_Forced_Interaction exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0
	 * @static
	 * @staticvar array $instance
	 * @uses Popup_Maker_Forced_Interaction::setup_constants() Setup the constants needed
	 * @uses Popup_Maker_Forced_Interaction::includes() Include the required files
	 * @uses Popup_Maker_Forced_Interaction::load_textdomain() load the language files
	 * @see PopMake()
	 * @return The one true Popup_Maker_Forced_Interaction
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Popup_Maker_Forced_Interaction ) ) {
			self::$instance = new Popup_Maker_Forced_Interaction;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->load_textdomain();
			
			if ( class_exists( 'PopMake_License' ) && is_admin() ) {
			  self::$license = new PopMake_License( __FILE__, POPMAKE_FI_NAME, POPMAKE_FI_VERSION, 'Daniel Iser' );
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
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-forced-interaction' ), '3' );
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
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-forced-interaction' ), '3' );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function setup_constants() {

		if ( !defined('POPMAKE_FI') ) {
			define('POPMAKE_FI', __FILE__);	
		}

		if ( !defined('POPMAKE_FI_NAME') ) {
			define('POPMAKE_FI_NAME', 'Forced Interaction');	
		}

		if ( !defined('POPMAKE_FI_SLUG') ) {
			define('POPMAKE_FI_SLUG', trim(dirname(plugin_basename(__FILE__)), '/'));	
		}

		if ( !defined('POPMAKE_FI_DIR') ) {
			define('POPMAKE_FI_DIR', WP_PLUGIN_DIR . '/' . POPMAKE_FI_SLUG . '/');	
		}

		if ( !defined('POPMAKE_FI_URL') ) {
			define('POPMAKE_FI_URL', plugins_url() . '/' . POPMAKE_FI_SLUG);	
		}

		if ( !defined('POPMAKE_FI_NONCE') ) {
			define('POPMAKE_FI_NONCE', POPMAKE_FI_SLUG.'_nonce' );	
		}

		if ( !defined('POPMAKE_FI_VERSION') ) {
			define('POPMAKE_FI_VERSION', '1.0.2' );
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

		require_once POPMAKE_FI_DIR . 'includes/scripts.php';
		if ( is_admin() ) {
			require_once POPMAKE_FI_DIR . 'includes/admin/admin-setup.php';
			require_once POPMAKE_FI_DIR . 'includes/admin/popups/metabox.php';
			require_once POPMAKE_FI_DIR . 'includes/admin/popups/metabox-forced-interaction-fields.php';
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
		$popmake_fi_lang_dir = dirname( plugin_basename( POPMAKE_FI ) ) . '/languages/';
		$popmake_fi_lang_dir = apply_filters( 'popmake_fi_languages_directory', $popmake_fi_lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'popup-maker-forced-interaction' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'popup-maker-forced-interaction', $locale );

		// Setup paths to current locale file
		$mofile_local  = $popmake_fi_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/popup-maker/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/popup-maker folder
			load_textdomain( 'popup-maker-forced-interaction', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/popup-maker/languages/ folder
			load_textdomain( 'popup-maker-forced-interaction', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'popup-maker-forced-interaction', false, $popmake_fi_lang_dir );
		}
	}
}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Popup_Maker_Forced_Interaction
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $popmake_fi = PopMakeForceUserAction(); ?>
 *
 * @since 1.0
 * @return object The one true Popup_Maker_Forced_Interaction Instance
 */

function PopMakeForceUserAction() {
	return Popup_Maker_Forced_Interaction::instance();
}


function popmake_fi_initialize() {
	PopMakeForceUserAction();
}
add_action('popmake_initialize', 'popmake_fi_initialize');