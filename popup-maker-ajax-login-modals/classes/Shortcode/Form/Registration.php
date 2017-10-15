<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_Shortcode_Registration_Form
 *
 * Registers the popup_close shortcode.
 */
class PUM_ALM_Shortcode_Form_Registration extends PUM_Shortcode {

	public function register() {
		// register old shortcode tag.
		add_shortcode( 'ajax_registration_modal', array( $this, 'handler' ) );
		parent::register();
	}

	public function label() {
		return __( 'AJAX Registration Form', 'popup-maker-ajax-login-modals' );
	}

	public function description() {
		return __( 'A customizable AJAX Registration Form.', 'popup-maker-ajax-login-modals' );
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
				'enable_confirm_email'    => array(
					'label'    => __( 'Force users to confirm their email?.', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Adds a confirm email field & requires matching emails.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'enable_password'         => array(
					'label'    => __( 'Allow users to create their own password?.', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Adds a password field & requires users to enter their own password.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 10,
				),
				'enable_confirm_password' => array(
					'label'    => __( 'Force users to confirm their password?', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Adds a confirm password field & requires matching passwords.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 15,
				),
				'enable_recaptcha'         => array(
					'label'    => __( 'Add Google ReCaptcha.', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Adds a Google ReCaptcha field to the form.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 20,
				),
			),
			'labels'       => array(
				'disable_labels'         => array(
					'label'    => __( 'Disable Labels', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables the display of field labels.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'label_username'         => array(
					'label'    => __( 'Username' ),
					'desc'     => __( 'Label for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
				'label_email'            => array(
					'label'    => __( 'Email' ),
					'desc'     => __( 'Label for the email field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 15,
				),
				'label_confirm_email'    => array(
					'label'    => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Label for the confirm email field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 20,
				),
				'label_password'         => array(
					'label'    => __( 'Password' ),
					'desc'     => __( 'Label for the password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 25,
				),
				'label_confirm_password' => array(
					'label'    => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Label for the confirm password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 30,
				),
				'label_submit'           => array(
					'label'    => __( 'Submit Button', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Label for the submit button.', 'popup-maker-ajax-login-modals' ),
					'priority' => 35,
				),
			),
			'placeholders' => array(
				'disable_placeholders'         => array(
					'label'    => __( 'Disable Placeholders', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables the display of field placeholders.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'placeholder_username'         => array(
					'label'    => __( 'Username' ),
					'desc'     => __( 'Placeholder for the username field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 10,
				),
				'placeholder_email'            => array(
					'label'    => __( 'Email' ),
					'desc'     => __( 'Placeholder for the email field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 15,
				),
				'placeholder_confirm_email'    => array(
					'label'    => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Placeholder for the confirm email field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 20,
				),
				'placeholder_password'         => array(
					'label'    => __( 'Password' ),
					'desc'     => __( 'Placeholder for the password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 30,
				),
				'placeholder_confirm_password' => array(
					'label'    => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Placeholder for the confirm password field.', 'popup-maker-ajax-login-modals' ),
					'priority' => 35,
				),
			),
			'success'      => array(
				'enable_autologin' => array(
					'label'    => __( 'Automatically login After Registration.', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'User will be immediately logged in after successful registration.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 5,
				),
				'disable_redirect' => array(
					'label'    => __( 'Disable Redirect', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Disables refreshing the page or redirecting after login.', 'popup-maker-ajax-login-modals' ),
					'type'     => 'checkbox',
					'priority' => 10,
				),
				'redirect'         => array(
					'label'    => __( 'Redirect URL', 'popup-maker-ajax-login-modals' ),
					'desc'     => __( 'Leave blank to refresh, or enter a url that users will be taken to after login.', 'popup-maker-ajax-login-modals' ),
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
			'form_id'                      => 'pum-registration-form',
			'layout'                       => 'standard',
			'enable_confirm_email'         => false,
			'enable_password'              => false,
			'enable_confirm_password'      => false,
			'enable_autologin'             => false,
			'disable_redirect'             => false,
			'redirect'                     => '',
			'autoclose'                    => false,
			'close_delay'                  => 3000,
			'enable_recaptcha'             => false,
			// Labels
			'disable_labels'               => false,
			'label_username'               => __( 'Username' ),
			'label_email'                  => __( 'Email' ),
			'label_confirm_email'          => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
			'label_password'               => __( 'Password' ),
			'label_confirm_password'       => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
			'label_submit'                 => __( 'Register' ),
			// Placeholders
			'disable_placeholders'         => false,
			'placeholder_username'         => __( 'Username' ),
			'placeholder_email'            => __( 'Email' ),
			'placeholder_confirm_email'    => __( 'Confirm Email', 'popup-maker-ajax-login-modals' ),
			'placeholder_password'         => __( 'Password' ),
			'placeholder_confirm_password' => __( 'Confirm Password', 'popup-maker-ajax-login-modals' ),
			// Values
			'value_username'               => '',
			'value_email'                  => '',
			// Deprecated
			'redirect_url'                 => false,
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

		include popmake_get_template_part( 'form', 'registration', false );

		return ob_get_clean();
	}

	public function shortcode_atts( $atts ) {
		$atts = parent::shortcode_atts( $atts );

		if ( $atts['redirect_url'] ) {
			$atts['redirect'] = $atts['redirect_url'];
		}

		if ( ! $atts['disable_redirect'] && $atts['redirect'] == '' ) {
			$atts['redirect'] = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		return $atts;
	}

	public function _template() { ?>
		<script type="text/html" id="tmpl-pum-shortcode-view-<?php echo $this->tag(); ?>">
			<?php _e( 'AJAX Registration Form', 'popup-maker-ajax-login-modals' ); ?>
		</script><?php
	}

	/**
	 * The shortcode tag.
	 */
	public function tag() {
		return 'pum_registration_form';
	}

}

new PUM_ALM_Shortcode_Form_Registration();
