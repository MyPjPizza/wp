<?php
/**
 * Helper Functions
 *
 * @package     PopMake\ScrollTriggeredPopups\Functions
 * @since       1.1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the srcoll pops meta of a popup.
 *
 * @since 1.0
 *
 * @param int $popup_id ID number of the popup to retrieve a srcoll pop meta for
 *
 * @return mixed array|string of the popup srcoll pop meta
 */
function popmake_get_popup_scroll_triggered( $popup_id = null, $key = null ) {
	return popmake_get_popup_meta_group( 'scroll_triggered', $popup_id, $key );
}
