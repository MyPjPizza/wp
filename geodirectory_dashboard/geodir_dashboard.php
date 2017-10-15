<?php
/*
Plugin Name: GeoDirectory Dashboard
Plugin URI: https://wpgeodirectory.com
Description: GeoDirectory Dashboard plugin.
Version: 0.0.1
Author: GeoDirectory team
Author URI: https://wpgeodirectory.com
Update URL: https://wpgeodirectory.com
Update ID: 388371
*/

class GD_Dashboard {

    private static $instance;
    public $pages;

    public static function instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof GD_Dashboard ) ) {
            self::$instance = new GD_Dashboard;
            self::$instance->setup_menus();
            self::$instance->setup_constants();
            self::$instance->includes();
            self::$instance->pages = new GD_Dashboard_Pages;
        }
        return self::$instance;
    }

    public function setup_menus() {
        add_action( 'admin_menu', array( $this, 'admin_menus') );
        add_action( 'current_screen', array( $this, 'display_reviews_by_post_type'), 10, 1 );
    }

    public function setup_constants() {

        if ( ! defined( 'GEODASHBOARD_VERSION' ) ) {
            define( 'GEODASHBOARD_VERSION', "0.0.1" );
        }

        if ( ! defined( 'GEODASHBOARD_TEXTDOMAIN' ) ) {
            define( 'GEODASHBOARD_TEXTDOMAIN', 'geodashboard' );
        }

        if ( ! defined( 'GEODASHBOARD_URL' ) ) {
            define( 'GEODASHBOARD_URL', plugin_dir_url( __FILE__ ) );
        }

    }

    public function includes() {
        require_once( 'includes/class-count.php' );
        require_once( 'includes/class-charts.php' );
        require_once( 'includes/class-pages.php' );
    }

    public function admin_menus() {
        $page = add_submenu_page(
            "index.php",
            "GD Dashboard",
            "GeoDirectory",
            'manage_options',
            'geodir-dashboard',
            array( self::$instance->pages, 'geodir_dashboard_index_page' )
        );
        // Load the css conditionally
        add_action( 'load-' . $page,  array( $this, 'load_admin_css'));
        // Load the js conditionally
        add_action( 'load-' . $page,  array( $this, 'load_admin_js'));

    }

    // This function is only called when our plugin's page loads!
    public function load_admin_css(){
        // Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css'));
    }

    // This function is only called when our plugin's page loads!
    public function load_admin_js(){
        // Unfortunately we can't just enqueue our scripts here - it's too early. So register against the proper action hook to do it
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_js'));
    }

    public function enqueue_admin_css(){
        wp_register_style( 'gd-dashboard-css', constant( 'GEODASHBOARD_URL' ) . 'assets/css/admin.css' );
        wp_enqueue_style( 'gd-dashboard-css' );
    }

    public function enqueue_admin_js(){
        wp_register_script( 'gd-dashboard-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js', array(), GEODASHBOARD_VERSION );
        wp_enqueue_script( 'gd-dashboard-js' );
    }

    public function display_reviews_by_post_type( $screen )
    {
        if ( $screen->id != 'edit-comments' )
            return;

        if( isset( $_GET['post_type'] ) )
            add_action( 'pre_get_comments', array( $this, 'gd_dash_display_reviews_query_vars'), 10, 1 );

    }

    public function gd_dash_display_reviews_query_vars( $clauses )
    {
        $post_type = $_GET['post_type'];
        $clauses->query_vars['post_type'] = $post_type;
    }

    public function generate_grid_html($args = array()) {
        $defaults = array(
            'link' => '',
            'icon' => "fa-th-list",
            'title' => "",
            'stats' => array()
        );
        $args = wp_parse_args( $args, $defaults );
        ?>
        <div class="gd-dash-box-wrap">
            <section class="gd-dash-box">
                <div class="gd-dash-box-inner">
                    <a class="gd-dash-box-icon" <?php if ($args['link']) { echo 'href="'.$args['link'].'"';} ?>><i class="fa <?php echo $args['icon']; ?>"></i></a>
                    <div class="gd-dash-box-title"><?php echo $args['title']; ?></div>
                    <div class="gd-dash-box-sep"></div>
                    <?php
                    foreach($args['stats'] as $key => $value) {
                        ?>
                        <h4 class="gd-dash-box-stat">
                            <strong><?php echo $value; ?></strong><small><?php echo $key; ?></small>
                        </h4>
                        <?php
                    }
                    ?>
                </div>
            </section>
        </div>
        <?php
    }

    public function breadcrumb() {
        echo '<ol class="dash-breadcrumb">';
        echo '<li class="dash-breadcrumb-item"><a href="'.admin_url('/index.php?page=geodir-dashboard').'">Dashboard</a></li>';
        if (isset($_GET['type'])) {

            $type = $_GET['type'];
            $title = ucfirst($type);
            if (isset($_GET['subtype'])) {
                $item = '<li class="dash-breadcrumb-item"><a href="'.add_query_arg('type', $type, admin_url('/index.php?page=geodir-dashboard')).'">'.$title.'</a></li>';
            } else {
                $item = '<li class="dash-breadcrumb-item active">'.$title.'</li>';
            }
            echo $item;
        }

        if (isset($_GET['subtype'])) {
            $subtype = $_GET['subtype'];
            $all_postypes = geodir_get_posttypes('array');
            $keys = array_keys($all_postypes);
            if (in_array($subtype, $keys)) {
                $subtype = $all_postypes[$subtype]['labels']['name'];
            }
            $title = ucfirst($subtype);
            echo '<li class="dash-breadcrumb-item active">'.$title.'</li>';
        }
        echo '</ol>';
    }

}

function GD_Dashboard_init() {
    return GD_Dashboard::instance();
}
GD_Dashboard_init();