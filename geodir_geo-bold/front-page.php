<?php
/**
 * If you do not set GeoDirectory to be your homepage, this file will be used instead.
 */

	
//* Add geobold-home body class
add_filter( 'body_class', 'geobold_body_class' );

add_action( 'genesis_meta', 'geobold_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function geobold_home_genesis_meta() {

	if ( is_active_sidebar( 'home-featured' ) || is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) || is_active_sidebar( 'home-bottom' ) ) {

		//* Force full-width-content layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

		//* Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Add home featured area
		add_action( 'genesis_after_header', 'geobold_home_featured_widget' );
		
		//* Add home widget area
		add_action( 'genesis_before_footer', 'geobold_home_widgets', 1 );

	}
}

function geobold_body_class( $classes ) {

		$classes[] = 'geobold-home';
		return $classes;
		
}

function geobold_home_featured_widget() {

	genesis_widget_area( 'home-featured', array(
		'before' => '<div class="home-featured full-width widget-area"><div class="wrap">',
		'after' => '</div></div>',
	) );

}

function geobold_home_widgets() {

	if ( is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) ) {
		
		echo '<div class="home-middle"><div class="wrap">';
		
			genesis_widget_area( 'home-middle-1', array(
				'before' => '<div class="home-middle-1 widget-area">',
				'after'  => '</div>',
			) );
			
			genesis_widget_area( 'home-middle-2', array(
				'before' => '<div class="home-middle-2 widget-area">',
				'after'  => '</div>',
			) );
			
			genesis_widget_area( 'home-middle-3', array(
				'before' => '<div class="home-middle-3 widget-area">',
				'after'  => '</div>',
			) );
			
		echo '</div></div>';
		
	}
	
	genesis_widget_area( 'home-bottom', array(
		'before' => '<div class="home-bottom full-width widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
