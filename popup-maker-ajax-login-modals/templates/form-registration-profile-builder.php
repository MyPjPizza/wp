<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * popmake- classes and form[id="ajax-registration-form"] are here for backward css compatibility.
 */ ?>
<div class="pum-form-wrapper pum-alm-form-wrapper pum-registration-form-wrapper popmake-ajax-form popmake-registration-form" data-autoclose="<?php echo $atts['autoclose']; ?>" data-autoclose-delay="<?php echo $atts['close_delay']; ?>">

	<?php do_action( 'pum_registration_form_before', null, $atts ); ?>

	<?php
	$form_args = shortcode_atts( array(
		'enable_autologin' => false,
		'disable_redirect' => false,
		'redirect'         => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
	), $atts );

	?>

	<input type="hidden" name="_form_args" data-moveme="true" value='<?php echo json_encode( $form_args ); ?>' />

	<?php echo do_shortcode( '[wppb-register]' ); ?>

	<?php do_action( 'pum_registration_form_after', null, $atts ); ?>

</div>