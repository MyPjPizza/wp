<?php

/**
 * Process Gravity Forms Add-On feed when an entry is updated
 *
 * Works whether the entry is updated in the admin or via the API
 *
 * @since  2.3.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFPGFU_Process_Feed_Entry_Update {

	/**
	 * GFPGFU_Process_Feed_Entry_Update constructor.
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		$this->add_feed_toggle();

		$this->listen_for_entry_update();

	}

	/**
	 * Add feed toggle
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function add_feed_toggle() {

		add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_action( 'wp_ajax_gf_feed_entry_update_active', array( $this, 'toggle_entry_update_active' ) );

	}

	/**
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function admin_init() {

		$addons = GFPGFU_Helper::get_addons( array( 'GFPaymentAddOn' ) );

		$addon_slugs = array_keys( $addons );

		if ( ( 'gf_edit_forms' == rgget( 'page' ) ) && ( 'settings' == rgget( 'view' ) ) && ( in_array( rgget('subview'), $addon_slugs) ) && (empty( $_GET['fid'])) ) {

			$this->add_toggle( rgget('id'), rgget('subview') );

			add_filter( 'gform_noconflict_scripts', array( $this, 'gform_noconflict_scripts' ) );

		}

	}

	/**
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $scripts
	 *
	 * @return array
	 */
	public function gform_noconflict_scripts( $scripts ) {

		return array_merge( $scripts, array( 'gfp_utility_feed_list' ) );

	}

	/**
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form_id
	 * @param $addon_slug
	 */
	public function add_toggle( $form_id, $addon_slug ) {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'gfp_utility_feed_list', trailingslashit( GFP_GF_UTILITY_URL ) . "tools/process-feed-entry-update/js/feed-list{$suffix}.js", array( 'jquery', 'gform_form_admin' ), GFP_GF_UTILITY_CURRENT_VERSION );

		$feed_list_data = array();

		$feeds = GFPGFU_Helper::get_feeds( $addon_slug, $form_id );

		if ( is_array( $feeds ) ) {

			foreach( $feeds as $feed ) {

				$feed_list_data[] = array( 'id' => $feed['id'], 'process_on_entry_update' => isset( $feed['meta']['process_on_entry_update'] ) ? $feed['meta']['process_on_entry_update'] : 0 );

			}

		}

		$feed_list_js_data = array( 'feeds' => $feed_list_data, 'active_img' => GFCommon::get_base_url() . '/images/active1.png', 'inactive_img' => GFCommon::get_base_url() . '/images/active0.png' );

		wp_localize_script( 'gfp_utility_feed_list', 'gfp_utility_feed_list', $feed_list_js_data );
	}

	/**
	 * Toggle feed's entry update status
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function toggle_entry_update_active() {
		
		$feed_id   = rgpost( 'feed_id' );
		
		$is_active = rgpost( 'is_active' );
		
		$feed = GFPGFU_Helper::get_feed( $feed_id );

		if ( ! $feed ) {

			wp_send_json_error();

		}
		else {

			$feed[ 'meta' ][ 'process_on_entry_update' ] = $is_active;

			$result = GFAPI::update_feed( $feed_id, $feed[ 'meta' ] );

			if ( is_wp_error( $result ) || ! $result ) {

				wp_send_json_error();

			} else {

				wp_send_json_success();

			}

		}

	}

	/**
	 * Listen for entry update actions
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function listen_for_entry_update() {

		add_action( 'gform_after_update_entry', array( $this, 'gform_after_update_entry' ), 10, 2 );

		add_action( 'gform_post_update_entry', array( $this, 'gform_post_update_entry' ) );


	}

	/**
	 * Fires when entry is updated in the admin or with GravityView on the frontend
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $form
	 * @param $entry_id
	 */
	public function gform_after_update_entry( $form, $entry_id ) {

		GFP_GF_Utility_Logging::log_debug( __METHOD__ );

		if ( /*is_admin() ||*/ ! class_exists( 'GFCommon' ) || ! class_exists( 'GFAPI' ) ) {

			return;

		}

		$entry = GFAPI::get_entry( $entry_id );

		$this->process_feeds( $entry, $form );

	}

	/**
	 * Fires when entry is updated through the API
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $entry
	 */
	public function gform_post_update_entry( $entry ) {

		GFP_GF_Utility_Logging::log_debug( __METHOD__ );

		if ( /*! is_admin() ||*/ ! class_exists( 'GFCommon' ) || ! class_exists( 'GFAPI' ) ) {

			return;

		}

		$form = GFAPI::get_form( $entry[ 'form_id' ] );

		$this->process_feeds( $entry, $form );

	}

	/**
	 * Only process feeds that were selected for entry update
	 *
	 * @since 2.3.0
	 *
	 * @param $feeds
	 *
	 * @return mixed
	 */
	public function gform_addon_pre_process_feeds( $feeds ) {

		foreach ( $feeds as $key => $feed ) {

			if ( empty( $feed['meta'][ 'process_on_entry_update' ] ) ) {

				unset( $feeds[ $key ] );

			}

		}

		return $feeds;
	}

	/**
	 * Process Gravity Forms Add-On feeds for an entry
	 *
	 * @since  2.3.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 *
	 */
	function process_feeds( $entry, $form ) {

		$addons = GFPGFU_Helper::get_addons( array( 'GFPaymentAddOn' ) );

		GFP_GF_Utility_Logging::log_debug( 'Addons: ' . print_r( $addons, true ) );

		if ( ! empty( $addons ) ) {

			foreach ( $addons as $slug => $addon_data ) {

				$callable = array( $addon_data[ 'class' ], 'get_instance' );

				if ( is_callable( $callable ) ) {

					add_filter( "gform_{$slug}_pre_process_feeds", array( $this, 'gform_addon_pre_process_feeds' ) );

					/**
					 * @var GFFeedAddOn $addon_instance
					 */
					$addon_instance = call_user_func( $callable );

					$addon_instance->maybe_process_feed( $entry, $form );

				}

			}

		}

	}

}

$gfpgfu_process_feed_entry_update = new GFPGFU_Process_Feed_Entry_Update();