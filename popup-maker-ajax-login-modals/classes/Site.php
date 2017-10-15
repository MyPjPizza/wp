<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PUM_ALM Site class
 *
 * @since       1.2.0
 */
class PUM_ALM_Site {

	/**
	 * Initialize Hooks & Filters
	 */
	public static function init() {
		PUM_ALM_Site_Assets::init();

	}

}
