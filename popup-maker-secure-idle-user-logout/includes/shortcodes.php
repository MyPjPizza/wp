<?php
add_shortcode( 'secure_logout', 'popmake_siul_secure_logout_shortcode');
function popmake_siul_secure_logout_shortcode( $atts ) {
	global $post;
	$atts = shortcode_atts( array(), $atts );
	$secure_logout = popmake_get_popup_secure_logout( $post->ID );
	$content = '';
	if( popmake_get_popup_secure_logout( $post->ID, 'enabled') ) {
		$content .= '<div class="popmake-logout-timer popmake-title">0</div>';
	}
	return $content;
}