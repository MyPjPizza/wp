<?php
/**
 * Helper Functions
 *
 * @package     PopMake\RemoteContent\Functions
 * @since       1.0.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Returns the remote content meta of a popup.
 *
 * @since 1.0
 *
 * @param int $popup_id ID number of the popup to retrieve a remote content meta for
 * @param null $key
 * @param null $default
 *
 * @return mixed array|string of the popup remote content meta
 */
function popmake_get_popup_remote_content( $popup_id = null, $key = null, $default = null ) {
	if ( function_exists( 'popmake_get_popup_meta' ) ) {
		return popmake_get_popup_meta( 'remote_content', $popup_id, $key, $default );
	}
	else {
		return popmake_get_popup_meta_group( 'remote_content', $popup_id, $key );
	}
}