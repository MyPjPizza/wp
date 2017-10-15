<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * MailChimp API Wrapper Class
 *
 * @package     PopMake\Pum_MailChimp_Integration\MailChimp_API_Wrapper
 * @since 1.0.0
 */
class MailChimp_API_Wrapper {

	/**
	 * User's API Key
	 *
	 * @var string $api_key The API key of the user's account
	 * @since 1.0.0
	 */
	public $api_key = '';

	/**
	 *
	 */
	public $api_url = 'https://<dc>.api.mailchimp.com/3.0';

	/**
	 * Main constructor, saves api key to class property
	 *
	 * @since 1.0.0
	 */
	function __construct( $api_key ) {
		$this->api_key = $api_key;
		$data_center = explode( '-', $api_key );
		$this->api_url = str_replace( '<dc>', $data_center[1], $this->api_url );
	}

	/**
	 * Retrieves the lists from the user's account
	 *
	 * @since 1.0.0
	 * @uses MailChimp_API_Wrapper:api_call
	 * @return object The lists attached to the user's account
	 */
	public function get_lists() {
		return json_decode( $this->api_call( '/lists', array(), 'get' ) );
	}

	/**
	 * Subscribes user to supplied list
	 *
	 * @since 1.0.0
	 * @uses MailChimp_API_Wrapper:api_call
	 * @return bool|string False if failed, string if works
	 */
	public function subscribe_to_list( $list_id, $list_args ) {
		$defaults = array(
			'email' => '',
			'first_name' => '',
			'last_name' => '',
			'double_opt_in' => 'enable'
		);
		$list_args = wp_parse_args( $list_args, $defaults );
		if ( 'disable' === $list_args["double_opt_in"] ) {
			$status = 'subscribed';
		} else {
			$status = 'pending';
		}
		$args = apply_filters('pum_mailchimp_sub_list_args', array(
			'email_address' => sanitize_email( $list_args["email"] ),
			'status' => $status,
			'merge_fields' => array(
				'FNAME' => $list_args["first_name"],
				'LNAME' => $list_args["last_name"]
			)
		));
		return $this->api_call( "/lists/$list_id/members", $args );
	}

	/**
	 * Calls the MailChimp API using wp_remote_get or wp_remote_post
	 *
	 * @since 1.0.0
	 * @param $url string The url of the api to call
	 * @param $parameter_array array An array for the data to send in the body
	 * @param $method string Whether to call the api using GET or POST. Pass either 'post' or 'get'
	 * @return bool|string False if failed, string if works
	 */
	public function api_call( $url, $parameter_array = array(), $method = 'post' ) {
		$api_url = $this->api_url . $url;

		$parameter_array = array_merge( $parameter_array, array( 'apikey' => $this->api_key ) );

		if ( 'post' === $method ) {
			$response = wp_remote_post( $api_url, array(
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( 'ApiKey:' . $this->api_key )
				),
				'timeout' => 15,
				'body' => json_encode( $parameter_array )
			) );
		} else {
			$response = wp_remote_get( $api_url, array(
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( 'ApiKey:' . $this->api_key )
				),
				'timeout' => 15,
				'body' => json_encode( $parameter_array )
			) );
		}

		if ( is_wp_error( $response ) ) {
			return false;
		} elseif ( 200 === wp_remote_retrieve_response_code( $response ) ) {
			return true;
		} else {
			return $response["body"];
		}
	}
}
?>
