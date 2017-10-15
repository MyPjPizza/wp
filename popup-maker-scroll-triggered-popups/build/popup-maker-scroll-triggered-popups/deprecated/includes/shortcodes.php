<?php
/**
 * Shortcode Functions
 *
 * @since       1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'scroll_pop', 'popmake_stp_trigger_shortcode' );
function popmake_stp_trigger_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'id' => null ), $atts );
	if ( ! $atts['id'] ) {
		return;
	}

	return '<span id="scroll_pop_trigger-' . $atts['id'] . '"></span>';
}
