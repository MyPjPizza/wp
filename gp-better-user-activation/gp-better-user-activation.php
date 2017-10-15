<?php
/**
 * Plugin Name: GP Better User Activation
 * Plugin URI: https://gravitywiz.com/
 * Description: Take control of your Gravity Forms User Activation page.
 * Version: 1.0
 * Author: Gravity Wiz
 * Author URI: https://gravitywiz.com/
 * Text Domain: gp-better-user-activation
 * Domain Path: /languages
 * Perk: True
 */

require 'includes/class-gp-bootstrap.php';

$gp_better_user_activation = new GP_Bootstrap( 'class-gp-better-user-activation.php', __FILE__ );