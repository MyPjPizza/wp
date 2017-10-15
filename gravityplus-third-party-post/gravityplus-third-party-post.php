<?php
/**
 * @wordpress-plugin
 * Plugin Name: Gravity Forms Send to Third-Party API
 * Plugin URI: https://gravityplus.pro/gravity-forms-post-to-third-party-api
 * Description: Send your Gravity Forms submissions to a third-party API
 * Version: 1.5.0
 * Author: gravity+
 * Author URI: https://gravityplus.pro
 * Text Domain: gravityplus-third-party-post
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package   GFP_Third_Party_Post
 * @version   1.5.0
 * @author    gravity+ <support@gravityplus.pro>
 * @license   GPL-2.0+
 * @link      https://gravityplus.pro
 * @copyright 2015-2017 gravity+
 *
 * last updated: January 10, 2017
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {

	die;

}

define( 'GFP_THIRD_PARTY_POST_CURRENT_VERSION', '1.5.0' );

define( 'GFP_THIRD_PARTY_POST_FILE', __FILE__ );

define( 'GFP_THIRD_PARTY_POST_PATH', plugin_dir_path( __FILE__ ) );

define( 'GFP_THIRD_PARTY_POST_URL', plugin_dir_url( __FILE__ ) );

define( 'GFP_THIRD_PARTY_POST_SLUG', plugin_basename( dirname( __FILE__ ) ) );

//Load all of the necessary class files for the plugin
require_once( 'includes/class-loader.php' );

GFP_Third_Party_Post_Loader::load();

$gfp_third_party_post = new GFP_Third_Party_Post();

$gfp_third_party_post->run();