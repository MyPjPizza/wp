<?php
/*
Author: GeoDirectory
URL: http://wpgeodirectory.com/
*/
if (!defined('GDF_VERSION')) define('GDF_VERSION', '1.2.8');
/**
 * CHANGE GEODIRECTORY WRAPPERS TO MATCH THEME
 */
// action for adding the wrapper div opening tag
remove_action( 'geodir_wrapper_open', 'geodir_action_wrapper_open', 10 );
add_action( 'geodir_wrapper_open', 'gdf_action_wrapper_open', 9 );
function gdf_action_wrapper_open(){
echo '<div id="geodir_wrapper" class="geodir-home">';
}
// action for adding the wrapper div closing tag
remove_action( 'geodir_wrapper_close', 'geodir_action_wrapper_close', 10);
add_action( 'geodir_wrapper_close', 'gdf_action_wrapper_close', 11);
function gdf_action_wrapper_close(){echo '</div></div><!-- content ends here-->';}

//add_action( 'geodir_before_main_content', 'gdf_action_geodir_common', 10);
function gdf_action_geodir_common(){echo '<div class="clearfix geodir-common">';}

// action for adding the content div opening tag
remove_action( 'geodir_wrapper_content_open', 'geodir_action_wrapper_content_open', 10 );
add_action( 'geodir_wrapper_content_open', 'gdf_action_wrapper_content_open', 9, 3 );
function gdf_action_wrapper_content_open($type='',$id='',$class=''){
if($type=='home-page' && $width = get_option('geodir_width_home_contant_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='listings-page' && $width = get_option('geodir_width_listing_contant_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='search-page' && $width = get_option('geodir_width_search_contant_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='author-page' && $width = get_option('geodir_width_author_contant_section') ) { $width_css = 'style="width:'.$width.'%;"'; }else{$width_css = '';}
echo '<div id="geodir_content" class="'.$class.'" role="main" '. $width_css.'>';
}
// action for adding the primary div closing tag
remove_action( 'geodir_wrapper_content_close', 'geodir_action_wrapper_content_close', 10);
add_action( 'geodir_wrapper_content_close', 'gdf_action_wrapper_content_close', 11);
function gdf_action_wrapper_content_close(){echo '</div><!-- inner-content ends here-->';}

// action for adding the sidebar opening tag
remove_action( 'geodir_main_content_open', 'geodir_action_main_content_open', 10);
remove_action( 'geodir_main_content_close', 'geodir_action_main_content_close', 10);



// action for adding the sidebar opening tag
remove_action( 'geodir_sidebar_right_open', 'geodir_action_sidebar_right_open', 10 );
add_action( 'geodir_sidebar_right_open', 'gdf_action_sidebar_right_open', 10, 4 );
function gdf_action_sidebar_right_open($type='',$id='',$class='',$itemtype=''){
if($type=='home-page' && $width = get_option('geodir_width_home_right_section') ) {$width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='listings-page' && $width = get_option('geodir_width_listing_right_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='search-page' && $width = get_option('geodir_width_search_right_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='author-page' && $width = get_option('geodir_width_author_right_section') ) { $width_css = 'style="width:'.$width.'%;"'; }else{$width_css = '';}
echo '<aside  id="gd-sidebar-wrapper" class="sidebar '.$class.'" role="complementary" itemscope itemtype="'.$itemtype.'" '.$width_css.'>';
}

// action for adding the sidebar opening tag
remove_action( 'geodir_sidebar_left_open', 'geodir_action_sidebar_left_open', 10 );
add_action( 'geodir_sidebar_left_open', 'gdf_action_sidebar_left_open', 10, 4 );
function gdf_action_sidebar_left_open($type='',$id='',$class='',$itemtype=''){
if($type=='home-page' && $width = get_option('geodir_width_home_left_section') ) {$width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='listings-page' && $width = get_option('geodir_width_listing_left_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='search-page' && $width = get_option('geodir_width_search_left_section') ) { $width_css = 'style="width:'.$width.'%;"'; }
elseif($type=='author-page' && $width = get_option('geodir_width_author_left_section') ) { $width_css = 'style="width:'.$width.'%;"'; }else{$width_css = '';}
echo '<aside  id="gd-sidebar-wrapper" class="sidebar '.$class.'" role="complementary" itemscope itemtype="'.$itemtype.'" '.$width_css.'>';
}




/**
 * Add Redux Framework core
 */
add_action( 'redux/construct', 'gdf_run_compiler', 10, 1 );
function gdf_run_compiler($all){
	/* Get the old database version. */
	$old_db_version = get_option( 'gdf_db_version' );
	if ( empty( $old_db_version ) ){ $old_db_version =1;}

    // if updated version, run the compiler.
	if (  $old_db_version  < GDF_VERSION  ){
        $all->run_compiler = true;
        $tr = get_option( 'gdf-transients', array() );
        $tr['run_compiler']   = 1;
        $tr['last_save_mode'] = "defaults";
        update_option('gdf-transients',$tr);

    }

	return $all;
}
	
if (!defined('GEODIRECTORY_FRAMEWORK')) define('GEODIRECTORY_FRAMEWORK', 'geodirectory_framework');	
  
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/options/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/options/ReduxCore/framework.php' );
}


/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';

// LOAD GEODIRECTORY_FRAMEWORK CORE (if you remove this, the theme will break)
require_once( 'library/geodirectory_framework.php' );

/**
 * Add auto update script
 */
function gdf_theme_updater() {
    require( get_template_directory() . '/updater/theme-updater.php' );
}
if(is_admin()){
    add_action( 'after_setup_theme', 'gdf_theme_updater' );
}


/*********************
LAUNCH GEODIRECTORY_FRAMEWORK
Let's get everything up and running.
*********************/
if (!function_exists('geodirf_ahoy')) {
function geodirf_ahoy() {
	
  // let's get language support going, if you need it
  load_theme_textdomain( GEODIRECTORY_FRAMEWORK, get_stylesheet_directory() . '/languages' );
  // launching operation cleanup
  add_action( 'init', 'geodirf_head_cleanup' );
  // A better title
  $version = get_bloginfo('version');
  if ($version < 4.0 ) {
      add_filter('wp_title', 'rw_title', 10, 3);
  }
  // remove WP version from RSS
  add_filter( 'the_generator', 'geodirf_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'geodirf_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'geodirf_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'geodirf_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'geodirf_scripts_and_styles', 999 );
  add_action( 'admin_enqueue_scripts', 'geodirf_scripts_and_styles_admin', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  geodirf_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'geodirf_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'geodirf_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'geodirf_excerpt_more' );

} /* end GeoDirectory Framework ahoy */
}

// let's get this party started
add_action( 'after_setup_theme', 'geodirf_ahoy' );


/* Hook your version check to 'init' to run it on every page. You can use 'admin_menu' to just run it in the admin. */
add_action( 'init', 'gdf_version_check' );

/* Checks the version number and runs install or update functions if needed. */
if (!function_exists('gdf_version_check')) {
function gdf_version_check() {
	/* Get the old database version. */
	$old_db_version = get_option( 'gdf_db_version' );

	/* If there is no old database version, run the install. */
	if ( empty( $old_db_version ) )
		gdf_install();

	/* If the old version is less than the new version, run the update. */
	elseif (  $old_db_version  < GDF_VERSION  )
		gdf_update();
}
}


/* Function for installing your theme/plugin settings. */
if (!function_exists('gdf_install')) {
function gdf_install() {

	/* Add the database version setting. */
	add_option( 'gdf_db_version', GDF_VERSION );

	/* Add your default theme/plugin settings here. */
	// add_option();
}
}


/* Function for updating your theme/plugin settings. */
if (!function_exists('gdf_update')) {
function gdf_update() {
	/* Update the database version setting. */
	update_option( 'gdf_db_version', GDF_VERSION );


	/* Update the user's new theme/plugin settings here if there are new settings. */
	// get_option(); // Get the previous settings.
	// You'd need to merge the old settings and new settings here.
	// update_option(); // Update the settings.
}
}




/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'geodirf-thumb-600', 600, 150, true );
add_image_size( 'geodirf-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'geodirf-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'geodirf-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'geodirf_custom_image_sizes' );

if (!function_exists('geodirf_custom_image_sizes')) {
function geodirf_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'geodirf-thumb-600' => __('600px by 150px',GEODIRECTORY_FRAMEWORK),
        'geodirf-thumb-300' => __('300px by 100px',GEODIRECTORY_FRAMEWORK),
    ) );
}
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
if (!function_exists('geodirf_register_sidebars')) {
function geodirf_register_sidebars() {
	global $gdf;

		$before_widget = apply_filters( 'geodir_before_widget','<section id="%1$s" class="widget geodir-widget %2$s">' );
		$after_widget = apply_filters( 'geodir_after_widget','</section>' );
		$before_title = apply_filters( 'geodir_before_title','<h3 class="widget-title">' );
		$after_title = apply_filters( 'geodir_after_title','</h3>' );
		
		
	register_sidebar(array(
		'id' => 'blog-details',
		'name' => __( 'GD Blog Details', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The first (primary) sidebar.', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	
	register_sidebar(array(
		'id' => 'blog-listing',
		'name' => __( 'GD Blog Listing', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The first (primary) sidebar.', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	
	register_sidebar(array(
		'id' => 'page-details',
		'name' => __( 'GD Page Details', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The first (primary) sidebar.', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	
	if(!empty($gdf) && $gdf['footer-widgets']>0){
	register_sidebar(array(
		'id' => 'footer-1',
		'name' => __( 'GD Footer 1', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The first footer', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	}
	
	if(!empty($gdf) && $gdf['footer-widgets']>1){
	register_sidebar(array(
		'id' => 'footer-2',
		'name' => __( 'GD Footer 2', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The second footer', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	}
	
	if(!empty($gdf) && $gdf['footer-widgets']>2){
	register_sidebar(array(
		'id' => 'footer-3',
		'name' => __( 'GD Footer 3', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The third footer', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	}
	
	if(!empty($gdf) && $gdf['footer-widgets']>3){
	register_sidebar(array(
		'id' => 'footer-4',
		'name' => __( 'GD Footer 4', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The forth footer', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	}

	register_sidebar(array(
		'id' => 'header-right',
		'name' => __( 'GD Header Right', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'Right side of header', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	
	if(!empty($gdf) && !$gdf['head-gdf-adminbar']){
	register_sidebar(array(
		'id' => 'admin-bar-left',
		'name' => __( 'GD Admin Bar Left', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'Left side of admin bar', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	
	register_sidebar(array(
		'id' => 'admin-bar-right',
		'name' => __( 'GD Admin Bar Right', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'Right side of admin bar', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));
	}

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', GEODIRECTORY_FRAMEWORK ),
		'description' => __( 'The second (secondary) sidebar.', GEODIRECTORY_FRAMEWORK ),
		'before_widget' => $before_widget,
		'after_widget' => $after_widget,
		'before_title' => $before_title ,
		'after_title' => $after_title,
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!
}

/************* COMMENT LAYOUT *********************/

// Comment Layout
if (!function_exists('geodirf_comments')) {
function geodirf_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>

<div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
<article  class="cf">
  <header class="comment-author vcard">
    <?php
    // custom gravatar call
    /**
     * Filter to modify comment avatar size
     *
     * You can use this filter to change comment avatar size.
     *
     * @since 1.2.5
     * @package GeoDirectory_framework
     */
    $avatar_size = apply_filters('geodir_comment_avatar_size', 44);
    echo get_avatar($comment, $avatar_size);
       // end custom gravatar call ?>
    <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', GEODIRECTORY_FRAMEWORK ), get_comment_author_link(), edit_comment_link(__( '(Edit)', GEODIRECTORY_FRAMEWORK ),'  ','') ) ?>
    <time datetime="<?php echo comment_time('c'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
      <?php comment_time(__( 'F jS, Y', GEODIRECTORY_FRAMEWORK )); ?>
      </a></time>
  </header>
  <?php if ($comment->comment_approved == '0') : ?>
  <div class="alert alert-info">
    <p>
      <?php _e( 'Your comment is awaiting moderation.', GEODIRECTORY_FRAMEWORK ) ?>
    </p>
  </div>
  <?php endif; ?>
  <section class="comment_content cf">
    <?php comment_text() ?>
  </section>
  <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
</article>
<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!
}

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
if (!function_exists('geodirf_fonts')) {
function geodirf_fonts() {
  wp_register_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  wp_enqueue_style( 'googleFonts');
}
}

add_action('wp_print_styles', 'geodirf_fonts');



if (!function_exists('geodirf_get_image_params')) {
function geodirf_get_image_params( $url ) {
 
	// Split the $url into two parts with the wp-content directory as the separator.
	$parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
 
	// Get the host of the current site and the host of the $url, ignoring www.
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
 
	// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
	if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}
 
	// Now we're going to quickly search the DB for any attachment GUID with a partial path match.
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;
 
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parse_url[1] ) );
 
	if( $attachment[0]){
		$img = wp_get_attachment_image_src( $attachment[0]);
		return array(
			'url' => $img[0],
            'id' => $attachment[0],
            'height' => $img[2],
            'width' => $img[1],
            'thumbnail' => $img[0]);
	}else{return false;}
	   
	   
	return $attachment[0];
}
}


add_filter( 'redux/field/gdf/output_css', 'gdf_output_only_changed', 10, 1 );

if (!function_exists('gdf_output_only_changed')) {
function gdf_output_only_changed($field){
global	$gdf;
if($field['compiler']==''){return $field;}

if($field['id']=='home_top_widget'){$field['compiler']='';}
if($field['id']=='home_site_width'){$field['compiler']='';}
if($field['id']=='body-background-gradient'){$field['compiler']='';}
if($field['id']=='footer-background-gradient'){$field['compiler']='';}
if($field['id']=='head-background-gradient'){$field['compiler']='';}
if($field['id']=='head-menu-background-gradient'){$field['compiler']='';}
if($field['id']=='head-menu-radius'){$field['compiler']='';}

if($field['type']=='spacing'){
	if($gdf[$field['id']] == $field['default'] ){$field['compiler']='';}
}elseif($field['type']=='typography'){
	$changed = false;
	if($gdf[$field['id']]['font-family'] != $field['default']['font-family']){$changed = true;}
	if($gdf[$field['id']]['font-weight'] != $field['default']['font-weight']){$changed = true;}
	if($gdf[$field['id']]['font-size'] != $field['default']['font-size']){$changed = true;}
	if($gdf[$field['id']]['line-height'] != $field['default']['line-height']){$changed = true;}
	if($gdf[$field['id']]['color'] != $field['default']['color']){$changed = true;}
	
	if(!$changed){$field['compiler']='';}
	
}elseif($field['type']=='background'){
	$changed = false;
	if(isset($gdf[$field['id']]['background-color']) && $gdf[$field['id']]['background-color'] != $field['default']['background-color'] ){$changed = true;}
	if(isset($gdf[$field['id']]['background-repeat']) && $gdf[$field['id']]['background-repeat'] !=''){$changed = true;}
	if(isset($gdf[$field['id']]['background-size']) && $gdf[$field['id']]['background-size'] !=''){$changed = true;}
	if(isset($gdf[$field['id']]['background-attachment']) && $gdf[$field['id']]['background-attachment'] !=''){$changed = true;}
	if(isset($gdf[$field['id']]['background-position']) && $gdf[$field['id']]['background-position'] !=''){$changed = true;}
	if(isset($gdf[$field['id']]['background-image']) && $gdf[$field['id']]['background-image'] !=''){$changed = true;}
	
	if(!$changed){$field['compiler']='';}
}elseif($field['type']=='color'){
	if($gdf[$field['id']] == $field['default'] ){$field['compiler']='';}
}elseif($field['type']=='border'){
	sort($gdf[$field['id']]);sort($field['default']);
	if($gdf[$field['id']] == $field['default'] ){$field['compiler']='';}
}elseif($field['type']=='link_color'){
	if($gdf[$field['id']] == $field['default'] ){$field['compiler']='';}
}
elseif($field['type']=='switch'){$field['compiler']='';}
 
	return $field;
}
}

function gdf_removeDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'gdf_removeDemoModeLink');
/* DON'T DELETE THIS CLOSING TAG */ ?>