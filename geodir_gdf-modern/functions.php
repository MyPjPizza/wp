<?php
/*#############################################
HERE YOU CAN ADD YOUR OWN FUNCTIONS OR REPLACE FUNCTONS IN THE PARENT THEME
#############################################*/

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

// Here we define the textdomain for the child theme, if changing you should also replace it in the function below. 
if (!defined('GDF_CHILD')) define('GDF_CHILD', 'gdf_modern');
define('CHILD_THEME_VERSION', '1.0.4');

add_action('after_setup_theme', 'gdf_modern_setup');
function gdf_modern_setup()
{
    // load_child_theme_textdomain( GDF_CHILD, get_stylesheet_directory() . '/languages' ); // uncomment this if you plan to use translation

    // REMOVE BREADCRUMB
    remove_action('geodir_detail_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_listings_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_author_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_search_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_home_before_main_content', 'geodir_breadcrumb', 20);
    remove_action('geodir_location_before_main_content', 'geodir_breadcrumb', 20);
    // PUT BREADCRUMBS BACK EARLIER
    add_action('geodir_wrapper_open', 'gdf_modern_geodir_breadcrumb', 5);
    add_action('geodir_wrapper_open', 'gdf_modern_geodir_breadcrumb', 5);
    add_action('geodir_wrapper_open', 'gdf_modern_geodir_breadcrumb', 5);
    add_action('geodir_wrapper_open', 'gdf_modern_geodir_breadcrumb', 5);
    add_action('geodir_wrapper_open', 'gdf_modern_geodir_breadcrumb', 5);
    // CHANGE MAIN WRAPPER MARKUP
    remove_action('geodir_wrapper_open', 'gdf_action_wrapper_open', 9);
    add_action('geodir_wrapper_open', 'gdf_modern_action_wrapper_open', 9);
    // ENQUEUE GOOGLE FONTS
    add_action('wp_enqueue_scripts', 'gdfmodern_google_fonts');
    function gdfmodern_google_fonts()
    {

        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Lato:300,700|Roboto:700,300,400', array(), CHILD_THEME_VERSION);

    }

}

// Functions
function gdf_modern_geodir_breadcrumb()
{
    echo '<div id="breadcrumb-wrapper">';
    geodir_breadcrumb();
    echo '</div>';
}

function gdf_modern_action_wrapper_open()
{
    if (geodir_is_page('location') || (is_front_page() && get_option('geodir_set_as_home'))) {
        echo '<div id="geodir_wrapper" class="gdf-modern-home">';
    } else {
        echo '<div id="geodir_wrapper">';
    }
}


add_action('wp_enqueue_scripts', 'gdf_modern_enqueue_styles');
function gdf_modern_enqueue_styles()
{
    $parent_style = 'geodirf-stylesheet';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-geodirf-stylesheet', get_stylesheet_directory_uri() . '/style.css', array($parent_style)
    );

}