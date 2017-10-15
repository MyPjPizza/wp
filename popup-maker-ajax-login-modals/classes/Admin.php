<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PUM_ALM Site class
 *
 * @since       1.2.0
 */
class PUM_ALM_Admin {

	/**
	 * Initialize Hooks & Filters
	 */
	public static function init() {
		PUM_ALM_Admin_Assets::init();

		add_filter( 'popmake_settings_extensions', array( __CLASS__, 'settings' ) );
	}

	public static function settings( $settings ) {

		return array_merge( $settings, array(
			'alm_message_position' => array(
				'id'   => 'alm_message_position',
				'name' => __( 'Where should form errors be shown?', 'popup-maker-ajax-login-modals' ),
				'type' => 'select',
				'options' => array(
					'top' => __( 'Top', 'popup-maker-ajax-login-modals' ),
					'bottom' => __( 'Bottom', 'popup-maker-ajax-login-modals' ),
				),
				'std' => 'bottom',
			),
			'google_recaptcha_site_key' => array(
				'id'   => 'google_recaptcha_site_key',
				'name' => __( 'Google Recaptcha Site Key', 'popup-maker-ajax-login-modals' ),
				'desc' => '<br/>' . __( '', 'popup-maker-ajax-login-modals' ),
				'type' => 'text',
			),
			'google_recaptcha_secret_key' => array(
				'id'   => 'google_recaptcha_secret_key',
				'name' => __( 'Google Recaptcha Secret Key', 'popup-maker-ajax-login-modals' ),
				'desc' => '<br/>' . __( '', 'popup-maker-ajax-login-modals' ),
				'type' => 'text',
			),


			/*
			'alm_login_cookie' => array(
				'id'   => 'alm_login_cookie',
				'name' => __( 'Global Login Cookie Name', 'popup-maker-ajax-login-modals' ),
				'desc' => '<br/>' . __( 'This cookie will be set when any user logs in, even if not in a popup.', 'popup-maker-ajax-login-modals' ),
				'type' => 'text',
			),
*/
		) );

	}

}
