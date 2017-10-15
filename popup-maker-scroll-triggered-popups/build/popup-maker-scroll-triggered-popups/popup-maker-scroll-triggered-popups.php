<?php
/**
 * Plugin Name: Popup Maker - Scroll Triggered Popups
 * Plugin URI: https://wppopupmaker.com/extensions/scroll-triggered-popups/
 * Description:
 * Version: 1.2
 * Author: WP Popup Maker
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-scroll-triggered-popups
 *
 * @package     PUM\Triggers\Scroll
 * @author      WP Popup Maker
 * @copyright   Copyright (c) 2016, WP Popup Maker
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_STP
 */
class PUM_STP {

	/**
	 * @var string Plugin Version
	 */
	public static $VER = '1.2';

	/**
	 * @var int DB Version
	 */
	public static $DB_VER = 3;

	/**
	 * @var string Text Domain
	 */
	public static $DOMAIN = 'popup-maker-scroll-triggered-popups';

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
		add_action( 'init', array( __CLASS__, 'textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_filter( 'pum_get_triggers', array( __CLASS__, 'triggers' ) );
		add_filter( 'pum_get_trigger_labels', array( __CLASS__, 'trigger_labels' ) );
		
		require_once static::$DIR . 'includes/shortcodes/class-pum-shortcode-scroll-trigger.php';

		//static::maybe_update();

		// Handle licensing
		if ( class_exists( 'PopMake_License' ) ) {
			new PopMake_License( __FILE__, 'Scroll Triggered Popups', static::$VER, 'WP Popup Maker' );
		}
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

	public static function maybe_update() {

		$current_ver = get_option( 'pum_stp_ver', false );

		if ( ! $current_ver ) {
			$deprecated_ver = get_site_option( 'popmake_stp_version', false );
			$current_ver    = $deprecated_ver ? $deprecated_ver : PUM_STP::$VER;
			add_option( 'pum_stp_ver', PUM_STP::$VER );
		}

		if ( version_compare( $current_ver, PUM_STP::$VER, '<' ) ) {
			// Save Upgraded From option
			update_option( 'pum_stp_ver_upgraded_from', $current_ver );
			update_option( 'pum_stp_ver', PUM_STP::$VER );
		}

		$current_db_version = get_option( 'pum_stp_db_ver', false );

		if ( ! $current_db_version ) {
			$updated_from = get_option( 'pum_stp_ver_upgraded_from', false );

			// If no updated install then this is fresh, no need to do anything.
			if ( ! $updated_from ) {
				$current_db_version = 3;
			} else {
				if ( version_compare( '1.1.2', $updated_from, '>=' ) ) {
					$current_db_version = 2;
				} else {
					$current_db_version = 3;
				}
			}

			update_option( 'pum_stp_db_ver', $current_db_version );

		}

		if ( $current_db_version < PUM_STP::$DB_VER ) {
			if ( $current_db_version <= 2 ) {
				include_once PUM_STP::$DIR . 'includes/upgrades/class-pum-stp-upgrade-routine-2.php';
				PUM_STP_Upgrade_Routine_2::run();
				$current_db_version = 3;
			}

			update_option( 'pum_stp_db_ver', $current_db_version );
		}


	}

	/**
	 * Enqueue the needed scripts.
	 */
	public static function scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( ! is_admin() ) {
			wp_enqueue_script( 'pum-stp', static::$URL . 'assets/js/site' . $suffix . '.js?defer', array( 'popup-maker-site' ), static::$VER, true );
		} elseif ( popmake_is_admin_page() ) {
			wp_enqueue_script( 'pum-stp-admin', static::$URL . 'assets/js/admin' . $suffix . '.js', array( 'popup-maker-admin' ), static::$VER, true );
		}
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
			'scroll'        => array(
				'fields' => array(
					'general' => array(
						'trigger'         => array(
							'label'   => __( 'Trigger Type', 'popup-maker-scroll-triggered-popups' ),
							'desc'    => __( 'Choose the type of trigger to be used for opening this popup.', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => array(
								__( 'Distance', 'popup-maker-scroll-triggered-popups' ) => 'distance',
								__( 'Element', 'popup-maker-scroll-triggered-popups' )  => 'element',
								__( 'Manual', 'popup-maker-scroll-triggered-popups' )   => 'manual'
							),
							'std'     => 'distance'
						),
						'distance'        => array(
							'class' => 'distance-only',
							'label' => __( 'Distance', 'popup-maker-scroll-triggered-popups' ),
							'desc'  => __( 'Choose how far users scroll before popup opens.', 'popup-maker-scroll-triggered-popups' ),
							'type'  => 'rangeslider',
							'std'   => 75,
							'step'  => 1,
							'min'   => 0,
							'max'   => 100,
							'unit'  => __( '%', 'popup-maker' ),
						),
						'unit'            => array(
							'class'   => 'distance-only',
							'label'   => __( 'Distance Unit', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => apply_filters( 'popmake_size_unit_options', array() ),
							'std'     => '%'
						),
						'trigger_element' => array(
							'class' => 'element-only',
							'label' => __( 'Trigger Element', 'popup-maker-scroll-triggered-popups' ),
							'desc'  => __( 'CSS / jQuery Selector that will trigger the popup once the user scrolls it on screen.', 'popup-maker-scroll-triggered-popups' ),
						),
						'trigger_point'   => array(
							'label'   => __( 'Trigger Point', 'popup-maker-scroll-triggered-popups' ),
							'desc'    => __( 'This changes the default trigger detection point.', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => array(
								__( 'Auto', 'popup-maker-scroll-triggered-popups' )     => '',
								__( 'Top', 'popup-maker-scroll-triggered-popups' )      => 'top',
								__( 'Bottom', 'popup-maker-scroll-triggered-popups' )   => 'bottom',
								__( 'Floating', 'popup-maker-scroll-triggered-popups' ) => 'floating'
							),
						),
						'close_on_up'     => array(
							'label' => __( 'Close When Scrolled Back Up', 'popup-maker-scroll-triggered-popups' ),
							'desc'  => __( 'Checking this will cause popup to scroll when user scrolls back up.', 'popup-maker-scroll-triggered-popups' ),
							'type'  => 'checkbox',
						),
					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			),
			/*
			'scroll_return' => array(
				'fields' => array(
					'activation' => array(
						'trigger'         => array(
							'label'   => __( 'Trigger Type', 'popup-maker-scroll-triggered-popups' ),
							'desc'    => __( 'Choose the type of trigger to be used for opening this popup.', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => array(
								__( 'Distance', 'popup-maker-scroll-triggered-popups' ) => 'distance',
								__( 'Element', 'popup-maker-scroll-triggered-popups' )  => 'element',
								__( 'Manual', 'popup-maker-scroll-triggered-popups' )   => 'manual'
							),
							'std'     => 'distance'
						),
						'distance'        => array(
							'class' => 'distance-only',
							'label' => __( 'Distance', 'popup-maker-scroll-triggered-popups' ),
							'desc'  => __( 'Choose how far users scroll before popup opens.', 'popup-maker-scroll-triggered-popups' ),
							'type'  => 'rangeslider',
							'std'   => 75,
							'step'  => 1,
							'min'   => 0,
							'max'   => 100,
							'unit'  => __( '%', 'popup-maker' ),
						),
						'unit'            => array(
							'class'   => 'distance-only',
							'label'   => __( 'Distance Unit', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => apply_filters( 'popmake_size_unit_options', array() ),
							'std'     => '%'
						),
						'trigger_element' => array(
							'class' => 'element-only',
							'label' => __( 'Trigger Element', 'popup-maker-scroll-triggered-popups' ),
							'desc'  => __( 'CSS / jQuery Selector that will trigger the popup once the user scrolls it on screen.', 'popup-maker-scroll-triggered-popups' ),
						),
						'trigger_point'   => array(
							'label'   => __( 'Trigger Point', 'popup-maker-scroll-triggered-popups' ),
							'desc'    => __( 'This changes the default trigger detection point.', 'popup-maker-scroll-triggered-popups' ),
							'type'    => 'select',
							'options' => array(
								__( 'Auto', 'popup-maker-scroll-triggered-popups' )     => '',
								__( 'Top', 'popup-maker-scroll-triggered-popups' )      => 'top',
								__( 'Bottom', 'popup-maker-scroll-triggered-popups' )   => 'bottom',
								__( 'Floating', 'popup-maker-scroll-triggered-popups' ) => 'floating'
							),
						),


					),
					'cookie'     => pum_trigger_cookie_fields(),
				),

			),
				*/
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
			'scroll' => array(
				'name'            => __( 'Scroll', 'popup-maker-scroll-triggered-popups' ),
				'modal_title'     => __( 'Scroll Trigger Settings', 'popup-maker-scroll-triggered-popups' ),
				'settings_column' => sprintf(
					'<strong>%1$s</strong>: %2$s',
					__( 'Trigger', 'popup-maker-scroll-triggered-popups' ),
					'{{data.trigger}}'
				),
			),
			/*
			'scroll_return' => array(
				'name'            => __( 'Scroll Return', 'popup-maker-scroll-triggered-popups' ),
				'modal_title'     => __( 'Scroll Return Trigger Settings', 'popup-maker-scroll-triggered-popups' ),
				'settings_column' => sprintf(
					'<strong>%1$s</strong>: %2$s',
					__( 'Message', 'popup-maker-scroll-triggered-popups' ),
					'{{data.message}}'
				),
			),
			*/
		) );
	}

}


/**
 * Get the ball rolling. Fire up the correct version.
 *
 * @since       1.2
 */
function pum_stp_init() {
	if ( ! class_exists( 'Popup_Maker' ) && ! class_exists( 'PUM' ) ) {
		if ( ! class_exists( 'PUM_Extension_Activation' ) ) {
			require_once 'includes/pum-sdk/class-pum-extension-activation.php';
		}

		$activation = new PUM_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation->run();
	} else {

		// Set up variables for use in all versions.
		PUM_STP::setup_vars();

		if ( function_exists( 'pum_is_v1_4_compatible' ) && pum_is_v1_4_compatible() ) {
			PUM_STP::init();
		} else {
			// Here for backward compatibility with older versions of Popup Maker.
			require_once 'deprecated/class-popmake-scroll-triggered-popups.php';
			PopMake_Scroll_Triggered_Popups::instance();
		}

	}
}

add_action( 'plugins_loaded', 'pum_stp_init' );

