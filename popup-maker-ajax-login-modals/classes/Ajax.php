<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PUM_ALM Ajax class
 *
 * @since       1.2.0
 */
class PUM_ALM_Ajax {

	/**
	 * @var WP_Error
	 */
	public static $errors;

	/**
	 * Initialize Hooks & Filters
	 */
	public static function init() {
		self::$errors = new WP_Error();
		add_action( 'wp_ajax_pum_alm_form', array( __CLASS__, 'ajax_call' ) );
		add_action( 'wp_ajax_nopriv_pum_alm_form', array( __CLASS__, 'ajax_call' ) );
	}

	/**
	 * Process all pum_alm form submissions.
	 */
	public static function ajax_call() {
		$values = ! empty( $_REQUEST ) ? $_REQUEST : array();
		$which  = ! empty( $values['which'] ) ? $values['which'] : false;

		if ( ! $which ) {
			return;
		}

		unset( $values['which'] );
		unset( $values['action'] );

		if ( isset( $values['_form_args'] ) ) {
			try {
				$values['_form_args'] = json_decode( stripslashes( $values['_form_args'] ) );
			} catch ( Exception $e ) {
				self::$errors->add( 'noformargs', __( 'Missing form arguments.', 'popup-maker-ajax-login-modals' ) );
			}
		}

		// Deprecated.
		do_action( 'popmake_alm_ajax_override_' . $which, $values );

		do_action( 'pum_alm_' . $which . '_ajax_override', $values );

		// Allow validation of the data.
		self::$errors = apply_filters( 'pum_alm_' . $which . '_validation', self::$errors, $values );

		if ( self::$errors->get_error_code() ) {
			self::send_errors();
		}

		switch ( $which ) {
			case 'login':
				self::process_login( $values );
				break;
			case 'registration':
				self::process_registration( $values );
				break;
			case 'recovery':
				self::process_recovery( $values );
				break;
		}

		// Don't let it keep going.
		die();
	}

	/**
	 * Process ajax login forms
	 *
	 * @param array $values
	 */
	public static function process_login( $values = array() ) {
		$user = wp_signon();

		$values['_form_args'] = shortcode_atts( array(
			'disable_redirect' => false,
			'redirect'         => '',
		), $values['_form_args'] );

		if ( ! is_wp_error( $user ) ) {
			wp_send_json_success( array(
				'message'  => __( 'Login Successful!', 'popup-maker-ajax-login-modals' ),
				'user'     => self::get_user_data( $user->ID ),
				'redirect' => ! $values['_form_args']['disable_redirect'] ? $values['_form_args']['redirect'] : false,
			) );
		} else {
			self::send_errors( $user );
		}
	}

	/**
	 * Process ajax registration forms
	 *
	 * @param array $values
	 */
	public static function process_registration( $values = array() ) {

		$values['_form_args'] = shortcode_atts( array(
			'enable_autologin' => false,
			'disable_redirect' => false,
			'redirect'         => '',
		), $values['_form_args'] );

		$user_data = wp_parse_args( $values, array(
			'user_login'      => '',
			'user_pass'       => wp_generate_password( 12, false ),
			'user_email'      => '',
			'first_name'      => '',
			'last_name'       => '',
			'user_registered' => date( 'Y-m-d H:i:s' ),
			'role'            => get_option( 'default_role' ),
		) );

		$user_id = wp_insert_user( $user_data );

		if ( ! $user_id || is_wp_error( $user_id ) ) {
			self::$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );

			self::send_errors();

			wp_send_json_error( array(
				'message' => $user_id->get_error_message(),
			) );

		}

		update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

		/**
		 * Fires after a new user registration has been recorded.
		 *
		 * @since 4.4.0
		 *
		 * @param int $user_id ID of the newly registered user.
		 */
		do_action( 'register_new_user', $user_id );

		// Auto Login if enabled.
		if ( $values['_form_args']['enable_autologin'] ) {
			self::log_user_in( $user_id, $values['user_login'] );
		}

		$message = __( 'Registration complete.', 'popup-maker-ajax-login-modals' );

