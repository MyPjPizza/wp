<?php
/**
 * Plugin Name: GP Unique ID
 * Description: Generate unique IDs (i.e. reference numbers, codes, invoice numbers, etc.) on submission for your Gravity Form entries.
 * Plugin URI: http://gravitywiz.com/documentation/gp-unique-id/
 * Version: 1.2.6
 * Author: David Smith
 * Author URI: http://gravitywiz.com/
 * License: GPL2
 * Perk: True
 * Text Domain: gp-unique-id
 * Domain Path: /languages
 */

class GP_Unique_ID_Bootstrap {

	public static $_file = __FILE__;

    public static function load() {
        require_once( 'class-gp-unique-id.php' );
    }

}

add_action( 'gperks_loaded', array( 'GP_Unique_ID_Bootstrap', 'load' ), 5 );