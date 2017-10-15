<?php
/*
 * @package   GFP_Third_Party_Post
 * @copyright 2015-2017 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GFP_Third_Party_Post
 *
 * Creates a Gravity Forms Add-On
 *
 * @since  1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Third_Party_Post {

	/**
	 * Let's get it started!
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function construct() {
	}

	/**
	 * Register WordPress hooks
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function run() {

		add_action( 'gform_loaded', array( $this, 'gform_loaded' ) );

	}

	/**
	 * Create GF Add-On
	 *
	 * @since  1.4.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function gform_loaded() {

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {

			return;

		}

		GFForms::include_addon_framework();

		GFForms::include_feed_addon_framework();

		GFAddOn::register( 'GFP_Third_Party_Post_Addon' );

	}

	/**
	 * Return GF Add-On object
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return GFP_Third_Party_Post_Addon
	 */
	public function get_addon_object() {

		return GFP_Third_Party_Post_Addon::get_instance();

	}


}