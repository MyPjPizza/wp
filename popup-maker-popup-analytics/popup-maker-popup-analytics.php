<?php
/**
 * Plugin Name: Popup Maker - Popup Analytics
 * Plugin URI: https://wppopupmaker.com/extensions/popup-analytics/
 * Description: 
 * Author: WP Popup Maker
 * Version: 1.1.4
 * Author URI: https://wppopupmaker.com/
 * Text Domain: popup-maker-popup-analytics
 * 
 * @package     POPMAKE_POPUPANALYTICS
 * @category    Addon\Tracking
 * @author      WP Popup Maker
 * @copyright   Copyright (c) 2016, WP Popup Maker
 * @since       1.0
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics' ) ) {

    /**
     * Main PopMake_Popup_Analytics class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics {

        /**
         * @var         PopMake_Popup_Analytics $instance The one true PopMake_Popup_Analytics
         * @since       1.0.0
         */
        private static $instance;

        public $db;
        public $site;
        public $admin;
        public $conversions;
        public $legacy;
        public $upgrades;

        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true PopMake_Popup_Analytics
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new PopMake_Popup_Analytics();
                self::$instance->setup_constants();
                self::$instance->load_textdomain();
                self::$instance->includes();

                self::$instance->db = new POPMAKE_DB_Analytics();
                self::$instance->legacy = new PopMake_Popup_Analytics_Legacy();
                self::$instance->site = new PopMake_Popup_Analytics_Site();
                self::$instance->conversions = new PopMake_Popup_Analytics_Conversions();
                self::$instance->admin = new PopMake_Popup_Analytics_Admin();
                self::$instance->upgrades = new PopMake_Popup_Analytics_Upgrades();

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
            // Plugin File
            define('POPMAKE_POPUPANALYTICS_FILE', __FILE__);    

            // Plugin version
            define( 'POPMAKE_POPUPANALYTICS_VER', '1.1.4' );

            // Plugin path
            define( 'POPMAKE_POPUPANALYTICS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'POPMAKE_POPUPANALYTICS_URL', plugin_dir_url( __FILE__ ) );

            // Plugin nonce key
            define( 'POPMAKE_POPUPANALYTICS_NONCE', 'popmake_pa_nonce' );   
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
            if( ! class_exists( 'POPMAKE_DB' ) ) {
                require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-popmake-db.php';
            }
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-popmake-db-analytics.php';

            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-legacy.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-site.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-conversions.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/class-admin.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/admin/upgrades/class-upgrades.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/admin/functions.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/admin/popups/class-columns.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/admin/popups/class-metaboxes.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/admin/analytics/class-pages.php';

            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/analytic-functions.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/functions.php';
            require_once POPMAKE_POPUPANALYTICS_DIR . 'includes/ga-functions.php';

        }


        /**
         * Run action and filter hooks
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function hooks() {

            // Register settings
            add_filter( 'popmake_settings_extensions', array( $this, 'settings' ), 1 );
            add_filter( 'popmake_popup_analytics_defaults', array( $this, 'defaults' ) );


            add_action( 'init', array( $this->site, 'register_session' ) );
            add_action( 'wp_enqueue_scripts', array( $this->site, 'scripts' ) );
            add_filter( 'popmake_get_the_popup_data_attr', array( $this->site, 'popup_data_attr' ), 10, 2 );

            add_action( 'wp_ajax_popmake_pa', array( $this->site, 'ajax_listener' ) );
            add_action( 'wp_ajax_nopriv_popmake_pa', array( $this->site, 'ajax_listener' ) );

            // Conversion Handlers
            add_action( 'wpcf7_mail_sent', array( $this->conversions, 'wpcf7' ), 1 );
            add_action( 'ninja_forms_pre_process',  array( $this->conversions, 'ninja_forms' ) );
            add_action( 'gform_after_submission', array( $this->conversions, 'gform' ), 10, 2 );



            add_action( 'admin_menu', array( $this->admin, 'pages' ), 10 );
            add_action( 'admin_enqueue_scripts', array( $this->admin, 'scripts' ), 100 );
            add_filter( 'popmake_pa_table_args', array( $this->admin->analytics_pages, 'table_args' ), 0, 3 );
            add_filter( 'popmake_popup_columns', array( $this->admin->popup_columns, 'columns' ) );
            add_action( 'manage_posts_custom_column', array( $this->admin->popup_columns, 'render' ), 10, 2 );
            add_filter( 'manage_edit-popup_sortable_columns', array( $this->admin->popup_columns, 'sortables' ) );
            add_action( 'load-edit.php', array( $this->admin->popup_columns, 'load' ), 9999 );
            add_action( 'add_meta_boxes', array( $this->admin->metaboxes, 'register' ) );
            add_filter( 'popmake_cookie_trigger_options', array( $this->admin->metaboxes, 'cookie_trigger_options' ) );
            add_filter( 'popmake_pa_convert_on_options', array( $this->admin->metaboxes, 'convert_on_options' ) );
            add_filter( 'popmake_popup_meta_fields', array( $this->admin->metaboxes, 'meta_fields' ) );
            add_filter( 'popmake_popup_meta_field_groups', array( $this->admin->metaboxes, 'meta_field_groups' ) );
            add_filter( 'popmake_popup_meta_field_group_analytics', array( $this->admin->metaboxes, 'meta_field_group_analytics' ) );
            add_action( 'popmake_save_popup', array( $this->admin->metaboxes, 'save_popup' ), 10, 2 );
            add_action( 'popmake_popup_stats_meta_box_fields', array( $this->admin->metaboxes, 'stats_meta_box_fields' ), 10 );
            add_action( 'popmake_popup_analytics_meta_box_fields', array( $this->admin->metaboxes, 'event_meta_box_fields' ), 10);
            add_action( 'popmake_popup_conversions_meta_box_fields', array( $this->admin->metaboxes, 'conversions_meta_box_fields' ), 10 );

            if ( is_admin() ) {
                add_action( 'after_setup_theme', array( $this->admin, 'install_check' ) );
            }

            // Handle licensing
            if( class_exists( 'PopMake_License' ) ) {
                $license = new PopMake_License( __FILE__, 'Popup Analytics', POPMAKE_POPUPANALYTICS_VER, 'Daniel Iser' );
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
            $lang_dir = POPMAKE_POPUPANALYTICS_DIR . '/languages/';
            $lang_dir = apply_filters( 'popmake_pa_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'popup-maker-popup-analytics' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'popup-maker-popup-analytics', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/popup-maker-popup-analytics/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/popup-maker-plugin-name/ folder
                load_textdomain( 'popup-maker-popup-analytics', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/popup-maker-plugin-name/languages/ folder
                load_textdomain( 'popup-maker-popup-analytics', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'popup-maker-popup-analytics', false, $lang_dir );
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
                'popmake_pa_settings' => array(
                    'id'    => 'popmake_pa_settings',
                    'name'  => '<strong>' . __( 'Popup Analytics Settings', 'popup-maker-popup-analytics' ) . '</strong>',
                    'desc'  => __( 'Configure Popup Analytics Settings', 'popup-maker-popup-analytics' ),
                    'type'  => 'header',
                ),


                'popmake_pa_logged_in_tracking_disabled' => array(
                    'id' => 'popmake_pa_logged_in_tracking_disabled',
                    'name' => __( 'Disable Tracking for Logged In Users?', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Disables popup tracking for logged in admin users.', 'popup-maker-popup-analytics' ),
                    'type' => 'checkbox'
                ),
                'popmake_pa_logged_in_tracking_level' => array(
                    'id' => 'popmake_pa_logged_in_tracking_level',
                    'name' => __( 'Disable for which Roles?', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Select the user roles you don\'t want to track.', 'popup-maker-popup-analytics' ),
                    'type' => 'multicheck',
                    'options' => $this->user_role_options()
                ),


                'popmake_pa_ga_header' => array(
                    'id' => 'popmake_pa_ga_header',
                    'name' => '<strong>' . __( 'Google Analytics', 'popup-maker-popup-analytics' ) . '</strong>',
                    'desc' => '',
                    'type' => 'header'
                ),
                'popmake_pa_ga_enabled' => array(
                    'id' => 'popmake_pa_ga_enabled',
                    'name' => __( 'Enable Google Analytics Tracking?', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'For best results this requires you to already be using GA on your site.<br/><strong>Currently Only Works with Googles new Universal Analytics.</strong>', 'popup-maker-popup-analytics' ),
                    'type' => 'checkbox'
                ),
                'popmake_pa_ga_tid' => array(
                    'id' => 'popmake_pa_ga_tid',
                    'name' => __( 'Enter your GA Tracking ID.', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Should resemble <strong>UA-XXXXXXXX-X</strong>', 'popup-maker-popup-analytics' ),
                    'type' => 'text'
                ),


                'popmake_pa_ga_event_labels_header' => array(
                    'id' => 'popmake_pa_ga_event_labels_header',
                    'name' => '<strong>' . __( 'Default GA Event Labels', 'popup-maker-popup-analytics' ) . '</strong>',
                    'desc' => '',
                    'type' => 'header'
                ),
                'popmake_pa_ga_open_events' => array(
                    'id' => 'popmake_pa_ga_open_events',
                    'name' => __( 'Open', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Enter default open event event information.', 'popup-maker-popup-analytics' ),
                    'type' => 'gaeventlabel',
                    'std' => array(
                        'category' => __( 'Popup', 'popup-maker-popup-analytics' ),
                        'action' => __( 'Open', 'popup-maker-popup-analytics' ),
                        'label' => '[open_trigger]',
                        'value' => 0,
                    )
                ),
                'popmake_pa_ga_close_events' => array(
                    'id' => 'popmake_pa_ga_close_events',
                    'name' => __( 'Close', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Enter default close event event information.', 'popup-maker-popup-analytics' ),
                    'type' => 'gaeventlabel',
                    'std' => array(
                        'category' => __( 'Popup', 'popup-maker-popup-analytics' ),
                        'action' => __( 'Close', 'popup-maker-popup-analytics' ),
                        'label' => '[close_trigger]',
                        'value' => 0,
                    )
                ),
                'popmake_pa_ga_conversion_events' => array(
                    'id' => 'popmake_pa_ga_conversion_events',
                    'name' => __( 'Conversion', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'Enter default conversion event information.', 'popup-maker-popup-analytics' ),
                    'type' => 'gaeventlabel',
                    'std' => array(
                        'category' => __( 'Popup', 'popup-maker-popup-analytics' ),
                        'action' => __( 'Conversion', 'popup-maker-popup-analytics' ),
                        'label' => '[conversion_trigger]',
                        'value' => 10,
                    )
                ),


                'popmake_pa_ga_debug_header' => array(
                    'id' => 'popmake_pa_ga_debug_header',
                    'name' => '<strong>' . __( 'Debugging', 'popup-maker-popup-analytics' ) . '</strong>',
                    'desc' => '',
                    'type' => 'header'
                ),
                'popmake_pa_ga_debug' => array(
                    'id' => 'popmake_pa_ga_debug',
                    'name' => __( 'Enable Google Analytics Debugging?', 'popup-maker-popup-analytics' ),
                    'desc' => __( 'This enables emailed reports from google when an error occurs with the details.', 'popup-maker-popup-analytics' ),
                    'type' => 'checkbox'
                ),
                'popmake_pa_ga_debug_email' => array(
                    'id' => 'popmake_pa_ga_debug_email',
                    'name' => __( 'Debug Email Address', 'popup-maker-popup-analytics' ),
                    'desc' => '<br/>' . __( 'The email you want debug reports sent to.', 'popup-maker-popup-analytics' ),
                    'type' => 'text'
                ),

                'popmake_pa_break' => array(
                    'id' => 'popmake_pa_break',
                    'name' => '',
                    'desc' => '<hr/>',
                    'type' => 'section'
                ),
            );

            return array_merge( $settings, $new_settings );
        }

        public function user_role_options() {
            global $wp_roles;
            $options = array();
            foreach($wp_roles->roles as $role => $labels) {
                $options[$role] = $labels['name'];
            }
            return $options;
        }

        public function defaults( $defaults ) {
            return array_merge( $defaults, array(
                'open_event_override'       => NULL,
                'open_event_category'       => __( 'Popup', 'popup-maker-popup-analytics' ),
                'open_event_action'         => __( 'Open', 'popup-maker-popup-analytics' ),
                'open_event_label'          => '[open_trigger]',
                'open_event_value'          => 0,
                
                'close_event_override'      => NULL,
                'close_event_category'      => __( 'Popup', 'popup-maker-popup-analytics' ),
                'close_event_action'        => __( 'Close', 'popup-maker-popup-analytics' ),
                'close_event_label'         => '[close_trigger]',
                'close_event_value'         => 0,
                
                'conversion_event_override' => NULL,
                'conversion_event_category' => __( 'Popup', 'popup-maker-popup-analytics' ),
                'conversion_event_action'   => __( 'Conversion', 'popup-maker-popup-analytics' ),
                'conversion_event_label'    => '[conversion_trigger]',
                'conversion_event_value'    => 0,
            ));
        }

    }
} // End if class_exists check

function PopMake_Popup_Analytics() {
    return PopMake_Popup_Analytics::instance();
}


/**
 * The main function responsible for returning the one true PopMake_Popup_Analytics
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      PopMake_Popup_Analytics The one true PopMake_Popup_Analytics
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where your extension is activated but Popup Maker is not
 *              present.
 */
function popmake_pa_load() {
    if( ! class_exists( 'Popup_Maker' ) ) {
        if( ! class_exists( 'PopMake_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new PopMake_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
    } else {
        PopMake_Popup_Analytics();
    }
}
add_action( 'plugins_loaded', 'popmake_pa_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function popmake_pa_activation() {
    @PopMake_Popup_Analytics()->admin->install_check();
}
register_activation_hook( __FILE__, 'popmake_pa_activation' );
