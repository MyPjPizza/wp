<?php


function popmake_av_age_verification_type_options( $options ) {
	return array_merge($options, array(
		// option => value
		__( 'Enter / Exit', 'popup-maker-age-verification-modals' ) => 'enterexit',
		__( 'Birthdate', 'popup-maker-age-verification-modals' ) => 'birthdate',
	));
}
add_filter('popmake_av_age_verification_type_options', 'popmake_av_age_verification_type_options',10);
