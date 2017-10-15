<?php
/**
 * Scripts
 *
 * @package		POPMAKE_AVM
 * @subpackage	Functions
 * @copyright	Copyright (c) 2014, Wizard Internet Solutions
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since		1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Loads the Popup Maker scripts.
 *
 * @since 1.0
 * @return void
 */
function popmake_av_load_site_scripts() {
	$js_dir = POPMAKE_AVM_URL . '/assets/scripts/';
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	wp_enqueue_script('popup-maker-age-verification-modals-site', $js_dir . 'popup-maker-age-verification-modals-site' . $suffix . '?defer', array('popup-maker-site', 'jquery-cookie'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'popmake_av_load_site_scripts' );

/**
 * Load Styles
 *
 * Loads the Popup Maker stylesheet.
 *
 * @since 1.0
 * @return void
 */
function popmake_av_load_site_styles() {
	$css_dir = POPMAKE_AVM_URL . '/assets/styles/';
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	wp_enqueue_style('popup-maker-age-verification-modals-site', $css_dir . 'popup-maker-age-verification-modals-site' . $suffix, array('popup-maker-site'), '1.0');
}
add_action( 'wp_enqueue_scripts', 'popmake_av_load_site_styles' );


/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @since 1.0
 * @param string $hook Page hook
 * @return void
 */
function popmake_av_load_admin_scripts( $hook ) {
	$js_dir  = POPMAKE_AVM_URL . '/assets/scripts/';
	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	if(popmake_is_admin_page()) {
		wp_enqueue_script('popup-maker-age-verification-modals-admin', $js_dir . 'popup-maker-age-verification-modals-admin' . $suffix,  array('popup-maker-admin'), '1.0');
	}
}
add_action( 'admin_enqueue_scripts', 'popmake_av_load_admin_scripts', 100 );