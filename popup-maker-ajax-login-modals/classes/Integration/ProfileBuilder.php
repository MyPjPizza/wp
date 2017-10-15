<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PUM_ALM Integration: Profile Builder class
 *
 * @since       1.2.0
 */
class PUM_ALM_Integration_ProfileBuilder {

	/**
	 * Initialize Hooks & Filters
	 */
	public static function init() {
		if ( defined( 'PROFILE_BUILDER' ) || function_exists( 'wppb_plugin_init' ) || function_exists( 'wppb_free_plugin_init' ) ) {
			add_action( 'pum_alm_registration_ajax_override', array( __CLASS__, 'ajax_registration_override' ) );
			add_filter( 'popmake_get_template_part', array( __CLASS__, 'registration_form_template' ), 10, 3 );
		}
	}

	/**
	 * @param $templates
	 * @param $slug
	 * @param $name
	 *
	 * @return array
	 */
	public static function registration_form_template( $templates, $slug, $name ) {
		if ( $slug !== 'form' || $name !== 'registration' ) {
			return $templates;
		}

		return array_merge( array( 'form-registration-profile-builder.php' ), $templates );
	}

	/**
	 *
	 */
	public static function ajax_registration_override() {

		require_once WPPB_PLUGIN_DIR . '/front-end/class-formbuilder.php';
		require_once WPPB_PLUGIN_DIR . '/front-end/register.php';

		$_REQUEST['action'] = $_POST['action'] = "register";

		$register = wppb_front_end_register_handler( array() );
		$errors   = $register->wppb_test_required_form_values( $_REQUEST );

		ob_start();

		echo $register;

		$form = ob_get_clean();

		if ( ! empty( $errors ) ) {
			wp_send_json_error( array(
				'form' => $form,
			) );
		}

		$form_args = isset( $_POST['_form_args'] ) ? $_POST['_form_args'] : false;

		try {
			$form_args = (array) json_decode( stripslashes( $form_args ) );
		} catch ( Exception $e ) {}

		$data = array(
			'form' => $form,
			'redirect' => ! $form_args['disable_redirect'] ? $form_args['redirect'] : false,
		);

		if ( $form_args['enable_autologin'] ) {
			$creds = array(
				'user_login'    => $_POST['username'],
				'user_password' => $_POST['passw1'],
				'remember'      => true,
			);

			$user = wp_signon( $creds );

			if ( ! is_wp_error( $user ) ) {
				$data['user'] = PUM_ALM_Ajax::get_user_data( $user->ID );
			}
		}

		wp_send_json_success( $data );

		die();
	}
}
