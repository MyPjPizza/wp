<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Shortcode_Recovery_Form
 *
 * Registers the popup_close shortcode.
 */
class PUM_ALM_Shortcode_Form_Recovery extends PUM_Shortcode {

	public function register() {
		// register old shortcode tag.
		add_shortcode( 'ajax_recovery_modal', array( $this, 'handler' ) );
		parent::register();
	}

	public function label() {
		return __( 'AJAX Recovery Form', 'popup-maker-ajax-login-modals' );
	}

	public function description() {
		return __( 'A customizable AJAX Recovery Form.', 'popup-maker-ajax-login-modals' );
	}

	public function post_types() {
		return array( 'popup' );
	}

	public function sections() {
		return array(
			//'general'      => __( 'General', 'popup-maker-ajax-login-modals' ),
			'labels'       => __( 'Labels', 'popup-maker-ajax-login-modals' ),
			'placeholders' => __( 'Placeholders', 'popup-maker-ajax-login-modals' ),
			'success'      => __( 'Success', 'popup-maker-ajax-login-modals' ),
		);
	}

	public function fields() {
		return array(
			//'general'      => array(),
			'labels'       => array(
				'disable_labels' => array(
					'label'    => __( 'Disable Labels', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables the display of field labels.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'label_username' => array(
					'label'    => __( 'Username or Email' ),
					'desc'     => __( 'Label for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
				'label_submit'   => array(
					'label'    => __( 'Get New Password' ),
					'desc'     => __( 'Label for the submit button.', 'popup-maker-ajax-login-modals' ),
					'priority' => 25,
				),

			),
			'placeholders' => array(
				'disable_placeholders' => array(
					'label'    => __( 'Disable Placeholders', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables the display of field placeholders.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'placeholder_username' => array(
					'label'    => __( 'Username or Email' ),
					'desc'     => __( 'Placeholder text for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
			),
			'success'      => array(
				'disable_redirect' => array(
					'label'    => __( 'Disable Redirect', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables refreshing the page or redirecting after success.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 10,
				),
				'redirect'         => array(
					'label'    => __( 'Redirect URL', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Leave blank to refresh, or enter a url that users will be taken to after success.', 'popup-maker-ajax-login-modals' ),
					'std'      => '',
					'priority' => 15,
				),
				'autoclose'        => array(
					'label'    => __( 'Auto Close', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Enables the auto closing of the popup after success.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 20,
				),
				'close_delay'      => array(
					'label'    => __( 'Auto Close Delay', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'This is the delay before the popup closes & redirects occur.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'rangeslider',
					'priority' => 25,
					'step'     => 500,
					'min'      => 0,
					'max'      => 10000,
					'unit'     => 'ms',
					'std'      => 3000,
				),
			),
		);
	}

	public function defaults() {
		return array(
			'form_id'              => 'pum-recovery-form',
			'layout'               => 'standard',
			'disable_redirect'     => false,
			'redirect'             => '',
			'autoclose'            => false,
			'close_delay'          => 3000,
			// Labels
			'disable_labels'       => false,
			'label_username'       => __( 'Username or Email' ),
			'label_submit'         => __( 'Get New Password' ),
			// Placeholders
			'disable_placeholders' => false,
			'placeholder_username' => __( 'Username or Email' ),
			// Values
			'value_username'       => '',
			// Deprecated
			'redirect_url'         => false,
		);
	}

	/**
	 * Shortcode handler
	 *
	 * @param  array $atts shortcode attributes
	 * @param  string $content shortcode content
	 *
	 * @return string
	 */
	public function handler( $atts, $content = null ) {
		$atts = $this->shortcode_atts( $atts );

		ob_start();

		include popmake_get_template_part( 'form', 'recovery', false );

		return ob_get_clean();
	}

	public function shortcode_atts( $atts ) {
		$atts = parent::shortcode_atts( $atts );

		if ( ! $atts['disable_redirect'] && $atts['redirect'] == '' ) {
			$atts['redirect'] = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		return $atts;
	}

	public function _template() { ?>
		<script type="text/html" id="tmpl-pum-shortcode-view-<?php echo $this->tag(); ?>">
			<?php _e( 'AJAX Recovery Form', 'popup-maker-ajax-login-modals' ); ?>
		</script><?php
	}

	/**
	 * The shortcode tag.
	 */
	public function tag() {
		return 'pum_recovery_form';
	}

}
