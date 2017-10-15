<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Shortcode_Login_Form
 *
 * Registers the popup_close shortcode.
 */
class PUM_ALM_Shortcode_Form_Login extends PUM_Shortcode {

	public function register() {
		// register old shortcode tag.
		add_shortcode( 'ajax_login_modal', array( $this, 'handler' ) );
		parent::register();
	}

	public function label() {
		return __( 'AJAX Login Form', 'popup-maker-ajax-login-modals' );
	}

	public function description() {
		return __( 'A customizable AJAX Login Form.', 'popup-maker-ajax-login-modals' );
	}

	public function post_types() {
		return array( 'popup' );
	}

	public function sections() {
		return array(
			'general'      => __( 'General', 'popup-maker-ajax-login-modals' ),
			'labels'       => __( 'Labels', 'popup-maker-ajax-login-modals' ),
			'placeholders' => __( 'Placeholders', 'popup-maker-ajax-login-modals' ),
			'success'      => __( 'Success', 'popup-maker-ajax-login-modals' ),
		);
	}

	public function fields() {
		return array(
			'general'      => array(
				'disable_remember' => array(
					'label'    => __( 'Disable Remember Me', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disable the remember me option.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
			),
			'labels'       => array(
				'disable_labels' => array(
					'label'    => __( 'Disable Labels', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables the display of field labels.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'label_username' => array(
					'label'    => __( 'Username' ),
					'desc'     => __( 'Label for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
				'label_password' => array(
					'label'    => __( 'Password' ),
					'desc'     => __( 'Label for the password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 15,
				),
				'label_remember' => array(
					'label'    => __( 'Remember Me' ),
					'desc'     => __( 'Label for the remember me field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 20,
				),
				'label_submit'   => array(
					'label'    => __( 'Log In' ),
					'desc'     => __( 'Label for the login button.', 'popup-maker-ajax-login-modals' ),
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
					'label'    => __( 'Username' ),
					'desc'     => __( 'Placeholder text for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
				'placeholder_password' => array(
					'label'    => __( 'Password' ),
					'desc'     => __( 'Placeholder text for the password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 15,
				),
			),
			'success' => array(
				'disable_redirect'        => array(
					'label'    => __( 'Disable Redirect', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables refreshing the page or redirecting after success.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 10,
				),
				'redirect'                => array(
					'label'    => __( 'Redirect URL', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Leave blank to refresh, or enter a url that users will be taken to after success.', 'popup-maker-ajax-login-modals' ),
					'std'      => '',
					'priority' => 15,
				),
				'autoclose'               => array(
					'label'    => __( 'Auto Close', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Enables the auto closing of the popup after success.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 20,
				),
				'close_delay'             => array(
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
			'form_id'              => 'pum-login-form',
			'layout'               => 'standard',
			// Form Settings
			'disable_redirect'     => false,
			'redirect'             => '',
			'disable_remember'     => false,
			'remember'             => null,
			'autoclose'            => false,
			'close_delay'          => 3000,
			// Labels
			'disable_labels'       => false,
			'label_username'       => __( 'Username' ),
			'label_password'       => __( 'Password' ),
			'label_remember'       => __( 'Remember Me' ),
			'label_submit'         => __( 'Log In' ),
			// Placeholders
			'disable_placeholders' => false,
			'placeholder_username' => __( 'Username' ),
			'placeholder_password' => __( 'Password' ),
			// Values
			'value_username'       => '',
			'value_remember'       => false,

			// Deprecated
			'label_log_in' => '',
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

		include popmake_get_template_part( 'form', 'login', false );

		return ob_get_clean();
	}

	public function shortcode_atts( $atts ) {
		$atts = parent::shortcode_atts( $atts );

		if ( $atts['remember'] ) {
			$atts['disable_remember'] = false;
		} elseif ( $atts['disable_remember'] ) {
			$atts['remember'] = false;
		}

		if ( $atts['label_log_in'] != '' ) {
			$atts['label_submit'] = $atts['label_log_in'];
		}

		if ( ! $atts['disable_redirect'] && $atts['redirect'] == '' ) {
			$atts['redirect'] = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		return $atts;
	}

	public function _template() { ?>
		<script type="text/html" id="tmpl-pum-shortcode-view-<?php echo $this->tag(); ?>">
			<?php _e( 'AJAX Login Form', 'popup-maker-ajax-login-modals' ); ?>
		</script><?php
	}

	/**
	 * The shortcode tag.
	 */
	public function tag() {
		return 'pum_login_form';
	}

}
