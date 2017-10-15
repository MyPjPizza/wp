<?php

/**
 * Show WP Easy Updates required admin notification.
 */
if(is_admin()){
	if (!function_exists('ayecode_show_update_plugin_requirement')) {//only load the update file if needed
		function ayecode_show_update_plugin_requirement() {
			if ( !defined( 'WP_EASY_UPDATES_ACTIVE' ) ) {
				?>
				<div class="notice notice-warning is-dismissible">
					<p>
						<strong>
							<?php
							echo sprintf( __( 'The plugin %sWP Easy Updates%s is required to check for and update some installed plugins/themes, please install it now.', 'geodirectory' ), '<a href="https://wpeasyupdates.com/" target="_blank" title="WP Easy Updates">', '</a>' );
							?>
						</strong>
					</p>
				</div>
				<?php
			}
		}

		add_action( 'admin_notices', 'ayecode_show_update_plugin_requirement' );
	}
}

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Geo Travel Theme', 'geotravel' ) );
define( 'CHILD_THEME_URL', 'https://wpgeodirectory.com/' );
define( 'CHILD_THEME_VERSION', '1.0.2' );

//* Add Homepage Image upload to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'geotravel_google_fonts' );
function geotravel_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'geotravel_scripts' );
function geotravel_scripts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'geotravel-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
		
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'caption', ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 60,
	'width'           => 320,
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

/*//* Reposition the simple share buttons
add_action( 'genesis_header', 'bg_simple_share', 11 );
function bg_simple_share() {

	if( 'post' === get_post_type() ) {
		genesis_share_icon_output( 'genesis_header', array(  'twitter', 'facebook', 'googlePlus' ) );
	}

}
*/
//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'geotravel_secondary_menu_args' );
function geotravel_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'geotravel_after_entry', 5 );
function geotravel_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'geotravel_remove_comment_form_allowed_tags' );
function geotravel_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add My Custom Footer Links
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text($creds) {
 $creds = '[footer_copyright] ' . get_bloginfo('name') . ' &bull; <a href="https://wpgeodirectory.com/">Geo Travel Theme</a> by <a href="https://wpgeodirectory.com/">GeoDirectory</a>';
 return  $creds;
}

//* Add Discliamer to Footer
add_action( 'genesis_footer', 'geotravel_disclaimer' );
	function geotravel_disclaimer() {
		genesis_widget_area( 'disclaimer', array(
			'before' => '<div class="disclaimer widget-area">',
			'after'  => '</div>',
		) );
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-featured-left',
	'name'        => __( 'Home Featured Left', 'geotravel' ),
	'description' => __( 'This is the home featured left widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-featured-right',
	'name'        => __( 'Home Featured Right', 'geotravel' ),
	'description' => __( 'This is the home featured right widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home Top', 'geotravel' ),
	'description' => __( 'This is the home top widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home Middle', 'geotravel' ),
	'description' => __( 'This is the home middle widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home Bottom', 'geotravel' ),
	'description' => __( 'This is the home bottom widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'geotravel' ),
	'description' => __( 'This is the after entry widget area.', 'geotravel' ),
) );
genesis_register_sidebar( array(
	'id'          => 'disclaimer',
	'name'        => __( 'Disclaimer', 'geotravel' ),
	'description' => __( 'This is the disclaimer section of the footer.', 'geotravel' ),
) );
