<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class that handles the ajax functions for the extension
 *
 * @package     PopMake\Pum_MailChimp_Integration\PUM_Newsletter_Ajax
 * @since 1.0.0
 */
class PUM_Newsletter_Ajax {

	/**
	 * Attaches the functions to the hooks
	 *
	 * @since 1.0.0
	 * @return void
	 * @access public
	 */
	public static function init() {
		add_action( 'wp_ajax_pum_sub_form_submit', array( 'PUM_Newsletter_Ajax', 'ajax_submit_shortcode' ) );
		add_action( 'wp_ajax_nopriv_pum_sub_form_submit', array( 'PUM_Newsletter_Ajax', 'ajax_submit_shortcode' ) );
	}

	/**
	 * Submits the form using ajax
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public static function ajax_submit_shortcode() {

		//Places the sub form data into $field_values
		parse_str( $_POST["sub_data"], $field_values );

		$json_response = array(
			'result' => 'error', //Accepted values are 'success' and 'error'
			'error_type' => 'default', //Accepted values are 'default' 'empty_name_email' 'invalid_email' and 'already_subscribed'
			'api_error_message' => '',
			'message' => ''
		);

		//Check to make sure the fields are present
		if ( ( ! isset( $field_values["name"] ) || empty( $field_values["name"] ) ) || ( ! isset( $field_values["email"] ) || empty( $field_values["email"] ) ) ) {
			$json_response["message"] = apply_filters( 'pum_newsletter_err_message', 'Error occurred when subscribing. Please try again.' );
			$json_response["error_type"] = 'empty_name_email';
			echo json_encode( $json_response );
			die();
		}

		//Checks to make sure the supplied email is an email address
		if ( ! is_email( $field_values["email"] ) ) {
			$json_response["message"] = apply_filters( 'pum_newsletter_email_message', 'Email provided is not a valid email address.' );
			$json_response["error_type"] = 'invalid_email';
			echo json_encode( $json_response );
			die();
		}

		//Runs through email service classes
		$json_response = apply_filters( 'pum_newsletter_ajax', $field_values, $json_response );

		//If success was returned, then show success message
		if ( 'success' === $json_response["result"] ) {
			$json_response["message"] = apply_filters( 'pum_newsletter_success_message', 'You have been subscribed correctly!' );
		} else {
			//If not successful, show the correct error type's message
			switch ( $json_response["error_type"] ) {
				case 'already_subscribed':
					$json_response["message"] = apply_filters( 'pum_newsletter_already_sub_err_msg', 'You are already a subscriber.' );
					break;

				default:
					$json_response["message"] = apply_filters( 'pum_newsletter_err_message', 'Error occurred when subscribing. Please try again.' );
					break;
			}
		}

		//Echo final response in JSON form
		echo json_encode( $json_response );

		//Don't want anything extra going or wasting extra resources
		die();
	}
}

PUM_Newsletter_Ajax::init();

?>
