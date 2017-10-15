<?php
/**
 * Shortcode Functions
 *
 * @since       1.0.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

add_shortcode( 'terms-conditions', 'popmake_tcp_terms_conditions_shortcode');
add_shortcode( 'terms_conditions', 'popmake_tcp_terms_conditions_shortcode');
function popmake_tcp_terms_conditions_shortcode( $atts, $content ) {
	$atts = shortcode_atts( array( 'height' => NULL ), $atts );
	extract( $atts );
	ob_start();
	include popmake_get_template_part( 'terms-conditions', 'box', false );
	return ob_get_clean();
}
