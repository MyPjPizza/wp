<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PUM_Newsletter_Shortcodes' ) ) {
	require_once 'class-pum-newsletter-shortcodes.php';
}
if( ! class_exists( 'PUM_Newsletter_Ajax' ) ) {
	require_once 'class-pum-newsletter-ajax.php';
}
if( ! class_exists( 'PUM_Newsletter' ) ) {
	require_once 'newsletter-functions.php';

	/**
	 * Class that handles all of the newsletter functionality
	 *
	 * @package     PopMake\Pum_MailChimp_Integration\PUM_Newsletter
	 * @since 1.0.0
	 */
	class PUM_Newsletter {

		/**
		 * @var         PUM_Newsletter $shortcode_fields An array of fields needed for the email service such as 'list_id'
		 * @since       1.0.0
		 */
		public $shortcode_fields = array();

		/**
		 * @var         PUM_Newsletter $service A string of the email service name such as 'mailchimp'
		 * @since       1.0.0
		 */
		public $service = '';

		/**
		 * @var         PUM_Newsletter $error_message The error message to be shown upon error
		 * @since       1.0.0
		 */
		public $error_message = '';

		/**
		 * @var         PUM_Newsletter $email_message The error message to be shown when email is invalid
		 * @since       1.0.0
		 */
		public $email_message = '';

		/**
		 * @var         PUM_Newsletter $success_message The success message shown when user is signed up
		 * @since       1.0.0
		 */
		public $success_message = '';

		/**
		 * @var         PUM_Newsletter $already_subscribed_message The message shown when user is already subscribed
		 * @since       1.0.0
		 */
		public $already_subscribed_message = '';

		/**
		 * The constructor method which sets up all filters and actions to prepare fields and messages
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	null
		 */
		function __construct( $fields, $messages, $service ) {

			//Saves the messages into properties
			$this->error_message = $messages["error"];
			$this->email_message = $messages["email"];
			$this->success_message = $messages["success"];
			$this->already_subscribed_message = $messages["already_subscribed"];

			//Saves fields and service into properties
			$this->shortcode_fields = $fields;
			$this->service = $service;

			//Hooks functions into filters and actions in the ajax and shortcode classes
			add_filter( 'shortcode_atts_pum_sub_form', array( $this, 'register_shortcode_atts' ), 10, 3 );
			add_filter( 'pum_newsletter_err_message', array( $this, 'filter_err_message' ) );
			add_filter( 'pum_newsletter_email_message', array( $this, 'filter_email_message' ) );
			add_filter( 'pum_newsletter_success_message', array( $this, 'filter_success_message' ) );
			add_filter( 'pum_newsletter_already_sub_err_msg', array( $this, 'filter_already_subscribed_message' ) );
			add_filter( 'pum_newsletter_ajax', array( $this, 'subscribe_to_email' ), 10, 2 );
			add_action( 'pum_newsletter_fields', array( $this, 'display_shortcode_fields' ) );
			add_filter( 'pum_newsletter_default', array( $this, 'add_default_option' ) );
		}

		/**
		 * Adds needed fields to shortcode atts
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	array The shortcode atts
		 */
		public function register_shortcode_atts( $out, $pairs, $atts ) {

			//Foreach through the fields needed by the email service
			foreach ( $this->shortcode_fields as $value ) {

				//If the $atts already has the field entered from a shortcode parameter use it
				//If not, set it to 'none'
				if ( array_key_exists( $value, $atts ) ) {
					$out[$value] = $atts[$value];
				} else {
					$out[$value] = 'none';
				}
			}

			return $out;
		}

		/**
		 * Creates the hidden inputs for each of the needed fields for the email service
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	null
		 */
		public function display_shortcode_fields( $atts ) {
			foreach ( $this->shortcode_fields as $value ) {
				echo '<input type="hidden" name="'.$value.'" value="'.$atts[$value].'" >';
			}
		}

		/**
		 * Extend the class and use this function to add in API
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	array The array used to send results and message to shortcode
		 */
		public function subscribe_to_email( $fields, $json_response ) {
			return $json_response;
		}

		/**
		 * Adds the new service as an option for the default newsletter settings
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	array The array of options for the newsletter_default setting
		 */
		 public function add_default_option( $default_array ) {
			 $default_array[$this->service] = $this->service;
			 return $default_array;
		 }

		/**
		 * Hooks into filter to prepare error message
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	string The error message to be displayed
		 */
		public function filter_err_message( $content ) {
			if ( ! empty( $this->error_message ) ) {
				return $this->error_message;
			} else {
				return $content;
			}
		}

		/**
		 * Hooks into filter to prepare email error message
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	string The error message to be displayed
		 */
		public function filter_email_message( $content ) {
			if ( ! empty( $this->email_message ) ) {
				return $this->email_message;
			} else {
				return $content;
			}
		}

		/**
		 * Hooks into filter to prepare success message
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	string The success message to be displayed
		 */
		public function filter_success_message( $content ) {
			if ( ! empty( $this->success_message ) ) {
				return $this->success_message;
			} else {
				return $content;
			}
		}

		/**
		 * Hooks into filter to prepare already subscribed message
		 *
		 * @access	public
		 * @since		1.0.0
		 * @return	string The already subscribed message to be displayed
		 */
		public function filter_already_subscribed_message( $content ) {
			if ( ! empty( $this->already_subscribed_message ) ) {
				return $this->already_subscribed_message;
			} else {
				return $content;
			}
		}
	}
}

?>
