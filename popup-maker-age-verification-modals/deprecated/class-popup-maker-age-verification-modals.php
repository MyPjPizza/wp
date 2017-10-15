<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Popup_Maker_Age_Verification_Modals' ) ) :

	/**
	 * Main Popup_Maker_Age_Verification_Modals Class
	 *
	 * @since 1.0
	 */
	final class Popup_Maker_Age_Verification_Modals {

		/** Singleton *************************************************************/

		/**
		 * @var Popup_Maker_Age_Verification_Modals The one true Popup_Maker_Age_Verification_Modals
		 * @since 1.0
		 */
		private static $instance;

		public static $license;

		/**
		 * Main Popup_Maker_Age_Verification_Modals Instance
		 *
		 * Insures that only one instance of Popup_Maker_Age_Verification_Modals exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0
		 * @static
		 * @staticvar array $instance
		 * @uses Popup_Maker_Age_Verification_Modals::setup_constants() Setup the constants needed
		 * @uses Popup_Maker_Age_Verification_Modals::includes() Include the required files
		 * @uses Popup_Maker_Age_Verification_Modals::load_textdomain() load the language files
		 * @see  PopMake()
		 * @return The one true Popup_Maker_Age_Verification_Modals
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Popup_Maker_Age_Verification_Modals ) ) {
				self::$instance = new Popup_Maker_Age_Verification_Modals;
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();

				if ( class_exists( 'PopMake_License' ) && is_admin() ) {
					self::$license = new PopMake_License( __FILE__, POPMAKE_AVM_NAME, POPMAKE_AVM_VERSION, 'WP Popup Maker' );
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
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-age-verification-modals' ), '3' );
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
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'popup-maker-age-verification-modals' ), '3' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private function setup_constants() {

			if ( ! defined( 'POPMAKE_AVM' ) ) {
				define( 'POPMAKE_AVM', __FILE__ );
			}

			if ( ! defined( 'POPMAKE_AVM_NAME' ) ) {
				define( 'POPMAKE_AVM_NAME', 'Age Verification Modals' );
			}

			if ( ! defined( 'POPMAKE_AVM_SLUG' ) ) {
				define( 'POPMAKE_AVM_SLUG', PUM_AVM::$DOMAIN );
			}

			if ( ! defined( 'POPMAKE_AVM_DIR' ) ) {
				define( 'POPMAKE_AVM_DIR', PUM_AVM::$DIR . 'deprecated/' );
			}

			if ( ! defined( 'POPMAKE_AVM_URL' ) ) {
				define( 'POPMAKE_AVM_URL', PUM_AVM::$URL . 'deprecated/' );
			}

			if ( ! defined( 'POPMAKE_AVM_NONCE' ) ) {
				define( 'POPMAKE_AVM_NONCE', POPMAKE_AVM_SLUG . '_nonce' );
			}

			if ( ! defined( 'POPMAKE_AVM_VERSION' ) ) {
				define( 'POPMAKE_AVM_VERSION', PUM_AVM::$VER );
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

			require_once POPMAKE_AVM_DIR . 'includes/defaults.php';
			require_once POPMAKE_AVM_DIR . 'includes/input-options.php';
			require_once POPMAKE_AVM_DIR . 'includes/load-popups.php';
			require_once POPMAKE_AVM_DIR . 'includes/popup-functions.php';
			require_once POPMAKE_AVM_DIR . 'includes/scripts.php';
			require_once POPMAKE_AVM_DIR . 'includes/shortcodes.php';

			if ( is_admin() ) {
				require_once POPMAKE_AVM_DIR . 'includes/admin/admin-setup.php';
				require_once POPMAKE_AVM_DIR . 'includes/admin/popups/metabox.php';
				require_once POPMAKE_AVM_DIR . 'includes/admin/popups/metabox-age-verification-modals-fields.php';
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
			$popmake_av_lang_dir = dirname( plugin_basename( POPMAKE_AVM ) ) . '/languages/';
			$popmake_av_lang_dir = apply_filters( 'popmake_av_languages_directory', $popmake_av_lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'popup-maker-age-verification-modals' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'popup-maker-age-verification-modals', $locale );

			// Setup paths to current locale file
			$mofile_local  = $popmake_av_lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/popup-maker/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/popup-maker folder
				load_textdomain( 'popup-maker-age-verification-modals', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/popup-maker/languages/ folder
				load_textdomain( 'popup-maker-age-verification-modals', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'popup-maker-age-verification-modals', false, $popmake_av_lang_dir );
			}
		}
	}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Popup_Maker_Age_Verification_Modals
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $popmake_av = PopMakeAgeVerificationModals(); ?>
 *
 * @since 1.0
 * @return object The one true Popup_Maker_Age_Verification_Modals Instance
 */
function PopMakeAgeVerificationModals() {
	return Popup_Maker_Age_Verification_Modals::instance();
}


function popmake_av_initialize() {
	PopMakeAgeVerificationModals();
}

add_action( 'popmake_initialize', 'popmake_av_initialize' );