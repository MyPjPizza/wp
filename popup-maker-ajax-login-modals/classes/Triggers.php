<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class PUM_ALM_Triggers {

	public static function init() {
		add_filter( 'pum_get_trigger_labels', array( __CLASS__, 'trigger_labels' ) );
		add_filter( 'pum_get_triggers', array( __CLASS__, 'register_triggers' ) );
		add_action( 'pum_alm_field_notice', array( __CLASS__, 'field_notice' ) );

	}

	public static function trigger_labels( $labels = array() ) {
		return array_merge( $labels, array(
			'force_login' => array(
				'name'        => __( 'Force Login', 'popup-maker-ajax-login-modals' ),
				'modal_title' => __( 'Force Login Settings', 'popup-maker-ajax-login-modals' ),
			),
			'click_block' => array(
				'name'        => __( 'Click Blocking', 'popup-maker-ajax-login-modals' ),
				'modal_title' => __( 'Click Blocking Settings', 'popup-maker-ajax-login-modals' ),
			),
			'login_links' => array(
				'name'        => __( 'Login Links', 'popup-maker-ajax-login-modals' ),
				'modal_title' => __( 'Login Links Settings', 'popup-maker-ajax-login-modals' ),
				//'settings_column' => sprintf( '%2$s', '{{data.extra_selectors}}' ),
			),
		) );
	}

	public static function register_triggers( $triggers = array() ) {

		if ( ! isset( $triggers['click_block'] ) ) {
			$triggers['click_block'] = array(
				'fields' => array(
					'general' => array(
						'extra_selectors' => array(
							'label'       => __( 'Extra CSS Selectors', 'popup-maker' ),
							'desc'        => __( 'This allows custom css classes, ids or selector strings to trigger the popup when clicked. Separate multiple selectors using commas.', 'popup-maker' ),
							'placeholder' => __( '.my-class, #button2', 'popup-maker' ),
						),
						'requirements' => array(
							'type'    => 'multicheck',
							'label'   => __( 'Action Requirements?', 'popup-maker-ajax-login-modals' ),
							'desc'    => __( 'Each item checked will be required to acitvate the clicked item.', 'popup-maker-ajax-login-modals' ),
							'options' => array(),
						),
					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			);
		}

		$triggers['click_block']['fields']['general']['requirements']['options']['login'] = __( 'Login' );

		$triggers['click_open']['fields']['general']['login_links'] = array(
			'type'    => 'multicheck',
			'label'   => __( 'Target Which WordPress Links?', 'popup-maker-ajax-login-modals' ),
			'desc'    => __( 'This will turn these links into popup triggers.', 'popup-maker-ajax-login-modals' ),
			'options' => array(
				'login'        => __( 'Login', 'popup-maker-ajax-login-modals' ),
				'registration' => __( 'Registration', 'popup-maker-ajax-login-modals' ),
				'recovery'     => __( 'Recovery', 'popup-maker-ajax-login-modals' ),
			),
		);

		return array_merge( $triggers, array(
			'force_login' => array(
				'fields' => array(
					'general' => array(
						'user_notice'      => array(
							'type' => 'hook',
							'hook' => 'pum_alm_field_notice',
							'desc' => sprintf( __( 'Use the Popup Maker shortcode button %s on the editor toolbar to insert and customize your login forms.', 'popup-maker-ajax-login-modals' ), '<img src="' . POPMAKE_URL . '/assets/images/admin/popup-maker-icon.png" width="20" />' ),
						),
						'condition_notice' => array(
							'type' => 'hook',
							'hook' => 'pum_alm_field_notice',
							'desc' => __( 'If this is enabled the popup will be disabled entirely if the user is logged in.', 'popup-maker-ajax-login-modals' ),
						),
					),
					'cookie'  => pum_trigger_cookie_fields(),
				),
			),
		) );
	}

	/**
	 * @param array $args
	 */
	public static function field_notice( $args = array() ) {
		echo '<p class="desc">' . $args['desc'] . '</p>';
	}

}
