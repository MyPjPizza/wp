<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PUM_ALM Admin class
 *
 * @since       1.2.0
 */
class PUM_ALM_Migration {

	/**
	 * Initialization
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'process_updates' ) );
	}

	/**
	 * Used to check for and process individual updates.
	 */
	public static function process_updates() {

		$dep_version = get_option( 'popmake_alm_version', false );
		$version     = get_option( 'pum_alm_version', false );

		if ( ! $version && $dep_version ) {
			$version = $dep_version;
		}

		if ( ! $version ) {
			$version = PUM_ALM::$VER;
		}

		if ( version_compare( PUM_ALM::$VER, $version, '>' ) ) {
			update_option( 'pum_alm_version', $version );
		}

		$v  = PUM_ALM::$DB_VER;
		$cv = get_option( 'pum_alm_db_ver', false );

		if ( ! $cv || $cv < PUM_ALM::$DB_VER ) {


			if ( ! $cv ) {
				if ( version_compare( $version, '1.1.0', '<' ) ) {
					$cv = 1;
				}

				if ( version_compare( $version, '1.1.0', '>=' ) ) {
					$cv = 2;
				}

				if ( version_compare( $version, '1.2.0', '>=' ) ) {
					$cv = 3;
				}
			}

			for ( ; $v > $cv; $cv ++ ) {
				PUM_ALM_Migration::run( $cv );
			}

		}

	}


