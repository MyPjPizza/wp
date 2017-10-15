<?php
/**
 * Returns the age verification meta of a popup.
 *
 * @since 1.0
 * @param int $popup_id ID number of the popup to retrieve a age verification meta for
 * @return mixed array|string of the popup age verification meta 
 */
function popmake_get_popup_age_verification( $popup_id = NULL, $key = NULL ) {
	return popmake_get_popup_meta_group( 'age_verification', $popup_id, $key );
}
