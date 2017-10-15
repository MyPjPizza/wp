<?php

//* Geo1280 Theme Setting Defaults
add_filter( 'genesis_theme_settings_defaults', 'geo1280_theme_defaults' );
function geo1280_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 5;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'sidebar-content-sidebar';

	return $defaults;

}

//* Geo1280 Theme Setup
add_action( 'after_switch_theme', 'geo1280_theme_setting_defaults' );
function geo1280_theme_setting_defaults() {

	_genesis_update_settings( array(
		'blog_cat_num'              => 5,	
		'content_archive'           => 'full',
		'content_archive_limit'     => 0,
		'content_archive_thumbnail' => 0,
		'posts_nav'                 => 'numeric',
		'site_layout'               => 'sidebar-content-sidebar',
	) );

	update_option( 'posts_per_page', 5 );

}

//* Simple Social Icon Defaults
add_filter( 'simple_social_default_styles', 'geo1280_social_default_styles' );
function geo1280_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#333333',
		'background_color_hover' => '#555555',
		'border_radius'          => 3,
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 36,
	);
		
	$args = wp_parse_args( $args, $defaults );
	
	return $args;
	
}