<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class PUM_ALM_Validation {

	public static function init() {
		add_filter( 'pum_alm_login_validation', array( __CLASS__, 'login' ), 10, 2 );
		add_filter( 'pum_alm_registration_validation', array( __CLASS__, 'registration' ), 10, 2 );
		add_filter( 'pum_alm_registration_validation', array( __CLASS__, 'recaptcha' ), 1000, 2 );
		add_filter( 'pum_alm_recovery_validation', array( __CLASS__, 'recovery' ), 10, 2 );
	}

	public static function login( $errors = array(), $values = array() ) {
		if ( empty( $values['log'] ) ) {
			$errors->add( 'empty_username', __( "<strong>ERROR</strong>: Please enter your username or email.", 'popup-maker-ajax-login-modals' ) );
		}

		if ( empty( $values['pwd'] ) ) {
			$errors->add( 'empty_username', __( "<strong>ERROR</strong>: Please enter your password.", 'popup-maker-ajax-login-modals' ) );
		}

		return $errors;
	}

	/**
	 * @param WP_Error $errors
	 * @param array $values
	 *
	 * @return array|int|mixed|void|WP_Error
	 */
	public static function registration( $errors, $values = array() ) {

		$sanitized_user_login = sanitize_user( $values['user_login'] );

		/**
		 * Filters the email address of a user being registered.
		 *
		 * @since 2.1.0
		 *
		 * @param string $values ['user_email'] The email address of the new user.
		 */
		$values['user_email'] = apply_filters( 'user_registration_email', $values['user_email'] );

		// Check the username
		if ( $sanitized_user_login == '' ) {
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
		} elseif ( ! validate_username( $values['user_login'] ) ) {
			$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
			$sanitized_user_login = '';
		} elseif ( username_exists( $sanitized_user_login ) ) {
			$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );

		} else {
			/** This filter is documented in wp-includes/user.php */
			$illegal_user_logins = array_map( 'strtolower', (array) apply_filters( 'illegal_user_logins', array() ) );
			if ( in_array( strtolower( $sanitized_user_login ), $illegal_user_logins ) ) {
				$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: Sorry, that username is not allowed.' ) );
			}
		}

		// Check the email address
		if ( $values['user_email'] == '' ) {
			$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your email address.' ) );
		} elseif ( ! is_email( $values['user_email'] ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
			$values['user_email'] = '';
		} elseif ( email_exists( $values['user_email'] ) ) {
			$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
		}

		/**
		 * Fires when submitting registration form data, before the user is created.
		 *
		 * @since 2.1.0
		 *
		 * @param string $sanitized_user_login The submitted username after being sanitized.
		 * @param string $values ['user_email'] The submitted email.
		 * @param WP_Error $errors Contains any errors with submitted username and email,
		 *                                       e.g., an empty field, an invalid username or email,
		 *                                       or an existing username or email.
		 */
		do_action( 'register_post', $sanitized_user_login, $values['user_email'], $errors );

		/**
		 * Filters the errors encountered when a new user is being registered.
		 *
		 * The filtered WP_Error object may, for example, contain errors for an invalid
		 * or existing username or email address. A WP_Error object should always returned,
		 * but may or may not contain errors.
		 *
		 * If any errors are present in $errors, this will abort the user's registration.
		 *
		 * @since 2.1.0
		 *
		 * @param WP_Error $errors A WP_Error object containing any errors encountered
		 *                                       during registration.
		 * @param string $sanitized_user_login User's username after it has been sanitized.
		 * @param string $values ['user_email'] User's email.
		 */
		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $values['user_email'] );

		return $errors;
	}

	public static function recovery( $errors = array(), $values = array() ) {
		if ( empty( $values['user_login'] ) ) {
			$errors->add( 'empty_username', __( "<strong>ERROR</strong>: Please enter your username or email.", 'popup-maker-ajax-login-modals' ) );
		}

		return $errors;
	}

	/**
	 * @param WP_Error $errors
	 * @param array $values
	 *
	 * @return array|int|mixed|void|WP_Error
	 */
	public static function recaptcha( $errors, $values = array() ) {

		if ( ! isset( $values['g-recaptcha-response'] ) ) {
			return $errors;
		}

		if ( empty( $values['g-recaptcha-response'] ) ) {
			$errors->add( 'empty_captcha', __( '<strong>ERROR</strong>: Please complete the CAPTCHA.' ) );

			return $errors;
		}

		$secret = popmake_get_option( 'google_recaptcha_secret_key', false );

		if ( ! $secret ) {
			$errors->add( 'no_captcha_key', __( '<strong>ERROR</strong>: The admin has not entered a valid Google CAPTCHA API key.' ) );

			return $errors;
		}

		$args = array(
			'response' => esc_attr( $values['g-recaptcha-response'] ),
			'remoteip' => $_SERVER["REMOTE_ADDR"],
			'secret'   => $secret,
		);

		// make a GET request to the Google reCAPTCHA Server
		$request = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?' . http_build_query( $args ) );

		// get the request response body
		$response_body = wp_remote_retrieve_body( $request );

		$result = json_decode( $response_body, true );

		if ( ! $result['success'] ) {
			$errors->add( 'invalid_captcha', __( '<strong>ERROR</strong>: Please retry CAPTCHA.' ) );
		}

		return $errors;
	}

}
