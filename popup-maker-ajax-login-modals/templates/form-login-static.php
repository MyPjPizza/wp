<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Used for compatibility with plugins that modify the built in login forms.
$pum_login_form_args = shortcode_atts( array(
	'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
	'form_id'        => 'pum-login-form',
	'label_username' => __( 'Username' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_submit'   => __( 'Log In' ),
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'remember'       => ! $atts['disable_remember'],
	'value_username' => '',
	'value_remember' => false,
), $atts );


?>

<div class="pum-form-wrapper pum-login-form-wrapper popmake-ajax-form popmake-login-form">

	<?php do_action( 'pum_login_form_before', $atts ); ?>

	<form id="ajax-login-form" name="pum-login-form" class="pum-form pum-login-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">

		<?php echo apply_filters( 'login_form_top', '', $pum_login_form_args ); ?>

        <div class="pum-field pum-field-text pum-field-user_login">
            <?php if ( ! $atts['disable_labels'] ) : ?>
                <label for="user_login"><?php esc_html_e( $atts['label_username'] ); ?></label>
            <?php endif; ?>
            <input type="text" id="user_login" name="log" placeholder="<?php esc_attr_e( ! $atts['disable_placeholders'] ? $atts['placeholder_username'] : null ); ?>" value="<?php esc_attr_e( $atts['value_username'] ); ?>" required />
        </div>

        <div class="pum-field pum-field-password pum-field-user_pass">
            <?php if ( ! $atts['disable_labels'] ) : ?>
                <label for="user_pass"><?php esc_html_e( $atts['label_username'] ); ?></label>
            <?php endif; ?>
            <input type="password" id="user_pass" name="pwd" placeholder="<?php esc_attr_e( ! $atts['disable_placeholders'] ? $atts['placeholder_password'] : null ); ?>" required />
        </div>

        <?php echo apply_filters( 'login_form_middle', '', $pum_login_form_args ); ?>

        <div class="pum-field pum-field-checkbox pum-field-remember">
            <input type="checkbox" id="remember" name="remember" value="forever" <?php checked( $atts['value_remember'], true ); ?> />
            <label for="remember"><?php esc_html_e( $atts['label_remember'] ); ?></label>
        </div>

        <div class="pum-field pum-field-button pum-field-wp-submit">
            <input type="submit" id="wp-submit" name="wp-submit" class="button-primary" value="<?php esc_attr_e( $atts['label_submit'] ); ?>" />
        </div>

		<?php echo apply_filters( 'login_form_bottom', '', $pum_login_form_args ); ?>

	</form>

	<?php do_action( 'pum_login_form_after', $atts ); ?>

</div>