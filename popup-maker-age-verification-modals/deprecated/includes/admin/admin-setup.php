<?php

add_action('popmake_form_nonce', 'popmake_av_form_nonce', 5);
function popmake_av_form_nonce() {
	wp_nonce_field(POPMAKE_AVM_NONCE, POPMAKE_AVM_NONCE);
}
