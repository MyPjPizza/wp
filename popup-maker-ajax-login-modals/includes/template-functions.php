<?php
/**
 * Helper Functions
 *
 * @package     PopMake\AJAXLoginModals\TemplateFunctions
 * @since       1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function pum_alm_footer_links( $which = array() ) {
	if ( empty( $which ) ) {
		return '';
	}

	ob_start(); ?>

	<ul class='pum-alm-footer-links popmake-alm-footer-links'>

	<?php
	foreach ( $which as $key ) :
		switch ( $key ) :

			case 'login': ?>
				<li><?php _e( 'Already have an account?', 'popup-maker-ajax-login-modals' ); ?> <a href="<?php echo wp_login_url(); ?>"><?php _e( 'Log in' ); ?></a></li><?php
				break;

			case 'registration':
				$register = wp_register( '', '', false );
				if ( ! empty( $register ) ) { ?>
					<li><?php _e( 'Don\'t have an account?', 'popup-maker-ajax-login-modals' ); ?><?php echo $register; ?></li><?php
				}
				break;

			case 'recovery': ?>
				<li><?php _e( 'Lost your password?' ); ?><a href='<?php echo wp_lostpassword_url(); ?>'><?php _e( 'Click here', 'popup-maker-ajax-login-modals' ); ?></a></li><?php
				break;

		endswitch;
	endforeach;

	do_action( 'popmake_alm_footer_links' );
	do_action( 'pum_alm_footer_links' );
	?>
	</ul><?php

	return ob_get_clean();
}