		if ( ! isset( $values['user_pass'] ) || $values['user_pass'] == '' ) {
			update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.
			wp_new_user_notification( $user_id, $user_data['user_pass'] );
			$message .= ' ' . __( 'Please check your e-mail.', 'popup-maker-ajax-login-modals' );
		}

		wp_send_json_success( array(
			'message'  => $message,
			'user'     => self::get_user_data( $user_id ),
			'redirect' => ! $values['_form_args']['disable_redirect'] ? $values['_form_args']['redirect'] : false,
		) );
	}

	/**
	 * Process ajax recovery forms
	 *
	 * @param $values
	 */
	public static function process_recovery( $values ) {
		$values['_form_args'] = shortcode_atts( array(
			'disable_redirect' => false,
			'redirect'         => '',
		), $values['_form_args'] );

		// Send our information
		$user_forgotten = self::retrieve_password();

		// Check if there were any errors when requesting a new password
		if ( ! is_wp_error( $user_forgotten ) ) {
			wp_send_json_success( array(
				'message'  => __( 'Check your email for the confirmation link.' ),
				'redirect' => ! $values['_form_args']['disable_redirect'] ? $values['_form_args']['redirect'] : false,
			) );
		} else {
			self::send_errors( $user_forgotten );
		}
	}

	public static function get_user_data( $user_id ) {
		$user = shortcode_atts( array(
			'ID'              => '',
			'display_name'    => '',
			'user_email'      => '',
			'user_login'      => '',
			'user_nicename'   => '',
			'user_registered' => '',
			'user_url'        => '',
		), get_userdata( $user_id )->to_array() );

		// $user['meta'] = get_user_meta( $user_id );

		return apply_filters( 'pum_alm_ajax_get_user_data', $user );

	}

	public static function log_user_in( $user_id, $user_login ) {
		if ( $user_id < 1 ) {
			return;
		}

		wp_set_auth_cookie( $user_id );
		wp_set_current_user( $user_id, $user_login );
		do_action( 'wp_login', $user_login, get_userdata( $user_id ) );
	}

	/**
	 * Handles sending password retrieval email to user. (Copied from core wp-login.php
	 *
	 * @global wpdb         $wpdb      WordPress database abstraction object.
	 * @global PasswordHash $wp_hasher Portable PHP password hashing framework.
	 *
	 * @return bool|WP_Error True: when finish. WP_Error on error
	 */
	private static function retrieve_password() {
		$errors = new WP_Error();

		if ( empty( $_POST['user_login'] ) ) {
			$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or email address.'));
		} elseif ( strpos( $_POST['user_login'], '@' ) ) {
			$user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
			if ( empty( $user_data ) )
				$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
		} else {
			$login = trim($_POST['user_login']);
			$user_data = get_user_by('login', $login);
		}

		/**
		 * Fires before errors are returned from a password reset request.
		 *
		 * @since 2.1.0
		 * @since 4.4.0 Added the `$errors` parameter.
		 *
		 * @param WP_Error $errors A WP_Error object containing any errors generated
		 *                         by using invalid credentials.
		 */
		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() )
			return $errors;

		if ( !$user_data ) {
			$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or email.'));
			return $errors;
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			return $key;
		}

		$message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

		if ( is_multisite() )
			$blogname = $GLOBALS['current_site']->site_name;
		else
			/*
			 * The blogname option is escaped with esc_html on the way into the database
			 * in sanitize_option we want to reverse this for the plain text arena of emails.
			 */
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$title = sprintf( __('[%s] Password Reset'), $blogname );

		/**
		 * Filters the subject of the password reset email.
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		/**
		 * Filters the message body of the password reset mail.
		 *
		 * @since 2.8.0
		 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

		if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
			wp_die( __('The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );

		return true;
	}

	/**
	 * @param $errors WP_Error
	 */
	public static function send_errors( $errors = null ) {
		if ( ! $errors || ! is_wp_error( $errors ) ) {
			$errors = self::$errors;
		}

		wp_send_json_error( array(
			'errors' => $errors->get_error_messages(),
		) );
		die();
	}


}
