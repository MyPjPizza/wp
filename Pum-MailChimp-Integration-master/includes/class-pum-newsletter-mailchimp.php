<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class that handles all of the newsletter for MailChimp
 *
 * @package     PopMake\Pum_MailChimp_Integration\PUM_Newsletter_MailChimp
 * @since 1.0.0
 */
class PUM_Newsletter_MailChimp extends PUM_Newsletter {

	/**
	 * Subscribes the user to the list
	 *
	 * @access	public
	 * @since		1.0.0
	 * @return	array The array used to send results and message to shortcode
	 */
	public function subscribe_to_email( $fields, $json_response ) {

		//Only run this function if the service is mailchimp
		if ( strtolower( $this->service ) !== strtolower( $fields['service'] ) && ( strtolower( popmake_get_option( 'newsletter_default' ) ) !==  strtolower( $this->service ) ) ) {
			return $json_response;
		}

		//gathers variables from post
		$api_key = popmake_get_option( 'mc_int_api_key' );
		if ( ! $api_key || empty( $api_key ) ) {
			$json_response["api_error_message"] = 'API Key not given';
			return $json_response;
		}

		//includes the wrapper if needed
		if ( ! class_exists( 'MailChimp_API_Wrapper' ) ) {
			require_once( PUM_MAILCHIMP_INTEGRATION_DIR . 'includes/class-mailchimp-api-wrapper.php' );
		}

		//Check to make sure the fields are present
		if ( 'none' == $fields["list_id"] ) {
			$json_response["api_error_message"] = 'List ID is invalid';
			return $json_response;
		}

		$mailchimp_api = new MailChimp_API_Wrapper( $api_key );
		$list = $fields["list_id"];
		$name = $fields["name"];
		$email = $fields["email"];
		$double_opt_in = popmake_get_option( 'mc_double_opt_in', '' );

		//Creates last name
		$name = explode(" ", $name);
		if ( ! isset( $name[1] ) ) {
			$name[1] = '';
		}

		$list_args = array(
			'email' => $email,
			'first_name' => $name[0],
			'last_name' => $name[1],
			'double_opt_in' => $double_opt_in
		);

		//subscribes user and then echos success or Error
		$results = $mailchimp_api->subscribe_to_list( $list, $list_args );

		//If user has been subscribed, set the results to success
		if ( true === $results ) {
			$json_response["result"] = 'success';
		} elseif ( false === $results ) {
			//Results is false if an WP Error occurred
			$json_response["api_error_message"] = 'WP Error occurred when calling api';
		} else {
			//Decode API response to find error
			$response = json_decode( $results );

			//Add returned message to api err msg and then change error_type
			$json_response["api_error_message"] = $response->title.' : '.$response->detail;
			if ( 'Member Exists' === $response->title ) {
				$json_response["error_type"] = 'already_subscribed';
			}
		}

		return $json_response;
	}
}

$args = array( 'list_id' );
$messages = array(
	'error' => popmake_get_option( 'mc_int_error_message' ),
	'email' => popmake_get_option( 'mc_int_invalid_email_message' ),
	'success' => popmake_get_option( 'mc_int_success_message' ),
	'already_subscribed' => popmake_get_option( 'mc_int_already_subscribed_message' )
);
$pum_newsletter_mailchimp = new PUM_Newsletter_MailChimp( $args, $messages, 'mailchimp' );

?>
