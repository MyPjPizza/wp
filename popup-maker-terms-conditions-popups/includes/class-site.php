<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PopMake_Terms_Conditions_Popups_Site' ) ) {

    /**
     * Main PopMake_Terms_Conditions_Popups_Site class
     *
     * @since       1.1.0
     */
    class PopMake_Terms_Conditions_Popups_Site {

		public function popup_data_attr( $data_attr, $popup_id ) {
			if( popmake_get_popup_terms_conditions( $popup_id, 'enabled' ) ) {
				$data_attr['meta']['terms_conditions'] = popmake_get_popup_terms_conditions( $popup_id );
			}
			return $data_attr;
		}

		public function popup_classes( $classes, $popup_id ) {
			if( popmake_get_popup_terms_conditions( $popup_id, 'enabled' ) ) {
				$classes[] = 'terms-conditions';
			}
			return $classes;
		}

		public function popup_is_loadable( $is_loadable, $popup_id ) {
			if( popmake_get_popup_terms_conditions( $popup_id, 'enabled' ) ) {
				$cookie_name = 'popmake-terms-conditions-' . $popup_id . "-" . popmake_get_popup_terms_conditions( $popup_id, 'cookie_key' );
				if( ! empty( $_COOKIE[ $cookie_name ] ) ) {
					$is_loadable = false;			
				}
			}
			return $is_loadable;
		}


		/**
		 * Load frontend scripts
		 *
		 * @since       1.1.0
		 * @return      void
		 */
		public function scripts() {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_script( 'popmake-terms-conditions-popups-js', POPMAKE_TERMSCONDITIONSPOPUPS_URL . 'assets/js/scripts' . $suffix . '.js?defer', array( 'popup-maker-site' ), POPMAKE_TERMSCONDITIONSPOPUPS_VER, true );
			wp_enqueue_style( 'popmake-terms-conditions-popups-css', POPMAKE_TERMSCONDITIONSPOPUPS_URL . 'assets/css/styles' . $suffix . '.css', array( 'popup-maker-site' ), POPMAKE_TERMSCONDITIONSPOPUPS_VER );
		}

    }
} // End if class_exists check
