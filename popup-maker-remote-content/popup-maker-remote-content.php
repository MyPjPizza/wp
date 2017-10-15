<?php
/**
 * Plugin Name:     Popup Maker - Remote Content
 * Plugin URI:      https://wppopupmaker.com/extensions/remote-content/
 * Description:     The remote content extension allows you to easily fill your popup with a remote content source.
 * Version:         1.0.0
 * Author:          Daniel Iser
 * Author URI:      https://danieliser.com
 * Text Domain:     popup-maker-remote-content
 *
 * @package         PopMake\RemoteContent
 * @author          Daniel Iser
 * @copyright       Copyright (c) 2015
 *
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Remote_Content' ) ) {

    /**
     * Main PopMake_Remote_Content class
     *
     * @since       1.0.0
     */
    class PopMake_Remote_Content {

        /**
         * @var         PopMake_Remote_Content $instance The one true PopMake_Remote_Content
         * @since       1.0.0
         */
        private static $instance;

        /**
         * @var         string $texdomain Stores the plugins text-domain
         * @since       1.0.0
         */
        public $textdomain = 'popmake-remote-content';

        private $admin_controller;
	    private $site_controller;
	    private $ajax_controller;

        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true PopMake_Remote_Content
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new PopMake_Remote_Content();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();

                self::$instance->admin_controller = new PopMake_Remote_Content_Admin();
	            self::$instance->site_controller = new PopMake_Remote_Content_Site();
	            self::$instance->ajax_controller = new PopMake_Remote_Content_Ajax();

                self::$instance->hooks();
                self::$instance->register_fields();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {
            // Plugin version
            define( 'POPMAKE_REMOTECONTENT_VER', '1.0.0' );

            // Plugin path
            define( 'POPMAKE_REMOTECONTENT_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'POPMAKE_REMOTECONTENT_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            // Include scripts
            require_once POPMAKE_REMOTECONTENT_DIR . 'includes/functions.php';

	        require_once POPMAKE_REMOTECONTENT_DIR . 'includes/class.ajax.php';
	        require_once POPMAKE_REMOTECONTENT_DIR . 'includes/class.site.php';

            require_once POPMAKE_REMOTECONTENT_DIR . 'includes/class.admin.php';
            require_once POPMAKE_REMOTECONTENT_DIR . 'includes/admin/popups/class.metaboxes.php';
        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         *
         */
        private function hooks() {
            // Register settings
            add_filter( 'popmake_settings_extensions', array( $this, 'settings' ), 1 );

            // Handle licensing
            if( class_exists( 'PopMake_License' ) ) {
                new PopMake_License( __FILE__, 'Remote Content', POPMAKE_REMOTECONTENT_VER, 'Daniel Iser' );
            }
        }


        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = POPMAKE_REMOTECONTENT_DIR . '/languages/';
            $lang_dir = apply_filters( 'popmake_remote_content_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), popmake_rc()->textdomain );
            $mofile = sprintf( '%1$s-%2$s.mo', 'popmake-plugin-name', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/popmake-plugin-name/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/popmake-plugin-name/ folder
                load_textdomain( 'popmake-plugin-name', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/popmake-plugin-name/languages/ folder
                load_textdomain( 'popmake-plugin-name', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'popmake-plugin-name', false, $lang_dir );
            }
        }

        public function register_fields() {

            if ( version_compare( POPMAKE_VERSION, '1.3', '>=' ) ) {

                Popmake_Popup_Fields::instance()->register_section(
                    'remote_content',
                    __( 'Remote Content', popmake_rc()->textdomain )
                );

                Popmake_Popup_Fields::instance()->add_fields( 'remote_content', array(
                    'enabled'        => array(
                        'label'       => __( 'Enable Remote Content', popmake_rc()->textdomain ),
                        'description' => __( 'This enables Remote Content for this popup.', popmake_rc()->textdomain ),
                        'type'        => 'checkbox',
                        'std'         => false,
                        'priority'    => 0,
                    ),
                    'type'         => array(
                        'class' => 'remote-content-enabled',
                        'label'       => __( 'Type', popmake_rc()->textdomain ),
                        'description' => __( 'Choose the type of remote content use.', popmake_rc()->textdomain ),
                        'type'        => 'select',
                        'std'         => 'loadselector',
                        'priority'    => 5,
                        'options'     => apply_filters( 'popmake_remote_content_type_options', array(
                            __( 'Load From URL', popmake_rc()->textdomain ) => 'loadselector',
                            __( 'AJAX', popmake_rc()->textdomain ) => 'ajax',
                        ) )
                    ),
                    'function_name'    => array(
                        'class' => 'remote-content-enabled only-ajax',
                        'label'       => __( 'Function Name', popmake_rc()->textdomain ),
                        'placeholder' => __( 'my_custom_function', popmake_rc()->textdomain ),
                        'description' => __( 'A function that will be called and render results.', popmake_rc()->textdomain ),
                        'std'         => '',
                        'priority'    => 10,
                    ),
                    'css_selector'    => array(
                        'class' => 'remote-content-enabled only-loadselector',
                        'label'       => __( 'CSS Selector', popmake_rc()->textdomain ),
                        'placeholder' => __( '#main .content', popmake_rc()->textdomain ),
                        'description' => __( 'Enter the CSS id or selector that we will will load from links.', popmake_rc()->textdomain ),
                        'std'         => '',
                        'priority'    => 15,
                    ),
                    'loading_icon'    => array(
                        'class' => 'remote-content-enabled',
                        'label'       => __( 'Loading Icon', popmake_rc()->textdomain ),
                        'type'        => 'select',
                        'description' => __( 'Choose a loding icon style.', popmake_rc()->textdomain ),
                        'std'         => 'circle-4',
                        'options'     => array(
                            __( 'Lines: Growing', popmake_rc()->textdomain ) => 'lines-1',
                            __( 'Dots: Growing', popmake_rc()->textdomain ) => 'dots-1',
                            __( 'Circles: Streaking', popmake_rc()->textdomain ) => 'circles-1',
                            __( 'Circles: Chasing Tail', popmake_rc()->textdomain ) => 'circles-2',
                            __( 'Circles: Dots Chasing', popmake_rc()->textdomain ) => 'circles-3',
                            __( 'Circles: Dots Fading', popmake_rc()->textdomain ) => 'circles-4',
                            __( 'Circles: Dots Streaking', popmake_rc()->textdomain ) => 'circles-5',
                            __( 'Circles: Racetrack', popmake_rc()->textdomain ) => 'circles-6',
                        ),
                        'priority'    => 20,
                    ),
                ) );

            }
        }

        /**
         * Add settings
         *
         * @access      public
         * @since       1.0.0
         * @param       array $settings The existing Popup Maker settings array
         * @return      array The modified Popup Maker settings array
         */
        public function settings( $settings ) {
            $new_settings = array(
                array(
                    'id'    => 'popmake_remote_content_settings',
                    'name'  => '<strong>' . __( 'Remote Content', popmake_rc()->textdomain ) . '</strong>',
                    'desc'  => __( 'Configure Remote Content Settings', popmake_rc()->textdomain ),
                    'type'  => 'header',
                )
            );

            return array_merge( $settings, $new_settings );
        }
    }
} // End if class_exists check


function popmake_rc() {
    return PopMake_Remote_Content::instance();
}


/**
 * The main function responsible for returning the one true PopMake_Remote_Content
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      PopMake_Remote_Content The one true PopMake_Remote_Content
 *
 */
function popmake_remote_content_load() {
    if( ! class_exists( 'Popup_Maker' ) ) {
        if( ! class_exists( 'PopMake_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new PopMake_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation->run();
    } else {
        popmake_rc();
    }
}
add_action( 'plugins_loaded', 'popmake_remote_content_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function popmake_remote_content_activation() {
    /* Activation functions here */
}
register_activation_hook( __FILE__, 'popmake_remote_content_activation' );
