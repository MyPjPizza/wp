<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PUM_ALM_Forms {

	public static function init() {
		add_action( 'pum_login_form_filters', array( __CLASS__, 'login_form_callback' ) );
		add_action( 'pum_login_form_after', array( __CLASS__, 'form_after' ), 10, 2 );
		add_action( 'pum_registration_form_after', array( __CLASS__, 'form_after' ), 10, 2 );
		add_action( 'pum_recovery_form_after', array( __CLASS__, 'form_after' ), 10, 2 );
	}


	/**
	 * Returns an PUM_Form object for the login form.
	 *
	 * @param array $args
	 *
	 * @return \PUM_Form
	 */
	public static function get_login_form( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'form_id'              => 'pum-login-form',
			// Form Settings
			'disable_redirect'     => false,
			'redirect'             => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'disable_remember'     => false,
			// Labels
			'disable_labels'       => false,
			'label_username'       => __( 'Username' ),
			'label_password'       => __( 'Password' ),
			'label_remember'       => __( 'Remember Me' ),
			'label_submit'         => __( 'Log In' ),
			// Placeholders
			'disable_placeholders' => false,
			'placeholder_username' => __( 'Username' ),
			'placeholder_password' => __( 'Password' ),
			// Values
			'value_username'       => '',
			'value_remember'       => false,
			// Deprecated
			'remember'             => true,
		) );

		// Used for compatibility with plugins that modify the built in login forms.
		$pum_login_form_args = shortcode_atts( array(
			'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id'        => 'pum-login-form',
			'label_username' => __( 'Username' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_submit'   => __( 'Log In' ),
			'id_username'    => 'user_login',
			'id_password'    => 'user_pass',
			'id_remember'    => 'rememberme',
			'id_submit'      => 'wp-submit',
			'remember'       => ! $args['disable_remember'],
			'value_username' => '',
			'value_remember' => false,
		), $args );

		$form_fields = array();

		$form_fields['top'] = array(
			'type'        => 'hook',
			'hook'        => 'login_form_filters',
			'priority'    => 0,
			'filter_args' => $pum_login_form_args,
		);

		$form_fields['user_login'] = array(
			'name'        => 'log',
			'label'       => ! $args['disable_labels'] ? $args['label_username'] : null,
			'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_username'] : null,
			'std'         => $args['value_username'],
			'priority'    => 5,
			'required'    => true,
		);

		$form_fields['user_pass'] = array(
			'name'        => 'pwd',
			'label'       => ! $args['disable_labels'] ? $args['label_password'] : null,
			'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_password'] : null,
			'type'        => 'password',
			'priority'    => 10,
			'required'    => true,
		);

		$form_fields['middle'] = array(
			'type'        => 'hook',
			'hook'        => 'login_form_filters',
			'priority'    => 25,
			'filter_args' => $pum_login_form_args,
		);

		if ( ! $args['disable_remember'] ) {
			$form_fields['remember'] = array(
				'id'           => 'rememberme',
				'name'         => 'rememberme',
				'desc'         => $args['label_remember'],
				'checkbox_val' => 'forever',
				'type'         => 'checkbox',
				'std'          => $args['value_remember'] ? 1 : 0,
				'priority'     => 30,
			);
		}

		$form_args = shortcode_atts( array(
			'disable_redirect' => false,
			'redirect'         => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		), $args );

		$form_fields['_form_args'] = array(
			'type'     => 'hidden',
			'std'      => json_encode( $form_args ),
			'priority' => 40,
		);

		$form_fields['wp-submit'] = array(
			'label'       => $args['label_submit'],
			'type'        => 'wpsubmit',
			'button_type' => 'submit',
			'class'       => 'button-primary',
			'priority'    => 100000,
			'std'         => __( 'Log In' ),
		);

		$form_fields['bottom'] = array(
			'type'        => 'hook',
			'hook'        => 'login_form_filters',
			'priority'    => 50,
			'filter_args' => $pum_login_form_args,
		);

		// Allow users to add additional meta fields.
		$meta = apply_filters( 'pum_login_form_meta_fields', array(), $args );
		if ( ! empty( $meta ) ) {
			$form_fields['meta'] = $meta;
		}

		$form = new PUM_ALM_Form_User( $args['form_id'], array(
			'fields' => apply_filters( 'pum_login_form_fields', $form_fields ),
		) );

		return $form;
	}

	/**
	 * Returns an PUM_Form object for the registration form.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public static function get_registration_form( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'form_id'                      => 'pum-registration-form',
			'enable_confirm_email'         => false,
			'enable_password'              => false,
			'enable_confirm_password'      => false,
			'enable_autologin'             => false,
			'disable_redirect'             => false,
			'enable_recaptcha'             => false,
			'redirect'                     => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			// Labels
			'disable_labels'               => false,
			'label_username'               => __( 'Username', 'popup-maker-ajax-login-modals' ),
			'label_email'                  => __( 'Email', 'popup-maker-ajax-login-modals' ),
			'label_confirm_email'          => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
			'label_password'               => __( 'Password', 'popup-maker-ajax-login-modals' ),
			'label_confirm_password'       => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
			'label_submit'                 => __( 'Register', 'popup-maker-ajax-login-modals' ),
			// Placeholders
			'disable_placeholders'         => false,
			'placeholder_username'         => __( 'Username', 'popup-maker-ajax-login-modals' ),
			'placeholder_email'            => __( 'Email', 'popup-maker-ajax-login-modals' ),
			'placeholder_confirm_email'    => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
			'placeholder_password'         => __( 'Password', 'popup-maker-ajax-login-modals' ),
			'placeholder_confirm_password' => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
			// Values
			'value_username'               => '',
			'value_email'                  => '',
			// Deprecated
			'redirect_url'                 => false,
		) );


		$form_fields = array();

		$form_fields['user_login'] = array(
			'label'       => ! $args['disable_labels'] ? $args['label_username'] : null,
			'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_username'] : null,
			'std'         => $args['value_username'],
			'class'       => 'registration-username',
			'priority'    => 5,
			'required'    => true,
		);

		$form_fields['user_email'] = array(
			'label'       => ! $args['disable_labels'] ? $args['label_email'] : null,
			'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_email'] : null,
			'type'        => 'email',
			'class'       => 'registration-email',
			'priority'    => 10,
			'required'    => true,
		);
		if ( $args['enable_confirm_email'] ) {
			$form_fields['user_email2'] = array(
				'label'       => ! $args['disable_labels'] ? $args['label_confirm_email'] : null,
				'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_confirm_email'] : null,
				'type'        => 'email',
				'priority'    => 10.1,
				'required'    => true,
			);
		}

		if ( $args['enable_password'] ) {
			$form_fields['user_pass'] = array(
				'label'       => ! $args['disable_labels'] ? $args['label_password'] : null,
				'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_password'] : null,
				'type'        => 'password',
				'priority'    => 15,
				'required'    => true,
			);
			if ( $args['enable_confirm_password'] ) {
				$form_fields['user_pass2'] = array(
					'label'       => ! $args['disable_labels'] ? $args['label_confirm_password'] : null,
					'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_confirm_password'] : null,
					'type'        => 'password',
					'priority'    => 15.1,
					'required'    => true,
				);
			}
		}

		$form_fields['register_form_hook'] = array(
			'type'     => 'hook',
			'hook'     => 'register_form',
			'priority' => 25,
		);

		$form_args = shortcode_atts( array(
			'enable_autologin' => false,
			'disable_redirect' => false,
			'redirect'         => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		), $args );

		$form_fields['_form_args'] = array(
			'type'     => 'hidden',
			'std'      => json_encode( $form_args ),
			'priority' => 40,
		);

		// Allow users to add additional meta fields.
		$form_fields = apply_filters( 'pum_registration_form_fields', $form_fields, $args );

		if ( $args['enable_recaptcha'] ) {
			$form_fields['recaptcha'] = array(
				'type'     => 'recaptcha',
				'priority' => 99999,
			);
		}

		$form_fields['wp-submit'] = array(
			'label'       => $args['label_submit'],
			'type'        => 'wpsubmit',
			'button_type' => 'submit',
			'class'       => 'button-primary',
			'priority'    => 100000,
			'std'         => __( 'Register' ),
		);

		$form = new PUM_ALM_Form_User( $args['form_id'], array(
			'fields' => apply_filters( 'pum_registration_form_fields', $form_fields ),
		) );

		return $form;
	}

	/**
	 * Returns an PUM_Form object for the recovery form.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public static function get_recovery_form( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'form_id'              => 'pum-recovery-form',
			'disable_redirect'     => false,
			'redirect'             => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			// Labels
			'disable_labels'       => false,
			'label_username'       => __( 'Username or E-mail', 'popup-maker-ajax-login-modals' ),
			'label_submit'         => __( 'Get New Password', 'popup-maker-ajax-login-modals' ),
			// Placeholders
			'disable_placeholders' => false,
			'placeholder_username' => __( 'Username', 'popup-maker-ajax-login-modals' ),
			// Values
			'value_username'       => '',
			// Deprecated
			'redirect_url'         => false,
		) );

		$form_fields = array();

		$form_fields['user_login'] = array(
			'label'       => ! $args['disable_labels'] ? $args['label_username'] : null,
			'placeholder' => ! $args['disable_placeholders'] ? $args['placeholder_username'] : null,
			'std'         => $args['value_username'],
			'class'       => 'recovery-username',
			'priority'    => 5,
			'required'    => true,
		);

		$form_fields['recovery_form_hook'] = array(
			'type'     => 'hook',
			'hook'     => 'lostpassword_form',
			'priority' => 25,
		);

		$form_args = shortcode_atts( array(
			'disable_redirect' => false,
			'redirect'         => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		), $args );

		$form_fields['_form_args'] = array(
			'type'     => 'hidden',
			'std'      => json_encode( $form_args ),
			'priority' => 40,
		);

		$form_fields['wp-submit'] = array(
			'label'       => $args['label_submit'],
			'type'        => 'wpsubmit',
			'button_type' => 'submit',
			'class'       => 'button-primary',
			'priority'    => 100000,
			'std'         => __( 'Get New Password' ),
		);

		// Allow users to add additional meta fields.
		$meta = apply_filters( 'pum_recovery_form_meta_fields', array(), $args );
		if ( ! empty( $meta ) ) {
			$form_fields['meta'] = $meta;
		}

		$form = new PUM_ALM_Form_User( $args['form_id'], array(
			'fields' => apply_filters( 'pum_recovery_form_fields', $form_fields ),
		) );

		return $form;
	}

	/**
	 * Used to render core login form filters.
	 *
	 * @param $args
	 */
	public static function login_form_callback( $atts ) {

		$filter_args = isset( $atts['filter_args'] ) ? $atts['filter_args'] : array();

		if ( in_array( $atts['id'], array( 'top', 'bottom', 'middle' ) ) ) {

			if ( empty( $filter_args ) ) {
				return;
			}

			// Mainly here for compatiblity with existing plugins that modify the contents of the login form. Our customization will come with hooks.
			if ( has_filter( 'login_form_' . $atts['id'] ) ) {
				echo apply_filters( 'login_form_' . $atts['id'], '', $filter_args );
			}

		}

		// Here for us to extend the login form with actions.
		if ( has_action( 'pum_alm_form_' . $atts['id'] ) ) {
			do_action( 'pum_alm_form_' . $atts['id'], $atts, $filter_args );
		}

	}

	public static function form_after( $form, $atts ) {
		switch ( $form->id ) {
			case 'pum-login-form':
				echo pum_alm_footer_links( array( 'registration', 'recovery' ) );
				break;
			case 'pum-registration-form':
				echo pum_alm_footer_links( array( 'login', 'recovery' ) );
				break;
			case 'pum-recovery-form':
				echo pum_alm_footer_links( array( 'login', 'registration' ) );
				break;
		}
	}


}
