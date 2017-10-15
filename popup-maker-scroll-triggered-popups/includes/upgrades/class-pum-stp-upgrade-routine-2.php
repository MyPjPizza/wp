<?php
/**
 * Upgrade Routine 2
 *
 * @package     PUM
 * @subpackage  Admin/Upgrades
 * @copyright   Copyright (c) 2016, WP Popup Maker
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since       1.4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_STP_Upgrade_Routine_2
 */
final class PUM_STP_Upgrade_Routine_2 {

	public static function description() {
		return __( 'Update your popups scroll trigger settings.', 'popup-maker' );
	}

	public static function run() {
		ignore_user_abort( true );

		if ( ! pum_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			@set_time_limit( 0 );
		}

		static::process_popups();
		static::cleanup_old_data();
	}

	public static function process_popups() {

		$popups = get_posts( array(
			'post_type'      => 'popup',
			'post_status'    => array( 'any', 'trash' ),
			'posts_per_page' => - 1,
		) );

		if ( ! function_exists( 'popmake_get_popup_scroll_triggered' ) ) {
			include_once PUM_STP::$DIR . 'deprecated/includes/functions.php';
		}

		foreach ( $popups as $popup ) {

			$popup = pum_popup( $popup->ID );

			$scroll_trigger = popmake_get_popup_scroll_triggered( $popup->ID );

			if ( ! $scroll_trigger || empty( $scroll_trigger['enabled'] ) || ! $scroll_trigger['enabled'] ) {
				continue;
			}

			$triggers = $popup->get_triggers();

			$cookies = $popup->get_cookies();

			// Empty placeholder arrays.
			$_triggers = $_cookies = array();

			// Set the new cookie name.
			$cookie_name = 'popmake-scroll-triggered-' . $popup->ID;

			// Append the cookie key if set.
			if ( ! empty( $scroll_trigger['cookie_key'] ) ) {
				$cookie_name .= '-' . $scroll_trigger['cookie_key'];
			}

			// Store cookie_trigger for reuse.
			$cookie_trigger = $scroll_trigger['cookie_trigger'];

			// Create empty trigger cookie in case of disabled trigger.
			$trigger_cookie = null;

			// If cookie trigger not disabled create a new cookie and add it to the auto open trigger.
			if ( $cookie_trigger != 'disabled' ) {

				// Add the new cookie to the auto open trigger.
				$trigger_cookie = array( $cookie_name );

				// Set the event based on the original option.
				switch ( $cookie_trigger ) {
					case 'close':
						$event = 'on_popup_close';
						break;
					case 'open':
						$event = 'on_popup_close';
						break;
					default:
						$event = $cookie_trigger;
						break;
				}

				// Add the new cookie to the cookies array.
				$_cookies[] = array(
					'event'    => $event,
					'settings' => array(
						'name'    => $cookie_name,
						'key'     => '',
						'time'    => $scroll_trigger['cookie_time'],
						'path'    => isset( $scroll_trigger['cookie_path'] ) ? 1 : 0,
						'session' => isset( $scroll_trigger['session_cookie'] ) ? 1 : 0,
					),
				);
			}

			// Add the new auto open trigger to the triggers array.
			$_triggers[] = array(
				'type'     => 'scroll',
				'settings' => array(
					'trigger'         => ! empty( $scroll_trigger['trigger'] ) ? $scroll_trigger['unit'] : 'trigger',
					'trigger_point'   => ! empty( $scroll_trigger['trigger_point'] ) ? $scroll_trigger['trigger_point'] : '',
					'distance'        => ! empty( $scroll_trigger['distance'] ) ? absint( $scroll_trigger['distance'] ) : 75,
					'unit'            => ! empty( $scroll_trigger['unit'] ) ? $scroll_trigger['unit'] : '%',
					'trigger_element' => ! empty( $scroll_trigger['trigger_element'] ) ? $scroll_trigger['trigger_element'] : '',
					'close_on_up'     => ! empty( $scroll_trigger['close_on_up'] ) ? $scroll_trigger['close_on_up'] : null,
					'cookie'          => array(
						'name' => $trigger_cookie,
					),
				),
			);

			foreach ( $_cookies as $cookie ) {
				$cookie['settings'] = PUM_Cookies::instance()->validate_cookie( $cookie['event'], $cookie['settings'] );
				$cookies[]          = $cookie;
			}

			foreach ( $_triggers as $trigger ) {
				$trigger['settings'] = PUM_Triggers::instance()->validate_trigger( $trigger['type'], $trigger['settings'] );
				$triggers[]          = $trigger;
			}

			update_post_meta( $popup->ID, 'popup_triggers', $triggers );

			update_post_meta( $popup->ID, 'popup_cookies', $cookies );
		}

	}

	public static function cleanup_old_data() {
		global $wpdb;

		$meta_keys = array(
			'popup_scroll_triggered',
			'popup_scroll_triggered_enabled',
			'popup_scroll_triggered_trigger',
			'popup_scroll_triggered_trigger_point',
			'popup_scroll_triggered_distance',
			'popup_scroll_triggered_unit',
			'popup_scroll_triggered_trigger_element',
			'popup_scroll_triggered_close_on_up',
			'popup_scroll_triggered_cookie_trigger',
			'popup_scroll_triggered_cookie_time',
			'popup_scroll_triggered_cookie_path',
			'popup_scroll_triggered_cookie_key',
			'popup_scroll_triggered_defaults_set'
		);

		$meta_keys = implode( "','", $meta_keys );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key IN('$meta_keys');" );
	}

}
