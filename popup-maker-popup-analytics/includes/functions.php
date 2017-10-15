<?php
/**
 * Helper Functions
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Returns the analytics meta of a popup.
 *
 * @since 1.0
 * @param int $popup_id ID number of the popup to retrieve a analytics meta for
 * @return mixed array|string of the popup analytics meta 
 */
function popmake_get_popup_analytics( $popup_id = NULL, $key = NULL ) {
	return popmake_get_popup_meta_group( 'analytics', $popup_id, $key );
}



if( ! function_exists( 'formatMilliseconds' ) ) {
	function formatMilliseconds( $milliseconds ) {
	    $seconds = floor( $milliseconds / 1000 );
	    $minutes = floor( $seconds / 60 );
	    $hours = floor( $minutes / 60 );
	    $milliseconds = $milliseconds % 1000;
	    $seconds = $seconds % 60;
	    $minutes = $minutes % 60;

	    $time = $seconds . 's';

	    if( $minutes > 0 ) {
	    	$time = $minutes . 'm ' . $time;
	    }
	    if( $hours > 0 ) {
	    	$time = $hours . 'h ' . $time;
	    }

	    return rtrim( $time, '0' );
	}
}
