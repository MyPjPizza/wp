<?php
function popmake_av_popup_age_verification_defaults( $defaults ) {
	return array_merge( $defaults, array(
		'enabled' => NULL,
		'type' => 'enterexit',
		'required_age' => 18,
		'exiturl' => 'http://www.disney.com',
		'cookie_time' => '1 month',
		'cookie_path' => '/'
	));
}
add_filter('popmake_popup_age_verification_defaults', 'popmake_av_popup_age_verification_defaults');