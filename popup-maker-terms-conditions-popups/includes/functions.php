<?php
/**
 * Helper Functions
 *
 * @package     PopMake\TermsConditionsPopups\Functions
 * @since       1.0.0
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Returns the terms & conditions meta of a popup.
 *
 * @since 1.0
 * @param int $popup_id ID number of the popup to retrieve a terms_conditions meta for
 * @return mixed array|string of the popup terms_conditions meta 
 */
function popmake_get_popup_terms_conditions( $popup_id = NULL, $key = NULL ) {
	return popmake_get_popup_meta_group( 'terms_conditions', $popup_id, $key );
}
