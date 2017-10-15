<?php
/**
 * Scripts
 *
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
 * Loads the Popup Maker - Forced Interaction scripts.
 *
 * @since 1.0
 * @return void
 */
function popmake_fi_load_site_scripts() {
	$js_dir = POPMAKE_FI_URL . '/assets/scripts/';
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	wp_enqueue_script('popup-maker-forced-interaction-site', $js_dir . 'popup-maker-forced-interaction-site' . $suffix . '?defer', array('popup-maker-site'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'popmake_fi_load_site_scripts' );