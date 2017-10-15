<?php


function popmake_fi_form_nonce() {
	wp_nonce_field(POPMAKE_FI_NONCE, POPMAKE_FI_NONCE);
}
add_action('popmake_form_nonce', 'popmake_fi_form_nonce', 5);
