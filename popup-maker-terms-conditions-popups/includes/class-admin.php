<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Terms_Conditions_Popups_Admin' ) ) {

    /**
     * Main PopMake_Terms_Conditions_Popups_Admin class
     *
     * @since       1.1.0
     */
    class PopMake_Terms_Conditions_Popups_Admin {

        public $metaboxes;
        public $metabox_fields;

        public function __construct() {
            $this->metaboxes = new PopMake_Terms_Conditions_Popups_Admin_Popup_Metaboxes();
            $this->metabox_fields = new PopMake_Terms_Conditions_Popups_Admin_Popup_Metabox_Fields();
        }

        public function install_check() {
            $version = get_option( 'popmake_tcp_version' );
            update_option( 'popmake_tcp_version', POPMAKE_TERMSCONDITIONSPOPUPS_VER );
        }


        /**
		 * Load frontend scripts
		 *
		 * @since       1.1.0
		 * @return      void
		 */
		public function scripts( $hook ) {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			if( popmake_is_admin_page() ) {
				wp_enqueue_script( 'popmake-terms-conditions-popups-admin-js', POPMAKE_TERMSCONDITIONSPOPUPS_URL . 'assets/js/admin' . $suffix . '.js', array( 'jquery', 'popup-maker-admin' ), POPMAKE_TERMSCONDITIONSPOPUPS_VER );
			}
		}

    }
} // End if class_exists check
