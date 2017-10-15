<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form = PUM_ALM_Forms::get_login_form( $atts );

/**
 * popmake- classes and form[id="ajax-login-form"] are here for backward css compatibility.
 */ ?>
<div class="pum-form-wrapper pum-alm-form-wrapper pum-login-form-wrapper popmake-ajax-form popmake-login-form" data-autoclose="<?php echo $atts['autoclose']; ?>" data-autoclose-delay="<?php echo $atts['close_delay']; ?>">

	<?php do_action( 'pum_login_form_before', $form, $atts ); ?>

	<form id="ajax-login-form" name="pum-login-form" class="pum-form pum-alm-form pum-login-form layout-<?php echo $atts['layout']; ?>" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post" novalidate>

		<div class="pum-fields">

			<?php $form->render_fields(); ?>

		</div>

	</form>

	<?php do_action( 'pum_login_form_after', $form, $atts ); ?>

</div>