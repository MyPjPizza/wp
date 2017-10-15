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

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet');
//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization
//load_child_theme_textdomain( 'geobold', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'geobold' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Geo Bold Theme', 'geobold' ) );
define( 'CHILD_THEME_URL', 'https://wpgeodirectory.com/' );
define( 'CHILD_THEME_VERSION', '1.0.5' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'caption', ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Google fonts
add_action( 'wp_enqueue_scripts', 'geobold_google_fonts' );
function geobold_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,700|Roboto:700,300,400', array(), CHILD_THEME_VERSION );
		
}

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'geobold_scripts' );
function geobold_scripts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'geobold-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
		
}

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
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

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'geo-bold-green' => __( 'Geo Bold Green', 'geobold' ),
) );

//* Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'geobold_secondary_menu_args' );
function geobold_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'geobold_after_entry', 5 );
function geobold_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'geobold_remove_comment_form_allowed_tags' );
function geobold_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add My Custom Footer Links
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text($creds) {
 $creds = '[footer_copyright] ' . get_bloginfo('name') . ' &bull; Genesis Child Theme by <a href="https://wpgeodirectory.com/">GeoDirectory</a>';
 return  $creds;
}

//* Add Discliamer to Footer
add_action( 'genesis_footer', 'geobold_disclaimer' );
	function geobold_disclaimer() {
		genesis_widget_area( 'disclaimer', array(
			'before' => '<div class="disclaimer widget-area">',
			'after'  => '</div>',
		) );
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-featured',
	'name'        => __( 'Home - Featured', 'geobold' ),
	'description' => __( 'This is the featured section at the top of the homepage.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-1',
	'name'        => __( 'Home - Middle 1', 'geobold' ),
	'description' => __( 'This is first widget-area in the middle section of the content area on the homepage.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-2',
	'name'        => __( 'Home - Middle 2', 'geobold' ),
	'description' => __( 'This is second widget-area in the middle section of the content area on the homepage.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-3',
	'name'        => __( 'Home - Middle 3', 'geobold' ),
	'description' => __( 'This is third widget-area in the middle section of the content area on the homepage.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'geobold' ),
	'description' => __( 'This is the bottom section of the content area on the homepage.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'geobold' ),
	'description' => __( 'This is the after entry widget area.', 'geobold' ),
) );
genesis_register_sidebar( array(
	'id'          => 'disclaimer',
	'name'        => __( 'Disclaimer', 'geobold' ),
	'description' => __( 'This is the disclaimer section of the footer.', 'geobold' ),
) );

// Geodirectory Functions
add_action( 'geodir_listings_page_title', 'geobold_listing_title_open', 9 );
function geobold_listing_title_open() {
	echo '<div class="geo-bold-listing-title">';
}
add_action( 'geodir_listings_page_description', 'geobold_listing_title_close', 11 );
function geobold_listing_title_close() {
	echo '</div>';
}

add_action('after_setup_theme', 'gd_bold_compat_php_genesis', 12);
function gd_bold_compat_php_genesis()
{

    // REMOVE PAGE TITLES
    add_action('geodir_listings_page_title', 'geodir_action_listings_title', 10);
    add_action('geodir_search_page_title', 'geodir_action_search_page_title', 10);
    add_action('geodir_author_page_title', 'geodir_action_author_page_title', 10);

    remove_action('geodir_before_listing', 'gd_genesis_listing_page_title_bar', 9);


    remove_action('geodir_main_content_open', 'geodir_action_main_content_open', 10, 3);
    add_action('geodir_main_content_open', 'geodir_bold_action_main_content_open', 11, 3);


    add_filter("geodir_post_view_article_extra_class","geodir_bold_article_class",10,1);
}




function geodir_bold_action_main_content_open($type = '', $id = '', $class = '')
{

    $text = '<main id="[id]" class="[class]" role="main">';

    $text = str_replace(array("[id]", "[class]"), array($id, $class), $text);

    echo $text;
}




function geodir_bold_article_class($class){
    $class .= " entry";

    return $class;
}