<?php

/**
 * Manually Process Feeds
 *
 * Manually process a Gravity Forms add-on feed
 *
 * @since 2.2.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Manually_Process_Feeds {

	/**
	 * GFPGFU_Manually_Process_Feeds constructor.
	 */
	public function __construct() {

		if ( 'entry_list' == GFForms::get_page() ) {
			
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

		add_action( 'wp_ajax_gf_process_feeds', array( $this, 'process_feeds' ) );


	}

	/**
	 * //TODO, as of WordPress 4.7
	 * 
	 * @since 2.2.0
	 *        
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>       
	 *
	 * @param $actions
	 *
	 * @return mixed
	 */
	public function bulk_actions_forms_page_gf_entries( $actions ) {

		$actions['process_feeds'] = esc_html__( 'Process Feeds', 'gravityplus-gfutility' );

		return $actions;
	}

	/**
	 * @since 2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_enqueue_scripts() {

		$form_id = rgget( 'id' );
		
		$form = GFAPI::get_form( $form_id );
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_utility_manually_process_feeds', GFP_GF_UTILITY_URL . "tools/manually-process-feeds/js/manually-process-feeds{$suffix}.js", array( 'jquery' ), GFP_GF_UTILITY_CURRENT_VERSION );

		wp_localize_script( 'gfp_utility_manually_process_feeds', 'process_feeds', array(
			'nonce' => wp_create_nonce( 'gf_process_feeds' ),
			'form_id' => $form_id,
			'modal_html' => $this->get_modal( $form ),
			'bulk_actions' => $this->get_bulk_actions( $form_id ),
			'no_feeds_selected' => esc_html__( 'You must select at least one feed to process.', 'gravityplus-gfutility' ),
			'success_message' => __( 'Feeds for %s were processed successfully.', 'gravityplus-gfutility' ),
			'entries_string' => __( 'entries', 'gravityplus-gfutility' ),
			'entry_string' => __( 'entry', 'gravityplus-gfutility' ),
			'modal_caption' => esc_html__('Process Feeds', 'gravityplus-gfutility')
		) );
	}

	/**
	 * Add redact JS to noconflict scripts
	 *
	 * @since 2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $noconflict_scripts
	 *
	 * @return array
	 */
	public static function gform_noconflict_scripts( $noconflict_scripts ) {

		$noconflict_scripts = array_merge( $noconflict_scripts, array( 'gfp_utility_manually_process_feeds' ) );

		return $noconflict_scripts;

	}

	/**
	 * @since 2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 *
	 * @return array
	 */
	private function get_bulk_actions( $form_id ) {

		$bulk_actions = array(
			array('value' => 'process_feeds', 'label' => esc_html__( 'Process Feeds', 'gravityplus-gfutility' ) ) );


		return $bulk_actions;
	}

	/**
	 * @since 2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form
	 *
	 * @return string
	 */
	private function get_modal( $form ) {

		$addons = GFPGFU_Helper::get_addons( array( 'GFPaymentAddOn' ) );

		$feeds = array();

		foreach( $addons as $slug => $addon_data ) {

			$addon_feeds = GFAPI::get_feeds( null, $form['id'], $slug );

			if ( is_array( $addon_feeds ) ) {

				$feeds = array_merge( $feeds, $addon_feeds );
			}

		}

		ob_start();
		
		include( GFP_GF_UTILITY_PATH . 'tools/manually-process-feeds/views/modal.php' );

		$modal = ob_get_contents();

		ob_end_clean();
		
		
		return $modal;
	}

	/**
	 * @since 2.2.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function process_feeds() {

		GFP_GF_Utility_Logging::log_debug( __METHOD__ );

		check_admin_referer( 'gf_process_feeds', 'gf_process_feeds' );
		
		$form_id = absint( rgpost( 'formId' ) );

		GFP_GF_Utility_Logging::log_debug( "Form ID: {$form_id}" );
		
		$entries   = rgpost( 'leadIds' );

		GFP_GF_Utility_Logging::log_debug( 'Entries: ' . print_r( $entries, true ) );

		$entries = ! is_array( $entries ) ? array( $entries ) : $entries;

		$form = GFAPI::get_form( $form_id );

		if ( empty( $entries ) || empty( $form ) ) {
			
			esc_html_e( 'There was an error while processing the feeds.', 'gravityplus-gfutility' );
			
			wp_send_json_error();
		
		};

		$feeds = json_decode( rgpost( 'feeds' ) );

		GFP_GF_Utility_Logging::log_debug( 'Feeds: ' . print_r( $feeds, true ) );

		if ( ! is_array( $feeds ) ) {

			wp_send_json_error( esc_html__( 'No feeds have been selected. Please select a feed to be processed.', 'gravityplus-gfutility' ) );
		
		}

		$addons = GFPGFU_Helper::get_addons( array( 'GFPaymentAddOn' ) );

		GFP_GF_Utility_Logging::log_debug( 'Addons: ' . print_r( $addons, true ) );

		if ( ! empty( $addons ) ) {

			foreach ( $entries as $entry_id ) {

				$entry = GFAPI::get_entry( $entry_id );

				foreach ( $feeds as $feed_id ) {

					$feed = GFAPI::get_feeds( $feed_id );

					if ( is_array( $feed ) ) {

						$feed = $feed[ 0 ];

						$callable = array( $addons[ $feed['addon_slug'] ]['class'], 'get_instance' );

						if ( is_callable( $callable ) ) {

							/**
							 * @var GFFeedAddOn $addon_instance
							 */
							$addon_instance = call_user_func( $callable );

							$addon_instance->process_feed( $feed, $entry, $form );

						}

					} else {

						GFP_GF_Utility_Logging::log_error( "Error retrieving {$feed_id}: $feed" );
					}

				}
			}

		}

		wp_send_json_success();
	}

}

if ( class_exists('GFFeedAddon') ) {

	$gfpgfu_manually_process_feeds = new GFPGFU_Manually_Process_Feeds();

}