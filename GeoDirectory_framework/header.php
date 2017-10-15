<?php if(isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))header('X-UA-Compatible: IE=edge,chrome=1');// Google Chrome Frame for IE ?>
<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<meta charset="utf-8" />
<?php // mobile meta (hooray!) ?>
<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php global $gdf;?>
<link rel="apple-touch-icon" href="<?php echo $gdf['site_apple_touch_icon']['url']; ?>">
<link rel="icon" href="<?php echo $gdf['site_favicon']['url']; ?>">
<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo $gdf['site_favicon']['url']; ?>">
<![endif]-->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php // wordpress head functions ?>
<?php wp_head(); ?>
<?php // end of wordpress head ?>
<?php // drop Google Analytics Here ?>
<?php // end analytics ?>
</head>
<body <?php body_class(); ?>>
<div id="container">
<header class="header" >
  <?php global $gdf; if(!empty($gdf) && !$gdf['head-gdf-adminbar']){
	  if(!empty($gdf) && !$gdf['head-gdf-adminbar-fixed']){
	  ?>
  <style>html {margin-top: 31px !important;}.geodirf-ab{position:fixed;width:100%;top:0;left:0;z-index:1005;}</style>
<?php }?>
  <div class="geodirf-ab">
    <div class="geodirf-ab-wrap">
      <div class="geodirf-ab-left">
        <?php dynamic_sidebar('admin-bar-left');?>
      </div>
      <div class="geodirf-ab-right">
        <?php dynamic_sidebar('admin-bar-right');?>
      </div>
    </div>
  </div>
  <?php }?>
  <a class="mobile-left" href="#mobile-navigation-left"><i class="fa fa-bars"></i></a>
  <?php if(!empty($gdf) && !$gdf['head-mobile-login']){?>
  <a class="mobile-right" href="#mobile-navigation-right"><i class="fa fa-user"></i></a>
  <div id="mobile-navigation-right">
    <div>
      <?php if(class_exists('geodir_loginwidget')){ the_widget( 'geodir_loginwidget',  'mobile-login-widget', array('before_title'=>'<strong class="mobile-login-widget-title">','after_title'=>'</strong>'));}?>
    </div>
  </div>
  <?php }?>
  <div id="inner-header" class="wrap cf">
    <?php if ( isset( $gdf['site_logo']) &&  isset( $gdf['site_logo']['url']) && $gdf['site_logo']['url'] ) : ?>
    <div class='site-logo'> <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo $gdf['site_logo']['url']; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a> </div>
    <?php else : ?>
    <div class='site-logo'>
      <h1 class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
        <?php bloginfo( 'name' ); ?>
        </a></h1>
      <h2 class='site-description'>
        <?php bloginfo( 'description' ); ?>
      </h2>
    </div>
    <?php endif; ?>
    <?php if ( is_active_sidebar( 'header-right' ) ) {?>
    <div class="header-right-area">
      <?php dynamic_sidebar('header-right');?>
    </div>
    <?php }?>
    <nav role="navigation" id="mobile-navigation-left">
      <?php 
	  global $wp_query;
	 
	  wp_nav_menu(array(
    					'container' => false,                           // remove nav container
    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					//'menu' => __( 'The Main Menu', GEODIRECTORY_FRAMEWORK ),  // nav name // removed because it was breaking WPML lang switcher
    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					'theme_location' => 'main-nav',                 // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>
    </nav>
  </div>
</header>