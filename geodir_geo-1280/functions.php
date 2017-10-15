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
//add_action( 'wp_enqueue_scripts', 'genesis_load_stylesheet');
add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet');

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
//load_child_theme_textdomain( 'geo1280', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'geo1280' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Geo1280 Theme', 'geo1280' ) );
define( 'CHILD_THEME_URL', 'https://wpgeodirectory.com/' );
define( 'CHILD_THEME_VERSION', '1.0.3' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'geo1280_enqueue_scripts_styles' );
function geo1280_enqueue_scripts_styles() {

	wp_enqueue_script( 'geo1280-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lora:400,700|Oswald:400', array(), PARENT_THEME_VERSION );

}

//* Add new featured image size
add_image_size( 'grid-featured', 270, 100, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 320,
	'height'          => 65,
	'header-selector' => '.site-header .title-area',
	'header-text'     => false
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'geo1280_after_entry', 5 );
function geo1280_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
	) );

}

//* Add support for additional color styles
add_theme_support( 'genesis-style-selector', array(
	'geo1280-blue'  => __( 'Geo1280 Blue', 'geo1280' ),
	'geo1280-green' => __( 'Geo1280 Green', 'geo1280' ),
	'geo1280-red'   => __( 'Geo1280 Red', 'geo1280' )
) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Unregister the header right widget area
unregister_sidebar( 'header-right' );

//* Remove breadcrumb and navigation meta boxes
add_action( 'genesis_theme_settings_metaboxes', 'geo1280_remove_genesis_metaboxes' );
function geo1280_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {

    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 12 );

//* Remove output of primary navigation right extras
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'geo1280_secondary_menu_args' );
function geo1280_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'geo1280_remove_comment_form_allowed_tags' );
function geo1280_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'geo1280_author_box_gravatar' );
function geo1280_author_box_gravatar( $size ) {

	return 128;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'geo1280_comments_gravatar' );
function geo1280_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;

	return $args;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add My Custom Footer Links
add_filter('genesis_footer_creds_text', 'custom_footer_creds_text');
function custom_footer_creds_text($creds) {
 $creds = '[footer_copyright] ' . get_bloginfo('name') . ' &bull; Genesis Child Theme by <a href="https://wpgeodirectory.com/">GeoDirectory</a>';
 return  $creds;
}


//* GeoDirectory ****************************************
//* Add body class on location pages
add_filter('body_class', 'geo1280_body_class');
function geo1280_body_class( $classes ) {
	if ( geodir_is_page('location') ) {
		$classes[] = 'geo1280-location';
	}
	return $classes;
}

//* Add page descriptions
remove_action( 'geodir_listings_page_title', 'geodir_action_listings_title',10);
remove_action( 'geodir_add_listing_page_title', 'geodir_action_add_listing_page_title',10);
remove_action( 'geodir_details_main_content', 'geodir_action_page_title',20);
remove_action( 'geodir_search_page_title', 'geodir_action_search_page_title',10);
remove_action( 'geodir_author_page_title', 'geodir_action_author_page_title',10);
add_action( 'genesis_before_content_sidebar_wrap', 'geo1280_page_title', 10 );
remove_action('geodir_before_listing', 'gd_genesis_listing_page_title_bar', 9);
function geo1280_page_title() {
	$title = '';
	if ( geodir_is_page('location') ) {
		return;
	}
	if ( is_front_page() && get_option('geodir_set_as_home') && !isset($_GET['geodir_signup']) ) {
		if ( is_active_sidebar( 'home-intro' ) ) {
			genesis_widget_area( 'home-intro', array(
				'before' 		=> '<div class="home-intro">',
				'after'  		=> '</div>',
			) );
		}
		return;
	}
	if( isset($_GET['geodir_signup']) ) {
		$title = 'Sign In / Register';
	}
	if( geodir_is_page('listing') ) {
		ob_start(); // Start buffering;
		geodir_action_listings_title();
		$gd_title = ob_get_clean();
		$title_p = explode('">',$gd_title);
		$title = str_replace('</h1></header>','',$title_p[2]);
	}
	if( geodir_is_page('add-listing') ) {
		ob_start() ; // Start buffering;
		geodir_action_add_listing_page_title();
		$gd_title = ob_get_clean();
		$gd_title = str_replace('<h1 class="entry-title fn">','',$gd_title);
		$title = str_replace('</h1>','',$gd_title);
	}
	if( geodir_is_page('detail') ) {
		$title = get_the_title();
	}
	if( geodir_is_page('search') ) {
		ob_start(); // Start buffering;
		geodir_action_search_page_title();
		$gd_title = ob_get_clean();
		$gd_title = str_replace('<h1 class="entry-title fn">','',$gd_title);
		$title = str_replace('</h1>','',$gd_title);
	}
	if( geodir_is_page('author') ) {
		ob_start() ; // Start buffering;
		geodir_action_author_page_title();
		$gd_title = ob_get_clean();
		$gd_title = str_replace('<h1>',"",$gd_title);
		$title = str_replace('</h1>',"",$gd_title);
	}
	if( ! $title ) {
		if( is_archive() ) {
			if ( is_author() ) {
				$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $_GET['author_name'] ) : get_user_by(  'id', get_the_author_meta('ID') );
				$title = $curauth->nickname;
			} else {
				$title = single_cat_title( '', false );
			}
		} else {
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
			$title = get_the_title();
		}
	}
	
	echo '<header><h1 class="main-page-title">' . $title . '</h1></header>';
}

//* Move breadcrumb
remove_action( 'genesis_after_header', 'geodir_replace_breadcrumb', 20 );
add_action( 'genesis_before_content_sidebar_wrap', 'geodir_replace_breadcrumb', 20 );

//* Add search bar
add_action( 'genesis_after_header', 'geo1280_search_bar', 20 );
function geo1280_search_bar() {
	if ( is_active_sidebar( 'search-bar' ) ) {
		genesis_widget_area( 'search-bar', array(
			'before' => '<div class="search-bar widget-area"><div class="wrap">',
			'after' => '</div></div>',
		) );
	} else {
		echo '<div class="geo1280-placeholder"></div>';
	}
}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-intro',
	'name'        => __( 'Home Intro', 'geo1280' ),
	'description' => __( 'This is the home intro widget area.', 'geo1280' ),
) );
genesis_register_sidebar( array(
	'id'          => 'search-bar',
	'name'        => __( 'Search Bar', 'geo1280' ),
	'description' => __( 'This is the search bar widget area.', 'geo1280' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'geo1280' ),
	'description' => __( 'This is the after entry widget area.', 'geo1280' ),
) );
