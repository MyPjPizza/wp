<?php


function popmake_siul_logout_ajax_call() { 
	wp_logout();
	die();
}

add_action('wp_ajax_popmake_siul_logout', 'popmake_siul_logout_ajax_call');
add_action('wp_ajax_nopriv_popmake_siul_logout', 'popmake_siul_logout_ajax_call');
