<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_ALM_Site_Assets
 */
class PUM_ALM_Site_Assets {

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

		wp_register_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', null );

		wp_enqueue_script( 'pum-alm', PUM_ALM::$URL . 'assets/js/site' . $suffix . '.js?defer', array( 'popup-maker-site' ), PUM_ALM::$VER, true );
		wp_enqueue_style( 'pum-alm', PUM_ALM::$URL . 'assets/css/site' . $suffix . '.css', array( 'popup-maker-site' ), PUM_ALM::$VER );
		wp_localize_script( 'pum-alm', 'pum_alm_vars', array(
			'message_position' => popmake_get_option( 'alm_message_position', 'bottom' ),
			'is_logged_in'     => is_user_logged_in(),
			'I10n'             => array(
				'errors'                    => array(
					'invalid_form'              => __( "Invalid form type", 'popup-maker-ajax-login-modals' ),
					'empty_username'            => __( '<strong>ERROR</strong>: Please enter a username.' ),
					'empty_login'               => __( "<strong>ERROR</strong>: Please enter your username or email.", 'popup-maker-ajax-login-modals' ),
					'empty_password'            => __( "<strong>ERROR</strong>: Please enter your password.", 'popup-maker-ajax-login-modals' ),
					'empty_confirm_email'       => __( "<strong>ERROR</strong>: Please confirm your email.", 'popup-maker-ajax-login-modals' ),
					'mismatch_confirm_email'    => __( "<strong>ERROR</strong>: Your emails do not match.", 'popup-maker-ajax-login-modals' ),
					'invalid_email'             => __( "<strong>ERROR</strong>: Your email address appears invalid.", 'popup-maker-ajax-login-modals' ),
					'empty_confirm_password'    => __( "<strong>ERROR</strong>: Please confirm your password.", 'popup-maker-ajax-login-modals' ),
					'mismatch_confirm_password' => __( "<strong>ERROR</strong>: Your passwords do not match.", 'popup-maker-ajax-login-modals' ),
					'must_complete_recaptcha'   => __( "<strong>ERROR</strong>: You must complete the captcha.", 'popup-maker-ajax-login-modals' ),
					'unknown'                   => __( 'An error has occurred. Please try again.', 'popup-maker-ajax-login-modals' ),
				),
			),
		) );
	}

}
