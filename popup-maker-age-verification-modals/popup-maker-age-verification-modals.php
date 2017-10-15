<?php
/**
 * Plugin Name: Popup Maker - Age Verification Modals
 * Plugin URI: https://wppopupmaker.com/extensions/age-verification-modals/
 * Description: Add multipe types of age verification forms to your popups.
 * Author: WP Popup Maker
 * Version: 1.2.2
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-age-verification-modals
 *
 * @package      PUM\Security
 * @author       WP Popup Maker
 * @copyright    Copyright (c) 2016, WP Popup Maker
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_AVM
 *
 * @since 1.2
 */
class PUM_AVM {

	/**
	 * @var string Plugin Version
	 */
	public static $VER = '1.2.2';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 2;

	/**
	 * @var string Text Domain
	 */
	public static $DOMAIN = 'popup-maker-age-verification-modals';

	/**
	 * @var string Plugin Directory
	 */
	public static $DIR;

	/**
	 * @var string Plugin URL
	 */
	public static $URL;

	/**
	 * @var string Plugin FILE
	 */
	public static $FILE;

	/**
	 * Set up plugin variables.
	 */
	public static function setup_vars() {
		static::$FILE = __FILE__;
		static::$DIR  = plugin_dir_path( __FILE__ );
		static::$URL  = plugin_dir_url( __FILE__ );
	}

