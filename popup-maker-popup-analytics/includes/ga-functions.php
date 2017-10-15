<?php

// Handle the parsing of the _ga cookie or setting it to a unique identifier
function popmake_ga_parse_cookie() {
	if( isset( $_COOKIE['_ga'] ) ) {
		list( $version, $domainDepth, $cid1, $cid2 ) = split('[\.]', $_COOKIE["_ga"], 4 );
		$contents = array( 'version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1.'.'.$cid2 );
		return $contents['cid'];
	}
	else {
		return popmake_pa_ga_gen_uuid();
	}
}


// Generate UUID v4 function - needed to generate a CID when one isn't available
function popmake_pa_ga_gen_uuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		// 32 bits for "time_low"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

		// 16 bits for "time_mid"
		mt_rand( 0, 0xffff ),

		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand( 0, 0x0fff ) | 0x4000,

		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand( 0, 0x3fff ) | 0x8000,

		// 48 bits for "node"
		mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	);
}


// See https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide
function popmake_pa_ga_fire_hit( $data = null ) {
	global $popmake_options;
	if( $data ) {
		$getString = 'https://ssl.google-analytics.com/collect';
		$getString .= '?payload_data&';
		$getString .= http_build_query( $data );
		$result = wp_remote_get( $getString );
		if( popmake_get_option( 'popmake_pa_ga_debug', false ) && popmake_get_option( 'popmake_pa_ga_debug_email', '' ) != '' ) {
			$sendlog = error_log( $getString, 1, popmake_get_option( 'popmake_pa_ga_debug_email' ) );
		}
		return $result;
	}
	return false;
}