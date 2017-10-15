<?php
/*
 * @package   GFP_Third_Party_Post
 * @copyright 2015-2016 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GFP_Third_Party_Post_Addon
 *
 * Adds form feed and sends Gravity Forms submission to specified third-party API URL
 *
 * @since  1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Third_Party_Post_Addon extends GFFeedAddOn {

	/**
	 * @var string Version number of the Add-On
	 */
	protected $_version = GFP_THIRD_PARTY_POST_CURRENT_VERSION;

	/**
	 * @var string Gravity Forms minimum version requirement
	 */
	protected $_min_gravityforms_version = '2.0';

	/**
	 * @var string URL-friendly identifier used for form settings, add-on settings, text domain localization...
	 */
	protected $_slug = GFP_THIRD_PARTY_POST_SLUG;

	/**
	 * @var string Relative path to the plugin from the plugins folder
	 */
	protected $_path = GFP_THIRD_PARTY_POST_PATH;

	/**
	 * @var string Full path to the plugin. Example: __FILE__
	 */
	protected $_full_path = GFP_THIRD_PARTY_POST_FILE;

	/**
	 * @var string URL to the App website.
	 */
	protected $_url = 'https://gravityplus.pro/gravity-forms-post-to-third-party-api';

	/**
	 * @var string Title of the plugin to be used on the settings page, form settings and plugins page.
	 */
	protected $_title = 'Gravity Forms Send to Third Party';

	/**
	 * @var string Short version of the plugin title to be used on menus and other places where a less verbose string
	 *      is useful.
	 */
	protected $_short_title = 'Send to Third Party';

	/**
	 * @var array Members plugin integration. List of capabilities to add to roles.
	 */
	protected $_capabilities = array(
		'gravityplusthirdpartypost_form_settings',
		'gravityplusthirdpartypost_uninstall'
	);

	// ------------ Permissions -----------

	/**
	 * @var string|array A string or an array of capabilities or roles that have access to the form settings
	 */
	protected $_capabilities_form_settings = array( 'gravityplusthirdpartypost_form_settings' );

	/**
	 * @var string|array A string or an array of capabilities or roles that can uninstall the plugin
	 */
	protected $_capabilities_uninstall = array( 'gravityplusthirdpartypost_uninstall' );

	private static $_instance = null;

	/**
	 * The submitted form
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var null
	 */
	private $form = null;

	/**
	 * Request to submit to third-party API
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $request = array();

	/**
	 * Response from third-party API
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $response;

	/**
	 * Delay third-party API submission
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var bool
	 */
	private $delay_post = false;

	/**
	 * Reason for delaying the post
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var string
	 */
	private $delay_reason = '';

	/**
	 * PDFs to send
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @var array
	 */
	private $pdfs = array();

	/**
	 * @return GFP_Third_Party_Post_Addon|null
	 */
	public static function get_instance() {

		if ( self::$_instance == null ) {

			self::$_instance = new self();

		}

		return self::$_instance;

	}

	/**
	 * @see    GFAddOn::upgrade
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string $previous_version
	 */
	public function upgrade( $previous_version ) {

		if ( '1.0.0' == $previous_version ) {

			$this->convert_keys_to_new_dynamic_field_map_format();

		}

		if ( '1.2.0' > $previous_version ) {

			$this->update_current_feeds_with_new_settings();

		}

	}

	/**
	 * Convert current feed parameters to new dynamic field map key format
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function convert_keys_to_new_dynamic_field_map_format() {

		$forms = GFFormsModel::get_forms();

		foreach ( $forms as $form ) {

			$feeds = $this->get_feeds( $form->id );

			if ( $feeds ) {

				foreach ( $feeds as $feed ) {

					$request_body = rgar( $feed[ 'meta' ], 'request_body' );

					foreach ( $request_body as $number => $parameter_info ) {

						$request_body[ $number ][ 'key' ]        = 'gf_custom';
						$request_body[ $number ][ 'value' ]      = empty( $parameter_info[ 'value' ] ) ? rgar( $parameter_info, 'key_value' ) : $parameter_info[ 'value' ];
						$request_body[ $number ][ 'custom_key' ] = empty( $parameter_info[ 'custom_key' ] ) ? rgar( $parameter_info, 'key_name' ) : $parameter_info[ 'custom_key' ];

						unset( $request_body[ $number ][ 'key_name' ] );
						unset( $request_body[ $number ][ 'key_value' ] );
						unset( $request_body[ $number ][ 'custom' ] );

					}

					$feed[ 'meta' ][ 'request_body' ] = $request_body;

					$this->update_feed_meta( $feed[ 'id' ], $feed[ 'meta' ] );

				}

			}
		}

	}

	/**
	 * Update current feeds with new required request settings
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function update_current_feeds_with_new_settings() {

		$forms = GFAPI::get_forms();


		foreach ( $forms as $form ) {

			$feeds = $this->get_feeds( $form[ 'id' ] );

			if ( $feeds ) {

				foreach ( $feeds as $feed ) {

					if ( empty( $feed[ 'meta' ][ 'request_method' ] ) ) {

						$feed[ 'meta' ][ 'request_method' ] = 'POST';

					}

					if ( empty( $feed[ 'meta' ][ 'request_auth' ] ) ) {

						$feed[ 'meta' ][ 'request_auth' ] = ( empty( $feed[ 'meta' ][ 'bearer_auth_token' ] ) ) ? 'none' : 'bearer';

					}

					if ( empty( $feed[ 'meta' ][ 'request_headers' ] ) ) {

						$feed[ 'meta' ][ 'request_headers' ] = '';

					}

					$this->update_feed_meta( $feed[ 'id' ], $feed[ 'meta' ] );

				}

			}

		}

	}

	/**
	 * @see    GFAddOn::init
	 *
	 * @since  0.1
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function init() {

		parent::init();

		$this->add_delayed_payment_support(
			array(
				'option_label' => __( 'Take Send to Third Party action only when a payment is received.', 'gravityplus-third-party-post' )
			)
		);
	}

	/**
	 * @see    GFFeedAddOn::can_duplicate_feed
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array|int $id
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return true;

	}

	/**
	 * @see    GFFeedAddOn::feed_settings_fields
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_settings_fields() {

		$feed_field_name = array(
			'label'    => __( 'Name', 'gravityplus-third-party-post' ),
			'type'     => 'text',
			'name'     => 'feedName',
			'tooltip'  => __( 'Name for this feed', 'gravityplus-third-party-post' ),
			'class'    => 'medium',
			'required' => true
		);

		$feed_field_request_method = array(
			'label'         => __( 'Method', 'gravityplus-third-party-post' ),
			'type'          => 'select',
			'name'          => 'request_method',
			'choices'       => $this->get_request_method_choices(),
			'default_value' => 'POST',
			'required'      => true
		);

		$feed_field_api_url = array(
			'label'      => __( 'API URL', 'gravityplus-third-party-post' ),
			'type'       => 'text',
			'input_type' => 'url',
			'name'       => 'api_url',
			'tooltip'    => __( 'Enter the third-party API URL where the data will be posted. For example, MailChimp is: https://us2.api.mailchimp.com/2.0/lists/subscribe.json', 'gravityplus-third-party-post' ),
			'class'      => 'medium',
			'required'   => true
		);

		$feed_field_authorization = array(
			'label'         => __( 'Authorization', 'gravityplus-third-party-post' ),
			'type'          => 'select',
			'name'          => 'request_auth',
			'choices'       => $this->get_request_authorization_choices(),
			'default_value' => 'none',
			'required'      => true,
			'onchange'      => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );"
		);

		$feed_field_bearer_auth_token = array(
			'label'      => __( 'Token', 'gravityplus-third-party-post' ),
			'type'       => 'text',
			'name'       => 'bearer_auth_token',
			'tooltip'    => __( 'Enter the bearer authorization token that should be included in the request header. Most often, this is something like an API key.', 'gravityplus-third-party-post' ),
			'class'      => 'medium',
			'required'   => true,
			'dependency' => array(
				'field'  => 'request_auth',
				'values' => array( 'bearer' )
			)
		);

		$feed_field_basic_auth_username = array(
			'label'      => __( 'Username', 'gravityplus-third-party-post' ),
			'type'       => 'text',
			'name'       => 'basic_auth_username',
			'class'      => 'medium',
			'required'   => true,
			'dependency' => array(
				'field'  => 'request_auth',
				'values' => array( 'basic' )
			)
		);

		$feed_field_basic_auth_password = array(
			'label'      => __( 'Password', 'gravityplus-third-party-post' ),
			'type'       => 'text',
			'input_type' => 'password',
			'name'       => 'basic_auth_pass',
			'class'      => 'medium',
			'dependency' => array(
				'field'  => 'request_auth',
				'values' => array( 'basic' )
			)
		);

		$feed_field_request_headers = array(
			'label'          => __( 'Headers', 'gravityplus-third-party-post' ),
			'type'           => 'dynamic_field_map',
			'name'           => 'request_headers',
			'disable_custom' => false
		);

		$feed_field_request_format = array(
			'label'         => __( 'Format', 'gravityplus-third-party-post' ),
			'type'          => 'select',
			'name'          => 'request_format',
			'choices'       => $this->get_request_format_choices(),
			'default_value' => 'default',
			'required'      => true,
			'onchange'      => "jQuery(this).parents('form').submit();jQuery( this ).parents( 'form' ).find(':input').prop('disabled', true );"
		);

		$feed_field_request_body = array(
			'label'          => __( 'Map API Parameters to Form Fields', 'gravityplus-third-party-post' ),
			'type'           => 'dynamic_field_map',
			'name'           => 'request_body',
			'disable_custom' => false,
			'required'       => true,
			'dependency'     => array(
				'field'  => 'request_format',
				'values' => array( '', 'default', 'JSON', 'XML' )
			)
		);

		$feed_field_request_body_raw = array(
			'label'      => __( 'Request Data', 'gravityplus-third-party-post' ),
			'type'       => 'textarea',
			'name'       => 'request_body_raw',
			'required'   => true,
			'use_editor' => false,
			'class'      => 'merge-tag-support mt-position-right mt-hide_all_fields mt-option-url',
			'style'      => 'width: 50%;height:100px;',
			'dependency' => array(
				'field'  => 'request_format',
				'values' => array( 'raw' )
			)
		);

		$feed_field_conditional_logic = array(
			'name'    => 'conditionalLogic',
			'label'   => __( 'Conditional Logic', 'gravityplus-third-party-post' ),
			'type'    => 'feed_condition',
			'tooltip' => '<h6>' . __( 'Conditional Logic', 'gravityplus-third-party-post' ) . '</h6>' . __( 'When conditions are enabled, form submissions will only be posted to the third-party URL when the conditions are met. When disabled, all form submissions will be posted to third-party URL.', 'gravityplus-third-party-post' )
		);

		$sections = array(
			array(
				'title'  => __( 'Feed Name', 'gravityplus-third-party-post' ),
				'fields' => array(
					$feed_field_name
				)
			),
			array(
				'title'  => __( 'API Connection Details', 'gravityplus-third-party-post' ),
				'fields' => array(
					$feed_field_request_method,
					$feed_field_api_url,
					$feed_field_authorization,
					$feed_field_bearer_auth_token,
					$feed_field_basic_auth_username,
					$feed_field_basic_auth_password,
					$feed_field_request_headers
				)
			),
			array(
				'title'  => __( 'API Parameters', 'gravityplus-third-party-post' ),
				'fields' => array(
					$feed_field_request_format,
					$feed_field_request_body,
					$feed_field_request_body_raw
				)
			),
			array(
				'title'  => __( 'Conditional Logic', 'gravityplus-third-party-post' ),
				'fields' => array(
					$feed_field_conditional_logic
				)
			)
		);

		return $sections;
	}

	/**
	 * Get request method options to display in settings_select field
	 *
	 * TODO allow these to be filterable
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_request_method_choices() {

		$this->log_debug( __METHOD__ );

		return array(
			array(
				'label' => __( 'POST', 'gravityplus-third-party-post' ),
				'value' => 'POST'
			),
			array(
				'label' => __( 'GET', 'gravityplus-third-party-post' ),
				'value' => 'GET'
			),
			array(
				'label' => __( 'PUT', 'gravityplus-third-party-post' ),
				'value' => 'PUT'
			),
			array(
				'label' => __( 'DELETE', 'gravityplus-third-party-post' ),
				'value' => 'DELETE'
			)
		);

	}

	/**
	 * Get request authorization options to display in settings_select field
	 *
	 * TODO allow these to be filterable
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_request_authorization_choices() {

		$this->log_debug( __METHOD__ );

		return array(
			array(
				'label' => __( 'None', 'gravityplus-third-party-post' ),
				'value' => 'none'
			),
			array(
				'label' => __( 'Bearer/Token', 'gravityplus-third-party-post' ),
				'value' => 'bearer'
			),
			array(
				'label' => __( 'Basic', 'gravityplus-third-party-post' ),
				'value' => 'basic'
			)
		);

	}

	/**
	 * Get request format options to display in settings_select field
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	private function get_request_format_choices() {

		$this->log_debug( __METHOD__ );

		return array(
			array(
				'label' => __( 'Default', 'gravityplus-third-party-post' ),
				'value' => 'default'
			),
			array(
				'label' => __( 'JSON', 'gravityplus-third-party-post' ),
				'value' => 'JSON'
			),
			/*array(
				'label' => __( 'XML', 'gravityplus-third-party-post' ),
				'value' => 'XML'
			),*/
			array(
				'label' => __( 'Raw', 'gravityplus-third-party-post' ),
				'value' => 'raw'
			)
		);

	}

	/**
	 * @see       GFAddOn::get_field_map_choices
	 *
	 * @see       GFPDF_Core_Model::detail_pdf_link()
	 *
	 * @since     1.1.0
	 *
	 * @author    Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $form_id
	 * @param null $field_type
	 * @param null $exclude_field_types
	 *
	 * @return array
	 */
	public static function get_field_map_choices( $form_id, $field_type = null, $exclude_field_types = null ) {

		$fields = parent::get_field_map_choices( $form_id, $field_type, $exclude_field_types );

		if ( class_exists( 'GFPDF_Core_Model' ) && GFPDF_Core_Model::is_fully_installed() ) {

			global $gfpdf;

			$template = $gfpdf->get_template( $form_id );

			$index = GFPDF_Core_Model::check_configuration( $form_id, $template );

			$templates = $gfpdf->get_form_configuration( $form_id );

			if ( ! empty( $templates ) ) {

				foreach ( $templates as $id => $template ) {

					$template_name = ( '.php' == substr( $template[ 'template' ], - 4 ) ) ? substr( $template[ 'template' ], 0, - 4 ) : $template[ 'template' ];

					$fields[] = array(
						'value' => "gfpdf_{$id}",
						'label' => __( 'PDF', 'gravityplus-third-party-post' ) . ': ' . $template_name
					);

				}
			}
		}

		return $fields;
	}

	/**
	 * @see    GFFeedAddOn::feed_list_columns
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function feed_list_columns() {

		return array(
			'feedName' => __( 'Name', 'gravityplus-third-party-post' )
		);

	}

	/**
	 * Post selected data to third-party API after form submission
	 *
	 * @since 1.0.0
	 *
	 * @param array $feed
	 * @param array $entry
	 * @param array $form
	 */
	public function process_feed( $feed, $entry, $form ) {

		$this->log_debug( 'Starting to process feed' );

		$this->form = $form;

		$this->post_data_to_external_api( $feed, $entry, $form );

	}

	/**
	 * Get data and post to third-party API
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param array $feed
	 * @param array $entry
	 */
	private function post_data_to_external_api( $feed, $entry, $form ) {

		$this->request[ 'api_url' ] = (string) $this->get_setting( 'api_url', '', $feed[ 'meta' ] );

		$this->request[ 'method' ] = (string) $this->get_setting( 'request_method', '', $feed[ 'meta' ] );

		$this->get_request_headers( $feed, $entry, $form );

		$this->get_request_body( $feed, $entry, $form );

		$this->format_request_body( $feed, $entry, $form );

		$this->log_debug( 'Posting the following data to third-party API: ' . print_r( $this->request, true ) );

		if ( $this->delay_post ) {

			$this->log_debug( "Delaying post: {$this->delay_reason}" );

		} else {

			$this->send_request();

			$this->remove_temp_files();

		}

	}

	/**
	 * Send request
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function send_request() {

		$this->log_debug( 'Sending request...' );

		$arguments[ 'body' ] = $this->request[ 'body' ];

		if ( ! empty( $this->request[ 'headers' ] ) ) {

			$arguments[ 'headers' ] = $this->request[ 'headers' ];

		}

		$arguments[ 'timeout' ] = 30;

		switch ( $this->request[ 'method' ] ) {

			case 'GET':

				$raw_response = wp_remote_get( $this->request[ 'api_url' ], $arguments );

				break;

			case 'POST':

				$raw_response = wp_remote_post( $this->request[ 'api_url' ], $arguments );

				break;

			default:

				$raw_response = wp_remote_request( $this->request[ 'api_url' ], array_merge( array( 'method' => $this->request[ 'method' ] ), $arguments ) );

				break;
		}

		if ( is_wp_error( $raw_response ) || ( 200 != wp_remote_retrieve_response_code( $raw_response ) ) ) {

			$this->log_error( 'Error posting to third-party API' . print_r( $raw_response, true ) );

		} else {

			$this->response = /*(array) (*/
				wp_remote_retrieve_body( $raw_response ) /*)*/
			;

			$this->log_debug( "Success." . print_r( $this->response, true ) );

		}

	}

	/**
	 * Get response from third-party API
	 *
	 * @since  1.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array
	 */
	public function get_response() {

		return $this->response;

	}

	/**
	 * Get request headers
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 * @param $entry
	 * @param $form
	 */
	private function get_request_headers( $feed, $entry, $form ) {

		$this->get_request_authorization( $feed );

		$this->get_custom_request_headers( $feed, $entry, $form );

	}

	/**
	 * Get request authorization and add it to the request header
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 */
	private function get_request_authorization( $feed ) {

		$auth = $this->get_setting( 'request_auth', '', $feed[ 'meta' ] );

		switch ( $auth ) {

			case 'bearer':

				$token = (string) $this->get_setting( 'bearer_auth_token', '', $feed[ 'meta' ] );

				if ( ! empty( $token ) ) {

					$this->request[ 'headers' ] = array( 'Authorization' => "Bearer {$token}" );

				}

				break;

			case 'basic':

				$username = (string) $this->get_setting( 'basic_auth_username', '', $feed[ 'meta' ] );

				$password = (string) $this->get_setting( 'basic_auth_pass', '', $feed[ 'meta' ] );

				$this->request[ 'headers' ] = array( 'Authorization' => 'Basic ' . base64_encode( "{$username}:{$password}" ) );

				break;

		}

	}

	/**
	 * Get custom headers the user added
	 *
	 * @since  1.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 * @param $entry
	 * @param $form
	 */
	private function get_custom_request_headers( $feed, $entry, $form ) {

		$custom_headers = array();


		$request_header_field_ids = $this->get_dynamic_field_map_fields( $feed, 'request_headers' );


		foreach ( $request_header_field_ids as $name => $field_id ) {

			if ( ! empty( $field_id ) ) {

				if ( false === strpos( $field_id, 'gfpdf_' ) ) {

					$custom_headers[ $name ] = $this->get_field_value( $form, $entry, $field_id );

					if ( $field_id == intval( $field_id ) ) {

						$field = GFFormsModel::get_field( $form, $field_id );

						if ( 'signature' == $field->get_input_type() ) {

							$custom_headers[ $name ] = RGFormsModel::get_upload_url_root() . "signatures/{$custom_headers[ $name ]}";

						}

					}

				}

			}

		}

		if ( ! empty( $custom_headers ) ) {

			$this->request[ 'headers' ] = ( empty( $this->request[ 'headers' ] ) ) ? $custom_headers : $this->request[ 'headers' ] + $custom_headers;

		}

	}

	/**
	 * Get request body
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $feed
	 * @param $entry
	 * @param $form
	 *
	 * @return array
	 */
	private function get_request_body( $feed, $entry, $form ) {

		$request_body = array();

		$data_format = (string) $this->get_setting( 'request_format', '', $feed[ 'meta' ] );

		if ( 'raw' !== $data_format ) {

			$nested_param = false;


			$request_body_field_ids = $this->get_dynamic_field_map_fields( $feed, 'request_body' );


			foreach ( $request_body_field_ids as $name => $field_id ) {

				if ( ! empty( $field_id ) ) {

					if ( false === strpos( $field_id, 'gfpdf_' ) ) {

						$field_value = $this->get_field_value( $form, $entry, $field_id );

						if ( false !== strpos( $name, '/' ) ) {

							$nested_param = true;

							$nested_params = explode( '/', $name );

							$this->set_nested_parameter( $request_body, $nested_params, $field_value );

						} else {

							if ( is_numeric( $field_id ) ) {

								$field = GFFormsModel::get_field( $form, $field_id );

								if ( 'number' == $field->get_input_type() ) {

									$field_value += 0;

								}

							}

							$request_body[ $name ] = $field_value;

						}

						if ( is_numeric( $field_id ) ) {

							$field = GFFormsModel::get_field( $form, $field_id );

							if ( 'signature' == $field->get_input_type() ) {

								$signature = RGFormsModel::get_upload_url_root() . "signatures/{$request_body[ $name ]}";

								if ( $nested_param ) {

									$this->set_nested_parameter( $request_body, $nested_params, $signature );

								} else {

									$request_body[ $name ] = $signature;

								}

							}

						}

					} else {

						$request_body[ $name ] = $field_id;

						$this->pdfs[] = str_replace( 'gfpdf_', '', $field_id );

						$delay_post = true;

					}

				}

				unset( $field_value, $nested_params, $field, $signature );

				$nested_param = false;

			}


			if ( ! empty( $delay_post ) ) {

				$this->delay_post = true;

				$this->delay_reason = "Waiting for GravityPDF to generate PDF that needs to be included in the request";


				add_action( 'gform_after_submission', array( $this, 'gform_after_submission' ), 11, 2 );

			}

		} else {

			$request_body = $this->get_setting( 'request_body_raw', '', $feed[ 'meta' ] );

		}


		$this->request[ 'body' ] = $request_body;

	}

	/**
	 * Add nested API parameters to the request body
	 *
	 * @since    1.2.0
	 *
	 * @author   Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $body
	 * @param $parameter_names
	 * @param $value
	 *
	 */
	private function set_nested_parameter( &$body, $parameter_names, $value ) {

		$body_alias = &$body;

		$final_parameter_name = array_pop( $parameter_names );

		foreach ( $parameter_names as $par ) {

			$body_alias = &$body_alias[ $par ];

		}

		$body_alias[ $final_parameter_name ] = $value;
	}

	private function format_request_body( $feed, $entry, $form ) {

		$data_format = (string) $this->get_setting( 'request_format', '', $feed[ 'meta' ] );

		if ( ! empty( $data_format ) ) {

			switch ( $data_format ) {

				case 'JSON':

					$this->request[ 'body' ] = json_encode( $this->request[ 'body' ] );

					break;

				case 'raw':

					$this->request[ 'body' ] = GFCommon::replace_variables( $this->request[ 'body' ], $form, $entry );

					break;

			}

		}

		$this->request[ 'body' ] = apply_filters( 'gravityplus_third_party_post_request_body', $this->request[ 'body' ], $feed, $entry, $form );

	}

	/**
	 * Get PDF files to add to request
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $form
	 *
	 * @return bool
	 */
	private function get_pdfs( $entry, $form ) {

		global $gfpdf, $gfpdfe_data;


		GFPDF_Core_Model::check_configuration( $form[ 'id' ] );

		$config_nodes = $gfpdf->get_form_configuration( $form[ 'id' ] );

		if ( empty( $config_nodes ) ) {

			return false;

		}

		$temp_directory = $this->get_temp_directory();

		foreach ( $config_nodes as $index => $config ) {

			if ( in_array( $index, $this->pdfs ) ) {

				if ( $temp_directory ) {

					$template = ( ! empty( $config[ 'template' ] ) ) ? $config[ 'template' ] : $gfpdf->get_template( $index );

					$pdf_file = $this->get_pdf( $index, $form[ 'id' ], $entry[ 'id' ], $template );

					if ( $pdf_file ) {

						$filename = basename( $pdf_file );

						rename( $pdf_file, "{$temp_directory}{$filename}" );

						$this->add_pdf_to_request( $index, RGFormsModel::get_upload_url_root() . "3pp/{$filename}" );

					} else {

						$this->remove_pdf_from_request( $index );
					}

				} else {

					$this->remove_pdf_from_request( $index );

				}

			}

		}

	}

	/**
	 * Get the PDF file
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $index
	 * @param $form_id
	 * @param $lead_id
	 * @param $template
	 *
	 * @return bool|string
	 */
	private function get_pdf( $index, $form_id, $lead_id, $template ) {

		$this->log_debug( 'Generating and saving PDF' );


		global $gfpdf, $gfpdfe_data;


		remove_all_actions( 'gfpdf_post_pdf_save' );

		remove_all_filters( 'gfpdfe_return_pdf_path' );


		$pdf_arguments = GFPDF_Core_Model::generate_pdf_parameters( $index, $form_id, $lead_id, $template );

		$gfpdf->render->PDF_Generator( $form_id, $lead_id, $pdf_arguments );


		$pdf_file = $gfpdfe_data->template_save_location . $form_id . $lead_id . '/' . $pdf_arguments[ 'pdfname' ];


		if ( file_exists( $pdf_file ) ) {

			return $pdf_file;

		} else {

			return false;
		}

	}

	/**
	 * Get temporary directory for PDFs
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return bool
	 */
	private function get_temp_directory() {

		$temp_directory = RGFormsModel::get_upload_root() . '3pp/';

		if ( is_dir( $temp_directory ) ) {

			return $temp_directory;

		}

		if ( mkdir( $temp_directory ) ) {

			return $temp_directory;

		} else {

			$this->log_error( "Could not create {$temp_directory}" );

			return false;

		}
	}

	/**
	 * Add PDF to request
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $index
	 * @param $pdf
	 */
	private function add_pdf_to_request( $index, $pdf ) {

		foreach ( $this->request[ 'body' ] as $name => $value ) {

			if ( "gfpdf_{$index}" == $value ) {

				$this->log_debug( "Adding {$pdf} to {$name}" );

				$this->request[ 'body' ][ $name ] = $pdf;

				break;
			}

		}

	}

	/**
	 * Remove temporary files
	 *
	 * Leaving some time for the third-party API to access the file, however this means that the files won't be deleted
	 * from the server until another form submission
	 *
	 * TODO is this a valid concern?
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	private function remove_temp_files() {

		$this->log_debug( 'Removing temporary files' );

		$interval = 180;

		if ( $temp_directory = $this->get_temp_directory() ) {

			if ( $handle = opendir( preg_replace( '/\/$/', '', $temp_directory ) ) ) {

				while ( false !== ( $file = readdir( $handle ) ) ) {

					if ( ! is_dir( $file ) && ( ( filemtime( "{$temp_directory}{$file}" ) + $interval ) < time() ) && ( $file != ".." ) && ( $file != "." ) && ( $file != "index.html" ) && ( substr( $file, 0, 1 ) !== '.' ) ) {

						$this->log_debug( "Removing {$file}" );

						unlink( "{$temp_directory}{$file}" );

					}

				}

				closedir( $handle );

			}

		}

	}

	/**
	 * Remove PDF from request
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $index
	 */
	private function remove_pdf_from_request( $index ) {

		foreach ( $this->request[ 'body' ] as $name => $value ) {

			if ( "gfpdf_{$index}" == $value ) {

				$this->log_debug( "Removing {$name} from request" );

				unset( $this->request[ 'body' ][ $name ] );

				break;
			}

		}

	}

	/**
	 * After GF is submitted
	 *
	 * @since  1.1.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 * @param $form
	 */
	public function gform_after_submission( $entry, $form ) {

		$this->get_pdfs( $entry, $form );

		$this->send_request();

		$this->remove_temp_files();

	}

}