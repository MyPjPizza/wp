<?php
/**
 * Plugin Name:     Popup Maker - Terms & Conditions Popups
 * Plugin URI:      https://wppopupmaker.com/extensions/terms-conditions-popups/
 * Description:     Quickly create popups requiring users to agree to your terms & conditions.
 * Version:         1.0.4
 * Author:          Daniel Iser
 * Author URI:      https://wppopupmaker.com/
 * Text Domain:     popup-maker-terms-conditions-popups
 *
 * @package         PopMake\TermsConditionsPopups
 * @author          Daniel Iser
 * @copyright       Copyright 2015 (c) Daniel Iser
 *
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Terms_Conditions_Popups' ) ) {

    /**
     * Main PopMake_Terms_Conditions_Popups class
     *
     * @since       1.0.0
     */
    class PopMake_Terms_Conditions_Popups {

        /**
         * @var         PopMake_Terms_Conditions_Popups $instance The one true PopMake_Terms_Conditions_Popups
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true PopMake_Terms_Conditions_Popups
         */
        public static function instance() {
            if( ! self::$instance ) {
                self::$instance = new PopMake_Terms_Conditions_Popups();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();

                self::$instance->site =  new PopMake_Terms_Conditions_Popups_Site();
                self::$instance->admin =  new PopMake_Terms_Conditions_Popups_Admin();

                self::$instance->hooks();
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
            define( 'POPMAKE_TERMSCONDITIONSPOPUPS_VER', '1.0.4' );

            // Plugin path
            define( 'POPMAKE_TERMSCONDITIONSPOPUPS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'POPMAKE_TERMSCONDITIONSPOPUPS_URL', plugin_dir_url( __FILE__ ) );
        }


        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/functions.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/class-site.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/class-admin.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/admin/popups/class-metaboxes.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/admin/popups/class-metabox-fields.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/functions.php';
            require_once POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'includes/shortcodes.php';
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
            //add_filter( 'popmake_settings_extensions', array( $this, 'settings' ), 1 );
            add_filter( 'popmake_template_paths', array( $this, 'template_path' ) );

            add_action( 'wp_enqueue_scripts', array( $this->site, 'scripts' ) );
            add_filter( 'popmake_get_the_popup_data_attr', array( $this->site, 'popup_data_attr' ), 10, 2 );
            add_filter( 'popmake_get_the_popup_classes', array( $this->site, 'popup_classes' ), 5, 2);
            add_filter( 'popmake_popup_is_loadable', array( $this->site, 'popup_is_loadable' ), 5, 2);

            add_filter( 'popmake_terms_conditions', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
            add_filter( 'popmake_terms_conditions', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
            add_filter( 'popmake_terms_conditions', 'wptexturize', 10 );
            add_filter( 'popmake_terms_conditions', 'convert_smilies', 10 );
            add_filter( 'popmake_terms_conditions', 'convert_chars', 10 );
            add_filter( 'popmake_terms_conditions', 'wpautop', 10 );
            add_filter( 'popmake_terms_conditions', 'shortcode_unautop', 10 );
            add_filter( 'popmake_terms_conditions', 'prepend_attachment', 10 );
            add_filter( 'popmake_terms_conditions', 'do_shortcode', 11 );
            add_filter( 'popmake_terms_conditions', 'capital_P_dangit', 11 );


            add_action( 'admin_enqueue_scripts', array( $this->admin, 'scripts' ), 100 );
            add_action( 'add_meta_boxes', array( $this->admin->metaboxes, 'register' ) );
            add_filter( 'popmake_popup_meta_fields', array( $this->admin->metaboxes, 'meta_fields' ) );
            add_filter( 'popmake_popup_meta_field_groups', array( $this->admin->metaboxes, 'meta_field_groups' ) );
            add_filter( 'popmake_popup_meta_field_group_terms_conditions', array( $this->admin->metaboxes, 'group_terms_conditions' ) );
            add_filter( 'popmake_popup_terms_conditions_defaults', array( $this->admin->metaboxes, 'terms_conditions_defaults' ) );
            add_filter( 'popmake_metabox_save_popup_terms_conditions_cookie_key', array( $this->admin->metaboxes, 'save_popup' ) );

            add_filter( 'popmake_tcp_checkbox_style_options', array( $this->admin->metaboxes, 'checkbox_style_options' ) );


            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'enabled' ), 10 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'checkbox_style' ), 20 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'agree_text' ), 30 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'force_agree' ), 40 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'force_read' ), 50 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'force_read_notice' ), 60 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_time' ), 70 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_path' ), 80 );
            add_action( 'popmake_popup_terms_conditions_meta_box_fields', array( $this->admin->metabox_fields, 'cookie_key' ), 90 );


            // Handle licensing
            if( class_exists( 'PopMake_License' ) ) {
                $license = new PopMake_License( __FILE__, 'Terms & Conditions Popups', POPMAKE_TERMSCONDITIONSPOPUPS_VER, 'Daniel Iser' );
            }
        }

        public function template_path( $file_paths ) {
            $key = max( array_keys( $file_paths ) ) + 1;
            $file_paths[ $key ] = POPMAKE_TERMSCONDITIONSPOPUPS_DIR . 'templates';
            return $file_paths;
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
            $lang_dir = POPMAKE_TERMSCONDITIONSPOPUPS_DIR . '/languages/';
            $lang_dir = apply_filters( 'popmake_tcp_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'popmake-popup-maker-terms-conditions-popups' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'popmake-popup-maker-terms-conditions-popups', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/popmake-popup-maker-terms-conditions-popups/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/popmake-popup-maker-terms-conditions-popups/ folder
                load_textdomain( 'popmake-popup-maker-terms-conditions-popups', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/popmake-popup-maker-terms-conditions-popups/languages/ folder
                load_textdomain( 'popmake-popup-maker-terms-conditions-popups', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'popmake-popup-maker-terms-conditions-popups', false, $lang_dir );
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
                    'id'    => 'popmake_tcp_settings',
                    'name'  => '<strong>' . __( 'Plugin Name Settings', 'popmake-popup-maker-terms-conditions-popups' ) . '</strong>',
                    'desc'  => __( 'Configure Plugin Name Settings', 'popmake-popup-maker-terms-conditions-popups' ),
                    'type'  => 'header',
                )
            );

            return array_merge( $settings, $new_settings );
        }
    }
} // End if class_exists check


function PopMake_Terms_Conditions_Popups() {
    return PopMake_Terms_Conditions_Popups::instance();
}


/**
 * The main function responsible for returning the one true PopMake_Terms_Conditions_Popups
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      PopMake_Terms_Conditions_Popups The one true PopMake_Terms_Conditions_Popups
 *
 */
function popmake_tcp_load() {
    if( ! class_exists( 'Popup_Maker' ) ) {
        if( ! class_exists( 'PopMake_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new PopMake_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
    } else {
        PopMake_Terms_Conditions_Popups::instance();
    }
}
add_action( 'plugins_loaded', 'popmake_tcp_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function popmake_tcp_activation() {
    /* Activation functions here */
}
register_activation_hook( __FILE__, 'popmake_tcp_activation' );
