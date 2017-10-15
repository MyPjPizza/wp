<?php
/**
 * Upgrade Routine 2
 *
 * @package     PUM_AVM
 * @subpackage  Admin/Upgrades
 * @copyright   Copyright (c) 2016, WP Popup Maker
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since       1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_AVM_Upgrade_Routine_2
 */
final class PUM_AVM_Upgrade_Routine_2 {

	/**
	 * @return string|void
	 */
	public static function description() {
		return __( 'Update your popup age verification settings.', 'popup-maker-age-verification-modals' );
	}

	/**
	 *
	 */
	public static function run() {
		ignore_user_abort( true );

		if ( ! pum_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			@set_time_limit( 0 );
		}

		static::process_popups();
		static::cleanup_old_data();
	}

	/**
	 * Migrate form single age verification meta to various triggers & cookies.
	 */
	public static function process_popups() {
		global $wpdb;

		$popups = get_posts( array(
			'post_type'      => 'popup',
			'post_status'    => array( 'any', 'trash' ),
			'posts_per_page' => -1,
		) );

		if ( ! function_exists( 'popmake_get_popup_age_verification' ) ) {
			include_once PUM_AVM::$DIR . 'deprecated/includes/popup-functions.php';
		}

		foreach ( $popups as $popup ) {

			$popup = pum_popup( $popup->ID );

			$age_verification = popmake_get_popup_age_verification( $popup->ID );

			if ( ! $age_verification || empty( $age_verification['enabled'] ) || ! $age_verification['enabled'] ) {
				continue;
			}

			$triggers = $popup->get_triggers();

			$cookies = $popup->get_cookies();

			// Empty placeholder arrays.
			$_triggers = $_cookies = array();

			// Set the new cookie name.
			$cookie_name = 'popmake-ageverification-' . $popup->ID;

			// Append the cookie key if set.
			if ( ! empty( $age_verification['cookie_key'] ) ) {
				$cookie_name .= '-' . $age_verification['cookie_key'];
			}

			// Add the new cookie to the cookies array.
			$_cookies[] = array(
				'event'    => 'age_verified',
				'settings' => array(
					'name'    => $cookie_name,
					'key'     => '',
					'time'    => $age_verification['cookie_time'],
					'path'    => isset( $age_verification['cookie_path'] ) ? 1 : 0,
					'session' => isset( $age_verification['session_cookie'] ) ? 1 : 0,
				),
			);

			$_triggers[] = array(
				'type'     => 'age_verification',
				'settings' => array(
					'cookie' => array(
						'name' => $cookie_name,
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

			$type = $age_verification['type'];

			$new_shortcode = '[pum_age_form type="' . $type . '"';

			switch ( $type ) {
				case 'enterexit':
					$new_shortcode .= ' exit_url="' . $age_verification['exiturl'] . '"';
					break;
				case 'birthdate':
					$new_shortcode .= ' disable_date_input="1" required_age="' . $age_verification['required_age'] . '" exit_url="' . $age_verification['exiturl'] . '"';
					break;
			}

			$new_shortcode .= ']';

			$content = $popup->post_content;

			if ( strpos( $content, "[pum_age_form" ) !== false ) {
				continue;
			}

			if ( strpos( $content, "[age_verification]" ) !== false ) {
				$content = str_replace( '[age_verification]', $new_shortcode, $content );
			} else {
				if ( $content != '' ) {
					$content .= "\n\n";
				}
				$content .= $new_shortcode;
			}

			update_post_meta( $popup->ID, 'popup_triggers', $triggers );

			update_post_meta( $popup->ID, 'popup_cookies', $cookies );

			if ( $content != $popup->post_content ) {
				$wpdb->update( $wpdb->posts, array( 'post_content' => $content ), array( 'ID' => $popup->ID ), array( '%s' ), array( '%d') );
			}
		}

	}

	/**
	 * Clean up old meta keys.
	 */
	public static function cleanup_old_data() {
		global $wpdb;

		$meta_keys = array(
			'popup_age_verification',
			'popup_age_verification_enabled',
			'popup_age_verification_type',
			'popup_age_verification_required_age',
			'popup_age_verification_exiturl',
			'popup_age_verification_cookie_time',
			'popup_age_verification_cookie_path',
			'popup_age_verification_defaults_set',
		);

		$meta_keys = implode( "','", $meta_keys );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key IN('$meta_keys');" );
	}
}