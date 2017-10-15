<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main PUM_ALM_Popup class
 *
 * @since       1.2.0
 */
class PUM_ALM_Popup {

	/**
	 * Initialize Hooks & Filters
	 */
	public static function init() {
		add_filter( 'pum_popup_get_classes', array( __CLASS__, 'get_classes' ), 10, 2 );
		add_filter( 'pum_popup_get_close', array( __CLASS__, 'get_close' ), 10, 2 );
		add_filter( 'pum_popup_show_close_button', array( __CLASS__, 'show_close' ), 10, 2 );
	}

	public static function get_close( $close, $popup_id ) {

		if ( self::force_login( $popup_id ) ) {
			$close['esc_press']     = false;
			$close['overlay_click'] = false;
		}

		return $close;
	}

	/**
	 * Checks if forced login is enabled for the popup.
	 *
	 * @param $popup_id
	 *
	 * @return bool|array
	 */
	public static function force_login( $popup_id ) {
		$popup = pum_popup( $popup_id );

		foreach ( $popup->get_triggers() as $trigger ) {
			if ( $trigger['type'] == 'force_login' ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Hides the close button if needed.
	 *
	 * @param $show
	 * @param $popup_id
	 *
	 * @return bool
	 */
	public static function show_close( $show, $popup_id ) {

		if ( self::force_login( $popup_id ) ) {
			return false;
		}

		return $show;
	}

	/**
	 * Adds additional classes to the popup.
	 *
	 * @param $classes
	 * @param $popup_id
	 *
	 * @return array
	 */
	public static function get_classes( $classes, $popup_id ) {

		$forms = self::has_forms( $popup_id );

		if ( ! $forms ) {
			return $classes;
		}

		if ( $forms['login'] ) {
			$classes['overlay'][] = 'ajax-login';
			$classes['overlay'][] = 'pum-alm-login';
			$classes['overlay'][] = 'ajax-login';
		}

		if ( $forms['registration'] ) {
			$classes['overlay'][] = 'ajax-registration';
		}

		if ( $forms['recovery'] ) {
			$classes['overlay'][] = 'ajax-recovery';
		}

		return $classes;
	}

	/**
	 * Checks if alm forms are enabled for the popup.
	 *
	 * @param $popup_id
	 *
	 * @return bool|array
	 */
	public static function has_forms( $popup_id ) {
		$popup = pum_popup( $popup_id );

		$enabled = array(
			'login'        => false,
			'registration' => false,
			'recovery'     => false,
		);

		if ( has_shortcode( $popup->content, 'pum_login_form' ) ) {
			$enabled['login'] = true;
		}

		if ( has_shortcode( $popup->content, 'pum_registration_form' ) ) {
			$enabled['registration'] = true;
		}

		if ( has_shortcode( $popup->content, 'pum_recovery_form' ) ) {
			$enabled['recovery'] = true;
		}

		if ( ! $enabled['login'] && ! $enabled['registration'] && ! $enabled['recovery'] ) {
			return false;
		}

		return $enabled;
	}
}
