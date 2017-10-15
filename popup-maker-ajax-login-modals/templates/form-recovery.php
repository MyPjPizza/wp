<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form = PUM_ALM_Forms::get_recovery_form( $atts );

/**
* popmake- classes and form[id="ajax-recovery-form"] are here for backward css compatibility.
*/ ?>
<div class="pum-form-wrapper pum-alm-form-wrapper pum-recovery-form-wrapper popmake-ajax-form popmake-recovery-form" data-autoclose="<?php echo $atts['autoclose']; ?>" data-autoclose-delay="<?php echo $atts['close_delay']; ?>">

	<?php do_action( 'pum_recovery_form_before', $form, $atts ); ?>

	<form id="ajax-recovery-form" name="pum-recovery-form" class="pum-form pum-alm-form pum-recovery-form layout-<?php echo $atts['layout']; ?>" action="<?php echo wp_lostpassword_url( $atts['redirect'] ); ?>" method="post" novalidate>

		<div class="pum-fields">

			<?php $form->render_fields(); ?>

		</div>

	</form>

	<?php do_action( 'pum_recovery_form_after', $form, $atts ); ?>

</div>