	/**
	 * Initialize the plugin.
	 */
	public static function init() {

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'scripts' ) );

		add_filter( 'pum_get_cookies', array( __CLASS__, 'cookies' ) );
		add_filter( 'pum_get_triggers', array( __CLASS__, 'triggers' ) );
		add_filter( 'pum_get_trigger_labels', array( __CLASS__, 'trigger_labels' ) );

		add_filter( 'popmake_template_paths', array( __CLASS__, 'template_path' ) );

		add_action( 'pum_avm_field_notice', array( __CLASS__, 'field_notice' ) );

		add_filter( 'pum_popup_show_close_button', array( __CLASS__, 'show_close_button' ), 10, 2 );

		require_once static::$DIR . 'includes/shortcodes/class-pum-shortcode-age-form.php';

		static::maybe_update();

		// Handle licensing
		if ( class_exists( 'PopMake_License' ) ) {
			new PopMake_License( __FILE__, 'Age Verification Modals', static::$VER, 'WP Popup Maker' );
		}
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

	/**
	 * @param array $args
	 */
	public static function field_notice( $args = array() ) {
		echo '<p class="desc">' . $args['desc'] . '</p>';
	}

	/**
	 * @param $show
	 * @param $popup_id
	 *
	 * @return bool
	 */
	public static function show_close_button( $show, $popup_id ) {
		$has_age_verification = false;
		foreach ( pum_get_popup_triggers( $popup_id ) as $trigger ) {
			if ( $trigger['type'] == 'age_verification' ) {
				$has_age_verification = true;
			}
		}

		if ( $has_age_verification ) {
			return false;
		}

		return $show;
	}

	/**
	 * Registers the exit intent trigger.
	 *
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function cookies( $triggers = array() ) {
		return array_merge( $triggers, array(
			'age_verified'             => array(
				'labels' => array(
					'name' => __( 'Age Verified', 'popup-maker' ),
				),
				'fields' => pum_get_cookie_fields(),
			),
			'age_verification_failed'  => array(
				'labels' => array(
					'name' => __( 'Age Verification Failed', 'popup-maker' ),
				),
				'fields' => pum_get_cookie_fields(),
			),
			'age_verification_lockout' => array(
				'labels' => array(
					'name' => __( 'Age Verification Lockout', 'popup-maker' ),
				),
				'fields' => pum_get_cookie_fields(),
			),
		) );
	}

	/**
	 * Registers the exit intent trigger.
	 *
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function triggers( $triggers = array() ) {
		return array_merge( $triggers, array(
			'age_verification'    => array(
				'fields' => array(
					'general' => array(
						'user_notice' => array(
							'type' => 'hook',
							'hook' => 'pum_avm_field_notice',
							'desc' => sprintf( __( 'Use the Popup Maker shortcode button %s on the editor toolbar to insert and customize your age verification form.', 'popup-maker-age-verification-modals' ), '<img src="' . POPMAKE_URL . '/assets/images/admin/popup-maker-icon.png" width="20" />' ),
						),
					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			),
			'failed_age_redirect' => array(
				'fields' => array(
					'general' => array(
						'redirect_url' => array(
							'label'       => __( 'Redirect URL', 'popup-maker-age-verification-modals' ),
							'desc'        => __( 'Users that fail verification will be redirected to this url on return visits until the cookie expires.', 'popup-maker-age-verification-modals' ),
							'placeholder' => __( 'disney.com, example.com/too-young', 'popup-maker-age-verification-modals' ),
							'std'         => __( 'http://www.disney.com', 'popup-maker-age-verification-modals' ),
						),
					),
					'cookie'  => array(
						'name' => array(
							'label'    => __( 'Cookies', 'popup-maker' ),
							'desc'     => __( 'Which cookies will cause the user to be redirected?', 'popup-maker' ),
							'type'     => 'select',
							'multiple' => true,
							'select2'  => true,
							'required' => true,
							'priority' => 1,
							'options'  => array(
								__( 'Add New Cookie', 'popup-maker' ) => 'add_new',
							),
						),
					),
				),
			),
		) );
	}

	/**
	 * Registers the exit intent trigger labels.
	 *
	 * @param array $labels
	 *
	 * @return array
	 */
	public static function trigger_labels( $labels = array() ) {
		return array_merge( $labels, array(
			'age_verification'    => array(
				'name'            => __( 'Age Verification', 'popup-maker-age-verification-modals' ),
				'modal_title'     => __( 'Age Verification Settings', 'popup-maker-age-verification-modals' ),
				'settings_column' => '',
			),
			'failed_age_redirect' => array(
				'name'            => __( 'Failed Age Redirect', 'popup-maker-age-verification-modals' ),
				'modal_title'     => __( 'Failed Age Redirect Settings', 'popup-maker-age-verification-modals' ),
				'settings_column' => sprintf( '<strong>%1$s</strong>: %2$s', __( 'URL', 'popup-maker-age-verification-modals' ), '{{data.redirect_url}}' ),
			),
		) );
	}

	/**
	 * Load the textdomain for gettext translation.
	 */
	public static function textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), static::$DOMAIN );
		// wp-content/languages/plugin-name/plugin-name-de_DE.mo
		load_textdomain( static::$DOMAIN, trailingslashit( WP_LANG_DIR ) . static::$DOMAIN . '/' . static::$DOMAIN . '-' . $locale . '.mo' );
		// wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
		load_plugin_textdomain( static::$DOMAIN, false, static::$DIR . 'languages/' );
	}

	/**
	 *
	 */
	public static function maybe_update() {

		$current_ver = get_option( 'pum_avm_ver', false );

		if ( ! $current_ver ) {
			$deprecated_ver = get_site_option( 'popmake_avm_version', false );
			$current_ver    = $deprecated_ver ? $deprecated_ver : PUM_AVM::$VER;
			add_option( 'pum_avm_ver', PUM_AVM::$VER );
		}

		if ( version_compare( $current_ver, PUM_AVM::$VER, '<' ) ) {
			// Save Upgraded From option
			update_option( 'pum_avm_ver_upgraded_from', $current_ver );
			update_option( 'pum_avm_ver', PUM_AVM::$VER );
		}

		$current_db_version = get_option( 'pum_avm_db_ver', false );

		if ( ! $current_db_version ) {
			$updated_from = get_option( 'pum_avm_ver_upgraded_from', false );

			// Since no versions prior to 1.2 had a ver stored we default to 1.
			if ( ! $updated_from ) {
				$current_db_version = 1;
			} else {
				if ( version_compare( '1.2', $updated_from, '>=' ) ) {
					$current_db_version = 2;
				} else {
					$current_db_version = 1;
				}
			}

			update_option( 'pum_avm_db_ver', $current_db_version );

		}

		if ( $current_db_version < PUM_AVM::$DB_VER ) {
			if ( $current_db_version < 2 ) {
				include_once PUM_AVM::$DIR . 'includes/upgrades/class-pum-avm-upgrade-routine-2.php';
				PUM_AVM_Upgrade_Routine_2::run();
				$current_db_version = 2;
			}

			update_option( 'pum_avm_db_ver', $current_db_version );
		}

	}

	/**
	 * Enqueue the needed scripts.
	 */
	public static function scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( ! is_admin() ) {
			wp_enqueue_style( 'pum-avm-site', static::$URL . 'assets/css/site' . $suffix . '.css', array( 'popup-maker-site' ), static::$VER );
			wp_enqueue_script( 'pum-avm-site', static::$URL . 'assets/js/site' . $suffix . '.js?defer', array( 'popup-maker-site' ), static::$VER, true );
			wp_localize_script( 'pum-avm-site', 'pum_avm', apply_filters( 'pum_avm_js_var', array(
				'I10n' => array(
					'trigger_labels' => array(
						'enter'     => __( 'Enter Clicked', 'popup-maker-age-verification-modals' ),
						'exit'      => __( 'Exit Clicked', 'popup-maker-age-verification-modals' ),
						'birthdate' => __( 'Age Entered', 'popup-maker-age-verification-modals' ),
					),
					'errors'         => array(
						'too_young'    => __( 'Sorry but you do not appear to be old enough.', 'popup-maker-age-verification-modals' ),
						'locked_out'   => __( 'Sorry but you have been locked out Please come back when you are old enough.', 'popup-maker-age-verification-modals' ),
						'invalid_date' => __( 'Please enter a valid date.', 'popup-maker-age-verification-modals' ),
					),
				),
			) ) );
		} else {
			wp_enqueue_script( 'pum-avm-admin', static::$URL . 'assets/js/admin' . $suffix . '.js', array( 'popup-maker-admin' ), static::$VER, true );
		}
	}

}


/**
 * Get the ball rolling. Fire up the correct version.
 *
 * @since       1.2
 */
function pum_avm_init() {
	if ( ! class_exists( 'Popup_Maker' ) && ! class_exists( 'PUM' ) ) {
		if ( ! class_exists( 'PUM_Extension_Activation' ) ) {
			require_once 'includes/pum-sdk/class-pum-extension-activation.php';
		}

		$activation = new PUM_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation->run();
	} else {

		// Set up variables for use in all versions.
		PUM_AVM::setup_vars();

		// Versioned Bootstrap. If v1.4+ use new, otherwise use deprecated.
		if ( function_exists( 'pum_is_v1_4_compatible' ) && pum_is_v1_4_compatible() ) {
			PUM_AVM::init();
		} else {
			// Here for backward compatibility with older versions of Popup Maker.
			require_once 'deprecated/class-popup-maker-age-verification-modals.php';
			Popup_Maker_Age_Verification_Modals::instance();
		}

	}
}

add_action( 'plugins_loaded', 'pum_avm_init' );
