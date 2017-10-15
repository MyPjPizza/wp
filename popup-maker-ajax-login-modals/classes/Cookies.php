<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class PUM_ALM_Cookies {

	public static function init() {
		add_filter( 'pum_get_cookies', array( __CLASS__, 'register_cookies' ) );

	}

	public static function register_cookies( $cookies = array() ) {
		return array_merge( $cookies, array(
			'login_successful'             => array(
				'labels' => array(
					'name' => __( 'Login Successful', 'popup-maker-ajax-login-modals' ),
				),
				'fields' => pum_get_cookie_fields(),
			),
			'registration_successful' => array(
				'labels' => array(
					'name' => __( 'Registration Successful', 'popup-maker-ajax-login-modals' ),
				),
				'fields' => pum_get_cookie_fields(),
			),
		) );
	}

}