	/**
	 * Runs a specific update.
	 *
	 * @param null $version
	 */
	public static function run( $version = null ) {
		if ( ! $version ) {
			return;
		}

		if ( ! method_exists( __CLASS__, 'v' . $version . '_migration' ) ) {
			return;
		}

		ignore_user_abort( true );

		if ( ! pum_is_func_disabled( 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) {
			@set_time_limit( 0 );
		}

		call_user_func( array( __CLASS__, 'v' . $version . '_migration' ) );

		if ( method_exists( __CLASS__, 'v' . $version . '_cleanup' ) ) {
			call_user_func( array( __CLASS__, 'v' . $version . '_cleanup' ) );
		}

		update_option( 'pum_alm_db_ver', $version + 1 );
	}

	public static function v1_migration() {
		global $wpdb;
		$key_changes = array(
			'popup_ajax_login_enabled'                       => 'popup_ajax_login_enabled',
			'popup_ajax_login_force_login'                   => 'popup_ajax_login_force_login',
			'popup_ajax_login_allow_remember'                => 'popup_ajax_login_allow_remember',
			'popup_ajax_login_disable_redirect'              => 'popup_ajax_login_disable_redirect',
			'popup_ajax_login_login_redirect_url'            => 'popup_ajax_login_redirect_url',
			'popup_ajax_login_login_loading_text'            => null,
			'popup_ajax_login_registration_enabled'          => 'popup_ajax_registration_enabled',
			'popup_ajax_login_registration_enable_password'  => 'popup_ajax_registration_enable_password',
			'popup_ajax_login_registration_enable_autologin' => 'popup_ajax_registration_enable_autologin',
			'popup_ajax_login_registration_disable_redirect' => 'popup_ajax_registration_disable_redirect',
			'popup_ajax_login_registration_redirect_url'     => 'popup_ajax_registration_redirect_url',
			'popup_ajax_login_registration_loading_text'     => null,
			'popup_ajax_login_recovery_enabled'              => 'popup_ajax_recovery_enabled',
			'popup_ajax_login_recovery_disable_redirect'     => 'popup_ajax_recovery_disable_redirect',
			'popup_ajax_login_recovery_redirect_url'         => 'popup_ajax_recovery_redirect_url',
			'popup_ajax_login_recovery_loading_text'         => null,
		);
		foreach ( $key_changes as $old => $new ) {
			if ( ! $new ) {
				$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => $old ) );
			} else {
				$wpdb->update( $wpdb->postmeta, array( 'meta_key' => $new ), array( 'meta_key' => $old ) );
			}
		}
	}


	public static function v2_migration() {
		global $wpdb;

		$popups = get_posts( array(
			'post_type'      => 'popup',
			'post_status'    => array( 'any', 'trash' ),
			'posts_per_page' => - 1,
		) );

		foreach ( $popups as $popup ) {

			$popup = new PUM_Popup( $popup->ID );

			$old_alm = self::v2_get_old_data( $popup->ID );

			$content = $popup->post_content;

			if ( isset( $old_alm['login']['enabled'] ) && $old_alm['login']['enabled'] ) {
				$login = $old_alm['login'];

				$triggers = $popup->get_triggers();

				$_triggers = array();

				// Add Triggers
				if ( isset( $login['action_block'] ) && $login['action_block'] ) {
					$_triggers[] = array(
						'type'     => 'click_block',
						'settings' => array(
							'requirements' => array(
								'login' => 'login',
							),
							'cookie'       => array(
								'name' => null,
							),
						),
					);
				}

				if ( isset( $login['force_login'] ) && $login['force_login'] ) {
					$_triggers[] = array(
						'type'     => 'force_login',
						'settings' => array(
							'cookie' => array(
								'name' => null,
							),
						),
					);
				}

				$login_links = array(
					'login'        => 'login',
					'registration' => isset( $old_alm['registration']['enabled'] ) && $old_alm['registration']['enabled'] ? 'registration' : false,
					'recovery'     => isset( $old_alm['recovery']['enabled'] ) && $old_alm['recovery']['enabled'] ? 'recovery' : false,
				);

				$_triggers[] = array(
					'type'     => 'click_open',
					'settings' => array(
						'login_links' => $login_links,
						'cookie'      => array(
							'name' => null,
						),
					),
				);

				foreach ( $_triggers as $trigger ) {
					$trigger['settings'] = PUM_Triggers::instance()->validate_trigger( $trigger['type'], $trigger['settings'] );
					$triggers[]          = $trigger;
				}

				// Add / Replace Content
				$atts = array(
					'disable_remember' => empty( $login['allow_remember'] ) || ! $login['allow_remember'],
					'redirect'         => $login['redirect_url'],
					'disable_redirect' => isset( $login['disable_redirect'] ) && $login['disable_redirect'],
					'autoclose'        => $login['close_delay'] > 0,
					'close_delay'      => $login['close_delay'],
				);

				$new_login_code = static::build_shortcode( 'pum_login_form', $atts );

				if ( strpos( $content, "[ajax_login_modal]" ) !== false ) {
					$content = str_replace( '[ajax_login_modal]', $new_login_code, $content );
				} else {
					if ( $content != '' ) {
						$content .= "\n\n";
					}
					$content .= $new_login_code;
				}

				update_post_meta( $popup->ID, 'popup_triggers', $triggers );

			}

			if ( isset( $old_alm['registration']['enabled'] ) && $old_alm['registration']['enabled'] ) {
				$registration = $old_alm['registration'];

				// Add / Replace Content
				$atts = array(
					'redirect'         => $registration['redirect_url'],
					'disable_redirect' => isset( $registration['disable_redirect'] ) && $registration['disable_redirect'],
					'autoclose'        => $registration['close_delay'] > 0,
					'close_delay'      => $registration['close_delay'],
					'enable_password'  => isset( $registration['enable_password'] ) && $registration['enable_password'],
					'enable_autologin' => isset( $registration['enable_autologin'] ) && $registration['enable_autologin'],
				);

				$new_registration_code = static::build_shortcode( 'pum_registration_form', $atts );

				if ( strpos( $content, "[ajax_registration_modal]" ) !== false ) {
					$content = str_replace( '[ajax_registration_modal]', $new_registration_code, $content );
				} else {
					if ( $content != '' ) {
						$content .= "\n\n";
					}
					$content .= $new_registration_code;
				}
			}

			if ( isset( $old_alm['recovery']['enabled'] ) && $old_alm['recovery']['enabled'] ) {
				$recovery = $old_alm['recovery'];

				// Add / Replace Content
				$atts = array(
					'redirect'         => $recovery['redirect_url'],
					'disable_redirect' => isset( $recovery['disable_redirect'] ) && $recovery['disable_redirect'],
					'autoclose'        => $recovery['close_delay'] > 0,
					'close_delay'      => $recovery['close_delay'],
				);

				$new_recovery_code = static::build_shortcode( 'pum_recovery_form', $atts );

				if ( strpos( $content, "[ajax_recovery_modal]" ) !== false ) {
					$content = str_replace( '[ajax_recovery_modal]', $new_recovery_code, $content );
				} else {
					if ( $content != '' ) {
						$content .= "\n\n";
					}
					$content .= $new_recovery_code;
				}
			}

			if ( $content != $popup->post_content ) {
				$wpdb->update( $wpdb->posts, array( 'post_content' => $content ), array( 'ID' => $popup->ID ), array( '%s' ), array( '%d' ) );
			}

		}

	}

	public static function v2_get_old_data( $popup_id ) {
		return array(
			'login'        => popmake_get_popup_meta( 'ajax_login', $popup_id ),
			'registration' => popmake_get_popup_meta( 'ajax_registration', $popup_id ),
			'recovery'     => popmake_get_popup_meta( 'ajax_recovery', $popup_id ),
		);
	}

	public static function build_shortcode( $tag, $atts = array(), $content = false ) {

		$shortcode = '[' . $tag;

		if ( ! empty( $atts ) ) {
			foreach( $atts as $key => $value ) {
				if ( empty( $value ) || ! $value ) {
					continue;
				}
				$shortcode .= ' ' . $key . '="' . $value . '"';
			}
		}

		$shortcode .= ']';

		if ( $content ) {
			$shortcode .= $content . '[/' . $tag . ']';
		}

		return $shortcode;
	}

	public static function v2_cleanup() {

	}

}
