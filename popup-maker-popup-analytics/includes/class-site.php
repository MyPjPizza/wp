<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'PopMake_Popup_Analytics_Site' ) ) {

    /**
     * Main PopMake_Popup_Analytics_Site class
     *
     * @since       1.0.0
     */
    class PopMake_Popup_Analytics_Site {

		public function popup_data_attr( $data_attr, $popup_id ) {
			if ( popmake_get_popup_analytics( $popup_id, 'convert_on' ) ) {
				$data_attr['meta']['convert_on'] = popmake_get_popup_analytics( $popup_id, 'convert_on' );
			}
			return $data_attr;
		}

		public function register_session(){
		    if( ! session_id() ) {
		        session_start();
		    }
		}


		public function popmake_popup_search_get_the_popup_data_attr( $data_attr, $popup_id ) {
		}


		public function ajax_listener() {
			check_ajax_referer( POPMAKE_POPUPANALYTICS_NONCE, 'nonce' );

			$popup_id	= $_REQUEST['popup_id'];
			$type		= $_REQUEST['event_type'];
			$args		= array(
				'url'           => $_SERVER['HTTP_REFERER'],
				'trigger'       => ! empty( $_REQUEST['trigger'] ) ? $_REQUEST['trigger'] : '',
				'open_event_id' => ! empty( $_REQUEST['open_event_id'] ) ? $_REQUEST['open_event_id'] : 0,
			);

			$event_id	= popmake_pa_popup_analytic_event( $type, $popup_id, $args );

			$response	= array(
				'success'	=> $event_id > 0,
				'event_id'	=> $event_id,
				'new_nonce'	=> wp_create_nonce( POPMAKE_POPUPANALYTICS_NONCE ),
			);

			echo json_encode( $response );
			die();
		}


		/**
		 * Load frontend scripts
		 *
		 * @since       1.0.0
		 * @return      void
		 */
		function scripts( $hook ) {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_script( 'popmake-popup-analytics-js', POPMAKE_POPUPANALYTICS_URL . 'assets/js/scripts' . $suffix . '.js?defer', array( 'popup-maker-site' ), POPMAKE_POPUPANALYTICS_VER, true );
			wp_localize_script( 'popmake-popup-analytics-js', 'popmake_pa_nonce', wp_create_nonce( POPMAKE_POPUPANALYTICS_NONCE ) );
		}


    }
} // End if class_exists check
