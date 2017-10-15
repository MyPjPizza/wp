<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form = PUM_ALM_Forms::get_registration_form( $atts );

/**
 * popmake- classes and form[id="ajax-registration-form"] are here for backward css compatibility.
 */ ?>
<div class="pum-form-wrapper pum-alm-form-wrapper pum-registration-form-wrapper popmake-ajax-form popmake-registration-form" data-autoclose="<?php echo $atts['autoclose']; ?>" data-autoclose-delay="<?php echo $atts['close_delay']; ?>">

	<?php do_action( 'pum_registration_form_before', $form, $atts ); ?>

	<form id="ajax-registration-form" name="pum-registration-form" class="pum-form pum-alm-form pum-registration-form layout-<?php echo $atts['layout']; ?>" action="<?php echo wp_registration_url(); ?>" method="post" novalidate>

		<div class="pum-fields">

			<?php $form->render_fields(); ?>

		</div>

	</form>

	<?php do_action( 'pum_registration_form_after', $form, $atts ); ?>

</div>