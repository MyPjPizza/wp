<?php
function popmake_siul_popup_secure_logout_defaults( $defaults ) {
	return array_merge( $defaults, array(
		'enabled'				=> NULL,
		'force_logout_after'	=> 15,
		'warning_timer'			=> 30,
	));
}
add_filter('popmake_popup_secure_logout_defaults', 'popmake_siul_popup_secure_logout_defaults');