<?php 
/**
 * Plugin Name: GP Multi-page Form Navigation
 * Description: Navigate between form pages quickly by converting the page steps into page links or creating your own custom page links.
 * Plugin URI: http://gravitywiz.com/
 * Version: 1.0.beta2.5
 * Author: David Smith <david@gravitywiz.com>
 * Author URI: http://gravitywiz.com
 * License: GPLv2
 * Perk: True
 */

require 'includes/class-gp-bootstrap.php';

$gp_multi_page_navigation_bootstrap = new GP_Bootstrap( 'class-gp-multi-page-navigation.php', __FILE__ );