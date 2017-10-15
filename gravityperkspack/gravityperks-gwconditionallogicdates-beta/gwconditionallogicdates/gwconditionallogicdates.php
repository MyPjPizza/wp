<?php
/**
* Plugin Name: GP Conditional Logic Dates
* Description: Allows Date fields to be used in Gravity Forms conditional logic.
* Plugin URI: http://gravitywiz.com/
* Version: 1.0.beta5.7
* Author: David Smith
* Author URI: http://gravitywiz.com/
* License: GPL2
* Perk: True
*/

/**
* Saftey net for individual perks that are active when core Gravity Perks plugin is inactive.
*/
$gw_perk_file = __FILE__;
if(!require_once(dirname($gw_perk_file) . '/safetynet.php'))
    return;

class GWConditionalLogicDates extends GWPerk {

    protected $version = '1.0.beta5.7';
    protected $min_gravity_forms_version = '1.7.2.6';
    protected $min_wp_version = '3.4.2';

    public static $instance;

    function init() {

        require_once( $this->get_base_path() . '/includes/class-gw-conditional-logic-date-fields.php' );
        self::$instance = new GWConditionalLogicDateFields();

    }

    function documentation() {
        return array(
	        'type'   => 'url',
	        'value'  => 'http://gravitywiz.com/gp-conditional-logic-dates-first-draft/'
        );
    }

}