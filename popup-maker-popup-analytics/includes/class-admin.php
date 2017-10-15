<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Admin' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Admin class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Admin {

        public $metaboxes;
        public $columns;
        public $analytics_pages;

        public function __construct() {
            $this->metaboxes = new PopMake_Popup_Analytics_Admin_Popup_Metaboxes();
            $this->popup_columns = new PopMake_Popup_Analytics_Admin_Popup_Columns();
            $this->analytics_pages = new PopMake_Popup_Analytics_Admin_Analytics_Pages();
        }



    	public function install_check() {
    		$current_db_version = get_option( PopMake_Popup_Analytics()->db->table_name . '_db_version' );

    		if( ! $current_db_version || version_compare( $current_db_version, PopMake_Popup_Analytics()->db->version ) == -1 ) {
				@PopMake_Popup_Analytics()->db->create_table();
    		}

            update_option( 'popmake_pa_version', POPMAKE_POPUPANALYTICS_VER );
    	}

        public function pages() {
            global $popmake_analytics_page;
            $popmake_analytics_page = add_submenu_page(
                'edit.php?post_type=popup',
                apply_filters( 'popmake_admin_submenu_analytics_page_title', __( 'Analytics', 'popup-maker' ) ),
                apply_filters( 'popmake_admin_submenu_analytics_menu_title', __( 'Analytics', 'popup-maker' ) ),
                apply_filters( 'popmake_admin_submenu_analytics_capability', 'manage_options' ),
                'analytics',
                apply_filters( 'popmake_admin_submenu_analytics_function', array( $this->analytics_pages, 'render' ) )
            );
        }

        /**
         * Load admin scripts
         *
         * @since       1.0.0
         * @global      array $popmake_settings_page The slug for the Popup Maker settings page
         * @global      string $post_type The type of post that we are editing
         * @return      void
         */
        public function scripts( $hook ) {
            // Use minified libraries if SCRIPT_DEBUG is turned off
            $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';


            if( popmake_is_admin_page() ) {
                wp_enqueue_script( 'popup-maker-popup-analytics-admin', POPMAKE_POPUPANALYTICS_URL . 'assets/js/admin' . $suffix . '.js',  array( 'popup-maker-admin' ), POPMAKE_POPUPANALYTICS_VER );
            }

            if( $hook == 'popup_page_analytics' ) {
                wp_enqueue_script( 'jquery-flot', POPMAKE_POPUPANALYTICS_URL . 'assets/js/jquery.flot.min.js',  array( 'jquery' ) );
                wp_enqueue_script( 'jquery-flot-time', POPMAKE_POPUPANALYTICS_URL . 'assets/js/jquery.flot.time.min.js',  array( 'jquery' ) );
                wp_enqueue_script( 'popup-maker-popup-analytics-stats', POPMAKE_POPUPANALYTICS_URL . 'assets/js/stats' . $suffix . '.js',  array( 'jquery-flot' ), POPMAKE_POPUPANALYTICS_VER );
            }
        }


    }
} // End if class_exists check