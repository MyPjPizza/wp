<?php
/**
 * Plugin Name:     Popup Maker - MailChimp Integration
 * Plugin URI:      https://wppopupmaker.com
 * Description:     Adds MailChimp Integration To Popup Maker
 * Version:         1.1.0
 * Author:          Frank Corso
 * Author URI:      https://wppopupmaker.com
 * Text Domain:     pum-mailchimp-integration
 *
 * @package         PopMake\Pum_MailChimp_Integration
 * @author          Frank Corso
 * @copyright       Copyright (c) 2015
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PUM_MailChimp_Integration' ) ) {

    /**
     * Main Pum_MailChimp_Integration class
     *
     * @since       1.0.0
     */
    class PUM_MailChimp_Integration {

        /**
         * @var         Pum_MailChimp_Integration $instance The one true Pum_MailChimp_Integration
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true Pum_MailChimp_Integration
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new PUM_MailChimp_Integration();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
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
            define( 'PUM_MAILCHIMP_INTEGRATION_VER', '1.1.0' );

            // Plugin path
            define( 'PUM_MAILCHIMP_INTEGRATION_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'PUM_MAILCHIMP_INTEGRATION_URL', plugin_dir_url( __FILE__ ) );
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
            require_once PUM_MAILCHIMP_INTEGRATION_DIR . 'includes/scripts.php';
            require_once PUM_MAILCHIMP_INTEGRATION_DIR . 'includes/functions.php';

            require_once PUM_MAILCHIMP_INTEGRATION_DIR . 'includes/pum-newsletters/class-pum-newsletter.php';
            require_once PUM_MAILCHIMP_INTEGRATION_DIR . 'includes/class-pum-newsletter-mailchimp.php';
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

            // Handle licensing
            if( class_exists( 'PopMake_License' ) ) {
                $license = new PopMake_License( __FILE__, 'MailChimp Integration', PUM_MAILCHIMP_INTEGRATION_VER, 'Frank Corso' );
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
            $lang_dir = PUM_MAILCHIMP_INTEGRATION_DIR . '/languages/';
            $lang_dir = apply_filters( 'pum_mailchimp_integration_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'pum-mailchimp-integration' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'pum-mailchimp-integration', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/pum-mailchimp-integration/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/pum-mailchimp-integration/ folder
                load_textdomain( 'pum-mailchimp-integration', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/pum-mailchimp-integration/languages/ folder
                load_textdomain( 'pum-mailchimp-integration', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'pum-mailchimp-integration', false, $lang_dir );
            }
        }


        /**
         * Add settings
         *
         * @access      public
         * @since       1.0.0
         * @param       array $settings The existing Popup Maker settings array
         * @return      array The modified Popup Maker settings array
         * @todo        Needs to create settings to allow user to enter their API Key
         */
        public function settings( $settings ) {
            $new_settings = array(
                array(
                    'id'    => 'mc_int_settings',
                    'name'  => '<strong>' . __( 'MailChimp Integration Settings', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Configure MailChimp Integration Settings', 'pum-mailchimp-integration' ),
                    'type'  => 'header',
                ),
                array(
                    'id'    => 'mc_int_api_key',
                    'name'  => '<strong>' . __( 'MailChimp API Key', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Your MailChimp API Key which can be found on the Account page in MailChimp.', 'pum-mailchimp-integration' ),
                    'type'  => 'text',
                ),
                array(
                    'id'    => 'mc_double_opt_in',
                    'name'  => '<strong>' . __( 'Enable Double Opt-In', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Enable the double opt-in to send users confirmation emails upon signing up', 'pum-mailchimp-integration' ),
                    'type'  => 'select',
                    'std'   => 'enable',
                    'options' => array(
                      'enable' => 'Enable',
                      'disable' => 'Disable'
                    )
                ),
                array(
                    'id'    => 'mc_int_success_message',
                    'name'  => '<strong>' . __( 'Success Message', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Message to show user when successfuly subscribed.', 'pum-mailchimp-integration' ),
                    'type'  => 'text',
                ),
                array(
                    'id'    => 'mc_int_invalid_email_message',
                    'name'  => '<strong>' . __( 'Invalid Email Message', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Message to show user when an invalid email is entered.', 'pum-mailchimp-integration' ),
                    'type'  => 'text',
                ),
                array(
                    'id'    => 'mc_int_error_message',
                    'name'  => '<strong>' . __( 'Error Message', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Message to show user when an errored occurred.', 'pum-mailchimp-integration' ),
                    'type'  => 'text',
                ),
                array(
                    'id'    => 'mc_int_already_subscribed_message',
                    'name'  => '<strong>' . __( 'Already Subscribed Message', 'pum-mailchimp-integration' ) . '</strong>',
                    'desc'  => __( 'Message to show user who is already subscribed.', 'pum-mailchimp-integration' ),
                    'type'  => 'text',
                )
            );

            return array_merge( $settings, $new_settings );
        }
    }
} // End if class_exists check


/**
 * The main function responsible for returning the one true Pum_MailChimp_Integration
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      Pum_MailChimp_Integration The one true Pum_MailChimp_Integration
 */
function pum_mailchimp_integration_load() {
    if( ! class_exists( 'Popup_Maker' ) ) {
        if( ! class_exists( 'PopMake_Extension_Activation' ) ) {
            require_once 'includes/class.extension-activation.php';
        }

        $activation = new PopMake_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
        $activation = $activation->run();
    } else {
        PUM_MailChimp_Integration::instance();
    }
}
add_action( 'plugins_loaded', 'pum_mailchimp_integration_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function pum_mailchimp_integration_activation() {
    /* Activation functions here */
}
register_activation_hook( __FILE__, 'pum_mailchimp_integration_activation' );
