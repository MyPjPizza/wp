<?php

add_action('popmake_form_nonce', 'popmake_siul_form_nonce', 5);
function popmake_siul_form_nonce() {
	wp_nonce_field(POPMAKE_SIUL_NONCE, POPMAKE_SIUL_NONCE);
}
