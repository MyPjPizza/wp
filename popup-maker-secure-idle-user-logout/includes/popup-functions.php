<?php
/**
 * Returns the age verification meta of a popup.
 *
 * @since 1.0
 * @param int $popup_id ID number of the popup to retrieve a age verification meta for
 * @return mixed array|string of the popup age verification meta 
 */
function popmake_get_popup_secure_logout( $popup_id = NULL, $key = NULL ) {
	return popmake_get_popup_meta_group( 'secure_logout', $popup_id, $key );
}
