<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PopMake_Scroll_Triggered_Popups_Site' ) ) {

	/**
	 * Main PopMake_Scroll_Triggered_Popups_Site class
	 *
	 * @since       1.1.0
	 */
	class PopMake_Scroll_Triggered_Popups_Site {

		/**
		 * Add data attr
		 *
		 * @since       1.1.0
		 * @return      void
		 */
		public function popup_data_attr( $data_attr, $popup_id ) {
			if ( popmake_get_popup_scroll_triggered( $popup_id, 'enabled' ) ) {
				$data_attr['meta']['scroll_triggered'] = popmake_get_popup_scroll_triggered( $popup_id );
			}

			return $data_attr;
		}

		/**
		 * Add popup class
		 *
		 * @since       1.1.1
		 * @return      void
		 */
		public function popup_classes( $classes, $popup_id ) {
			if ( popmake_get_popup_scroll_triggered( $popup_id, 'enabled' ) ) {
				$classes[] = 'scroll-triggered';
			}

			return $classes;
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
			wp_register_script( 'popmake-scroll-triggered-popups-js', POPMAKE_SCROLLTRIGGEREDPOPUPS_URL . 'assets/js/scripts' . $suffix . '.js?defer', array( 'popup-maker-site' ), POPMAKE_SCROLLTRIGGEREDPOPUPS_VER, true );
		}

		public function enqueue_scripts( $scripts = array(), $popup_id = null ) {
			if ( ! is_null( $popup_id ) && popmake_get_popup_scroll_triggered( $popup_id, 'enabled' ) ) {
				$scripts['scroll-triggered'] = 'popmake-scroll-triggered-popups-js';
			}

			return $scripts;
		}


	}
} // End if class_exists check
